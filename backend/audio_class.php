<?php

    class Passport
    {
        public
        $image_name,
        $image_ext,
        $path,
        $mp3,
        $ext2,
        $path2,
        $title,
        $anchor,
        $details,
        $day,
        $month,
        $year;

        public function __construct($name, $ext, $path, $mp3, $ext2, $path2, $title, $anchor, $details, $day, $month, $year)
        {
            $this->image_name = $name;
            $this->image_ext = $ext;
            $this->path = $path;
            $this->mp3 = $mp3;
            $this->ext2 = $ext2;
            $this->path2 = $path2;
            $this->title = $title;
            $this->anchor = $anchor;
            $this->details = $details;
            $this->day = $day;
            $this->month = $month;
            $this->year = $year;
        }

        public function Upload()
        {

            $error = array();
            $image_format = array('jpeg','jpg','png');

            $mp3_format = array('mp3');

            if ($_FILES['audioPicture'] && $_FILES['audioFile']) 
            {
                $files = $_FILES['audioPicture'];
                //setting variables for the passport object
                $temp_name = $files['tmp_name'];
                $image_type = strtolower($files['type']);
                $image_size = $files['size'];

                $audioMP3 = $_FILES['audioFile'];
                $temp_name2 = $audioMP3['tmp_name'];
                $image_type2 = strtolower($audioMP3['type']);
                $audio_size = $audioMP3['size'];
                
                //End of variable setting


                if (in_array($this->image_ext, $image_format)===false) {
                    $error[] = "The format, $this->image_ext, is not allowed <br> The permitted image formats are: jpeg, jpg and png";
                }

                if (in_array($this->ext2, $mp3_format)===false) {
                    $error[] = "The audio format, $this->ext2, is not allowed <br> The permitted audio format is: mp3";
                }
    
                if ($image_size > 20971520) {
                    $error[] = "The image size is too large, please upload an image of 10mb or less";
                }

                if ($audio_size > 83886080) {
                    $error[] = "The audio size is too large, please upload find a way to compress it to 70mb or less";
                }

                if($this->anchor ===""){
                    $error[] = "You did not supply the Author of the video";
                }
                if($this->details ===""){
                    $error[] = "You did not supply any detail for the video";
                }
                if($this->title ===""){
                    $error[] = "You did not supply the title of the video";
                }
    
                if (empty($error))
                {

                    $sql =   "
                      INSERT INTO message (title, sermon_by, type, details, day, month, year, ext, ext2) 
                      VALUES(:title, :sermon_by, :type, :details, :day, :month, :year, :ext, :ext2)
                    ";

                    global $conn;
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':title', $this->title);
                    $stmt->bindValue(':sermon_by', $this->anchor);
                    $stmt->bindValue(':type', 'audio');
                    $stmt->bindValue(':details', $this->details);
                    $stmt->bindValue(':day', $this->day);
                    $stmt->bindValue(':month', $this->month);
                    $stmt->bindValue(':year', $this->year);
                    $stmt->bindValue(':ext', $this->image_ext);
                    $stmt->bindValue(':ext2', $this->ext2);

                    $result = $stmt->execute();

                    $count = $stmt->rowCount();
                    
                    if ($result===true && $count>0) 
                    {
                        $audio_image_uploaded = move_uploaded_file($temp_name, $this->path);

                        $audio_mp3_uploaded = move_uploaded_file($temp_name2, $this->path2);
    
                        if ($audio_image_uploaded===true && $audio_mp3_uploaded===true)
                        {
                            $success = '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                            '<h6><i class="icon fa pe-7s-check"></i> Success</h6>'.
                                        '</div>';

                            echo $success;
                        }
                        else
                        {
                            echo    '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                        '<h6><i class="icon fa pe-7s-attention"></i>Error uploading the audio, please try again later</h6>'.
                                    '</div>';
                        }
                    }
                    else
                        {
                            echo    '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                        '<h6><i class="icon fa pe-7s-attention"></i>Error uploading the audio, please try again later</h6>'.
                                    '</div>';
                        }
                }
                else 
                {
                    echo    '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-attention"></i>'. "Failed to add because: <br>";
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
                echo    '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-attention"></i>Please ensure that you use choose picture and audio file to be uploaded!</h6>'.
                        '</div>';
            }

        }//End of the upload function
    }//End of the passport classs

?>