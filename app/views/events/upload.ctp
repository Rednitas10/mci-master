<script type="text/javascript">
  function showAndHide() {
    var $noPacketReason = $("select#noPacketReasonSelect").val();
    var $priorEventDateKnown = $("input#PriorEventDateRadio1").is(":checked");

    $("div#noPacketReason").show();
    $("div#twoAttempts").hide();
    $("div#priorEventDateKnown").hide();
    $("div#priorEventDate").hide();
    $("div#priorEventOnsite").hide();
    $("div#otherCause").hide();
    $("div#submit").hide();

    if ($noPacketReason == 'Ascertainment diagnosis error') {
      $("div#submit").show();
    } else if ($noPacketReason == 'Other') {
      $("div#otherCause").show();
      $("div#submit").show();
    } else if ($noPacketReason == 'Outside hospital') {
      $("div#twoAttempts").show();
      $("div#submit").show();
    } else if ($noPacketReason == 
               'Ascertainment diagnosis referred to a prior event') 
    {
      $("div#priorEventDateKnown").show();
      $("div#priorEventOnsite").show();
      $("div#submit").show();

      if ($priorEventDateKnown) {
        $("div#priorEventDate").show();
      }
    }
  }

  $(document).ready(function(){
    showAndHide();

    $("select").change(function () {
      showAndHide();
    });

    $("radio").click(function () {
      showAndHide();
    });

    $("input").change(function () {
      showAndHide();
    });
  });

</script>

<?php
    $eventId = $event['Event']['id'];
	$criteria = '<span class="criteria">';

	if (empty($event['Criteria'])) {
		$criteria .= 'None';
	} else {
		$firstCriterion = true;

		foreach ($event['Criteria'] as $criterion) {
			$criteria .= $firstCriterion ? '' : ', ';
			$criteria .= $criterion['name'] . ' = ' .
							$criterion['value'];
			$firstCriterion = false;
		}
	}

	$criteria .= '</span>';
?>

<div class="boxright" id="infobox" style="width: 360px; font-size: .95em">
	<h3>Review packets should contain:</h3>
    <ol>
        <li>Physician's notes closest to potential Event date</li>
        <li>Outpatient cardiology consultations</li>
        <li>In-patient cardiology notes or consults</li>
        <li>Baseline ECG</li>
        <li>First 2 ECGs after admission or in-hospital event</li>
        <li>Related procedure and diagnostic test results</li>
        <li>Related laboratory evidence</li>
        <li>Please redact the personal identifiers including name, birthday, and hospital number</li>
    </ol>
    <div>Full instructions: 
    <?php
    $prefix = (strpos(Router::url('/', true), 'cnics') != true) ? 
        'NA-ACCORD' : 'CNICS';

    $prefix2 = (strpos(Router::url('/', true), 'mci') != true) ?
        'VTE' : 'MI';

    echo $html->link('.doc', '/files/' . $prefix . ' MI' .Event::UPLOAD_INSTRUCTIONS);
    echo " | ";
    echo $html->link('.pdf', '/files/' . $prefix . ' MI' .Event::UPLOAD_INSTRUCTIONS_PDF, array('target'=>'_blank'));
    ?>
    </div>
</div>

<h1>Packet for                                        
<?php 
    if (PROJECT_NAME == 'MI') {
        echo "MI " .($eventId + 1000);
    } else {
        echo "Event " . $eventId;
    }
?>
</h1>

<p>
<?php
  echo "Patient ID: " . $event['Patient']['site_patient_id'] . "<br />Date: " . $event['Event']['event_date'] . "<br />Criteria: " . $criteria;
?>
</p>

<h2 class="indent1" style="padding-top: 6px">If packet is available:</h2>

<div class="indent2">
<?php
if ($alreadyUploaded) {
?>
<p>
<em>A packet has already been uploaded for this event on 
<?php echo $event['Event']['upload_date']; ?></em>
</p>
<?php
}
?>
<?php
    echo $form->create(null, array('controller' => 'events',
                                   'action' => 'upload',
                                   'enctype' => 'multipart/form-data'));
    // 100 Mbytes (roughly)
    echo '<input type="hidden" name="MAX_FILE_SIZE" value="100000000"/>';

    echo $form->hidden(AppController::CAKEID_KEY,
                       array(
                           'value' => $session->read(AppController::ID_KEY)
                      ));
    echo $form->hidden('Event.id', array('value' => $eventId));

    echo '<label for = \"chartFile\">Choose a file to upload: </label>';
    echo $form->file('Event.chartFile');

    if ($alreadyUploaded) {
?>
<table style="margin: 10px 0">
<tr>
  <th>Confirm re-upload:</th>
  <td>
  <?php
    echo $form->input('Event.confirmUpload',
                      array('type' => 'checkbox', 'label' => ' Confirm re-upload'));
    }
  ?>
  </td>
</tr>
</table>

<?php
    echo $form->submit('Upload');
    echo $form->end();
?>
</div>

<h2 class="indent1" style="padding-top: 6px">If no packet is available:</h2>

<div class="indent2">

<?php
    echo $form->create(null, array('controller' => 'events',
                                   'action' => 'markNoPacket'));
    echo $form->hidden('Event.id', array('value' => $eventId));
    echo $form->hidden(AppController::CAKEID_KEY,
                       array(
                           'value' => $session->read(AppController::ID_KEY)
                      ));
?>

<div id="noPacketAvailableForm">
<div style="margin-bottom: 12px" id="noPacketReason">Please document why there is no event packet:
  <?php 
    echo $form->select('Event.no_packet_reason', $noPacketReasons, null, array('id' => 'noPacketReasonSelect'));
  ?>
</div>
<div id="twoAttempts">
<div>The protocol requests that 2 attempts are made to obtain medical records for all events that occurred at outside hospitals if the location 
is known. Have you made 2 attempts to request the medical records from the outside hospital?</div>
<div style="margin-top: 8px" class="indent3">
<?php 
      echo $form->radio('Event.two_attempts_flag', 
                      array(1 => ' Yes, 2 attempts were made&nbsp;&nbsp;&nbsp;&nbsp;', 0 => ' No '), 
                      array('legend' => false, 'id' => 'twoAttemptsRadio'));
?>
</div>
</div>
<div id="priorEventDateKnown">
  <div>Is approximate month/year of the prior event known?
  <?php 
    echo $form->radio('Event.prior_event_date_known', 
                      array(1 => ' Yes&nbsp;&nbsp;&nbsp;&nbsp;', 0 => ' No '),  
                      array('legend' => false, 'id' => 'priorEventDateRadio'));
  ?>
  </div>
</div>
<div style="padding-top: 12px" id="priorEventDate">
  <div>Please enter the month/year of the prior event. Leave a field blank if it is unknown:</div>
  <div style="padding-top: 6px" class="indent3">
  <?php 
    echo 'Month: ' . 
         $form->month('Event.priorDateMonth', null, 
                      array('monthNames' => false));
    echo $form->input("Event.priorDateYear", 
                                 array('label' => ' &nbsp;Year: ', 
                                       'size' => '4',
                                       'div' => false));
  ?>
  </div>
</div>
<div style="padding-top: 12px" id="priorEventOnsite">
  <div>Did event occur while in care at your site?
  <?php 
    echo $form->radio('Event.prior_event_onsite_flag', 
                      array(1 => ' Yes&nbsp;&nbsp;&nbsp;&nbsp;', 0 => ' No '), 
                      array('legend' => false));
  ?>
  </div>
</div>
<div id="otherCause">
  <?php echo "<label for = \"Event.other_cause\">Other cause:</label>";?>
  <?php
    echo $form->input("Event.other_cause", array('label' => ''));
  ?>
</div>
<div id='submit'>
  <?php
    echo $form->submit('Submit');
  ?>
</div>

<?php
    echo $form->end();
?>

</div>
 
