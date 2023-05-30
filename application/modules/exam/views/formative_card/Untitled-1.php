<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-file-text-o"></i><small> <?php echo $this->lang->line('manage_a_level_result'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
                                      
            <div class="x_content quick-link no-print">
                 <?php $this->load->view('quick-link-exam'); ?> 
            </div>  
            
            <div class="x_content no-print"> 
                <?php echo form_open_multipart(site_url('exam/alevelresult/index'), array('name' => 'marksheet', 'id' => 'marksheet', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row"> 
                        
                    <?php $this->load->view('layout/school_list_filter'); ?>  
                    
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('academic_year'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="academic_year_id" id="academic_year_id" required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($academic_years as $obj) { ?>
                                <?php $running = $obj->is_running ? ' ['.$this->lang->line('running_year').']' : ''; ?>
                                <option value="<?php echo $obj->id; ?>" <?php if(isset($academic_year_id) && $academic_year_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->session_year; echo $running; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                        
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('exam'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="exam_id" id="exam_id"  required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($exams as $obj) { ?>
                                <option value="<?php echo $obj->id; ?>" <?php if(isset($exam_id) && $exam_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->title; ?></option>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('exam_id'); ?></div>
                        </div>
                    </div>
                    
                    <?php if($this->session->userdata('role_id') != STUDENT ){ ?>    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                                <?php $teacher_student_data = get_teacher_access_data('student'); ?>
                                <?php $guardian_class_data = get_guardian_access_data('class'); ?>
                                <div><?php echo $this->lang->line('class'); ?> <span class="required">*</span></div>
                                <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id"  required="required" onchange="get_section_by_class(this.value,'','');">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    <?php foreach ($classes as $obj) { ?>
                                        <?php if($this->session->userdata('role_id') == TEACHER && !in_array($obj->id, $teacher_student_data)){ continue;  ?>
                                        <?php }elseif($this->session->userdata('role_id') == GUARDIAN && !in_array($obj->id, $guardian_class_data)){ continue; } ?>
                                        <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="help-block"><?php echo form_error('class_id'); ?></div>
                            </div>
                    </div>
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('section'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="section_id" id="section_id" required="required" onchange="get_student_by_section(this.value,'');">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('section_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('student'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="student_id" id="student_id" required="required">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('student_id'); ?></div>
                        </div>
                    </div>
                    <?php } ?>    
                                   
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <?php  if (isset($student) && !empty($student)) { ?>
            <div class="x_content">             
                <div class="row">
                    <div class="col-sm-6 col-xs-6  col-sm-offset-3  col-xs-offset-3 layout-box">
                        <p>
                            <?php if(isset($school)){ ?>
                            <div>
                                <?php if($school->logo){ ?>
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" /> 
                                 <?php }else if($school->frontend_logo){ ?>
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->frontend_logo; ?>" alt="" /> 
                                 <?php }else{ ?>                                                        
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->brand_logo; ?>" alt=""  />
                                 <?php } ?>
                            </div>
                            <h4><?php echo $school->school_name; ?></h4>
                            <p> <?php echo $school->address; ?></p>
                            <?php } ?>
                            <h4><?php echo $this->lang->line('mark_sheet'); ?></h4> 
                            <?php echo $this->lang->line('name'); ?> : <?php echo $student->name; ?><br/>
                            <?php echo $this->lang->line('exam'); ?> : <?php echo $exam->title; ?><br/>
                            <?php echo $this->lang->line('class'); ?> : <?php echo $student->class_name; ?>,
                            <?php echo $this->lang->line('section'); ?> : <?php echo $student->section; ?>,
                            <?php echo $this->lang->line('roll_no'); ?> : <?php echo $student->roll_no; ?>
                        </p>
                    </div>
                </div>            
            </div>
             <?php } ?>
            
            <div class="x_content">
                
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                   <thead>
                        <tr>
                            <th rowspan="2"><?php echo $this->lang->line('sl_no'); ?></th>
                            <th rowspan="2"><?php echo $this->lang->line('subject'); ?></th>                                                                            <th><?php echo $this->lang->line('init'); ?></th> 
                            <th rowspan="2"><?php echo $this->lang->line('score'); ?></th>   
                            <th rowspan="2"><?php echo $this->lang->line('papers'); ?></th>                                                                                                                         
                            <th rowspan="2"><?php echo $this->lang->line('marks'); ?></th>                                                                                                                         
                            <th rowspan="2"><?php echo $this->lang->line('ranks'); ?></th>                                                                                                                         
                            <th rowspan="2"><?php echo $this->lang->line('comments'); ?></th>                                                                                                   
                        </tr>
                    </thead>
                    <tbody id="fn_mark">
    <?php
    $subject = "";
    $count = 0;
    $paper_counts = array(); // initialize an empty array to keep track of paper_title counts
    $rank_counts = array();

    if (isset($subjects) && !empty($subjects)) {
        foreach ($subjects as $obj) {
            if ($subject != $obj->subject) {
                // new subject, print subject name and start paper/marks list
                $count++;
                $paper_counts[$obj->subject] = 1; // initialize paper count to 1 for new subject
                $rank_counts[$obj->subject] = 1; // initialize paper count to 1 for new subject
    ?>
                <tr class="subject-row">
                    <td class="subject-count"><?php echo $count; ?></td>
                    <td class="subject-name"><?php echo ucfirst($obj->subject); ?></td>
                    <td class="teacher-initials"><?php echo ucfirst($obj->teacher_initials); ?></td>
                    <td><?php printRanks($rank_counts, $subjects, $obj->subject); ?></td>

 <!-- compute the grade based on paper_title and name -->
                    <td class="paper-title"><?php echo $obj->paper_title; ?></td>
                    <td class="paper-score"><?php echo $obj->paper_score; ?></td>
                    <td class="subject-rank"><?php echo $obj->name; ?></td>
                    <td class="comment">Good</td>
                </tr>
    <?php
                $subject = $obj->subject;
            } else {
                // same subject, print paper/marks list
                $paper_counts[$obj->subject]++; // increment paper count for the same subject
                $rank_counts[$obj->subject]++; // increment paper count for the same subject
    ?>
                <tr class="paper-row">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="paper-title"><?php echo $obj->paper_title; ?></td>
                    <td class="paper-score"><?php echo $obj->paper_score; ?></td>
                    <td class="subject-rank"><?php echo $obj->name; ?></td>
                    <td></td>
                </tr>
    <?php
            }
        }
    } else {
    ?>
        <tr>
            <td colspan="8" align="center"><?php echo $this->lang->line('no_data_found'); ?></td>
        </tr>
    <?php
    }
    // function printRanks($rank_counts, $subjects, $subject) {
    //     echo "<ul>";
    
    //     // initialize variables to keep track of C5 and D2 ranks for this subject
    //     $d1_rank = false;
    //     $d2_rank = false;
    //     $c3_rank = false;
    //     $c4_rank = false;
    //     $c5_rank = false;
    //     $c6_rank = false;
    //     $p7_rank = false;
    //     $p8_rank = false;
    //     $f9_rank = false;
        
    //     $num_ranks = 0; // keep track of number of ranks attained for this subject
    
    //     foreach ($subjects as $obj) {
    //         if ($obj->subject == $subject) {
    //             $num_ranks++; // increment the number of ranks attained for this subject
    
    //             // check if the rank is C5 or D2
    //             if ($obj->name == "D1") {
    //                 $d1_rank = true;
    //             } elseif ($obj->name == "D2") {
    //                 $d2_rank = true;
    //             }
    //             // check if the rank is C5 or D2
    //             if ($obj->name == "C3") {
    //                 $c3_rank = true;
    //             } elseif ($obj->name == "C4") {
    //                 $c4_rank = true;
    //             } elseif ($obj->name == "C5") {
    //                 $c5_rank = true;
    //             } elseif ($obj->name == "C6") {
    //                 $c6_rank = true;
    //             } elseif ($obj->name == "P7") {
    //                 $p7_rank = true;
    //             } elseif ($obj->name == "P8") {
    //                 $p8_rank = true;
    //             } elseif ($obj->name == "F9") {
    //                 $f9_rank = true;
    //             }
    //         }
    //     }
    
    //     // check if only one rank was attained for this subject
    //     if ($num_ranks == 1) {
    //         if ($d1_rank) {
    //             echo "<p>A</p>";
    //         } elseif ($d2_rank) {
    //             echo "<p>B</p>";
    //         } elseif ($c3_rank) {
    //             echo "<p>C</p>";
    //         } elseif ($c4_rank) {
    //             echo "<p>D</p>";
    //         } elseif ($c5_rank) {
    //             echo "<p>E</p>";
    //         }  elseif ($c6_rank) {
    //             echo "<p>O</p>";
    //         }elseif ($p7_rank_rank || $p8_rank || $f9_rank ) {
    //             echo "<p>F</p>";
    //         }
    //     } else {
    //         // check if both C5 and D2 ranks were attained for this subject
    //         if ($d1_rank && $d2_rank  || $d1_rank && $d1_rank || $d2_rank && $d2_rank ) {
    //             echo "<p>You attained a D1 and a D2 so you get an A</p>";
    //         } else {
    //             // check if both C3 and C4 ranks were attained for this subject
    //             if ($c3_rank && $d1_rank || $c3_rank && $d2_rank) {
    //                 echo "<p>B</p>";
    //             } else {
    //                 echo "<p>Multiple ranks attained. Could not determine the overall rank.</p>";
    //             }
    //         }
    //     }
    //     echo "</ul>";
    // }
    
    function printRanks($rank_counts, $subjects, $subject) {
        echo "<ul>";
        
        // initialize variables to keep track of C5 and D2 ranks for this subject
        $d1_rank = false;
        $d2_rank = false;
        $c3_rank = false;
        $c4_rank = false;
        $c5_rank = false;
        $c6_rank = false;
        $p7_rank = false;
        $p8_rank = false;
        $f9_rank = false;
        
        $num_ranks = 0; // keep track of number of ranks attained for this subject
        
        foreach ($subjects as $obj) {
            if ($obj->subject == $subject) {
                $num_ranks++; // increment the number of ranks attained for this subject
        
                // check if the rank is C5 or D2
                if ($obj->name == "D1") {
                    $d1_rank = true;
                } elseif ($obj->name == "D2") {
                    $d2_rank = true;
                } elseif ($obj->name == "C3") {
                    $c3_rank = true;
                } elseif ($obj->name == "C4") {
                    $c4_rank = true;
                } elseif ($obj->name == "C5") {
                    $c5_rank = true;
                } elseif ($obj->name == "C6") {
                    $c6_rank = true;
                } elseif ($obj->name == "P7") {
                    $p7_rank = true;
                } elseif ($obj->name == "P8") {
                    $p8_rank = true;
                } elseif ($obj->name == "F9") {
                    $f9_rank = true;
                }
            }
        }
        
        // check if only one rank was attained for this subject
        if ($num_ranks == 1) {
            if ($d1_rank) {
                echo "<p>A</p>";
            } elseif ($d2_rank) {
                echo "<p>B</p>";
            } elseif ($c3_rank) {
                echo "<p>C</p>";
            } elseif ($c4_rank) {
                echo "<p>D</p>";
            } elseif ($c5_rank) {
                echo "<p>E</p>";
            } elseif ($c6_rank) {
                echo "<p>O</p>";
            } elseif ($p7_rank || $p8_rank || $f9_rank) {
                echo "<p>F</p>";
            }
        // check if two ranks were attained for this subject
        } elseif ($num_ranks == 2) {
            if (($d1_rank && $c3_rank) || ($d2_rank && $c3_rank)) {
                echo "<p>B</p>";
            }elseif (($d1_rank && $c4_rank) || ($d2_rank && $c4_rank)|| ($c3_rank && $c4_rank)) {
                echo "<p>C</p>";
            }elseif (($d1_rank && $c5_rank) || ($d2_rank && $c5_rank)|| ($c3_rank && $c5_rank) || ($c4_rank && $c5_rank)) {
                echo "<p>D</p>";
            }elseif (($d1_rank && $c6_rank) || ($d2_rank && $c6_rank)|| ($c3_rank && $c6_rank) || ($c4_rank && $c6_rank)|| ($c5_rank && $c6_rank)) {
                echo "<p>E</p>";
            }elseif (($d1_rank && $p7_rank ) || ($d2_rank && $p7_rank )|| ($c3_rank && $p7_rank ) ||($c4_rank && $p7_rank )|| ($c5_rank && $p7_rank )|| ($c6_rank && $p7_rank )) {
                echo "<p>O</p>";
            }elseif (($d1_rank && $p8_rank ) || ($d2_rank && $p8_rank )|| ($c3_rank && $p8_rank ) ||($c4_rank && $p8_rank )|| ($c5_rank && $p8_rank )|| ($c6_rank && $p8_rank )) {
                echo "<p>O</p>";
            }elseif (($d1_rank && $f9_rank ) || ($d2_rank && $f9_rank )|| ($c3_rank && $f9_rank ) ||($c4_rank && $f9_rank )|| ($c5_rank && $f9_rank )|| ($c6_rank && $f9_rank)) {
                echo "<p>O</p>";
            }elseif (($p8_rank || $p7_rank && $f9_rank )) {
                echo "<p>F</p>";
            }
             elseif (($d1_rank && $d1_rank) || ($d2_rank && $d2_rank) || ($d1_rank && $d2_rank )) {
                echo "<p>A</p>";
            }
             else {
                echo "Error: Invalid ranks for this subject";
            }
        } 
        elseif ($num_ranks == 3) {
            if (($f9_rank) && ($f9_rank)) {
                if (($d1_rank) || ($d2_rank) || ($c3_rank)  || ($c4_rank) || ($c5_rank) || ($c6_rank)){
                    echo "<p>F</p>";
                }    
            }elseif ($f9_rank && $p8_rank) {
                if (($d1_rank) || ($d2_rank) || ($c3_rank)  || ($c4_rank) || ($c5_rank) || ($c6_rank)){
                    echo "<p>F</p>";
                } 
            }else if ($f9_rank) {
                if (($p7_rank && $p8_rank) || ($p7_rank && $p7_rank) || ($p8_rank && $p8_rank)) {
                    echo "<p>F</p>";
                    } 
            }else if ($f9_rank) {
            if (($d1_rank && $d2_rank) || ($d1_rank && $c3_rank) || ($d1_rank && $c4_rank)  || ($d1_rank && $c5_rank) || ($d1_rank && $c6_rank) || ($d2_rank && $c3_rank) || ($d2_rank && $c4_rank)  || ($d2_rank && $c5_rank)  || ($d2_rank && $c6_rank) || ($d1_rank && $d1_rank) || ($d2_rank && $d2_rank) || ($c3_rank && $c3_rank)|| ($c3_rank && $c4_rank)|| ($c3_rank && $c5_rank)  || ($c3_rank && $c6_rank)) {
                echo "<p>O</p>";
                } 
            }elseif ($p7_rank && $p8_rank) {
                if (($d1_rank) || ($d2_rank) || ($c3_rank)  || ($c4_rank) || ($c5_rank) || ($c6_rank)) {
                    echo "<p>O</p>";
                }    
            } elseif ($p7_rank || $p8_rank) {
                if (($d1_rank && $d2_rank) || ($d1_rank && $c3_rank) || ($d1_rank && $c4_rank)  || ($d1_rank && $c5_rank) || ($d1_rank && $c6_rank) || ($d2_rank && $c3_rank) || ($d2_rank && $c4_rank)  || ($d2_rank && $c5_rank)  || ($d2_rank && $c6_rank) || ($d1_rank && $d1_rank) || ($d2_rank && $d2_rank) || ($c3_rank && $c3_rank)|| ($c3_rank && $c4_rank)|| ($c3_rank && $c5_rank)  || ($c3_rank && $c6_rank)) {
                    echo "<p>E</p>";
                }
            }elseif ($c5_rank) {
                if (($d1_rank && $d2_rank) || ($d1_rank && $c3_rank) || ($d1_rank && $c4_rank) || ($d2_rank && $c3_rank) || ($d2_rank && $c4_rank) || ($d1_rank && $d1_rank) || ($d2_rank && $d2_rank) || ($c3_rank && $c3_rank)  || ($c3_rank && $c4_rank)) {
                    echo "<p>C</p>";
                }
            }elseif ($c6_rank) {
                if (($d1_rank && $d2_rank) || ($d1_rank && $c3_rank) || ($d1_rank && $c4_rank)  || ($d1_rank && $c5_rank) || ($d2_rank && $c3_rank) || ($d2_rank && $c4_rank)  || ($d2_rank && $c5_rank) || ($d1_rank && $d1_rank) || ($d2_rank && $d2_rank) || ($c3_rank && $c3_rank)|| ($c3_rank && $c4_rank)|| ($c3_rank && $c5_rank)) {
                    echo "<p>D</p>";
                }
            }elseif ($c4_rank) {
                if (($d1_rank && $d2_rank) || ($d1_rank && $c3_rank) || ($d2_rank && $c3_rank) || ($d1_rank && $d1_rank) || ($d2_rank && $d2_rank) || ($c3_rank && $c3_rank)) {
                    echo "<p>B</p>";
                }
            }elseif (($d1_rank && $p7_rank ) || ($d2_rank && $p7_rank )|| ($c3_rank && $p7_rank ) ||($c4_rank && $p7_rank )|| ($c5_rank && $p7_rank )|| ($c6_rank && $p7_rank )) {
                echo "<p>O</p>";
            }elseif (($d1_rank && $p8_rank ) || ($d2_rank && $p8_rank )|| ($c3_rank && $p8_rank ) ||($c4_rank && $p8_rank )|| ($c5_rank && $p8_rank )|| ($c6_rank && $p8_rank )) {
                echo "<p>O</p>";
            }elseif (($d1_rank && $f9_rank ) || ($d2_rank && $f9_rank )|| ($c3_rank && $f9_rank ) ||($c4_rank && $f9_rank )|| ($c5_rank && $f9_rank )|| ($c6_rank && $f9_rank)) {
                echo "<p>O</p>";
            }elseif (($d1_rank && $d1_rank && $c3_rank) || ($d2_rank && $d2_rank && $c3_rank) || ($d1_rank && $d2_rank && $c3_rank )) {
                echo "<p>A</p>";
            }
             else {
                echo "Error: Invalid ranks for this subject";
            }
        }    elseif ($num_ranks == 4) {
            if (($f9_rank) && ($f9_rank)) {
                if (($d1_rank) || ($d2_rank) || ($c3_rank)  || ($c4_rank) || ($c5_rank) || ($c6_rank)){
                    echo "<p>F</p>";
                }    
            }elseif ($f9_rank && $p8_rank) {
                if (($d1_rank) || ($d2_rank) || ($c3_rank)  || ($c4_rank) || ($c5_rank) || ($c6_rank)){
                    echo "<p>F</p>";
                } 
            }else if ($f9_rank) {
                if (($p7_rank && $p8_rank) || ($p7_rank && $p7_rank) || ($p8_rank && $p8_rank)) {
                    echo "<p>F</p>";
                    } 
            }else if ($f9_rank) {
            if (($d1_rank && $d2_rank) || ($d1_rank && $c3_rank) || ($d1_rank && $c4_rank)  || ($d1_rank && $c5_rank) || ($d1_rank && $c6_rank) || ($d2_rank && $c3_rank) || ($d2_rank && $c4_rank)  || ($d2_rank && $c5_rank)  || ($d2_rank && $c6_rank) || ($d1_rank && $d1_rank) || ($d2_rank && $d2_rank) || ($c3_rank && $c3_rank)|| ($c3_rank && $c4_rank)|| ($c3_rank && $c5_rank)  || ($c3_rank && $c6_rank)) {
                echo "<p>O</p>";
                } 
            }elseif ($p7_rank && $p8_rank) {
                if (($d1_rank) || ($d2_rank) || ($c3_rank)  || ($c4_rank) || ($c5_rank) || ($c6_rank)) {
                    echo "<p>O</p>";
                }    
            } elseif ($p7_rank) {
                if (($d1_rank && $d2_rank) || ($d1_rank && $c3_rank) || ($d1_rank && $c4_rank)  || ($d1_rank && $c5_rank) || ($d1_rank && $c6_rank) || ($d2_rank && $c3_rank) || ($d2_rank && $c4_rank)  || ($d2_rank && $c5_rank)  || ($d2_rank && $c6_rank) || ($d1_rank && $d1_rank) || ($d2_rank && $d2_rank) || ($c3_rank && $c3_rank)|| ($c3_rank && $c4_rank)|| ($c3_rank && $c5_rank)  || ($c3_rank && $c6_rank)) {
                    echo "<p>E</p>";
                }
            }elseif ($c5_rank) {
                if (($d1_rank && $d2_rank) || ($d1_rank && $c3_rank) || ($d1_rank && $c4_rank) || ($d2_rank && $c3_rank) || ($d2_rank && $c4_rank) || ($d1_rank && $d1_rank) || ($d2_rank && $d2_rank) || ($c3_rank && $c3_rank)  || ($c3_rank && $c4_rank)) {
                    echo "<p>C</p>";
                }
            }elseif ($c6_rank) {
                if (($d1_rank && $d2_rank) || ($d1_rank && $c3_rank) || ($d1_rank && $c4_rank)  || ($d1_rank && $c5_rank) || ($d2_rank && $c3_rank) || ($d2_rank && $c4_rank)  || ($d2_rank && $c5_rank) || ($d1_rank && $d1_rank) || ($d2_rank && $d2_rank) || ($c3_rank && $c3_rank)|| ($c3_rank && $c4_rank)|| ($c3_rank && $c5_rank)) {
                    echo "<p>D</p>";
                }
            }elseif ($c4_rank) {
                if (($d1_rank && $d2_rank) || ($d1_rank && $c3_rank) || ($d2_rank && $c3_rank) || ($d1_rank && $d1_rank) || ($d2_rank && $d2_rank) || ($c3_rank && $c3_rank)) {
                    echo "<p>B</p>";
                }
            }elseif (($d1_rank && $p7_rank ) || ($d2_rank && $p7_rank )|| ($c3_rank && $p7_rank ) ||($c4_rank && $p7_rank )|| ($c5_rank && $p7_rank )|| ($c6_rank && $p7_rank )) {
                echo "<p>O</p>";
            }elseif (($d1_rank && $p8_rank ) || ($d2_rank && $p8_rank )|| ($c3_rank && $p8_rank ) ||($c4_rank && $p8_rank )|| ($c5_rank && $p8_rank )|| ($c6_rank && $p8_rank )) {
                echo "<p>O</p>";
            }elseif (($d1_rank && $f9_rank ) || ($d2_rank && $f9_rank )|| ($c3_rank && $f9_rank ) ||($c4_rank && $f9_rank )|| ($c5_rank && $f9_rank )|| ($c6_rank && $f9_rank)) {
                echo "<p>O</p>";
            }elseif (($d1_rank && $d1_rank && $c3_rank) || ($d2_rank && $d2_rank && $c3_rank) || ($d1_rank && $d2_rank && $c3_rank )) {
                echo "<p>A</p>";
            }
             else {
                echo "Error: Invalid ranks for this subject";
            }
        }       
        else {
            echo "Error: Invalid number of ranks for this subject";
        }
        
        echo "</ul>";
    }
    
    
    ?>
</tbody>








                            <style>
                                .subject-row {
                                    background-color: #f2f2f2;
                                    border-top: 2px solid black;
                                }
                                .subject-count, .subject-name, .teacher-initials {
                                    font-weight: bold;
                                }
                                .paper-row:nth-child(even) {
                                    background-color: #f2f2f2;
                                }
                                .paper-title {
                                    font-style: italic;
                                }
                            

                            </style>


                </table>             
            </div> 
            <div class="row no-print">
                <div class="col-xs-12 text-right">
                    <button class="btn btn-default " onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 no-print">
                <div class="instructions"><strong><?php echo $this->lang->line('instruction'); ?>: </strong> <?php echo $this->lang->line('mark_sheet_instruction'); ?></div>
            </div>
        </div>
    </div>
</div>

 
<!-- Super admin js START  -->
 <script type="text/javascript">
        
     $("document").ready(function() {
         <?php if(isset($school_id) && !empty($school_id)  && $this->session->userdata('role_id') == SUPER_ADMIN){ ?>               
            $(".fn_school_id").trigger('change');
         <?php } ?>
    });
    
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();
        var exam_id = '';
        var class_id = '';
        var academic_year_id = '';
        
        <?php if(isset($school_id) && !empty($school_id)){ ?>
            exam_id =  '<?php echo $exam_id; ?>';           
            class_id =  '<?php echo $class_id; ?>';           
            academic_year_id =  '<?php echo $academic_year_id; ?>';           
         <?php } ?> 
           
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_exam_by_school'); ?>",
            data   : { school_id:school_id, exam_id:exam_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#exam_id').html(response);  
                   get_class_by_school(school_id,class_id); 
                   get_academic_year_by_school(school_id, academic_year_id);
               }
            }
        });
    }); 

    function get_academic_year_by_school(school_id, academic_year_id){       
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_academic_year_by_school'); ?>",
            data   : { school_id:school_id, academic_year_id :academic_year_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#academic_year_id').html(response); 
               }
            }
        });
   }
   function get_class_by_school(school_id, class_id){       
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id, class_id:class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                    $('#class_id').html(response); 
               }
            }
        }); 
   } 
   
  
   
  </script>
<!-- Super admin js end -->


 <script type="text/javascript">     
  
    <?php if(isset($class_id) && isset($section_id)){ ?>
        get_section_by_class('<?php echo $class_id; ?>', '<?php echo $section_id; ?>');
    <?php } ?>
    
    
    function get_section_by_class(class_id, section_id){       
       
       var school_id = $('#school_id').val();  
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        } 
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_section_by_class'); ?>",
            data   : {school_id:school_id, class_id : class_id , section_id: section_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#section_id').html(response);
               }
            }
        });         
    }
 
    <?php if(isset($class_id) && isset($section_id)){ ?>
        get_student_by_section('<?php echo $section_id; ?>', '<?php echo $student_id; ?>');
    <?php } ?>
    
    function get_student_by_section(section_id, student_id){       
        
        var school_id = $('#school_id').val();  
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        } 
           
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_student_by_section'); ?>",
            data   : {school_id:school_id,section_id: section_id, student_id: student_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#student_id').html(response);
               }
            }
        });         
    }
 
  $("#marksheet").validate(); 
</script>
<style>
.table>thead>tr>th {
    padding: 4px;
}
</style>



