<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet"> 
<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>

<style type="text/css">
    #buangLine {
        border: none;
        background-color: transparent;
        resize: none;
        outline: none;
    }
</style> 


<div class="box-header with-border">
    <div class="col-md-6">
        <h3 class="box-title">User Information</h3>
    </div>
</div>
<div id="signupalert" class="alert alert-danger">
    <span></span>
</div>

<?php foreach ($output as $data): ?>
    <form action="#" id="uform" class="form-horizontal">
        <div class="form-body">
            <div class="form-group">
                <label class="control-label col-md-3">First Name</label>
                <div class="col-md-9">
                    <input name="uid" placeholder="First Name" class="form-control" value="<?php echo $data->users_id; ?>" type="hidden">
                    <input name="firstName" placeholder="First Name" class="form-control" value="<?php echo $data->first_name; ?>" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Last Name</label>
                <div class="col-md-9">
                    <input name="lastName" placeholder="Last Name" class="form-control" value="<?php echo $data->last_name; ?>" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Username</label>
                <div class="col-md-9">
                    <input name="username" placeholder="Username" class="form-control" value="<?php echo $data->username; ?>" readonly="true" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Email</label>
                <div class="col-md-9">
                    <input name="email" placeholder="Email" class="form-control" value="<?php echo $data->email; ?>" type="email">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Phone</label>
                <div class="col-md-9">
                    <input name="phone" placeholder="00000000000" class="form-control" value="<?php echo $data->phone; ?>" type="tel">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Password</label>
                <div class="col-md-9">
                    <input name="password" placeholder="" class="form-control" value="<?php echo $data->password; ?>" type="password">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Confirm Password</label>
                <div class="col-md-9">
                    <input name="confirm_password" placeholder="" class="form-control" value="<?php echo $data->password; ?>" type="password">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Address</label>
                <div class="col-md-9">
                    <textarea name="address" placeholder="Address" class="form-control"><?php echo $data->address; ?></textarea>
                </div>
            </div>
            <!-- <div class="form-group">
                <label class="control-label col-md-3">Date of Birth</label>
                <div class="col-md-9">
                    <input name="dob" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text" value="<?php echo $data->dob; ?>">
                </div>
            </div> -->
        </div>
    </form>
<?php endforeach; ?>
<div class="modal-footer">
    <button type="button" id="btnSave" onclick="account_save()" class="btn btn-primary">Save</button>
</div>
<!-- /.box -->
<script>    
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

    function account_save() {
        var url;
        url = "<?php echo site_url('account/update')?>";

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#uform').serialize(),
            dataType: "JSON",
            success: function(data) {
                if (data.status == 'success') {
                    $("#signupalert").html("Success");
                } else {
                    $("#signupalert").html(data.message);
                    //alert(data.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
            }
        });
    }
</SCRIPT>

<div class = "row">
   <div class="">Reminder Setting</div>
   <br />
   <br />
   <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
         <tr>
            <th>Course Name</th>
            <th>Last Assessment Pre Moderated</th>
            <th>Last Assessment Post Moderated</th>                                 
            <th>Pre Reminder</th>            
            <th>Post Reminder</th>            
         </tr>
      </thead>
      <tbody>
      <?php foreach ($output1 as $data): ?>
        <tr>
          <td><?php echo $data->course_name;?></td>
          <td><?php echo $data->assessment_release_date;?></td>
          <td><?php echo $data->submission_due_date;?></td>
          <td style="width:120px;text-align:center;">
            <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_reminder(1,<?php echo $data->id;?>)"><i class="glyphicon glyphicon-pencil"></i> Edit</a>            
          </td>
          <td style="width:120px;text-align:center;">
            <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_reminder(2,<?php echo $data->id;?>)"><i class="glyphicon glyphicon-pencil"></i> Edit</a>            
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
   </table>
</div>
</div>  
<div class="modal fade" id="modal_form" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Setting Reminder</h3>
         </div>
         <div class="modal-body form">
            <form action="#" id="form" class="form-horizontal">
               <input type="hidden" value="" name="id"/> 
               <input type="hidden" value="" name="flag"/> 
               <div class="form-body">
                  <div class="form-group">
                     <label class="control-label col-md-3">Reminder Day</label>
                     <div class="col-md-9">
                      <select name="reminder_day" class="form-control" type="text">
                        <option value="7">1 week</option>
                        <option value="14">2 week</option>
                        <option value="21">3 week</option>
                        <option value="28">4 week</option>
                        <option value="35">5 week</option>
                      </select>
                     </div>
                  </div>                  
               </div>
               <div class="form-body">
                  <div class="form-group">
                     <label class="control-label col-md-3">Reminder</label>
                     <div class="col-md-9">
                        <textarea class="form-control" rows="5" id="reminder" name='reminder'></textarea>
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
<script>
 $('.datepicker').datepicker({
      autoclose: true,
      format: "yyyy-mm-dd",
      todayHighlight: true,
      orientation: "top auto",
      todayBtn: true,
      todayHighlight: true,  
  });
function edit_reminder(type,id)
  {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
  
    //Ajax Load data from ajax
    $.ajax({
      url : "<?php echo site_url('setting/get_course_info/')?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
          $('[name="id"]').val(data.id);
          $('[name="flag"]').val(type);
          if(type==1) {
            $('[name="reminder"]').val(data.pre_reminder);
            $('[name="reminder_day"]').val(data.pre_reminder_day);
          } else {
            $('[name="reminder"]').val(data.post_reminder);
            $('[name="reminder_day"]').val(data.post_reminder_day);
          }          
          $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Edit Role'); // Set title to Bootstrap modal title
          
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error get data from ajax');
        }
      });
  }

function save()
{
    var url;
    
    url = "<?php echo site_url('setting/update')?>";
    
  
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
</script>