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

  $limit = 10;
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
    function getInput(){
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
                OR day LIKE '%$input' OR month LIKE '%$input' OR year LIKE '%$input') && type = 'audio' ORDER BY id LIMIT $start, $limit
            ";

    $result = $conn->prepare($sql);
    $checker = $result->execute();
    $audios = $result->fetchAll();

    $result1 = $conn->prepare("
                                SELECT count(id) AS id FROM message WHERE (sermon_by LIKE '%$input%'
                                OR title LIKE '%$input%' OR details LIKE '%$input%'
                                OR day LIKE '%$input' OR month LIKE '%$input' OR year LIKE '%$input') && type = 'audio'
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
                SELECT * FROM message WHERE type = 'audio' ORDER BY id LIMIT $start, $limit
            ";

    $result = $conn->query($sql);
    $audios = $result->fetchAll();

    $result1 = $conn->prepare("
                                SELECT count(id) AS id FROM message WHERE type = 'audio'
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

<style>
    
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

<!--SUBPAGE HEAD-->

<div class="subpage-head" style="margin-bottom: 10px;">
  <div class="container">
    <div class="row">
        <div class="col-md-8 col-xs-12">
            <h3>Audio Gallery</h3>
            <p class="lead">A collection of our church Audio Messages</p>
        </div>
        <div class="main-card card col-md-4 col-xs-12">
            <div class="card-body">
                <div class="collapse" id="collapseExample123">
                    
                    <audio class="overlay_audio2" controls style="height: 50px;">
                        <source src="audio_messages/grace.mp3" type="audio/mp3">
                    </audio>
                    <img class="img-resoponsive" src="images/audio/grace.jpg" style="height: 150px; width: 100%;" />
                </div>
            </div>
            <div class="card-footer">
                <button type="button" data-toggle="collapse" href="#collapseExample123" class="btn btn-warning btn-sm">Live</button>
            </div>
        </div>
    </div>
  </div>
</div>
<!-- // END SUBPAGE HEAD --> 

<div class="container">
    <div class="row" style="margin-x: auto;">
        <div class="col-md-6 col-xs-12 text-center" style="margin-bottom: 0px;">
            <nav aria-label="Page navigation" style="margin-bottom: 0px;">
                <ul class="pagination" style="margin-bottom: 0px;">
                    <li>
                        <a href="audio-gallery.php?pages=<?= $Previous; ?>&page=<?= $page; ?>&searchInput=<?= $input; ?>" 
                            class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Previous">
                            <span aria-hidden="true">&laquo; </span>
                        </a>
                    </li>
                    <?php 
                        $i = $pages > 5 ? $pages - 4 : 1;
                        for($i; $i<= $pages; $i++)
                        {
                        ?>
                        <li><a href="audio-gallery.php?page=<?= $i; ?>&pages=<?= $pages; ?>&searchInput=<?= $input; ?>" class="btn btn-transition btn btn-sm btn-outline-primary"><?= $i; ?></a></li>
                        <?php 
                        }
                        ?>
                    <li>
                        <a href="audio-gallery.php?pages=<?= $Next; ?>&page=<?= $page; ?>&searchInput=<?= $input; ?>"
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
    <hr class="text-success" />
</div>

<!--OUR GALLERY-->
<div class="container has-margin-bottom">
  <div class="row">
  <?php foreach($audios as $audios) :  ?>
        <div class="col-xs-12 col-md-3 mt-1 mb-3" id="<?= $audios['id']; ?>">
            <div class="row">
                <div class="col-xs-12" style="height: 150px; width: 100%; margin-x: auto;">
                    <div class="text-center" id="book-top">
                        <img class="img-resoponsive" src="images/audio/<?= $audios['title']; ?>.<?= $audios['ext']; ?>" alt="<?= $audios['title']; ?>" style="height: 150px; width: 100%;" />
                        <audio class="overlay_audio" controls style="height: 30px;">
                            <source src="audio_messages/<?= $audios['title']; ?>.<?= $audios['ext2']; ?>" type="audio/<?= $audios['ext2']; ?>">
                        </audio>
                    </div>
                </div>
                <div class="col-xs-12 card-footer" style="width: 100%;">
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-info"><?= $audios['title']; ?></h6>
                            <p><?= $audios['day']."/".$audios['month']."/".$audios['year']; ?></p>
                        </div>
                        <div class="col-md-12">
                            <h6 class="">Downloads: <span class="text-success">120</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<!--// END OUR GALLERY --> 
    </div>
</div>

<?php
  include_once 'footer/footer.php';
?>

</body>
</html>