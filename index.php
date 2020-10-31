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
          <h1>UNCEASING PROVISION</h1>
          
          <p><a class="btn btn-giant btn-primary" href="charity-donation.php" role="button">JOIN US &rarr;</a></p>
        </div>
      </div>
    </div>
    <div class="item slide-two">
      <div class="container">
        <div class="carousel-caption">
          <h2>Waves of Grace</h2>
          <p class="lead">Receive the unceasing wave after wave, after wave, after wave of Grace God has for you.</p>
          <p><a class="btn btn-lg btn-primary" href="ministry.php" role="button">Learn more &rarr;</a></p>
        </div>
      </div>
    </div>
    <div class="item slide-three">
      <div class="container">
        <div class="carousel-caption">
          <h2>Grace and Truth</h2>
          <p class="lead">For God did not send his Son into the world to condemn the world, but to save the world through him. <em>John 3:17</em></p>
          <p><a class="btn btn-lg btn-primary" href="image-gallery.php" role="button">Browse gallery &rarr;</a></p>
        </div>
      </div>
    </div>
  </div>
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a> </div>
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
                <img class="img-fulid img-responsive" src="<?php echo 'images/audio/'.$messages['title'].'.'.$messages['ext']; ?>" style="height: 100%; width: 100%;"alt="church">
                <audio class="overlay_audio" controls style="height: 30px;">
                    <source src="audio_messages/<?= $messages['title']; ?>.<?= $messages['ext2']; ?>" type="audio/<?= $messages['ext2']; ?>">
                </audio>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <h5><?= $messages['title']; ?></h5>
              <p class="text-justify"><?php echo $messages['details']; ?></p>
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
<div class="highlight-bg has-margin-bottom">
  <div class="container event-list">
    <div class="section-title">
      <h4> PROGRAMS &amp; EVENTS </h4>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="owl-carousel">
          <div class="el-block item">
            <h4> OUR PROGRAMS </h4>
            <p class="el-head">Weekly meeting &amp; prayer</p>
            <span>Weekly</span>
            <p class="el-cta"><a class="btn btn-primary" href="weeklyProgram.php" role="button">Details &rarr;</a></p>
          </div>

          <?php 

            $event = $call->prog_and_events();

            while($events = $event->fetch(PDO::FETCH_ASSOC))
            {
            ?>

              <div class="el-block item">
                <h4>  <?php echo $events['event_from']; ?> </h4>
                <p class="el-head"><?php echo $events['theme']; ?></p>
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
          <a class="btn btn-primary" href="blog-single.php" role="button">Read Article →</a> 
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
        <a href="#"><img src="images/video-thumb.jpg" class="img-responsive center-block" alt="video thumb"></a>
        <div class="list-group"> <a href="sermons.php" class="list-group-item">
          <p class="list-group-item-heading">Heavens and the earth</p>
          <p class="list-group-item-text">24:15 mins</p>
          </a> <a href="sermons.php" class="list-group-item">
          <p class="list-group-item-heading">Prayer and petition</p>
          <p class="list-group-item-text">12:00 mins</p>
          </a> <a href="sermons.php" class="list-group-item">
          <p class="list-group-item-heading">Fruit of the Spirit</p>
          <p class="list-group-item-text">30:25 mins</p>
          </a> <a href="sermons.php" class="list-group-item">
          <p class="list-group-item-heading">Do not be afraid; keep on...</p>
          <p class="list-group-item-text">17:00 mins</p>
          </a> </div>
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
    <div class="col-sm-4 col-md-3"> <a class="fancybox" href="images/gallery/img_gallery_1.jpg" data-fancybox-group="gallery" title="church image gallery"> <img src="images/gallery/thumb/gallery_thumb_1.jpg" class="img-responsive" width="270" height="270" alt="church image gallery"> </a> </div>
    <div class="col-sm-4 col-md-3"> <a class="fancybox" href="images/gallery/img_gallery_2.jpg" data-fancybox-group="gallery" title="church image gallery"> <img src="images/gallery/thumb/gallery_thumb_2.jpg" class="img-responsive" width="270" height="270" alt="church image gallery"> </a> </div>
    <div class="col-sm-4 col-md-3"> <a class="fancybox" href="images/gallery/img_gallery_3.jpg" data-fancybox-group="gallery" title="church image gallery"> <img src="images/gallery/thumb/gallery_thumb_3.jpg" class="img-responsive" width="270" height="270" alt="church image gallery"> </a> </div>
    <div class="col-sm-4 col-md-3"> <a class="fancybox" href="images/gallery/img_gallery_4.jpg" data-fancybox-group="gallery" title="church image gallery"> <img src="images/gallery/thumb/gallery_thumb_4.jpg" class="img-responsive" width="270" height="270" alt="church image gallery"> </a> </div>
    <div class="col-sm-4 col-md-3"> <a class="fancybox" href="images/gallery/img_gallery_5.jpg" data-fancybox-group="gallery" title="church image gallery"> <img src="images/gallery/thumb/gallery_thumb_5.jpg" class="img-responsive" width="270" height="270" alt="church image gallery"> </a> </div>
    <div class="col-sm-4 col-md-3"> <a class="fancybox" href="images/gallery/img_gallery_6.jpg" data-fancybox-group="gallery" title="church image gallery"> <img src="images/gallery/thumb/gallery_thumb_6.jpg" class="img-responsive" width="270" height="270" alt="church image gallery"> </a> </div>
    <div class="col-sm-4 col-md-3"> <a class="fancybox" href="images/gallery/img_gallery_7.jpg" data-fancybox-group="gallery" title="church image gallery"> <img src="images/gallery/thumb/gallery_thumb_7.jpg" class="img-responsive" width="270" height="270" alt="church image gallery"> </a> </div>
    <div class="col-sm-4 col-md-3"> <a class="fancybox" href="images/gallery/img_gallery_8.jpg" data-fancybox-group="gallery" title="church image gallery"> <img src="images/gallery/thumb/gallery_thumb_8.jpg" class="img-responsive" width="270" height="270" alt="church image gallery"> </a> </div>
  </div>
</div>
<!--// END OUR GALLERY --> 

<!-- BIBLE QUOTES -->
<div class="highlight-bg has-margin-bottom">
  <div class="container event-list">
    <div class="row">
      <div class="col-md-12">
        <div class="owl-carousel2">
          <div class="item">
            <div class="section-title">
              <h4> FOCUS FOR THE MONTH </h4>
            </div>
            <blockquote class="blockquote-centered">
                Spirituality and Diversity
                <small>Ephesians 4 : 12</small>
                <a class="btn btn-primary" href="focus_for_the_month.php" role="button">Read More →</a> 
            </blockquote>
          </div>
          <div class="item">
            <div class="section-title">
              <h4> QUOTES </h4>
            </div>
            <blockquote class="blockquote-centered"> For God so loved the world that he gave his one and only begotten Son, that who ever believes in him shall not perish but have eternal life. <small>John 3:16 (KJV)</small> </blockquote>
          </div>
          <div class="item">
            <div class="section-title">
              <h4> QUOTES </h4>
            </div>
            <blockquote class="blockquote-centered"> For if, by the trespass of the one man, death reigned through that one man, how much more will those who receive God's abundant provision of grace!
 <small>Romans 5:17 (NIV)</small> </blockquote>
          </div>
          <div class="item">
            <div class="section-title">
              <h4> QUOTES </h4>
            </div>
            <blockquote class="blockquote-centered">For God did not send his Son into the world to condemn the world, but to save the world through him. <small>John 3:17</small> </blockquote>
          </div>
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
    <div class="col-md-4 col-sm-6 has-margin-bottom"> <img class="img-responsive" src="images/ministry_1.jpg" alt="catholic church">
      <h5>YOU CANNOT, BUT GOD CAN</h5>
      <p>The world says that blood and sweat equals success. But we can rest in Jesus' finished work at the cross because of His blood, sweat, tears... </p>
      <p><a href="ministry.php" role="button">Read more →</a></p>
    </div>
    <!-- /.col-md-4 -->
    <div class="col-md-4 col-sm-6 has-margin-bottom"> <img class="img-responsive" src="images/ministry_2.jpg" alt="ministry sermon">
      <h5>DELIGHT YOURSELF IN LORD</h5>
      <p>When we rest in the Lord and draw from His Word every day, we have the confidence in knowing our Father has already opened doors...</p>
      <p><a href="ministry.php" role="button">Read more →</a></p>
    </div>
    <!-- /.col-md-4 -->
    <div class="col-md-4 col-sm-8 col-sm-offset-2 col-md-offset-0 center-this has-margin-bottom"> <img class="img-responsive" src="images/ministry_3.jpg" alt="bulletin programs">
      <h5>FAITH DEVELOPS PERSEREVANCE</h5>
      <p>Through these he has given us his very great and precious promises, so that through them you may participate in the divine nature...</p>
      <p><a href="ministry.php" role="button">Read more →</a></p>
    </div>
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

