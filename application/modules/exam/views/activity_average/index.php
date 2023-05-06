<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-file-text-o"></i><small> <?php echo $this->lang->line('manage_activity_average'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
                            
            <div class="x_content quick-link no-print">
                 <?php $this->load->view('quick-link-exam'); ?> 
            </div>      
                        
            <div class="x_content no-print"> 
                <?php echo form_open_multipart(site_url('exam/activityaverage/index'), array('name' => 'average', 'id' => 'average', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">  
                    
                    <?php $this->load->view('layout/school_list_filter'); ?>
                    
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('academic_year'); ?> <span class="red">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="academic_year_id" required="required" id="academic_year_id">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($academic_years as $obj) { ?>
                                <?php $running = $obj->is_running ? ' ['.$this->lang->line('running_year').']' : ''; ?>
                                <option value="<?php echo $obj->id; ?>" <?php if(isset($academic_year_id) && $academic_year_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->session_year; echo $running; ?></option>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('academic_year_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <?php $teacher_student_data = get_teacher_access_data('student'); ?>
                            <?php $guardian_class_data = get_guardian_access_data('class'); ?>
                            <div><?php echo $this->lang->line('class'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id"  required="required" onchange="get_section_subject_by_class(this.value,'');">
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
                            <div><?php echo $this->lang->line('section'); ?></div>
                            <select  class="form-control col-md-7 col-xs-12" name="section_id" id="section_id">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('section_id'); ?></div>
                        </div>
                    </div> 
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('subject'); ?></div>
                            <select  class="form-control col-md-7 col-xs-12" name="subject_id" id="subject_id">                             
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('subject_id'); ?></div>
                        </div>
                    </div>                   
                
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="x_content">             
                <div class="row">                                                      
                    <div class="col-sm-6  col-xs-6 col-sm-offset-3 col-xs-offset-3 layout-box">
                        <p> &nbsp;
                            <?php if(isset($school)){ ?>
                            <div><img   src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" width="70" /></div>
                            <h4><?php echo $school->school_name; ?></h4>
                            <p> <?php echo $school->address; ?></p>
                            <?php } ?>
                            <h4 class="head-title_ ptint-title"><small> <?php echo $this->lang->line('activity_average'); ?> </small></h4>                
                            <?php if(isset($academic_year)){ ?>
                            <div> &nbsp;
                            <?php echo $this->lang->line('academic_year'); ?>: <?php echo $academic_year; ?>
                            </div>
                            <?php } ?>
                            <div>
                            <?php if(isset($class)){ ?>
                            <?php echo $this->lang->line('class'); ?>: <?php echo $class; ?>
                            <?php } ?>
                            <?php if(isset($section)){ ?>
                            , <?php echo $this->lang->line('section'); ?>: <?php echo $section; ?>
                            <?php } ?>
                            <?php if(isset($subject)){ ?>
                            , <?php echo $this->lang->line('subject'); ?>: <?php echo $subject; ?>
                            <?php } ?>
                            </div>
                         </p>
                    </div>
                </div>            
            </div>
          
            <div class="x_content">
    <table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><?php echo $this->lang->line('roll_no'); ?></th>
                <th><?php echo $this->lang->line('name'); ?></th>
                <th><?php echo $this->lang->line('photo'); ?></th>
                <th><?php echo $this->lang->line('Activity_Score'); ?></th>
                <th><?php echo $this->lang->line('Averages'); ?></th>
                <th>Descriptor/Achievement Level</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $groups = array();
            foreach ($activityaverage as $obj) {
                $name = $obj->student;
                $roll = $obj->roll_no;
                $score = $obj->activity_score;

                if (isset($groups[$name][$roll])) {
                    $groups[$name][$roll][] = $score;
                } else {
                    $groups[$name][$roll] = array($score);
                }
            }

            foreach ($groups as $name => $rolls) {
                foreach ($rolls as $roll => $scores) {
                    $avg = number_format(array_sum($scores) / count($scores), 1);
                    $level = '';

                    if ($avg >= 2.5 && $avg <= 3.0) {
                        $level = 'Outstanding';
                    } elseif ($avg >= 1.5 && $avg <= 2.49) {
                        $level = 'Moderate';
                    } elseif ($avg >= 0.9 && $avg <= 1.49) {
                        $level = 'Basic';
                    }

                    ?>
                    <tr>
                        <?php if ($roll != '') { ?>
                            <td><?php echo $roll; ?></td>
                        <?php } else { ?>
                            <td><?php echo $this->lang->line('not_assigned'); ?></td>
                        <?php } ?>
                        <td><?php echo $name; ?></td>
                        <td>
                            <?php if ($obj->photo != '') { ?>
                                <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $obj->photo; ?>" alt="" width="45" />
                            <?php } else { ?>
                                <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="45" />
                            <?php } ?>
                            <input type="hidden" value="<?php echo $obj->id; ?>" name="students[]" />
                        </td>
                        <td>
                            <?php 
                            foreach ($scores as $key => $score) {
                                echo 'Topic ' . ($key + 1) . ' => <strong>' . $score . '</strong>, ';
                            }
                            ?>
                        </td>

                        <td><?php echo $avg; ?></td>
                        <td><?php echo $level; ?></td>
                    </tr>
                <?php }
            }
            if (empty($groups)) {
                ?>
                <tr>
                    <td colspan="10" class="text-center"><?php echo $this->lang->line('no_data_found'); ?></td>
                </tr>
            <?php } ?>
        </tbody>
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
         <?php if(isset($school_id) && !empty($school_id) && $this->session->userdata('role_id') == SUPER_ADMIN){ ?>               
            $(".fn_school_id").trigger('change');
         <?php } ?>
    });
    
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();
        var academic_year_id = '';
        var class_id = '';
        
        <?php if(isset($school_id) && !empty($school_id)){ ?>
            academic_year_id =  '<?php echo $academic_year_id; ?>';     
            class_id =  '<?php echo $class_id; ?>';           
         <?php } ?> 
           
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_academic_year_by_school'); ?>",
            data   : { school_id:school_id, academic_year_id:academic_year_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#academic_year_id').html(response);  
                    get_class_by_school(school_id,class_id); 
               }
            }
        });
    }); 

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
        get_section_subject_by_class('<?php echo $class_id; ?>', '<?php echo $section_id; ?>', '<?php echo $subject_id; ?>');
    <?php } ?>
    
    function get_section_subject_by_class(class_id, section_id, subject_id){       
        
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
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_subject_by_class'); ?>",
            data   : {school_id:school_id, class_id : class_id , subject_id: subject_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#subject_id').html(response);
               }
            }
        });         
            
    }
    $("#average").validate(); 
 
</script>





