
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
                        <li><a href="{{ route('overview') }}">About Us</a></li>
                        <li><a href="{{ route('careers') }}">Careers</a></li>
                        <!--<li><a href="{{ route('sustainability') }}">Sustainability</a></li>-->
                    </ul>
                </div>
                <div class="info_box">
                    <div class="title">Products</div>
                    <ul>
                        <li><a href="{{ route('electricals') }}">Electrical</a></li>
                         <li><a href="{{ route('automotive') }}">Automotive</a></li>
                    </ul>
                </div>
                <div class="info_box">
                    <div class="title">Markets</div>
                    <ul>
                        <!-- <li><a href="{{ route('markets').'#automotive' }}">Automotive</a></li> -->
                        <li><a href="{{ route('markets').'#construction' }}">Construction</a></li>
                        <li><a href="{{ route('markets').'#data-center' }}">Data Center</a></li>
                        <li><a href="{{ route('markets').'#lightning-protection' }}">Lightning Protection</a></li>
                        <li><a href="{{ route('markets').'#renewables' }}">Renewables</a></li>
                        <li><a href="{{ route('markets').'#utility' }}">Utility</a></li>
                    </ul>
                </div>
                <div class="info_box">
                    <div class="title">Location</div>
                    <ul class="ctc_links">
                        <li>
                            <div class="ctc_link_box">
                                <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                                <!-- <span class="txt">106 Northfield Avenue,<br> Edison, NJ 08837.</span> -->
                                <span class="txt">135 Fieldcrest Avenue <br> Edison, New Jersey 08837</span>
                            </div>
                        </li>
                        <li>
                            <a href="tel:+18008819236" class="ctc_link_box">
                                <span class="icon"><i class="fas fa-phone-alt"></i></span>
                                <span class="txt">+1 (800) 881 9236</span>
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
                    <form class="subscribe_box" id="subscribe_form" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="input_box">
                            <div class="error form_error form-error-email"></div>
                            <input type="text" name="email" placeholder="Email Address *">
                        </div>
                        <div class="submit_box">
                            <button class="red_filled_btn" type="submit">Subscribe</button>
                        </div>
                    </form>
                    <a href="https://www.codzera.com/" target="_blank" class="developed_by">
                        <div class="text">Developed by <b>Codzera</b> </div>
                        <div class="codzera_logo">
                            <img src="admin/assets/images/codzera-logo.png">
                        </div>
                    </a>
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



<script type="text/javascript">
$(document).ready(function() {    

    $('.eye').on('click', function(){
        $(this).toggleClass('show_password');
        const input = $(this).prev();
        input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
    });

    $("#subscribe_form").on('submit',(function(e){

        $this = $(this);

        e.preventDefault();
        $this.find(".form_error").html("");
        $this.find(".form_error").removeClass("alert alert-danger");

        var button = $(this).find('[type=submit]');
        button.attr('disabled', 'disabled');
        button.addClass('spinners');

        $.ajax({
            type: "POST",
            url: "{{ route('subscribeNewsletter') }}",
            data:  new FormData(this),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                // location.href="{{ route('electrical') }}";
                $this.html('<p>Subscribed Successfully</p>');
            },
            error: function(data){
                if (data.status === 422) {
                    let errors = data.responseJSON.errors;
                    let allErrors = '';
                    $.each(errors, function (key, val) {
                        var fieldName = key.replace(/\./g, '-');
                        // $('#form-error-' + key).html(message).addClass('alert alert-danger');
                        allErrors += val + '<br>';
                        $this.find(".form-error-"+fieldName).html(val).addClass('alert alert-danger');
                        $this.find(".form-error-"+fieldName).addClass('alert alert-danger');
                    });
                    $this.find(".all_errors").html(allErrors).addClass('alert alert-danger');
                } else if (data.status === 401) {
                    alert("Please log in.");
                    // window.location.href = "/login";
                } else if (data.status === 403) {
                    alert("You don’t have permission.");
                } else if (data.status === 404) {
                    alert("The resource was not found.");
                } else if (data.status === 419) {
                    alert("Error - "+419);
                    console.log(data.responseJSON.message);
                } else if (data.status === 500) {
                    alert("Something went wrong on the server.");
                    console.log(data.console_message);
                } else {
                    alert("Unexpected error: " + data.status);
                    console.log(data);
                }

                button.prop('disabled', false).removeClass('spinners');
            }
        });

    }));

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
