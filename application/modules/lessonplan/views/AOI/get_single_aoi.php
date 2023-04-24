<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
         <tr>
            <th width="20%"> <?php echo $this->lang->line('school_name'); ?> </th>
            <td><?php echo $aoi->school_name; ?></td>
        </tr> 
         <tr>
            <th width="20%"> <?php echo $this->lang->line('academic_year'); ?> </th>
            <td><?php echo $aoi->session_year; ?></td>
        </tr> 
        <tr>
            <th width="20%"> <?php echo $this->lang->line('class'); ?> </th>
            <td><?php echo $aoi->class_name; ?></td>
        </tr>       
     
        <tr>
            <th><?php echo $this->lang->line('subject'); ?></th>
            <td><?php echo $aoi->subject; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('lesson'); ?></th>
            <td><?php echo $aoi->Ltitle; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('topic'); ?></th>
            <td><?php echo $aoi->title; ?></td>
        </tr>
        <!-- <tr>
            <th><?php echo $this->lang->line('topic'); ?></th>
            <td>
               <?php foreach($aoi_details as $obj){ ?>
                       <?php echo $obj->title; ?><br/>
                <?php } ?>
            </td>
        </tr> -->
        <tr>
            <th><?php echo $this->lang->line('AOI'); ?></th>
            <td><?php echo $aoi->name; ?></td>
        </tr>  
        <tr>
            <th><?php echo $this->lang->line('Aoi_quiz'); ?></th>
            <td><?php echo $aoi->Question; ?></td>
        </tr>           
        <tr>
            <th><?php echo $this->lang->line('Competency'); ?></th>
            <td><?php echo $aoi->competency; ?></td>
        </tr>           
        <tr>
            <th><?php echo $this->lang->line('information'); ?></th>
            <td><?php echo $aoi->information; ?></td>
        </tr>           
    </tbody>
</table>