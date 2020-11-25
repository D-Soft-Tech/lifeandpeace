<?php

    session_start();

    include_once 'life/php/db.php';

    $conn = get_DB();

    include_once 'backend/downloadlogic.php';

    if(isset($_SESSION['username_frontEnd']) && isset($_GET['refCode']) && !empty($_GET['refCode']) && strlen($_GET['refCode']) === 20)
    {
        $sanitizer = filter_var_array($_GET, FILTER_SANITIZE_STRING);
        $refCode = $sanitizer['refCode'];

        $sql_refCode =  "
                                SELECT books.book_title, books.book_id, books.volume, books.ext, books.ext2 FROM books, transactions
                                 WHERE transactions.reference = :refCode && transactions.purpose_id = books.book_id && transactions.transc_status = 'pending'
                            ";

        $stmtRef = $conn->prepare($sql_refCode);
        $stmtRef->bindValue(':refCode', $refCode);

        if(isset($_SESSION['shoppingCart']) && !empty($_SESSION['shoppingCart']) && $stmtRef->execute() === true)
        {
            $booksToDownload = $stmtRef->fetchAll();
            include_once 'header/header2.php';
            include_once 'life/php/indexpage.php';
        ?>
           
            <div class="subpage-head" style="margin-bottom: 10px;">
                <div class="container">
                    <h4 class="text-center">Download Portal</h4>
                </div>
            </div>
            <div id="response"><?php $response = ""; echo $response; ?></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-9 col-xs-12 px-auto" id="reportTransaction">
                        <h6 Class="bg-success text-center" style="padding: 10px;">Books in your shopping Cart</h6>
                        <div class="col-xs-12 pull-center">

                            <!-- Shopping Cart Details -->
                            <?php

                                foreach($booksToDownload AS $booksToDownload) : 
                            ?>  
                                    <div class="row" style="margin-bottom: 10px;" id="<?= $booksToDownload['book_id']; ?>">
                                        <div class="col-xs-4 col-md-2 text-center">
                                            <img class="img-responsive lazy" data-src="images/books/<?= $booksToDownload['book_title'];?>.<?= $booksToDownload['ext'];?>" style="height: 150px; width: 100%;" alt="">
                                        </div>
                                        <div class="col-xs-8 col-md-10">
                                            <div class="row">
                                                <div class="col-xs-12 well" id="height" style="margin-right: 10px;">
                                                    <p><strong><?= $booksToDownload['book_title'];?></strong></p>
                                                    <p>
                                                        <form method="POST">
                                                            <input type="text" name="downLoadNow" value="<?= $booksToDownload['book_title']; ?>" hidden>
                                                            <input type="text" name="downLoadFormat" value="<?= $booksToDownload['ext2']; ?>" hidden>
                                                            <input type="text" name="downLoadId" value="<?= $booksToDownload['book_id']; ?>" hidden>
                                                            <input type="text" name="downLoadRef" value="<?= $refCode; ?>" hidden>
                                                            <button type="submit" class="btn btn-success btn-xs" name="download" value="download">
                                                                Download now
                                                            </button>
                                                        </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php 
                                endforeach;
                            ?>
                            <!-- /Shopping Cart Details -->
                        </div>
                    </div>

                    <!-- side bar -->
                    <div class="col-md-3 col-xs-12 visible-md-block visible-xs-block visible-lg-block">
                        <div class="well">
                            <div class="section-title">
                                <h4> Book Archive </h4>
                            </div>
                            <div class="list-group">
                                <div>
                                    <div class="blog-search has-margin-xs-bottom">
                                        <div class="input-group input-group-lg">
                                            <input type="text" class="form-control" placeholder="Search..">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search glyphicon-lg"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="book_search"></div>
                                </div>
                                <h6>New Arrivals</h6> 
                                <a href="#" class="list-group-item">
                                    <p class="list-group-item-heading">Heavens and the earth Heavens and the earth</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <p class="list-group-item-heading">Heavens and the earth</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <p class="list-group-item-heading">Heavens and the earth</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <p class="list-group-item-heading">Heavens and the earth</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <p class="list-group-item-heading">Heavens and the earth</p>
                                </a>
                                <a href="#" class="list-group-item">
                                    <p class="list-group-item-heading">Heavens and the earth</p>
                                </a>
                            </div>
                        </div>
                    </dvi>
                </div>
            </div>
        </div>
        <?php
        include_once 'footer/footer.php';
        ?>

        <script>

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

        </body>
        </html>
<?php
        }
        else{
            header('Location: books.php');
        }
    }
    else{
        header('Location: books.php');
    }
?>