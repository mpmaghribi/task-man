<div class="right-sidebar">
            <div class="right-stat-bar">
                <ul class="right-side-accordion">
<!--                    <li class="widget-collapsible">
                        <a href="#" class="head widget-head terques-bg active clearfix">
                            <span class="pull-left">contact online (5)</span>
                            <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
                        </a>
                        <ul class="widget-container">
                            <li>
                                <div class="prog-row">
                                    <div class="user-thumb">
                                        <a href="#"><img src="<?php echo base_url() ?>assets/images/avatar1_small.jpg" alt=""></a>
                                    </div>
                                    <div class="user-details">
                                        <h4><a href="#">Jonathan Smith</a></h4>
                                        <p>
                                            Work for fun
                                        </p>
                                    </div>
                                    <div class="user-status text-danger">
                                        <i class="fa fa-comments-o"></i>
                                    </div>
                                </div>
                                <div class="prog-row">
                                    <div class="user-thumb">
                                        <a href="#"><img src="<?php echo base_url() ?>assets/images/avatar1.jpg" alt=""></a>
                                    </div>
                                    <div class="user-details">
                                        <h4><a href="#">Anjelina Joe</a></h4>
                                        <p>
                                            Available
                                        </p>
                                    </div>
                                    <div class="user-status text-success">
                                        <i class="fa fa-comments-o"></i>
                                    </div>
                                </div>
                                <div class="prog-row">
                                    <div class="user-thumb">
                                        <a href="#"><img src="<?php echo base_url() ?>assets/images/chat-avatar2.jpg" alt=""></a>
                                    </div>
                                    <div class="user-details">
                                        <h4><a href="#">John Doe</a></h4>
                                        <p>
                                            Away from Desk
                                        </p>
                                    </div>
                                    <div class="user-status text-warning">
                                        <i class="fa fa-comments-o"></i>
                                    </div>
                                </div>
                                <div class="prog-row">
                                    <div class="user-thumb">
                                        <a href="#"><img src="<?php echo base_url() ?>assets/images/avatar1_small.jpg" alt=""></a>
                                    </div>
                                    <div class="user-details">
                                        <h4><a href="#">Mark Henry</a></h4>
                                        <p>
                                            working
                                        </p>
                                    </div>
                                    <div class="user-status text-info">
                                        <i class="fa fa-comments-o"></i>
                                    </div>
                                </div>
                                <div class="prog-row">
                                    <div class="user-thumb">
                                        <a href="#"><img src="<?php echo base_url() ?>assets/images/avatar1.jpg" alt=""></a>
                                    </div>
                                    <div class="user-details">
                                        <h4><a href="#">Shila Jones</a></h4>
                                        <p>
                                            Work for fun
                                        </p>
                                    </div>
                                    <div class="user-status text-danger">
                                        <i class="fa fa-comments-o"></i>
                                    </div>
                                </div>
                                <p class="text-center">
                                    <a href="#" class="view-btn">View all Contacts</a>
                                </p>
                            </li>
                        </ul>
                    </li>-->
                    <script>
                    (function($)
                    {
                        $(document).ready(function()
                        {
                            $.ajaxSetup(
                                    {
                                        cache: false,
                                        beforeSend: function() {
                                            $('#recent_activity').show();
                                        },
                                        complete: function() {
                                            $('#recent_activity').show();
                                        },
                                        success: function() {
                                            $('#recent_activity').show();
                                        }
                                    });
                            var $container = $("#recent_activity");
                            $container.load("<?php echo site_url(); ?>/home/recent_activity");
                            var refreshId = setInterval(function()
                            {
                                $container.load('<?php echo site_url(); ?>/home/recent_activity');
                            }, 1000);
                        });
                    })(jQuery);
                </script>
                    <li class="widget-collapsible">
                        <a href="#" class="head widget-head purple-bg active">
                            <span class="pull-left"> recent activity </span>
                            <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
                        </a>
                        <ul class="widget-container">
                            <li>
                                <div id="recent_activity">
                                    
                                </div>
                            </li>
                        </ul>
                    </li>
<!--                    <li class="widget-collapsible">
                        <a href="#" class="head widget-head yellow-bg active">
                            <span class="pull-left"> shipment status</span>
                            <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
                        </a>
                        <ul class="widget-container">
                            <li>
                                <div class="col-md-12">
                                    <div class="prog-row">
                                        <p>
                                            Full sleeve baby wear (SL: 17665)
                                        </p>
                                        <div class="progress progress-xs mtop10">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                <span class="sr-only">40% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="prog-row">
                                        <p>
                                            Full sleeve baby wear (SL: 17665)
                                        </p>
                                        <div class="progress progress-xs mtop10">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                                                <span class="sr-only">70% Completed</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>-->
                </ul>
            </div>
        </div>