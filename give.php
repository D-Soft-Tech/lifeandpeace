<?php
  session_start();

  include_once 'life/php/db.php';
  include_once 'header/header2.php';

  $conn = get_DB();

  $api =  "
              SELECT api_key FROM account WHERE purpose = :titheAndOffering
          ";

  $stmt = $conn->prepare($api);
  $stmt->bindValue(':titheAndOffering', 'titheAndOffering');
  $apiResource = $stmt->execute();

  $tithe_api_key = $stmt->fetch();

  $tAndD =  "
              SELECT * FROM account WHERE purpose = :titheAndOffering
          ";

  $stmt = $conn->prepare($tAndD);
  $stmt->bindValue(':titheAndOffering', 'titheAndOffering');
  $$tAndDResource = $stmt->execute();

  function disable_button()
  {
    if(isset($_SESSION['username_frontEnd']) && isset($_SESSION['password_frontEnd']) && !empty($_SESSION['username_frontEnd']) && !empty($_SESSION['password_frontEnd']))
    {
        echo "value='give' name='payTitheAndOffering' onclick='getDetails()' type='submit'";
    }
    else{
        echo "data-toggle='tooltip' value='give' data-placement='right' type='button' title='You have to login first'";
    }
  }

  ?>
  <style>
    .newJumbotron {
        color: #fff;
        background-image: url("images/news.jpg");
        background-size: cover;
    }
</style>
  <div class="jumbotron newJumbotron" style="height: 40%; margin-top: 50px;">
    <div class="container">
      <div class="col-md-12" style="width: 80%; padding-top: 5%; margin-left: 7%;">
        <p class="text-justiry" style="color: black; font-size: 1.8em;">
          And I will rebuke the devourer for your sakes
          <hr class="bg-success">
        </p>
          <h3 class="pull-right" style="color: black;">-- Malachi 3 : 12</h3`></br />
          <button type="button" data-toggle="modal" data-target="#bankTransferModal" class="btn btn-primary btn-sm pull-right"> Bank Transfer </button>
      </div>
    </div>
  </div>

  <div id="reportTransaction"></div>

  <div class="conatainer">
    <div class="row">
      <div class=" col-md-12" style="width: 70%; margin-right: 15%; margin-left: 15%;">
        <div class="jumbotron">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                  <label for="purpose">
                      Purpose
                  </label>
              </span>
              <select id="purpose" name="purpose" class="form-control-sm form-control">
                <option value='tithe'>Tithe</option>
                <option value="offering">Offering</option>
                <option value="personalPledge">Personal Pledge</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="details" name="details" placeholder="Short details" required>
          </div>
          <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon">
                      <label for="amount">
                          Amount
                      </label>
                  </span>
                  <input type="number" id="amount" class="form-control" name="amount" required>
              </div>
          </div>
          <div class="form-group">
            <script src="https://js.paystack.co/v1/inline.js"></script>
            <input class="btn btn-primary btn-lg" <?php disable_button(); ?>>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Bank Transfer modal -->

<div class="modal fade bd-example-modal-lg" id="bankTransferModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">USSD / BANK TRANSFER</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                  Choose any of the accounts below if you prefer USSD code or you want to make bank transfer or payment.
                </p>
                <div class="row">
                  <?php
                  
                    while($tithesAndDonations = $stmt->fetch())
                    {
                  
                  ?>
                  <div class="col-md-4 card text-white card-content" style="background-color: rgb(51, 51, 51); 
                  border-color: rgb(51, 51, 51); color: white; margin: 1%; padding: 2px 10px;">
                    <h5 class="text-white card-header card-title" style="color: white;"><?= $tithesAndDonations['account_number']; ?></h5>
                    <p class="card-body">
                    <?= $tithesAndDonations['account_name']; ?><br />
                      (<?= $tithesAndDonations['bank_name']; ?>)
                    </p>
                  </div>
                  <?php
                    }
                  ?>
                </div>
                  Please write the purpose of your giving (i.e tithe, offering or personal pledge) (plus any other message you want to include) 
                  in the description while making the transaction
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
  include_once 'footer/footer.php';
?>

<script>

  function payWithPaystack(purpose, details, amount)
  {
      var handler = PaystackPop.setup({
          key: '<?= $tithe_api_key['api_key']; ?>',
          email: '<?= $_SESSION['email_frontEnd'];?>',
          amount: ''+amount*100,
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
                          url: 'backend/verifyTithesAndOffering.php',
                          type: 'POST',
                          data: 'refCode=<?= $bytes; ?>&purpose='+ purpose + '&details=' + details + '&amount=' +amount,
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

  function getDetails()
  {
    var purpose = document.getElementById('purpose').value;
    var details = document.getElementById('details').value;
    var amount = document.getElementById('amount').value;

    payWithPaystack(purpose, details, amount);
  }

</script>

</body>
</html>