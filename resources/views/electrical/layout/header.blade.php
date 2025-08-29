<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>{{ $meta_title ?? 'OEC' }}</title>
<meta name="description" content="{{ $meta_description ?? 'OEC' }}" />
<meta name="keywords" content="" />

<link rel="shortcut icon" type="image/x-icon" href="{{ asset('front/assets/images/favicon.webp') }}"> 

<link href="{{ asset('electrical-assets/css/reset.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('electrical-assets/css/ace-responsive-menu.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('electrical-assets/css/animate.css') }}" rel="stylesheet" type="text/css" />

<!---fonts-->
<link href="{{ asset('electrical-assets/css/fontawesome-5.15.3.css') }}" rel="stylesheet" type="text/css" />
<!-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet"> -->

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<!-- <link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400..700;1,400..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet"> -->
<!-- <link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400..700;1,400..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<!---menu-->
<!-- <link rel="stylesheet" href="{{ asset('front/assets/css/menu-style.css') }}" type="text/css" media="all" /> -->

<!-- slider -->
<!-- <link href="{{ asset('front/assets/plugins/owl-carousel/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('front/assets/plugins/owl-carousel/owl.theme.default.min.css') }}" rel="stylesheet"> -->

<link rel="stylesheet" href="{{ asset('front/assets/plugins/venobox/venobox.css') }}" type="text/css" media="screen" />


<!-- Swiper Slider -->
<link href="{{ asset('front/assets/plugins/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

@stack('css')

<link href="{{ asset('electrical-assets/css/style.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('electrical-assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

</head>

<body>

<header>

<div class="upper_sec">
    <div class="container">
        <div class="inner_container">
            <div class="mobile_menu_btn">
                <button type="button" class="menu_btn">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="txt">Menu</div>
            </div>
            <div class="logo">
                <a href="{{ route('electrical') }}"><img src="{{ asset('electrical-assets/images/logo.webp') }}" alt="" /></a>
            </div>
            <form method="GET" action="{{ route('shop') }}" class="search_wrapper">
                <div class="input_box">
                    <input type="text" class="search_input" id="main_search" name="q" placeholder="Search Products" value="{{ request('q') }}" autocomplete="off">
                </div>
                <button type="button" class="clear_search cross_icon"></button>
                <button class="icon_box"><i class="fas fa-search"></i></button>
                <div id="search_results">
                    @include('electrical.includes.recents')
                </div>
            </form>
            <div class="my_account_links">
                @if($desktop)
                <div class="head">My Account</div>
                @else
                <div class="head"><i class="fas fa-user"></i></div>
                @endif
                <ul>
                    <li><a href="{{ route('my-account.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('my-account.orders') }}">Orders</a></li>
                    <!-- <li><a href="#">Downloads</a></li> -->
                    <li><a href="{{ route('my-account.addresses') }}">Addresses</a></li>
                    <li><a href="{{ route('my-account.account-details') }}">Account details</a></li>
                    <li><a href="{{ route('my-account.logout') }}">Logout</a></li>
                </ul>
            </div>
            <button type="button" class="menu_cart_wrapper @if(request()->path() !== 'electrical/cart') open_side_cart @endif">
                <div class="icon_box"><i class="fas fa-shopping-cart"></i></div>
                <div class="cart_count_wrapper">
                    <span class="cart_count">{{ !empty($cartProducts) ? count($cartProducts) : 0 }}</span>
                    <span class="text">items</span>
                </div>
            </button>
        </div>
    </div>
</div>
<div class="lower_sec">
    <div class="container">
        <div class="inner_container" @if(!$desktop) id="mobile_tabs" @endif>
            @if(!$desktop)
            <script>
              $( function() {
                $( "#mobile_tabs" ).tabs();
              } );
              </script>
            <ul>
                <li><a href="#menu_tab_2">Menu</a></li>
                <li><a href="#menu_tab_1">Categories</a></li>
            </ul>
            @endif
            <nav @if(!$desktop) id="menu_tab_1" @endif>
                <!-- Menu Toggle btn-->
                <!-- <div class="menu-toggle">
                    <h3>Menu</h3>
                    <button type="button" class="menu-btn">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div> -->
                <!-- Responsive Menu Structure-->
                <!--Note: declare the Menu style in the data-menu-style="horizontal" (options: horizontal, vertical, accordion) -->
                <ul id="category_menu" class="ace-responsive-menu" data-menu-style="horizontal">
                    @if($desktop)
                    <li>
                        <a>
                            <span class="ham_with_txt">
                                <i class="fas fa-bars"></i>
                                Browse Categories 
                            </span>
                            <span class="arrow"></span> 
                        </a>
                        <ul>
                            @endif
                            @foreach($categories as $category)
                            <li>
                                <a>{{ $category->title }}
                                    @if(!empty($category->subCategories))<span class="arrow"></span>@endif
                                </a>
                                @if(!empty($category->subCategories) && $category->subCategories->count() > 0)
                                <ul>
                                    @foreach($category->subCategories as $subCategory)
                                    <li><a href="{{ route('products', ['category' => $category->slug, 'subCategory' => $subCategory->slug]) }}">{{ $subCategory->title }}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                            <!-- <li>
                                <a>Test 2</a>
                                <ul>
                                    <li>asdasd 1</li>
                                    <li>asdasd 2</li>
                                    <li>asdasd 3</li>
                                    <li>asdasd 4</li>
                                </ul>
                            </li> -->
                            @if($desktop)
                        </ul>
                    </li>
                    @endif
                </ul>
            </nav>
            
            <nav @if(!$desktop) id="menu_tab_2" @endif>
                <!-- <div class="menu-toggle">
                    <h3>Menu</h3>
                    <button type="button" class="menu-btn">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div> -->
                <ul id="main_menu" class="ace-responsive-menu" data-menu-style="horizontal">
                    <li>
                        <a href="{{ route('electrical') }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a>
                            Industries
                            <span class="arrow"></span> 
                        </a>
                        <ul>
                            <li><a href="{{ route('commercial-and-industrial') }}">Commercial & Industrial</a></li>
                            <li><a href="{{ route('landscape-irrigation-solutions') }}">Landscape & Irrigation Solutions</a></li>
                            <li><a href="{{ route('energy-systems-renewables') }}">Energy Systems & Renewables</a></li>
                        </ul>
                    </li>
                    <li>
                        <a>
                            Resources
                            <span class="arrow"></span> 
                        </a>
                        <ul>
                            <li>
                                <a>Technical Resources <span class="arrow"></span></a>
                                <ul>
                                    <li><a href="{{ route('operation-manual') }}">Operation Manual</a></li>
                                    <li><a href="{{ route('safety-standards') }}">Safety Standards</a></li>
                                    <li><a href="{{ route('nabl-testing-lab') }}">NABL Testing Lab</a></li>
                                </ul>
                            </li>
                            <li>
                                <a>Catalogs & Brochure <span class="arrow"></span></a>
                                <ul>
                                    <li><a href="{{ route('brochure') }}">Brochure</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="https://oec-americas.com/electrical/wp-content/uploads/2025/05/oec-tc.pdf">Terms & Conditions</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('cross-reference') }}">
                            <span><i class="fas fa-crosshairs"></i></span>
                            Cross Reference
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
</div>
</header>
<!-- End of Responsive Menu -->

<div id="main">