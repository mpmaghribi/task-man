<!--Core js-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-migrate-1.2.1.min.js"></script>
<!--Notification script-->
    <script src="<?php echo base_url()?>/assets/js/miniNotification.js"></script>
    <script>
      $(function() {
        $('#mini-notification').miniNotification();
      });
    </script>
    <!--End of notification script-->
<script src="<?php echo base_url()?>/assets/js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
<script src="<?php echo base_url()?>/assets/bs3/js/bootstrap.min.js"></script>
<script class="include" src="<?php echo base_url()?>/assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url()?>/assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.nicescroll.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="<?php echo base_url()?>/assets/js/skycons/skycons.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.scrollTo/jquery.scrollTo.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="<?php echo base_url()?>/assets/js/calendar/clndr.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>
<script src="<?php echo base_url()?>/assets/js/calendar/moment-2.2.1.js"></script>
<script src="<?php echo base_url()?>/assets/js/evnt.calendar.init.js"></script>
<script src="<?php echo base_url()?>/assets/js/jvector-map/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url()?>/assets/js/jvector-map/jquery-jvectormap-us-lcc-en.js"></script>
<script src="<?php echo base_url()?>/assets/js/gauge/gauge.js"></script>
<!--clock init-->
<script src="<?php echo base_url()?>/assets/js/css3clock/js/css3clock.js"></script>
<!--Easy Pie Chart-->
<script src="<?php echo base_url()?>/assets/js/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="<?php echo base_url()?>/assets/js/sparkline/jquery.sparkline.js"></script>
<!--Morris Chart-->
<script src="<?php echo base_url()?>/assets/js/morris-chart/morris.js"></script>
<script src="<?php echo base_url()?>/assets/js/morris-chart/raphael-min.js"></script>
<!--jQuery Flot Chart-->
<!--<script src="<?php echo base_url()?>/assets/js/flot-chart/jquery.flot.js"></script>-->
<!--<script src="<?php echo base_url()?>/assets/js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo base_url()?>/assets/js/flot-chart/jquery.flot.resize.js"></script>
<script src="<?php echo base_url()?>/assets/js/flot-chart/jquery.flot.pie.resize.js"></script>
<script src="<?php echo base_url()?>/assets/js/flot-chart/jquery.flot.animator.min.js"></script>
<script src="<?php echo base_url()?>/assets/js/flot-chart/jquery.flot.growraf.js"></script>-->
<script src="<?php echo base_url()?>/assets/js/dashboard.js"></script>
<script src="<?php echo base_url()?>/assets/js/jquery.customSelect.min.js" ></script>

<script src="<?php echo base_url()?>/assets/js/bootstrap-switch.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/js/fuelux/js/spinner.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/js/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/js/jquery-multi-select/js/jquery.quicksearch.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery-tags-input/jquery.tagsinput.js"></script>
<script src="<?php echo base_url()?>assets/js/select2/select2.js"></script>
<script src="<?php echo base_url()?>assets/js/select-init.js"></script>

<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.min.js"></script>
<!--common script init for all pages-->
<script src="<?php echo base_url()?>assets/js/scripts.js"></script>

<script src="<?php echo base_url()?>assets/js/toggle-init.js"></script>

<script src="<?php echo base_url()?>assets/js/advanced-form.js"></script>

<script src="<?php echo base_url()?>assets/js/validation-init.js"></script>
<!--script for this page-->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&AMP;sensor=false"></script>
<script>

    //google map
    function initialize() {
        var myLatlng = new google.maps.LatLng(-37.815207, 144.963937);
        var mapOptions = {
            zoom: 15,
            scrollwheel: false,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: 'Hello World!'
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);

$('.contact-map').click(function(){

    //google map in tab click initialize
    function initialize() {
        var myLatlng = new google.maps.LatLng(-37.815207, 144.963937);
        var mapOptions = {
            zoom: 15,
            scrollwheel: false,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: 'Hello World!'
        });
    }
    google.maps.event.addDomListener(window, 'click', initialize);
});

</script>
</body>
</html>
