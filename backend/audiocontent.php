<style>
    .image-top{
        overflow: hidden;
    }
    .image-top:hover img{
        transition: 2s ease;
        transform: scale(1.15);
    }

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
</style>

<?php 

    require_once ('audio_class.php');

    if (isset($_POST['addNewAudio'])) 
    {
        if (isset($_FILES['audioPicture']) && isset($_FILES['audioFile']))
        {  
            $title = $_POST['title'];
           $anchor = $_POST['anchor'];
           $details = $_POST['details'];

           $dayNumber = date("jS"); 
           $day = $dayNumber . " of ";
           $month = date("F"); 
           $year = date("Y");

            $name = strtolower($_FILES['audioPicture']['name']);
            $splitted = explode(".", $name);
            $ext = end($splitted);
            $path = "../images/audio/".$title.".".$ext;

            $mp3 = strtolower($_FILES['audioFile']['name']);
            $splitted2 = explode(".", $mp3);
            $ext2 = end($splitted2);
            $path2 = "../audio_messages/".$title.".".$ext2;
            

            $passport_obj = new Passport($name, $ext, $path, $mp3, $ext2, $path2, $title, $anchor, $details, $day, $month, $year);
            $passport_obj->Upload();
        }
    }

?>

<div class="row mb-0">
    <div class="col-xs-12 col-md-8">
        <div class="alert alert-success fade show" role="alert">
            <div class="row">
                <div class="col-6">
                    <span class="fsize-2 font-weight-bold">Audio</span>
                </div>
                <div class="col-6">
                    <button class="ml-2 mr-5 btn-transition btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#addAudio">
                        Add new
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
                            <a href="audio.php?pages=<?= $Previous; ?>&page=<?= $page; ?>&month=<?= $month; ?>&year=<?= $year; ?>" 
                                class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Previous">
                                <span aria-hidden="true">&laquo; </span>
                            </a>
                        </li>
                        <?php 
                            $i = $pages > 5 ? $pages - 4 : 1;
                            for($i; $i<= $pages; $i++)
                            {
                            ?>
                            <li><a href="audio.php?page=<?= $i; ?>&pages=<?= $pages; ?>&month=<?= $month; ?>&year=<?= $year; ?>" class="btn btn-transition btn btn-sm btn-outline-primary"><?= $i; ?></a></li>
                            <?php 
                            }
                            ?>
                        <li>
                            <a href="audio.php?pages=<?= $Next; ?>&page=<?= $page; ?>&month=<?= $month; ?>&year=<?= $year; ?>"
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
    <?php foreach($audios as $audios) :  ?>
        <div class="col-xs-6 col-md-3 mt-1 mb-3" id="<?= $audios['id']; ?>">
            <div class="row">
                <div class="col-xs-12 mx-auto px-2" style="height: 150px; width: 100%;">
                    <div class="text-center" id="book-top">
                        <img class="img-resoponsive" src="../images/audio/<?= $audios['title']; ?>.<?= $audios['ext']; ?>" alt="<?= $audios['title']; ?>" style="height: 150px; width: 100%;" />
                        <audio class="overlay_audio" controls style="height: 30px;">
                            <source src="../audio_messages/<?= $audios['title']; ?>.<?= $audios['ext2']; ?>" type="audio/<?= $audios['ext2']; ?>">
                        </audio>
                        <div class="overlay">
                            <button id="<?= $audios['id']; ?>" name="<?= $audios['title']; ?>" value="<?= $audios['ext2']; ?>" class="btn btn-dark removeAudio" title="Delete"><i class="fa fa-lg fa-trash removeaudio"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 card-footer py-1 mx-2" style="width: 100%;">
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-info"><?= $audios['title']; ?></h6>
                        </div>
                        <div class="col-md-12">
                            <h6 class="">Downloads: <span class="text-success"><?= number_format(audio_downloads($audios['id'], $audios['title'])); ?></span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="modal fade bd-example-modal-lg mt-5" id="addAudio" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header text-primary">
            <h5 class="modal-title">
                Upload New Audio
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
                <div class="form-group col-md-6">
                    <label for="audioFile">
                        Choose the Audio file to be Uploaded (mp3 only)
                    </label>
                    <input type="file" class="form-control" id="audioFile" name="audioFile" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="audioPicture">
                        Choose the Picture for this Audio
                    </label>
                    <input type="file" class="form-control" id="audioPicture" name="audioPicture" required>
                </div>
            </div>
            <button type="submit" name="addNewAudio" value="addNewAudio" class="btn btn-primary btm-sm btn-block">Upload</button>
        </form>
        </div>
    </div>
</div>