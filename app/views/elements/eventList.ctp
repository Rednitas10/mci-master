<?php
if ($showPatientInfo) {
?>
<div class="boxright" id="infobox" style="width: 400px; font-size: .95em">
	<h3>Review packets should contain:</h3>
    <ol style="margin-bottom: 0.5em">
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
    echo $html->link('.doc', '/files/' . $prefix . ' MI' . Event::UPLOAD_INSTRUCTIONS);
    echo " | ";
    echo $html->link('.pdf', '/files/' . $prefix . ' MI' . Event::UPLOAD_INSTRUCTIONS_PDF, array('target'=>'_blank'));
    ?>
    </div>
</div>
<?php
} else {
?>
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
<?php
}
?>

<?php
echo "<h1>$heading</h1>";

if (empty($events)) {
    echo "<p>No events to $verb</p>";
} else {
	echo "<p>$instructions</p>";
?>

<h3>Quick Search</h3>
<p>Filter the list of events by searching on any field:</p>

<?php
if ($showPatientInfo) {
?>
		<div style="font-style: italic; margin-left: 18px">Filter events: <input type="text" name="search" value="" id="id_search" placeholder="Search" autofocus /> <span class="loading">Loading...</span></div>
<?php
} else {
?>
		<div style="font-style: italic; margin-left: 18px">Filter events: <input type="text" name="search" value="" id="id_search_review" placeholder="Search" autofocus /> <span class="loading">Loading...</span></div>
<?php
}
?>        
<br />        

<?php
	echo "<h3>$eventlistinfo</h3>";
?>

<table class="table_list">
<thead>
<tr>
	<th>ID</th>
<?php
if ($showPatientInfo) {
?>
	<th>Patient ID</th>
<?php
}
?>
	<th>Date</th>
<?php
if ($showPatientInfo) {
?>
	<th>Criteria</th>
<?php
}
?>
 </tr>
</thead>
<?php
if ($showPatientInfo) {
?>
		<tbody id="uploader">
        <tr id="noresults">
            <td colspan="4">Nothing matches your search. Please try again.</td>
        </tr>
<?php
} else {
?>
		<tbody id="reviewer">
        <tr id="noresultsreviewer">
            <td colspan="4">Nothing matches your search. Please try again.</td>
        </tr>
<?php
}
?>
<?php
    foreach ($events as $index => $event) {
        $eventId = $event['Event']['id'];
        $miNumber = 1000 + $eventId;

        // show site and patientId if appropriate
        if ($showPatientInfo) {
            $patientInfo = ', ' . $event['Patient']['site'] . ', ' .  
                           $event['Patient']['site_patient_id'];
 
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
        } else {
            $patientInfo = '';
            $criteria = '';
        }
        
        /* allow $verb to change per event by adding on a suffix (if the
           array of suffixes exists */
        if (!empty($verbSuffixes)) {
            $thisVerb = $verb . $verbSuffixes[$index];
        } else {
            $thisVerb = $verb;
        }
		
       	echo '<tr><td>' .
            $html->link("Event {$miNumber}",
                        "/events/$thisVerb/$eventId") .
            '</td>';
			if ($showPatientInfo) {
            	echo '<td>' . $event['Patient']['site_patient_id'] . '</td>';
			}
            echo '<td>' . $event['Event']['event_date'] . '</td>';
			if ($showPatientInfo) {
				echo '<td>' . $criteria . '</td>';
			}
            '</tr>';
    }
?>
</tbody>
</table>

<?php
}
?>

<!-- Begin script to make whole tr clickable -->
<script type="text/javascript">
$(document).ready(function() {
    $('tr').click(function() {
        var href = $(this).find("a").attr("href");
        if(href) {
            window.location = href;
        }
    });
});
</script>
<!-- End script to make whole tr clickable -->
