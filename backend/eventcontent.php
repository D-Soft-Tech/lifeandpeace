<?php

    require_once ('event_class.php');

    if (isset($_POST['submitAddWeeklyEvent'])) 
    {
        if (isset($_FILES) && isset($_POST))
        {  
            $theme = $_POST['theme'];
            $anchor = $_POST['anchor'];
            $phone = $_POST['phone'];
            $details = $_POST['details'];

            $day = $_POST['dayOfTheWeek'];

            $hour = $_POST['hour'];
            $minutes = $_POST['minutes'];
            $amOrPm = $_POST['amOrPm'];

            $time = $hour. " : ". $minutes . " ". $amOrPm;

            $name = strtolower($_FILES['eventPicture']['name']);

            $splitted = explode(".", $name);
            $ext = end($splitted);

            $path = "../images/event/weeklyProgram/".$theme.".".$ext;

            $weeklyProgram = new weeklyProgram($name, $ext, $path, $theme, $anchor, $phone, $details, $day, $time);
            $weeklyProgram->Upload();
        }
    }

    if (isset($_POST['submitAddEvent'])) 
    {
        if (isset($_FILES) && isset($_POST))
        {  
            $theme = $_POST['theme'];
            $anchor = $_POST['anchor'];
            $details = $_POST['details'];

            $event_from1 = strtotime($_POST['from']);
            $event_from = date("l, F jS; Y", $event_from1);

            
            $event_to1 = strtotime($_POST['to']);
            $event_to = date("l, F jS; Y", $event_to1);

            $event_time = $_POST['time'];

            $name = strtolower($_FILES['eventPicture']['name']);

            $splitted = explode(".", $name);
            $ext = end($splitted);

            $path = "../images/event/".$theme.".".$ext;

            $passport_obj = new Passport($name, $ext, $path, $theme, $anchor, $details, $event_from, $event_to, $event_time);
            $passport_obj->Upload();
        }
    }
?>

<div class="row">
    <div class="col-xs-12 col-md-8">
        <div class="card mb-2 widget-content bg-premium-dark">
            <div class="row widget-content-wrapper text-white">
                <div class="col-6 widget-content-left shadow">
                    <div class="widget-heading"><h5 class="font-weight-bold">Events</h5></div>
                </div>
                <div class="col-6">
                    <button class="ml-2 mr-5 btn-transition btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#addEvent">
                        Add Event
                    </button>
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
                <a href="event.php?pages=<?= $Previous; ?>&page=<?= $page; ?>" 
                    class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Previous">
                    <span aria-hidden="true">&laquo; </span>
                </a>
            </li>
            <?php 
                $i = $pages > 5 ? $pages - 4 : 1;
                for($i; $i<= $pages; $i++)
                {
                ?>
                <li><a href="event.php?page=<?= $i; ?>&pages=<?= $pages; ?>" class="btn btn-transition btn btn-sm btn-outline-primary"><?= $i; ?></a></li>
                <?php 
                }
                ?>
            <li>
                <a href="event.php?pages=<?= $Next; ?>&page=<?= $page; ?>"
                class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>


<!-- each comments -->
<?php foreach($events as $events) :  ?>
    <div class="row  my-4 mx-3" id="<?= $events['event_id']; ?>">
        <div class="card card-body col-xs-12 col-md-8">
            <img src="../images/event/<?= $events['theme'];?>.<?= $events['ext']; ?>" class="mb-3 image-responsive" style="height: 300px; width: 100%;" alt="<?= $events['theme']; ?>">
            <h4 class="card-title">Theme: &nbsp;<?= $events['theme'];?></h4>
            <h5 class="card-title">Anchor: &nbsp;<?= $events['anchor'];?></h5>
            <p><span class="card-title">Date</span>: &nbsp;
                <?= $events['event_from']; ?> / 
                <?= $events['event_to']; ?> <br />
                <span class="card-title">Time</span>: &nbsp;<?= $events['event_time']; ?>
            </p>
            <button type="button" id="<?= $events['event_id']; ?>" name="<?= $events['theme']; ?>" value="<?= $events['ext']; ?>" class="ml-2 mr-5 btn btn-transition btn-outline-danger removeEvent">
                Remove Event
            </button>
        </div>
        <div class="col-xs-12 col-md-4"><br /></div>
    </div>
<?php endforeach; ?>

<div class="modal fade bd-example-modal-lg mt-2" id="addEvent" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="false">
    <div class="modal-dialog modal-lg mt-5 mb-5">
        <div class="modal-content">
        <div class="modal-header text-info">
            <h5 class="modal-title">
                Add new Event
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="theme">Theme</label>
                        <input type="text" class="form-control" name="theme" id="theme" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="anchor">Anchor</label>
                        <input type="text" class="form-control" name="anchor" id="anchor" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="details">Details</label>
                        <textarea class="form-control fr-view" name="details" id="details"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-xs-12">
                        Date of the Event:
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="datepicker">From</label>
                        <input type="text" class="form-control" name="from" id="datepicker" required>
                    </div>
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="datepicker2">To</label>
                        <input type="text" class="form-control" name="to" id="datepicker2" Placeholder="(optional)">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="time">Time of the event</label>
                                <input type="text" class="form-control" name="time" id="time" Placeholder="(optional)">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="eventPicture">
                                    Poster for the Event
                                </label>
                                <input type="file" class="form-control" name="eventPicture" id="eventPicture">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" name="submitAddEvent" value="submit" class="btn btn-primary block btm-sm btn-block mt-1">Save</button>
            </form>
        </div>
    </div>
</div>

