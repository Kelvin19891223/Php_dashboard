<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
   <head>
      <style type="text/css">
         .un {text-decoration: none; }
      </style>
      <script src="<?php echo base_url();?>assets/js/jquery-1.11.2.min.js"></script> 
      <script type = "text/javascript" src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
      <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
      <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/AdminLTE.min.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/skin-red.min.css" />
      <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
      <meta charset="UTF-8">
      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
            
      <script src="<?php echo base_url('assets/toast.js')?>"></script>
   </head>
   <body class="skin-red">
      <div class="wrapper">
         <header class="main-header">
           <a href="" style="text-decoration:none"class="un logo"><b>Moderation Software</b></a>
            <nav class="navbar navbar-static-top" role="navigation">
               <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
               <span class="sr-only">Toggle navigation</span>
               </a>
               <div class="navbar-custom-menu">
                  <ul class="nav navbar-nav">
                     <li class="">
                        <a href="<?php echo site_url('welcome/logout') ?>"> <i class="fa fa-sign-out"></i>Log out </a>
                     </li>
                  </ul>
               </div>
            </nav>
         </header>
         <?php $this->load->view('navigation_bar');?>      
         <div class="content-wrapper">
            <section class="content-header">
               <h1>
                  <small>Welcome</small>
               </h1>
            </section>
            <section class="content">
               <div class="row">
                  <div class="col-xs-12">
                     <div class="box">
                        <div class="box-header">
                        </div>
                        <div class="box-body">
                           <section class="content">
                              <?php $this->load->view('content'); ?>
                           </section>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
         </section><!-- /.content -->
         <footer class="main-footer">
            <div class="pull-right hidden-xs">
            </div>
            <strong>Copyright &copy; 2018 <a href="#">Unitec</a>.</strong> All rights reserved.
         </footer>
      </div>      
      <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.3.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url(); ?>assets/js/app.min.js" type="text/javascript"></script>

      <script>      
            //getNotify();
            function sleep(milliseconds) {
                  var start = new Date().getTime();
                  for (var i = 0; i < 1e7; i++) {
                        if ((new Date().getTime() - start) > milliseconds){
                              break;
                        }
                  }
            }
            function getNotify() {
                  url = "<?php echo site_url('setting/get_notify')?>";
                  $.ajax({
                        url : url,
                        type: "POST",
                        data: $('#form').serialize(),
                        dataType: "JSON",
                        success: function(data)
                        {                                                            
                              if(data) {
                                    for(i in data)   {                                          
                                          showAndroidToast(data[i]['reminder']);
                                    }
                              }
                              setTimeout(function(){ getNotify(); }, 600000);
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                              alert('Error adding / update data');
                        }
                  });
            }                             
            function showAndroidToast(message, options, transitions)
            {
                  var default_options = {
                        style: {
                              main: {
                                    display: "inline-block",
                                    backgroundColor: "rgba(0,0,0,0.9)",
                                    color: "white",
                                    padding: "10px 16px",
                                    borderRadius: "3px",
                                    margin: "5px auto",
                                    boxShadow: "0 0 5px rgba(0,0,0,0.5), 0 0 2px rgba(0,0,0,0.5)",
                                    "max-width": "300px",
                                    left: "calc(95% - 300px)"
                              }
                        },
                        settings: {
                              duration: 3000
                        }
                  };
                  iqwerty.toast.Toast(message, default_options, transitions);
            }
      </script>
   </body>
</html>