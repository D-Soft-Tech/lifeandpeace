<!-- The book whose comments is being displayed -->
<?php

    $sql1 = "SELECT DISTINCT article_title, articles_id FROM articles, comments WHERE comments.obj = 'articles' && articles.articles_id = comments.obj_id";

    $result = $conn->query($sql1);
    $articleComments = $result->fetchAll();
?>
<div id="testing"></div>
<div class="row">
    <div class="col-xs-12 col-md-8">
        <div class="card mb-3 widget-content bg-premium-dark">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div>
                        <h5 class="font-weight-bold">
                            <span id="show">Comments on Articles</span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4"></div>
</div>

<div class="ml-5">
<nav aria-label="Page navigation">
        <ul class="pagination">
        <li>
            <a href="bulletin.php?pages=<?= $Previous; ?>&page=<?= $page; ?>" 
                class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Previous">
                <span aria-hidden="true">&laquo; </span>
            </a>
        </li>
        <?php 
            $i = $pages > 5 ? $pages - 4 : 1;
            for($i; $i<= $pages; $i++)
            {
            ?>
            <li><a href="bulletin.php?page=<?= $i; ?>&pages=<?= $pages; ?>" class="btn btn-transition btn btn-sm btn-outline-primary"><?= $i; ?></a></li>
            <?php 
            }
            ?>
        <li>
            <a href="bulletin.php?pages=<?= $Next; ?>&page=<?= $page; ?>"
            class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        </ul>
    </nav>
</div>

<!-- The pending bulletin messages are being looped here -->
<?php foreach($pendingArticleComments as $pendingArticleComments) :  ?>
    <div class="main-card mb-3 card" id="<?= $pendingArticleComments['comment_id']; ?>">
        <div class="card-header"><?= $pendingArticleComments['full_name']; ?>&nbsp; &nbsp; &nbsp; <span class="small"> commented on </span> &nbsp; &nbsp; &nbsp;<?= $pendingArticleComments['article_title']; ?></div>
        <div class="card-body">
            <p class="text-justiy">
                <?= $pendingArticleComments['comment']; ?>
            </p> 
        </div>
        <div class="card-footer">
            <button id="<?= $pendingArticleComments['comment_id']; ?>" onclick="allowComment(this.id)" class="mb-2 mr-5 btn-transition btn btn-outline-success view">
                Allow
            </button>
            <button id="<?= $pendingArticleComments['comment_id']; ?>" class="mb-2 mr-5 btn-transition btn btn-outline-danger deleteComment">
                Remove
            </button>
        </div>
    </div>
<?php endforeach; ?>

<!-- Warning Modal before deleting a contact message -->
<div class="modal fade bd-example-modal-lg mt-5" id="deletemessagemodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-danger">
            <h5 class="modal-title">
                Warning <i class="icon fa pe-7s-attention"></i> 
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="position-relative">
                <p>
                    <h6 class="text-center">Do you realy want to Remove this comment?</h6>
                </p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="mr-5 btn-transition btn btn-outline-success" data-dismiss="modal">
                No
            </button>
            <button type="submit" id="" onclick="deleteComment(this.id)" class="mr-5 btn-transition btn btn-outline-danger finalDelete" data-dismiss="modal">
                Yes
            </button>
        </div>
    </div>
</div>
<!-- Warning Modal before deleting a contact message -->

<script type="text/javascript">

    function show(id){
        XmlHttp
        (
            {
                url: 'testing.php',
                type: 'POST',
                data: "articleComment="+id,
                contentType: 'application/json',
                complete:function(xhr,response,status)
                {
                    var total = response.length;

                    document.getElementById('testing').innerHTML = total;
                }
            }
        );
    }

</script>