
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
                                    <li><a href="{{ url('owm/managers'); }}">Managers</a></li>
                                    <li><a href="{{ url('owm/zones'); }}">Zones</a></li>
                                    <li><a href="{{ url('owm/states'); }}">States</a></li>
                                    <li><a href="{{ url('owm/cities'); }}">Cities</a></li>
                                    <li><a href="{{ url('owm/pincodes'); }}">Pincodes</a></li>
                                    <li><a href="{{ url('owm/vendors'); }}">Dispatch Vendors</a></li>
                                    <li><a href="{{ url('owm/productcategories'); }}">Product Categories</a></li>
                                    <li><a href="{{ url('owm/products'); }}">Products</a></li>
                                    <li><a href="{{ url('owm/offers'); }}">Scheme / Offer(PAP)</a></li>
                                    <li><a href="{{ url('owm/indications'); }}">Indications</a></li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>

                        @endif

                        @if(in_array(session('userType'), ['superadmin','manager']))
                        <li>
                            <a><i class="fa fa-list-alt" aria-hidden="true"></i> Inventory<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{{ url('owm/productbatches'); }}">Product Batches</a></li>
                            </ul>
                        </li>
                        @endif
                        
                        @if(in_array(session('userType'), ['superadmin','manager','executive']))
                            <li>
                                <a><i class="fa fa-male" aria-hidden="true"></i> Patients<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="{{ url('owm/patients/create'); }}">Add New Patient</a></li>
                                    <li><a href="{{ url('owm/patients'); }}">All Patients</a></li>
                                    <li><a href="{{ url('owm/patients/registered-patients'); }}">Registered Patients</a></li>
                                    <li><a href="{{ url('owm/patients/pending-approval'); }}">Waiting For Approval</a></li>
                                    <li><a href="{{ url('owm/patients/active-patients'); }}">Active Patients</a></li>
                                    <li><a href="{{ url('owm/patients/dropout-requested'); }}">Dropout Requests</a></li>
                                    <li><a href="{{ url('owm/patients/dropout-patients'); }}">Dropout Patients</a></li>
                                    <li><a href="{{ url('owm/patients/offers-available'); }}">Patient Offer Availability</a></li>
                                </ul>
                            </li>

                            <li>
                                <a><i class="fa fa-file-text-o" aria-hidden="true"></i> Rx<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="{{ url('owm/rx'); }}">All</a></li>
                                    <li><a href="{{ url('owm/rx/pending'); }}">Approval Pending</a></li>
                                    <li><a href="{{ url('owm/rx/approved'); }}">Approved</a></li>
                                </ul>
                            </li>

                            <li>
                                <a><i class="fa fa-file-text-o" aria-hidden="true"></i> POP<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="{{ url('owm/pop'); }}">All</a></li>
                                    <li><a href="{{ url('owm/pop/pending'); }}">Approval Pending</a></li>
                                    <li><a href="{{ url('owm/pop/approved'); }}">Approved</a></li>
                                </ul>
                            </li>
                        @endif

                        @if(in_array(session('userType'), ['superadmin','manager','executive']))
                            <li>
                                <a><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Orders<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">

                                    @if(!in_array(session('userType'), ['dispatch']))
                                    <li><a href="{{ url('owm/orders'); }}">All Orders</a></li>
                                    <li><a href="{{ url('owm/orders/approval-pending'); }}">Orders Placed (Approval Pending)</a></li>
                                    @endif

                                    @if(!in_array(session('userType'), ['executive']))
                                    <li><a href="{{ url('owm/orders/approved'); }}">Orders Approved (Require Dispatch)</a></li>
                                    @endif

                                    @if(!in_array(session('userType'), ['dispatch']))
                                    <li><a href="{{ url('owm/orders/dispatched'); }}">Orders Dispatched</a></li>
                                    <li><a href="{{ url('owm/orders/delivered'); }}">Orders Delivered</a></li>
                                    <li><a href="{{ url('owm/orders/cancelled'); }}">Orders Cancelled</a></li>
                                    <li><a href="{{ url('owm/orders/returned_to_origin'); }}">Orders Returned To Origin</a></li>
                                    @endif
                                    
                                </ul>
                            </li>
                        @endif

                        @if(in_array(session('userType'), ['superadmin','manager','executive']))
                        <li>
                            <a><i class="fa fa-history" aria-hidden="true"></i> Tasks<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <!-- <li><a href="{{ url('owm/tasks'); }}">All</a></li> -->
                                <li><a href="{{ url('owm/tasks/pending'); }}">Pending</a></li>
                                <li><a href="{{ url('owm/tasks/completed'); }}">Completed</a></li>
                                <li><a href="{{ url('owm/tasks/upcoming'); }}">Upcoming</a></li>
                            </ul>
                        </li>
                        <li>
                            <a><i class="fa fa-history" aria-hidden="true"></i>Registered Patients Tasks<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <!-- <li><a href="{{ url('owm/tasks'); }}">All</a></li> -->
                                <li><a href="{{ url('owm/tasks-registered-patients/pending'); }}">Pending</a></li>
                                <li><a href="{{ url('owm/tasks-registered-patients/done'); }}">Done</a></li>
                                <!-- <li><a href="{{ url('owm/tasks-registered-patients/follow-up'); }}">Follow Up</a></li>
                                <li><a href="{{ url('owm/tasks-registered-patients/completed'); }}">Completed</a></li>
                                <li><a href="{{ url('owm/tasks-registered-patients/no-call'); }}">No Call</a></li> -->
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a><i class="fa fa-history" aria-hidden="true"></i>Rx Added - No Pop Tasks<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{{ url('owm/tasks-pop/pending'); }}">Pending</a></li>
                                <li><a href="{{ url('owm/tasks-pop/done'); }}">Done</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a><i class="fa fa-history" aria-hidden="true"></i>Delivery Update (Order Dispatched) Tasks<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{{ url('owm/tasks-order-delivery/pending'); }}">Pending</a></li>
                                <li><a href="{{ url('owm/tasks-order-delivery/done'); }}">Done</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        @endif
                        
                        @if(in_array(session('userType'), ['superadmin','manager','executive']))
                            <li><a href="{{ url('owm/adverse'); }}" class="active"><i class="fa fa-fire" aria-hidden="true"></i> Adverse</a></li>
                        @endif

                        <?php if(in_array($userType, array('superadmin','manager','client'))){ ?>
                            <!-- <li><a href="{{ url('owm/clientdashboard'); }}/?year={{ date('Y') }}"><i class="fa fa-bar-chart" aria-hidden="true"></i> Enrolment Overview</a></li>
                            <li><a href="{{ url('owm/clientdashboard/abmwise_enrolment'); }}/?year={{ date('Y') }}"><i class="fa fa-bar-chart" aria-hidden="true"></i> ABM wise Enrolment</a></li>
                            <li><a href="{{ url('owm/clientdashboard/zonewise_enrolment'); }}/?year={{ date('Y') }}"><i class="fa fa-bar-chart" aria-hidden="true"></i> Zone wise Enrolment</a></li>
                            <li><a href="{{ url('owm/clientdashboard/orders_dispatched'); }}/?year={{ date('Y') }}"><i class="fa fa-bar-chart" aria-hidden="true"></i> Orders Dispatched</a></li>
                            <li><a href="{{ url('owm/clientdashboard/dropout'); }}/?year={{ date('Y') }}"><i class="fa fa-bar-chart" aria-hidden="true"></i> Dropout Patients</a></li> -->
                        <?php } ?>
                        
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