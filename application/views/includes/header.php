
<?php
if($this->session->userdata('lang')=="english"){

  $lang['title']="User Management";
  $lang['title_small']="Add user";
  $lang['side_dashboard']="Dashboard";
  $lang['side_mytask']="Tasks";
  $lang['side_user']="Users";
  $lang['last_login']="Last Login";
  
  
  
}elseif($this->session->userdata('lang')=="persion"){
  
  $lang['title']="مدیریت کاربران";
  $lang['title_small']="اضافه کردن کاربر";
  $lang['side_dashboard']="داشبرد";
  $lang['side_mytask']="وظایف";
  $lang['side_user']="کاربران";
  $lang['last_login']="آخرین ورود"; 
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $pageTitle; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <style>
    	.error{
    		color:red;
    		font-weight: normal;
    	}
    </style>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->  
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <!-- Font Awesome -->  
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/font-awesome/css/font-awesome.min.css') ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/Ionicons/css/ionicons.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/rtl.css') ?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css') ?>">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/morris.js/morris.css') ?>">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/jvectormap/jquery-jvectormap.css') ?>">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>">
    <!-- Daterange picker -->  
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') ?>">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/select2/dist/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/fileinput/fileinput.min.css') ?>">

    <!-- icheck -->
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/all.css') ?>">

  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>US</b>MG</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>UserManagement</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="fa fa-history"></i>
                </a>
                <ul class="dropdown-menu">
                  <li class="header"> <?=$lang['last_login'] ?> : <i class="fa fa-clock-o"></i> <?= empty($last_login) ? "First Time Login" : $last_login; ?></li>
                </ul>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url().$this->session->userdata('user_image');?>" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $name; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    
                    <img src="<?php echo base_url().$this->session->userdata('user_image'); ?>" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo $name; ?>
                      <small><?php echo $role_text; ?></small>
                    </p>
                    
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?php echo base_url(); ?>profile" class="btn btn-warning btn-flat"><i class="fa fa-user-circle"></i> Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            <li>
              <a href="<?php echo base_url(); ?>dashboard">
                <i class="fa fa-dashboard"></i> <span><?=$lang['side_dashboard']?></span></i>
              </a>
            </li>

            <li>
              <a href="<?php echo base_url() ?>task" >
                <i class="fa fa-ticket"></i>
                <span><?=$lang['side_mytask']?></span>
              </a>
            </li>
   
            <?php
            
            if($role == ROLE_ADMIN)
            {
            ?>
            <li>
              <a href="<?php echo base_url(); ?>userListing">
                <i class="fa fa-users"></i>
                <span><?=$lang['side_user']?></span>
              </a>
            </li>
            <?php
            }
            ?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>