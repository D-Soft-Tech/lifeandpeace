<?php
  include_once 'life/php/db.php';
  include_once 'header/header.php';

  $conn = get_DB();

  function truncate($string)
  {
    // strip tags to avoid breaking any html
    $string = strip_tags($string);
    if (strlen($string) > 50) {

        // truncate string
        $stringCut = substr($string, 0, 500);
        $endPoint = strrpos($stringCut, ' ');

        //if the string doesn't contain any space then it will cut without word basis.
        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
    }
    return $string;
  }

?>

<style>
  .owl-carousel .owl-stage{
  display: flex;
  align-items: center;
}

.owl-carousel img{
  margin: auto;
}

.owl-carousel .caption {
  text-align: center;
}

#about{
  background-image: url('images/about.jpg');
  background-attachment: fixed;
  background-repeat: no-repeat;
  background-size: cover;
  text-shadow:
        3px 3px 0 #4268B3,  
        3px 3px 0 #4268B3,
        3px 3px 0 #4268B3,
        3px 3px 0 #4268B3;
}

</style>
<!--SUBPAGE HEAD-->

<div class="subpage-head has-margin-bottom" id="about">
  <div class="container">
    <h2><span style="color: white; font-weight: bold;">About us</span></h2>
  </div>
</div>

<!-- // END SUBPAGE HEAD -->

<div class="container has-margin-bottom">
  <div class="row">
    <div class="col-md-9">
      <p class="lead"> Brief History of the Church </p>
      <p> Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere consectetur est at lobortis. Cras mattis consectetur purus sit amet fermentum. </p>
      <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
      <h4>Mission</h4>
      <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
      <p>Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
      <h4>Vision</h4>
      <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
      <p>Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
    </div>
    <!--// col md 9--> 
    
    <!--Latest Sermons-->
    <div class="col-md-3 visible-md-block visible-lg-block">
      <div class="well">
        <div class="section-title">
          <h4> RECENT ARTICLES </h4>
        </div>
        <a href="#"><img src="images/article.jpg" class="img-responsive center-block" alt="video thumb"></a>
        <?php
          
          $sql_donations = "
                              SELECT * FROM articles ORDER BY articles_id DESC LIMIT 5
                            ";

          $stmtArticles = $conn->query($sql_donations);
          $stmtArticles->execute();

        ?>
        <div class="list-group">
          <?php
            while($lsArticles = $stmtArticles->fetch())
            {
          ?>
          <p>
            <a class="list-group-item" href="blog-single.php?articleID=<?= $lsArticles['articles_id']; ?>"><?= $lsArticles['article_title']; ?></a>
          </p>
          <?php
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- OUR TEAM -->
<div class="container">
  <div class="section-title">
    <h4> OUR TEAM </h4>
  </div>

  <?php
    $result = $conn->query("SELECT * FROM team ORDER BY id DESC");
  ?>
  <div class="row owl-carousel">
    <?php
      while($teams = $result->fetch())
      {
    ?>
    <div class="has-margin-bottom item"> 
      <img class="img-circle" src="images/team/<?= $teams['full_name']?>.<?= $teams['ext'];?>" alt="<?= $teams['title']; ?> <?= $teams['full_name']; ?>" style="height: 250px; width: 250px;"></img>
      <div class="caption"><h5><?= $teams['title']; ?> <?= $teams['full_name']; ?></h5>
      <p><?= $teams['roles']; ?></p>
      <p><?= truncate($teams['about']); ?></p>
      <p><a href="<?= $teams['facebook']; ?>" target="_blank" role="button">Facebook</a> / <a href="<?= $teams['tweeter']; ?>" target="_blank" role="button">Twitter</a></p></div>
    </div>
    <!-- /.col-md-4 -->
    <?php
      }
    ?>
    <!-- /.col-md-4 --> 
  </div>
<!-- // END OUR TEAM --> 

    <div class="col-12 has-margin-bottom">
      <h4>Locate Us on the Globe</h4>
    </div>
</div>
<!-- LOCATION MAP -->
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.707156579709!2d3.9813427497178786!3d7.386676824211546!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xbd047882cd5a5941!2sLife%20and%20Peace%20Commission!5e0!3m2!1sen!2sng!4v1602564445016!5m2!1sen!2sng" 
width="100%" height="450" frameborder="0" style="border:0; margin-bottom: 15px;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
<!-- // END LOCATION MAP  -->
<?php
  include_once 'footer/footer.php';
?>

<script type="text/javascript">
  $('.owl-carousel').owlCarousel({
    loop:true,
    margin:20,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
      responsive:{
          0:{
              items:1
          },
      550:{
              items:2
          },
          768:{
              items:3
          }
      }
  })


//   $('.owl-carousel').owlCarousel({
//     loop:true,
//     margin:10,
//     nav:true,
//     navText: [
//         "<span class='nav-arrow left'></i>",
//         "<span class='nav-arrow right'></i>"
//         ],
//     responsive:{
//         0:{
//             items:1
//         },
//         600:{
//             items:2
//         },
//         1000:{
//             items:3
//         }
//     }
// })
</script>

</body>
</html>
