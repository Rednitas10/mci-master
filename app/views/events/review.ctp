<script type="text/javascript">
  function showAndHide() {
    var $mci = $("select#mciSelect").val();
    var $ciYes = $("input#CiRadio1:radio:checked").val();
    var $ciNo = $("input#CiRadio0:radio:checked").val();
    var $ciType = $("select#ciTypeSelect").val();
    var $type = $("select#typeSelect").val();
    var $secondaryCause = $("select#secondaryCauseSelect").val();
    var $abnormalCeValues = $("input#abnormalCeValuesFlag").is(":checked");
    var $chestPain = $("input#chestPainFlag").is(":checked");
    var $ecgChanges = $("input#ecgChangesFlag").is(":checked");
    var $lvmByImaging = $("input#lvmByImagingFlag").is(":checked");
    var $ceCriteria = $("select#ceCriteriaSelect").val();
    var $currentSmoking = $("input#CurrentSmoking0:radio:checked").val();
    var $falsePositive = $("input#falsePositiveFlag").is(":checked");
    var $falsePositiveReason = $("select#falsePositiveSelect").val();

    $("tr#mci").show();
    $("tr#criteria").hide();
    $("div#ceCriteria").hide();
    $("tr#type").hide();
    $("tr#ci").hide();
    $("tr#ciType").hide();
    $("tr#secondaryCause").hide();
    $("tr#otherCause").hide();
    $("tr#falsePositiveBar").hide();
    $("tr#ecgType").hide();
    $("tr#falsePositive").hide();
    $("tr#falsePositiveReason").hide();
    $("tr#falsePositiveOtherCause").hide();
    $("tr.question").hide();
    $("tr#pastSmoking").hide();
    $("tr.cardiacCath").hide();
    $("tr#submit").hide();

    if ($mci == 'No' || $mci == 'No [resuscitated cardiac arrest]') {
      $("tr#ci").show();

      if ($ciYes) {
        $("tr#ciType").show();
      
        if ($ciType!= '') {
          $("tr.cardiacCath").show();
          $("tr#submit").show();
        }
      } else if ($ciNo) {
        $("tr.cardiacCath").show();
        $("tr#submit").show();
      }
    } else if ($mci != '') {
      $("tr#criteria").show();

      if ($abnormalCeValues) {
        $("div#ceCriteria").show();
      }

      if ((!$abnormalCeValues || $ceCriteria != '') &&
          ($abnormalCeValues || $chestPain || $ecgChanges || $lvmByImaging))
      {
        $("tr#type").show();
  
        if ($type == 'Secondary') {
          $("tr#secondaryCause").show();
  
          if ($secondaryCause != '') {
            if ($secondaryCause == 'Other') {
              $("tr#otherCause").show();
            }
          }
        }

        if ($type == 'Primary' || 
            ($type == 'Secondary' && $secondaryCause != '')) 
        {
          $("tr#falsePositiveBar").show();
          $("tr#ecgType").show();
          $("tr#falsePositive").show();

          if ($falsePositive) {
            $("tr#falsePositiveReason").show();

            if ($falsePositiveReason != '') {
              if ($falsePositiveReason == 'Other') {
                $("tr#falsePositiveOtherCause").show();
              }
            }
          }

          $("tr.question").show();

          if ($currentSmoking == '0') {
            $("tr#pastSmoking").show();
          }

          $("tr.cardiacCath").show();

          $("tr#submit").show();
        }
      }
    }
  }

  $(document).ready(function(){
    showAndHide();

    $("select").change(function () {
      showAndHide();
    });

    $("input[type=checkbox]").click(function () {
      showAndHide();
    });

    $("input").change(function () {
      showAndHide();
    });
  });

</script>

<div class="boxright" id="infobox" style="width: 300px; font-size: .95em">
	<h3>Review Instructions:</h3>
    <br />
    <div>View as: 
    <?php
    echo $html->link('.doc', '/files/' . $prefix . Event::REVIEW_INSTRUCTIONS);
    echo " | ";
    echo $html->link('.pdf', '/files/' . $prefix . Event::REVIEW_INSTRUCTIONS_PDF, array('target'=>'_blank'));
    ?>
    </div>
</div>

<h1>Review event: <?php echo PROJECT_NAME == 'MI' ? 'MI' . (1000 + $eventId) : 
                                                    $eventId; ?></h1>
                             
<p>
<?php
  echo "Date: " . $event['Event']['event_date'];
?>
</p>

<?php
    echo $form->create(null, array('controller' => 'events',
                                   'action' => 'review' . $reviewerNumber));
    echo $form->hidden('Event.id', array('value' => $eventId));
    echo $form->hidden(AppController::CAKEID_KEY,
                       array(
                           'value' => $session->read(AppController::ID_KEY)
                      ));
?>

<div class="indent1">

    <h2>Step 1: Review Charts</h2>
    
    <p>Review the packet for this event:</p>
    <ul>
        <li><?php
        $anchor = PROJECT_NAME == 'MI' ? 
            "Download charts for MI" . (1000 + $eventId) :
            "Download charts for Event" . $eventId;
        echo $html->link($anchor, '/events/download/' .$eventId );
        ?></li>
    </ul>
    
    <h2>Step 2: Enter Decision</h2>
    <br />
    <?php
        echo $form->create(null, array('controller' => 'events',
                                       'action' => 'review' . $reviewerNumber));
        echo $form->hidden('Event.id', array('value' => $eventId));
        echo $form->hidden(AppController::CAKEID_KEY,
                           array(
                               'value' => $session->read(AppController::ID_KEY)
                          ));
    ?>
    
    <table id='reviewForm'>
<tr id='mci'>
  <th>Was the event a Myocardial Infarction?</th>
  <td>
  <?php 
    echo $form->select('Review.mci', $mcis, null, array('id' => 'mciSelect'));
  ?>
  </td>
</tr>
<tr id='criteria'>
  <th>
    Please identify all criteria that indicated possible or definite MI.  
    Each patient will likely have at least 2.
  </th>

  <td>
    <br/>

    <?php 
      echo $form->input('Review.abnormal_ce_values_flag',
                      array('type' => 'checkbox', 'label' => '', 
                            'id' => 'abnormalCeValuesFlag', 'div' => false));
    ?>
    Abnormal cardiac enzyme values  

    <div id='ceCriteria'>
      <br/>
      Select which cardiac enzyme criteria were appropriate for this 
      patient<br/>

      <?php 
        echo $form->select('Review.ce_criteria', $ceCriterias, null, 
                           array('id' => 'ceCriteriaSelect'));
      ?>
    </div>

    <br/>
    <?php 
      echo $form->input('Review.chest_pain_flag',
                      array('type' => 'checkbox', 'label' => '', 
                            'id' => 'chestPainFlag', 'div' => false));
    ?>
    Chest pain

    <br/>

    <?php 
      echo $form->input('Review.ecg_changes_flag',
                      array('type' => 'checkbox', 'label' => '', 
                            'id' => 'ecgChangesFlag', 'div' => false));
    ?>
    ECG changes

    <br/>

    <?php 
      echo $form->input('Review.lvm_by_imaging_flag',
                      array('type' => 'checkbox', 'label' => '', 
                            'id' => 'lvmByImagingFlag', 'div' => false));
    ?>
    Loss of viable myocardium or regional wall abnormalities by imaging
  </td>
</tr>
<tr id='ci'>
  <th>Did the patient have a cardiac intervention (e.g. CABG, PTCA, stent)?</th>
  <td>
  <?php 
    echo $form->radio('Review.ci', array(1 => 'Yes&nbsp;&nbsp;', 0 => 'No'), 
                      array('legend' => false, 'id' => 'ciRadio'));
  ?>
  </td>
</tr>
<tr id='ciType'>
  <th>Type of CI?</th>
  <td>
  <?php 
    echo $form->select('Review.ci_type', $ciTypes, null,
                       array('id' => 'ciTypeSelect'));
  ?>
  </td>
</tr>
<tr id='type'>
  <th>Was the myocardial infarction Primary or Secondary?</th>
  <td>
  <?php 
    echo $form->select('Review.type', $types, null,
                       array('id' => 'typeSelect'));
  ?>
  </td>
</tr>
<tr id='secondaryCause'>
  <th>If Secondary, what was the cause?</th>
  <td>
  <?php 
    echo $form->select('Review.secondary_cause', $secondaryCauses, null,
                       array('id' => 'secondaryCauseSelect'));
  ?>
  </td>
</tr>
<tr id='otherCause'>
  <th><?php echo "<label for = \"Review.other_cause\">Other cause</label>";?></th>
  <td>
  <?php
    echo $form->input("Review.other_cause", array('label' => '', 
                                                  'id' => 'otherCauseInput'));
  ?>
  </td>
</tr>
<tr id='falsePositiveBar'>
  <td colspan="2"><hr/></td>
</tr>
<tr id='ecgType'>
  <th>
    ECG based type
  </th>
  <td>
    <?php 
      echo $form->select('Review.ecg_type', $ecgTypes, null,
                       array('id' => 'ecgTypeSelect'));
    ?>
  </td>
</tr>
<tr id='falsePositive'>
  <th>
    Meets criteria for an MI but has a credible reason to be potentially a false positive
  </th>
  <td>
    <?php 
      echo $form->input('Review.false_positive_flag',
                      array('type' => 'checkbox', 'label' => '', 
                            'id' => 'falsePositiveFlag', 'div' => false));
    ?>
  </td>
</tr>
<tr id='falsePositiveReason'>
  <th>Reason for the potential false positive result</th>
  <td>
  <?php 
    echo $form->select('Review.false_positive_reason', $falsePositiveReasons,
                       null, array('id' => 'falsePositiveSelect'));
  ?>
  </td>
</tr>
<tr id='falsePositiveOtherCause'>
  <th><?php echo "<label for = \"Review.false_positive_other_cause\">Other cause</label>";?></th>
  <td>
  <?php
    echo $form->input("Review.false_positive_other_cause", 
                      array('label' => '', 
                            'id' => 'falsePositiveOtherCauseInput'));
  ?>
  </td>
</tr>
<tr class='question'>
  <td colspan="2"><hr/></td>
</tr>
<tr class='question'>
  <th>Is there any mention of current tobacco use?</th>
  <td>
  <?php 
    echo $form->radio('Review.current_tobacco_use_flag', 
                      array(1 => 'Yes&nbsp;&nbsp;', 0 => 'No'), 
                      array('legend' => false, 'id' => 'currentSmoking'));
  ?>
  </td>
</tr>
<tr id='pastSmoking'>
  <th>Is there any mention of past tobacco use?</th>
  <td>
  <?php 
    echo $form->radio('Review.past_tobacco_use_flag', 
                      array(1 => 'Yes&nbsp;&nbsp;', 0 => 'No'), 
                      array('legend' => false));
  ?>
  </td>
</tr>
<tr class='question'>
  <th>Is there any mention of past or current cocaine or crack use?</th>
  <td>
  <?php 
    echo $form->radio('Review.cocaine_use_flag', 
                      array(1 => 'Yes&nbsp;&nbsp;', 0 => 'No'), 
                      array('legend' => false));
  ?>
  </td>
</tr>
<tr class='question'>
  <th>Is there any mention of a family history of coronary artery disease?</th>
  <td>
  <?php 
    echo $form->radio('Review.family_history_flag', 
                      array(1 => 'Yes&nbsp;&nbsp;', 0 => 'No'), 
                      array('legend' => false));
  ?>
  </td>
</tr>
<tr class='cardiacCath'>
  <td colspan="2"><hr/></td>
</tr>
<tr class='cardiacCath'>
  <th>Did the patient undergo a cardiac cath?</th>
  <td>
  <?php
    echo $form->radio('Review.cardiac_cath', array(1 => 'Yes&nbsp;&nbsp;', 0 => 'No'),
                      array('legend' => false, 'id' => 'ccRadio'));
  ?>
  </td>
</tr>
<tr id='submit'>
  <td colspan="2">
  <?php
    echo $form->submit('Submit');
  ?>
  </td>
</tr>
</table>

</div>

<?php
    echo $form->end();
?>
