<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-bars"></i><small> <?php echo $this->lang->line('manage_AOI'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content quick-link">
                 <?php $this->load->view('quick-link'); ?>  
            </div>
            
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs  nav-tab-find  bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_aoi_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        
                        <?php if(has_permission(ADD, 'lessonplan', 'aoi')){ ?>
                             <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('lessonplan/aoi/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> </a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_aoi"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?> </a> </li>                          
                             <?php } ?>
                        <?php } ?> 
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_aoi"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                        <?php } ?> 
                            
                               
                        <li class="li-class-list">
                            
                            <?php $guardian_class_data = get_guardian_access_data('class'); ?>
                            <?php $teacher_access_data = get_teacher_access_data(); ?> 
                            
                            <?php echo form_open(site_url('lessonplan/aoi/index'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>
                                    
                                    <select  class="form-control col-md-7 col-xs-12" style="width:auto;" name="school_id" id="school_id" onchange="get_class_by_school(this.value, '', '');">
                                            <option value="">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                        <?php foreach($schools as $obj ){ ?>
                                            <option value="<?php echo $obj->id; ?>" <?php if(isset($school_id) && $school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                        <?php } ?>   
                                    </select>


                                    <select  class="form-control col-md-7 col-xs-12" id="class_id" name="class_id" onchange="get_subject_by_class(this.value, '', '');" style="width:auto;">
                                         <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                         
                                    </select>  


                                    <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_" name="subject_id" id="subject_id" style="width: auto;">                                
                                        <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                  
                                    </select>   
                            
                                 <?php }else{  ?>
                            
                                    <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_" name="class_id" id="class_id" onchange="get_subject_by_class(this.value, '', '');" style="width: auto;">
                                        <?php if($this->session->userdata('role_id') != STUDENT){ ?>
                                        <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                        <?php } ?>  
                                        <?php foreach($classes as $obj ){ ?>
                                            <?php if($this->session->userdata('role_id') == STUDENT ){ ?>
                                                <?php if ($obj->id != $this->session->userdata('class_id')){ continue; } ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                                <?php }elseif($this->session->userdata('role_id') == GUARDIAN){ ?>                                            
                                                     <?php if (!in_array($obj->id, $guardian_class_data)) { continue; } ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                                <?php }elseif($this->session->userdata('role_id') == TEACHER){ ?>                                            
                                                     <?php if (!in_array($obj->id, $teacher_access_data)) { continue; } ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                                <?php } ?>                                           
                                        <?php } ?>                                                
                                    </select> 
                                    <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_" name="subject_id" id="subject_id" style="width: auto;">                                
                                        <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php if($this->session->userdata('role_id') == STUDENT){ ?>                                       
                                                <?php foreach($subjects as $obj ){ ?>
                                                    <option value="<?php $obj->id; ?>" <?php if(isset($subject_id) && $subject_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                                <?php } ?>                                            
                                            <?php } ?>                                                                                     
                                    </select> 
                            
                               <?php } ?>
                                <input type="submit" name="find" value="<?php echo $this->lang->line('find'); ?>"  class="btn btn-success btn-sm"/>
                            <?php echo form_close(); ?>
                        </li>                            
                            
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_aoi_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>    
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>   
                                        <th><?php echo $this->lang->line('academic_year'); ?></th>
                                        <th> <?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('subject'); ?> </th>
                                        <th><?php echo $this->lang->line('lesson'); ?> </th>
                                        <th><?php echo $this->lang->line('topic'); ?> </th>
                                        <th><?php echo $this->lang->line('AOI'); ?> </th>
                                        <th><?php echo $this->lang->line('Aoi_quiz'); ?> </th>
                                        <th><?php echo $this->lang->line('action'); ?> </th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                          
                                    <?php $count = 1; if(isset($aoiList) && !empty($aoiList)){ ?>
                                        <?php foreach($aoiList as $obj){ ?> 
                                     <?php 
                                            if($this->session->userdata('role_id') == GUARDIAN){
                                                if (!in_array($obj->class_id, $guardian_class_data)) { continue; }
                                            }elseif($this->session->userdata('role_id') == STUDENT){
                                                if ($obj->class_id != $this->session->userdata('class_id')){ continue; }                                          
                                            }elseif($this->session->userdata('role_id') == TEACHER){
                                                if ($obj->teacher_id != $this->session->userdata('profile_id')) { continue; }
                                            }
                                        ?>     
                                        <tr>
                                            <td><?php echo $count++; ?></td>  
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                                
                                            <?php } ?>
                                            <td><?php echo $obj->session_year; ?></td>
                                            <td><?php echo $obj->class_name; ?></td>
                                            <td><?php echo $obj->subject; ?></td>
                                            <td><?php echo $obj->Ltitle; ?></td>
                                            <td><?php echo $obj->title; ?></td>

                                          

                                             
                                            <td>                                                
                                                <?php $aoi_list = get_aoi_detail_by_aoi_id($obj->id); ?>                                                
                                                <?php if(isset($aoi_list) && !empty($aoi_list)){ ?>
                                                <?php foreach($aoi_list AS $ad){ ?>
                                                        <?php echo $ad->name; ?><br/>
                                                <?php } } ?>
                                            </td>
                                            <td>                                                
                                                <?php $aoi_list = get_aoi_detail_by_aoi_id($obj->id); ?>                                                
                                                <?php if(isset($aoi_list) && !empty($aoi_list)){ ?>
                                                <?php foreach($aoi_list AS $ad){ ?>
                                                        <?php echo $ad->Question; ?><br/>
                                                <?php } } ?>
                                            </td>
                                            <td>                                                      
                                                <?php if(has_permission(EDIT, 'lessonplan', 'aoi')){ ?>
                                                    <a href="<?php echo site_url('lessonplan/aoi/edit/'.$obj->id); ?>" title="<?php echo $this->lang->line('edit'); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?> 
                                                 <?php if(has_permission(VIEW, 'lessonplan', 'aoi')){ ?>
                                                    <a  onclick="get_aoi_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-aoi-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>   
                                                <?php if(has_permission(DELETE, 'lessonplan', 'aoi')){ ?>    
                                                    <a href="<?php echo site_url('lessonplan/aoi/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_aoi">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('lessonplan/aoi/add'), array('name' => 'add', 'id' => 'add_aoi', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                 <?php $this->load->view('layout/school_list_form'); ?> 
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 gsms-nice-select"  name="class_id"  id="add_class_id" required="required"  onchange="get_subject_by_class(this.value, '', 'add_');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php if(isset($classes) && !empty($classes)){ ?>
                                                <?php foreach($classes as $obj ){ ?>
                                                   <?php
                                                    if($this->session->userdata('role_id') == TEACHER){
                                                       if (!in_array($obj->id, $teacher_access_data)) {continue; }
                                                    } 
                                                    ?>
                                                   <option value="<?php echo $obj->id; ?>" <?php echo isset($post['class_id']) && $post['class_id'] == $obj->id ?  'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>                                            
                                            <?php } ?>   
                                        </select>
                                        <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                    </div>
                                </div>
                                 
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="subject_id"><?php echo $this->lang->line('subject'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-12 col-xs-12 gsms-nice-select_"  name="subject_id"  id="add_subject_id" required="required"  onchange="get_lesson_by_subject(this.value, '', 'add_');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                        </select>
                                        <div class="help-block"><?php echo form_error('subject_id'); ?></div>
                                    </div>
                                </div>
                                 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lesson_detail_id"><?php echo $this->lang->line('lesson'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 gsms-nice-select"  name="lesson_detail_id"  id="add_lesson_detail_id" required="required" onchange="get_topic_by_lesson(this.value, '', 'add_');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                             
                                        </select>
                                        <div class="help-block"><?php echo form_error('lesson_detail_id'); ?></div>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="topic_details_id"><?php echo $this->lang->line('topic'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 gsms-nice-select"  name="topic_details_id"  id="add_topic_details_id" required="required">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                             
                                        </select>
                                        <div class="help-block"><?php echo form_error('topic_details_id'); ?></div>
                                    </div>
                                </div>
                                
                                 <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('AOI'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                         <table style="width:100%;" class="fn_add_aoi_container responsive">                                             
                                            <tr>               
                                                <td>
                                                    <input  class="form-control col-md-12 col-xs-12" style="width:90%;" type="text" name="name" placeholder="<?php echo $this->lang->line('AoI_title'); ?>" autocomplete="off" required="required"/>
                                                </td>
                                            </tr>                                           
                                          </table>
                                         
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="add Question"><?php echo $this->lang->line('add_question'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea required="required" class="form-control" name="Question" id="add_question" placeholder="<?php echo $this->lang->line('add_question'); ?>"><?php echo isset($post['Question']) ?  $post['question'] : '';  ?></textarea>
                                        <div class="help-block"><?php echo form_error('question'); ?></div>
                                    </div>
                                </div> 
                                                                                           
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('lessonplan/aoi/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                            <div  class="tab-pane fade in <?php if(isset($edit)){ echo 'active'; }?>" id="tab_edit_aoi">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('lessonplan/aoi/edit/'.$aoi->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                    <?php $this->load->view('layout/school_list_edit_form'); ?>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 gsms-nice-select"  name="class_id"  id="edit_class_id" required="required"  onchange="get_subject_by_class(this.value, '', 'edit_');" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php foreach($classes as $obj ){ ?>
                                                <?php
                                                if($this->session->userdata('role_id') == TEACHER){
                                                   if (!in_array($obj->id, $teacher_access_data)) {continue; }
                                                } 
                                                ?>
                                                <option value="<?php echo $obj->id; ?>" <?php if($obj->id == $aoi->class_id){ echo 'selected="selected"'; } ?>><?php echo $obj->name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                        </div>
                                    </div>
                                
                                    <div class="item form-group">  
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="subject_id"><?php echo $this->lang->line('subject'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-12 col-xs-12 gsms-nice-select_"  name="subject_id"  id="edit_subject_id" required="required" onchange="get_topic_by_subject(this.value, '', 'edit_');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                            </select>
                                            <div class="help-block"><?php echo form_error('subject_id'); ?></div>
                                        </div>
                                    </div>
                                
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lesson_detail_id"><?php echo $this->lang->line('lesson'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_"  name="lesson_detail_id"  id="edit_lesson_detail_id" required="required">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php if(isset($lessons) && !empty($lessons)){ ?>
                                                <?php foreach($lessons as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if($aoi->lesson_detail_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->title; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('lesson_detail_id'); ?></div>
                                        </div>
                                    </div>
                                
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="topic_details_id"><?php echo $this->lang->line('topic'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_"  name="topic_details_id"  id="edit_topic_details_id" required="required">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php if(isset($topics) && !empty($topics)){ ?>
                                                <?php foreach($topics as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if($aoi->topic_details_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->title; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('topic_details_id'); ?></div>
                                        </div>
                                    </div>
                                 
                                    <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('AOI'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                         <table style="width:100%;" class="fn_edit_aoi_container responsive">                                             
                                            <?php $couter = 1; foreach($aoi_details as $obj){ ?> 
                                            <tr>               
                                                <td>                                                  
                                                   <input type="hidden" name="aoi_id[]" value="<?php echo $obj->id; ?>" />
                                                   <input  class="form-control col-md-12 col-xs-12" style="width:90%;" type="text" name="name" value="<?php echo $obj->name; ?>" placeholder="<?php echo $this->lang->line('AOI'); ?>" autocomplete="off" />
                                              
                                                   <?php if($couter > 1){ ?>
                                                   <a  class="btn btn-danger btn-md " onclick="remove(this, <?php echo $obj->id; ?>);" style="margin-bottom: -0px;" > - </a>
                                                   <?php } ?>
                                                </td>
                                            </tr> 
                                            <?php $couter++; } ?>                                            
                                          </table>
                                        
                                    </div>
                                </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Aoi question"><?php echo $this->lang->line('add_question'); ?> </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea  class="form-control col-md-7 col-xs-12"  name="Question"  id="add_question"  placeholder="<?php echo $this->lang->line('add_question'); ?>"> <?php echo isset($aoi) ?  $aoi->Question : ''; ?></textarea>
                                            <div class="help-block"><?php echo form_error('question'); ?></div>
                                        </div>
                                    </div> 

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <input type="hidden" value="<?php echo isset($aoi) ? $aoi->id : $id; ?>" id="id" name="id" />
                                            <a  href="<?php echo site_url('lessonplan/aoi/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
                                        </div>
                                </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>  
                        <?php } ?>
                        
                    </div>
             
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bs-aoi-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
        <div class="modal-body fn_aoi_data">
            <!-- <p>This Modal Works Perfectly</p> -->
        </div>       
      </div>
    </div>
</div>


<!-- Begin Modal to display Single Record -->

<script type="text/javascript">
     
    function get_aoi_modal(aoi_id){
         
        $('.fn_aoi_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('lessonplan/aoi/get_single_aoi'); ?>",
          data   : {aoi_id : aoi_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_aoi_data').html(response);
             }
          }
       });
    }
</script>

<!-- End Modal to dispaly Single record -->

<!-- Begin Script to add more Button -->

<script type="text/javascript">

     function add_more(fn_aoi_container){
         var data = '<tr>'                
                    +'<td>'                   
                    +'<input  class="form-control col-md-12 col-xs-12" style="width:90%;" type="text" name="title[]" class="answer" placeholder="<?php echo $this->lang->line('aoi'); ?>" />' 
                    +'<a  class="btn btn-danger btn-md " onclick="remove(this);" style="margin-bottom: -0px;" > - </a>'
                    +'</td>'
                    +'</tr>';
            $('.'+fn_aoi_container).append(data);
     }
     
     function remove(obj, aoi_detail_id){ 
        
        if(aoi_detail_id)
        {
            if(confirm('<?php echo $this->lang->line('confirm_alert'); ?>')){
                $.ajax({       
                    type   : "POST",
                    url    : "<?php echo site_url('lessonplan/Aoi/remove'); ?>",
                    data   : { aoi_detail_id : aoi_detail_id},               
                    async  : false,
                    success: function(response){                                                   
                       if(response)
                       {
                          $(obj).parent().parent('tr').remove();   
                       }
                    }
                });   
            }            
        }else{
            
            $(obj).parent().parent('tr').remove(); 
        }
     }
        
</script>

<!-- End Script to add more Button -->

<!-- Super admin js START  -->
 <script type="text/javascript">
     
    $("document").ready(function() {
        <?php if(isset($edit) && !empty($edit)){ ?>
           $("#edit_school_id").trigger('change');
        <?php } ?>
    });
     
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();        
        var class_id = '';
        
        <?php if(isset($edit) && !empty($edit)){ ?>
            class_id =  '<?php echo $aoi->class_id; ?>';           
         <?php } ?> 
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id, class_id:class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                   if(class_id){
                       $('#edit_class_id').html(response);   
                   }else{
                       $('#add_class_id').html(response);   
                   }                  
               }
            }
        });
    }); 

  </script>
<!-- Super admin js end -->


 <script type="text/javascript">  

           
    <?php if(isset($post) && $post['school_id'] != ''){ ?>       
        get_class_by_school('<?php echo $post['school_id']; ?>', '<?php echo $post['class_id']; ?>', 'add_');        
    <?php } ?> 

   <?php if(isset($aoi) && !empty($aoi)){ ?>
        get_class_by_school('<?php echo $aoi->school_id; ?>', '<?php echo $aoi->class_id; ?>', 'edit_');
    <?php } ?>    

   <?php if(isset($school_id) && $school_id != '' && isset($class_id)){ ?>
        get_class_by_school('<?php echo $school_id; ?>', '<?php echo $class_id; ?>', '');
    <?php } ?>    
    
    function get_class_by_school(school_id, class_id, form){
        
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id : school_id, class_id : class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                     $('#'+form+'class_id').html(response);                    
               }
            }
        });
    }
    

    <?php if(isset($post) && $post['class_id'] != ''){ ?>       
        get_subject_by_class('<?php echo $post['class_id']; ?>', '<?php echo $post['subject_id']; ?>', 'add_');
    <?php } ?>
   <?php if(isset($aoi) && !empty($aoi)){  ?>
        get_subject_by_class('<?php echo $aoi->class_id; ?>', '<?php echo $aoi->subject_id; ?>', 'edit_');
    <?php } ?> 
    <?php if(isset($class_id) && $class_id != '' && isset($subject_id)){ ?>
        get_subject_by_class('<?php echo $class_id; ?>', '<?php echo $subject_id; ?>', '');
    <?php } ?>

        
    function get_subject_by_class(class_id, subject_id, form){       
           
        var school_id = $('#'+form+'school_id').val();       
        if(!school_id){
            school_id = '<?php echo $school_id; ?>';
        }   
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_subject_by_class'); ?>",
            data   : {school_id : school_id, class_id : class_id , subject_id : subject_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {                  
                   $('#'+form+'subject_id').html(response);                  
               }
            }
        });
   } 
        

   <?php if(isset($aoi)){?>
        get_lesson_by_subject('<?php echo $aoi->subject_id; ?>', '<?php echo $aoi->lesson_detail_id; ?>', 'edit_');
    <?php } ?>    
    function get_lesson_by_subject(subject_id, lesson_detail_id, form){       
        
        var school_id = $('#'+form+'school_id').val();       
             
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
        
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_lesson_by_subject'); ?>",
            data   : {school_id : school_id, subject_id : subject_id , lesson_detail_id : lesson_detail_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {                   
                 
                    $('#'+form+'lesson_detail_id').html(response);
                   
               }
            }
        });          
   }
   
//    #Get Topic by class

<?php if(isset($aoi)){?>
        get_topic_by_lesson('<?php echo $aoi->lesson_detail_id; ?>', '<?php echo $aoi->topic_details_id; ?>', 'edit_');
    <?php } ?>   
    
    function get_topic_by_lesson(lesson_detail_id, topic_details_id, form){       
        
        var school_id = $('#'+form+'school_id').val();       
             
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
        
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_topic_by_lesson'); ?>",
            data   : {school_id : school_id,  lesson_detail_id : lesson_detail_id,
            topic_details_id : topic_details_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {                   
                 
                    $('#'+form+'topic_details_id').html(response);
                   
               }
            }
        });          
   }
  
   $(document).ready(function() {
        $('#datatable-responsive').DataTable( {
            dom: 'Bfrtip',
            iDisplayLength: 15,
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                'pageLength'
            ],
            search: true,            
            responsive: true
        });
      });
      
    $("#add_aoi").validate();   
    $("#edit").validate();   

</script> 

