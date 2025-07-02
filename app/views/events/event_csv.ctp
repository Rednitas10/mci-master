<?php
    // headings
    $csv->addField('MI');
    $csv->addField('Patient ID');
    $csv->addField('Patient Site');
    $csv->addField('Site Patient ID');
    $csv->addField('Event Date');
    $csv->addField('Status');
    $csv->addField('Creator');
    $csv->addField('Criteria: MI Dx');
    $csv->addField('Criteria: CKMB_Q');
    $csv->addField('Criteria: CKMB_M');
    $csv->addField('Criteria: CKMB');
    $csv->addField('Criteria: Troponin');
    $csv->addField('Criteria: Other');
    $csv->addField('Add Date');
    $csv->addField('Uploader');
    $csv->addField('Upload Date');
    $csv->addField('Marker (no packet)');
    $csv->addField('No Packet Reason');
    $csv->addField('Two Attempts?');
    $csv->addField('Prior Event Date');
    $csv->addField('Prior Event Onsite?');
    $csv->addField('Other Cause');
    $csv->addField('Mark No Packet Date');
    $csv->addField('Scrubber');
    $csv->addField('Scrub Date');
    $csv->addField('Screener');
    $csv->addField('Screen Date');
    $csv->addField('Rescrub Message');
    $csv->addField('Reject Message');
    $csv->addField('Assigner');
    $csv->addField('Assign Date');
    $csv->addField('Sender');
    $csv->addField('Send Date');
    $csv->addField('Reviewer 1');
    $csv->addField('Review 1 MI');
    $csv->addField('Review 1 Abnormal CE Values?');
    $csv->addField('Review 1 CE Criteria');
    $csv->addField('Review 1 Chest Pain?');
    $csv->addField('Review 1 ECG Changes?');
    $csv->addField('Review 1 LVM by Imaging?');
    $csv->addField('Review 1 Clinical Intervention?');
    $csv->addField('Review 1 Type');
    $csv->addField('Review 1 Secondary Cause');
    $csv->addField('Review 1 Other Cause');
    $csv->addField('Review 1 False Positive?');
    $csv->addField('Review 1 False Positive Reason');
    $csv->addField('Review 1 False Positive Other Cause');
    $csv->addField('Review 1 Current Tobacco Use?');
    $csv->addField('Review 1 Past Tobacco Use?');
    $csv->addField('Review 1 Cocaine Use?');
    $csv->addField('Review 1 Family History?');
    $csv->addField('Review 1 Date');
    $csv->addField('Reviewer 2');
    $csv->addField('Review 2 MI');
    $csv->addField('Review 2 Abnormal CE Values?');
    $csv->addField('Review 2 CE Criteria');
    $csv->addField('Review 2 Chest Pain?');
    $csv->addField('Review 2 ECG Changes?');
    $csv->addField('Review 2 LVM by Imaging?');
    $csv->addField('Review 2 Clinical Intervention?');
    $csv->addField('Review 2 Type');
    $csv->addField('Review 2 Secondary Cause');
    $csv->addField('Review 2 Other Cause');
    $csv->addField('Review 2 False Positive?');
    $csv->addField('Review 2 False Positive Reason');
    $csv->addField('Review 2 False Positive Other Cause');
    $csv->addField('Review 2 Current Tobacco Use?');
    $csv->addField('Review 2 Past Tobacco Use?');
    $csv->addField('Review 2 Cocaine Use?');
    $csv->addField('Review 2 Family History?');
    $csv->addField('Review 2 Date');
    $csv->addField('3rd Review Assigner');
    $csv->addField('3rd Review Assign Date');
    $csv->addField('Reviewer 3');
    $csv->addField('Review 3 MI');
    $csv->addField('Review 3 Abnormal CE Values?');
    $csv->addField('Review 3 CE Criteria');
    $csv->addField('Review 3 Chest Pain?');
    $csv->addField('Review 3 ECG Changes?');
    $csv->addField('Review 3 LVM by Imaging?');
    $csv->addField('Review 3 Clinical Intervention?');
    $csv->addField('Review 3 Type');
    $csv->addField('Review 3 Secondary Cause');
    $csv->addField('Review 3 Other Cause');
    $csv->addField('Review 3 False Positive?');
    $csv->addField('Review 3 False Positive Reason');
    $csv->addField('Review 3 False Positive Other Cause');
    $csv->addField('Review 3 Current Tobacco Use?');
    $csv->addField('Review 3 Past Tobacco Use?');
    $csv->addField('Review 3 Cocaine Use?');
    $csv->addField('Review 3 Family History?');
    $csv->addField('Review 3 Date');
    $csv->addField('Overall Outcome');
    $csv->addField('Overall Primary vs. Secondary');
    $csv->addField('Overall False Positive Event?');
    $csv->addField('Overall Secondary Cause');
    $csv->addField('Overall Secondary Cause Other');
    $csv->addField('Overall False Positive Cause');
    $csv->addField('Overall Cardiac Intervention?');
    $csv->endRow();

    foreach ($events as $event) {
        $csv->addField($event['Event']['id'] + 1000);
        $csv->addField($event['Patient']['id']);
        $csv->addField($event['Patient']['site']);
        $csv->addField($event['Patient']['site_patient_id']);
        //$csv->addField('"' . $event['Patient']['site_patient_id'] . '"');
        $csv->addField($event['Event']['event_date']);
        $csv->addField($event['Event']['status']);
        $csv->addField($this->element('actor', 
            array('user' => $event['Creator'])));

        $criterias = array('mi dx' => '', 'ckmb_q' => '', 'ckmb_m' => '',
                           'ckmb' => '', 'troponin' => '', 'other' => '');
        $criterias['other'] = '';

        foreach ($event['Criteria'] as $criteria) {
            $c = strtolower($criteria['name']);

            if ($c == 'diagnosis' || $c == 'mi_dx' || $c == 'dx') {
                $c = 'mi dx';
            } else if ($c == 'troponin t' || $c == 'troponin i' || 
                       $c == 'trop_i' || $c == 'trop_t' || 
                       $c == 'troponin i (tni)' || $c == 'troponin t (tnt)') 
            {
                $c = 'troponin';
            } else if ($c == 'creatine kinase mb quotient') {
                $c = 'ckmb_q';
            } else if ($c == 'creatine kinase mb mass') {
                $c = 'ckmb_m';
            } else if ($c != 'mi dx' && $c != 'ckmb_q' && $c != 'ckmb_m' &&
                       $c != 'ckmb' && $c != 'troponin') 
            {
                $c = 'other';
                /* 'other' values get concatenated.  The rest should only 
                    appear once */
                $criteria['value'] = $criterias['other'] . $criteria['name'] . 
                                     ':' .  $criteria['value'] . ';';
            }

            $criterias[$c] = $criteria['value'];
        }

        $csv->addField($criterias['mi dx']);
        $csv->addField($criterias['ckmb_q']);
        $csv->addField($criterias['ckmb_m']);
        $csv->addField($criterias['ckmb']);
        $csv->addField($criterias['troponin']);
        $csv->addField($criterias['other']);
        $csv->addField($event['Event']['add_date']);
        $csv->addField($this->element('actor', 
            array('user' => $event['Uploader'])));
        $csv->addField($event['Event']['upload_date']);
        $csv->addField($this->element('actor', 
            array('user' => $event['Marker'])));

        $noPacketReason = $event['Event']['no_packet_reason'];
        $csv->addField($noPacketReason);

        if ($noPacketReason == Event::OUTSIDE_HOSPITAL) {
            $csv->addField($event['Event']['two_attempts_flag'] ? 
                           'Yes' : 'No');
        } else {
            $csv->addField('');
        }

        if ($noPacketReason == Event::ASCERTAINMENT_PRIOR_EVENT) {
            $priorDate = $event['Event']['prior_event_date'];
            $csv->addField(empty($priorDate) ? 'unknown' : $priorDate);
            $csv->addField($event['Event']['prior_event_onsite_flag'] ? 
                           'Yes' : 'No');
        } else {
            $csv->addField('');
            $csv->addField('');
        }

        $csv->addField($event['Event']['other_cause']);

        $csv->addField($event['Event']['markNoPacket_date']);
        $csv->addField($this->element('actor', 
            array('user' => $event['Scrubber'])));
        $csv->addField($event['Event']['scrub_date']);
        $csv->addField($this->element('actor', 
            array('user' => $event['Screener'])));
        $csv->addField($event['Event']['screen_date']);
        $csv->addField($event['Event']['rescrub_message']);
        $csv->addField($event['Event']['reject_message']);
        $csv->addField($this->element('actor', 
            array('user' => $event['Assigner'])));
        $csv->addField($event['Event']['assign_date']);
        $csv->addField($this->element('actor', 
            array('user' => $event['Sender'])));
        $csv->addField($event['Event']['send_date']);
        $csv->addField($this->element('actor', 
            array('user' => $event['Reviewer1'])));
        $this->element('reviewcsv', array('review' => $event['Review1']));

        $csv->addField($event['Event']['review1_date']);
        $csv->addField($this->element('actor', 
            array('user' => $event['Reviewer2'])));
        $this->element('reviewcsv', array('review' => $event['Review2']));
        $csv->addField($event['Event']['review2_date']);
        $csv->addField($this->element('actor', 
            array('user' => $event['Assigner3rd'])));
        $csv->addField($event['Event']['assign3rd_date']);
        $csv->addField($this->element('actor', 
            array('user' => $event['Reviewer3'])));
        $this->element('reviewcsv', array('review' => $event['Review3']));
        $csv->addField($event['Event']['review3_date']);

        if (empty($event['EventDerivedData'])) {
            $csv->addField('');
            $csv->addField('');
            $csv->addField('');
            $csv->addField('');
            $csv->addField('');
            $csv->addField('');
        } else {
            $eed = $event['EventDerivedData'];
            $csv->addField($eed['outcome']);
            $csv->addField($eed['primary_secondary']);

            if ($eed['false_positive_event'] === null) {
                $csv->addField('');
            } else {
                $csv->addField($eed['false_positive_event'] ? 'Yes' : 'No');
            }

            $csv->addField($eed['secondary_cause']);
            $csv->addField($eed['secondary_cause_other']);
            $csv->addField($eed['false_positive_reason']);

            if ($eed['ci'] === null) {
                $csv->addField('');
            } else {
                $csv->addField($eed['ci'] ? 'Yes' : 'No');
            }
        }

        $csv->endRow();
    }

    $datetime = str_replace(' ', '_', date('Y-m-d'));

    if (!defined('CAKEPHP_UNIT_TEST_EXECUTION')) {
        echo $csv->render("event.$datetime.csv");
    } else {
        echo $csv->render(false);      // for testing, just output as page
    }
?>
