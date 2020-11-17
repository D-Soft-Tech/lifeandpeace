<div class="row">
    <div class="col-xs-12 col-md-8">
        <div class="card mb-3 widget-content bg-premium-dark">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading"><h5 class="font-weight-bold">Testimonies</h5></div>
                </div>
                <div class="mx-auto">
                    <div class="">
                        <a href="testimonies.php" class="btn btn-transition btn btn-sm btn-outline-info" aria-label="Next">
                            View Pending Testimonies
                        </a>
                    </div>
                </div>
                <div class="widget-content-right">
                    <div class="">
                        <span class="font-weight-bold">
                            Allowed Testimonies
                            <sup class="badge badge-danger badge-pill" id="allowedTesti"></sup>
                        </span>
                    </div>
                </div>
            <!-- </div> -->
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4"></div>
</div>
<div class="ml-5">
    <nav aria-label="Page navigation">
        <ul class="pagination">
        <li>
            <a href="allowedTestimonies.php?pages=<?= $Previous; ?>&page=<?= $page; ?>" 
            class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Previous">
            <span aria-hidden="true">&laquo; </span>
            </a>
        </li>
        <?php 
            $i = $pages > 5 ? $pages - 4 : 1;
            for($i; $i<= $pages; $i++)
            {
            ?>
            <li><a href="allowedTestimonies.php?page=<?= $i; ?>&pages=<?= $pages; ?>" class="btn btn-transition btn btn-sm btn-outline-primary"><?= $i; ?></a></li>
            <?php 
            }
            ?>
        <li>
            <a href="allowedTestimonies.php?pages=<?= $Next; ?>&page=<?= $page; ?>"
            class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        </ul>
    </nav>
</div>

<!-- The read contact messages are being looped here -->
<?php foreach($allowedTestimonies as $allowedTestimonies) :  ?>
    <div class="main-card mb-3 card" id="<?= $allowedTestimonies['user_id']; ?>">
        <div class="card-header"><?= $allowedTestimonies['title']; ?></div>
        <div class="card-body">
            <p><span class="card-title"><?= $allowedTestimonies['full_name']; ?> &nbsp;</span>
                <span>
                <?= '0'. $allowedTestimonies['phone']. " ". $allowedTestimonies['email']; ?>
                </span>
            </p>
            <?= $allowedTestimonies['details']; ?> 
        </div>
        <div class="card-footer">
            <button id="<?= $allowedTestimonies['user_id']; ?>" class="mb-2 mr-5 btn-transition btn btn-outline-danger deleteTesti">
                Delete
            </button>
        </div>
    </div>
<?php endforeach; ?>
<!-- End of read contact messages -->

<!-- Warning Modal before deleting a contact message -->
<div class="modal fade bd-example-modal-lg mt-5" id="deleteTestiModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="false">
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
                    <h6 class="text-center">Do you realy want to delete this message?</h6>
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

<script type="text/javascript">
    function allowedTesti(item, id){
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
    setTimeout("allowedTesti('allowedTesti', 'allowedTesti')", 1000);
    setInterval("allowedTesti('allowedTesti', 'allowedTesti')", 180000);

</script>