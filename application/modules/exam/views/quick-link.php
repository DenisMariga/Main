<span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'exam', 'grade')){ ?>
   | <a href="<?php echo site_url('exam/grade/index'); ?>"><?php echo $this->lang->line('exam_grade'); ?></a>
<?php } ?> 
<?php if(has_permission(VIEW, 'exam', 'paper')){ ?>
| <a href="<?php echo site_url('exam/paper/index'); ?>"><?php echo $this->lang->line('paper'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'exam', 'exam')){ ?>
   | <a href="<?php echo site_url('exam/index'); ?>"><?php echo $this->lang->line('exam_term'); ?></a>
<?php } ?> 
<?php if(has_permission(VIEW, 'exam', 'schedule')){ ?>
   | <a href="<?php echo site_url('exam/schedule/index'); ?>"><?php echo $this->lang->line('exam_schedule'); ?></a>
<?php } ?> 
<?php if(has_permission(VIEW, 'exam', 'suggestion')){ ?>
   | <a href="<?php echo site_url('exam/suggestion/index'); ?>"><?php echo $this->lang->line('exam_suggestion'); ?> </a>
<?php } ?> 
<?php if(has_permission(VIEW, 'exam', 'attendance')){ ?>
   | <a href="<?php echo site_url('exam/attendance/index'); ?>"><?php echo $this->lang->line('exam_attendance'); ?></a>                    
<?php } ?> 
<?php if(has_permission(VIEW, 'exam', 'grouping')){ ?>
   | <a href="<?php echo site_url('exam/grouping/index'); ?>"><?php echo $this->lang->line('project_grouping'); ?></a>                    
<?php } ?> 
<?php if(has_permission(VIEW, 'exam', 'paperattendance')){ ?>
   | <a href="<?php echo site_url('exam/paperattendance/index'); ?>"><?php echo $this->lang->line('manage_paper_attendance'); ?></a>                    
<?php } ?> 