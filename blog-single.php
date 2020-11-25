<?php

  include_once 'life/php/db.php';
  include_once 'header/header.php';

  $conn = get_DB();

  if(isset($_GET) && !empty($_GET))
  {
    $sanitizer = filter_var_array($_GET, FILTER_SANITIZE_STRING);

    $idA = $sanitizer['articleID'];
  }

  $alertMessage = "";

  function disable_button()
  {
    if(isset($_SESSION['username_frontEnd']) && isset($_SESSION['password_frontEnd']) && !empty($_SESSION['username_frontEnd']) && !empty($_SESSION['password_frontEnd']))
    {
        echo "value='submit' name='submitAddComment' type='submit'";
    }
    else{
        echo "data-toggle='tooltip' value='Submit' name='submitAddComment' data-placement='right' type='button' title='You have to login first'";
    }
  }

  if(isset($_POST['submitAddComment']) && $_POST['submitAddComment'] === "submit")
  {
    $commentator = $_SESSION['username_frontEnd'];

    $userID_resource = $conn->query("SELECT user_id FROM users WHERE username = '$commentator'");
    $userID = $userID_resource->fetch();
    
    $sanitizer = filter_var_array($_POST, FILTER_SANITIZE_STRING);

    $comment = $sanitizer['comment'];

    $date = date("l, F jS, Y");

    if(!empty($commentator) && !empty($comment))
    {
      $sqlComment = "
                        INSERT INTO comments set obj_id = :obj_id, comment = :comment, date_added = :date, user_id = :user_id 
                      ";

      $stmt1 = $conn->prepare($sqlComment);
      $stmt1->bindValue(':obj_id', $idA);
      $stmt1->bindValue(':comment', $comment);
      $stmt1->bindValue(':date', $date);
      $stmt1->bindValue(':user_id', $userID['user_id']);

      $check = $stmt1->execute();

      $count = $stmt1->rowCount();

      if($check === true && $count>0)
      {
        $alertMessage = '<div class="alert alert-success alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<div class="">'.
                                '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Thank you, your Comment has been received!!!</h6>'.
                            '</div>'.
                        '</div>';
      }
      else
      {
        $alertMessage = '<div class="alert alert-danger alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<div class="">'.
                                '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Error sending the Comment, please try again later!!!</h6>'.
                            '</div>'.
                        '</div>';
      }
    }
    else
      {
        $alertMessage = '<div class="alert alert-danger alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<div class="">'.
                                '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Error sending the Comment, please try again later. Thank You!</h6>'.
                            '</div>'.
                        '</div>';
      }
  }

  if(isset($_GET) && !empty($_GET))
  {
    $sanitizer = filter_var_array($_GET, FILTER_SANITIZE_STRING);

    $id = $sanitizer['articleID'];

    // Getting the Article from the database using the id that was sent in from blog.php

    $sqlArticle = "
                    SELECT * FROM articles WHERE articles_id = :articles_id
                  ";

    $stmt = $conn->prepare($sqlArticle);
    $stmt->bindParam(':articles_id', $id);
    $stmt->execute();

    $article = $stmt->fetch();

    $commentsSql = "
                  SELECT comments.comment AS comment, comments.date_added AS date_added, users.full_name AS full_name FROM comments, users WHERE comments.obj_id = :id
                  && comments.obj = 'articles' && comments.user_id = users.user_id && comments.status = 'read'
                ";

    $stmt2 = $conn->prepare($commentsSql);
    $stmt2->bindParam(':id', $id);
    $stmt2->execute();

    $comments = $stmt2->fetchAll();
    $totalComments = $stmt2->rowCount();

    if(!empty($article) && $article !== null)
    {
    ?>
      <!--SUBPAGE HEAD-->
      <style>
        #topbar
        {
          background-image: url('images/blog.png');
          background-attachment: fixed;
          background-repeat: no-repeat;
          background-size: cover;
          background-blend-mode: inherit;
        }
        #shadow{
          text-shadow:
            3px 3px 0 #000,  
            3px 3px 0 #000,
            3px 3px 0 #000,
            3px 3px 0 #000;
        }
      </style>

      <div class="subpage-head has-margin-bottom" id="topbar">
        <div class="container" style="color: #fff; font-weight: bold; font-size: 2em;">
          <h3><span id="shadow" style="color: #fff; font-size: 1.5em;"><?= $article['article_title'] ?></span></h3>
          <p class="lead" id="shadow" style="font-size: 0.7em;"><span>Posted on</span> <?= $article['date_added'] ?><a style="color: #fff; text-shadow: 2px 2px 0 #000;"> by <?= $article['article_author']; ?></a></p>
        </div>
      </div>

      <!-- // END SUBPAGE HEAD -->

      <div class="container">
        <div class="row">

        <!-- Alert div for showing if the comment is successfully sent or not -->
          <div class="col-md-12">
            <div class="row">
              <?= $alertMessage; ?>
            </div>
          </div>

          <div class="col-md-9 has-margin-bottom">
            <article class="blog-content">
              <p class="text-justify">
                <?= $article['article_details']; ?>
              </p>
            </article>
            <section class="comments-block">

              <!-- Getting the comments on the article posted -->
              <h3 class="comments-head"><?= $totalComments; ?> Comments</h3>

              <?php foreach($comments as $comments) : ?>
                <div class="media"> <a class="pull-left" href="#"> <img class="media-object lazy" alt="avatar" data-src="images/avatar-1.jpg"> </a>
                  <div class="media-body">
                    <h6 class="media-heading"><?= $comments['full_name']; ?></h6>
                    <p class="text-muted"><?= $comments['date_added']; ?></p>
                     <?= $comments['comment'] ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </section>
            <section class="post-comment-form">
              <h3 class="comments-head">Add your Comment</h3>
              <form class="form" method="POST" role="form">
                <div class="row">
                  <div class="form-group col-md-12">
                    <textarea cols="8" rows="4" name="comment" class="form-control input-lg" placeholder="Your Comment" required></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-12">
                    <input class="btn btn-primary btn-lg" <?php disable_button(); ?>>
                  </div>
                </div>
              </form>
            </section>
          </div>
          <!--// col md 9--> 
          
          <!--Blog Sidebar-->
          <div class="col-md-3">
            <div class="well">
              <h4>About</h4>
              <p class="text-justify">Here is a list of articles writtten under the inspiration of the Holy Ghost. They address various issues that 
                are impossible for us to be confronted with during our sourjourning here on earth.
                <br /> <b>Please do well to read them.</b>
              </p>
            </div>
            <div class="vertical-links has-margin-xs-bottom">
              <h4>Blog archives</h4>
              <?php
          
                $sql_donations = "
                                    SELECT * FROM articles ORDER BY articles_id DESC LIMIT 10
                                  ";

                $stmtAll = $conn->prepare($sql_donations);
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
    }
  }
?>

<?php
  include_once 'footer/footer.php';
?>

</body>
</html>
