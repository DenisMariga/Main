<span><?php echo $this->lang->line('quick_link'); ?>:</span>

<?php if(has_permission(VIEW, 'exam', 'mark')){ ?>
   | <a href="<?php echo site_url('exam/mark/index'); ?>"><?php echo $this->lang->line('manage_mark'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'exam', 'markaoi')){ ?>
   | <a href="<?php echo site_url('exam/markaoi/index'); ?>"><?php echo $this->lang->line('manage_aoi'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'exam', 'project_marks')){ ?>
   | <a href="<?php echo site_url('exam/projectmark/index'); ?>"><?php echo $this->lang->line('manage_project'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'exam', 'examresult')){ ?>
   | <a href="<?php echo site_url('exam/examresult/index'); ?>"><?php echo $this->lang->line('exam_term_result'); ?></a>                 
<?php } ?>
<?php if(has_permission(VIEW, 'exam', 'finalresult')){ ?>
   | <a href="<?php echo site_url('exam/finalresult/index'); ?>"><?php echo $this->lang->line('exam_final_result'); ?></a>                 
<?php } ?>
<?php if(has_permission(VIEW, 'exam', 'activityaverage')){ ?>
   | <a href="<?php echo site_url('exam/activityaverage/index'); ?>"><?php echo $this->lang->line('activity_average'); ?></a>                 
<?php } ?>
<?php if(has_permission(VIEW, 'exam', 'meritlist')){ ?>
   | <a href="<?php echo site_url('exam/meritlist/index'); ?>"><?php echo $this->lang->line('merit_list'); ?></a>                 
<?php } ?>   
<?php if(has_permission(VIEW, 'exam', 'marksheet')){ ?>
   | <a href="<?php echo site_url('exam/marksheet/index'); ?>"><?php echo $this->lang->line('mark_sheet'); ?></a>
<?php } ?>
 <?php if(has_permission(VIEW, 'exam', 'resultcard')){ ?>
   | <a href="<?php echo site_url('exam/resultcard/index'); ?>"><?php echo $this->lang->line('result_card'); ?></a>
<?php } ?>   
 <?php if(has_permission(VIEW, 'exam', 'formativecard')){ ?>
   | <a href="<?php echo site_url('exam/formativecard/index'); ?>"><?php echo $this->lang->line('formative_card'); ?></a>
<?php } ?>   
<?php if(has_permission(VIEW, 'exam', 'resultcard')){ ?>
   | <a href="<?php echo site_url('exam/resultcard/all'); ?>"><?php echo $this->lang->line('all_result_card'); ?></a>
<?php } ?>     
<?php if(has_permission(VIEW, 'exam', 'formativecard')){ ?>
   | <a href="<?php echo site_url('exam/formativecard/all'); ?>"><?php echo $this->lang->line('all_formative_card'); ?></a>
<?php } ?>     
<?php if(has_permission(VIEW, 'exam', 'mail')){ ?>
   | <a href="<?php echo site_url('exam/mail/index'); ?>"><?php echo $this->lang->line('mark_send_by_email'); ?></a>                    
<?php } ?>
<?php if(has_permission(VIEW, 'exam', 'text')){ ?>
   | <a href="<?php echo site_url('exam/text/index'); ?>"><?php echo $this->lang->line('mark_send_by_sms'); ?></a>                  
<?php } ?>
<?php if(has_permission(VIEW, 'exam', 'resultemail')){ ?>
   | <a href="<?php echo site_url('exam/resultemail/index'); ?>"> <?php echo $this->lang->line('result_email'); ?></a>                    
<?php } ?>
<?php if(has_permission(VIEW, 'exam', 'resultsms')){ ?>
   | <a href="<?php echo site_url('exam/resultsms/index'); ?>"> <?php echo $this->lang->line('result_sms'); ?></a>                  
<?php } ?>