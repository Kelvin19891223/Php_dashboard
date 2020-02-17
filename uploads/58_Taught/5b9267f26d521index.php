<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>
<div class = "row">
   <div class=""> 
     <?php 
      if($flag == '1') { 
      ?>  Taught Course <?php 
      } else if($flag=='2') { ?>
          Moderator Course <?php
      } ?>
    </div>
   <br />
   <br />
   <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
         <tr>
            <th>Course Name</th>
            <th>Teacher Name</th>            
            <th>Moderate Name</th>            
            <th style="width:189px;">Action</th>                              
         </tr>
      </thead>
      <tbody>
      <?php foreach ($output as $data): ?>
        <tr>
          <td><?php echo $data->course_name;?></td>
          <td><?php echo $data->teacher_name;?></td>
          <td><?php echo $data->moderator_name;?></td>
          <td><a class="ayam btn btn-sm btn-primary" title="Add Form" href="<?php echo base_url();?>assessment/assessment_form/<?php echo $data->id;?>"><i class="glyphicon glyphicon-pencil"></i> Add Form</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
   </table>
</div>
</div>  
<script>    
</script>
</body>
</html>