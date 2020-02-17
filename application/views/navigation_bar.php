<aside class="main-sidebar">
<section class="sidebar">
    <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=base_url().'uploads/nophoto.jpg';?>" class="img-circle" alt="User Image" />
        </div>
        <div class="pull-left info">
          <p></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <ul class="sidebar-menu">
          <li class="header">MAIN NAVIGATION</li>
          <?php if($email == 'admin@admin.com') { ?>
          <li><a class = "ayam" href="<?php echo base_url();?>assign/index"><i class="fa fa-users"></i>Assign Role</a></li>
          <li><a class = "ayam" href="<?php echo base_url();?>account/regist"><i class="fa fa-users"></i>Registration</a></li>
          <?php } ?>
          <li><a class = "ayam" href="<?php echo base_url();?>account/account"><i class="fa fa-users"></i>Settings</a></li>
          <li class="treeview">
              <a href="#" style="text-decoration:none">
                <i class="fa fa-users"></i>
                <span>Dashboard</span><i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <li>
                <a class = "ayam" href="<?php echo base_url();?>dashboard/form/1"><i class="fa fa-circle-o"></i>Taught
                </a>
              </li>
              <li>
                <a class = "ayam" href="<?php echo base_url();?>dashboard/form/2"><i class="fa fa-circle-o"></i>Moderate
                </a>
              </li>
            </ul>
          </li>
          <li class="treeview">
              <a href="#" style="text-decoration:none">
                <i class="fa fa-users"></i>
                <span >Assessment Form</span><i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
               <li>
                <a class = "ayam" href="<?php echo base_url();?>assessment/form/1"><i class="fa fa-circle-o"></i>Taught
                </a>
              </li>
              <li>
                <a class = "ayam" href="<?php echo base_url();?>assessment/form/2"><i class="fa fa-circle-o"></i>Moderate
                </a>
              </li>
            </ul>
          </li>
          <!-- <li><a class = "ayam" href="<?php echo base_url();?>setting/index"><i class="fa fa-users"></i>Setting the reminder</a></li> -->
    </ul>
</section>
</aside>

<script type="text/javascript">

    $(document).on('click','.ayam',function(){

        var href = $(this).attr('href');
        $('#haha').empty().load(href).fadeIn('slow');
        return false;

    });
</script>

<script type="text/javascript">
    $('.apam').removeClass('active');
</script>

<script>
    $(document).ready(function(){
        $( "body" ).on( "click", ".ayam", function() {
          $('.ayam').each(function(a){
            $( this ).removeClass('selectedclass')
          });
          $( this ).addClass('selectedclass');
        });
    })
</script>

<style type="text/css">
    li a.selectedclass
    {
      color: red !important;
      font-weight: bold;
    }
</style>