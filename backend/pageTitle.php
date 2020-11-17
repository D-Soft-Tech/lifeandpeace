                                            <div class="app-page-title">
                                                <div class="page-title-wrapper">
                                                    <div class="page-title-heading">
                                                        <div class="page-title-icon">
                                                            <i class="pe-7s-shield icon-gradient bg-mean-fruit">
                                                            </i>
                                                        </div>
                                                        <div>Administrative Dashboard
                                                            <div class="page-title-subheading">Mount Zion Fortres
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="page-title-actions">
                                                        <div class="d-inline-block dropdown">
                                                            <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
                                                                <span class="btn-icon-wrapper pr-2 opacity-7">
                                                                    <i class="fa fa-business-time fa-w-20"></i>
                                                                </span>
                                                                Feedback
                                                            </button>
                                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                                                <ul class="nav flex-column" id="listing">
                                                                    <li class="nav-item">
                                                                        <a href="contact.php" class="nav-link">
                                                                            <i class="nav-link-icon lnr-inbox"></i>
                                                                            <span>
                                                                                Inbox
                                                                            </span>
                                                                            <div class="ml-auto badge badge-pill badge-secondary" id="contacts">
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a href="bulletin.php" class="nav-link">
                                                                            <i class="nav-link-icon lnr-book"></i>
                                                                            <span>
                                                                                Article Comments
                                                                            </span>
                                                                            <div class="ml-auto badge badge-pill badge-danger" id="articles">
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>    
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

                                                setTimeout("inbox('contacts', 'contacts')", 1000);
                                                setInterval("inbox('contacts', 'contacts')", 180000);
                                                setTimeout("inbox('articles', 'articles')", 1000);
                                                setInterval("inbox('articles', 'articles')", 180000);
                                            </script>