<?php
  session_start();

  require_once 'life/php/db.php';
  
  include_once 'header/header2.php';

  $conn = get_DB();

  function disable_button()
  {
    if(isset($_SESSION['username_frontEnd']) && isset($_SESSION['password_frontEnd']) && !empty($_SESSION['username_frontEnd']) && !empty($_SESSION['password_frontEnd']))
    {
        echo "value='Donate Now →' name='donate' onclick='payment()' type='button'";
    }
    else{
        echo "data-toggle='tooltip' name='donate' value='Donate Now →' data-placement='right' type='button' title='You have to login first'";
    }
  }

  $result = $conn->query("SELECT * FROM donation WHERE status = 'on_going'");
  $check = $result->fetchAll();

    if(isset($_GET['searchDonationById']) && !empty($check))
    {
        $sanitizer = filter_var_array($_GET, FILTER_SANITIZE_STRING);

        $donationID = $_GET['searchDonationById'];

        $donationIDNum = $donationID;
        
        $result = $conn->query("SELECT donation.*, account.api_key FROM donation, account WHERE 
        account.id = donation.account_id && donation.id = '$donationID' && status = 'on_going'");
        $donations = $result->fetch();

        $apiKeyToUse = $donations['api_key'];
      ?>
      
      <!--SUBPAGE HEAD-->
      <style>
        #topbar
        {
          background-image: url('images/donations2.png');
          background-attachment: fixed;
          background-repeat: no-repeat;
          background-size: cover;
        }
        #shadow1{
          text-shadow:
            2px 2px 0 #000,  
            2px 2px 0 #000,
            2px 2px 0 #000,
            2px 2px 0 #000;
        }
        #shadow2{
          text-shadow:
            1px 1px 0 #fff,  
            1px 1px 0 #fff,
            1px 1px 0 #fff,
            1px 1px 0 #fff;
        }
      </style>

      <div class="subpage-head" id="topbar" style="margin-bottom: 20px;">
        <div class="container">
          <h4><span id="shadow1" style="color: #fff; font-weight: bold; font-size: 2em;"><?= $donations['title']; ?></span></h4>
          <h6 class="lead text-danger" id="shadow2"><span style="color: red;">Target Date:&nbsp; <?= $donations['target_date']; ?></span></h6>
        </div>
      </div>
      
      <!-- // END SUBPAGE HEAD -->
      <div id="reportTransaction"></div>

      <div class="container">
        <div class="row">
          <div class="col-md-8 has-margin-bottom">
            <article class="blog-content">
              <img src="images/donation/<?= $donations['title']; ?>.<?= $donations['ext']; ?>" alt="charity donation" class="img-responsive has-margin-xs-bottom" style="width: 100%;">
              <p class= "text-justify"><?= $donations['details']; ?></p>
            </article>
          </div>
          <!--// col md 9--> 
          
          <!--Sidebar-->
          <div class="col-md-4"> 
            
            <!--Donate Box-->
            <div class="charity-box has-margin-xs-bottom">
              <div class="charity-desc">
                <?php
      
                  $donation_id = $donations['id'];
      
                  $sql_transc =   "
                                      SELECT sum(amount) AS amount FROM transactions, donation WHERE purpose = 'donation' && purpose_id = '$donation_id' && donation.status = 'on_going' && donation.id = transactions.purpose_id
                                  ";

                  $pldg_amount = $conn->query($sql_transc);

                  $pledged = $pldg_amount->fetchColumn();
                  
                  $prg_percent = ceil(abs($pledged/$donations['target_amount']) * 100);
      
      
                ?>
                <h2 class="pledged-amount has-no-margin">#<?php echo number_format($pledged); ?></h2>
                <p>Pledged out of <span class="text-danger"> #<?= number_format($donations['target_amount']); ?></span> goal</p>
                <div class="progress">
                  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $prg_percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $prg_percent; ?>%"><span class="sr-only"><?= $prg_percent; ?>% Complete</span><?= $prg_percent; ?>%</div>
                </div>
                <div class="clearfix">
                  <div>
                    <?php
                      $propose_date = $donations['target_date'];
    
                      $proposed_date = strtotime($propose_date);
                      $currentDate = date('F jS, Y');
                      $currentTime = strtotime($currentDate);

                      if($currentTime < $proposed_date)
                      {
                        $daysLeft = ceil(abs($proposed_date - $currentTime)/86400);
                      }
                      elseif($proposed_date === $currentTime)
                      {
                        $daysLeft = '0';
                      }
                      else
                      {
                        $daysLeft = "Target date already passed";
                      }
                    ?>
                    <h3 class="pledged-amount text-center text-danger"><?= $daysLeft; ?></h3>
                    <p class="text-center text-danger">Days left</p>
                  </div>
                </div>
                <div class="text-center has-margin-xs-top">
                  <script src="https://js.paystack.co/v1/inline.js"></script>
                  <input type="number" name="donateAmount" placeholder="Enter amount to donate" style="margin-bottom: 10px;" class="form-control" id="amountToDonate">
                  <input class="btn btn-primary btn-lg" <?php disable_button(); ?>>
                </div>
              </div>
            </div>
            <!--// END Donate Box-->
            
            <div class="vertical-links has-margin-xs-bottom">
              <h4>Other Donations</h4>
              <?php
      
                $sql_donations = "
                                    SELECT * FROM donation WHERE status = 'on_going'
                                  ";
      
                $stmtAll = $conn->prepare($sql_donations);
                $stmtAll->execute();
      
              ?>
              <ul class="list-unstyled">
                <?php
                  while($allDonations1 = $stmtAll->fetch())
                  {
                  ?>
                    <li><a href="charity-donation.php?searchDonationById=<?= $allDonations1['id']; ?>"><?= $allDonations1['title']; ?></a></li>
                <?php
                  }
                ?>
              </ul>
            </div>
            <div class="tag-cloud has-margin-bottom"> 
              <a href="blog.php">bulletin</a> 
              <a href="events-programs.php">programs</a>
              <a href="events-programs.php">events</a> 
              <a href="index.php">church</a>
              <a href="charity-doantion.php">donation</a> 
              <a href="image-gallery.php">gallery</a> 
              <a href="#">audio messages</a>
              <a href="#">video messages</a> 
              <a href="about.php">about</a>
              <a href="contact.php">contact</a> 
            </div>
          </div>
        </div>
      </div>
    <?php
    }
    elseif (!isset($_GET['searchDonationById']) && !empty($check)){
        $result = $conn->query("SELECT donation.*, account.api_key FROM donation, account WHERE status = 'on_going' LIMIT 1, 1");
        $donations = $result->fetch();

        $apiKeyToUse = $donations['api_key'];

        include_once 'header/header2.php';
      ?>
          
          <!--SUBPAGE HEAD-->
          <?php
            $donationIDNum = $donations['id'];
          ?>
          
          <style>
            #topbar
            {
              background-image: url('images/donations2.png');
              background-attachment: fixed;
              background-repeat: no-repeat;
              background-size: cover;
            }
            #shadow1{
              text-shadow:
                2px 2px 0 #000,  
                2px 2px 0 #000,
                2px 2px 0 #000,
                2px 2px 0 #000;
            }
            #shadow2{
              text-shadow:
                1px 1px 0 #fff,  
                1px 1px 0 #fff,
                1px 1px 0 #fff,
                1px 1px 0 #fff;
            }
          </style>

          <div class="subpage-head" id="topbar" style="margin-bottom: 20px;">
            <div class="container">
              <h4><span id="shadow1" style="color: #fff; font-weight: bold; font-size: 2em;"><?= $donations['title']; ?></span></h4>
              <h6 class="lead text-danger" id="shadow2"><span style="color: red; font-size: +1.2em;">Target Date:&nbsp; <?= $donations['target_date']; ?></span></h6>
            </div>
          </div>
          
          <!-- // END SUBPAGE HEAD -->
          <div id="reportTransaction"></div>

          <div class="container">
            <div class="row">
              <div class="col-md-8 has-margin-bottom">
                <article class="blog-content">
                  <img src="images/donation/<?= $donations['title']; ?>.<?= $donations['ext']; ?>" alt="charity donation" class="img-responsive has-margin-xs-bottom" style="width: 100%;">
                  <p class= "text-justify"><?= $donations['details']; ?></p>
                </article>
              </div>
              <!--// col md 9--> 
              
              <!--Sidebar-->
              <div class="col-md-4"> 
                
                <!--Donate Box-->
                <div class="charity-box has-margin-xs-bottom charity-desc">
                  <?php
        
                    $donation_id = $donations['id'];
        
                    $sql_transc = "
                    SELECT sum(amount) AS amount FROM transactions, donation WHERE purpose = 'donation' && purpose_id = '$donation_id' && donation.status = 'on_going' && donation.id = transactions.purpose_id
                                  ";
        
                    $pldg_amount = $conn->prepare($sql_transc);
                    $pldg_amount->bindParam(':id', $donation_id);
                    $pldg_amount->execute();
        
                    $pledged = $pldg_amount->fetchAll();

                    $pledged= $pledged[0]['amount'];

                    $prg_percent = ceil(abs($pledged/$donations['target_amount']) * 100);
        
        
                  ?>
                  <h2 class="pledged-amount has-no-margin">#<?php echo number_format($pledged); ?></h2>
                  <p>Pledged out of <span class="text-danger"> #<?= number_format($donations['target_amount']); ?></span> goal</p>
                  <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $prg_percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $prg_percent; ?>%"><span class="sr-only"><?= $prg_percent; ?>% Complete</span><?= $prg_percent; ?>%</div>
                  </div>
                  <div class="clearfix">
                    <div>
                      <?php
                          $propose_date = $donations['target_date'];
  
                          $proposed_date = strtotime($propose_date);
                          $currentDate = date('F jS, Y');
                          $currentTime = strtotime($currentDate);
    
                          if($currentTime < $proposed_date)
                          {
                            $daysLeft = ceil(abs($proposed_date - $currentTime)/86400);
                          }
                          elseif($proposed_date === $currentTime)
                          {
                            $daysLeft = 0;
                          }
                          else
                          {
                            $daysLeft = "Target date already passed";
                          }
                      ?>
                      <h3 class="pledged-amount text-center text-danger"><?= $daysLeft; ?></h3>
                      <p class="text-center text-danger">Days left</p>
                    </div>
                  </div>
                  <div class="text-center has-margin-xs-top"> 
                    <script src="https://js.paystack.co/v1/inline.js"></script>
                    <input type="number" name="donateAmount" placeholder="Enter amount to donate" style="margin-bottom: 10px;" class="form-control" id="amountToDonate">
                    <input class="btn btn-primary btn-lg" <?php disable_button(); ?>> 
                  </div>
                </div>
                <!--// END Donate Box-->
                
                <div class="vertical-links has-margin-xs-bottom">
                  <h4>Other Donations</h4>
                  <?php
          
                    $sql_donations = "
                                        SELECT * FROM donation WHERE status = 'on_going'
                                      ";
          
                    $stmtAll = $conn->prepare($sql_donations);
                    $stmtAll->execute();
          
                  ?>
                  <ul class="list-unstyled">
                    <?php
                      while($allDonations = $stmtAll->fetch())
                      {
                      ?>
                        <li><a href="charity-donation.php?searchDonationById=<?= $allDonations['id']; ?>"><?= $allDonations['title']; ?></a></li>
                    <?php
                      }
                    ?>
                  </ul>
                </div>
                <div class="tag-cloud has-margin-bottom"> 
                  <a href="blog.php">bulletin</a> 
                  <a href="events-programs.php">programs</a>
                  <a href="events-programs.php">events</a> 
                  <a href="index.php">church</a>
                  <a href="charity-doantion.php">donation</a> 
                  <a href="image-gallery.php">gallery</a> 
                  <a href="#">audio messages</a>
                  <a href="#">video messages</a> 
                  <a href="about.php">about</a>
                  <a href="contact.php">contact</a> 
                </div>
              </div>
            </div>
          </div>
    <?php
    }
    else
    {
    ?>
      <div class="subpage-head" style="margin-bottom: 20px;">
        <div class="container">
          <h4>Thank You for checking</h4>
          <h6 class="lead text-danger">But there is no ongoing donation at the moment!!! <br /> <br /> Please check back later</h6>
        </div>
      </div>

    <?php
    }

      include_once 'footer/footer.php';
      
    ?>
    
    <script>

      function payWithPaystack(id)
      {
          var donateAmount = id;

          var handler = PaystackPop.setup({
              key: '<?= $apiKeyToUse; ?>',
              email: '<?= $_SESSION['email_frontEnd'];?>',
              amount: ''+donateAmount * 100,
              currency: "NGN", 
              ref: '<?php $bytes = bin2hex(random_bytes(10)); $_SESSION['refCode'] = $bytes; echo $_SESSION['refCode']; ?>',
              full_name: '<?= $_SESSION['full_name_frontEnd']; ?>',
              address: '<?= $_SESSION['address_frontEnd']; ?>',
              phone: '<?= $_SESSION['phone_frontEnd']; ?>',
              metadata: {
                  custom_fields: [
                      {
                          display_name: '<?= $_SESSION['full_name_frontEnd']; ?>',
                          variable_name: '<?= $_SESSION['address_frontEnd']; ?>',
                          value: '<?= $_SESSION['phone_frontEnd']; ?>'
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
                              url: 'backend/verifyDonation.php',
                              type: 'POST',
                              data: 'refCode=<?= $bytes; ?>&donateAmount='+donateAmount+'&donationID=<?= $donationIDNum; ?>',
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

      function payment()
      {
        var amountToDonate = document.getElementById('amountToDonate').value;

        payWithPaystack(amountToDonate);
      }
    </script>
    
    </body>
    </html>