<?php
    include_once 'php/db.php';
    
    function disabledButton()
    {
        if(!isset($_SESSION['permission']) OR $_SESSION['permission'] != true){
            echo "disabled";
        }
    }

    if(isset($_GET['logout'])){
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        header('Location: index.php');
    }

?>

<div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-src">
                    <img class="image-responsive image-fit-content rounded-circle" src="assets/images/logo.jpg" alt="" srcset="">
                </div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
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
            </div>    <div class="app-header__content">
                <div class="app-header-left">
                    <div class="search-wrapper">
                        <button class="close"></button>
                    </div>
                    <ul class="header-menu nav">
                        <li class="nav-item">
                            <h5>Life And Peace Commission Administrative Portal</h5>
                        </li>
                    </ul>        </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            <img width="42" class="rounded-circle" src="assets/images/avatars/userAvatar.png" alt="">
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <button type="button" tabindex="0" data-toggle="modal" class="dropdown-item" data-target="#staticBackdrop" <?php disabledButton(); ?>>Add Admins</button>
                                            <button type="button" tabindex="0" class="dropdown-item" <?php disabledButton(); ?>><a class="text-dark" href="admin.php">Manage Admins</a></button>
                                            <button tabindex="0" class="dropdown-item"><form method="get"><input type="text" name='logout' value='logout' hidden> <input type="submit" value=' Log out'></form></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                        <?php echo $_SESSION['name']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Warning Modal before deleting a contact message -->

        <!-- Modal to add Admin user -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Admin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <input type="text" class="form-control" id="validationCustom01" name="name" placeholder="Enter the Name of the Person" required>
                                    <div class="valid-feedback">
                                        Please enter a name
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label for="username" class="input-group-text">
                                                <i class="fa fa-user"></i>
                                            </label>
                                        </div>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Choose a Username for the person" aria-describedby="inputGroupPrepend" required>
                                        <div class="invalid-feedback">
                                            Please choose a username.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label for="password" class="input-group-text">
                                                <i class="fa fa-lock"></i>
                                            </label>
                                        </div>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Choose a Password for the person" required>
                                        <div class="invalid-feedback">
                                            This field is required.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit" value="submit" class="btn btn-primary btn-block" data-dismissal="modal" type="submit">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php

            if(isset($_POST['submit'])){
                $newAdmin = $_POST['submit'];

                if($newAdmin ==="submit"){
                    $name = $_POST['name'];
                    $password = $_POST['password'];
                    $username = $_POST['username'];

                    if($name !=="" && $username !=="" && $password !==""){
                        $adminsql = "INSERT INTO admin (admin_name, admin_user, admin_password) VALUES(:admin_name,:admin_user,:admin_password)";
                        $admin_result = $conn->prepare($adminsql);
                        $admin_result->bindValue(':admin_name', $name);
                        $admin_result->bindValue(':admin_user', $username);
                        $admin_result->bindValue(':admin_password', $password);

                        $admin_result = $admin_result->execute();

                        if($admin_result===true)
                        {
                            echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                                        '<button aria-hidden="true" data-target="alert" data-dismiss="alert" class="close" type="button">×</button>'.
                                        '<h6><i class="icon fa pe-7s-check"></i> Successfully added!</h6>'.
                                    '</div>';
                        }
                        else
                        {
                            echo    '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                        '<h6><i class="icon fa pe-7s-attention"></i>Unable to add user, please try again later!</h6>'.
                                    '</div>';
                        }
                    }
                    else
                    {
                        echo    '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                    '<h6><i class="icon fa pe-7s-attention"></i>Please ensure you fill out all fields and then try again!</h6>'.
                                '</div>';
                    }
                }
                else
                {
                    echo    '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-attention"></i>Please ensure you fill out all fields and then try again!</h6>'.
                            '</div>';
                }
            }

        ?>