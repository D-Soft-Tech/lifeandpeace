<div class="row">
    <div class="col-xs-12 col-md-8">
        <div class="card mb-3 widget-content bg-premium-dark">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading"><h5 class="font-weight-bold">Contacts</h5></div>
                </div>
                <div class="mx-auto">
                    <div class="">
                        <a href="readContact.php" class="btn btn-transition btn btn-sm btn-outline-info" aria-label="Next">
                            View Read Messages
                        </a>
                    </div>
                </div>
                <div class="widget-content-right">
                    <div class="">
                        <span class="font-weight-bold">
                            Inbox
                            <sup class="badge badge-danger badge-pill" id="sup"></sup>
                        </span>
                    </div>
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
            <a href="contact.php?pages=<?= $Previous; ?>&page=<?= $page; ?>" 
                class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Previous">
                <span aria-hidden="true">&laquo; </span>
            </a>
        </li>
        <?php 
            $i = $pages > 5 ? $pages - 4 : 1;
            for($i; $i<= $pages; $i++)
            {
            ?>
            <li><a href="contact.php?page=<?= $i; ?>&pages=<?= $pages; ?>" class="btn btn-transition btn btn-sm btn-outline-primary"><?= $i; ?></a></li>
            <?php 
            }
            ?>
        <li>
            <a href="contact.php?pages=<?= $Next; ?>&page=<?= $page; ?>"
            class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        </ul>
    </nav>
</div>

<!-- The pending contact messages are being looped here -->
<?php foreach($pendingContacts as $pendingContacts) :  ?>
    <div class="main-card mb-3 card" id="<?= $pendingContacts['user_id']; ?>">
        <div class="card-header"><?= $pendingContacts['contact_subject']; ?></div>
        <div class="card-body">
            <p><span class="card-title"><?= $pendingContacts['full_name']; ?> &nbsp;</span>
                <span>
                <?= '0'. $pendingContacts['phone']. " ". $pendingContacts['email']; ?>
                </span>
            </p>
            <p class="text-justiy">
                <?= $pendingContacts['details']; ?>
            </p> 
        </div>
        <div class="card-footer">
            <button id="respondToModal" name="<?= $pendingContacts['full_name']; ?>" value="<?= $pendingContacts['email']; ?>" class="mb-2 mr-5 btn-transition btn btn-outline-success view">
                Respond
            </button>
            <button id="<?= $pendingContacts['user_id']; ?>" onclick="markAsRead(this.id)" class="mb-2 mr-5 btn-transition btn btn-outline-info markAsRead">
                Mark as read
            </button>
            <button id="<?= $pendingContacts['user_id']; ?>" class="mb-2 mr-5 btn-transition btn btn-outline-danger deleteMessage">
                Delete
            </button>
        </div>
    </div>
<?php endforeach; ?>
<!-- End of Pending contact messages -->


<!--Respond to Contact -->
<div class="modal fade bd-example-modal-lg mt-5" id="modalbox" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="modal">
            
        </div>
    </div>
</div>
<!-- Respond to Contact ends here -->

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
                    <h6 class="text-center">Do you realy want to delete this message?</h6>
                </p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="mr-5 btn-transition btn btn-outline-success" data-dismiss="modal">
                No
            </button>
            <button type="submit" id="" onclick="deleteMessage(this.id)" class="mr-5 btn-transition btn btn-outline-danger finalDelete" data-dismiss="modal">
                Yes
            </button>
        </div>
    </div>
</div>
<!-- Warning Modal before deleting a contact message -->

<script type="text/javascript">
    function inbox(item, id){
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
    setTimeout("inbox('contacts', 'sup')", 1000);
    setInterval("inbox('contacts', 'sup')", 180000);
</script>