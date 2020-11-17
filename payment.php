<?php

    session_start();

    include_once 'life/php/db.php';

    $conn = get_DB();

    if(isset($_POST['submitRemove']) && $_POST['submitRemove'] === "submitRemove")
    {
        if(isset($_SESSION['username_frontEnd']))
        {   
            $romeveBook_id = $_POST['removeBookFromCart'];
            $keyOfElementToRemove = array_search($removeBook_id, $_SESSION['shoppingCart']);
            unset($_SESSION['shoppingCart'][$keyOfElementToRemove]);
            $_SESSION['shoppingCart'] = array_values($_SESSION['shoppingCart']);
        } 
    }

    if(isset($_SESSION['username_frontEnd']))
    {
        if(isset($_SESSION['shoppingCart']) && !empty($_SESSION['shoppingCart']))
        {
            $book_id = $_SESSION['shoppingCart'];
            $userName = $_SESSION['username_frontEnd'];

            $sql_userDetails =  "
                                    SELECT * FROM users WHERE username = :userName
                                ";

            $stmt1 = $conn->prepare($sql_userDetails);
            $stmt1->bindValue(':userName', $userName);
            $userResources = $stmt1->execute();

            $userDetails = $stmt1->fetch();

            //getting the api_key to use
            $api =  "
                        SELECT api_key FROM account WHERE purpose = :book
                    ";

            $stmt = $conn->prepare($api);
            $stmt->bindValue(':book', 'book');
            $stmt->execute();

            $api_key = $stmt->fetch();
            
            include_once 'header/header2.php';
            include_once 'life/php/indexpage.php';
        ?>
           <style>
                #pay a{
                    width: 30%; 
                    background-color: white; 
                    border: 2px solid #449D44;
                }
                #pay a:hover{
                    background-color: #DFF0D8;
                }
           </style>
            <div class="subpage-head" style="margin-bottom: 10px;">
                <div class="container">
                    <h4 class="text-center">Make Payment</h4>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-9 col-xs-12 px-auto" id="reportTransaction">
                        <h6 Class="bg-success text-center" style="padding: 10px;">Books in your shopping Cart</h6>
                        <div class="col-xs-12 pull-center">

                            <!-- Shopping Cart Details -->
                            <?php
                                $total= 0;
                                for($i = 0; $i<COUNT($book_id); ++$i)
                                {
                                    $sql_book = "
                                                    SELECT * FROM books WHERE book_id = :book_id
                                                ";

                                    $stmt = $conn->prepare($sql_book);
                                    $stmt->bindParam(':book_id', $book_id[$i]);
                                    $stmt->execute();
                                    $bookDetails = $stmt->fetch();

                                    $total += $bookDetails['price'];

                            ?>  
                                    <div class="row" style="margin-bottom: 10px;" id="<?= $bookDetails['book_id']; ?>">
                                        <div class="col-xs-4 col-md-2 text-center">
                                            <img class="img-responsive" src="images/books/<?= $bookDetails['book_title'];?>.<?= $bookDetails['ext'];?>" style="height: 150px; width: 100%;" alt="">
                                        </div>
                                        <div class="col-xs-8 col-md-10">
                                            <div class="row">
                                                <div class="col-xs-12 well" id="height" style="margin-right: 10px;">
                                                    <p><strong><?= $bookDetails['book_title'];?></strong></p>
                                                    <p>Price: <span><?= $bookDetails['price'];?></span></p>
                                                    <p>
                                                        <form method="POST">
                                                            <input type="text" name="removeBookFromCart" value="<?= $bookDetails['book_id']; ?>" hidden>
                                                            <button type="submit" class="btn btn-danger btn-xs" name="submitRemove" value="submitRemove">
                                                                Remove from cart
                                                            </button>
                                                        </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php 
                                }
                            ?>
                            <!-- /Shopping Cart Details -->

                            <div class="row" id="pay">
                                <div class="col-12" style="font-size: 1.0em;">
                                    <h6 Class="bg-success text-center" style="padding: 10px;">Summary</h6>
                                    <p class="text-center"><strong> Number of Items: <span><?= COUNT($book_id); ?></span></strong></p>
                                    <p class="text-center"><strong>Total: <span>
                                        <?= $total; ?>
                                    </span></strong></p>
                                    <p class="text-center">
                                        <script src="https://js.paystack.co/v1/inline.js"></script>
                                        <a class="btn text-center" value="<?= $total; ?>" onclick='payWithPaystack()' role="button">
                                            Pay
                                        </a>
                                    </p>
                                </div>
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

        <script>

            function payWithPaystack()
            {
                var handler = PaystackPop.setup({
                    key: '<?= $api_key['api_key']; ?>',
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