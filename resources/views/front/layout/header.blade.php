<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>HTML Framework</title>
<meta name="description" content="," />
<meta name="keywords" content="" />

<link href="{{ asset('front/assets/css/reset.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('front/assets/css/ace-responsive-menu.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('front/assets/css/animate.css') }}" rel="stylesheet" type="text/css" />

<!---fonts-->
<link href="{{ asset('front/assets/css/fontawesome-5.15.3.css') }}" rel="stylesheet" type="text/css" />
<!-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet"> -->

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<!-- <link href="https://fonts.googleapis.com/css2?family=Michroma&display=swap" rel="stylesheet"> -->
<link href="https://fonts.googleapis.com/css2?family=Michroma&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<!---menu-->
<!-- <link rel="stylesheet" href="{{ asset('front/assets/css/menu-style.css') }}" type="text/css" media="all" /> -->

<!-- slider -->
<!-- <link href="{{ asset('front/assets/plugins/owl-carousel/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('front/assets/plugins/owl-carousel/owl.theme.default.min.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('front/assets/plugins/venobox/venobox.css') }}" type="text/css" media="screen" />
 -->
<link href="{{ asset('front/assets/css/style.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('front/assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />

<!-- <script type="text/javascript" src="{{ asset('front/assets/js/jquery.3.3.1.min.js') }}"></script> -->
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

</head>

<body>

<header>  

<div class="container">
    <div class="inner_container">
        <div class="logo">
            <!-- <a href="{{ route('home') }}"><img src="{{ asset('front/assets/images/logo.webp') }}" alt="" /></a> -->
        </div>
        <nav>
            <!-- Menu Toggle btn-->
            <div class="menu-toggle">
                <h3>Menu</h3>
                <button type="button" id="menu-btn">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Responsive Menu Structure-->
            <!--Note: declare the Menu style in the data-menu-style="horizontal" (options: horizontal, vertical, accordion) -->
            <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">
                <li>
                    <a href="{{ route('home') }}">
                        Home
                    </a>
                </li>
                <li>
                    <a>
                        Company
                        <span class="arrow"></span> 
                    </a>
                    <ul>
                        <li><a href="{{ route('overview') }}">About OEC</a></li>
                        <li><a href="{{ route('careers') }}">Careers</a></li>
                        <li><a href="{{ route('sustainability') }}">Sustainability</a></li>
                    </ul>
                </li>
                <li>
                    <a>
                        Products
                        <span class="arrow"></span> 
                    </a>
                    <ul>
                        <li><a href="@{{ route('electricals') }}">Electricals</a></li>
                        <li><a href="@{{ route('automotive') }}">Automotive</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('markets') }}">
                        Markets
                    </a>
                </li>
                <li>
                    <a href="{{ route('reach-us') }}">
                        Reach Us
                    </a>
                </li>
                <li>
                    <a href="{{ route('login') }}">
                        Login/Register
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
</header>
<!-- End of Responsive Menu -->


<div id="main">