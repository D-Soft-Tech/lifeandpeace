<div class="row">
    <div class="col-xs-12 col-md-8">
        <div class="row alert alert-success fade show" role="alert">
            <div class="col-xs- 7 widget-content-left">
                <span class="fsize-2 font-weight-bold">Testimonies</span>
                <span class="badge badge-light badge-pill font-weight-bold ml-5" id="test">
                </span>
            </div>
            <div class="col-xs-5 mx-auto">
                <div class="">
                    <a href="allowedTestimonies.php" class="btn btn-transition btn btn-sm btn-outline-dark" aria-label="Next">
                        View all Testimonies
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <!-- This column was left empty intentionally -->
    </div>
</div>

<div class="ml-5">
    <nav aria-label="Page navigation">
    <ul class="pagination">
        <li>
            <a href="testimonies.php?pages=<?= $Previous; ?>&page=<?= $page; ?>" 
                class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Previous">
                <span aria-hidden="true">&laquo; </span>
            </a>
        </li>
        <?php 
            $i = $pages > 5 ? $pages - 4 : 1;
            for($i; $i<= $pages; $i++)
            {
            ?>
            <li><a href="testimonies.php?page=<?= $i; ?>&pages=<?= $pages; ?>" class="btn btn-transition btn btn-sm btn-outline-primary"><?= $i; ?></a></li>
            <?php 
            }
            ?>
        <li>
            <a href="testimonies.php?pages=<?= $Next; ?>&page=<?= $page; ?>"
            class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        </ul>
    </nav>
</div>

<!-- each comments -->
<?php foreach($pendingTestimonies as $pendingTestimonies) :  ?>
    <div class="main-card mb-3 card" id="<?= $pendingTestimonies['id']; ?>">
        <div class="card-header"><?= $pendingTestimonies['title']; ?></div>
        <div class="card-body">
            <p><span class="card-title"><?= $pendingTestimonies['full_name']; ?> &nbsp;</span>
                <span>
                <?= '0'. $pendingTestimonies['phone']. " ". $pendingTestimonies['email']; ?>
                </span>
            </p>
            <p class="text-justiy">
                <?= $pendingTestimonies['details']; ?>
            </p> 
        </div>
        <div class="card-footer">
            <button id="<?= $pendingTestimonies['id']; ?>" onclick="allowTestimony(this.id)" class="mb-2 mr-5 btn-transition btn btn-outline-success allowTestimony">
                Allow this Testimony to show on the website
            </button>
            <button id="<?= $pendingTestimonies['id']; ?>" class="mb-2 mr-5 btn-transition btn btn-outline-danger deleteTesti">
                Delete
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
                    <h6 class="text-center">Do you realy want to delete this Testimony?</h6>
                </p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="mr-5 btn-transition btn btn-outline-success" data-dismiss="modal">
                No
            </button>
            <button type="submit" id="" onclick="deleteTesti(this.id)" class="mr-5 btn-transition btn btn-outline-danger finalDelete" data-dismiss="modal">
                Yes
            </button>
        </div>
    </div>
</div>
<!-- Warning Modal before deleting a contact message -->
<script>
    function testimonies(item, id){
        XmlHttp
        (
            {
                url: 'customBackendScript.php',
                type: 'POST',
                data: "item="+item,
                complete:function(xhr,response,status)
                {
                    document.getElementById(id).innerHTML = response;
                }
            }
        );
    }
    setTimeout("testimonies('testimonies', 'test')", 1000);
    setInterval("testimonies('testimonies', 'test')", 180000);
</script>