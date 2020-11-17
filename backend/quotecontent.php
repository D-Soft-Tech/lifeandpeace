<?php

    if (isset($_POST['submitQuote'])) 
    {
        if (isset($_POST))
        {  
            $quote = $_POST['quote'];
            $author = $_POST['author'];

            $sql = "
                    INSERT INTO quote (details, author) VALUES(:details, :author)
                    ";

            $check = $conn->prepare($sql);
            $check->bindValue(':details', $quote);
            $check->bindValue(':author', $author);

            $check = $check->execute();

            if($check === true){
                echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-check"></i> DONE, Quote has been uploaded successfully</h6>'.
                        '</div>';

            }else{
                echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-attention"></i> Failed, Unable to upload the quote, please try again later</h6>'.
                        '</div>';

            }
        }
    }

?>

<div class="row">
    <div class="col-xs-12 col-md-8">
        <div class="alert alert-success fade show" role="alert">
            <div class="row">
                <div class="col-6">
                    <h4 class="fsize-2 font-weight-bold">Quote</h4>
                </div>
                <div class="col-6">
                    <button class="ml-2 mr-5 btn-transition btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#addQuote">
                        Add new quote
                    </button>
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
            <a href="quote.php?pages=<?= $Previous; ?>&page=<?= $page; ?>" 
                class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Previous">
                <span aria-hidden="true">&laquo; </span>
            </a>
        </li>
        <?php 
            $i = $pages > 5 ? $pages - 4 : 1;
            for($i; $i<= $pages; $i++)
            {
            ?>
            <li><a href="quote.php?page=<?= $i; ?>&pages=<?= $pages; ?>" class="btn btn-transition btn btn-sm btn-outline-primary"><?= $i; ?></a></li>
            <?php 
            }
            ?>
        <li>
            <a href="quote.php?pages=<?= $Next; ?>&page=<?= $page; ?>"
            class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        </ul>
    </nav>
</div>

<!-- The pending quote messages are being looped here -->
<?php foreach($quotes as $quotes) :  ?>
    <div class="main-card mb-3 card" id="<?= $quotes['quote_id']; ?>">
        <div class="card-header"><?= $quotes['author']; ?></div>
        <div class="card-body">
            <p class="text-justiy">
                <?= $quotes['details']; ?>
            </p> 
            <div class="widget-content-right">
                <div class="">
                    <span class="font-weight-bold">
                        Likes
                        <sup class="badge badge-info badge-pill showLikes" name="<?= $quotes['quote_id']; ?>">
                            <style>
                                
                            </style>
                        </sup>
                    </span>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button id="<?= $quotes['quote_id']; ?>" class="mb-2 mr-5 btn-transition btn btn-outline-danger deleteQuote">
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
            <div class="">
                <p>
                    <h6 class="text-center">You are about to delete this quote from the database</h6>
                </p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="mr-5 btn-transition btn btn-outline-success" data-dismiss="modal">
                Back
            </button>
            <button id="" onclick="deleteQuote(this.id)" class="mr-5 btn-transition btn btn-outline-danger finalDelete" data-dismiss="modal">
                Yes, Proceed
            </button>
        </div>
    </div>
</div>
<!-- /Warning Modal before deleting a contact message -->

<scrip>

</script>