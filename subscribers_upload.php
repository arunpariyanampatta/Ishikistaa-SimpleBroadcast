<?php
session_start();
require_once 'dbconfig.php';
require_once 'config.php';
require_once 'query.php';

if (!isset($_SESSION['loginuser'])) {
    header("Location: index.php");
    exit;
} else {
    if (isset($_SESSION['fullname'])) {
        $user = $_SESSION['fullname'];
    }
}

$uploaded = 0;
$msisdn_nm = 0;
if(isset($_GET['uploaded']) && isset($_GET['msisdn_nm'])){
    $uploaded = $_GET['uploaded'];
//    $msisdn_nm = $_GET['msisdn_nm'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SMS Portal</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="global_assets/images/favicon.ico">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="global_assets/js/main/jquery.min.js"></script>
    <script src="global_assets/js/main/bootstrap.bundle.min.js"></script>
    <script src="global_assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="global_assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script src="global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
    <script src="global_assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script src="global_assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
    <script src="global_assets/js/plugins/ui/moment/moment.min.js"></script>
    <script src="global_assets/js/plugins/pickers/daterangepicker.js"></script>

    <script src="assets/js/app.js"></script>
    <script src="global_assets/js/demo_pages/dashboard.js"></script>
    <script src="global_assets/js/plugins/notifications/jgrowl.min.js"></script>
    <script src="global_assets/js/plugins/notifications/noty.min.js"></script>
    <!-- /theme JS files -->

    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>

</head>

<body>

<!-- Main navbar -->
<div class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-brand">
        <a href="home.php" class="d-inline-block">
            <img src="global_assets/images/logo_light.png" alt="">
        </a>
    </div>

    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>
        </ul>

        <span class="navbar-text ml-md-3 mr-md-auto"></span>

        <ul class="navbar-nav">
            <li class="nav-item dropdown"></li>

            <li class="nav-item dropdown dropdown-user">
                <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-user icon-2x"></i>
                    <span><?php echo $user; ?></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="logout.php" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->


<!-- Page content -->
<div class="page-content">

    <!-- Main sidebar -->
    <div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

        <!-- Sidebar mobile toggler -->
        <div class="sidebar-mobile-toggler text-center">
            <a href="#" class="sidebar-mobile-main-toggle">
                <i class="icon-arrow-left8"></i>
            </a>
            Navigation
            <a href="#" class="sidebar-mobile-expand">
                <i class="icon-screen-full"></i>
                <i class="icon-screen-normal"></i>
            </a>
        </div>
        <!-- /sidebar mobile toggler -->


        <!-- Sidebar content -->
        <div class="sidebar-content">

            <!-- User menu -->
            <div class="sidebar-user">
                <div class="card-body">
                    <div class="media">
                        <div class="mr-3">
                            <!--<a href="#">-->
                            <i class="icon-user icon-2x rounded-circle"></i>
                            <!--</a>-->
                        </div>

                        <div class="media-body">
                            <div class="media-title font-weight-semibold"><?php echo $user; ?></div>
                            <div class="font-size-xs opacity-50">
                            </div>
                        </div>

                        <div class="ml-3 align-self-center">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /user menu -->


            <!-- Main navigation -->
            <div class="card card-sidebar-mobile">
                <ul class="nav nav-sidebar" data-nav-type="accordion">

                    <!-- Main -->
                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">Menu</div>
                        <i class="icon-menu" title="Main"></i>
                    </li>
                    <li class="nav-item">
                        <a href="home.php" class="nav-link active">
                            <i class="icon-home4"></i>
                            <span>
									SMS Broadcast
							</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="subscribers_upload.php" class="nav-link">
                            <i class="icon-home4"></i>
                            <span>
									Subscribers upload
							</span>
                        </a>
                    </li>
                    <!--<li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-copy"></i> <span>Configuration</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Configuration">
                            <li class="nav-item"><a href="#" class="nav-link active">Default Configuration</a></li>
                        </ul>
                    </li>-->
                    <!-- /main -->
                </ul>
            </div>
            <!-- /main navigation -->

        </div>
        <!-- /sidebar content -->

    </div>
    <!-- /main sidebar -->


    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="home.php" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                        <span class="breadcrumb-item active">Broadcast Messages</span>
                    </div>

                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

            </div>
        </div>
        <!-- /page header -->

        <!-- Content area -->
        <div class="content">

            <!-- Main charts -->
            <div class="row">
                <div class="col-xl-12">

                    <div class="card">

                        <div class="card-body">

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="publish-msg-pill">
                                    <div class="row">
                                        <div class="col-xl-12">

                                            <div class="card-header header-elements-inline">
                                                <h6 class="card-title"><span class="no-of-workers-span">SUBSCRIBERS UPLOAD</span></h6>
                                            </div>

                                            <form action="subscribers_upload_action.php" method="POST" enctype="multipart/form-data">
                                                Select file to upload:
                                                <input type="file" name="file" id="fileToUpload">
                                                <input type="submit" value="Upload File" name="submit">
                                            </form>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!-- /main charts -->

        </div>
        <!-- /content area -->


        <!-- Footer -->
        <div class="navbar navbar-expand-lg navbar-light">
            <div class="text-center d-lg-none w-100">
                <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse"
                        data-target="#navbar-footer">
                    <i class="icon-unfold mr-2"></i>
                    Footer
                </button>
            </div>

            <div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; 2018. <a href="#">Dashboard</a> by <a href="http://www.greentelecom.co.tz/"
                                                                     target="_blank">Greentelecom</a>
					</span>
            </div>
        </div>
        <!-- /footer -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

<?php
   if($uploaded) {
       $notification = $msisdn_nm." MSISDNS Successfully uploaded!";
       ?>
       <script>
           $.jGrowl('<?php echo $notification; ?>', {
               header: 'Successfully!',
               position: 'center',
               sticky: true,
               theme: 'bg-success'
           });
       </script>
       <?php
   }
?>

</body>

</html>
