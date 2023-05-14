<?php
$subject_counts = array();

// iterate through the table rows
foreach ($subjects as $obj) {
    $subject = $obj->subject;

    // check if this is the first time we've seen this subject
    if (!isset($subject_counts[$subject])) {
        $subject_counts[$subject] = array();
    }

    // add the student name to the list for this subject
    $subject_counts[$subject][] = $obj->name;
}

// output the results
foreach ($subject_counts as $subject => $names) {
    $count = count($names);
    $names_str = implode(' and ', $names);

    // check if the condition is true
    if ($names_str == 'C3 and D2') {
        echo "Subject: $subject, Count: $count, Names: B<br>";
    } else {
        echo "Subject: $subject, Count: $count, Names: $names_str<br>";
    }
}
?>