<?php
  session_start();
  include_once 'header/header2.php';
  include_once 'life/php/db.php';

  $conn = get_DB();

  $alertMessage = "";

  function disable_button()
  {
    if(isset($_SESSION['username_frontEnd']) && isset($_SESSION['password_frontEnd']) && !empty($_SESSION['username_frontEnd']) && !empty($_SESSION['password_frontEnd']))
    {
        echo "value='submit' name='submitAddTestimony' type='submit'";
    }
    else{
        echo "data-toggle='tooltip' value='Submit' data-placement='right' type='button' title='You have to login first'";
    }
  }
  
  if(isset($_POST['submitAddTestimony']) && $_POST['submitAddTestimony'] === "submit")
  {
    $testifier = $_SESSION['username_frontEnd'];

    $userID_resource = $conn->query("SELECT user_id FROM users WHERE username = '$testifier'");
    $userID = $userID_resource->fetch();
    
    $sanitizer = filter_var_array($_POST, FILTER_SANITIZE_STRING);

    $subject = $sanitizer['subject'];
    $message = $sanitizer['message'];

    $date = date("l, F jS, Y");

    if(!empty($testifier) && !empty($subject) && !empty($message))
    {
      $sqlTestimony = "
                        INSERT INTO testimonies set title = :title, details = :details, date_added = :date, user_id = :user_id 
                      ";

      $stmt1 = $conn->prepare($sqlTestimony);
      $stmt1->bindValue(':title', $subject);
      $stmt1->bindValue(':details', $message);
      $stmt1->bindValue(':date', $date);
      $stmt1->bindValue(':user_id', $userID['user_id']);

      $check = $stmt1->execute();

      $count = $stmt1->rowCount();

      if($check === true && $count>0)
      {
        $alertMessage = '<div class="alert alert-success alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<div class="">'.
                                '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Thank you for sharing your testimony!!!</h6>'.
                            '</div>'.
                        '</div>';
      }
      else
      {
        $alertMessage = '<div class="alert alert-danger alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<div class="">'.
                                '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Error sending the Testimony, please try again later!!!</h6>'.
                            '</div>'.
                        '</div>';
      }
    }
    else
      {
        $alertMessage = '<div class="alert alert-danger alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<div class="">'.
                                '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Error sending the Testimony, please try again later!!!</h6>'.
                            '</div>'.
                        '</div>';
      }
  }

  function get_month()
  {
    if (isset($_POST['month']) && $_POST['month'] !== "") {
        return $_POST['month'];
    }elseif(isset($_GET['month']) && $_GET['month'] !== ""){
        return $_GET['month'];
    }
    else{ return date("F");}
  }

  function get_year()
  {
    if (isset($_POST['year']) && $_POST['year'] !== "") {
        return $_POST['year'];
    }elseif (isset($_GET['year']) && $_GET['year'] !== "") {
        return $_GET['year'];
    }
    else{ return date("Y");}
  }


  $month = get_month();
  $year = get_year();

  $limit = 2;
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
  $result = $conn->query("SELECT testimonies.*, users.full_name AS full_name FROM testimonies, users WHERE testimonies.status = 'read' && testimonies.user_id = users.user_id && date_added LIKE '%$month%$year' ORDER BY testimonies.id DESC LIMIT $start, $limit");
  $testimonies = $result->fetchAll();

  $result1 = $conn->query("SELECT count(testimonies.id) AS id FROM testimonies, users WHERE testimonies.status = 'read' && testimonies.user_id = users.user_id && date_added LIKE '%$month%$year'");
  $custCount = $result1->fetchAll();
  $total = $custCount[0]['id'];

  function pages()
  {
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

  function previous()
  {
      global $pages;
      if($pages <=5){
          return 5;
      }else{
          return $pages - 5;
      }
  }
  $Previous = previous();

  function nextArrow()
  {
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

<!--SUBPAGE HEAD-->
<style>
  #topbar
  {
    background-image: url('images/testimony.png');
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-size: cover;
    background-blend-mode: inherit;
  }
  #shadow1{
    text-shadow:
      3px 3px 0 #000,  
      3px 3px 0 #000,
      3px 3px 0 #000,
      3px 3px 0 #000;
  }
  #shadow2{
    text-shadow:
      1px 1px 0 #000,  
      1px 1px 0 #000,
      1px 1px 0 #000,
      1px 1px 0 #000;
  }
</style>

<div class="subpage-head" id="topbar">
  <div class="container" style="color: #fff; font-weight: bold;">
    <h3><span style="color: #fff; font-size: 1.2em;" id="shadow1">Testimonies</span></h3>
    <p class="lead" style="font-size: 1.6em;" id="shadow2">For He is good and His mercies endureth forever</p>
  </div>
</div>

<!-- // END SUBPAGE HEAD -->

<div class="container">
  <div class="row">

  <div class="col-md-12">
    <div class="row">
      <?= $alertMessage; ?>
    </div>
  </div>

  <div class="col-md-12">
    <div class="row mt-0 text-center" style="margin-top: 0px;">
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <li>
              <a href="testimony.php?pages=<?= $Previous; ?>&page=<?= $page; ?>&month=<?= $month; ?>&year=<?= $year; ?>" 
                  class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Previous">
                  <span aria-hidden="true">&laquo; </span>
              </a>
          </li>
          <?php 
              $i = $pages > 5 ? $pages - 4 : 1;
              for($i; $i<= $pages; $i++)
              {
              ?>
              <li><a href="testimony.php?page=<?= $i; ?>&pages=<?= $pages; ?>&month=<?= $month; ?>&year=<?= $year; ?>" class="btn btn-transition btn btn-sm btn-outline-primary"><?= $i; ?></a></li>
              <?php 
              }
          ?>
          <li>
              <a href="testimony.php?pages=<?= $Next; ?>&page=<?= $page; ?>&month=<?= $month; ?>&year=<?= $year; ?>"
              class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
              </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>

  <div class="col-md-9 has-margin-bottom">
  
    <section class="comments-block">
      <?php foreach($testimonies as $testimonies) :  ?>
      <div class="media"> <a class="pull-left" href="#"> <img class="media-object lazy" alt="avatar" data-src="images/avatar-2.jpg"> </a>
        <div class="media-body">
          <h4 class="media-heading"><?= $testimonies['title']; ?></h4>
          <p class="text-muted">Posted on <?= $testimonies['date_added']; ?> by <a class="text-danger"><?= $testimonies['full_name']; ?></a></p>
          <p class="text-justify">
            <?= $testimonies['details']; ?>
          </p>
        </div>
      </div>
      <?php endforeach; ?>
    </section>

    <section class="post-comment-form">
      <h3 class="comments-head">Add your Testimony</h3>
      <form class="form" method="POST" role="form">
        <div class="row">
          <div class="form-group col-md-12">
            <input type="text" name="subject" class="form-control input-lg" placeholder="Summarize your testimony in one Sentence" required>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-12">
            <textarea cols="8" rows="4" name="message" class="form-control input-lg" placeholder="Your Testimony in full details" required></textarea>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-12">
            <input class="btn btn-primary btn-lg" <?php disable_button(); ?>>
          </div>
        </div>
      </form>
    </section>
  </div>
  <!--// col md 9--> 
  
  <!--Blog Sidebar-->
  <div class="col-md-3">
    <div class="col-xs-12 well">
      <h4>Share yours</h4>
      <p>For We overcame by the blood of the Lamb <em><b>and by the word of our testimony</b></em>... 
      <br />
        <b class="pull-right"> --- Rev. 12 : 11 </b>
      </p>
    </div>
    <div class="row vertical-links has-margin-xs-bottom">
      <div class="col-xs-12">
        <h4>Archive of Testimonies</h4>
      </div>
      <div class="col-xs-12">
        <div class="row">
          <div class="col-xs-12" style="margin-bottom: 5px;">
            <span class="font-weight-bold">Search By</span>
          </div>
          <div class="col-xs-12" style="margin-bottom: 5px;">
            <form method="POST">
              <div class="form-row">
                <div class="col-xs-6" style="padding-right: 2px;">
                  <select id="month" name="month" class="form-control-sm form-control">
                    <option>Month </option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                  </select>
                </div>
                <div class="col-xs-6" style="padding-left: 2px;">
                  <div class="row">
                    <div class="col-xs-9" style="padding-right: 2px;">
                        <select id="year" name="year" class="form-control-sm form-control">
                            <option>Year</option>
                            <?php
                                for ($now= "2020"; $now <= date("Y"); $now++) { 
                                    echo '<option value="'.$now.'">' . $now . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-3" style="padding-left: 2px;">
                        <button name="filtered_search" value="filtered_search" class="btn btn-transition btn btn-sm btn-outline-success"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
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
  include_once 'footer/footer.php';
?>

</body>
</html>
