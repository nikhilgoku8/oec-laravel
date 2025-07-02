@push('css')
<link href="{{ asset('front/assets/plugins/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
<!-- <style>
.swiper-slide{
    background: #ff0000;
    padding: 50px;
}
</style> -->
@endpush

@extends('front.layout.master')

@section('content')

<div class="products_page electricals_page">
	
<div class="main_slider_wrapper">
    <div class="swiper">
        <div class="swiper-wrapper">

            <div class="swiper-slide">
                <div class="info_box">
                    <div class="img_box">
                        <img src="{{ asset('front/assets/images/products/electricals/disconnects-and-boxes.webp') }}">
                    </div>
                    <div class="text-wrapper-container" data-swiper-parallax="100" data-swiper-parallax-opacity="0">
                        <div class="text_aligned">
                            <div class="text" data-direction="left-stroke">Disconnects</div>
                            <div class="text" data-direction="right-stroke">&amp; Boxes</div>
                        </div>
                    </div>
                    <div class="product_info" data-swiper-parallax-scale="0" data-swiper-parallax-opacity="0">
                        Discover our high-quality electrical boxes designed to meet diverse electrical installation needs. From disconnects to enclosures, we provide secure and reliable housing for various components. Our boxes are built to industry standards, ensuring safety and durability. Please contact us for more information, catalogs, and spec sheets. 
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="info_box">
                    <div class="img_box">
                        <img src="{{ asset('front/assets/images/products/electricals/lugs-mechanical-connectors.webp') }}">
                    </div>
                    <div class="text-wrapper-container" data-swiper-parallax="100" data-swiper-parallax-opacity="0">
                        <div class="text_aligned">
                            <div class="text" data-direction="left-stroke">Lugs &</div>
                            <div class="text" data-direction="right-stroke"> Mechanical</div>
                            <div class="text" data-direction="left-stroke">Connectors</div>
                        </div>
                    </div>
                    <div class="product_info" data-swiper-parallax-scale="0" data-swiper-parallax-opacity="0">
                        OEC is the world’s largest manufacturer Of UL-listed lugs and neutral bars. Please contact us to know more about our product offering, including catalogs, brochures, and spec sheets. 
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="info_box">
                    <div class="img_box">
                        <img src="{{ asset('front/assets/images/products/electricals/grounding.webp') }}">
                    </div>
                    <div class="text-wrapper-container" data-swiper-parallax="100" data-swiper-parallax-opacity="0">
                        <div class="text_aligned">
                            <div class="text" data-direction="left-stroke">Grounding</div>
                        </div>
                    </div>
                    <div class="product_info" data-swiper-parallax-scale="0" data-swiper-parallax-opacity="0">
                        OEC manufactures the complete range of UL-listed grounding connectors, ground rods, and bussbars. Please contact us for more information, including catalogs, brochures, and spec sheets.
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="info_box">
                    <div class="img_box">
                        <img src="{{ asset('front/assets/images/products/electricals/power-distribution-blocks.webp') }}">
                    </div>
                    <div class="text-wrapper-container" data-swiper-parallax="100" data-swiper-parallax-opacity="0">
                        <div class="text_aligned">
                            <div class="text" data-direction="left-stroke">Power</div>
                            <div class="text" data-direction="right-stroke">Distribution</div>
                            <div class="text" data-direction="left-stroke">Blocks</div>
                        </div>
                    </div>
                    <div class="product_info" data-swiper-parallax-scale="0" data-swiper-parallax-opacity="0">
                        OEC manufactures a wide range of UL-listed power distribution blocks along with other connectors for the medium voltage industry. Contact us for information on our medium voltage products.
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="info_box">
                    <div class="img_box">
                        <img src="{{ asset('front/assets/images/products/electricals/conduit-fittings.webp') }}">
                    </div>
                    <div class="text-wrapper-container" data-swiper-parallax="100" data-swiper-parallax-opacity="0">
                        <div class="text_aligned">
                            <div class="text" data-direction="left-stroke">Conduit</div>
                            <div class="text" data-direction="right-stroke">Fittings</div>
                        </div>
                    </div>
                    <div class="product_info" data-swiper-parallax-scale="0" data-swiper-parallax-opacity="0">
                        OEC manufactures a wide range of UL-listed aliuminum and zinc die-cast fittings, along with an extensive offering of EMT fittings. Contact us for more information on our fittings category, including catalogs, brochures, and spec sheets.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- main_slider_wrapper end -->

<div class="request_catalogue_wrapper">
    <div class="container">
        <div class="inner_container">
            
            <div class="hollow_heading wow fadeInLeft">Electrical</div>
            <div class="btn_warpper wow fadeInRight">
                <a href="#" class="hollow_btn">Request a Catalogue</a>
            </div>

        </div>
    </div>
</div>
<!-- request_catalogue_wrapper end -->

</div>
<!-- products_page end -->


<script src="{{ asset('front/assets/plugins/swiper/swiper-bundle.min.js') }}" type="text/javascript"></script>
<script>
const swiper = new Swiper('.swiper', {
    parallax: true,
    effect: 'slide',
    mousewheel: true,
    speed: 1000,
    slidesPerView: 1,
    spaceBetween: 20,
    centeredSlides: true,
    // centeredSlidesBounds: true,
    loop: true,
    // Responsive breakpoints
    breakpoints: {
        // // when window width is >= 320px
        // 320: {
        //   slidesPerView: 2,
        //   spaceBetween: 20
        // },
        // // when window width is >= 480px
        // 480: {
        //   slidesPerView: 3,
        //   spaceBetween: 30
        // },
        // when window width is >= 640px
        640: {
            slidesPerView: 1.6,
            spaceBetween: 200,
        }
    }

    // on: {
    //     sliderMove() {
    //         updateSplit();
    //     },
    //     setTranslate() {
    //         updateSplit();
    //     },
    // }
});

const activeSlide = document.querySelector('.swiper-slide-active');

let lastX = activeSlide.getBoundingClientRect().left;

function loop() {
  const rect = activeSlide.getBoundingClientRect();
  if (rect.left !== lastX) {
    updateSplit();
    lastX = rect.left;
  }
  requestAnimationFrame(loop);
}

loop();

function prepareSplitBoxes() {
  $('.swiper-slide').each(function() {
    const $box = $(this);

    $box.find('.text').each(function() {
      const $original = $(this);
      const direction = $original.data('direction');
      const textContent = $original.text();

      // Create a wrapper for stacking
      const $wrapper = $('<div class="text-wrapper"></div>');

      const $outline = $('<div class="text text-outline"></div>').text(textContent);
      $outline.attr('data-direction', direction);

      const $fill = $('<div class="text text-fill"></div>').text(textContent);
      $fill.attr('data-direction', direction);

      $wrapper.append($outline).append($fill);
      $original.replaceWith($wrapper);
    });
  });
}

function updateSplit() {
  $('.swiper-slide').each(function() {
    const $box = $(this);
    const textLeft = $box.find('.text-wrapper-container')[0].getBoundingClientRect().left;
    const imageLeft = $box.find('.img_box')[0].getBoundingClientRect().left;

    $box.find('.text-wrapper').each(function() {
      const $wrapper = $(this);
      const $outline = $wrapper.find('.text-outline');
      const $fill = $wrapper.find('.text-fill');
      const direction = $outline.data('direction');
      const difference = $wrapper.width() - imageLeft;
      // console.log(difference);

      if (direction === 'left-stroke') {
        $outline.css('clip-path', `inset(0 ${difference + textLeft}px 0 0)`);
        $fill.css('clip-path', `inset(0 0 0 ${imageLeft - textLeft}px)`);
      } else if (direction === 'right-stroke') {
        $fill.css('clip-path', `inset(0 ${difference + textLeft}px 0 0)`);
        $outline.css('clip-path', `inset(0 0 0 ${imageLeft - textLeft}px)`);
      }
    });
  });
}

$(window).on('load', function() {
  prepareSplitBoxes();
  updateSplit();
});

$(window).on('resize', updateSplit);
</script>

@endsection