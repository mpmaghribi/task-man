<?php
$temp = $this->session->userdata('logged_in');
$bawahan = json_decode(
        file_get_contents(
                str_replace('taskmanagement', 'integrarsud', str_replace('://', '://hello:world@', base_url())) . "index.php/api/integration/bawahan/id/" . $temp['user_id'] . "/format/json"
        ));
?>
<div class="right-sidebar">
    <div class="right-stat-bar">
        <ul class="right-side-accordion">
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
                        $container.load("<?php echo site_url(); ?>/home/recent_activity_staff");
                        var refreshId = setInterval(function()
                        {
                            $container.load('<?php echo site_url(); ?>/home/recent_activity_staff');
                        }, 100000);
                    });
                })(jQuery);
            </script>
            <script>
                (function($)
                {
                    $(document).ready(function()
                    {
                        $.ajaxSetup(
                                {
                                    cache: false,
                                    beforeSend: function() {
                                        $('#recent_activity2').show();
                                    },
                                    complete: function() {
                                        $('#recent_activity2').show();
                                    },
                                    success: function() {
                                        $('#recent_activity2').show();
                                    }
                                });
                        var $container = $("#recent_activity2");
                        $container.load("<?php echo site_url(); ?>/home/recent_activity");
                        var refreshId = setInterval(function()
                        {
                            $container.load('<?php echo site_url(); ?>/home/recent_activity');
                        }, 100000);
                    });
                })(jQuery);
            </script>
<?php if (isset($bawahan) && $bawahan != NULL) { ?>
                <li class="widget-collapsible">
                    <a href="#" class="head widget-head purple-bg active">
                        <span class="pull-left"> recent activity staff</span>
                        <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
                    </a>
                    <ul class="widget-container">
                        <li>
                            <div id="recent_activity">
                            </div>
                        </li>
                    </ul>
                </li>
<?php } ?>
            <li class="widget-collapsible">
                <a href="#" class="head widget-head purple-bg active">
                    <span class="pull-left"> my recent activity</span>
                    <span class="pull-right widget-collapse"><i class="ico-minus"></i></span>
                </a>
                <ul class="widget-container">
                    <li>
                        <div id="recent_activity2">
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>