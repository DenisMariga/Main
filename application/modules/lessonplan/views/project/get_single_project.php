<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
         <tr>
            <th width="20%"> <?php echo $this->lang->line('school_name'); ?> </th>
            <td><?php echo $project->school_name; ?></td>
        </tr> 
         <tr>
            <th width="20%"> <?php echo $this->lang->line('academic_year'); ?> </th>
            <td><?php echo $project->session_year; ?></td>
        </tr> 
        <tr>
            <th width="20%"> <?php echo $this->lang->line('class'); ?> </th>
            <td><?php echo $project->class_name; ?></td>
        </tr>       
     
        <tr>
            <th><?php echo $this->lang->line('subject'); ?></th>
            <td><?php echo $project->subject; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('Project'); ?></th>
            <td><?php echo $project->name; ?></td>
        </tr>  
        <tr>
            <th><?php echo $this->lang->line('Project_quiz'); ?></th>
            <td><?php echo $project->Question; ?></td>
        </tr>           
    </tbody>
</table>