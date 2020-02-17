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
   <button class="btn btn-success" onclick="add_item()"><i class="glyphicon glyphicon-plus"></i> Add New Course</button>
   <br />
   <br />
   <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
         <tr>
            <th>Course Type</th>
            <th>Course Name</th>
            <th>Teacher Name</th>            
            <th>Moderate Name</th>            
            <th style="width:189px;">Action</th>
         </tr>
      </thead>
      <tbody>
      </tbody>
   </table>
</div>
</div>
<script type="text/javascript">
   var save_method; 
   var table;
   $(document).ready(function() {
     table = $('#table').DataTable({ 
       "processing": true, 
       "serverSide": true, 
       "ajax": {
         "url": "<?php echo site_url('assign/getlist')?>",
         "type": "POST"
       },
       "columnDefs": [
        { 
          "targets": [ -1 ], 
          "orderable": false, 
        },
       ],
   
     });
   });
   
   function add_item()
   {
     save_method = 'add';
     $('#form')[0].reset(); 
     $('#modal_form').modal('show'); 
     $('.modal-title').text('Add New Course'); 
   }
   
   function edit_item(id)
   {
     save_method = 'update';
     $('#form')[0].reset(); // reset form on modals  
     $.ajax({
       url : "<?php echo site_url('assign/getInfo/')?>/" + id,
       type: "GET",
       dataType: "JSON",
       success: function(data)
       {
           $('[name="id"]').val(data.id);
           $('[name="course_kind"]').val(data.course_kind);
           $('[name="course_name"]').val(data.course_name);
           $('[name="teacher_name"]').val(data.teacher_name);           
           $('[name="moderator_name"]').val(data.moderator_name);           
           $('[name="course_year"]').val(data.course_year);           
           $('[name="course_semester"]').val(data.course_semester);           

           $('#modal_form').modal('show'); 
           $('.modal-title').text('Edit New Course'); 
           
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
           alert('Error get data from ajax');
         }
       });
   }
   
   function reload_table()
   {
     table.ajax.reload(null,false); 
   }
   
   function save()
   {
     var url;
     if(save_method == 'add') 
     {
       url = "<?php echo site_url('assign/add')?>";
     }
     else
     {
       url = "<?php echo site_url('assign/update')?>";
     }
   
      // ajax adding data to database
      $.ajax({
       url : url,
       type: "POST",
       data: $('#form').serialize(),
       dataType: "JSON",
       success: function(data)
       {
              //if success close modal and reload ajax table
              $('#modal_form').modal('hide');
              reload_table();
              swal(
               'Success!',
               'Data has been save!',
               'success'
               )
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
             alert('Error adding / update data');
           }
         });
    }
   
    function delete_item(id)
    {
   
     swal({
       title: 'Are you sure?',
       text: "You won't be able to revert this!",
       type: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yes, delete it!',
       closeOnConfirm: false
    }).then(function(isConfirm) {
      if (isConfirm) {
   
        $.ajax({
          url : "<?php echo site_url('assign/delete')?>/"+id,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
                
            $('#modal_form').modal('hide');
            reload_table();
            swal(
              'Deleted!',
              'Your file has been deleted.',
              'success'
            );
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error adding / update data');
          }
        });
      }
    })   
  }
 
    //datepicker
   $('.datepicker').datepicker({
       autoclose: true,
       format: "yyyy-mm-dd",
       todayHighlight: true,
       orientation: "top auto",
       todayBtn: true,
       todayHighlight: true,  
   });
   
   
</script>
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Assign Role/h3>
         </div>
         <div class="modal-body form">
            <form action="#" id="form" class="form-horizontal">
               <input type="hidden" value="" name="id"/> 
               <div class="form-group">
                  <label class="control-label col-md-3">Course Kind</label>
                  <div class="col-md-9">
                    <select name="course_kind" class="form-control">
                      <option value="Taught">Taught</option>
                      <option value="Moderate">Moderate</option>
                    </select>
                  </div>
              </div>
               <div class="form-body">
                  <div class="form-group">
                     <label class="control-label col-md-3">Course Name</label>
                     <div class="col-md-9">
                        <input name="course_name" placeholder="Course Name" class="form-control" type="text">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="control-label col-md-3">Teacher name</label>
                     <div class="col-md-9">
                        <select name="teacher_name" class="form-control">
                            <?php foreach ($output as $data): ?>
                              <option value="<?php echo $data->username?>"><?php echo $data->username; ?></option>
                            <?php endforeach; ?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="control-label col-md-3">Moderator Name</label>
                     <div class="col-md-9">
                        <select name="moderator_name" class="form-control">
                          <?php foreach ($output as $data): ?>
                            <option value="<?php echo $data->username?>"><?php echo $data->username; ?></option>
                          <?php endforeach; ?>
                        </select>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="control-label col-md-3">Course Year</label>
                     <div class="col-md-9">
                        <input name="course_year" placeholder="Course Year" class="form-control" type="text">
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="control-label col-md-3">Course Semester</label>
                     <div class="col-md-9">
                        <input name="course_semester" placeholder="Course Semester" class="form-control" type="text">
                     </div>
                  </div>

               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
         </div>
      </div>      
   </div>   
</div>
</body>
</html>