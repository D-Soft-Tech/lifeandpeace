<?php
  require_once 'header/header.php';
  include_once 'life/php/db.php';
  include_once 'life/php/indexpage.php';

  function truncate($string)
  {
    // strip tags to avoid breaking any html
    $string = strip_tags($string);
    if (strlen($string) > 100)
    {

        // truncate string
        $stringCut = substr($string, 0, 500);
        $endPoint = strrpos($stringCut, ' ');

        //if the string doesn't contain any space then it will cut without word basis.
        $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
    }
    return $string;
  }

  function truncate2($string)
  {
    // strip tags to avoid breaking any html
    $string = strip_tags($string);
    if (strlen($string) > 60)
    {

        // truncate string
        $stringCut = substr($string, 0, 350);
        $endPoint = strrpos($stringCut, '...');

        //if the string doesn't contain any space then it will cut without word basis.
        $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
    }
    return $string;
  }
  
?>

<style type="text/css">
    
    .overlay_audio{
    display: block;
    opacity: 0;
    position: absolute;
    top: 55%;
    }
    
    #book-top:hover .overlay_audio{
        opacity: 1;
        transition: 2s ease;
    }

    .overlay_audio2{
    display: block;
    opacity: 1;
    position: absolute;
    top: 55%;
    }


    /*--------------------------------------------------------------
# Quotes
--------------------------------------------------------------*/
.quotes {
  padding: 80px 0;
  background: url("images/background/quote.jpg") no-repeat;
  background-position: center center;
  background-size: cover;
  position: relative;
}

.quotes::before {
  content: "";
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.4);
}

.quotes .section-header {
  margin-bottom: 40px;
}

.quotes .quote-item {
  text-align: center;
  color: #fff;
}

.quotes .quote-item h3 {
  font-size: 20px;
  font-weight: bold;
  margin: 10px 0 5px 0;
  color: #fff;
}

.quotes .quote-item h4 {
  font-size: 14px;
  color: #ddd;
  margin: 0 0 15px 0;
}

.quotes .quote-item p {
  font-style: italic;
  margin: 0 auto 15px auto;
  color: #eee;
}

@media (min-width: 1024px) {
  .quotes {
    background-attachment: fixed;
  }
}

@media (min-width: 992px) {
  .quotes .quote-item p {
    width: 80%;
  }
}
</style>

<!-- BANNER SLIDER
    ================================================== -->
<div id="myCarousel" class="carousel slide" data-ride="carousel"> 
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="item slide-one active">
      <div class="container">
        <div class="carousel-caption">
          <h3>EXPERIENCE GOD'S</h3>
          <h1>UNENDING LOVE</h1>
          
          <p><a class="btn btn-giant btn-primary" href="events-programs.php" role="button">JOIN US &rarr;</a></p>
        </div>
      </div>
    </div>
    <div class="item slide-two">
      <div class="container">
        <div class="carousel-caption">
          <h2>Greener Pasture</h2>
          <p><a class="btn btn-lg btn-primary" href="books.php" role="button">Books &rarr;</a></p>
        </div>
      </div>
    </div>
    <div class="item slide-three">
      <div class="container">
        <div class="carousel-caption">
          <h2>Grace and Truth</h2>
          <p class="lead">And ye shall know the truth and the truth shall set you free. <em></em></p>
          <p><a class="btn btn-lg btn-primary" href="image-gallery.php" role="button">Browse gallery &rarr;</a></p>
        </div>
      </div>
    </div>
  </div>
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
</div>
<!-- // Banner Slider --> 

<!--UPCOMING EVENT-->

<div class="highlight-bg has-margin-bottom">
  <div class="container event-cta">
    <div class="ec-txt"> <span>UPCOMING EVENT</span>
      <p><?php $call = new most_recent_event(); $call->upcoming(); ?></p>
    </div>
    <a class="btn btn-lg btn-primary" href="events-programs.php" role="button">Program details →</a> </div>
</div>

<!-- // UPCOMING EVENT --> 

<!--FEATURED BLOCK-->
<div class="container">
  <div class="row feature-block">
    <div class="col-xs-12 section-title left-align-desktop">
      <h4> RECENT SERMONS </h4>
    </div>
      <?php  
        $message = $call->call_sermon();

        while ($messages = $message->fetch(PDO::FETCH_ASSOC)) 
        {
      ?>
        <div class="col-xs-12 col-md-4 has-margin-bottom"> 
          <div class="row">
            <div class="col-xs-12">
              <div class="text-center" id="book-top">
                <img class="img-fulid img-responsive" style="height: 30vh; margin-right: auto; margin-left: auto;" src="<?php echo 'images/audio/'.$messages['title'].'.'.$messages['ext']; ?>" style="height: 100%; width: 100%;"alt="church">
                <audio class="overlay_audio" controls style="height: 30px;">
                    <source src="audio_messages/<?= $messages['title']; ?>.<?= $messages['ext2']; ?>" type="audio/<?= $messages['ext2']; ?>">
                </audio>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <h5><?= $messages['title']; ?></h5>
              <p class="text-justify"><?php echo truncate2($messages['details']); ?></p>
              <p><a href="audio-gallery.php" role="button">download all Sermons →</a></p>
            </div>
          </div>
        </div>
      <?php
        }
      ?> 
  </div>
</div>
<!-- // END FEATURED BLOCK--> 

<!--EVENT LISTS-->
<div class="has-margin-bottom" style="background-color: #F6F9FE; padding-top: 25px; padding-bottom: 25px;">
  <div class="container event-list">
    <div class="section-title section-title2">
      <h4 style="color: #4268B3;"> PROGRAMS &amp; EVENTS </h4>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="owl-carousel">
          <div class="el-block item">
            <h4 style="font-family: 'Open Sans', sans-serif; color: #444444;"> OUR PROGRAMS </h4>
            <p class="el-head" style="font-family: 'Open Sans', sans-serif; color: #444444;">Weekly meeting &amp; prayer</p>
            <span>Weekly</span>
            <p class="el-cta"><a class="btn btn-primary" href="weeklyProgram.php" role="button">Details &rarr;</a></p>
          </div>

          <?php 

            $event = $call->prog_and_events();

            while($events = $event->fetch(PDO::FETCH_ASSOC))
            {
            ?>

              <div class="el-block item">
                <h4 style="font-family: 'Open Sans', sans-serif; color: #444444;">  <?php echo $events['event_from']; ?> </h4>
                <p class="el-head" style="font-family: 'Open Sans', sans-serif; color: #444444;"><?php echo $events['theme']; ?></p>
                <span><?php echo $events['event_time']; ?></span>
                <p class="el-cta"><a class="btn btn-primary" href="event-single.php?theme=<?= $events['theme']; ?>&details=<?= $events['details']; ?>&from=<?= $events['event_from']; ?>&ext=<?= $events['ext']; ?>" role="button">Details &rarr;</a></p>
              </div>
            <?php
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- // END EVENT LISTS --> 

<!-- BLOG LIST / LATEST SERMONS -->
<div class="container has-margin-bottom">
  <div class="row">
    <div class="col-md-9 has-margin-bottom">
      <div class="section-title left-align-desktop">
        <h4> LATEST BULLETIN </h4>
      </div>

    <?php 
        $article  = $call->articles();

        while($articles = $article->fetch(PDO::FETCH_ASSOC))
        {
      ?>
      <div class="row has-margin-xs-bottom">
        <div class="col-md-4">
          <div class="highlight-bg has-padding-xs event-details">
            <div class="ed-title">DETAILS</div>
            <div class="ed-content"> <span class="glyphicon glyphicon-calendar">
              </span> <?= $articles['date_added']; ?> <br>
              <span class="glyphicon glyphicon-user"></span> <?= $articles['article_author']; ?> <br>
            </div>
          </div>
        </div> 
        <div class="col-md-8 col-sm-8 bulletin">
          <h4 class="media-heading"><?= $articles['article_title']; ?> </h4>
          <p class="text-justify"> <?= truncate($articles['article_details']); ?></p>
          <a class="btn btn-primary" href="blog-single.php?articleID=<?= $articles['articles_id']; ?>" role="button">Read Article →</a> 
        </div>
      </div>
      <?php
        }
      ?>
    </div>
    <!-- // col md 9  -->
    
    <!--Latest Sermons-->
    <div class="col-md-3">
      <div class="well">
        <div class="section-title">
          <h4> RECENT SERMONS </h4>
        </div>
        <a href="audio-gallery.php" title="Audio Messages"><img src="images/audio2.jpg" class="img-responsive center-block" alt="Recent Sermons"></a>
        <div class="list-group">
          <?php
            $recentSermon = $call->recent_sermons();

            while($recentSermons = $recentSermon->fetch(PDO::FETCH_ASSOC))
            {
          ?>
          <p>
            <a class="list-group-item" href="audio-gallery.php?searchInput=<?= $recentSermons['title']; ?>"><?= $recentSermons['title']; ?></a>
          </p>
          <?php
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END BLOG LIST / LATEST SERMONS --> 

<!--CHARITY DONATION-->
<div class="container has-margin-bottom">
  <div class="section-title">
    <h4>CHARITY </h4>
  </div>
  <?php 
        $donation  = $call->donation();

        $donation = $donation->fetch(PDO::FETCH_ASSOC);

        
        $donation_id = $donation['id'];

        $sql_transc =   "
                            SELECT sum(amount) AS amount FROM transactions, donation WHERE purpose = 'donation' && purpose_id = '$donation_id' && donation.status = 'on_going' && donation.id = transactions.purpose_id
                        ";

        $pldg_amount = $call->conn->query($sql_transc);

        $pledged = $pldg_amount->fetchColumn();
        
        $prg_percent = ceil(abs($pledged/$donation['target_amount']) * 100);
      ?>
  <div class="charity-box">
    <div class="charity-image"> <img src="images/donation/<?= $donation['title']; ?>.<?= $donation['ext']; ?>" class="img-responsive" alt="Donation"></div>
    <div class="charity-desc">
      <h4><?= $donation['title']; ?></h4>
      <p> Posted on <a class="link-reverse"><?= $donation['date_posted']; ?></a> 
      &nbsp; &nbsp; Proposed Date: <a class="link-reverse"><?= $donation['target_date']; ?></a></p>
      
      <h3 class="pledged-amount"># <?= number_format($pledged); ?></h3>
      <p>Pledged out of  # <?= number_format($donation['target_amount']); ?> goal</p>
      <div class="progress">
        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $prg_percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $prg_percent; ?>%"><span class="sr-only"><?= $prg_percent; ?>% Complete</span><?= $prg_percent; ?>%</div>
      </div>
      <?php
        $propose_date = $donation['target_date'];

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
      <div class="pull-left">
        <h3 class="pledged-amount"><?= $daysLeft; ?></h3>
        <p><strong> Days left</strong></p>
        <p class="text-center link-reverse" style="font-size: 1.6rem;">Give Cheerfully, For God loves a cheerful giver</p>
      </div>
      <div class="donate-now"> <a href="charity-donation.php?searchDonationById=<?= $donation_id; ?>" class="btn btn-lg btn-primary">Donate Now →</a> </div>
    </div>
  </div>
</div>
<!--// END CHARITY DONATION --> 

<!--OUR GALLERY-->
<div class="container has-margin-bottom">
  <div class="section-title">
    <h4> OUR GALLERY </h4>
  </div>
  <div class="img-gallery row">
    <?php

      $allPhotos = $call->gallery();

      while($photos = $allPhotos->fetch(PDO::FETCH_ASSOC))
      {

    ?>
    <div class="col-sm-4 col-md-3"> <a class="fancybox" href="images/gallery/<?= $photos['title']; ?>.<?= $photos['ext']; ?>" data-fancybox-group="gallery" title="<?= $photos['title']; ?>"> <img src="images/gallery/<?= $photos['title']; ?>.<?= $photos['ext']; ?>" class="img-responsive" width="270" height="270" alt="<?= $photos['title']; ?>"> </a> </div>
    <?php 
      }
    ?>
  </div>
</div>
<!--// END OUR GALLERY --> 

<!-- BIBLE QUOTES -->
<div id="quotes" class="quotes has-margin-bottom">
  <div class="container event-list">
    <div class="row">
      <div class="col-md-12">
        <div class="owl-carousel2 quotes-carousel">
          <?php

              $focus = $call->focus();

              $focus = $focus->fetch(PDO::FETCH_ASSOC);

            ?>
          <div class="item">
            <div class="section-title" style="color: white; font-weight: bold;">
              <h4> FOCUS FOR THE MONTH </h4>
            </div>
            <blockquote class="quote-item blockquote-centered">
                <?= $focus['theme']; ?>
                <small style="color: white;"><?= $focus['script']; ?></small>
                <a class="btn btn-primary" href="focus_for_the_month.php" role="button">Read More →</a> 
            </blockquote>
          </div>
            <?php

              $allQuotes = $call->quotes();
              
              while($quote = $allQuotes->fetch(PDO::FETCH_ASSOC))
              {

            ?>
          <div class="item">
            <div class="section-title" style="color: white; font-weight: bold;">
              <h4> QUOTES </h4>
            </div>
            <blockquote class="quote-item blockquote-centered"> <?= $quote['details']; ?> <small style="color: white;"><?= $quote['author']; ?></small> </blockquote>
          </div>
          <?php
              }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- // END BIBLE QUOTES --> 

<!-- OUR MINISTRIES -->
<div class="container">
  <div class="section-title">
    <h4> TESTIMONIES </h4>
  </div>
  <div class="row feature-block">
    <?php
      function month($date)
      {
        $array = explode(',', $date);
        $month = $array[1];
        return $month;
      }

      function year($date)
      {
        $array = explode(' ', $date);
        $year = end($array);
        return $year;
      }

      $last3Testimonies = $call->testimonies();

      while($testimonies = $last3Testimonies->fetch(PDO::FETCH_ASSOC))
      {

    ?>
    <div class="col-md-4 col-sm-6 has-margin-bottom">
      <h5><?= $testimonies['title']; ?></h5>
      <p>---<?= $testimonies['testifier']; ?>&nbsp; &nbsp; posted on <span class="link-reverse"><?= $testimonies['date_added']; ?></span></p>
      <p class='text-justify'> <?= truncate2($testimonies['details']); ?> </p>
      <p><a href="testimony.php?page=1&pages=5&month=<?= month($testimonies['date_added']); ?>&year=<?= year($testimonies['date_added']); ?>" role="button">Read more →</a></p>
    </div>
      <?php } ?>
    <!-- /.col-md-4 -->
  </div>
</div>
<!-- // END OUR MINISTRIES--> 

<?php
  include_once 'footer/footer.php';
?>

<!--============== EVENT CAROUSEL =================--> 

<script>
$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
	navText: [
      "<span class='nav-arrow left'></i>",
      "<span class='nav-arrow right'></i>"
      ],
    responsive:{
        0:{
            items:1
        },
		550:{
            items:2
        },
        768:{
            items:3
        },
        992:{
            items:4
        }
    }
})

$('.owl-carousel2').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
	navText: false,
    responsive:{
        0:{
            items:1
        }
    }
})
</script> 

<!--============== IMAGE GALLERY =================--> 

<script>
$(document).ready(function() {
 $('.fancybox').fancybox();			
});			
</script> 

