<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gradefourresult_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_subject_list($school_id, $exam_id, $class_id, $section_id, $student_id, $academic_year_id) {
        $this->db->select('S.id, S.name AS subject, FLOOR(AVG(G.point)) AS average_point, (SELECT name FROM grades WHERE point <= AVG(G.point) ORDER BY point DESC LIMIT 1) AS grade_name');
        $this->db->from('grade_four_marks AS M');
        $this->db->join('subjects AS S', 'S.id = M.subject_id');
        $this->db->join('grades AS G', 'G.id = M.grade_id');
        $this->db->where('M.school_id', $school_id);
        $this->db->where('M.exam_id', $exam_id);
        $this->db->where('M.class_id', $class_id);
        $this->db->where('M.section_id', $section_id);
        $this->db->where('M.student_id', $student_id);
        $this->db->where('M.academic_year_id', $academic_year_id);
        $this->db->group_by('S.id, S.name');
        $this->db->having('average_point >', 0);
        $this->db->order_by('average_point ASC');
        $this->db->limit(8);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_division($school_id, $exam_id, $class_id, $section_id, $student_id, $academic_year_id) {
        $english_passed = $this->db->get_where('grade_four_marks', array('school_id' => $school_id, 'exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id, 'student_id' => $student_id, 'academic_year_id' => $academic_year_id, 'subject_id' => 1))->row();
        $humanity_passed = $this->db->get_where('grade_four_marks', array('school_id' => $school_id, 'exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id, 'student_id' => $student_id, 'academic_year_id' => $academic_year_id, 'group' => 'humanity', 'grade_id >=' => 7))->result();
        $math_passed = $this->db->get_where('grade_four_marks', array('school_id' => $school_id, 'exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id, 'student_id' => $student_id, 'academic_year_id' => $academic_year_id, 'subject_id' => 2, 'grade_id >=' => 7))->row();
        $science_passed = $this->db->get_where('grade_four_marks', array('school_id' => $school_id, 'exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id, 'student_id' => $student_id, 'academic_year_id' => $academic_year_id, 'group' => 'science', 'grade_id >=' => 7))->row();
        $credit_subjects = $this->db->get_where('grade_four_marks', array('school_id' => $school_id, 'exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id, 'student_id' => $student_id, 'academic_year_id' => $academic_year_id, 'grade_id >=' => 3, 'grade_id <=' => 6))->num_rows();
        $pass_subjects = $this->db->get_where('grade_four_marks', array('school_id' => $school_id, 'exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id, 'student_id' => $student_id, 'academic_year_id' => $academic_year_id, 'grade_id >=' => 7, 'grade_id <=' => 8))->num_rows();
        $credit_sum = $this->db->select('SUM(point) as sum')->get_where('grade_four_marks', array('school_id' => $school_id, 'exam_id' => $exam_id, 'class_id' => $class_id, 'section_id' => $section_id, 'student_id' => $student_id, 'academic_year_id' => $academic_year_id, 'grade_id >=' => 3, 'grade_id <=' => 6))->row()->sum;
        $english_pass = !empty($english_passed) ? true : false;
        $humanity_pass = count($humanity_passed) > 0 ? true : false;
        $math_pass = !empty($math_passed) ? true : false;
        $science_pass = !$science_subject || $science_grade_point >= 7;

        // Determine the number of credit subjects
        $credit_subjects = count($credit_list);
        
        // Calculate the sum of credit points
        $credit_sum = array_reduce($credit_list, function($sum, $subject) {
        return $sum + $subject->average_point;
        }, 0);
        
        // Determine the number of passed subjects
        $pass_subjects = count($pass_list);
        
        // Check the division criteria
        if ($pass_subjects >= 8 && $credit_subjects >= 7 && $credit_sum <= 32 && $english_passed && $humanity_passed && $math_passed && $science_pass) {
        $division = 'Division 1';
        } elseif ($pass_subjects >= 8 && $credit_subjects >= 6 && $credit_sum <= 45 && $english_passed && $math_passed) {
        $division = 'Division 2';
        } elseif (($pass_subjects >= 8 && $credit_subjects >= 3 && $credit_sum <= 58) || ($pass_subjects >= 7 && $credit_subjects >= 4 && $credit_sum <= 58) || ($pass_subjects >= 5 && $credit_subjects == 5 && $credit_sum <= 58)) {
        $division = 'Division 3';
        } elseif ($credit_subjects >= 1 && $credit_sum <= 32 && (!$science_subject || $science_grade_point <= 6) && ($pass_subjects >= 1 && $pass_list[0]->average_point >= 7 || $pass_subjects >= 2 && $pass_list[0]->average_point >= 6 && $pass_list[1]->average_point >= 6 || $pass_subjects >= 3 && $pass_list[0]->average_point >= 5 && $pass_list[1]->average_point >= 5 && $pass_list[2]->average_point >= 5)) {
        $division = 'Division 4';
        } else {
        $division = 'Division 7';
        }
        return $division;
    
    }
    
}
