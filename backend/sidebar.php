<div class="scrollbar-sidebar">
    <div class="app-sidebar__inner">
        <ul class="vertical-nav-menu">
            <li class="app-sidebar__heading">Dashboards</li>
            <li>
                <a href="home.php">
                    <i class="metismenu-icon pe-7s-rocket"></i>
                        Home
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="metismenu-icon pe-7s-mail"></i>
                        Feedback
                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                </a>
                <ul>
                    <li>
                        <a href="contact.php">
                            <i class="metismenu-icon"></i>
                            Inbox
                            <div class="ml-auto badge badge-pill badge-info" id="contact">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="testimonies.php">
                            <i class="metismenu-icon">
                            </i>
                            Testimonies
                            <div class="ml-auto badge badge-pill badge-info" id="testimonies">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="bulletin.php">
                            <i class="metismenu-icon">
                            </i>
                            Comments on Articles
                            <div class="ml-auto badge badge-pill badge-info" id="article">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="quote.php">
                            <i class="metismenu-icon">
                            </i>
                            Quotes
                            <div class="ml-auto badge badge-pill badge-info">
                                <span id="quote"></span>
                                Likes
                            </div> 
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="event.php">
                    <i class="metismenu-icon pe-7s-date"></i>
                    Special Events
                </a>
            </li>
            <li>
                <a href="weeklyProgram.php">
                    <i class="metismenu-icon pe-7s-date"></i>
                    Weekly Programs
                </a>
            </li>
            <li>
                <a href="team.php">
                    <i class="metismenu-icon pe-7s-users"></i>
                    Team
                </a>
            </li>
            <li>
                <a href="users.php">
                    <i class="metismenu-icon pe-7s-users"></i>
                    Users
                </a>
            </li>
            <li class="app-sidebar__heading">Resources</li>
            <li>
                <a href="books.php">
                    <i class="metismenu-icon pe-7s-notebook"></i>
                    Books
                </a>
            </li>
            <li>
                <a href="article.php">
                    <i class="metismenu-icon pe-7s-news-paper"></i>
                    Bulletin
                </a>
            </li>
            <li class="app-sidebar__heading">Gallery</li>
            <li>
                <a href="image.php">
                    <i class="metismenu-icon pe-7s-photo-gallery"></i>
                    Images
                </a>
            </li>
            <li>
                <a href="image.php">
                    <i class="metismenu-icon pe-7s-play"></i>
                    Media
                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                </a>
                <ul>
                    <li>
                        <a href="audio.php">
                            <i class="metismenu-icon"></i>
                            Audio
                        </a>
                    </li>
                    <li>
                        <a href="video.php">
                            <i class="metismenu-icon">
                            </i>
                            Video
                        </a>
                    </li>
                </ul>
            </li>
            <li class="app-sidebar__heading">Donation</li>
            <li>
                <a href="donation.php">
                    <i class="metismenu-icon pe-7s-gift">
                    </i>
                    Donation
                </a>
            </li>
            <li class="app-sidebar__heading">Account</li>
            <li>
                <a href="account.php">
                    <i class="metismenu-icon pe-7s-credit">
                    </i>
                    Account
                </a>
            </li>
            <li>
                <a href="transactions.php">
                    <i class="metismenu-icon pe-7s-graph1">
                    </i>
                    Transactions
                </a>
            </li>
        </ul>
    </div>
</div>


<script>
    function inbox(item, id){
        XmlHttp
        (
            {
                url: 'customBackendScript.php',
                type: 'POST',
                data: "item="+item,
                complete:function(xhr,response,status)
                {
                    document.getElementById(id).innerHTML = response;
                }
            }
        );
    }
    setTimeout("inbox('contacts', 'contact')", 1000);
    setInterval("inbox('contacts', 'contact')", 180000);
    setTimeout("inbox('articles', 'article')", 1000);
    setInterval("inbox('articles', 'article')", 180000);
    setTimeout("inbox('quote', 'quote')", 1000);
    setInterval("inbox('quote', 'quote')", 180000);
    setTimeout("inbox('testimonies', 'testimonies')", 1000);
    setInterval("inbox('testimonies', 'testimonies')", 180000);
</script>