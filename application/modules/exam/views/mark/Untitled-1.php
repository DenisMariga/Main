<tbody id="fn_mark"> 
<?php if (isset($exams) && !empty($exams)) { ?>
<?php foreach($exams as $ex){ ?>                       
<?php
 $exam_subjects = get_subject_Flist($school_id, $academic_year_id, $ex->id, $class_id, $section_id, $student_id);
                                        $count = 1;
                                        $activity_out_of_ten_total = 0;
                                        $total_score_sum = 0;
                                        $identifier_sum = 0;
if (isset($exam_subjects) && !empty($exam_subjects)) {
?>
<?php foreach ($exam_subjects as $obj) { ?>
<?php $exam = get_exam_result($school_id, $ex->id, $student_id, $academic_year_id, $class_id, $section_id); ?>
<?php if($exam->name == ''){ continue; } ?> 
<?php $activity_out_of_ten_total += $obj->activity_out_of_ten; ?>
<?php
$project_score = '';
$this->db->select('project_score');
$this->db->from('project_marks');
$this->db->where('subject_id', $obj->subject_id);
$this->db->where('student_id', $student_id);
$query = $this->db->get();
if($query->num_rows() > 0){
    $project_score = $query->row()->project_score;
}
// Get teacher's name and initials from the subjects table
$teacher_initials = '';
//  $this->db->select('SUBSTRING(teachers.name, 1, 2) AS initials');
//  $this->db->select("SUBSTRING(teachers.name,1,1) AS initials", FALSE);
$this->db->select("REPLACE(CONCAT(SUBSTR(teachers.name,1,1), SUBSTR(SUBSTR(teachers.name,LOCATE(' ',teachers.name)+1),1,1)), ' ', '') AS initials", FALSE);

$this->db->from('subjects');
$this->db->join('teachers', 'teachers.id = subjects.teacher_id');
$this->db->where('subjects.id', $obj->subject_id);
$query = $this->db->get();
if($query->num_rows() > 0){
    $teacher_initials = $query->row()->initials;
}

?>
<tr>
<td><?php echo $count++;  ?></td>
<td><?php echo ucfirst($obj->subject); ?></td>
<td><?php 
    $total_score = 0;
    if ($project_score !=0 && $project_score !== '') {
        $total_score = $obj->activity_out_of_ten + $project_score;
    } else {
        $total_score = $obj->activity_out_of_ten * 2;
    }
    echo $total_score;       
    $total_score_sum += $total_score;
?>
</td> 
<td>
<?php 
    $identifier = round($total_score / 20 * 3);
    echo $identifier;
    $identifier_sum += $identifier;
?>
</td>
<td>
<?php 
$descriptor = '';
switch($identifier) {
    case 1:
        $descriptor = 'Basic';
        break;
    case 2:
        $descriptor = 'Moderate';
        break;
    case 3:
        $descriptor = 'Outstanding';
        break;
}
echo $descriptor;
?>
</td>
<td>
<!-- tr -->
<?php echo $teacher_initials; ?>
</td>

</tr>
<?php } ?>
<tr>
<td colspan="2" align="left"><?php echo $this->lang->line('Averages'); ?>:</td>
                    
<td><?php echo round($total_score_sum/count($exam_subjects), 2); ?></td>
<td><?php echo round($identifier_sum/count($exam_subjects), 2); ?></td>
<td colspan="4"></td>
</tr>


<?php }else{ ?>
                
                <?php } ?>   
            <?php } ?>
<?php }else{ ?>
    <tr>
        <td colspan="17" align="center"><?php echo $this->lang->line('no_data_found'); ?></td>
    </tr>    
<?php } ?>            
</tbody>