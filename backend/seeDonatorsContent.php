<div class="row">
    <div class="col-xs-12 col-md-8">
        <div class="row alert alert-success fade show" role="alert">
            <div class="col-12">
                <h5>Donators to <span class="font-weight-bold"><?= $donation_name['title']; ?></span></h5>
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
                <a href="seeDonators.php?pages=<?= $Previous; ?>&page=<?= $page; ?>&id=<?= $id; ?>" 
                    class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Previous">
                    <span aria-hidden="true">&laquo; </span>
                </a>
            </li>
            <?php 
                $i = $pages > 5 ? $pages - 4 : 1;
                for($i; $i<= $pages; $i++)
                {
                ?>
                <li><a href="seeDonators.php?page=<?= $i; ?>&pages=<?= $pages; ?>&id=<?= $id; ?>" class="btn btn-transition btn btn-sm btn-outline-primary"><?= $i; ?></a></li>
                <?php 
                }
                ?>
            <li>
                <a href="seeDonators.php?pages=<?= $Next; ?>&page=<?= $page; ?>&id=<?= $id; ?>"
                class="btn btn-transition btn btn-sm btn-outline-primary" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<div class="row">
    <div class="col-md-10">
        <div class="main-card mb-3 card">
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($donators as $donators) :  ?>
                            <tr>
                                <td>
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left flex2">
                                                <div class="widget-heading text-center"><?= $donators['full_name']; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center"><?= $donators['address']; ?></td>
                                <td>
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left flex2">
                                                <div class="widget-heading text-center"><?= $donators['amount']; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center"><?= $donators['day']. $donators['month']. ', ' . $donators['year']; ?></td>
                                <td>
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left flex2">
                                                <div class="widget-heading text-center"><?= $donators['transc_time']; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-block  card-footer">
            </div>
        </div>
    </div>
    <div class="col-2"></div>
</div>

