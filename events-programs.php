<?php

  session_start();
  
  include_once 'life/php/db.php';

  $conn = get_DB();

  
  $sanitizer1 = filter_var_array($_POST, FILTER_SANITIZE_STRING);
  $sanitizer2 = filter_var_array($_GET, FILTER_SANITIZE_STRING);

  function truncate($string)
  {
    // strip tags to avoid breaking any html
    $string = strip_tags($string);
    if (strlen($string) > 100) {

        // truncate string
        $stringCut = substr($string, 0, 500);
        $endPoint = strrpos($stringCut, ' ');

        //if the string doesn't contain any space then it will cut without word basis.
        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
    }
    return $string;
  }

  function get_month()
  {
    if (isset($_POST['month']) && $_POST['month'] !== "") {
        return $_POST['month'];
    }elseif(isset($_GET['month']) && $_GET['month'] !== ""){
        return $sanitizer2['month'];
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
  $result = $conn->prepare("SELECT * FROM event WHERE event_from LIKE '%$month%$year' ORDER BY event_id DESC LIMIT $start, $limit");
  $result->execute();
  $events = $result->fetchAll();

  $result1 = $conn->prepare("SELECT count(event_id) AS id FROM event WHERE event_from LIKE '%$month%$year'");
  $result1->execute();
  $custCount = $result1->fetchAll();
  $total = $custCount[0]['id'];

  function pages()
  {
      global $pages;
      if(isset($_GET['pages']) && $pages === null){
          return $sanitizer2['pages'];
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

  include_once 'header/header2.php';
?>

  </div>
</div>
<!--// Navbar Ends--> 

<!--SUBPAGE HEAD-->

<div class="subpage-head" style="margin-bottom: 15px;">
  <div class="container">
    <h3>Programs &amp; Events </h3>
    <p class="lead">List of Upcoming Events and Programs</p>
  </div>
</div>
<!-- // END SUBPAGE HEAD -->

<div class="container">
  <div class="row">
    <div class="col-md-9 has-margin-bottom"> 

      <div class="row">
        <div class="col-md-12 mt-0 text-center" style="margin-top: 0px;">
          <nav aria-label="Page navigation">
            <ul class="pagination">
              <li>
                  <a href="events-programs.php?pages=<?= $Previous; ?>&page=<?= $page; ?>&month=<?= $month; ?>&year=<?= $year; ?>" 
                      class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Previous">
                      <span aria-hidden="true">&laquo; </span>
                  </a>
              </li>
              <?php 
                  $i = $pages > 5 ? $pages - 4 : 1;
                  for($i; $i<= $pages; $i++)
                  {
                  ?>
                  <li><a href="events-programs.php?page=<?= $i; ?>&pages=<?= $pages; ?>&month=<?= $month; ?>&year=<?= $year; ?>" class="btn btn-transition btn btn-sm btn-outline-primary"><?= $i; ?></a></li>
                  <?php 
                  }
              ?>
              <li>
                  <a href="events-programs.php?pages=<?= $Next; ?>&page=<?= $page; ?>&month=<?= $month; ?>&year=<?= $year; ?>"
                  class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                  </a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-md-12">
          <!--Event list-->
          <?php foreach($events as $events) :  ?>
            <div class="row">
              <div class="col-md-4">
                <div class="highlight-bg has-padding-xs event-details">
                  <div class="ed-title">EVENT DETAILS</div>
                  <div class="ed-content"> <span class="glyphicon glyphicon-calendar">
                    </span> <?= $events['event_from']; ?> <?php if($events['event_to']){echo " to ". $events['event_to']; }?> <br>
                    <span class="glyphicon glyphicon-time"></span> <?= $events['event_time']; ?> <br>
                  </div>
                </div>
              </div>
              <div class="col-md-8 bulletin">
                <h4 class="media-heading"><?= $events['theme']; ?></h4>
                <p class="media-content"><?= truncate($events['details']); ?></p>
                <a class="btn btn-primary" 
                href="event-single.php?theme=<?= $events['theme']; ?>&time=<?php if($events['event_time']){echo $events['event_time']; }else{echo "";}?>&details=<?= $events['details']; ?>&from=<?= $events['event_from']; ?>&to=<?php if(isset($events['event_to'])){echo $events['event_to']; }else{echo "";}?>&ext=<?= $events['ext']; ?>" role="button">Event Details →</a>
              </div>
            </div>
            <hr />
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <!--// col md 9--> 
    
    <!--Sidebar-->
    <div class="col-md-3">
      <div class="row has-margin-md-bottom">
        <div class="col-md-12">
          <h5>Event Categories</h5>
        </div>
        <div class="col-md-12" style="margin-bottom: 15px;">
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
        <div class="col-xs-12 well" style="margin-top: 15px;">
          <h4>About</h4>
          <p>Join us for these events for a life changing encounter<em><b> with the Lord</b></em>... 
          <br />
            <b class="pull-right"> --- Miss nothing heavenly</b>
          </p>
        </div>
        <div class="col-md-12 tag-cloud has-margin-bottom"> 
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
</div>
<?php
  include_once 'footer/footer.php';
?>

</body>
</html>
