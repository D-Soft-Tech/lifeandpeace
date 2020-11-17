<?php
  include_once 'header/header2.php';
  include_once 'life/php/db.php';

  $conn = get_DB();

  $sql = "
              SELECT youtube FROM live_program WHERE id = 1
          ";

  $result = $conn->prepare($sql);
  $result->execute();
  $live = $result->fetch();

  $live = $live['youtube'];

?>

<!--SUBPAGE HEAD-->
<style>
  #video{
    background-image: url('images/video.png');
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-size: cover;
  }
  #shadow
  {
    text-shadow:
        3px 3px 0 #4268B3,  
        3px 3px 0 #4268B3,
        3px 3px 0 #4268B3,
        3px 3px 0 #4268B3;
}

</style>
<div class="subpage-head" id="video">
  <div class="container" style="color: #fff; font-weight: bold;">
    <div class="row">
        <div class="col-md-8 col-xs-12" style="color: #fff; font-weight: bold;">
            <h3><span style="color: #fff;" id="shadow">Live Video</span></h3>
            <p class="lead" id="shadow">A collection of our church related videos</p>
        </div>
        <div class="main-card card col-md-4 col-xs-12">
          Go back <a href="video-gallery.php" class="btn btn-warning"> &larr; videos</a>
        </div>
    </div>
  </div>
</div>
<!-- // END SUBPAGE HEAD --> 

<!--OUR GALLERY-->
<div class="container has-margin-bottom" style="margin-top: 20px;">
  <div class="row">
      
    <?php

      if($live > null && !empty($live))
      {
      ?>

        <div class="col-md-9 col-xs-12 has-margin-xs-bottom">
          <div class="embed-responsive embed-responsive-4by3">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?= $live; ?>?rel=0&modestbranding=1" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
        </div>
        <div class="col-md-3 col-xs-12 has-margin-xs-bottom">
          <div class="embed-responsive">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/live_chat?v=<?= $live; ?>&amp;embed_domain=liveVideo.php"></iframe>
          </div>
        </div>
      <?php
      }
      else
      {
      ?>

        <div class="col-xs-12 has-margin-bottom" style="margin-top: 20vh; margin-bottom: 20vh;">
          <h3 class="text-center text-danger">Oops!!! No ongoing Live program, please check back latter</h3>          
        </div>

      <?php
      }

    ?>
  </div>
</div>
<!--// END OUR GALLERY --> 

<?php
  include_once 'footer/footer.php';
?>

</body>
</html>
