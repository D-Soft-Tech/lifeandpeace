<?php

  session_start();
  
  include_once 'life/php/db.php';

  $conn = get_DB();

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

  function get_day()
  {
    if(isset($_GET['day']) && !empty($_GET['day']))
    {
        $sanitizer = filter_var_array($_GET, FILTER_SANITIZE_STRING);

        $day = $sanitizer['day'];

        return $day;
    }
    else
    {
        return 'Sunday';
    }
  }

  $day = get_day();

  $result = $conn->prepare("SELECT * FROM weekly_meeting WHERE meeting_day LIKE ? ORDER BY meeting_id DESC");
  $result->execute([$day]);
  $events = $result->fetchAll();

  include_once 'header/header2.php';
?>

  </div>
</div>
<!--// Navbar Ends--> 

<!--SUBPAGE HEAD-->

<style>
  #topbar
  {
    background-image: url('images/program.png');
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-size: cover;
    background-blend-mode: inherit;
    text-shadow:
      1px 1px 0 #4268B3,  
      1px 1px 0 #4268B3,
      1px 1px 0 #4268B3,
      1px 1px 0 #4268B3;
  }
</style>

<div class="subpage-head" id="topbar" style="margin-bottom: 15px;">
  <div class="container" style="color: #fff; font-weight: bold;">
    <h3><span style="color: #fff;">Weekly Program</span></h3>
    <p class="lead" style="font-size: 1.6em;">List of our weekly meetings </p>
  </div>
</div>
<!-- // END SUBPAGE HEAD -->

<div class="container">
  <div class="row">
    <div class="col-md-12 mt-0 text-center" style="margin-top: 0px;">
        <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php 
            $weekDay = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
            $dayOfTheWeek = array('Su', 'M', 'T', 'W', 'Th', 'F', 'S');
                for($i=0; $i< COUNT($dayOfTheWeek); ++$i)
                {
                ?>
                <li><a href="weeklyProgram.php?day=<?= $weekDay[$i]; ?>" class="btn btn-transition btn btn-sm btn-outline-primary"><?= $dayOfTheWeek[$i]; ?></a></li>
                <?php 
                }
            ?>
        </ul>
        </nav>
    </div>
    
    <?php foreach($events as $events) :  ?>

    <div class="col-md-12">
        <h5><?= $events['title']; ?></h5>
    </div>
    
    <div class="col-md-9 has-margin-bottom"> 

      <div class="row">
        <div class="col-md-12">
          <!--Event list-->
            <div class="row">
              <div class="col-md-12">
                <article class="blog-content">
                    <img src="images/event/weeklyProgram/<?= $events['title']; ?>.<?= $events['ext']; ?>" alt="<?= $events['title']; ?>"  
                    class="img-responsive has-margin-xs-bottom" />
                    <p class="text-justify"><?= $events['meeting_details']; ?></p>
                </article>
              </div>
            </div>
        </div>
      </div>
    </div>
    <!--// col md 9--> 
    
    <!--Sidebar-->
    <div class="col-md-3">
      <div class="row has-margin-md-bottom">
        <div class="highlight-bg has-padding event-details has-margin-xs-bottom">
            <div class="ed-title">
                <?= $events['title']; ?>
            </div>
            <div class="ed-content">
                <span class="glyphicon glyphicon-calendar"> 
                </span> <?= $events['meeting_day']; ?> <br>
                <span class="glyphicon glyphicon-user"> 
                </span> <?= $events['anchor']; ?> <br>
                <span class="glyphicon glyphicon-phone"> 
                </span> <?= $events['phone']; ?> <br>
                <span class="glyphicon glyphicon-time"> </span> <?= $events['meeting_time']; ?> <br>
            </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="row">
    <div class="col-xs-12" style="margin-bottom: 10px;">
        <h5><i class="fa fa-2x fa-map-marker"></i> &nbsp; At the Church Auditorium</h5>
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
