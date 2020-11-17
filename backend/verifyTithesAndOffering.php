<?php

    session_start();

    include_once 'php/db.php';

    $conn = get_DB();

    if(isset($_POST['refCode']) && !empty($_POST['refCode']) && $_POST['refCode'] === $_SESSION['refCode'])
    {
        $sql_uId =  "
                        SELECT user_id FROM users WHERE username = :userName
                    ";

        $stmta = $conn->prepare($sql_uId);
        $stmta->bindValue(':userName', $_SESSION['username_frontEnd']);
        $stmta->execute();

        $user_id = $stmta->fetch();

        $user_id = $user_id['user_id'];

        date_default_timezone_set ('Africa/lagos');
        $time = date("h:i a");

        $dayNumber = date("jS"); 
        $day = $dayNumber . " of ";
        $month = date("F"); 
        $year = date("Y");

        $sql_donate = "
                        INSERT INTO transactions (user_id, purpose, reference, details, transc_status, transc_time, day, month, year, amount)
                        VALUES(:user_id, :purpose, :reference, :details, 'completed', :transc_time, :day, :month, :year, :amount)
                    ";

        $stmt = $conn->prepare($sql_donate);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':purpose', $_POST['purpose']);
        $stmt->bindParam(':reference', $_POST['refCode']);
        $stmt->bindParam(':details', $_POST['details']);
        $stmt->bindParam(':transc_time', $time);
        $stmt->bindParam(':day', $day);
        $stmt->bindParam(':month', $month);
        $stmt->bindParam(':amount', $_POST['amount']);
        $stmt->bindParam(':year', $year);


        if($checker = $stmt->execute())
        {
            echo    '<div class="alert alert-success alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                        '<div class="">'.
                            '<p><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Successfull'.
                            '</p>'.
                        '</div>'.
                    '</div>';
        }
        else
        {
            echo    '<div class="alert alert-success alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                        '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                        '<div class="">'.
                            '<p><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Payment successfull but unable to save your record'.
                            '</p>'.
                        '</div>'.
                    '</div>';
        }
    }
?>