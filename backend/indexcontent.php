<?php
    $alertMessage = "";
    if(isset($_POST['submitFocusForTheMonth']) && !empty($_POST['submitFocusForTheMonth']) && $_POST['submitFocusForTheMonth'] === 'submit')
    {
        $sanitizer = filter_var_array($_POST, FILTER_SANITIZE_STRING);

        $theme_focus = $sanitizer['focusTheme'];
        $scripture_focus = $sanitizer['focusScripture'];
        $details_focus = $sanitizer['focusDetails'];

        $insertFocus = "
                            UPDATE focus SET theme = :theme, details = :details, script = :script WHERE id = 1
                        ";

        $stmt = $conn->prepare($insertFocus);

        $stmt->bindValue(':theme', $theme_focus);
        $stmt->bindValue(':details', $details_focus);
        $stmt->bindValue(':script', $scripture_focus);

        if($stmt->execute())
        {
            $alertMessage = '<div class="alert alert-success alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<div class="">'.
                                    '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Successfull!!!</h6>'.
                                '</div>'.
                            '</div>';
        }
        else
        {
            $alertMessage = '<div class="alert alert-danger alert-dismissable mt-2" style="margin-right: 10%; margin-top: 10px; margin-bottom: 0px; margin-left: 10%;">'.
                                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'.
                                '<div class="">'.
                                    '<h6><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp; Error performing the task</h6>'.
                                '</div>'.
                            '</div>';
        }
        
    }

?>
<div class="row">
    <div class="col-md-12 my-1">
        <?= $alertMessage; ?>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content bg-midnight-bloom">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">
                    <?php
                        $monthNow = date('F');
                        $yearNow = date('Y');

                        $bookSales = $conn->query("SELECT sum(amount) AS 
                        amount, COUNT(amount) AS downloads FROM transactions WHERE purpose = 'books' && month = '$monthNow' && year = '$yearNow'");
                        $bookSales = $bookSales->fetch();
                    ?>
                        Books
                        <span class="badge badge-pill badge-light"><?= $bookSales['downloads']; ?></span>
                    </div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span># <?= number_format($bookSales['amount']); ?></span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content bg-arielle-smile">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                     <?php
                        $monthNow = date('F');
                        $donation = $conn->query("SELECT sum(amount) AS 
                        amount FROM transactions WHERE purpose = 'donation'");
                        $donation = $donation->fetch();
                    ?>
                    <div class="widget-heading">Donations</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span># <?= number_format($donation['amount']); ?></span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content bg-grow-early">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <?php
                        $monthNow = date('F');
                        $yearNow = date('Y');

                        $tithes = $conn->query("SELECT sum(amount) AS 
                        amount FROM transactions WHERE purpose = 'tithe' && month = '$monthNow' && year = '$yearNow'");
                        $tithes = $tithes->fetch();
                    ?>
                    <div class="widget-heading">
                        Tithes 
                        <span class="badge badge-pill badge-light"># <?= number_format($tithes['amount']); ?></span>
                    </div>
                    <div class="widget-subheading">
                        <div class="widget-content-left">
                            <?php
                                $monthNow = date('F');
                                $yearNow = date('Y');

                                $offerings = $conn->query("SELECT sum(amount) AS 
                                amount FROM transactions WHERE purpose = 'offering' && month = '$monthNow' && year = '$yearNow'");
                                $offerings = $offerings->fetch();
                            ?>
                            <div class="widget-heading">
                                Offerings 
                                <span class="badge badge-pill badge-light"># <?= number_format($offerings['amount']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span># <?= number_format($tithes['amount'] + $offerings['amount']); ?></span></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="mb-3 card">
            <div class="card-header">
                <div class="card-title">
                    <form method="POST">
                        <div class="row">
                            <div class="col-6 mr-0 pr-0">
                                <select id="month" name="month" class="form-control-sm form-control">
                                    <option value="1">1<sup>st</sup> Half</option>
                                    <option value="2">2<sup>nd</sup> Half</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-9 pl-0 ml-0 pr-2">
                                        <select id="year" name="year" class="form-control-sm form-control">
                                            <?php
                                                for ($now= "2020"; $now <= date("Y"); $now++) { 
                                                    echo '<option value="'.$now.'">' . $now . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-3 pl-0">
                                        <button type="submit" 
                                            name="submitSearchBooksSalesReport" value="submitSearchBooksSalesReport" 
                                            class="btn btn-transition btn btn-sm btn-outline-success">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tabs-eg-77">
                        <div class="card mb-3 widget-chart widget-chart2 text-left w-100">
                            <div class="widget-chat-wrapper-outer">
                                <div id="booksSalesReport" class="p-3" style="width: 100%; height:50vh;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <?php
        $focus_sql = "SELECT * FROM focus WHERE id = 1";

        $stmt = $conn->query($focus_sql);
        $focus_result = $stmt->fetch();
    ?>
    <div class="col-md-12">
        <div class="alert alert-success fade show">
            <div class="row card-body">
                <div class="text-center col-12">
                    <h5 class="card-title text-center lead" id="focusForTheMonthTitle"><?= $focus_result['theme']; ?></h5>
                    <h6 id="anchorScript"><?= $focus_result['script']; ?></h6>
                </div>
                <div class="col-xs-12 px-2">
                    <p class="mb-0 text-justify" id="focusForTheMonthDetails">
                        <?= $focus_result['details']; ?>
                    </p>
                    <br />
                </div>
                <div class="col-12 px-5">
                    <button class="btn btn-outline-focus btn-block btn-small" id="editFocusForTheMonth">Edit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-6 col-xs-12">
        <div class="card mb-3 widget-content">
            <div class="widget-content-outer">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left">
                        <div class="widget-heading">Personal Pledge</div>
                        <div class="widget-subheading">
                            <?php

                                $monthNow = date('F');
                                $yearNow = date('Y');

                                $personalPledge = $conn->query("SELECT sum(amount) AS 
                                amount FROM transactions WHERE purpose = 'personalPledge' && month = '$monthNow' && year = '$yearNow'");
                                $personalPledge = $personalPledge->fetch();

                            ?>
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-warning"><?= '#' . number_format($personalPledge['amount']); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-6 col-xs-12">
        <div class="card mb-3 widget-content">
            <div class="widget-content-outer">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left">
                        <div class="widget-heading">Top Audio Download</div>
                        <div class="widget-subheading">
                            <?php

                                $audioDownloadCount = "SELECT item, COUNT(*) AS num FROM `downloads` WHERE item != 'books' GROUP BY item ORDER BY num DESC LIMIT 0,1 ";
                                $audioDownloadCount = $conn->query($audioDownloadCount);
                                $audioDownloadCount = $audioDownloadCount->fetch();
                                
                                echo $audioDownloadCount['item'];
                            ?>
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-warning"><?= number_format($audioDownloadCount['num']); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">
                Recent Testimonies
            </div>
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Subject</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                        $sql_testimonies = "
                                            SELECT testimonies.title, users.full_name, 
                                            users.address, users.phone  FROM testimonies, 
                                            users WHERE users.user_id = testimonies.user_id && status = 'pending' LIMIT 10
                                        ";
                        
                        $stmt = $conn->query($sql_testimonies);
                        
                        while($pendingTestimonies = $stmt->fetch())
                        {
                    ?>
                        <tr>
                            <td>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading text-center"><?= $pendingTestimonies['full_name']; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center"><?= $pendingTestimonies['phone']; ?></td>
                            <td class="text-center">
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading"><?= $pendingTestimonies['title']; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="d-block text-center card-footer">
                <a href="testimonies.php" class="btn btn btn-success block text-white">See All</a>
            </div>
        </div>
    </div>
</div>
<div class="alert alert-primary fade show" role="alert">
    <h5>Donations Target Informations</h5>
</div>
<div class="row">
    <?php foreach($donationsProgress as $donationsProgress) : ?>
        <div class="col-md-6 col-lg-3">
            <div class="card-shadow-danger mb-3 widget-chart widget-chart2 text-left card">
                <div class="widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left pr-2 fsize-1">
                                <div class="widget-numbers mt-0 fsize-3"><?php percent($donationsProgress['amount'], $donationsProgress['target']); ?>%</div>
                            </div>
                            <div class="widget-content-right w-100">
                                <div class="progress-bar-xs progress">
                                    <?php
                                        progressBar($donationsProgress['amount'], $donationsProgress['target']);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content-left fsize-1">
                            <div class="text-muted opacity-6"><?= $donationsProgress['title']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="modal fade bd-example-modal-lg mt-3" id="focusForTheMonth" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="false">
    <div class="modal-dialog modal-lg mt-5 mb-5">
        <div class="modal-content">
        <div class="modal-header text-info">
            <h5 class="modal-title">
                Focus For the Month
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="POST">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="position-relative form-group">
                            <label for="theme">
                                Theme
                            </label><input name="focusTheme" value="" id="focusTheme" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="position-relative form-group">
                            <label for="scripturalAnchor">
                                Scriptural Anchor
                            </label><input name="focusScripture" value="" id="scripturalAnchor" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="position-relative form-group">
                            <label for="focusDetails" class="">
                                Details
                            </label>
                            <textarea name="focusDetails" id="focusDetails" value="" type="text" class="form-control fr-view"></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" name="submitFocusForTheMonth" value="submit" class="mt-1 btn btn-primary btn-outline-focus mt-2 btn-block text-white">Save</button>
            </form>
        </div>
    </div>
</div>