<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-file-text-o"></i><small> <?php echo $this->lang->line('manage_mark'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
               
            <div class="x_content quick-link">
                 <?php $this->load->view('quick-link-exam'); ?> 
            </div>      
            
            
            
            <div class="x_content"> 
                <?php echo form_open_multipart(site_url('exam/markaoi/index'), array('name' => 'mark_aoi', 'id' => 'mark_aoi', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">
                    
                    <div class="col-md-10 col-sm-10 col-xs-12">
                    
                    <?php $this->load->view('layout/school_list_filter'); ?>   
                        
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('exam'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="exam_id" id="exam_id"  required="required">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php if(isset($exams) && !empty($exams)) { ?>
                                    <?php foreach ($exams as $obj) { ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($exam_id) && $exam_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->title; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('exam_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('class'); ?>  <span class="required">*</span></div>
                            <?php $teacher_student_data = get_teacher_access_data('student'); ?>
                            <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id"  required="required" onchange="get_section_subject_by_class(this.value,'','');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($classes as $obj) { ?>
                                    <?php if(isset($classes) && !empty($classes)) { ?>
                                    <?php if($this->session->userdata('role_id') == TEACHER && !in_array($obj->id, $teacher_student_data)){ continue; } ?>   
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                    <?php } ?>
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
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('subject'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="subject_id" id="subject_id" required="required" onchange="get_lesson_by_subject(this.value,'','');">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('subject_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('lesson'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12 gsms-nice-select"  name="lesson_detail_id"  id="lesson_detail_id" required="required" onchange="get_topic_by_lesson(this.value,'','');">                           
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                             
                                        </select>
                            <div class="help-block"><?php echo form_error('lesson_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('topic'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12 gsms-nice-select"  name="topic_detail_id"  id="topic_detail_id" required="required" onchange="get_activity_by_topic(this.value,'','');"> 
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                             
                                        </select>
                            <div class="help-block"><?php echo form_error('topic_details_id'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('AOI'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12 gsms-nice-select"  name="activity_id"  id="activity_id" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                             
                                        </select>
                            <div class="help-block"><?php echo form_error('question'); ?></div>
                        </div>
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

           <?php  if (isset($students) && !empty($students)) { ?>
            <div class="x_content">             
                <div class="row">
                    <div class="col-sm-4  col-sm-offset-4 layout-box">
                        <p>
                            <h4><?php echo $this->lang->line('AOI'); ?></h4>                            
                        </p>
                    </div>
                </div>            
            </div>
             <?php } ?>
            
            <div class="x_content">
                 <?php echo form_open(site_url('exam/markaoi/add'), array('name' => 'addmark', 'id' => 'addmark', 'class'=>'form-horizontal form-label-left'), ''); ?>
               
                
                  <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="2"><?php echo $this->lang->line('roll_no'); ?></th>
                            <th rowspan="2"><?php echo $this->lang->line('name'); ?></th>
                            <th rowspan="2"><?php echo $this->lang->line('photo'); ?></th>
                            <th colspan="12" style="text-align: center;"><?php echo $this->lang->line('AOI'); ?></th>                                            
                                                                       
                        </tr>
                        <tr>                           
                            <th><?php echo $this->lang->line('mark'); ?></th>                                            
                            <th><?php echo $this->lang->line('obtain'); ?></th>                                            
                            <th><?php echo $this->lang->line('score'); ?></th>                                            
                            <th><?php echo $this->lang->line('descriptor'); ?></th>                                            
                            <th><?php echo $this->lang->line('out_of_ten'); ?></th>                                            
                            <th><?php echo $this->lang->line('skill'); ?></th>                                            
                            <th><?php echo $this->lang->line('strengths'); ?></th>                                                                                     
                                                                      
                        </tr>
                    </thead>
                    <tbody id="fn_mark">   
                        <?php
                        $count = 1;
                        if (isset($students) && !empty($students)) {
                            ?>
                            <?php foreach ($students as $obj) { ?>
                            <?php  $mark_aoi = get_exam_mark($school_id, $obj->student_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id); ?>
                            <?php  $attendance = get_exam_attendance($school_id, $obj->student_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id); ?>
                                <tr>
                                    <td><?php echo $obj->roll_no; ?></td>
                                    <td><?php echo ucfirst($obj->student_name); ?></td>
                                    <td>
                                        <?php if ($obj->photo != '') { ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $obj->photo; ?>" alt="" width="40" /> 
                                        <?php } else { ?>
                                            <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="40" /> 
                                        <?php } ?>
                                    </td>  
                                    <td>
                                        <input type="hidden" value="<?php echo $obj->student_id; ?>"  name="students[]" />                                       
                                        <input type="number" id="written_mark_<?php echo $obj->student_id; ?>" itemid="<?php echo $obj->student_id; ?>" value="<?php if(!empty($mark_aoi) && $mark_aoi->written_mark > 0){ echo $mark_aoi->written_mark; }else{ echo '';} ?>"  name="written_mark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total" required="required"  autocomplete="off"/>
                                    </td>
                                    <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="number"  id="written_obtain_<?php echo $obj->student_id; ?>"  itemid="<?php echo $obj->student_id; ?>"  value="<?php if(!empty($mark_aoi) && $mark_aoi->written_obtain > 0 ){ echo $mark_aoi->written_obtain; }else{ echo ''; } ?>"  name="written_obtain[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total"   autocomplete="off"/>
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="number" value="0"  name="written_obtain[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12" />
                                        <?php } ?>
                                    </td>
                                    
                                    <td>
                                        <input type="number"  id="activity_score_<?php echo $obj->student_id; ?>" itemid="<?php echo $obj->student_id; ?>"  value="<?php if(!empty($mark_aoi) && $mark_aoi->written_mark  > 0){ echo $mark_aoi->written_mark ; }else{ echo '';} ?>"  name="activity_score [<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total"   autocomplete="off"/>
                                    </td>
                                    <td>
                                        <?php if(!empty($attendance)){ ?>
                                        <input type="text"  id="activity_descriptor_<?php echo $obj->student_id; ?>" itemid="<?php echo $obj->student_id; ?>"   value="<?php if(!empty($mark_aoi) && $mark_aoi->written_mark  > 0 ){ echo $mark_aoi->written_mark ; }else{ echo ''; } ?>"  name="activity_descriptor [<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total"  autocomplete="off"/>
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="number" value="0"  name="activity_descriptor [<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"  />
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <input type="number"  id="exam_total_mark_<?php echo $obj->student_id; ?>"  value="<?php if(!empty($mark_aoi) && $mark_aoi->exam_total_mark > 0){ echo $mark_aoi->exam_total_mark; }else{ echo '';} ?>"name="exam_total_mark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total"  autocomplete="off"/>
                                    </td>
                                    <td>
                                        <textarea type="text"  id="activity_skill_<?php echo $obj->student_id; ?>" itemid="<?php echo $obj->student_id; ?>"  value="<?php if(!empty($mark_aoi) && $mark_aoi->written_mark > 0){ echo $mark_aoi->written_mark; }else{ echo '';} ?>"  name="activity_skill[<?php echo $obj->student_id; ?>]" class="form-control col-md-7 form-mark col-xs-12 fn_mark_total"   autocomplete="off"></textarea>
                                    </td>
                                    <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <textarea type="text"  id="activity_strengths_<?php echo $obj->student_id; ?>" itemid="<?php echo $obj->student_id; ?>"   value="<?php if(!empty($mark_aoi) && $mark_aoi->written_mark > 0 ){ echo $mark_aoi->written_mark; }else{ echo ''; } ?>"  name="activity_strengths[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total"   autocomplete="off"></textarea>
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="number" value="0"  name="activity_strengths[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"  autocomplete="off"/>
                                        <?php } ?>
                                    </td>
                                    
                                    <!-- <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="number"  id="viva_obtain_<?php echo $obj->student_id; ?>" itemid="<?php echo $obj->student_id; ?>"  value="<?php if(!empty($mark_aoi) && $mark_aoi->viva_obtain > 0 ){ echo $mark_aoi->viva_obtain; }else{ echo ''; } ?>"  name="viva_obtain[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total"   autocomplete="off"/>
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="number" value="0"  name="viva_obtain[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"   autocomplete="off"/>
                                        <?php } ?>
                                    </td>                                    
                                    <td>
                                        <input type="number"  id="exam_total_mark_<?php echo $obj->student_id; ?>" value="<?php if(!empty($mark) && $mark->exam_total_mark > 0){ echo $mark->exam_total_mark; }else{ echo '';} ?>"  name="exam_total_mark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"  autocomplete="off" />
                                    </td>
                                    <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="number"  id="obtain_total_mark_<?php echo $obj->student_id; ?>" value="<?php if(!empty($mark) && $mark->obtain_total_mark > 0 ){ echo $mark->obtain_total_mark; }else{ echo ''; } ?>"  name="obtain_total_mark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"  autocomplete="off"/>
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="number" value="0"  name="obtain_total_mark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12" required="required"  autocomplete="off"/>
                                        <?php } ?>
                                    </td>                                    
                                    <td>
                                        <select  class="form-control col-md-7 col-xs-12" name="grade_id[<?php echo $obj->student_id; ?>]"  required="required">                                
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                             <?php foreach ($grades as $grade) { ?>
                                            <option value="<?php echo $grade->id; ?>" <?php if(isset($mark) && $mark->grade_id == $grade->id){ echo 'selected="selected"';} ?>><?php echo $grade->name; ?> [<?php echo $grade->point; ?>]</option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <?php if(!empty($attendance)){ ?>
                                            <input type="text"  id="remark_<?php echo $obj->student_id; ?>" value="<?php if(!empty($mark) && $mark->remark != '' ){ echo $mark->remark; }else{ echo ''; } ?>"  name="remark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"  autocomplete="off"/>
                                        <?php }else{ ?>
                                            <input readonly="readonly" type="text" value=""  name="remark[<?php echo $obj->student_id; ?>]" class="form-control form-mark col-md-7 col-xs-12"   autocomplete="off"/>
                                        <?php } ?>
                                    </td> -->
                                </tr>
                            <?php } ?>
                        <?php }else{ ?>
                                <tr>
                                    <td colspan="15" align="center"><?php echo $this->lang->line('no_data_found'); ?></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-5">
                        <?php  if (isset($students) && !empty($students)) { ?>
                            <input type="hidden" value="<?php echo $school_id; ?>"  name="school_id" />
                            <input type="hidden" value="<?php echo $exam_id; ?>"  name="exam_id" />
                            <input type="hidden" value="<?php echo $class_id; ?>"  name="class_id" />
                            <input type="hidden" value="<?php echo $section_id; ?>"  name="section_id" />
                            <input type="hidden" value="<?php echo $subject_id; ?>"  name="subject_id" />                        
                            <a href="<?php echo site_url('exam/markaoi/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                           <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                        <?php } ?>
                    </div>
                </div>
                 <?php echo form_close(); ?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="instructions"><strong><?php echo $this->lang->line('instruction'); ?>: </strong> <?php echo $this->lang->line('exam_mark_instruction'); ?></div>
                </div>
            </div> 
            
        </div>
    </div>
</div>
 
<!-- Super admin js START  -->
 <script type="text/javascript">
        
    $("document").ready(function() {
         <?php if(isset($school_id) && !empty($school_id)){ ?>               
            $(".fn_school_id").trigger('change');
         <?php } ?>
    });
    
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();
        var exam_id = '';
        var class_id = '';
        
        <?php if(isset($school_id) && !empty($school_id)){ ?>
            exam_id =  '<?php echo $exam_id; ?>';           
            class_id =  '<?php echo $class_id; ?>';           
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
        get_section_subject_by_class('<?php echo $class_id; ?>', '<?php echo $section_id; ?>', '<?php echo $subject_id; ?>,'<?php echo $lesson_detail_id; ?>','<?php echo $topic_detail_id; ?>','<?php echo $activity_id; ?>'');
    <?php } ?>
    
    function get_section_subject_by_class(class_id, section_id, subject_id,lesson_detail_id,topic_detail_id,activity_id){       
        
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
        // $.ajax({       
        //     type   : "POST",
        //     url    : "<?php echo site_url('ajax/get_lesson_by_class'); ?>",
        //     data   : {school_id:school_id, class_id : class_id , subject_id: subject_id, lesson_detail_id: lesson_detail_id},               
        //     async  : false,
        //     success: function(response){                                                   
        //        if(response)
        //        {
        //           $('#lesson_detail_id').html(response);
        //        }
        //     }
        // }); 
        // $.ajax({       
        //     type   : "POST",
        //     url    : "<?php echo site_url('ajax/get_topic_by_class'); ?>",
        //     data   : {school_id:school_id, class_id : class_id , subject_id: subject_id, lesson_detail_id: lesson_detail_id, topic_detail_id: topic_detail_id},               
        //     async  : false,
        //     success: function(response){                                                   
        //        if(response)
        //        {
        //           $('#topic_detail_id').html(response);
        //        }
        //     }
        // });  
        // $.ajax({       
        //     type   : "POST",
        //     url    : "<?php echo site_url('ajax/get_activity_by_class'); ?>",
        //     data   : {school_id:school_id, class_id : class_id , subject_id: subject_id, lesson_detail_id: lesson_detail_id, topic_detail_id: topic_detail_id,activity_id: activity_id},               
        //     async  : false,
        //     success: function(response){                                                   
        //        if(response)
        //        {
        //           $('#activity_id').html(response);
        //        }
        //     }
        // });        
    }
    <?php if(isset($mark_aoi)){?>
        get_lesson_by_subject('<?php echo $mark_aoi->subject_id; ?>', '<?php echo $mark_aoi->lesson_detail_id; ?>', 'edit_');
    <?php } ?>
    function get_lesson_by_subject(subject_id,lesson_detail_id){       
        
        var school_id = $('#school_id').val();      
             
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        } 
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_lesson_by_subject'); ?>",
            data   : {school_id:school_id, subject_id : subject_id , lesson_detail_id : lesson_detail_id},                   
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#lesson_detail_id').html(response);
               }
            }
        }); 
             
    }
    <?php if(isset($mark_aoi)){?>
        get_topic_by_lesson('<?php echo $mark_aoi->lesson_detail_id; ?>', '<?php echo $mark_aoi->topic_detail_id; ?>', 'edit_');
    <?php } ?>
    function get_topic_by_lesson(lesson_detail_id,topic_detail_id){       
        
        var school_id = $('#school_id').val();      
             
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        } 
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_topic_by_lesson'); ?>",
            data   : {school_id:school_id, lesson_detail_id : lesson_detail_id,topic_detail_id : topic_detail_id },                   
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#topic_detail_id').html(response);
               }
            }
        }); 
             
    }
    <?php if(isset($mark_aoi)){?>
        get_activity_by_topic('<?php echo $mark_aoi->topic_details_id; ?>', '<?php echo $mark_aoi->activity_id; ?>', 'edit_');
    <?php } ?>
    function get_activity_by_topic(topic_details_id,activity_id){       
        
        var school_id = $('#school_id').val();      
             
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        } 
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_activity_by_topic'); ?>",
            data   : {school_id:school_id,topic_details_id : topic_details_id,activity_id : activity_id},                   
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#activity_id').html(response);
               }
            }
        }); 
             
    }
  
    $(document).ready(function(){
  
  $('.fn_mark_total').keyup(function(){         
       var student_id = $(this).attr('itemid');
     var written_mark       = $('#written_mark_'+student_id).val() ?  parseFloat($('#written_mark_'+student_id).val()) : 0;
     var written_obtain     = $('#written_obtain_'+student_id).val() ? parseFloat($('#written_obtain_'+student_id).val()) : 0;
     var tutorial_mark      = $('#tutorial_mark_'+student_id).val() ? parseFloat($('#tutorial_mark_'+student_id).val()) : 0;
     var tutorial_obtain    = $('#tutorial_obtain_'+student_id).val() ? parseFloat($('#tutorial_obtain_'+student_id).val()) : 0;
     var practical_mark     = $('#practical_mark_'+student_id).val() ? parseFloat($('#practical_mark_'+student_id).val()) : 0;
     var practical_obtain   = $('#practical_obtain_'+student_id).val() ? parseFloat($('#practical_obtain_'+student_id).val()) : 0;
     var viva_mark          = $('#viva_mark_'+student_id).val() ? parseFloat($('#viva_mark_'+student_id).val()) : 0;
     var viva_obtain        = $('#viva_obtain_'+student_id).val() ? parseFloat($('#viva_obtain_'+student_id).val()) : 0;
     
     $('#exam_total_mark_'+student_id).val(written_obtain/written_mark)*10;
     $('#obtain_total_mark_'+student_id).val(written_obtain+tutorial_obtain+practical_obtain+viva_obtain);
                         
  }); 
 
}); 
 $("#mark_aoi").validate();  
 $("#addmark").validate();  
</script>
<style>
#datatable-responsive label.error{display: none !important;}
</style>



