@extends('electrical.layout.master')

@section('content')

<div class="hero">
    <!-- <div class="video_wrapper">
        <video autoplay muted loop poster="https://placehold.co/1920x600/?text=Slider">
            <source src="" type="video/mp4">
        </video>
    </div> -->
    <div class="main_hero_slider">
        <div class="swiper-wrapper">

            @if(!empty($banners) && count($banners) > 0)
                @foreach($banners as $banner)
                    <div class="swiper-slide">
                        <a href="{{ $banner->link ?? '#' }}">
                            <div class="img_box">
                                <img src="{{ asset('uploads/banners/'.$banner->image_file) }}">
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif

            <!-- @foreach($categories as $category)
            <div class="swiper-slide">
                <a href="{{ route('category.products', $category->slug) }}">
                    <span class="category_title">{{$category->title}}</span>
                    <span class="image_wrapper">
                        @foreach($category->subCategories as $subCategory)
                            @if($subCategory->products->first()?->productImages?->first()?->image_file)
                            <span class="img_box">
                                <img src="{{ $subCategory->products->first()?->productImages->first()->image_file ?? asset('electrical-assets/images/coming-soon.webp') }}">
                            </span>
                            @endif
                            @if($loop->iteration == 4) @break @endif
                        @endforeach
                    </span>
                </a>
            </div>
            @endforeach -->
            <!-- <div class="swiper-slide">
                <div class="item_box">
                    <a href="{{ route('category.products', 'insulated') }}">
                        <img src="{{ asset('electrical-assets/images/our-brands/orion.png') }}">
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="item_box">
                    <a href="{{ route('category.products', 'grounding') }}">
                        <img src="{{ asset('electrical-assets/images/our-brands/terrafix.png') }}">
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="item_box">
                    <a href="{{ route('category.products', 'conduit-bodies') }}">
                        <img src="{{ asset('electrical-assets/images/our-brands/series-e.png') }}">
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="item_box">
                    <a href="{{ route('category.products', 'weatherproof-products') }}">
                        <img src="{{ asset('electrical-assets/images/our-brands/dry-shield.png') }}">
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="item_box">
                    <a href="{{ route('category.products', 'fittings') }}">
                        <img src="{{ asset('electrical-assets/images/our-brands/unisteel.png') }}">
                    </a>
                </div>
            </div> -->

        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- <div class="swiper-pagination"></div> -->
    </div>

</div>

<div class="our_brands">
    <!-- <div class="container"> -->
        <div class="inner_container">
            
            <div class="heading back_stroke">
                <span>Our Brands</span>
            </div>

            <div class="our_brands_slider">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'compression') }}">
                                <img src="{{ asset('electrical-assets/images/our-brands/duracrimp.png') }}">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'insulated') }}">
                                <img src="{{ asset('electrical-assets/images/our-brands/orion.png') }}">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'grounding') }}">
                                <img src="{{ asset('electrical-assets/images/our-brands/terrafix.png') }}">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'conduit-bodies') }}">
                                <img src="{{ asset('electrical-assets/images/our-brands/series-e.png') }}">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'weatherproof-products') }}">
                                <img src="{{ asset('electrical-assets/images/our-brands/dry-shield.png') }}">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'fittings') }}">
                                <img src="{{ asset('electrical-assets/images/our-brands/unisteel.png') }}">
                            </a>
                        </div>
                    </div>

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    <!-- </div> -->
</div>
<!-- our_brands end -->

<div class="featured_categories">
    <!-- <div class="container"> -->
        <div class="inner_container">
            
            <div class="heading back_stroke">
                <span>Featured Categories</span>
            </div>

            <div class="featured_categories_slider">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'compression') }}">
                                <span class="img_box">
                                    <img src="{{ asset('electrical-assets/images/featured-categories/compression.png') }}">
                                </span>
                                <span>Compression</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'mechanical') }}">
                                <span class="img_box">
                                    <img src="{{ asset('electrical-assets/images/featured-categories/mechanical.png') }}">
                                </span>
                                <span>Mechanical</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'insulated') }}">
                                <span class="img_box">
                                    <img src="{{ asset('electrical-assets/images/featured-categories/insulated.png') }}">
                                </span>
                                <span>Insulated</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'grounding') }}">
                                <span class="img_box">
                                    <img src="{{ asset('electrical-assets/images/featured-categories/grounding.png') }}">
                                </span>
                                <span>Grounding</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'conduit-bodies') }}">
                                <span class="img_box">
                                    <img src="{{ asset('electrical-assets/images/featured-categories/conduit-body.png') }}">
                                </span>
                                <span>Conduit Bodies</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'weatherproof-products') }}">
                                <span class="img_box">
                                    <img src="{{ asset('electrical-assets/images/featured-categories/weatherproof.png') }}">
                                </span>
                                <span>Weatherproof Products</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'fittings') }}">
                                <span class="img_box">
                                    <img src="{{ asset('electrical-assets/images/featured-categories/fittings.png') }}">
                                </span>
                                <span>Fittings</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'service-entrance') }}">
                                <span class="img_box">
                                    <img src="{{ asset('electrical-assets/images/featured-categories/service-entrance.png') }}">
                                </span>
                                <span>Service Entrance</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'junctions-boxes') }}">
                                <span class="img_box">
                                    <img src="{{ asset('electrical-assets/images/featured-categories/ac.png') }}">
                                </span>
                                <span>Junctions Boxes</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'cable-glands') }}">
                                <span class="img_box">
                                    <img src="{{ asset('electrical-assets/images/featured-categories/cable-glands.png') }}">
                                </span>
                                <span>Cable Glands</span>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    <!-- </div> -->
</div>
<!-- featured_categories end -->

<div class="featured_products">
    <div class="container">
        <div class="inner_container">
            
            <div class="heading back_stroke">
                <span>Featured Products</span>
            </div>

            <div class="products_wrapper">
                @foreach($featuredProducts as $row)
                    <div class="product_box">
                        <a href="{{ route('product', [
                                    'category' => $row->subCategory->category->slug,
                                    'subCategory' => $row->subCategory->slug,
                                    'product' => $row->slug
                                ]) }}" class="img_box">
                            <img src="{{ $row?->productImages?->first()?->image_file ?? asset('electrical-assets/images/coming-soon.webp') }}">
                        </a>
                        <a href="{{ route('product', [
                                    'category' => $row->subCategory->category->slug,
                                    'subCategory' => $row->subCategory->slug,
                                    'product' => $row->slug
                                ]) }}" class="product_title">{{ $row->title }}</a>
                        <a href="{{ route('products', [
                                    'category' => $row->subCategory->category->slug,
                                    'subCategory' => $row->subCategory->slug
                                ]) }}" class="category_title">{{ $row->subCategory->title }}</a>
                        <div class="add_to_cart_inputs">
                            <!-- <div class="number_input">
                                <button onclick="this.parentNode.querySelector('input').stepDown()">-</button>
                                <input type="number" value="1" min="1">
                                <button onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                            </div> -->
                            <button class="red_filled_btn add_to_cart" data-product-id="{{ $row->id }}">Add to Enquiry</button>
                        </div>
                        <button class="quick_view" data-product-id="{{ $row->id }}"><i class="far fa-window-restore"></i></button>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
<!-- featured_products end -->


<div class="sales_rep_states_page">
    
    <div class="container">
        <div class="inner_container">
            <!-- sales_rep_states_wrapper -->
            <div id="statemap">
                <img src="{{ asset('electrical-assets/images/map.jpg') }}" alt="" usemap="#states" border="0">
            </div>
            <div class="map_links_wrapper">
                <map id="states" name="states"> 
                    <area class="state_link" alt="WA" coords="25,5,27,27,32,32,34,37,71,44,77,13,44,3" shape="poly" href="#WA">
                     
                    <area class="state_link" alt="OR" coords="9,71,60,86,73,46,32,39,25,30,9,71" shape="poly" href="#OR">
                     
                    <area class="state_link" alt="CA" coords="57,191,67,175,59,159,34,117,39,83,10,76,5,92,11,132,16,158,44,190" shape="poly" href="#CA">
                     
                    <area class="state_link" alt="AZ" coords="60,194,112,216,118,154,76,150" shape="poly" href="#AZ">
                     
                    <area class="state_link" alt="NM" coords="115,213,165,212,170,160,119,154" shape="poly" href="#NM">
                     
                    <area class="state_link" alt="TX" coords="130,215,158,246,179,240,208,284,215,283,219,257,247,241,251,221,243,200,192,190,194,168,176,166,176,161,170,160,167,213" shape="poly" href="#TX">
                     
                    <area class="state_link" alt="LA" coords="251,242,293,244,283,229,273,228,274,211,249,211,251,242" shape="poly" href="#LA">
                     
                    <area class="state_link" alt="MS" coords="281,181,302,182,303,231,288,234,283,226,275,226,275,202" shape="poly" href="#MS">
                     
                    <area class="state_link" alt="AL" coords="305,231,313,233,312,223,333,223,325,181,304,181" shape="poly" href="#AL">
                     
                    <area class="state_link" alt="FL" coords="316,230,352,234,377,281,390,273,368,225,315,224" shape="poly" href="#FL">
                     
                    <area class="state_link" alt="GA" coords="367,221,369,204,344,176,327,179,336,223" shape="poly" href="#GA">
                     
                    <area class="state_link" alt="SC" coords="371,202,387,183,380,176,360,173,347,176" shape="poly" href="#SC">
                     
                    <area class="state_link" alt="NC" coords="334,178,355,157,404,152,392,180,380,173,359,172,345,175" shape="poly" href="#NC">
                     
                    <area class="state_link" alt="AR" coords="250,208,274,210,284,174,279,166,243,168,245,198" shape="poly" href="#AR">
                     
                    <area class="state_link" alt="OK" coords="178,161,241,162,242,198,193,192,194,165,177,167" shape="poly" href="#OK">
                     
                    <area class="state_link" alt="NV" coords="42,83,86,95,74,156,69,170,35,117" shape="poly" href="#NV">
                     
                    <area class="state_link" alt="ID" coords="64,86,109,98,115,67,101,67,94,53,89,55,94,42,85,30,86,15,77,15,71,44,76,49" shape="poly" href="#ID">
                     
                    <area class="state_link" alt="UT" coords="88,95,109,98,109,107,122,112,118,152,77,150" shape="poly" href="#UT">
                     
                    <area class="state_link" alt="MT" coords="86,15,172,28,168,70,117,65,102,68,95,56,91,53,97,43,86,31" shape="poly" href="#MT">
                     
                    <area class="state_link" alt="WY" coords="116,67,169,71,165,113,110,107" shape="poly" href="#WY">
                     
                    <area class="state_link" alt="CO" coords="125,112,181,118,179,159,118,153" shape="poly" href="#CO">
                     
                    <area class="state_link" alt="ND" coords="173,28,220,30,224,62,171,60" shape="poly" href="#ND">
                     
                    <area class="state_link" alt="SD" coords="172,62,226,63,225,100,169,93" shape="poly" href="#SD">
                     
                    <area class="state_link" alt="NE" coords="168,94,167,114,181,118,182,128,236,131,226,100" shape="poly" href="#NE">
                     
                    <area class="state_link" alt="KS" coords="182,129,181,160,241,161,237,132" shape="poly" href="#KS">
                     
                    <area class="state_link" alt="MN" coords="222,29,274,39,259,55,256,75,265,87,226,89" shape="poly" href="#MN">
                     
                    <area class="state_link" alt="IA" coords="227,90,233,121,268,123,273,113,278,105,269,89" shape="poly" href="#IA">
                     
                    <area class="state_link" alt="MO" coords="235,124,242,167,279,166,284,172,287,171,291,161,280,151,279,141,269,131,268,122" shape="poly" href="#MO">
                     
                    <area class="state_link" alt="WI" coords="259,57,258,77,276,99,295,98,293,64,267,53" shape="poly" href="#WI">
                     
                    <area class="state_link" alt="IL" coords="277,99,297,99,301,146,293,158,280,153,281,142,270,130,271,120,278,108" shape="poly" href="#IL">
                     
                    <area class="state_link" alt="MI" coords="275,54,297,64,319,57,314,70,307,82,307,105,334,102,338,83,333,79,329,85,329,65,322,53,310,48,287,47" shape="poly" href="#MI">
                     
                    <area class="state_link" alt="IN" coords="303,108,321,104,325,134,317,147,302,150" shape="poly" href="#IN">
                     
                    <area class="state_link" alt="TN" coords="284,182,331,179,353,157,291,164" shape="poly" href="#TN">
                     
                    <area class="state_link" alt="KY" coords="294,162,343,158,350,151,346,137,328,136,320,146,301,150" shape="poly" href="#KY">
                     
                    <area class="state_link" alt="OH" coords="325,103,341,106,355,99,358,121,350,127,348,136,328,137" shape="poly" href="#OH">
                     
                    <area class="state_link" alt="VA" coords="347,157,403,150,400,134,390,133,383,122" shape="poly" href="#VA">
                     
                    <area class="state_link" alt="WV" coords="351,148,352,126,370,123,378,125,354,149,351,148" shape="poly" href="#WV">
                     
                    <area class="state_link" alt="PA" coords="356,96,360,119,402,113,406,96,400,88" shape="poly" href="#PA">
                     
                    <area class="state_link" alt="NY" coords="366,93,365,79,384,76,389,60,405,54,412,97,407,97,402,87" shape="poly" href="#NY">
                     
                    <area class="state_link" alt="ME" coords="425,45,428,70,440,55,454,41,443,30,438,17,429,20" shape="poly" href="#ME">
                     
                    <area class="state_link" alt="VT" coords="362,20,389,41" shape="rect" href="#VT">
                     
                    <area class="state_link" alt="NH" coords="394,7,421,29" shape="rect" href="#NH">
                     
                    <area class="state_link" alt="HI" coords="15,222,42,242" shape="rect" href="#HI">
                     
                    <area class="state_link" alt="RI" coords="423,99,450,121" shape="rect" href="#RI">
                     
                    <area class="state_link" alt="MA" coords="423,121,450,141" shape="rect" href="#MA">
                     
                    <area class="state_link" alt="CT" coords="423,142,450,159" shape="rect" href="#CT">
                     
                    <area class="state_link" alt="NJ" coords="423,160,450,178" shape="rect" href="#NJ">
                     
                    <area class="state_link" alt="DE" coords="423,180,450,196" shape="rect" href="#DE">
                     
                    <area class="state_link" alt="AK" coords="129,273,119,228,85,227,76,240,71,252,74,275,87,288,72,304,78,307,100,286,117,281,145,282,166,294,173,285,149,275" shape="poly" href="#AK">
                     
                    <area class="state_link" alt="MD" coords="424,198,450,215" shape="rect" href="#MD">
                     
                    <area class="state_link" alt="DC" coords="424,216,450,234" shape="rect" href="#DC">
                </map>
            </div>
            <div id="rep">
                @if($usStates->isNotEmpty())
                    @foreach($usStates as $state)
                        <div id="{{ $state->abbr }}" class="state_info" style="display: none;">
                            <h3 class="state_name">{{ $state->title }}</h3>
                            @if($state->salesRepresentatives->isNotEmpty())
                                <div class="reps_wrapper">
                                    @foreach($state->salesRepresentatives as $rep)
                                        <div class="rep_info">
                                            <div class="info_box rep_name">{{ $rep->rep_name }}</div>
                                            <div class="info_box phone">
                                                <span class="icon"><i class="fas fa-phone-alt"></i></span>
                                                <span class="text">{{ $rep->phone }}</span>
                                            </div>
                                            <div class="info_box email">
                                                <span class="icon"><i class="far fa-envelope"></i></span>
                                                <span class="text">{{ $rep->email }}</span>
                                            </div>
                                            <div class="info_box website">
                                                <span class="icon"><i class="fas fa-globe-americas"></i></span>
                                                <span class="text">{{ $rep->website }}</span>
                                            </div>
                                            <div class="info_box territories">
                                                <span class="icon"><i class="far fa-map"></i></span>
                                                <span class="text">
                                                    Other Territories : 
                                                    <!-- @if($rep->usStates->isNotEmpty())
                                                        @foreach($rep->usStates as $innerState)
                                                            @if($innerState->abbr != $state->abbr)
                                                                @if($loop->iteration != 1)
                                                                , 
                                                                @endif
                                                                {{ $innerState->title }}
                                                            @endif
                                                        @endforeach
                                                    @endif -->

                                                    @php
                                                        $otherStates = $rep->usStates
                                                            ->reject(fn($s) => $s->abbr === $state->abbr)
                                                            ->pluck('title')
                                                            ->implode(', ');
                                                    @endphp

                                                    @if($otherStates)
                                                        {{ $otherStates }}
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="info_box address">
                                                <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                                                <span class="text">{{ $rep->address }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="center">
                                    No Sales Representatives
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </div>

<script src="https://rawcdn.githack.com/stowball/jQuery-rwdImageMaps/master/jquery.rwdImageMaps.min.js"></script>
<script>
$(function() {
    let scale = 2;

    $('map area').each(function() {
        let coords = $(this).attr('coords').split(',');
        let newCoords = coords.map(function(c) {
            return Math.round(parseInt(c, 10) * scale);
        });
        $(this).attr('coords', newCoords.join(','));
    });

    $('img[usemap]').rwdImageMaps();

    $('#WA').show();

    $('.state_link').on('click', function(e) {
        e.preventDefault();
        $alt = $(this).attr('alt');
        $('.state_info').hide();
        $('#'+$alt).show();
        // console.log($('#'+$alt));
    });
});
</script>

</div>

@endsection