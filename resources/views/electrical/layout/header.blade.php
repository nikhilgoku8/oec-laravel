<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>OEC</title>
<meta name="description" content="," />
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
<link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400..700;1,400..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

<!---menu-->
<!-- <link rel="stylesheet" href="{{ asset('front/assets/css/menu-style.css') }}" type="text/css" media="all" /> -->

<!-- slider -->
<!-- <link href="{{ asset('front/assets/plugins/owl-carousel/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('front/assets/plugins/owl-carousel/owl.theme.default.min.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('front/assets/plugins/venobox/venobox.css') }}" type="text/css" media="screen" />
 -->

@stack('css')

<link href="{{ asset('electrical-assets/css/style.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('electrical-assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

</head>

<body>

<header>

<div class="upper_sec">
    <div class="container">
        <div class="inner_container">
            <div class="logo">
                <a href="{{ route('electrical') }}"><img src="{{ asset('electrical-assets/images/logo.webp') }}" alt="" /></a>
            </div>
            <div class="search_wrapper">
                <div class="input_box">
                    <input type="text" name="search" placeholder="Search Products">
                </div>
                <button class="icon_box"><i class="fas fa-search"></i></button>
            </div>
            <div class="my_account_links">
                <div class="head">My Account</div>
                <ul>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Orders</a></li>
                    <li><a href="#">Downloads</a></li>
                    <li><a href="#">Addresses</a></li>
                    <li><a href="#">Account details</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </div>
            <div class="menu_cart_wrapper">
                <div class="icon_box"><i class="fas fa-shopping-cart"></i></div>
                <div class="cart_count_wrapper">
                    <span class="cart_count">0</span>
                    <span class="text">items</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="lower_sec">
    <div class="container">
        <div class="inner_container">
            
            <nav>
                <!-- Menu Toggle btn-->
                <div class="menu-toggle">
                    <h3>Menu</h3>
                    <button type="button" class="menu-btn">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- Responsive Menu Structure-->
                <!--Note: declare the Menu style in the data-menu-style="horizontal" (options: horizontal, vertical, accordion) -->
                <ul id="category_menu" class="ace-responsive-menu" data-menu-style="horizontal">
                    <li>
                        <a>
                            <span class="ham_with_txt">
                                <i class="fas fa-bars"></i>
                                Browse Categories 
                            </span>
                            <span class="arrow"></span> 
                        </a>
                        <ul>
                            <li>
                                <a>Compression <span class="arrow"></span></a>
                                <ul>
                                    <li><a>asdaasdasdsd 1</a></li>
                                    <li><a>asdaasdasdsd 2</a></li>
                                    <li><a>asdaasdasdsd 3</a></li>
                                    <li><a>asdaasdasdsd 4</a></li>
                                    <li><a>asdaasdasdsd 5</a></li>
                                </ul>
                            </li>
                            <li>
                                <a>Test 2</a>
                                <ul>
                                    <li>asdasd 1</li>
                                    <li>asdasd 2</li>
                                    <li>asdasd 3</li>
                                    <li>asdasd 4</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            
            <nav>
                <div class="menu-toggle">
                    <h3>Menu</h3>
                    <button type="button" class="menu-btn">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
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
                            <li><a href="{{ route('overview') }}">Commercial & Industrial</a></li>
                            <li><a href="{{ route('careers') }}">Landscape & Irrigation Solutions</a></li>
                            <li><a href="{{ route('sustainability') }}">Energy Systems & Renewables</a></li>
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
                                    <li><a href="#">Operation Manual</a></li>
                                    <li><a href="#">Safety Standards</a></li>
                                    <li><a href="#">NABL Testing Lab</a></li>
                                </ul>
                            </li>
                            <li>
                                <a>Catalogs & Brochure <span class="arrow"></span></a>
                                <ul>
                                    <li><a href="#">Brochure</a></li>
                                </ul>
                            </li>
                            <li>
                                <a>Terms & Conditions</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('markets') }}">
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