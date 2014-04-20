<!--header start-->
<header class="header fixed-top clearfix">
    <!--logo start-->
    <div class="brand">

        <a href="<?php echo site_url() ?>" class="logo">
    <!--        <img src="<?php echo base_url() ?>/assets/images/logo.png" alt="">-->
            Task<br>Management
        </a>
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
    <!--logo end-->

    <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
            <!-- settings start -->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="fa fa-tasks"></i>
                    <span class="badge bg-success" id="jumlah_pending_task">8</span>
                </a>
                <ul class="dropdown-menu extended tasks-bar" id="bagian_pending_task">
                    <li>
                        <p class="" id="keterangan_jumlah_pending_task">keterangan_jumlah_pending_task</p>
                    </li>
                    <li>
                        <a href="#">
                            <div class="task-info clearfix">
                                <div class="desc pull-left">
                                    <h5>Task 1</h5>
                                    <p>25% , Deadline  12 June’14</p>
                                </div>
                                <span class="notification-pie-chart pull-right" data-percent="25">
                                    <span class="percent"></span>
                                </span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="task-info clearfix">
                                <div class="desc pull-left">
                                    <h5>Task 2</h5>
                                    <p>45% , Deadline  12 June’14</p>
                                </div>
                                <span class="notification-pie-chart pull-right" data-percent="45">
                                    <span class="percent"></span>
                                </span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="task-info clearfix">
                                <div class="desc pull-left">
                                    <h5>Task 3</h5>
                                    <p>87% , Deadline  12 June’14</p>
                                </div>
                                <span class="notification-pie-chart pull-right" data-percent="87">
                                    <span class="percent"></span>
                                </span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="task-info clearfix">
                                <div class="desc pull-left">
                                    <h5>Task 4</h5>
                                    <p>33% , Deadline 12 June’15</p>
                                </div>
                                <span class="notification-pie-chart pull-right" data-percent="33">
                                    <span class="percent"></span>
                                </span>
                            </div>
                        </a>
                    </li>

                    <li class="external">
                        <a href="#">See All Tasks</a>
                    </li>
                </ul>
            </li>
            <!-- settings end -->
            <!-- inbox dropdown start-->
            <!--        <li id="header_inbox_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-envelope-o"></i>
                            <span class="badge bg-important">4</span>
                        </a>
                        <ul class="dropdown-menu extended inbox">
                            <li>
                                <p class="red">You have 4 Mails</p>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="photo"><img alt="avatar" src="<?php echo base_url() ?>/assets/images/avatar-mini.jpg"></span>
                                            <span class="subject">
                                            <span class="from">Jonathan Smith</span>
                                            <span class="time">Just now</span>
                                            </span>
                                            <span class="message">
                                                Hello, this is an example msg.
                                            </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="photo"><img alt="avatar" src="<?php echo base_url() ?>/assets/images/avatar-mini-2.jpg"></span>
                                            <span class="subject">
                                            <span class="from">Jane Doe</span>
                                            <span class="time">2 min ago</span>
                                            </span>
                                            <span class="message">
                                                Nice admin template
                                            </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="photo"><img alt="avatar" src="<?php echo base_url() ?>/assets/images/avatar-mini-3.jpg"></span>
                                            <span class="subject">
                                            <span class="from">Tasi sam</span>
                                            <span class="time">2 days ago</span>
                                            </span>
                                            <span class="message">
                                                This is an example msg.
                                            </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="photo"><img alt="avatar" src="<?php echo base_url() ?>/assets/images/avatar-mini.jpg"></span>
                                            <span class="subject">
                                            <span class="from">Mr. Perfect</span>
                                            <span class="time">2 hour ago</span>
                                            </span>
                                            <span class="message">
                                                Hi there, its a test
                                            </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">See all messages</a>
                            </li>
                        </ul>
                    </li>-->
            <!-- inbox dropdown end -->
            <!-- notification dropdown start-->
            <li id="header_notification_bar" class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                    <i class="fa fa-bell-o"></i>
                    <span class="badge bg-warning">3</span>
                </a>
                <ul class="dropdown-menu extended notification">
                    <li>
                        <p>Notifications</p>
                    </li>
                    <li>
                        <div class="alert alert-info clearfix">
                            <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                            <div class="noti-info">
                                <a href="#"> March 2014. You have tasks which is not completed.</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="alert alert-danger clearfix">
                            <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                            <div class="noti-info">
                                <a href="#"> Februari 2014. You have tasks which is not completed.</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="alert alert-success clearfix">
                            <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                            <div class="noti-info">
                                <a href="#"> January 2014. You have tasks which is not completed.</a>
                            </div>
                        </div>
                    </li>

                </ul>
            </li>
            <!-- notification dropdown end -->
        </ul>
        <!--  notification end -->
    </div>
    <div class="top-nav clearfix">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <li>
                <input type="text" class="form-control search" placeholder=" Search">
            </li>
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="<?php echo base_url() ?>/assets/images/avatar1_small.jpg">
                    <span class="username"><?php echo $this->session->userdata('user_nama') ?></span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="<?php echo site_url() ?>/profil"><i class=" fa fa-suitcase"></i>Profile</a></li>
                    <li><a href="<?php echo site_url() ?>/profil/setting"><i class="fa fa-cog"></i> Settings</a></li>
                    <li><a href="<?php echo site_url() ?>/login/logout"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->
            <li>
                <!--            <div class="toggle-right-box">
                                <div class="fa fa-bars"></div>
                            </div>-->
            </li>
        </ul>
        <!--search & user info end-->
    </div>
</header>
<!--header end-->
<script>
    function req_notifikasi() {

    }
    function req_pending_task() {
        $.ajax({// create an AJAX call...
            data: "", // get the form data
            type: "GET", // GET or POST
            url: "<?php echo site_url(); ?>/pekerjaan/req_pending_task", // the file to call
            success: function(response) { // on success..
                var json = jQuery.parseJSON(response);
                //alert(response);
                if (json.status === "OK") {
                    //alert("ok1");
                    var html = "";
                    var jumlah_data = json.status.length;
                    //id="bagian_pending_task">
                    html = "<li><p class=\"\">Anda memiliki " + jumlah_data + " pending task</p></li>";
                    for (var i = 0; i < jumlah_data; i++) {
                        html += "<li>" +
                                "<a href = \"#\" >" +
                                "<div class = \"task-info clearfix\" >" +
                                "<div class = \"desc pull-left\" >" +
                                "<h5>"+json.data[i]["nama_pekerjaan"]+"</h5>" +
                                "<p >"+ json.data[i]["progress"] +"% , "+ json.data[i]["tgl_selesai"] +" </p>" +
                                "</div>" +
                                "<span class = \"notification-pie-chart pull-right\" data-percent = \""+ json.data[i]["progress"] +"\" >" +
                                "<span class = \"percent\" > </span>" +
                                "</span>" +
                                "</div>" +
                                "</a>" +
                                "</li>";
                    }
                    $("#bagian_pending_task").html(html);
                    $("#jumlah_pending_task").html(jumlah_data);
                    alert("ok");
                } else {
                    alert("failed, " + json.reason);
                }
            }
        });
    }
    req_pending_task();
</script>