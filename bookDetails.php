<?php
    session_start();

    //getting the api_key to use
    include_once 'life/php/db.php';

    $conn = get_DB();
    
    $api =  "
    SELECT api_key FROM account WHERE purpose = :book
    ";

    $stmt = $conn->prepare($api);
    $stmt->bindValue(':book', 'book');
    $apiResource = $stmt->execute();

    $api_key = $stmt->fetch();

    $alertMessage = "";

    if(isset($_GET['submitAddToCart']) && $_GET['submitAddToCart'] === "submitAddToCart")
    {
        if(isset($_SESSION['username_frontEnd']))
        {
            $book_id = $_GET['book_id'];
            $book_name = $_GET['book_title'];

            if($_SESSION['shoppingCart'] && (in_array($book_id, $_SESSION['shoppingCart'])) === true)
            {
                $alertMessage =     '<div class="alert alert-info alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                        '<div class="">'.
                                            '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; The book already exists in your cart</h6>'.
                                        '</div>'.
                                    '</div>';
            }
            else
            {
                $_SESSION['shoppingCart'][] = $book_id;

                $alertMessage =     '<div class="alert alert-success alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                        '<div class="">'.
                                            '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; The book has been added to your cart</h6>'.
                                        '</div>'.
                                    '</div>';
            }
        }
        else
        {
            $alertMessage = '<div class="alert alert-danger alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<div class="">'.
                                    '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Sorry! You have to <a href="logs.php" class="text-danger"><b>Login</b></a> first</h6>'.
                                '</div>'.
                            '</div>';
        }  
    }

    function disable_button()
    {
        if(isset($_SESSION['username_frontEnd']) && isset($_SESSION['password_frontEnd']) && !empty($_SESSION['username_frontEnd']) && !empty($_SESSION['password_frontEnd']))
        {
            echo "onclick='payWithPaystack()' type='button'";
        }
        else{
            echo "data-toggle='tooltip' data-placement='right' type='button' title='You have to login first'";
        }
    }

    // Codes to redirect to payment page for shopping cart
    if(isset($_POST['payCart']))
    {
        if(isset($_SESSION['username_frontEnd']))
        {
            $checker = $_POST['payCart'];

            if($checker === "pay")
            {
                if(!empty($_SESSION['shoppingCart']))
                {
                   header('Location: payment.php');
                }
                else
                {
                    $alertMessage =     '<div class="alert alert-danger alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                            '<div class="">'.
                                                '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; You have no item in your shopping cart</h6>'.
                                            '</div>'.
                                        '</div>';
            
                    // echo $shoppingCartDontExist;
                }
            }
        }
        else
        {
            $alertMessage = '<div class="alert alert-danger alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<div class="">'.
                                    '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Sorry! You have to <a class="text-danger" href="logs.php"><b>Login</b></a> first</h6>'.
                                '</div>'.
                            '</div>';
        
            // echo $loginPrompt;
        }  
    }

    if(isset($_POST['logoutPassword']))
    {

        unset($_SESSION['username_frontEnd']);
        unset($_SESSION['password_frontEnd']);
        unset($_SESSION['shoppingCart']);

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Life and peace Commission; is church value is reaching the unsaved in the remotest and interior part of the world while equipping the saint for service.
The three most essential aspect of our family are: Sound Teachings, Sweet Fellowship and Strong Prayers">
<meta name="keywords" content="Church, Website, Strong Prayers, Sound Teachings, Sweet Fellowship, Mount Zion Fortress, Life and Peace, Descipleship, Knowing the Christ, Intimacy with the Father">
<meta name="author" content="Oloyede Adebayo (+2349075771869)">
<title>Life and Peace Commission - Mount Zion Fortress</title>
<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- Church Template CSS -->
<link href="css/church.css" rel="stylesheet">
<link href="css/fancybox.css" rel="stylesheet">
<link href="css/books.css" rel="stylesheet">
<link href="assets/fontawesomeForWeb/css/all.css">
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
<![endif]-->

<!-- Favicons -->
<link rel="shortcut icon" href="images/favicon.png">

<!-- Custom Google Font : Montserrat and Droid Serif -->

<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
<!-- Navigation Bar Starts -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="index.php"> <img src="images/lpc.jpg" alt="church logo" class="img-responsive img-circle"></a> <h5 style="color: white;"> Life And Peace <span class="text-justify">Commission</span></h5></div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php">HOME</a></li>
        <li><a href="about.php">ABOUT</a></li>
        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">SERMONS <span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-left" role="menu">
            <li><a href="audio-gallery.php">Audio Gallery</a></li>
            <li><a href="video-gallery.php">Video Gallery</a></li>
            </ul>
        </li>
        <li><a href="books.php">BOOKS</a></li>
        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">PAGES <span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-left" role="menu">
            <li><a href="image-gallery.php">Image Gallery</a></li>
            <li><a href="blog.php">Bulletin</a></li>
            <li><a href="events-programs.php">Events &amp; Programs</a></li>
            <li><a href="weeklyProgram.php">Weekly Program</a></li>
            <li><a href="charity-donation.php">Charity &amp; Donations</a></li>
            <li><a href="testimony.php">Testimonies</a></li>
            </ul>
        </li>
        <li><a href="give.php">Give Online</a></li>
        <li><a href="contact.php">CONTACT</a></li>
        <?php
            function href()
            {
            if(!isset($_SESSION['username_frontEnd']) && !isset($_SESSION['password_frontEnd']))
            {
            echo "<li class='dropdown'>". 
                    "<a href='logs.php'>".
                        "<b>Login</b>".
                    "</a>".
                    "</li>";
            }
            else
            {
                echo '<li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>'.$_SESSION['username_frontEnd'].'<span class="caret"></span></b></a>';
            }
            }

            href();

            function is_loggedIn()
            {
            if(isset($_SESSION['username_frontEnd']) && isset($_SESSION['password_frontEnd']))
            {
                echo  '<ul class="dropdown-menu dropdown-menu-left" role="menu">'.
                        '<li>'.
                            '<a href="#" type="button" class="mr-0 pr-0 dropdown-item logOut" name="'.$_SESSION['password_frontEnd'].'" id="'.$_SESSION['username_frontEnd'].'"><b>Log out</b></a>'.
                        '</li>'.
                    '</ul>';
            }
            }

            is_loggedIn();
        ?>
        </li>
      </ul>
    </div>
    <!--/.nav-collapse --> 
    
  </div>
</div>
<!--// Navbar Ends--> 

<?php
  include_once 'life/php/db.php';
  include_once 'life/php/indexpage.php';
?>

    <!-- Getting the details of book sent in from books.php -->
    <?php

        $sanitizer = filter_var_array($_GET, FILTER_SANITIZE_STRING);
        $book_id = $sanitizer['book_id'];
        $book_description = $sanitizer['book_description'];
        $book_price = $sanitizer['book_price'];
        $book_volume = $sanitizer['book_volume'];
        $book_page = $sanitizer['book_page'];
        $book_title = $sanitizer['book_title'];
        $book_ext1 = $sanitizer['book_ext1'];
        $book_ext2 = $sanitizer['book_ext2'];


    ?>

    <div class="subpage-head has-margin-bottom">
        <div class="container">
            <h4 class="text-center"><?= $book_title; ?></h4>
        </div>
    </div>

    <div id="alertMessageDiv" style="margin-bottom: 10px;">
            <?= $alertMessage; ?>
    </div>

    <div class="container has-margin-bottom">
        <div class="row">
            <div class="col-md-9 col-xs-12">
                <div class="row">
                    <div class="col-xs-12 has-margin-bottom">
                        <div class="row">
                            <div class="col-xs-6 col-md-3 container" id="book-top" style="border-right: 2px solid;">
                                <img src="images/books/<?= $book_title; ?>.<?= $book_ext1; ?>" style="height: 250px; width: 100%;" alt="" class="image-responsive">
                            </div>
                            <div class="col-xs-6 col-md-9">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h6 Class="bg-success" style="padding: 10px;">Details</h6>
                                    </div>
                                    <div class="col-xs-12" style="margin-left: 20px; line-height: 1.5;">
                                        <p>Price: <span><b><?= $book_price; ?></b></span></p>
                                        <p>Volume: <span><b><?= $book_volume; ?></b></span></p>
                                        <p>Pages: <span><b><?= $book_page; ?></b></span></p>
                                        <br />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6"><a 
                                    href="bookDetails.php?book_id=<?= $book_id; ?>&book_description=<?= $book_description;?>&book_price=<?= $book_price;?>&book_volume=<?= $book_volume; ?>&book_page=<?= $book_page;?>&book_title=<?= $book_title; ?>&book_ext1=<?= $book_ext1; ?>&book_ext2=<?= $book_ext2; ?>&submitAddToCart=submitAddToCart"
                                     type="button" class="btn-transition btn btn-success" title="Add to cart"><i class="fa fa-cart-plus"></i></a></div>
                                    <div class="col-xs-6"><a  href="books.php" class="btn-link"><button title="Go Back to Books" class="btn-transition btn btn-success"><i class="fa fa-arrow-left"></i></button></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 jumbotron ">
                        <h4 class="text-success">Preface</h4>
                        <p class="card-text text-justify" id="details" style="font-family: Arial, Helvetica, sans-serif; font-size: 16px; line-height: 2.0;">
                            <?= $book_description; ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- side bar -->
            <div class="col-md-3 col-xs-12 visible-md-block visible-xs-block visible-lg-block">
                <div class="well">
                    <div class="section-title">
                        <h4> Book Archive </h4>
                    </div>
                    <div class="list-group">
                        <div class="row">
                            <div class="col-xs-5">
                                <i class="fas fa-shopping-cart fa-2x"></i>&nbsp;
                                <sup><span id="shoppingCartBadge" class="badge">0</span></sup>
                            </div>
                            <div class="col-xs-7">
                                <form action="books.php" method="post"><input type="submit" class="btn btn-success" title="Pay for Cart" name="payCart" value="pay"></form>
                            </div>
                        </div>

                        <h6>New Arrivals</h6> 
                        <?php

                            $sql = "SELECT * FROM books ORDER BY book_id DESC LIMIT 10";

                            $stmt = $conn->prepare($sql);
                            $stmt->execute();

                            while($lastTenBooks = $stmt->fetch())
                            {
                        ?>
                            <a href="bookDetails.php?book_id=<?= $lastTenBooks['book_id']; ?>&book_description=<?= $lastTenBooks['book_description'];?>&book_price=<?= $lastTenBooks['price'];?>&book_volume=<?= $lastTenBooks['volume'];?>&book_page=<?= $lastTenBooks['page_count'];?>&book_title=<?= $lastTenBooks['book_title'];?>&book_ext1=<?= $lastTenBooks['ext'];?>&book_ext2=<?= $lastTenBooks['ext2'];?>" class="list-group-item">
                                <p class="list-group-item-heading"><?= $lastTenBooks['book_title']; ?></p>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </dvi>
        </div>
    </div>
</div>
<?php
  include_once 'footer/footer.php';
?>

<script type="text/javascript">
    function payWithPaystack()
    {
        var handler = PaystackPop.setup({
            key: 'pk_test_e1de14e19e0aee0cd1169fbe1a5d52de0c3d633a',
            email: '<?= $_SESSION['email_frontEnd'];?>',
            amount: '<?= $total*100; ?>',
            currency: "NGN", 
            ref: '<?php $bytes = bin2hex(random_bytes(10)); $_SESSION['refCode'] = $bytes; echo $_SESSION['refCode']; ?>', // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            full_name: '<?= $_SESSION['full_name_frontEnd']; ?>',
            address: '<?= $_SESSION['address_frontEnd']; ?>',
            phone: '<?= $_SESSION['phone_frontEnd']; ?>',
            metadata: {
                custom_fields: [
                    {
                        display_name: "<?= $_SESSION['full_name_frontEnd']; ?>",
                        variable_name: "<?= $_SESSION['address_frontEnd']; ?>",
                        value: "<?= $_SESSION['phone_frontEnd']; ?>"
                    }
                ]
            },
            callback: function(response)
            {
                const refNum = response.reference;
                if(response.reference === '<?= $bytes; ?>')
                {   
                    XmlHttp
                    (
                        {
                            url: 'backend/verify.php',
                            type: 'POST',
                            data: 'refCode=<?= $bytes; ?>',
                            complete:function(xhr,response,status)
                            {
                                document.getElementById('reportTransaction').innerHTML = response;
                            }
                        }
                    );
                }
            },
        });
        handler.openIframe();
    }

</script>

<script>

    function showShoppingCart(id)
    {
        document.getElementById(id).innerHTML = <?php echo count($_SESSION['shoppingCart']); ?>;
    }

    setInterval("showShoppingCart('shoppingCartBadge')", 1000);

</script>
</body>
</html>