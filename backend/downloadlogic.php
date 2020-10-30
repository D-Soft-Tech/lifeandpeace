<?php

// downLoads files
if (isset($_POST['download']) && isset($_POST['downLoadNow']) && !empty($_POST['downLoadNow']))
{
    $book_Title = $_POST['downLoadNow'];
    $book_Format = $_POST['downLoadFormat'];
    $book_Id = $_POST['downLoadId'];
    $refCode = $_POST['downLoadRef'];

    $filepath = 'books/' . $book_Title.'.'.$book_Format;


    if (file_exists($filepath))
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');
        header('Content-Disposition: attachment; filename='.basename($filepath));
        header('Pragma: public');
        

        // Now update downLoads count
        $updateQuery = "UPDATE transactions SET transc_status='completed' WHERE purpose = 'books' && purpose_id = '$book_Id' && reference = '$refCode'";
        if($conn->query($updateQuery) && $conn->query($updateQuery)->rowCount >=0)
        {
            $downloadCounter = $conn->query("INSERT INTO downloads (item, item_id) VALUES('books', '$book_Id')");

            unset($_SESSION['shoppingCart']);
            unset($refCode);

            readfile($filepath);
            
            exit;
        }
        else{

            unset($_SESSION['shoppingCart']);
            unset($refCode);

            $response =     '<div class="alert alert-danger alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<div class="">'.
                                    '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Something went wrong please try again later</h6>'.
                                '</div>'.
                            '</div>';
        }
        unset($_SESSION['shoppingCart']);
        unset($refCode);
        exit;
    }
    else{echo "file does not exist";}
}

?>