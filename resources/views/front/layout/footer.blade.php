
<footer>
    <div class="upper_sec">
        <div class="container">
            <div class="inner_container">

                <div class="info_box">
                    <div class="logo_box">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('front/assets/images/bg/parallax-logo.webp') }}" alt="" />
                        </a>
                    </div>
                </div>
                <div class="info_box">
                    <div class="title">Company</div>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Sustainability</a></li>
                    </ul>
                </div>
                <div class="info_box">
                    <div class="title">Products</div>
                    <ul>
                        <li><a href="#">Electrical</a></li>
                        <li><a href="#">Automotive</a></li>
                    </ul>
                </div>
                <div class="info_box">
                    <div class="title">Markets</div>
                    <ul>
                        <li><a href="#">Automotive</a></li>
                        <li><a href="#">Construction</a></li>
                        <li><a href="#">Data Center</a></li>
                        <li><a href="#">Lightning Protection</a></li>
                        <li><a href="#">Renewables</a></li>
                        <li><a href="#">Utility</a></li>
                    </ul>
                </div>
                <div class="info_box">
                    <div class="title">Location</div>
                    <ul class="ctc_links">
                        <li>
                            <a href="#" class="ctc_link_box">
                                <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                                <span class="txt">106 Northfield Avenue,<br> Edison, NJ 08837.</span>
                            </a>
                        </li>
                        <li>
                            <a href="tel:+1(732)4790469" class="ctc_link_box">
                                <span class="icon"><i class="fas fa-phone-alt"></i></span>
                                <span class="txt">+1 (732) 479 0469</span>
                            </a>
                        </li>
                        <li>
                            <a href="mailto:info@oec-americas.com" class="ctc_link_box">
                                <span class="icon"><i class="fas fa-envelope"></i></span>
                                <span class="txt">info@oec-americas.com</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="info_box">
                    <div class="title">Subscribe Our Newsletter</div>
                    <div class="subscribe_box">
                        <div class="input_box">
                            <input type="text" subscribe="Email Address *" placeholder="Email Address *">
                        </div>
                        <div class="submit_box">
                            <button class="red_filled_btn">Subscribe</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="lower_sec">
        <p>&copy; {{ date('Y') }} OEC USA INC. All Rights Reserved.</p>
    </div>
</footer>

</div>
<!-- main end -->

<!--sticky header-->
<script src="{{ asset('front/assets/js/classie.js') }}" type="text/javascript"></script>
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
</script>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

<!-- <script>
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".counter").forEach(counter => {
    const target = +counter.getAttribute("data-target");

    const obj = { val: 0 };

    gsap.to(obj, {
      val: target,
      duration: 2,
      ease: "power1.out",
      onUpdate: function () {
        counter.textContent = formatNumber(obj.val);
      }
    });
  });

  function formatNumber(num) {
    return Math.floor(num).toLocaleString('en-US');
  }
});
</script> -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const counters = document.querySelectorAll(".counter");

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        observer.unobserve(entry.target); // Animate only once
      }
    });
  }, { threshold: 0.5 }); // Adjust threshold as needed

  counters.forEach(counter => {
    observer.observe(counter);
  });

  function animateCounter(counter) {
    const target = +counter.getAttribute("data-target");
    const obj = { val: 0 };

    gsap.to(obj, {
      val: target,
      duration: 2,
      ease: "power1.out",
      onUpdate: function () {
        counter.textContent = formatNumber(obj.val);
      }
    });
  }

  function formatNumber(num) {
    return Math.floor(num).toLocaleString('en-US');
  }
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script>
    
gsap.registerPlugin(ScrollTrigger);
// gsap.utils.toArray(".heading").forEach(box => {
//   gsap.to(box, {
//     y: -100,
//     scrollTrigger: {
//       trigger: box,
//       start: "top bottom",
//       end: "bottom top",
//       scrub: true,
//       markers: true
//     }
//   });
// });
gsap.utils.toArray(".heading").forEach((heading) => {
  gsap.fromTo(
    heading,
    {
      y: 100
    },
    {
      y: -100,
      ease: "none",
      scrollTrigger: {
        trigger: heading,
        start: "top bottom",     // when heading top hits bottom of viewport
        end: "center top",    // when heading center hits viewport center
        scrub: true,
        smooth: 1
      }
    }
  );
});

</script>

</body>
</html>
