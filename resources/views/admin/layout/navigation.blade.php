
<?php $userType = Session::get('userType'); ?>

<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

            <div class="header_bar">
                <div class="logo_box">
                    <div class="logo">
                        <img src="admin/assets/images/logo.png">
                    </div>
                </div>
                <!-- <div class="orange_filled_btn"><button id="dark_mode">Dark Mode Toggle</button></div> -->
                <div class="right_section">
                    <div class="admin_info">
                        <div class="admin_name">Welcome <span> {{ Session::get('username') }}</span></div>
                        <div class="last_login">
                            last login on <span>{{ date('d-M-Y H:i', strtotime(Session::get('last_login'))) }}</span>
                        </div>
                    </div>
                    <!-- <div class="purple_hollow_btn">
                        <a>My Roles</a>
                    </div> -->
                    <!-- <div class="blue_hollow_btn">
                        <a>Sign Out</a>
                    </div> -->

                    <ul class="nav navbar-top-links navbar-right">
                        
                        <!-- /.dropdown -->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <!-- <li><a><i class="fa fa-key fa-fw"></i> Change Password</a></li>
                                <li class="divider"></li> -->
                                <li><a href="{{ url('owm/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                                </li>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>
                        <!-- /.dropdown -->
                    </ul>
                    <!-- /.navbar-top-links -->

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand"><img src="admin/assets/images/logo_admin.png"></a>
                    </div>
                    <!-- /.navbar-header -->
                    
                </div>
            </div>

            

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="menu_header">
                            <!-- <div class="user_profile">
                                <span class="user_icon"><img src="admin/assets/images/user.png" width="40"></span>
                                <span class="user_name">Welcome Admin</span>
                            </div> -->
                            <div>Menu</div>
                        </li>

                        @if(in_array(session('userType'), ['superadmin', 'manager','executive']))
                            <li><a href="{{ url('owm/dashboard'); }}" class="active"><i class="fa fa-line-chart" aria-hidden="true"></i> Dashboard</a></li>
                        @endif

                        @if(in_array(session('userType'), ['superadmin']))
                        <li>
                            <a><i class="fa fa-user" aria-hidden="true"></i> System Users<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{{ url('owm/admins') }}">All Admins</a></li>
                                <li><a href="{{ url('owm/admins/usertype/superadmin') }}">Super Admins</a></li>
                                <!-- <li><a href="{{ url('owm/admins/usertype/manager') }}">Managers</a></li>
                                <li><a href="{{ url('owm/admins/usertype/executive') }}">Care Executives</a></li> -->
                            </ul>
                        </li>
                        @endif

                        @if(in_array(session('userType'), ['superadmin', 'manager']))

                            <li>
                                <a><i class="fa fa-list-ul" aria-hidden="true"></i> Masters<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <!-- <li><a href="{{ url('owm/managers'); }}">Managers</a></li>
                                    <li><a href="{{ url('owm/zones'); }}">Zones</a></li>
                                    <li><a href="{{ url('owm/states'); }}">States</a></li>
                                    <li><a href="{{ url('owm/cities'); }}">Cities</a></li>
                                    <li><a href="{{ url('owm/pincodes'); }}">Pincodes</a></li>
                                    <li><a href="{{ url('owm/vendors'); }}">Dispatch Vendors</a></li>
                                    <li><a href="{{ url('owm/productcategories'); }}">Product Categories</a></li>
                                    <li><a href="{{ url('owm/products'); }}">Products</a></li>
                                    <li><a href="{{ url('owm/offers'); }}">Scheme / Offer(PAP)</a></li>
                                    <li><a href="{{ url('owm/indications'); }}">Indications</a></li> -->
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>

                        @endif
                        
                        @if(in_array(session('userType'), ['superadmin','manager','executive']))

                            <li>
                                <a><i class="fa fa-file-text-o" aria-hidden="true"></i> Categories<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="{{ route('categories.index') }}">All</a></li>
                                    <li><a href="{{ route('categories.create') }}">Add New</a></li>
                                </ul>
                            </li>
                            <li>
                                <a><i class="fa fa-file-text-o" aria-hidden="true"></i> Sub Categories<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="{{ route('sub-categories.index') }}">All</a></li>
                                    <li><a href="{{ route('sub-categories.create') }}">Add New</a></li>
                                </ul>
                            </li>
                            <li>
                                <a><i class="fa fa-file-text-o" aria-hidden="true"></i> Products<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="{{ route('products.index') }}">All</a></li>
                                    <li><a href="{{ route('products.create') }}">Add New</a></li>
                                </ul>
                            </li>
                            <li>
                                <a><i class="fa fa-file-text-o" aria-hidden="true"></i> Filter Types<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="{{ route('filter-types.index') }}">All</a></li>
                                    <li><a href="{{ route('filter-types.create') }}">Add New</a></li>
                                </ul>
                            </li>
                            <li>
                                <a><i class="fa fa-file-text-o" aria-hidden="true"></i> Product Tab labels<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="{{ route('product-tab-labels.index') }}">All</a></li>
                                    <li><a href="{{ route('product-tab-labels.create') }}">Add New</a></li>
                                </ul>
                            </li>

                        @endif
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <script>
            // $('#dark_mode').on('click',function(){
            //     $('html').css({"filter":"invert(1)"});
            // });

            // Check for saved theme preference on page load
            $(document).ready(function() {
              const savedTheme = localStorage.getItem('theme');
              if (savedTheme === 'dark') {
                $('html').addClass('dark-mode');
              }
            });
            
            $('#dark_mode').on('click', function() {
              // Toggle the filter on and off
              $('html').toggleClass('dark-mode');
              
              // You can also store the preference in localStorage, like this:
              const isDark = $('html').hasClass('dark-mode');
              localStorage.setItem('theme', isDark ? 'dark' : 'light');
            });

        </script>