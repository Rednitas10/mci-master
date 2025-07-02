<?php
if (empty($review)) {
    $csv->addField('');
    $csv->addField('');
    $csv->addField('');
    $csv->addField('');
    $csv->addField('');
    $csv->addField('');
    $csv->addField('');
    $csv->addField('');
    $csv->addField('');
    $csv->addField('');
    $csv->addField('');
    $csv->addField('');
    $csv->addField('');
    $csv->addField('');
    $csv->addField('');
    $csv->addField('');
    $csv->addField('');
} else {
    $mci = $review['mci'];
    $csv->addField($mci);

    if ($mci == Review::NOT || $mci == Review::RCA) {
        $csv->addField('');
        $csv->addField('');
        $csv->addField('');
        $csv->addField('');
        $csv->addField('');
        $csv->addField($review['ci'] ? 'Yes' : 'No');
        $csv->addField('');
        $csv->addField('');
        $csv->addField('');
        $csv->addField('');
        $csv->addField('');
        $csv->addField('');
        $csv->addField('');
        $csv->addField('');
        $csv->addField('');
        $csv->addField('');
    } else {
        $csv->addField($review['abnormal_ce_values_flag'] ? 'Yes' : 'No');

        if ($review['abnormal_ce_values_flag']) {
            $csv->addField($review['ce_criteria']);
        } else {
            $csv->addField('');
        }

        $csv->addField($review['chest_pain_flag'] ? 'Yes' : 'No');
        $csv->addField($review['ecg_changes_flag'] ? 'Yes' : 'No');
        $csv->addField($review['lvm_by_imaging_flag'] ? 'Yes' : 'No');
        $csv->addField('');   // ci
        $type = $review['type'];
        $csv->addField($type);

        if ($type == Review::SECONDARY) {
            $secondaryCause = $review['secondary_cause'];
            $csv->addField($secondaryCause);

            if ($secondaryCause == Review::OTHER) {
                $csv->addField($review['other_cause']);
            } else {
                $csv->addField('');   
            }
        } else {
            $csv->addField('');   
            $csv->addField('');   
        }

        $csv->addField($review['false_positive_flag'] ? 'Yes' : 'No');

        if ($review['false_positive_flag']) {
            $fpr = $review['false_positive_reason'];
            $csv->addField($fpr);

            if ($fpr == Review::OTHER) {
                $csv->addField($review['false_positive_other_cause']);
            } else {
                $csv->addField('');   
            }
        } else {
            $csv->addField('');   
            $csv->addField('');
        }

        $csv->addField($review['current_tobacco_use_flag'] ? 'Yes' : 'No');
        $csv->addField($review['past_tobacco_use_flag'] ? 'Yes' : 'No');
        $csv->addField($review['cocaine_use_flag'] ? 'Yes' : 'No');
        $csv->addField($review['family_history_flag'] ? 'Yes' : 'No');
    }
}
?>
