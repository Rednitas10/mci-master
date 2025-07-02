<?php
if (empty($review)) {
    echo "No such review!";
} else {
    $mci = $review['mci'];

    echo "MI: $mci";

    if ($mci == Review::NOT || $mci == Review::RCA) {
        $ci = $review['ci'] ? 'Yes' : 'No';
        echo "{$separator}Cardiac intervention: $ci";

        if ($ci == "Yes") {
            $ciType = $review['ci_type'];
            echo "{$separator}CI Type: $ciType";
        }
    } else {
        $criteria = '';

        if ($review['abnormal_ce_values_flag']) {
            $criteria .= 'Abnormal cardiac enzyme values (' . 
                         $review['ce_criteria'] . '); ';
        }

        if ($review['chest_pain_flag']) {
            $criteria .= 'Chest pain; ';
        }

        if ($review['ecg_changes_flag']) {
            $criteria .= 'ECG changes; ';
        }

        if ($review['lvm_by_imaging_flag']) {
            $criteria .= 'Loss of viable myocardium or regional wall abnormalities by imaging; ';
        }

        echo "{$separator}Criteria: $criteria";

        $type = $review['type'];
        echo "{$separator}Primary/Secondary: $type";
    
        if ($type == Review::SECONDARY) {
            $secondaryCause = $review['secondary_cause'];
            echo "{$separator}Secondary cause: $secondaryCause";
    
            if ($secondaryCause == Review::OTHER) {
                echo "{$separator}Other cause: {$review['other_cause']}";
            }
        }

        $ecgType = $review['ecg_type'];
        echo "{$separator}ECG Type: $ecgType";

        $pfp = $review['false_positive_flag'] ? 'Yes' : 'No';
        echo "{$separator}Possible false positive? $pfp";

        if ($pfp == 'Yes') {
            $fpr = $review['false_positive_reason'];
            echo "{$separator}False positive reason: $fpr";
            
            if ($fpr == Review::OTHER) {
                echo "{$separator}Other cause: {$review['false_positive_other_cause']}";
            }
        }

        $ctu = $review['current_tobacco_use_flag'] ? 'Yes' : 'No';
        $ptu = $review['past_tobacco_use_flag'] ? 'Yes' : 'No';
        $cu = $review['cocaine_use_flag'] ? 'Yes' : 'No';
        $fh = $review['family_history_flag'] ? 'Yes' : 'No';

        echo "{$separator}Current tobacco use? $ctu";
        echo "{$separator}Past tobacco use? $ptu";
        echo "{$separator}Past or current cocaine or crack use? $cu";
        echo "{$separator}Family history of coronary artery disease? $fh";
    }

    $cardiacCath = $review['cardiac_cath'] ? 'Yes' : 'No';
    echo "{$separator}Cardiac Cath: $cardiacCath";
    
}
?>
