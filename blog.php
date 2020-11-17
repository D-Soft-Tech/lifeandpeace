<?php
  include_once 'life/php/db.php';

  $conn = get_DB();

  function get_month()
  {
    if (isset($_POST['month']) && $_POST['month'] !== "") {
        return $_POST['month'];
    }elseif(isset($_GET['month']) && $_GET['month'] !== ""){
        return $_GET['month'];
    }
    else
    { 
      return date("F");
    }
  }

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

  function get_year()
  {
    if (isset($_POST['year']) && $_POST['year'] !== "") {
        return $_POST['year'];
    }elseif (isset($_GET['year']) && $_GET['year'] !== "") {
        return $_GET['year'];
    }
    else
    { 
      return date("Y");
    }
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
  $result = $conn->query("SELECT * FROM articles WHERE date_added LIKE '%$month%$year' ORDER BY articles_id DESC LIMIT $start, $limit");
  $articles = $result->fetchAll();

  $result1 = $conn->query("SELECT count(articles_id) AS id FROM articles WHERE date_added LIKE '%$month%$year'");
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

  include_once 'header/header.php';
?>

<!--SUBPAGE HEAD-->
<style>
  #topbar
  {
    background-image: url('images/blog.png');
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

<div class="subpage-head has-margin-bottom" id="topbar">
  <div class="container" style="color: #fff; font-weight: bold;">
    <h3><span style="color: #fff; font-size: 1.5em;">Our Blog</span></h3>
    <p class="lead" style="font-size: 1.6em;">Articles and latest bulletins</p>
  </div>
</div>

<!-- // END SUBPAGE HEAD -->

<div class="container">
  <div class="row">
    <div class="col-md-9 has-margin-bottom"> 
      
      <div class="text-center center-block">
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <li>
                <a href="blog.php?pages=<?= $Previous; ?>&page=<?= $page; ?>&month=<?= $month; ?>&year=<?= $year; ?>" 
                    class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Previous">
                    <span aria-hidden="true">&laquo; </span>
                </a>
            </li>
            <?php 
                $i = $pages > 5 ? $pages - 4 : 1;
                for($i; $i<= $pages; $i++)
                {
                ?>
                <li><a href="blog.php?page=<?= $i; ?>&pages=<?= $pages; ?>&month=<?= $month; ?>&year=<?= $year; ?>" class="btn btn-transition btn btn-sm btn-outline-primary"><?= $i; ?></a></li>
                <?php 
                }
            ?>
            <li>
                <a href="blog.php?pages=<?= $Next; ?>&page=<?= $page; ?>&month=<?= $month; ?>&year=<?= $year; ?>"
                class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
          </ul>
        </nav>
      </div>
      <!--Blog list-->
      <?php foreach($articles as $articles) :  ?>
        <div class="row has-margin-bottom">
          <div class="col-md-4 col-sm-4">
            <div class="highlight-bg has-padding-xs event-details">
              <div class="ed-title">ARTICLE DETAILS</div>
              <div class="ed-content"> <span class="glyphicon glyphicon-calendar">
                </span> <?= $articles['date_added']; ?><br>
                <span class="glyphicon glyphicon-user"></span> <?= $articles['article_author']; ?><br>
              </div>
            </div>
          </div>
          <div class="col-md-8 col-sm-8 bulletin">
            <h4 class="media-heading"><?= $articles['article_title']; ?> </h4>
            <p>Posted on <?= $articles['date_added']; ?> by <a class="link-reverse"><?= $articles['article_author']; ?></a></p>
            <p>  <?= truncate($articles['article_details']); ?>...</p>
            <a class="btn btn-primary" href="blog-single.php?articleID=<?= $articles['articles_id']; ?>" role="button">Read Article →</a> </div>
        </div>
      <?php endforeach; ?>
      
      <!-- PAGINATION -->
    </div>
    <!--// col md 9--> 
    
    <!--Blog Sidebar-->
    <div class="col-md-3">
      <div class="well">
        <h4>About</h4>
        <p class="text-justify">Here is a list of articles writtten under the inspiration of the Holy Ghost. They address various issues that 
        are impossible for us to be confronted with during our sourjourning here on earth.
        <br /> Please do well to read them.
        </p>
      </div>
      <div class="vertical-links has-margin-xs-bottom">
        <h4>Blog archives</h4>
        <?php
          
          $sql_articles = "
                              SELECT * FROM articles ORDER BY articles_id DESC LIMIT 10
                            ";

          $stmtAll = $conn->prepare($sql_articles);
          $stmtAll->execute();

        ?>
        <ul class="list-unstyled">
          <?php
            while($lsArticles = $stmtAll->fetch())
            {
            ?>
              <li><a href="blog-single.php?articleID=<?= $lsArticles['articles_id']; ?>"><?= $lsArticles['article_title']; ?></a></li>
          <?php
            }
          ?>
        </ul>
      </div>
      <div class="vertical-links has-margin-xs-bottom">
        <h6>Search by</h6>
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
        <br /><br />
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
