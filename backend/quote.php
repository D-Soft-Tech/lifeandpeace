<?php
    include_once 'php/db.php';

    $conn = get_DB();
    session_start();

    if(isset($_SESSION['username']) AND isset($_SESSION['password'])){
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];

        $sql = "
                    SELECT admin_user, admin_password FROM admin WHERE admin_user = :username AND admin_password = :password
                ";

        $check = $conn->prepare($sql);
        $check->bindParam(':username', $username);
        $check->bindParam(':password', $password);

        $check = $check->execute();

        if($check === true){
        ?>
            <!-- the main page starts from here -->

            <!doctype html>
                <html lang="en">

                <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta http-equiv="Content-Language" content="en">
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                    <title>Admin Dashboard - Mount Zion Fortres</title>
                    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
                    <meta name="msapplication-tap-highlight" content="no">
                    <link rel="stylesheet" href="../assets/forala/css/froala_editor.pkgd.min.css">
                    <link href="./main.css" rel="stylesheet">
                    </head>
                <body>
                    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
                        <!-- Include the header file here via php -->
                            <?php
                                include_once 'header.php';
                            ?>
                        <!-- Header file inclusion ends here -->

                        <!-- Color settings -->
                            <div class="ui-theme-settings">
                                <button type="button" id="TooltipDemo" class="btn-open-options btn btn-warning">
                                    <i class="fa fa-cog fa-w-16 fa-spin fa-2x"></i>
                                </button>
                                <div class="theme-settings__inner">
                                    <div class="scrollbar-container">
                                        <div class="theme-settings__options-wrapper">
                                            <h3 class="themeoptions-heading">Layout Options
                                            </h3>
                                            <div class="p-3">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left mr-3">
                                                                    <div class="switch has-switch switch-container-class" data-class="fixed-header">
                                                                        <div class="switch-animate switch-on">
                                                                            <input type="checkbox" checked data-toggle="toggle" data-onstyle="success">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading">Fixed Header
                                                                    </div>
                                                                    <div class="widget-subheading">Makes the header top fixed, always visible!
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left mr-3">
                                                                    <div class="switch has-switch switch-container-class" data-class="fixed-sidebar">
                                                                        <div class="switch-animate switch-on">
                                                                            <input type="checkbox" checked data-toggle="toggle" data-onstyle="success">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading">Fixed Sidebar
                                                                    </div>
                                                                    <div class="widget-subheading">Makes the sidebar left fixed, always visible!
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left mr-3">
                                                                    <div class="switch has-switch switch-container-class" data-class="fixed-footer">
                                                                        <div class="switch-animate switch-off">
                                                                            <input type="checkbox" data-toggle="toggle" data-onstyle="success">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading">Fixed Footer
                                                                    </div>
                                                                    <div class="widget-subheading">Makes the app footer bottom fixed, always visible!
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h3 class="themeoptions-heading">
                                                <div>
                                                    Header Options
                                                </div>
                                                <button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-header-cs-class" data-class="">
                                                    Restore Default
                                                </button>
                                            </h3>
                                            <div class="p-3">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <h5 class="pb-2">Choose Color Scheme
                                                        </h5>
                                                        <div class="theme-settings-swatches">
                                                            <div class="swatch-holder bg-primary switch-header-cs-class" data-class="bg-primary header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-secondary switch-header-cs-class" data-class="bg-secondary header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-success switch-header-cs-class" data-class="bg-success header-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-info switch-header-cs-class" data-class="bg-info header-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-warning switch-header-cs-class" data-class="bg-warning header-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-danger switch-header-cs-class" data-class="bg-danger header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-light switch-header-cs-class" data-class="bg-light header-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-dark switch-header-cs-class" data-class="bg-dark header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-focus switch-header-cs-class" data-class="bg-focus header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-alternate switch-header-cs-class" data-class="bg-alternate header-text-light">
                                                            </div>
                                                            <div class="divider">
                                                            </div>
                                                            <div class="swatch-holder bg-vicious-stance switch-header-cs-class" data-class="bg-vicious-stance header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-midnight-bloom switch-header-cs-class" data-class="bg-midnight-bloom header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-night-sky switch-header-cs-class" data-class="bg-night-sky header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-slick-carbon switch-header-cs-class" data-class="bg-slick-carbon header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-asteroid switch-header-cs-class" data-class="bg-asteroid header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-royal switch-header-cs-class" data-class="bg-royal header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-warm-flame switch-header-cs-class" data-class="bg-warm-flame header-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-night-fade switch-header-cs-class" data-class="bg-night-fade header-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-sunny-morning switch-header-cs-class" data-class="bg-sunny-morning header-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-tempting-azure switch-header-cs-class" data-class="bg-tempting-azure header-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-amy-crisp switch-header-cs-class" data-class="bg-amy-crisp header-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-heavy-rain switch-header-cs-class" data-class="bg-heavy-rain header-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-mean-fruit switch-header-cs-class" data-class="bg-mean-fruit header-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-malibu-beach switch-header-cs-class" data-class="bg-malibu-beach header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-deep-blue switch-header-cs-class" data-class="bg-deep-blue header-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-ripe-malin switch-header-cs-class" data-class="bg-ripe-malin header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-arielle-smile switch-header-cs-class" data-class="bg-arielle-smile header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-plum-plate switch-header-cs-class" data-class="bg-plum-plate header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-happy-fisher switch-header-cs-class" data-class="bg-happy-fisher header-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-happy-itmeo switch-header-cs-class" data-class="bg-happy-itmeo header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-mixed-hopes switch-header-cs-class" data-class="bg-mixed-hopes header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-strong-bliss switch-header-cs-class" data-class="bg-strong-bliss header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-grow-early switch-header-cs-class" data-class="bg-grow-early header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-love-kiss switch-header-cs-class" data-class="bg-love-kiss header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-premium-dark switch-header-cs-class" data-class="bg-premium-dark header-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-happy-green switch-header-cs-class" data-class="bg-happy-green header-text-light">
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h3 class="themeoptions-heading">
                                                <div>Sidebar Options</div>
                                                <button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-sidebar-cs-class" data-class="">
                                                    Restore Default
                                                </button>
                                            </h3>
                                            <div class="p-3">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <h5 class="pb-2">Choose Color Scheme
                                                        </h5>
                                                        <div class="theme-settings-swatches">
                                                            <div class="swatch-holder bg-primary switch-sidebar-cs-class" data-class="bg-primary sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-secondary switch-sidebar-cs-class" data-class="bg-secondary sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-success switch-sidebar-cs-class" data-class="bg-success sidebar-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-info switch-sidebar-cs-class" data-class="bg-info sidebar-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-warning switch-sidebar-cs-class" data-class="bg-warning sidebar-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-danger switch-sidebar-cs-class" data-class="bg-danger sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-light switch-sidebar-cs-class" data-class="bg-light sidebar-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-dark switch-sidebar-cs-class" data-class="bg-dark sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-focus switch-sidebar-cs-class" data-class="bg-focus sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-alternate switch-sidebar-cs-class" data-class="bg-alternate sidebar-text-light">
                                                            </div>
                                                            <div class="divider">
                                                            </div>
                                                            <div class="swatch-holder bg-vicious-stance switch-sidebar-cs-class" data-class="bg-vicious-stance sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-midnight-bloom switch-sidebar-cs-class" data-class="bg-midnight-bloom sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-night-sky switch-sidebar-cs-class" data-class="bg-night-sky sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-slick-carbon switch-sidebar-cs-class" data-class="bg-slick-carbon sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-asteroid switch-sidebar-cs-class" data-class="bg-asteroid sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-royal switch-sidebar-cs-class" data-class="bg-royal sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-warm-flame switch-sidebar-cs-class" data-class="bg-warm-flame sidebar-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-night-fade switch-sidebar-cs-class" data-class="bg-night-fade sidebar-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-sunny-morning switch-sidebar-cs-class" data-class="bg-sunny-morning sidebar-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-tempting-azure switch-sidebar-cs-class" data-class="bg-tempting-azure sidebar-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-amy-crisp switch-sidebar-cs-class" data-class="bg-amy-crisp sidebar-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-heavy-rain switch-sidebar-cs-class" data-class="bg-heavy-rain sidebar-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-mean-fruit switch-sidebar-cs-class" data-class="bg-mean-fruit sidebar-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-malibu-beach switch-sidebar-cs-class" data-class="bg-malibu-beach sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-deep-blue switch-sidebar-cs-class" data-class="bg-deep-blue sidebar-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-ripe-malin switch-sidebar-cs-class" data-class="bg-ripe-malin sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-arielle-smile switch-sidebar-cs-class" data-class="bg-arielle-smile sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-plum-plate switch-sidebar-cs-class" data-class="bg-plum-plate sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-happy-fisher switch-sidebar-cs-class" data-class="bg-happy-fisher sidebar-text-dark">
                                                            </div>
                                                            <div class="swatch-holder bg-happy-itmeo switch-sidebar-cs-class" data-class="bg-happy-itmeo sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-mixed-hopes switch-sidebar-cs-class" data-class="bg-mixed-hopes sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-strong-bliss switch-sidebar-cs-class" data-class="bg-strong-bliss sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-grow-early switch-sidebar-cs-class" data-class="bg-grow-early sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-love-kiss switch-sidebar-cs-class" data-class="bg-love-kiss sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-premium-dark switch-sidebar-cs-class" data-class="bg-premium-dark sidebar-text-light">
                                                            </div>
                                                            <div class="swatch-holder bg-happy-green switch-sidebar-cs-class" data-class="bg-happy-green sidebar-text-light">
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h3 class="themeoptions-heading">
                                                <div>Main Content Options</div>
                                                <button type="button" class="btn-pill btn-shadow btn-wide ml-auto active btn btn-focus btn-sm">Restore Default
                                                </button>
                                            </h3>
                                            <div class="p-3">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <h5 class="pb-2">Page Section Tabs
                                                        </h5>
                                                        <div class="theme-settings-swatches">
                                                            <div role="group" class="mt-2 btn-group">
                                                                <button type="button" class="btn-wide btn-shadow btn-primary btn btn-secondary switch-theme-class" data-class="body-tabs-line">
                                                                    Line
                                                                </button>
                                                                <button type="button" class="btn-wide btn-shadow btn-primary active btn btn-secondary switch-theme-class" data-class="body-tabs-shadow">
                                                                    Shadow
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- End of Color Settings -->
                        <!-- Main Content Starts from Here -->
                            <div class="app-main">
                                    <div class="app-sidebar sidebar-shadow">
                                        <div class="app-header__logo">
                                            <div class="logo-src"></div>
                                            <div class="header__pane ml-auto">
                                                <!-- Sidebar Controller Icon -->
                                                    <div>
                                                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                                            <span class="hamburger-box">
                                                                <span class="hamburger-inner"></span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                <!-- End of Sidebar controller icon -->
                                            </div>
                                        </div>
                                        <div class="app-header__mobile-menu">
                                            <div>
                                                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                                    <span class="hamburger-box">
                                                        <span class="hamburger-inner"></span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="app-header__menu">
                                            <span>
                                                <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                                    <span class="btn-icon-wrapper">
                                                        <i class="fa fa-ellipsis-v fa-w-6"></i>
                                                    </span>
                                                </button>
                                            </span>
                                        </div>    
                                        
                                        <!-- sidebar -->
                                            <?php
                                                include_once 'sidebar.php';
                                            ?>
                                        <!-- /sidebar -->
                                    </div>    
                                    <div class="app-main__outer">
                                        <div class="app-main__inner">
                                            <!-- Page title wrapper -->
                                            <?php include_once 'pageTitle.php'; ?>
                                            <!-- End of Page title wrapper-->

                                            <!-- The Major content that is associated with index page starts from this place -->
                                            <div id="maincontent">

                                                <?php 

                                                $limit = 5;
                                                $page = 1;

                                                function page()
                                                {
                                                    global $page;
                                                    if (isset($_GET['page']) && $page <= 1){
                                                        return $_GET['page'];
                                                    }elseif ($page >1){
                                                        return $page;
                                                    }else{
                                                        return 1;
                                                    }
                                                }

                                                $page = page();

                                                $start = ($page - 1) * $limit;
                                                $result = $conn->query("SELECT quote_id, details, author FROM quote LIMIT $start, $limit");
                                                $quotes = $result->fetchAll();

                                                $result1 = $conn->query("SELECT count(quote_id) AS quote_id FROM likes");
                                                $custCount = $result1->fetchAll();
                                                $total = $custCount[0]['quote_id'];

                                                function pages(){
                                                    global $pages;
                                                    if(isset($_GET['pages']) && $pages === null){
                                                        return $_GET['pages'];
                                                    }elseif ($pages){
                                                        return $pages;
                                                    }else{
                                                        return 5;
                                                    }
                                                }

                                                $pages = pages();

                                                function previous(){
                                                    global $pages;
                                                    if($pages <=5){
                                                        return 5;
                                                    }else{
                                                        return $pages - 5;
                                                    }
                                                }
                                                $Previous = previous();

                                                function nextArrow(){
                                                    global $pages, $total, $limit;
                                                    $rem = ceil($total % $limit);
                                                    $div = ceil($total / $limit);

                                                    if($pages >= $div){
                                                        if($rem>0){
                                                            return $div + 4;
                                                        }elseif($rem = 0){
                                                            return $div;
                                                        }
                                                    }
                                                    else
                                                    {
                                                        return $pages + 5;
                                                    }
                                                }	
                                                $Next = nextArrow();

                                                ?>

                                                <div class="row">
                                                    <div class="col-sm-10">
                                                        <div class="row" id="update">
                                                            
                                                        </div>    
                                                    </div>
                                                    <div class="col-sm-2"></div>
                                                </div>
                                                <!-- Each of the contents of this row are only displayed when a condition is met,i.e as confirmation alerts when something is a succes 
                                                of failure and so they are not part of the main items to be displayed on the page -->
                                                <div class="row">
                                                    <div class="col-sm-10">
                                                        <div class="row">
                                                            <?php $result =" "; function result($result){ echo $result; } ?>
                                                        </div>    
                                                    </div>
                                                    <div class="col-sm-2"></div>
                                                </div>

                                                <?php include_once 'quotecontent.php'; ?>
                                            </div>
                                            <!-- End of the the main content that is associated with the index page -->
                                        </div>
                                    </div>
                                    <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
                                    <div class="modal fade bd-example-modal-lg mt-5" id="addQuote" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="false">
                                        <div class="modal-dialog modal-lg mt-5 mb-5">
                                            <div class="modal-content">
                                            <div class="modal-header text-info">
                                                <h5 class="modal-title">
                                                    Add New Quote
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST">
                                                    <div class="form-row">
                                                        <div class="col-md-12">
                                                            <div class="position-relative form-group">
                                                                <label for="quote" class="">
                                                                    Quote
                                                                </label>
                                                                <textarea name="quote" id="quoteboxes" placeholder="Input the quote here" 
                                                                    type="text" class="form-control fr-view"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="position-relative form-group">
                                                                <label for="author" class="">
                                                                    Author
                                                                </label><input name="author" id="author" 
                                                                    placeholder="(eg. Pastor Barnabas / John 12:1 etc)" type="text" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" name="submitQuote" value="submit" class="mt-1 btn btn-primary">Post Quote</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        <!-- /Main Content Ends here -->
                    </div>
                    <script type="text/javascript" src="../assets/bootstrap-4.4.1-dist/js/jquery.js"></script>
                    <script type="text/javascript" src="../assets/bootstrap-4.4.1-dist/js/bootstrap.js"></script>
                    <script type="text/javascript" src="../assets/forala/js/froala_editor.pkgd.min.js"></script>
                    <script type="text/javascript" src="./assets/scripts/main.js"></script>
                    <script type="text/javascript" src="../ajax_class.js"></script>
                    <script>
                        
                        function removeElement(id)
                        {
                            var element = document.getElementById(id);
                            element.parentNode.removeChild(element);
                        }

                        $(document).ready(function (){

                        // $('.flash_msg').delay(250).fadeOut('slow');

                        $('.deleteQuote').click(function (){
                            var name = $(this).attr("id");

                            var deleteButton = $('.finalDelete').attr("id", name);

                            $('#deletemessagemodal').modal('show');
                            });

                                $('.addQuote').click(function (){

                                $('#addQuoteModal').modal('show');
                            });
                        });

                        function deleteQuote(id){
                            XmlHttp
                            (
                                {
                                    url: 'testing.php',
                                    type: 'POST',
                                    data: "deleteQuote="+id,
                                    complete:function(xhr,response,status)
                                    {
                                        if(response != ""){
                                            document.getElementById('update').innerHTML = response;

                                            removeElement(id);
                                        }
                                    }
                                }
                            );
                        }

                        function likes()
                        {
                            var id = $('.showLikes').attr("name");
                            XmlHttp
                            (
                                {
                                    url: 'testing.php',
                                    type: 'POST',
                                    data: "likeId="+id,
                                    complete:function(xhr,response,status)
                                    {
                                        document.getElementsByClassName('').innerHTML = response;
                                    }
                                }
                            );
                        }

                        var forala = new FroalaEditor('textarea');
                    </script>
                    </body>
                </html>

            <!-- the main page ends here -->
        <?php
        }
        else{
            header("Location: index.php");
        }
    }
    else{
            header("Location: index.php");
    }
?>