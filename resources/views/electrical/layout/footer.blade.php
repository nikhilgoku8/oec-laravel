
<footer>
    <div class="upper_sec">
        <div class="container">
            <div class="inner_container">

                <div class="icon_box">
                    <div class="icon"><img src="{{ asset('electrical-assets/images/icons/retail-247.svg') }}" width="50px" height="50px"></div>
                    <div class="text">Customer Convince</div>
                </div>
                <div class="icon_box">
                    <div class="icon"><img src="{{ asset('electrical-assets/images/icons/retail-payment.svg') }}" width="50px" height="50px"></div>
                    <div class="text">Quality Assurance</div>
                </div>
                <div class="icon_box">
                    <div class="icon"><img src="{{ asset('electrical-assets/images/icons/retail-delivery-man.svg') }}" width="50px" height="50px"></div>
                    <div class="text">Industry Experts</div>
                </div>

            </div>
        </div>
    </div>
    <div class="middle_sec">
        <div class="container">
            <div class="inner_container">
                <div class="logo">
                    <a href="{{ route('electrical') }}">
                        <img src="{{ asset('electrical-assets/images/logo.webp') }}">
                    </a>
                </div>
                <div class="text_box">
                    <p>OEC was established in 1974 and is a family-owned, global leader in the manufacturing of electrical connectors, fittings, cable glands, automotive fittings, air brake tubing, and hoses. Over the last 50 years, OEC has consistently expanded its product portfolio to cater to the diverse needs of the electrical and automotive industries across the globe. </p>
                </div>
            </div>
        </div>
    </div>
    <div class="lower_sec">
        <p>&copy; {{ date('Y') }}  OEC AMERICA . All Rights Reserved.</p>
    </div>
</footer>

</div>
<!-- main end -->


<script>
$(document).ready(function() {
    $('.my_account_links')
    .on('mouseenter', function() {
        $(this)
            .find('ul')
            .stop(true, true) // This is to clear animation queue
            .slideDown();
    })
    .on('mouseleave', function() {
        $(this)
            .find('ul')
            .stop(true, true)
            .slideUp();
    });
});
</script>

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
    $("#category_menu").aceResponsiveMenu({
        resizeWidth: '768', // Set the same in Media query       
        animationSpeed: 'fast', //slow, medium, fast
        accoridonExpAll: false //Expands all the accordion menu on click
    });
    $("#main_menu").aceResponsiveMenu({
        resizeWidth: '768', // Set the same in Media query       
        animationSpeed: 'fast', //slow, medium, fast
        accoridonExpAll: false //Expands all the accordion menu on click
    });
});
</script>

<script type="text/javascript" src="{{ asset('front/assets/plugins/venobox/venobox.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
  /* default settings */
  // $('.venobox').venobox({
  //   framewidth: '500px', 
  // }); 

    new VenoBox({
        selector: '.image_veno',
        // numeration: true,
        // infinigall: true,
        // share: true,
        // spinner: 'rotating-plane'
    });
});
</script>




<script src="{{ asset('front/assets/js/wow.min.js') }}"></script>
<script>
new WOW().init();
</script>

<!--slider-->
<!-- <script src="{{ asset('front/assets/plugins/owl-carousel/owl.carousel.js') }}"></script>
<script src="{{ asset('front/assets/plugins/owl-carousel/owl-content-animation.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

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
</script> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
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

</script> -->

<script src="{{ asset('front/assets/plugins/swiper/swiper-bundle.min.js') }}" type="text/javascript"></script>
<script>
const our_brands_slider = new Swiper('.our_brands_slider', {
    // parallax: true,
    // effect: 'slide',
    // speed: 1000,
    slidesPerView: 2,
    loop: false,
    // Responsive breakpoints
    breakpoints: {
        // // when window width is >= 480px
        480: {
          slidesPerView: 3,
          spaceBetween: 30
        },
        // when window width is >= 640px
        640: {
            slidesPerView: 6,
            // spaceBetween: 200,
        }
    }
});

const featured_categories_slider = new Swiper('.featured_categories_slider', {
    // parallax: true,
    // effect: 'slide',
    // speed: 1000,
    slidesPerView: 2,
    loop: false,
    // Responsive breakpoints
    breakpoints: {
        // // when window width is >= 480px
        480: {
          slidesPerView: 3,
          spaceBetween: 30
        },
        // when window width is >= 640px
        640: {
            slidesPerView: 5,
            // spaceBetween: 200,
        }
    }
});

const industries_slider = new Swiper('.industries_slider', {
    // parallax: true,
    // effect: 'slide',
    // speed: 1000,
    slidesPerView: 2,
    loop: false,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
      },
    // Responsive breakpoints
    breakpoints: {
        // // when window width is >= 480px
        480: {
          slidesPerView: 3,
          // spaceBetween: 30
        },
        // when window width is >= 640px
        640: {
            slidesPerView: 4,
            // spaceBetween: 200,
        }
    }
});

const related_products_slider = new Swiper('.related_products_slider', {
    // parallax: true,
    // effect: 'slide',
    // speed: 1000,
    slidesPerView: 2,
    loop: false,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
      },
    // Responsive breakpoints
    breakpoints: {
        // // when window width is >= 480px
        480: {
          slidesPerView: 3,
          spaceBetween: 20,
        },
        // when window width is >= 640px
        640: {
            slidesPerView: 4,
            spaceBetween: 20,
        }
    }
});
</script>

</body>
</html>
