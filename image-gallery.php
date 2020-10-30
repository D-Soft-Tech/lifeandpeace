<?php
  include_once 'header/header2.php';
  include_once 'life/php/db.php';

  $conn = get_DB();

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

  function get_day()
  {
    if (isset($_POST['day']) && $_POST['day'] !== "") {
        return $_POST['day'];
    }elseif (isset($_GET['day']) && $_GET['day'] !== "") {
        return $_GET['day'];
    }
    else{ return date("j");}
  }


  $month = get_month();
  $year = get_year();
  $day = get_day();

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

  $start = ($page - 1) * $limit;
  $result = $conn->query("SELECT * FROM gallery WHERE month = '$month' && year = '$year' ORDER BY id DESC LIMIT $start, $limit");

  $result1 = $conn->query("SELECT count(id) AS id FROM gallery WHERE month = '$month' && year = '$year'");
  $custCount = $result1->fetchAll();
  $total = $custCount[0]['id'];

?>

<!--SUBPAGE HEAD-->

<div class="subpage-head" style="margin-bottom: 1%;">
  <div class="container">
    <h3>Photo Gallery</h3>
    <p class="lead">Curated mages of our church programs and events</p>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="text-center">
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <li>
                <a href="image-gallery.php?pages=<?= $Previous; ?>&page=<?= $page; ?>&month=<?= $month; ?>&year=<?= $year; ?>&day=<?= $day; ?>" 
                    class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Previous">
                    <span aria-hidden="true">&laquo; </span>
                </a>
            </li>
            <?php 
                $i = $pages > 5 ? $pages - 4 : 1;
                for($i; $i<= $pages; $i++)
                {
                ?>
                <li><a href="image-gallery.php?page=<?= $i; ?>&pages=<?= $pages; ?>&month=<?= $month; ?>&year=<?= $year; ?>&day=<?= $day; ?>" class="btn btn-transition btn btn-sm btn-outline-primary"><?= $i; ?></a></li>
                <?php 
                }
            ?>
            <li>
                <a href="image-gallery.php?pages=<?= $Next; ?>&page=<?= $page; ?>&month=<?= $month; ?>&year=<?= $year; ?>&day=<?= $day; ?>"
                class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
          </ul>
        </nav>
    </div>
  </div>
  <div class="vertical-links" style="margin-right:5%; margin-left: 5%">
        <form method="POST">
          <div class="form-row">
            <div class="col-xs-1"></div>
            
            <div class="col-xs-3" style="padding-right: 2px; padding-left: 2px;">
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
            <div class="col-xs-3" style="padding-left: 2px;">
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
            <div class="col-xs-2"></div>
          </div>
        </form>
        <br /><br />
      </div>
</div>
<!-- // END SUBPAGE HEAD --> 

<!--OUR GALLERY-->
<div class="container has-margin-bottom">
  <div class="img-gallery row">
    <?php 
      while($gallery = $result->fetch())
      {
      ?>
      <div class="col-sm-4 col-md-3"> 
        <a class="fancybox" href="images/gallery/<?= $gallery['title']; ?>.<?= $gallery['ext']; ?>" data-fancybox-group="gallery" title="<?= $gallery['title']; ?>">
          <img src="images/gallery/<?= $gallery['title']; ?>.<?= $gallery['ext']; ?>" class="img-responsive" width="270" height="270" alt="<?= $gallery['title']; ?>">
        </a>
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

<!--============== IMAGE GALLERY =================--> 

<script>
$(document).ready(function() {
 $('.fancybox').fancybox();			
});			
</script> 

</body>
</html>
