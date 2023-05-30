<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title no-print">
                <h3 class="head-title"><i class="fa fa-file-text-o"></i><small> <?php echo $this->lang->line('manage_formative_card'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
                                             
            <div class="x_content quick-link no-print">
                 <?php $this->load->view('quick-link-exam'); ?> 
            </div>      
               
            <div class="x_content no-print"> 
                <?php echo form_open_multipart(site_url('exam/formativecard/index'), array('name' => 'formativecard', 'id' => 'formativecard', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">  
                    
                    <?php $this->load->view('layout/school_list_filter'); ?> 
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('academic_year'); ?> <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="academic_year_id" id="academic_year_id" required="required">
                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                <?php foreach ($academic_years as $obj) { ?>
                                <?php $running = $obj->is_running ? ' ['.$this->lang->line('running_year').']' : ''; ?>
                                <option value="<?php echo $obj->id; ?>" <?php if(isset($academic_year_id) && $academic_year_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->session_year; echo $running; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <?php if($this->session->userdata('role_id') != STUDENT ){ ?>    
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <?php $teacher_student_data = get_teacher_access_data('student'); ?>
                            <?php $guardian_class_data = get_guardian_access_data('class'); ?>
                            <div><?php echo $this->lang->line('class'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id"  required="required" onchange="get_section_by_class(this.value,'');">
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
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('student'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="student_id" id="student_id" required="required">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('student_id'); ?></div>
                        </div>
                    </div>
                    <?php } ?>    
                    <div class="col-md-1 col-sm-1 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                    <div class="item form-group"> 
                        <div>All</div>
                        <a href="all" class="btn btn-primary">
                            <i class="fa fa-eye"></i>VIEW ALL REPORT CARDS
                        </a>
                    </div>
                </div>

                </div>
                <?php echo form_close(); ?>
            </div>

            <?php  if (isset($student) && !empty($student)) { ?>
            <div class="x_content">             
                <div class="row">
                    <div class="col-sm-6 col-xs-6  col-sm-offset-3 col-xs-offset-3  layout-box">                       
                        <?php if(isset($school)){ ?>
                            <div><img   src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" width="70" /></div>
                        <h4><?php echo $school->school_name; ?></h4>
                        <p> <?php echo $school->address; ?></p>
                        <?php } ?>
                        <h4><?php echo $this->lang->line('formative_card'); ?></h4> 
                        <div class="profile-pic">
                            <?php if ($student->photo != '') { ?>
                               <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $student->photo; ?>" alt="" width="80" /> 
                            <?php } else { ?>
                                <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="45" /> 
                            <?php } ?>
                        </div>
                        <?php echo $this->lang->line('name'); ?> : <?php echo $student->name; ?><br/>
                        <?php echo $this->lang->line('class'); ?> : <?php echo $student->class_name; ?>,
                        <?php echo $this->lang->line('section'); ?> : <?php echo $student->section; ?>,
                        <?php echo $this->lang->line('roll_no'); ?> : <?php echo $student->roll_no; ?>                       
                    </div>
                </div>            
            </div>
             <?php } ?>
             <style>
                .x_content {
                    margin-bottom: 20px; /* set a bottom margin for the first div */
                }

                .rowt {
                    margin-top: 20px; /* set a top margin for the second div */
                }
                #fn_mark td {
  border: 2px solid black;
}

              

            </style>



                    <div class="x_content">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" style="border-width: 2px;">

                                <thead>
                                    <tr>
                            <!-- <th rowspan="1"><?php echo $this->lang->line('sl_no'); ?></th> -->
                                        <th><?php echo $this->lang->line('subject'); ?></th>                                           
                                        <th><?php echo $this->lang->line('activity/twenty'); ?></th>                                                                                       
                                        <th><?php echo $this->lang->line('identifier'); ?></th>                                            
                                        <th><?php echo $this->lang->line('descriptor/achieve'); ?></th>                                            
                                        <th><?php echo $this->lang->line('init'); ?></th>                                            
                                                                                
                                    </tr>
                                
                                </thead>
                           
                            <tbody>
                                <?php if (!empty($subjects)): ?>
                                    <?php 
                                        $total_identifiers = 0;
                                     $count = 1;

                                        $total_subjects = count($subjects);
                                    ?>
                                    <?php foreach ($subjects as $subject): ?>
                                        <tr>
                                    <!-- <td class="subject-count"><?php echo  $count++; ?></td> -->
                                            <td><?php echo $subject->subject; ?></td>
                                            <?php
                                            $total_score = 0;
                                            $score_count = 0;
                                            $activity_out_of_twenty = 0;
                                            $identifier = 0;
                                            $descriptor = '';
                                            if ($subject->project_score == null || $subject->project_score == 0) {
                                                $total_score = round($subject->activity_out_of_ten_avg * 2);
                                                $activity_out_of_twenty = round($total_score / 20 * 3);
                                            } else {
                                                $total_score = round($subject->activity_out_of_ten_avg + $subject->project_score);
                                                $activity_out_of_twenty = round($total_score / 20 * 3);
                                            }

                                            // Calculate identifier
                                            $identifier = round($activity_out_of_twenty);
                                            $total_identifiers += $identifier; // add identifier to the total

                                            // Calculate descriptor
                                            switch ($identifier) {
                                                case 3:
                                                    $descriptor = 'Outstanding';
                                                    break;
                                                case 2:
                                                    $descriptor = 'Moderate';
                                                    break;
                                                case 1:
                                                    $descriptor = 'Basic';
                                                    break;
                                                default:
                                                    $descriptor = '';
                                            }
                                            ?>
                                            <td><?php echo $total_score; ?></td>
                                            <td><?php echo $identifier; ?></td>
                                            <td><?php echo $descriptor; ?></td>
                                            <td><?php echo $subject->teacher_initials; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="1" align="center" style="font-weight:bold;"><?php echo $this->lang->line('Averages'); ?>:</td>
                                        <td style="font-weight:bold;">
                                            <?php
                                            $total = 0;
                                            $count = 0;
                                            foreach ($subjects as $subject) {
                                                if ($subject->activity_out_of_ten_avg != null && $subject->activity_out_of_ten_avg != 0) {
                                                    if ($subject->project_score == null || $subject->project_score == 0) {
                                                        $total += round($subject->activity_out_of_ten_avg * 2);
                                                    } else {
                                                        $total += round($subject->activity_out_of_ten_avg + $subject->project_score);
                                                    }
                                                    $count++;
                                                }
                                            }
                                            if ($count != 0) {
                                                echo round($total / $count, 1);
                                            } else {
                                                echo '0';
                                            }
                                            ?>
                                        </td>
                                        <td style="font-weight:bold;">
                                            <?php 
                                                if ($count != 0) {
                                                    echo round($total_identifiers / $count, 1); // calculate the average identifier
                                                } else {
                                                    echo '0';
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="17" align="center"><?php echo $this->lang->line('no_data_found'); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                        </table>
                    </div>
                 
            <div class="rowt"><div class="col-lg-12">&nbsp;</div></div>
            <div class="rowt">
                <div class="col-xs-4 text-center signature">
                    <?php echo $this->lang->line('principal'); ?>
                </div>
                <div class="col-xs-2 text-center">
                    &nbsp;
                </div>
                <div class="col-xs-4 text-center signature">
                    <?php echo $this->lang->line('class_teacher'); ?>
                </div>
            </div>
            <table style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; font-size: 14px;">
  <tr>
    <th style="border: 2px solid black; padding: 8px; text-align: left;">Identifier</th>
    <th style="border: 2px solid black; padding: 8px; text-align: left;">Score Range</th>
    <th style="border: 2px solid black; padding: 8px; text-align: left;">Description</th>
  </tr>
  <tr>
    <td style="border: 2px solid black; padding: 8px;">3</td>
    <td style="border: 2px solid black; padding: 8px;">2.5 - 3.0</td>
    <td style="border: 2px solid black; padding: 8px;">
        <table style="border-collapse: collapse; width: 100%;">
            <tr>
                <td style="font-weight: bold;">Outstanding:</td>
                <td>Most or all Learning outcomes achieved for overall achievement</td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td style="border: 2px solid black; padding: 8px;">2</td>
    <td style="border: 2px solid black; padding: 8px;">1.5 - 2.49</td>
    <td style="border: 2px solid black; padding: 8px;">
        <table style="border-collapse: collapse; width: 100%;">
            <tr>
                <td style="font-weight: bold;">Moderate:</td>
                <td>Many Learning Outcomes achieved, enough for overall achievements</td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td style="border: 2px solid black; padding: 8px;">1</td>
    <td style="border: 2px solid black; padding: 8px;">0.9 - 1.49</td>
    <td style="border: 2px solid black; padding: 8px;">
        <table style="border-collapse: collapse; width: 100%;">
            <tr>
                <td style="font-weight: bold;">Basic:</td>
                <td>Few Learning Outcomes achieved, but not sufficient for overall achievement</td>
            </tr>
        </table>
    </td>
  </tr>
</table>
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
         <?php if(isset($school_id) && !empty($school_id) &&  $this->session->userdata('role_id') == SUPER_ADMIN){ ?>               
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
        get_section_by_class('<?php echo $class_id; ?>', '<?php echo $section_id; ?>');
    <?php } ?>
    
    function get_section_by_class(class_id, section_id){       
       
        var school_id = $('.fn_school_id').val();     
             
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        } 
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_section_by_class'); ?>",
            data   : { school_id:school_id, class_id : class_id , section_id: section_id},               
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
            data   : {school_id:school_id, section_id: section_id, student_id: student_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#student_id').html(response);
               }
            }
        });         
    }
 
  $("#formativecard").validate(); 
  $("#marksheet").validate(); 
</script>
<style>
.table>thead>tr>th,.table>tbody>tr>td {
    padding: 2px;
}

</style>