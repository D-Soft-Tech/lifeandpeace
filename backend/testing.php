<?php

    include_once 'php/db.php';

    $conn = get_DB();

    if(isset($_POST['name']) && (isset($_POST['email'])))
    {
        $name = $_POST['name'];
        $email = $_POST['email'];

        if($name != null && $email != null){

            $output ='
                <div class="modal-header">
                    <h6 class="modal-title" id="destination">
                        Responding to '.$name.' via <span id="rEmail">'.$email.'</span>    
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="contact.php" method="POST">
                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">
                                <h6>
                                    Summarize your response to '.$name.' in few words
                                </h6>
                            </label>
                            <input type="text" name="title" id="exampleEmail" placeholder="(optional)" class="form-control">
                        </div>            
                        <div class="position-relative form-group">
                            <label for="exampleText" class="">
                                <h6>
                                    Your response in full details
                                </h6>
                            </label>
                            <textarea type="text" id="exampleText" class="form-control fr-view" name="details"></textarea>
                        </div>
                        <button type="submit" name="submitResponseMessage" value="submit" class="mt-1 btn btn-primary btn-block">
                            Send Response
                        </button>
                    </form>
                </div>';
            echo $output;
            exit();
        }
        exit();
    }


    if(isset($_POST['user_id']))
    {
        $user_id = $_POST['user_id'];

        if($user_id != '')
        {
            $sql = "
                        UPDATE contacts SET status = 'read' WHERE user_id = '$user_id'
                    ";
                    
            $check = $conn->prepare($sql);
            $read = $check->execute();

            $count = $check->rowCount();

            if($read===true OR $count>0)
            {
                echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-check"></i> DONE, Message marked as read</h6>'.
                        '</div>';
                        exit();
            }
            else
            {
                $errorMsg = '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-attention"></i> Unable to perform the command, please try again later</h6>'.
                            '</div>';

                echo $errorMsg;
                exit();
            }
        }
        exit();
    }

    
    if(isset($_POST['delete']))
    {
        $user_id = $_POST['delete'];

        if($user_id != '')
        {
            $sql = "
                        DELETE FROM contacts WHERE user_id = '$user_id'
                    ";
            $check = $conn->prepare($sql);
            $read = $check->execute();

            $count = $check->rowCount();

            if($read===true OR $count>0)
            {
                echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-check"></i> DONE, Message deleted</h6>'.
                        '</div>';
                        exit();
            }
        }
        exit();
    }

    if(isset($_POST['testUser_id']))
    {
        $testimony_id = $_POST['testUser_id'];

        if($testimony_id != '')
        {
            $sql = "
                        UPDATE testimonies SET status = 'read' WHERE id = '$testimony_id'
                    ";
            $check = $conn->prepare($sql);
            $read = $check->execute();

            $count = $check->rowCount();

            if($read===true OR $count>0)
            {
                echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-check"></i> DONE, Testimony is now available on the main Website </h6>'.
                        '</div>';
                        exit();
            }
            else
            {
                $errorMsg = '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-attention"></i> Unable to perform the command, please try again later</h6>'.
                            '</div>';

                echo $errorMsg;
                exit();
            }
        }
        exit();
    }

    if(isset($_POST['testDelete']))
    {
        $testimony_id = $_POST['testDelete'];

        if($testimony_id != '')
        {
            $sql = "
                        DELETE FROM testimonies WHERE id = '$testimony_id'
                    ";
            $check = $conn->prepare($sql);
            $read = $check->execute();

            $count = $check->rowCount();

            if($read===true OR $count>0)
            {
                echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-check"></i> DONE, The testimony has been deleted</h6>'.
                        '</div>';
                        exit();
            }
        }
        exit();
    }

    if(isset($_POST['deleteComment']))
    {
        $comment_id = $_POST['deleteComment'];

        if($comment_id != '')
        {
            $sql = "
                        DELETE FROM comments WHERE comment_id = '$comment_id'
                    ";
            $check = $conn->prepare($sql);
            $read = $check->execute();

            $count = $check->rowCount();

            if($read===true OR $count>0)
            {
                echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-check"></i> DONE, The Comment has been deleted</h6>'.
                        '</div>';
                        exit();
            }else{
                echo    '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-attention"></i> Unable to delete, please try again later</h6>'.
                        '</div>';
                        exit();
            }
        }
        exit();
    }

    if(isset($_POST['articleComment'])){
        $articleId = $_POST['articleComment'];

        $sql = "
                    SELECT full_name, comments.* FROM users, comments WHERE comments.obj = 'articles' && comments.obj_id = '$articleId' && comments.user_id = users.user_id && comments.status = 'pending'
                ";

        $sql1 = "
                    SELECT full_name, comments.* FROM users, comments WHERE comments.obj = 'articles' && comments.user_id = users.user_id && comments.status = 'read'
                ";

        $result = $conn->query($sql);
        $articleComments = $result->fetchAll();

        foreach($articleComments as $Comments1){
            $c_name = $Comments1['full_name'];
            $c_id = $Comments1['comment_id'];
            $obj_id = $Comments1['obj_id'];
            $user_id = $Comments1['user_id'];
            $comment = $Comments1['comment'];

            $art_comments = array(
                                    'c_name' => $c_name,
                                    'c_id' => $c_id, 
                                    'obj_id' => $obj_id, 
                                    'user_id' => $user_id, 
                                    'comment' => $comment
                                );
        }
        $count = COUNT($articleComments);
        $result= null;

        $result1 = $conn->query($sql1);
        $articleComments1 = $result1->fetchAll();

        foreach($articleComments1 as $Comments2){
            $c_name1 = $Comments2['full_name'];
            $c_id1 = $Comments2['comment_id'];
            $obj_id1 = $Comments2['obj_id'];
            $user_id1 = $Comments2['user_id'];
            $comment1 = $Comments2['comment'];

            $art_comments1 = array(
                                    'c_name' => $c_name1,
                                    'c_id' => $c_id1, 
                                    'obj_id' => $obj_id1, 
                                    'user_id' => $user_id1, 
                                    'comment' => $comment1
                                );
        }
        $count1 = COUNT($articleComments1);


        $results[0] = $art_comments;
        $results[1] = $count;
        
        $results[2] = $art_comments1;

        $results[3] = $count1;

        echo json_encode($results);

        exit();
    }

    if(isset($_POST['allowCommnet_id']))
    {
        $allowComment_id = $_POST['allowCommnet_id'];

        if($allowComment_id != '')
        {
            $sql = "
                        UPDATE comments SET status = 'read' WHERE comment_id = '$allowComment_id'
                    ";
            $check = $conn->prepare($sql);
            $read = $check->execute();

            $count = $check->rowCount();

            if($read===true OR $count>0)
            {
                echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-check"></i> DONE, Comment is now available on the main Website </h6>'.
                        '</div>';
                        exit();
            }
            else
            {
                $errorMsg = '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-attention"></i> Unable to perform the command, please try again later</h6>'.
                            '</div>';

                echo $errorMsg;
                exit();
            }
        }
        exit();
    }

    if(isset($_POST['likeId']))
    {
        $like_id = $_POST['likeId'];

        if($like_id !== '')
        {
            $sql = "
                        SELECT * FROM likes WHERE quote_id = '$like_id'
                    ";
            $stmt = $conn->query($sql);
            $like = $stmt->fetchAll();

            $count = COUNT($like);

            if($count != null OR $count >= 0)
            {
                echo  $count;
                exit();
            }
        }
        exit();
    }

    if(isset($_POST['deleteQuote']))
    {
        $quote_id = $_POST['deleteQuote'];

        if($quote_id != '')
        {
            $sql = "
                        DELETE FROM quote WHERE quote_id = '$quote_id'
                    ";
            $check = $conn->prepare($sql);
            $read = $check->execute();

            $count = $check->rowCount();

            if($read===true OR $count>0)
            {
                echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-check"></i> DONE, The quote has been deleted</h6>'.
                        '</div>';
                        exit();
            }else{
                echo    '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-attention"></i> Unable to delete, please try again later</h6>'.
                        '</div>';
                        exit();
            }
        }
        exit();
    }

    if(isset($_POST['removeWeeklyProgram']) && isset($_POST['name']) && isset($_POST['value']))
    {
        $event_id = $_POST['removeWeeklyProgram'];
        $theme = $_POST['name'];
        $ext = $_POST['value'];

        $path = "../images/event/weeklyProgram/".$theme.".".$ext;

        if($theme !=="" && $ext !=="" && $event_id !=="")
        {
            $deleted = unlink($path);

            if($deleted)
            {
                $sql = "
                            DELETE FROM weekly_meeting WHERE meeting_id = '$event_id'
                        ";

                $check = $conn->prepare($sql);
                $read = $check->execute();

                $count = $check->rowCount();

                if($read===true OR $count>0)
                {
                    echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-check"></i> DONE, The Weekly Program has been removed successfully</h6>'.
                            '</div>';
                            exit();
                }
            }
        }
    }

    if(isset($_POST['removeEvent']) && isset($_POST['name']) && isset($_POST['value']))
    {
        $event_id = $_POST['removeEvent'];
        $theme = $_POST['name'];
        $ext = $_POST['value'];

        $path = "../images/event/".$theme.".".$ext;

        if($theme !=="" && $ext !=="" && $event_id !=="")
        {
            $deleted = unlink($path);

            if($deleted)
            {
                $sql = "
                            DELETE FROM event WHERE event_id = '$event_id'
                        ";

                $check = $conn->prepare($sql);
                $read = $check->execute();

                $count = $check->rowCount();

                if($read===true OR $count>0)
                {
                    echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-check"></i> DONE, The Event has been deleted successfully</h6>'.
                            '</div>';
                            exit();
                }
            }
        }
    }

    if(isset($_POST['removeTeam']) && isset($_POST['name']) && isset($_POST['value']))
    {
        $id = $_POST['removeTeam'];
        $name = $_POST['name'];
        $ext = $_POST['value'];

        $path = "../images/team/".$name.".".$ext;

        if($id !=="" && $ext !=="" && $name !=="")
        {
            $deleted = unlink($path);

            if($deleted===true)
            {
                $sql = "
                        DELETE FROM team WHERE id = '$id'
                    ";

                $check = $conn->prepare($sql);
                $read = $check->execute();

                $count = $check->rowCount();

                if($read===true OR $count>0)
                {
                    echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-check"></i> DONE, The team member has been removed</h6>'.
                            '</div>';
                            exit();
                }
                else
                {
                    $errorMsg =  '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                        '<h6><i class="icon fa pe-7s-attention"></i> Unable to delete, please try again later</h6>'.
                                    '</div>';
        
                    echo $errorMsg;
                    exit();
                }
            }
        }
        else
        {
            $errorMsg =  '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-attention"></i> Unable to delete, please try again later</h6>'.
                            '</div>';

            echo $errorMsg;
            exit();
        }  
    }
    
    if(isset($_POST['editBookPrice']) && isset($_POST['newPrice']))
    {
        $book_id = $_POST['editBookPrice'];
        $newPrice = $_POST['newPrice'];

        if($book_id != '' && $newPrice != '')
        {
            $sql = "
                        UPDATE books SET price = '$newPrice' WHERE book_id = '$book_id'
                    ";
            $check = $conn->prepare($sql);
            $read = $check->execute();

            $count = $check->rowCount();
    
            if($read === true OR $count>0)
            {
                $success =      '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                    '<h6><i class="icon fa pe-7s-check"></i> DONE, The price of the book has been changed successfully</h6>'.
                                '</div>';

                echo $success;
                    
                exit();
            }
            else
            {
                $errorMsg =  '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                    '<h6><i class="icon fa pe-7s-attention"></i> Unable to change the price, please try again later</h6>'.
                                '</div>';

                echo $errorMsg;
                exit();
            }
        }
        exit();
    }

    if(isset($_POST['removePhoto']) && isset($_POST['name']) && isset($_POST['value']))
    {
        $photo_id = $_POST['removePhoto'];
        $title = $_POST['name'];
        $ext = $_POST['value'];

        $path = "../images/gallery/".$title.".".$ext;

        if($title !=="" && $ext !=="" && $photo_id !=="")
        {
            $deleted = unlink($path);

            if($deleted)
            {
                $sql = "
                            DELETE FROM gallery WHERE id = '$photo_id'
                        ";

                $check = $conn->prepare($sql);
                $read = $check->execute();

                $count = $check->rowCount();

                if($read===true OR $count>0)
                {
                    echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-check"></i> DONE, The photo has been successfully deleted from your gallery</h6>'.
                            '</div>';
                            exit();
                }else{
                    $errorMsg =  '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                        '<h6><i class="icon fa pe-7s-attention"></i> Unable to delete, please try again later</h6>'.
                                    '</div>';
    
                    echo $errorMsg;
                    exit();
                }
            }else{
                $errorMsg =  '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                    '<h6><i class="icon fa pe-7s-attention"></i> Unable to delete, please try again later</h6>'.
                                '</div>';

                echo $errorMsg;
                exit();
            }
            exit();

        }else{
            $errorMsg =  '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-attention"></i> Unable to delete, please try again later</h6>'.
                            '</div>';

            echo $errorMsg;
            exit();
        }

        
    }
    
    if(isset($_POST['removeDonation']))
    {
        $id = $_POST['removeDonation'];

        if($id != '')
        {
            $sql = "
                        DELETE FROM donation WHERE id = '$id'
                    ";

            $check = $conn->prepare($sql);
            $read = $check->execute();

            $count = $check->rowCount();

            if($read===true OR $count>0)
            {
                echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-check"></i> DONE, The donation has been deleted from the database</h6>'.
                        '</div>';
                        exit();
            }
        }
        exit();
    }
    
    if(isset($_POST['deleteArticleId']))
    {
        $id = $_POST['deleteArticleId'];

        if($id !== '')
        {
            $sql = "
                        DELETE FROM articles WHERE articles_id = '$id'
                    ";

            $check = $conn->prepare($sql);
            $read = $check->execute();

            $count = $check->rowCount();

            if($read===true OR $count>0)
            {
                echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-check"></i> DONE, The article has been deleted from the successfully</h6>'.
                        '</div>';
                        exit();
            }
        }
        exit();
    }
    
    if(isset($_POST['deleteAccountId']))
    {
        $id = $_POST['deleteAccountId'];

        if($id !== '')
        {
            $sql = "
                        DELETE FROM account WHERE id = '$id'
                    ";

            $check = $conn->prepare($sql);
            $read = $check->execute();

            $count = $check->rowCount();

            if($read===true OR $count>0)
            {
                echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-check"></i> DONE, the account has been deleted successfully</h6>'.
                        '</div>';
                        exit();
            }
        }
        exit();
    }
    
    if(isset($_POST['deleteAdmin']))
    {
        $id = $_POST['deleteAdmin'];

        if($id !== '')
        {
            $sql = "
                        DELETE FROM admin WHERE admin_id = '$id'
                    ";

            $check = $conn->prepare($sql);
            $read = $check->execute();

            $count = $check->rowCount();

            if($read===true OR $count>0)
            {
                echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-check"></i> DONE</h6>'.
                        '</div>';
                        exit();
            }
        }
        exit();
    }
    
    if(isset($_POST['removeVideo']))
    {
        $id = $_POST['removeVideo'];

        if($id != '')
        {
            $sql = "
                        DELETE FROM message WHERE id = '$id' && type = 'video'
                    ";

            $check = $conn->prepare($sql);
            $read = $check->execute();

            $count = $check->rowCount();

            if($read===true OR $count>0)
            {
                echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                            '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                            '<h6><i class="icon fa pe-7s-check"></i> Successful</h6>'.
                        '</div>';
                        exit();
            }
        }
        exit();
    }
    
    if(isset($_POST['removeAudio']) && isset($_POST['audio_name']) && isset($_POST['value']))
    {
        $id = $_POST['removeAudio'];
        $title = $_POST['audio_name'];
        $ext2 = $_POST['value'];

        $path2 = "../audio_messages/".$title.".".$ext2;

        if($title !=="" && $ext2 !=="")
        {
            $deleted = unlink($path2);

            if($deleted)
            {
                $sql = "
                            DELETE FROM message WHERE id = '$id' && type = 'audio'
                        ";

                $check = $conn->prepare($sql);
                $read = $check->execute();

                $count = $check->rowCount();

                if($read===true OR $count>0)
                {
                    echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-check"></i> Successful</h6>'.
                            '</div>';
                            exit();
                }
                exit();
            }else{
                $errorMsg =  '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                    '<h6><i class="icon fa pe-7s-attention"></i> Unable to delete, please try again later</h6>'.
                                '</div>';

                echo $errorMsg;
                exit();
            }
        }else{
            $errorMsg =  '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-attention"></i> Unable to delete, please try again later</h6>'.
                            '</div>';

            echo $errorMsg;
            exit();
        }
        exit();
    }
    
    if(isset($_POST['removeBook']) && isset($_POST['name']) && isset($_POST['ext']) && isset($_POST['ext2']))
    {
        $id = $_POST['removeBook'];
        $title = $_POST['name'];
        $ext = $_POST['ext'];
        $ext2 = $_POST['ext2'];

        $path = "../images/books/".$title.".".$ext;
        $path2 = "../books/".$title.".".$ext2;

        if($id !=="" && $title !=="" && $ext !=="" && $ext2 !=="")
        {
            $delete_book_pdf = unlink($path2);
            $delete_book_image = unlink($path);

            if($delete_book_pdf===true && $delete_book_image===true)
            {
                    $sql = "
                            DELETE FROM books WHERE book_id = '$id'
                        ";

                $check = $conn->prepare($sql);
                $read = $check->execute();

                $count = $check->rowCount();

                if($read===true OR $count>0)
                {
                    echo    '<div class="col-sm-12 alert alert-success alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-check"></i> Successful</h6>'.
                            '</div>';
                            exit();
                }
            }
            else
            {
                $errorMsg =  '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                    '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                    '<h6><i class="icon fa pe-7s-attention"></i> Unable to delete, please try again later</h6>'.
                                '</div>';
    
                echo $errorMsg;
                exit();
            }
        }
        else
        {
            $errorMsg =  '<div class="col-sm-12 alert alert-danger alert-dismissable">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<h6><i class="icon fa pe-7s-attention"></i> Unable to delete, please try again later</h6>'.
                            '</div>';

            echo $errorMsg;
            exit();
        }  
    }

    if(isset($_POST['checkUsername'])){
        $username = $_POST['checkUsername'];

        if(!empty($username)){
            $sql = "
                            SELECT * FROM users WHERE username = :username
                        ";

                $checker = $conn->prepare($sql);
                $checker->bindParam(':username', $username);

                try {
                    $checkers = $checker->execute();
                    $userDetails = $checker->fetch();
                } catch (PDOException $th) {
                    
                }

                global $checkers, $userDetails;

                if($checkers===true && !empty($userDetails))
                {
                    echo "<span class='text-danger'> $username is already taken</span>";
                }else{
                    echo "";
                }
        }
    }
?>