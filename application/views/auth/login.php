<!DOCTYPE html>
<html>
    <head>
        <title><?php echo isset($title) ? $title : 'CodeIgniter Login'; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSS -->    
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">  
        <link rel="stylesheet" href="<?php echo site_url('assets/css/auth.css');?>">
    </head>
    <body>
        <div class="container" id="main">    
            <div id="loginbox" style="margin-top:80px;" class="mainbox col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
                <div class="panel panel-primary" >
                    <div class="panel-heading">
                        <div class="panel-title">Login</div>                        
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <?php if(!empty(@$notif)){ ?>
                        <div id="login-alert" class="alert alert-<?php echo @$notif['type'];?> col-sm-12"><?php echo @$notif['message'];?></div>
                        <?php } ?>
                        
                        <form method="post" action="" class="form-horizontal" role="form">

                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="login-username" type="text" class="form-control" name="email" value="<?php echo $this->input->post('email');?>" placeholder="Email address">                                        
                            </div>

                            <div style="margin-bottom:7px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                            </div>

                            <div style="margin-top:15px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <input type="submit" class="btn btn-primary" value=" Login ">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 control">
                                    <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
                                        Not registered? <a href="<?php echo site_url('auth/register'); ?>">Create an account</a>
                                    </div>
                                </div>
                            </div>    
                        </form>     
                        
                    </div>                     
                </div>  
            </div>
        </div>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </body>
</html>


