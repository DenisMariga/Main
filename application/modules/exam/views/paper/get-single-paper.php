<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
         <tr>
            <th width="20%"> <?php echo $this->lang->line('school_name'); ?> </th>
            <td><?php echo $paper->school_name; ?></td>
        </tr> 
         <tr>
            <th> <?php echo $this->lang->line('academic_year'); ?> </th>
            <td><?php echo $paper->session_year; ?></td>
        </tr> 
        
        <tr>
            <th width="20%"> <?php echo $this->lang->line('class'); ?> </th>
            <td><?php echo $paper->class_name; ?></td>
        </tr>  
        
        <tr>
            <th><?php echo $this->lang->line('subject'); ?></th>
            <td><?php echo $paper->subject; ?></td>
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('paper'); ?></th>
            <td>                
                <?php foreach($paper_details as $obj){ ?>
                       <?php echo $obj->Ptitle; ?><br/>
                <?php } ?>
            </td>  
        </tr>
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $paper->note; ?></td>
        </tr>             
    </tbody>
</table>