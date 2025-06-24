

</div>
<!-- main end -->



<!--sticky header-->
<!-- <script src="{{ asset('front/assets/js/classie.js') }}" type="text/javascript"></script>
<script>
function init() {
window.addEventListener('scroll', function(e){
  var distanceY = window.pageYOffset || document.documentElement.scrollTop,
  shrinkOn = 50,
  header = document.querySelector("header");
  if (distanceY > shrinkOn) {
  classie.add(header,"smaller");
  } else {
  if (classie.has(header,"smaller")) {
    classie.remove(header,"smaller");
  }
  }
});
}
window.onload = init();
</script> -->
<script type="text/javascript" src="{{ asset('front/assets/js/common.js') }}"></script>
<script src="{{ asset('front/assets/js/jquery.easing.1.3.js') }}"></script>


<script src="{{ asset('front/assets/js/ace-responsive-menu.js') }}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
    $("#respMenu").aceResponsiveMenu({
        resizeWidth: '768', // Set the same in Media query       
        animationSpeed: 'fast', //slow, medium, fast
        accoridonExpAll: false //Expands all the accordion menu on click
    });

     // Tab
    $('ul.tabs li').click(function(){
        var tab_id = $(this).attr('data-tab');

        $('ul.tabs li').removeClass('current');
        $('.tab-content').removeClass('current');

        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
    });

    $('ul.cs_tabs li').click(function(){
        var tab_id = $(this).attr('data-tab');
        console.log("inside second tab");
        $('ul.cs_tabs li').removeClass('active');
        $('.cs-tab-content').removeClass('active');

        $(this).addClass('active');
        $("#"+tab_id).addClass('active');
    });
});
</script>

<script type="text/javascript" src="{{ asset('front/assets/plugins/venobox/venobox.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
  /* default settings */
  $('.venobox').venobox({
    framewidth: '500px', 
  }); 
});
</script>




<script src="{{ asset('front/assets/js/wow.min.js') }}"></script>
<script>
new WOW().init();
</script>

<!--slider-->
<script src="{{ asset('front/assets/plugins/owl-carousel/owl.carousel.js') }}"></script>
<script src="{{ asset('front/assets/plugins/owl-carousel/owl-content-animation.js') }}"></script>

</body>
</html>
