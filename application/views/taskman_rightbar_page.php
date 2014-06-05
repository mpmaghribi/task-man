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
                        $container.load("<?php echo site_url(); ?>/home/recent_activity");
                        var refreshId = setInterval(function()
                        {
                            $container.load('<?php echo site_url(); ?>/home/recent_activity');
                        }, 100000);
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
        </ul>
    </div>
</div>