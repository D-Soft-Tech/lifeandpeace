<?php
  include_once 'header/header2.php';
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

  if((isset($_POST['submitSearchByRef']) && isset($_POST['searchInput']) && !empty($_POST['searchInput'])) && $_POST['searchInput'] !== 'nothingnothing' OR (isset($_GET['searchInput']) && !empty($_GET['searchInput']) && $_GET['searchInput'] !== 'nothingnothing'))
  {   
    function getInput()
    {
        if(isset($_POST['searchInput']))
        {
            return $_POST['searchInput'];
        }
        elseif(isset($_GET['searchInput'])){
            return $_GET['searchInput'];
        }
    }

    $input = getInput();

    $start = ($page - 1) * $limit;
    $sql = "
              SELECT * FROM message WHERE (sermon_by LIKE '%$input%'
              OR title LIKE '%$input%' OR details LIKE '%$input%'
              OR day LIKE '%$input' OR month LIKE '%$input' OR year LIKE '%$input') && type = 'video' ORDER BY id LIMIT $start, $limit
          ";

    $result = $conn->prepare($sql);
    $checker = $result->execute();
    $video = $result->fetchAll();

    $result1 = $conn->prepare("
                                SELECT count(id) AS id FROM message WHERE (sermon_by LIKE '%$input%'
                                OR title LIKE '%$input%' OR details LIKE '%$input%'
                                OR day LIKE '%$input' OR month LIKE '%$input' OR year LIKE '%$input') && type = 'video'
                            ");
                            
    $check = $result1->execute();

    $custCount = $result1->fetchAll();
    $total = $custCount[0]['id'];
  }
  else
  {   
    $input = 'nothingnothing';
    $start = ($page - 1) * $limit;
    $sql = "
                SELECT * FROM message WHERE type = 'video' ORDER BY id LIMIT $start, $limit
            ";

    $result = $conn->query($sql);
    $video = $result->fetchAll();

    $result1 = $conn->prepare("
                                SELECT count(id) AS id FROM message WHERE type = 'video'
                            ");
                            
    $check = $result1->execute();

    $custCount = $result1->fetchAll();
    $total = $custCount[0]['id'];
  }

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
            <h3><span style="color: #fff;" id="shadow">Video Gallery</span></h3>
            <p class="lead" id="shadow">A collection of our church related videos</p>
        </div>
        <div class="main-card card col-md-4 col-xs-12">
          <a href="liveVideo.php" class="btn btn-warning btn-sm">Live &rarr;</a>
        </div>
    </div>
  </div>
</div>
<!-- // END SUBPAGE HEAD --> 

<div class="container">
  <div class="row">
    <div class="col-md-6 col-xs-12 text-center" style="margin-bottom: 0px;">
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <li>
              <a href="video-gallery.php?pages=<?= $Previous; ?>&page=<?= $page; ?>&searchInput=<?= $input; ?>" 
                  class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Previous">
                  <span aria-hidden="true">&laquo; </span>
              </a>
          </li>
            <?php 
                $i = $pages > 5 ? $pages - 4 : 1;
                for($i; $i<= $pages; $i++)
                {
                ?>
                <li><a href="video-gallery.php?page=<?= $i; ?>&pages=<?= $pages; ?>&searchInput=<?= $input; ?>" class="btn btn-transition btn btn-sm btn-outline-primary"><?= $i; ?></a></li>
                <?php 
                }
              ?>
          <li>
              <a href="video-gallery.php?pages=<?= $Next; ?>&page=<?= $page; ?>&searchInput=<?= $input; ?>"
              class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
              </a>
          </li>
        </ul>
      </nav>
    </div>

    <div class="col-md-6 col-xs-12">
      <form method="POST">
          <div class="form-row form-group">
              <div class="col-md-9 col-xs-10" style="margin-right: 0px; padding-right: 0px;">
                  <input type="text" class="form-control" name="searchInput" placeholder="Search by anything">
              </div>
              <div class="col-md-3 col-xs-2" style="margin-left: 0px; padding-left: 1px;">
                  <button type="submit" name="submitSearchByRef" value="submit" class="btn btn-info btn-sm">
                      <i class="fa fa-search"></i>
                  </button>
              </div>
          </div>
      </form>
    </div>
  </div>
</div>

<!--OUR GALLERY-->
<div class="container has-margin-bottom" style="margin-top: 20px;">
  <div class="row">
    <?php foreach($video as $video) :  ?>
      <div class="col-sm-6 has-margin-xs-bottom">
        <div class="embed-responsive embed-responsive-4by3">
          <iframe class="embed-responsive-item" src="<?= $video['link']; ?>" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
        </div>
        <h4><?= $video['title']; ?></h4>
        <p><?= $video['details']; ?></p>
      </div>
    <?php endforeach; ?>
    <!-- <div class="col-sm-6 has-margin-xs-bottom">
      <div class="embed-responsive embed-responsive-4by3">
      <iframe width="560" height="315" src="https://www.youtube.com/embed/ZUTzJG212Vo?rel=0&modestbranding=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
      <h4>Heavens and the earth</h4>
      <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. </p>
    </div> -->
  </div>
</div>
<!--// END OUR GALLERY --> 

<?php
  include_once 'footer/footer.php';
?>

</body>
</html>
