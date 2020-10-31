<?php

    class Passport
    {
        public
        $image_name,
        $image_ext,
        $path,
        $theme,
        $anchor,
        $details,
        $event_from,
        $event_to,
        $event_time;

        public function __construct($image_name, $image_ext, $path, $theme, $anchor, $details, $event_from, $event_to, $event_time)
        {
            $this->image_name = $image_name;
            $this->image_ext = $image_ext;
            $this->path = $path;
            $this->theme = $theme;
            $this->anchor = $anchor;
            $this->details = $details;
            $this->event_from = $event_from;
            $this->event_to = $event_to;
            $this->event_time = $event_time;
        }

        public function Upload()
        {

            $error = array();
            $image_format = array('jpeg','jpg','png');

            if ($_FILES['eventPicture']) 
            {
                $files = $_FILES['eventPicture'];
                //setting variables for the passport object
                $temp_name = $files['tmp_name'];
                $image_type = strtolower($files['type']);
                $image_size = $files['size'];
                
                //End of variable setting


                if (in_array($this->image_ext, $image_format)===false) {
                    $error[] = "The format, $this->image_ext, is not allowed <br> The permitted image formats are: jpeg, jpg and png";
                }
    
                if ($image_size > 20971520) {
                    $error[] = "The image size is too large, please upload an image of 10mb or less";
                }
                if($this->anchor ===""){
                    $error[] = "You did not supply the anchor of the event";
                }
                if($this->details ===""){
                    $error[] = "You did not supply the details of the event";
                }
                if($this->event_time ===""){
                    $this->event_time = " ";
                }
                if($this->theme ===""){
                    $error[] = "You did not supply the theme of the event";
                }
                if($this->event_from ===""){
                    $error[] = "You did not supply the starting date of the event";
                }
    
                if (empty($error))
                {

                    $q = "INSERT INTO event
                        (
                            ext,
                            theme,
                            anchor,
                            details,
                            event_from,
                            event_to,
                            event_time
                        )
                        VALUES
                        (
                            :ext,
                            :theme,
                            :anchor,
                            :details,
                            :event_from,
                            :event_to,
                            :event_time
                        )";
                    global $conn;
                    $stmt = $conn->prepare($q);
                    $stmt->bindValue(':ext', $this->image_ext);
                    $stmt->bindValue(':theme', $this->theme);
                    $stmt->bindValue(':anchor', $this->anchor);
                    $stmt->bindValue(':details', $this->details);
                    $stmt->bindValue(':event_from', $this->event_from);
                    $stmt->bindValue(':event_to', $this->event_to);
                    $stmt->bindValue(':event_time', $this->event_time);
                    $result = $stmt->execute();
                    
                    if ($result===true) 
                    {
                        $file_uploaded = move_uploaded_file($temp_name, $this->path);
    
                        if ($file_uploaded===true) {
                            $success = '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                            '<h6><i class="icon fa pe-7s-check"></i> Event added successfully</h6>'.
                                        '</div>';

                        echo $success;

                        }
                    }
                }
                else 
                {
                    echo    '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-attention"></i>'. "Failed to upload because: <br>";
                                    $j = 0;
                                    for ($i=1; $i <= count($error); ++$i) { 
                                        echo $i . ". ". $error[$j]. "<br />";
                                        ++$j;
                                    }
                    echo        '</h6>'.
                            '</div>';
                }
            }
            else
            {
                echo '<script> document.getElementById("update").innerHTML = "Please fill out the details of the event";</script>';;
            }

        }//End of the upload function
    }//End of the passport classs



    class WeeklyProgram
    {
        public
        $image_name,
        $image_ext,
        $path,
        $theme,
        $anchor,
        $phone,
        $details,
        $day,
        $time;

        public function __construct($image_name, $image_ext, $path, $theme, $anchor, $phone, $details, $day, $time)
        {
            $this->image_name = $image_name;
            $this->image_ext = $image_ext;
            $this->path = $path;
            $this->theme = $theme;
            $this->anchor = $anchor;
            $this->phone = $phone;
            $this->details = $details;
            $this->day = $day;
            $this->time = $time;
        }

        public function Upload()
        {

            $error = array();
            $image_format = array('jpeg','jpg','png');

            if ($_FILES['eventPicture']) 
            {
                $files = $_FILES['eventPicture'];
                //setting variables for the passport object
                $temp_name = $files['tmp_name'];
                $image_type = strtolower($files['type']);
                $image_size = $files['size'];
                
                //End of variable setting


                if (in_array($this->image_ext, $image_format)===false) {
                    $error[] = "The format, $this->image_ext, is not allowed <br> The permitted image formats are: jpeg, jpg and png";
                }
    
                if ($image_size > 20971520) {
                    $error[] = "The image size is too large, please upload an image of 10mb or less";
                }
                if($this->anchor ===""){
                    $error[] = "You did not supply the anchor of the Program";
                }
                if($this->details ===""){
                    $error[] = "You did not supply the details of the Program";
                }
                if($this->time ===""){
                    $error[] = "You did not supply the time of the Program";
                }
                if($this->theme ===""){
                    $error[] = "You did not supply the theme of the Program";
                }
                if($this->day ===""){
                    $error[] = "You did not supply the starting date of the Program";
                }
    
                if (empty($error))
                {

                    $q = "INSERT INTO weekly_meeting
                        (
                            ext,
                            title,
                            anchor,
                            phone,
                            meeting_details,
                            meeting_day,
                            meeting_time
                        )
                        VALUES
                        (
                            :ext,
                            :theme,
                            :anchor,
                            :phone,
                            :details,
                            :day,
                            :time
                        )";
                    global $conn;
                    $stmt = $conn->prepare($q);
                    $stmt->bindValue(':ext', $this->image_ext);
                    $stmt->bindValue(':theme', $this->theme);
                    $stmt->bindValue(':anchor', $this->anchor);
                    $stmt->bindValue(':phone', $this->phone);
                    $stmt->bindValue(':details', $this->details);
                    $stmt->bindValue(':day', $this->day);
                    $stmt->bindValue(':time', $this->time);
                    $result = $stmt->execute();
                    
                    if ($result===true) 
                    {
                        $file_uploaded = move_uploaded_file($temp_name, $this->path);
    
                        if ($file_uploaded===true) {
                            $success = '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                            '<h6><i class="icon fa pe-7s-check"></i> Event added successfully</h6>'.
                                        '</div>';

                        echo $success;

                        }
                    }
                }
                else 
                {
                    echo    '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-attention"></i>'. "Failed to upload because: <br>";
                                    $j = 0;
                                    for ($i=1; $i <= count($error); ++$i) { 
                                        echo $i . ". ". $error[$j]. "<br />";
                                        ++$j;
                                    }
                    echo        '</h6>'.
                            '</div>';
                }
            }
            else
            {
                echo '<script> document.getElementById("update").innerHTML = "Please fill out the details of the Program";</script>';;
            }

        }//End of the upload function
    }//End of the weeklyProgram classs

?>