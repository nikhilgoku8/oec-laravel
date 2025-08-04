
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

<!-- CART -->
<div class="cart_wrapper @if(Session::has('show_cart')) {{Session::get('show_cart')}} @endif">
    <div class="inner_box">
        <div class="cart_box">
            <div class="head_wrapper">
                <div class="title">Shopping Cart</div>
                <div class="close"></div>
            </div>
            <div id="cart_products">
                @if(!empty($cartProducts) && count($cartProducts) > 0)
                    <div class="products_wrapper">
                        @foreach($cartProducts as $row)
                            <div class="product_box">
                                <a href="{{ route('product', [
                                    'category' => $row->product->subCategory->category->slug,
                                    'subCategory' => $row->product->subCategory->slug,
                                    'product' => $row->product->slug
                                ]) }}">
                                    <div class="img_box">
                                        <img src="{{ $row->product->productImages[0]->image_file }}">
                                    </div>
                                    <div class="text_box">
                                        <div class="product_title">{{ $row->product->title }}</div>
                                        <div class="product_description">{{ Str::limit($row->product->description, 75) }}</div>
                                        <div class="product_count">
                                            <span class="number">{{ $row->quantity }}</span>
                                            <span class="times">x</span>
                                        </div>
                                    </div>
                                </a>
                                <button class="remove_product" data-cart-item-id="{{$row->id}}"></button>
                            </div>
                        @endforeach
                    </div>
                    <div class="c2a_btns">
                        <a href="{{ route('cart.index') }}" class="red_hollow_btn full_width">View Enquiry List</a>
                        <a href="{{ route('checkout') }}" class="red_filled_btn full_width">Request Quote</a>
                    </div>
                @else
                <div class="heading">Empty Cart</div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- CART END -->

<script>

$(".products_list_page .products_wrapper .inner_container .left_pane").on('click', function(event){
    if (!$(event.target).closest('.filters_wrapper').length) {
        closeProductsFilter();
    }
});
$(".show_filter_btn").on('click', function(event){
    openProductsFilter();
});
// $(document).on('click', '.cart_wrapper .close', function(event){
//     closeMobileMenu();
// });
function openProductsFilter() {
    $(".products_list_page .products_wrapper .inner_container .left_pane").fadeIn(100);
    setTimeout(function() {
        $(".products_list_page .products_wrapper .inner_container .left_pane .filters_wrapper").css({
            'transition': 'transform 0.4s ease',
            'transform': 'translateX(0%)'
        });
    }, 100);
    // $(".cart_wrapper .inner_box .cart_box").css("transform","translateX(0%)");
}
function closeProductsFilter() {
    // $(".cart_wrapper .inner_box .cart_box").animate({transform: 'translateX(100%)'},400,function() {
    //     $(".cart_wrapper").fadeOut();
    // });
    $(".products_list_page .products_wrapper .inner_container .left_pane .filters_wrapper").css({
        'transition': 'transform 0.4s ease',
        'transform': 'translateX(-100%)'
    });

    setTimeout(function() {
        $(".products_list_page .products_wrapper .inner_container .left_pane").fadeOut();
    }, 400);
    // $(".cart_wrapper .inner_box .cart_box").css("transform","translateX(100%)");
    // $(".cart_wrapper").fadeOut();
}
// ----------------------------------------------------------------------------------------------------
$(".lower_sec").on('click', function(event){
    if (!$(event.target).closest('.container').length) {
        closeMobileMenu();
    }
});
$(".mobile_menu_btn").on('click', function(event){
    openMobileMenu();
});
// $(document).on('click', '.cart_wrapper .close', function(event){
//     closeMobileMenu();
// });
function openMobileMenu() {
    $("header .lower_sec").fadeIn(100);
    setTimeout(function() {
        $("header .lower_sec .container").css({
            'transition': 'transform 0.4s ease',
            'transform': 'translateX(0%)'
        });
    }, 100);
    // $(".cart_wrapper .inner_box .cart_box").css("transform","translateX(0%)");
}
function closeMobileMenu() {
    // $(".cart_wrapper .inner_box .cart_box").animate({transform: 'translateX(100%)'},400,function() {
    //     $(".cart_wrapper").fadeOut();
    // });
    $("header .lower_sec .container").css({
        'transition': 'transform 0.4s ease',
        'transform': 'translateX(-100%)'
    });

    setTimeout(function() {
        $("header .lower_sec").fadeOut();
    }, 400);
    // $(".cart_wrapper .inner_box .cart_box").css("transform","translateX(100%)");
    // $(".cart_wrapper").fadeOut();
}
// ----------------------------------------------------------------------------------------------------------------------------------
$(document).on('click', function(event){
    if (!$(event.target).closest('.search_wrapper').length) {
        $('#search_results').slideUp();
    }
});

$('.clear_search').on('click', function(){
    $('#main_search').trigger('keyup');
    $(this).closest('form').find('input').val('');
    $('#search_results').slideUp();
});

$('#main_search').on('focus', function(){
    $('#search_results').slideDown();
});

let searchTimer;

// Trigger search after 3 letters
$('#main_search').on('keyup', function() {
    let query = $(this).val().trim();
    $('#search_results').slideDown();
    $('#search_results').html('<div class="center">Loading...</div>');

    if (query.length >= 3) {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            let url = '{{ route("shop") }}?q=' + encodeURIComponent(query);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#search_results').html(response.html);
                },
                error: function() {
                    $('#search_results').html('<div class="title red">Error loading results.</div>');
                }
            });
        }, 300); // debounce
    } else {
        $('#search_results').html('');
    }
});

$(document).on('click','.add_to_cart', function(){
    let addToCartBtn = $(this);
    let product_id = addToCartBtn.data('product-id');
    let quantity = addToCartBtn.parent().find('[type=number]').val();

    addToCartBtn.addClass('spinners').attr('disabled', true);
    quantity = quantity ? quantity : 1;
    // alert(quantity);

    let formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('product_id', product_id);
    formData.append('quantity', quantity);

    $.ajax({
        type: "POST",
        url: "{{ route('cart.add') }}",
        data:  formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(result) {
            // location.href="{{ route('login') }}";
            // window.location.reload();
            addToCartBtn.removeClass('spinners').attr('disabled', false);
            $('#cart_products').html(result.html);
            openCart();
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
                    // $this.find(".form-error-"+fieldName).addClass('alert alert-danger');
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
        }
    });
});
</script>

<script>
$(".cart_wrapper").on('click', function(event){
    if (!$(event.target).closest('.cart_box').length) {
        // $(".cart_wrapper").fadeOut();
        closeCart();
    }
});
$(".open_side_cart").on('click', function(event){
    // $(".cart_wrapper").css('display', 'flex').hide().fadeIn();
    openCart();
});
$(document).on('click', '.cart_wrapper .close', function(event){
    // $(".cart_wrapper").fadeOut();
    closeCart();
});
function openCart() {
    $(".cart_wrapper").fadeIn(100);
    setTimeout(function() {
        $(".cart_wrapper .inner_box .cart_box").css({
            'transition': 'transform 0.4s ease',
            'transform': 'translateX(0%)'
        });
    }, 100);
    // $(".cart_wrapper .inner_box .cart_box").css("transform","translateX(0%)");
}
function closeCart() {
    // $(".cart_wrapper .inner_box .cart_box").animate({transform: 'translateX(100%)'},400,function() {
    //     $(".cart_wrapper").fadeOut();
    // });
    $(".cart_wrapper .inner_box .cart_box").css({
        'transition': 'transform 0.4s ease',
        'transform': 'translateX(100%)'
    });

    setTimeout(function() {
        $(".cart_wrapper").fadeOut();
    }, 400);
    // $(".cart_wrapper .inner_box .cart_box").css("transform","translateX(100%)");
    // $(".cart_wrapper").fadeOut();
}
$(document).on('click','.remove_product', function(){
    let removeProduct = $(this);
    let cart_item_id = removeProduct.data('cart-item-id');
    // alert(quantity);

    $this = $(this).closest('form');

    let formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('cart_item_id', cart_item_id);

    $.ajax({
        type: "POST",
        url: "{{ route('cart.remove') }}",
        data:  formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(result) {
            window.location.reload();
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
                    // $this.find(".form-error-"+fieldName).addClass('alert alert-danger');
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
        }
    });
});
</script>

<!-- QUICK VIEW -->
<div class="quick_view_wrapper">
    <div class="inner_box">
        <div class="quick_view_box">
            <!-- <div class="left_pane">
                <div class="product_images_slider">
                    <div class="swiper-wrapper">

                        @for($i=1; $i<=10; $i++)
                        <div class="swiper-slide">
                            <div class="img_box">
                                <img src="@{{ $product->productImages[0]->image_file }}">
                            </div>
                        </div>
                        @endfor

                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <a href="#" class="red_filled_btn full_width square view_details">View Details</a>
            </div>
            <div class="right_pane">
                <div class="product_info">
                    <a class="heading left">@{{ $product->title }}</a>
                    <div class="description">@{!! $product->description !!}</div>
                    <div class="add_to_cart_inputs">
                        <div class="number_input">
                            <button onclick="this.parentNode.querySelector('input').stepDown()">-</button>
                            <input type="number" value="1" min="1">
                            <button onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                        </div>
                        <button class="red_filled_btn add_to_cart">Add to Enquiry</button>
                    </div>
                    <div class="other_btns">
                        <a href="#" class="red_hollow_btn">Catalog</a>
                        <a href="#" class="red_hollow_btn">Sales Drawing</a>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="close"></div>
    </div>
</div>
<!-- quick_view_wrapper end -->

<script>

let quickViewSwiper = null;

// Handle click on "Quick View" button
$('.quick_view').on('click', function () {
    const productId = $(this).data('product-id');

    // Show modal immediately with loading message
    $('.quick_view_box').html('<p class="center red" style="width:100%;padding:15px 0;">Loading...</p>');
    // $('#quickViewModal').modal('show');
    $('.quick_view_wrapper').css('display', 'flex').hide().fadeIn();

    // Get product quick view data
    $.ajax({
        url: "{{ route('quick-view-product', ':id' ) }}".replace(':id', productId),
        method: 'POST',
        data: {
            product_id: productId,
            _token: "{{ csrf_token() }}"
        },
        success: function (data) {
            const images = data.images; // ['img1.jpg', 'img2.jpg', ...]
            // console.log(images);
            preloadImages(images, function () {
                showQuickView(data, images);
            });
        },
        error: function () {
            $('.quick_view_box').html('<p class="center red" style="width:100%;padding:15px 0;">Failed to load product details.</p>');
        }
    });
});

// Preload images one by one, then run callback when done
function preloadImages(imageUrls, callback) {
    let loadedCount = 0;
    const total = imageUrls.length;

    if (total === 0) {
        callback();
        return;
    }

    imageUrls.forEach(url => {
        const img = new Image();
        img.onload = img.onerror = function () {
            loadedCount++;
            if (loadedCount === total) {
                callback();
            }
        };
        img.src = url;
    });
}

// Display the quick view with loaded images and product info
function showQuickView(data, images) {
    const slidesHtml = images.map(
        // (src) => `<div class="swiper-slide"><img src="${src}" class="img-fluid" /></div>`
        (src) => `<div class="swiper-slide">
                        <div class="img_box">
                            <img src="${src}">
                        </div>
                    </div>`
    ).join('');

    const modalHtml = `
        <div class="left_pane">
            <div class="product_images_slider">
                <div class="swiper-wrapper">
                    ${slidesHtml}
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <!-- product_images_slider end -->
            <a href="/electrical/${data.category}/${data.subCategory}/${data.product_slug}" class="red_filled_btn full_width square view_details">View Details</a>
        </div>
        <div class="right_pane">
            <div class="product_info">
                <a href="/electrical/${data.category}/${data.subCategory}/${data.product_slug}" class="heading left">${data.title}</a>
                <div class="description">${data.description}</div>
                <div class="add_to_cart_inputs">
                    <div class="number_input">
                        <button onclick="this.parentNode.querySelector('input').stepDown()">-</button>
                        <input type="number" value="1" min="1">
                        <button onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                    </div>
                    <button class="red_filled_btn add_to_cart" data-product-id="${data.id}">Add to Enquiry</button>
                </div>
                <div class="other_btns">
                    <a href="#" class="red_hollow_btn">Catalog</a>
                    <a href="#" class="red_hollow_btn">Sales Drawing</a>
                </div>
            </div>
        </div>
    `;

    $('.quick_view_box').html(modalHtml);

    // Initialize Swiper
    quickViewSwiper = new Swiper('.product_images_slider', {
        loop: true,
        slidesPerView: 1,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
          },
    });
}

$('.quick_view_wrapper').find('.close').on('click', function() {
    $('.quick_view_wrapper').fadeOut();
    // Clean up swiper when modal closes
    if (quickViewSwiper) {
        quickViewSwiper.destroy(true, true);
        quickViewSwiper = null;
    }
});

$(".quick_view_wrapper").on('click', function(event){
    if (!$(event.target).closest('.inner_box').length) {
        $(".quick_view_wrapper").fadeOut();
        // Clean up swiper when modal closes
        if (quickViewSwiper) {
            quickViewSwiper.destroy(true, true);
            quickViewSwiper = null;
        }
    }
});

</script>
<!-- QUICK VIEW END -->

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
const main_hero_slider = new Swiper('.main_hero_slider', {
    // parallax: true,
    // effect: 'slide',
    // speed: 1000,
    slidesPerView: 1,
    loop: true,
    // Responsive breakpoints
    // pagination: {
    //     el: '.swiper-pagination',
    //     type: 'bullets',
    //     clickable: true,
    //   },
    // breakpoints: {
    //     // // when window width is >= 480px
    //     480: {
    //       slidesPerView: 3,
    //       spaceBetween: 30
    //     },
    //     // when window width is >= 640px
    //     640: {
    //         slidesPerView: 6,
    //         // spaceBetween: 200,
    //     }
    // }
});
const our_brands_slider = new Swiper('.our_brands_slider', {
    // parallax: true,
    // effect: 'slide',
    // speed: 1000,
    slidesPerView: 2,
    loop: false,
    // Responsive breakpoints
    pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable: true,
      },
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
    pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable: true,
      },
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
        clickable: true,
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
        clickable: true,
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

@stack('js')

</body>
</html>
