<style>
    .image-top{
        overflow: hidden;
    }
    .image-top:hover img{
        transition: 2s ease;
        transform: scale(1.15);
    }
</style>

<?php 

    require_once ('video_class.php');

    if (isset($_POST['addNewVideo']) && $_POST['addNewVideo'] !== "") 
    {
        $title = $_POST['title'];
        $anchor = $_POST['anchor'];
        $details = $_POST['details'];
        $link = $_POST['link'];

        $dayNumber = date("jS"); 
        $day = $dayNumber . " of ";
        $month = date("F"); 
        $year = date("Y");

        $passport_obj = new Passport($title, $anchor, $details, $link, $day, $month, $year);
        $passport_obj->Upload();
    }

?>

<div class="row mb-0">
    <div class="col-xs-12 col-md-8">
        <div class="alert alert-success fade show" role="alert">
            <div class="row">
                <div class="col-2">
                    <span class="fsize-2 font-weight-bold">video</span>
                </div>
                <div class="col-3">
                    <button class="ml-2 mr-5 btn-transition btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#addvideo">
                        video<sup>+</sup>
                    </button>
                </div>
                <div class="col-3">
                    <button class="ml-2 mr-5 btn-transition btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#liveVideo">
                        live<sup>+</sup>
                    </button>
                </div>
                <div class="col-4">
                    <button class="ml-2 mr-5 btn-transition btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#removeLiveVideoModal">
                        live<sup>-</sup>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <!-- This column was left empty intentionally -->
    </div>
    
    <div class="col-xs-12 col-md-8">
        <div class="row">
            <div class="col-12 ml-1">
                Showing records for <span class="font-weight-bold"><?php $nowShowing = $month. ", ". $year; echo $nowShowing; ?></span>.
            </div>
            <div class="col-xs-12 col-md-6">
                <br />
                <nav aria-label="Page navigation">
                    <ul class="pagination ml-5 mb-0">
                        <li>
                            <a href="video.php?pages=<?= $Previous; ?>&page=<?= $page; ?>&month=<?= $month; ?>&year=<?= $year; ?>" 
                                class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Previous">
                                <span aria-hidden="true">&laquo; </span>
                            </a>
                        </li>
                        <?php 
                            $i = $pages > 5 ? $pages - 4 : 1;
                            for($i; $i<= $pages; $i++)
                            {
                            ?>
                            <li><a href="video.php?page=<?= $i; ?>&pages=<?= $pages; ?>&month=<?= $month; ?>&year=<?= $year; ?>" class="btn btn-transition btn btn-sm btn-outline-primary"><?= $i; ?></a></li>
                            <?php 
                            }
                            ?>
                        <li>
                            <a href="video.php?pages=<?= $Next; ?>&page=<?= $page; ?>&month=<?= $month; ?>&year=<?= $year; ?>"
                            class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            
            <div class="col-xs-12 col-md-6">
                <span class="font-weight-bold">Search By</span>
                <form method="POST">
                    <div class="form-row">
                        <div class="col-6">
                            <select id="month" name="month" class="form-control-sm form-control">
                                <option>Month</option>
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
                        <div class="col-6">
                            <div class="row">
                                <div class="col-9 pr-2">
                                    <select id="year" name="year" class="form-control-sm form-control">
                                        <option>Year</option>
                                        <?php
                                            for ($now= "2020"; $now <= date("Y"); $now++) { 
                                                echo '<option value="'.$now.'">' . $now . '</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-3 pl-0">
                                    <button type="submit" name="filtered_search" value="filtered_search" class="btn btn-transition btn btn-sm btn-outline-success"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr class="bg-success my-2" />
    </div>
    <div class="col-xs-12 col-md-4">
        <!-- This div was left empty intentionally -->
    </div>
</div>

<div class="row mt-1 mb-3">
    <?php foreach($videos as $videos) :  ?>
        <div class="col-xs-6 col-md-6 mt-1 mb-2" id="<?= $videos['id']; ?>">
            <div class="row">
                <div class="col-xs-12 mx-auto px-2" style="height: 350px; width: 100%;">
                    <div class="text-center" id="book-top"> 
                        <iframe class="media-object embed-responsive embed-responsive-16by9" style="height: 350px; width: 100%;"
                            src="<?= $videos['link']; ?>" frameborder="0" allowfullscreen>
                        </iframe>
                        <div class="overlay">
                            <button id="<?= $videos['id']; ?>" class="btn btn-dark removeVideo" title="Delete"><i class="fa fa-lg fa-trash removeVideo"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 card-footer py-1 mx-2" style="width: 100%;">
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-info"><?= $videos['title']; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="modal fade bd-example-modal-lg mt-5" id="addvideo" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-primary">
                <h5 class="modal-title">
                    Add New video link
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="title" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="anchor">By</label>
                            <input type="text" class="form-control" name="anchor" id="anchor" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="details">Description</label>
                            <textarea type="text" class="form-control fr-view" name="details" id="details">
                            </textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="link">
                                Paste the YouTube link to this video
                            </label>
                            <input type="text" class="form-control" id="link" name="link" required>
                        </div>
                    </div>
                    <button type="submit" name="addNewVideo" value="addNewVideo" class="btn btn-primary btm-sm btn-block">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Revoke live link -->
<div class="modal fade mt-5" id="removeLiveVideoModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header text-danger">
            <h5 class="modal-title">
                Warning <i class="fa fa-exclamation-triangle"></i> 
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="position-relative">
                <p>
                    <h6 class="text-center">You are about to <b>revoke the live links</b></h6>
                </p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="mr-5 btn-transition btn btn-outline-success" data-dismiss="modal">
                Cancel
            </button>
            <form method="POST">
                <input type="text" name="revoke_live_links" value="revokeLink" hidden>
                
                <button type="submit" class="mr-5 btn-transition btn btn-outline-danger">
                    Yes, Proceed
                </button>
            </form>
        </div>
    </div>
</div>