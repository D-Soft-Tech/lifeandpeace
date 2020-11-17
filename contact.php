<?php

include_once 'life/php/db.php';
include_once 'header/header.php';

$conn = get_DB();

$alertMessage = "";

function disable_button()
  {
    if(isset($_SESSION['username_frontEnd']) && isset($_SESSION['password_frontEnd']) && !empty($_SESSION['username_frontEnd']) && !empty($_SESSION['password_frontEnd']))
    {
        echo "value='Send Message' name='submitContactUsMessage' type='submit'";
    }
    else{
        echo "data-toggle='tooltip' name='submitContactUsMessage' value='Send Message' data-placement='right' type='button' title='You have to login first'";
    }
  }

  if(isset($_POST['submitContactUsMessage']) && $_POST['submitContactUsMessage'] === "Send Message")
  {
    $sender = $_SESSION['username_frontEnd'];

    $userID_resource = $conn->query("SELECT user_id FROM users WHERE username = '$sender'");
    $userID = $userID_resource->fetch();
    
    $sanitizer = filter_var_array($_POST, FILTER_SANITIZE_STRING);

    $message = $sanitizer['message'];
    $subject = $sanitizer['subject'];

    $date = date("l, F jS, Y");

    if(!empty($sender) && !empty($message))
    {
      $sqlmessage = "
                        INSERT INTO contacts set contact_subject = :contact_subject, details = :details, date_added = :date_added, user_id = :user_id 
                      ";

      $stmt1 = $conn->prepare($sqlmessage);
      $stmt1->bindValue(':contact_subject', $subject);
      $stmt1->bindValue(':details', $message);
      $stmt1->bindValue(':date_added', $date);
      $stmt1->bindValue(':user_id', $userID['user_id']);

      $check = $stmt1->execute();

      $count = $stmt1->rowCount();

      if($check === true && $count>0)
      {
        $alertMessage = '<div class="alert alert-success alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<div class="">'.
                                '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Thank you, your message has been received!!!</h6>'.
                            '</div>'.
                        '</div>';
      }
      else
      {
        $alertMessage = '<div class="alert alert-danger alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<div class="">'.
                                '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Error sending the message, please try again later!!!</h6>'.
                            '</div>'.
                        '</div>';
      }
    }
    else
      {
        $alertMessage = '<div class="alert alert-danger alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<div class="">'.
                                '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Error sending the message, please try again later. Thank You</h6>'.
                            '</div>'.
                        '</div>';
      }
  }
?>

<!--SUBPAGE HEAD-->
<style>
  #topbar
  {
    background-image: url('images/contactus2.png');
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-size: cover;
    background-blend-mode: inherit;
  }
  #shadow1{
    text-shadow:
      3px 3px 0 #4268B3,  
      3px 3px 0 #4268B3,
      3px 3px 0 #4268B3,
      3px 3px 0 #4268B3;
  }
  #shadow2{
    text-shadow:
      3px 1px 0 #4268B3,  
      3px 1px 0 #4268B3,
      3px 1px 0 #4268B3,
      3px 1px 0 #4268B3;
  }
</style>

<div class="subpage-head has-margin-bottom" id="topbar">
  <div class="container" style="color: #fff; font-weight: bold;">
    <h2><span style="color: #fff;" id="shadow1">Contact us</span></h2>
    <p class="lead" style="font-size: 1.6em;" id="shadow2">Our Church address and contact details</p>
  </div>
</div>

<!-- // END SUBPAGE HEAD -->

<div class="container">
  <div class="row">

    <!-- Alert div for showing if the comment is successfully sent or not -->
    <div class="col-md-12">
      <div class="row">
        <?= $alertMessage; ?>
      </div>
    </div>

    <div class="col-md-6 has-margin-bottom">
      <form id="phpcontactform" method="POST" role="form">
        <div class="form-group">
          <label for="subject">Subject</label>
          <input type="text" class="form-control" placeholder="summarize your message in one sentence" name="subject" id="subject" required>
        </div>
        <div class="form-group">
          <label for="message">Message</label>
          <textarea class="form-control" rows="6" name="message" id="message" placeholder="Your message in full" required></textarea>
        </div>
        <input class="btn btn-primary btn-lg" <?php disable_button(); ?>>
        <span class="help-block loading"></span>
      </form>
    </div>
    <!--// col md 9-->
    
    <div class="col-md-6 has-margin-bottom">
      <h5>OUR ADDRESS</h5>
      <div class="row">
        <div class="col-lg-6">Mount Zion Fortress<br>
          Along New Ibadan - Ife Express Road, Opposite Honors Filling Station <br>
          Adegbayi, Ibadan; Oyo State</div>
        <div class="col-lg-6">Phone: +234 65656565<br>
          Fax: +61 38 376 6284<br>
          Email: <a href="#">lifeandpeace@gmail.com</a></div>
      </div>
      <hr>
      </div>
    </div>
  </div>
</div>

<!-- LOCATION MAP -->
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.707156579709!2d3.9813427497178786!3d7.386676824211546!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xbd047882cd5a5941!2sLife%20and%20Peace%20Commission!5e0!3m2!1sen!2sng!4v1602564445016!5m2!1sen!2sng" 
width="100%" height="450" frameborder="0" style="border:0; margin-bottom: 15px;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

<!-- // END LOCATION MAP  --> 
<?php
  include_once 'footer/footer.php';
?>

</body>
</html>
