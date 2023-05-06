<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lowercurriculumresult_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    public function get_subject_list($school_id, $class_id, $section_id, $student_id, $academic_year_id, $exam_id) {
        $this->db->select('S.name AS subject, AVG(CASE WHEN M.activity_out_of_ten > 0 THEN M.activity_out_of_ten ELSE NULL END) AS activity_out_of_ten_avg, P.project_score, L.lower_exam_total_mark, REPLACE(CONCAT(SUBSTR(T.name,1,1), SUBSTR(SUBSTR(T.name,LOCATE(\' \',T.name)+1),1,1)), \' \', \'\') AS teacher_initials');
        $this->db->from('subjects AS S');
        $this->db->join('(SELECT subject_id, activity_out_of_ten FROM aoi_marks WHERE school_id = '.$school_id.' AND class_id = '.$class_id.' AND section_id = '.$section_id.' AND student_id = '.$student_id.' AND academic_year_id = '.$academic_year_id.') AS M', 'S.id = M.subject_id', 'left');
        $this->db->join('(SELECT subject_id, AVG(project_score) AS project_score FROM project_marks WHERE school_id = '.$school_id.' AND class_id = '.$class_id.' AND section_id = '.$section_id.' AND student_id = '.$student_id.' AND academic_year_id = '.$academic_year_id.' GROUP BY subject_id) AS P', 'S.id = P.subject_id', 'left');
        $this->db->join('(SELECT subject_id, lower_exam_total_mark FROM lower_marks WHERE school_id = '.$school_id.' AND class_id = '.$class_id.' AND section_id = '.$section_id.' AND student_id = '.$student_id.' AND academic_year_id = '.$academic_year_id.' AND exam_id = '.$exam_id.') AS L', 'S.id = L.subject_id', 'left');
        $this->db->join('teachers AS T', 'S.teacher_id = T.id', 'left');
        $this->db->where('S.school_id', $school_id);
        $this->db->where('S.class_id', $class_id);
        // $this->db->where('S.section_id', $section_id);
        // $this->db->where('S.academic_year_id', $academic_year_id);
        // $this->db->where('S.status', 1);
        $this->db->group_by('S.id');
        return $this->db->get()->result();
    }
    // public function get_subject_list($school_id, $class_id, $section_id, $student_id, $academic_year_id, $exam_id) {
    //     $this->db->select('S.name AS subject, AVG(CASE WHEN M.activity_out_of_ten > 0 THEN M.activity_out_of_ten ELSE NULL END) AS activity_out_of_ten_avg, P.project_score, L.lower_exam_total_mark, REPLACE(CONCAT(SUBSTR(T.name,1,1), SUBSTR(SUBSTR(T.name,LOCATE(\' \',T.name)+1),1,1)), \' \', \'\') AS teacher_initials, G.name AS grade_name, G.note');
    //     $this->db->from('subjects AS S');
    //     $this->db->join('(SELECT subject_id, activity_out_of_ten FROM aoi_marks WHERE school_id = '.$school_id.' AND class_id = '.$class_id.' AND section_id = '.$section_id.' AND student_id = '.$student_id.' AND academic_year_id = '.$academic_year_id.') AS M', 'S.id = M.subject_id', 'left');
    //     $this->db->join('(SELECT subject_id, AVG(project_score) AS project_score FROM project_marks WHERE school_id = '.$school_id.' AND class_id = '.$class_id.' AND section_id = '.$section_id.' AND student_id = '.$student_id.' AND academic_year_id = '.$academic_year_id.' GROUP BY subject_id) AS P', 'S.id = P.subject_id', 'left');
    //     $this->db->join('(SELECT subject_id, lower_exam_total_mark FROM lower_marks WHERE school_id = '.$school_id.' AND class_id = '.$class_id.' AND section_id = '.$section_id.' AND student_id = '.$student_id.' AND academic_year_id = '.$academic_year_id.' AND exam_id = '.$exam_id.') AS L', 'S.id = L.subject_id', 'left');
    //     $this->db->join('teachers AS T', 'S.teacher_id = T.id', 'left');
    //     $this->db->join('grades AS G', 'G.school_id = '.$school_id.' AND (L.lower_exam_total_mark + COALESCE(P.project_score, 0) + COALESCE(M.activity_out_of_ten, 0)) >= G.mark_from AND (L.lower_exam_total_mark + COALESCE(P.project_score, 0) + COALESCE(M.activity_out_of_ten, 0)) <= G.mark_to', 'left');
    //     $this->db->where('S.school_id', $school_id);
    //     $this->db->where('S.class_id', $class_id);
    //     // $this->db->where('S.section_id', $section_id);
    //     // $this->db->where('S.academic_year_id', $academic_year_id);
    //     // $this->db->where('S.status', 1);
    //     $this->db->group_by('S.id');
    //     return $this->db->get()->result();
    // }
    
    
}