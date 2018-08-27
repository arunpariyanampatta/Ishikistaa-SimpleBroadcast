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
  
    $msgs_published = 0;

    $workers_started = 0;
    if(isset($_GET['workers_started'])){
        $workers_started = $_GET['workers_started'];
    }
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
            checkQueue();
            setInterval(function(){
                checkQueue();
            },1000);
            $("#publishmessage").click(function(){
                $(this).attr("disabled",true);
                var tbl_name = $('.tbl_name').val();
                var promotionName = $('.promotionName').val();
                var senderID = $('.senderID').val();
                var message = $('.message').val();
                $.post('BackgroundProcess.php',{ProcessType:'Publish',tbl_name:tbl_name,promotionName: promotionName,senderID:senderID ,message:message },function(response){


                });

            });
            $("#startconsumers").click(function(){
                 $(this).attr("disabled",true);
                $.post('BackgroundProcess.php',{ProcessType:'Consume' },function(response){


                });
            });
            $('.message').on('keyup', function () {
                var nChars = $('.message').val().length;
                $('.numberOfChars').val(nChars + " Characters");
                var nMsgs = msgCount(nChars);
                var msgSuffx;
                if (nMsgs == 1) {
                    msgSuffx = "Message";
                } else {
                    msgSuffx = "Messages";
                }
                $('.numberOfMsg').val(nMsgs + " " + msgSuffx);
            });
        });
        function checkQueue(){
            $.post('ListQueue.php',{ProcessType:'QueueCheck'},function(response) {
                var rsp = $.parseJSON(response);

               if (rsp == "empty") {
                   return;

                } else {

                  if(rsp.Messagecount > 0){

                      $("#publishmessage").attr("disabled",true);

                      $('.publish_updates').text('Messagecount: '+rsp.Messagecount);

                  }
                  else{
                      $('.publish_updates').text('Messagecount: 0');
                      $("#publishmessage").attr("disabled",false);
                  }
                }
            });
            }
                function msgCount(chars) {
                    var msgs = 0;
                    if (chars > 0) {
                        if (chars <= 160) {
                            msgs = 1;
                        } else if (chars > 160 && chars <= 306) {
                            msgs = 2;
                        } else if (chars > 306 && chars <= 459) {
                            msgs = 3;
                        } else if (chars > 459 && chars <= 612) {
                            msgs = 4;
                        } else if (chars > 612 && chars <= 765) {
                            msgs = 5;
                        } else {
                            msgs = 6;
                        }
                    }
                    return msgs;
                }

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
                                                <h6 class="card-title"><span class="no-of-workers-span"><?php echo WORKER;?></span> WORKERS CONFIGURED</h6>
                                                <div class="header-elements">
                                                    <div class="form-check form-check-right form-check-switchery form-check-switchery-sm">
                                                        <span class="publish_updates">Messagecount: 0</span>
                                                    </div>
                                                </div>
                                            </div>

<!--                                            <form data-toggle="validator" method="get" action="--><?php //echo $_SERVER['PHP_SELF']; ?><!--">-->

                                                <div class="col-xl-3 form-group">
                                                    <select name="tbl_name" class="form-control table-name-select tbl_name" required>
                                                        <option value="">-- Table name --</option>
                                                        <?php if(count($tables) > 0){
                                                            $n_tables = count($tables);
                                                            for($i = 0; $i < $n_tables; ++$i){
                                                            ?>
                                                                <option><?php echo($tables[$i][0]); ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="col-xl-3 form-group">
                                                    <input name="promotionName" class="form-control promotionName" id="promotionName"
                                                           placeholder="promotionName" required>
                                                </div>

                                                <div class="col-xl-3 form-group">
                                                    <input name="senderID" class="form-control senderID" id="senderID"
                                                           placeholder="senderID" required>
                                                </div>

                                                <div class="col-xl-12 form-group">
                                                    <label for="message" class="control-label">Message</label>
                                                    <textarea name="message" class="form-control message" rows="8"
                                                              id="message"
                                                              required></textarea>
                                                </div>

                                                <input type="hidden" name="selected-groups"
                                                       class="form-control selected-groups"
                                                       value="" readonly>

                                                <div class="col-xl-6">
                                                    <input type="text" name="numberOfChars"
                                                           class="numberOfChars border-less"
                                                           placeholder="0 Characters" readonly>
                                                </div>

                                                <div class="col-xl-6">
                                                    <input type="text" name="numberOfMsg"
                                                           class="numberOfMsg border-less"
                                                           placeholder="0 Messages" readonly>
                                                </div>

                                                <div class="card-header header-elements-inline publish_and_start">
                                                    <button type="button"
                                                            class="btn btn-primary btn-send-msg" id="publishmessage">
                                                        PUBLISH MESSAGES
                                                    </button>
                                                    <div class="header-elements">
                                                        <button type="button"
                                                                    class="btn btn-primary btn-send-msg" id="startconsumers">
                                                                Start Workers
                                                            </button>
                                                        
                                                    </div>
                                                </div>

                                                <?php
                                                if($msgs_published || $workers_started){
                                                    $notification = '';
                                                    if($msgs_published){
                                                        $notification = '<strong>Queue</strong> published <strong>successfully!</strong> (Messages will come after queue establishment check)';
                                                    }else if($workers_started){
                                                        $notification = WORKER.' Workers <strong>started</strong> successfully!</strong> (Messages will come after workers start check)';
                                                    }
                                                ?>
                                                    <script>
                                                        $.jGrowl('<?php echo $notification; ?>', {
                                                            header: 'Successfully!',
                                                            position: 'bottom-center',
                                                            sticky: true,
                                                            theme: 'bg-success'
                                                        });
                                                    </script>
                                                <?php
                                                }
                                                ?>

<!--                                            </form>-->
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

</body>

</html>
