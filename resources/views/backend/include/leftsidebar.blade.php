<!-- body content start -->
<div class="body-content">


    <!-- left sidebar pc start -->
    <section class="left-sidebar">
        <div class="container-fluid">

            <!-- top part start -->
            <div class="row top-part">

                <!-- middle part start -->
                <div class="col-md-9 col-9">
                    <h3></h3>

                    <p>Welcome {{ Auth::user()->name }}</p>

                </div>
                <!-- middle part end -->

            </div>
            <!-- top part end -->

            <!-- navbar item start -->
            <div class="row nav-item">
                <div class="col-md-12">
                    <ul>

                        <!-- nav single view start -->
                        <li>
                            <a href="{{ route('backend_dashboard') }}">
                                <div class="left">
                                    dashboard
                                </div>
                                <div class="right">
                                    <i class="fas fa-home"></i>
                                </div>
                            </a>
                        </li>
                        <!-- nav single view end -->

                        

                        <!-- nav single view start -->
                        
                        <li>
                            <a href="{{ route('all.message') }}">
                                <div class="left">
                                    Messages
                                </div>
                                <div class="right">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </a>
                        </li>

                        @if(Auth::user()->role == 1)
                        <li>
                            <a href="{{ route('user.all') }}">
                                <div class="left">
                                    User Management
                                </div>
                                <div class="right">
                                    <i class="fas fa-user"></i>
                                </div>
                            </a>
                        </li>

                        
                        
                        <!-- nav single view end -->

                        <!-- nav single view start -->
                        <li>
                            <a href="{{route('logoShow')}}">
                                <div class="left">
                                    logo
                                </div>
                                <div class="right">
                                    <i class="fas fa-bars"></i>
                                </div>
                            </a>
                        </li>
                        <!-- nav single view end -->

                        <!-- nav single view start -->
                        <li>
                            <a href="{{route('sliderShow')}}">
                                <div class="left">
                                    Home Page Slider
                                </div>
                                <div class="right">
                                    <i class="fas fa-sliders-h"></i>
                                </div>
                            </a>
                        </li>

                        <!-- nav single view start -->

                        <!-- nav single view start -->
                        <li>
                            <a href="{{route('aboutShow')}}">
                                <div class="left">
                                    About US
                                </div>
                                <div class="right">
                                    <i class="fas fa-address-card"></i>
                                </div>
                            </a>
                        </li>

                        <!-- nav single view start -->

                        <!-- nav single view start -->
                        <li>
                            <a href="{{route('galleryShow')}}">
                                <div class="left">
                                    Photo Gallery
                                </div>
                                <div class="right">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('dining.all')}}">
                                <div class="left">
                                    Dining Hours
                                </div>
                                <div class="right">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('popup.video')}}">
                                <div class="left">
                                    Popup Video
                                </div>
                                <div class="right">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </a>
                        </li>

                        <!-- nav single view end -->

                        

                        <li>
                            <a href="{{route('contactShow')}}">
                                <div class="left">
                                    Contact Information
                                </div>
                                <div class="right">
                                    <i class="fas fa-phone"></i>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('specialityShow')}}">
                                <div class="left">
                                    Our Speciality
                                </div>
                                <div class="right">
                                    <i class="fas fa-crown"></i>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('event.all')}}">
                                <div class="left">
                                    Our Event
                                </div>
                                <div class="right">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('garden.all')}}">
                                <div class="left">
                                    Garden Gourmet
                                </div>
                                <div class="right">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </a>
                        </li>

                        <!--<li>-->
                        <!--    <a href="{{route('configShow')}}">-->
                        <!--        <div class="left">-->
                        <!--            Pricing-->
                        <!--        </div>-->
                        <!--        <div class="right">-->
                        <!--            <i class="fas fa-bars"></i>-->
                        <!--        </div>-->
                        <!--    </a>-->
                        <!--</li>-->

                        <!-- nav single view start -->
                        <li>
                            <a href="{{route('categoryShow')}}">
                                <div class="left">
                                    Our Menu
                                </div>
                                <div class="right">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                            </a>
                        </li>



                        <!-- nav single view end -->

                        <!-- nav single view start -->
                        <li>
                            <a href="{{route('menuShow')}}">
                                <div class="left">
                                    All Food List
                                </div>
                                <div class="right">
                                    <i class="fas fa-utensils"></i>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('holiday.all')}}">
                                <div class="left">
                                    Govt. Holiday
                                </div>
                                <div class="right">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                            </a>
                        </li>
                        @endif

                        @if( Auth::user()->role == 0 || Auth::user()->role == 1 || Auth::user()->role == 3 )
                        <li>
                            <div class="row navbar-dropdown-top" id="2">
                                <div class="col-md-10  col-10">
                                    reservation Information
                                </div>
                                <div class="col-md-2 col-2 text-right">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </div>
                            <div class="row navbar-dropdown-child 2">
                                <div class="col-md-12">
                                    <ul>
                                        <li>
                                            <a href="{{ route('reservation.make.page') }}" target="__blank">
                                                <i class="fas fa-book" style="margin-right: 5px"></i>
                                                Make a reservation
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('reservationShow') }}" target="__blank">
                                                <i class="fas fa-book" style="margin-right: 5px"></i>
                                                All Reservation
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('paid') }}" target="__blank">
                                                <i class="fas fa-money-bill" style="margin-right: 5px"></i>
                                                Online Pay
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('notPaid') }}" target="__blank">
                                                <i class="fas fa-money-bill" style="margin-right: 5px"></i>
                                                Onspot Pay
                                            </a>
                                        </li>
                                        <!-- <li>
                                            <a href="{{ route('not_arrived') }}" target="__blank">
                                                <i class="fas fa-plane-arrival" style="margin-right: 5px"></i>
                                                Not Arrived
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('arrived') }}" target="__blank">
                                                <i class="fas fa-plane-arrival" style="margin-right: 5px"></i>
                                                Arrived
                                            </a>
                                        </li> -->

                                        <li>
                                            <a href="{{ route('bogo.all') }}" target="__blank">
                                                <img src="https://img.icons8.com/cute-clipart/64/000000/b.png" width="30px"/>
                                                Bogo Get Cards
                                            </a>
                                        </li>

                                        <li>
                                            <a href="{{ route('discount.all') }}" target="__blank">
                                                <i class="fas fa-tags" style="margin-right: 5px"></i>
                                                Discount & Bogo
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </li>
                        @endif

                        <!-- nav drop down view start -->
                        {{-- <li>
                            <div class="row navbar-dropdown-top" id="3">
                                <div class="col-md-10  col-10">
                                    <a>selling history </a>
                                </div>
                                <div class="col-md-2 col-2 text-right">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </div>
                            <div class="row navbar-dropdown-child 3">
                                <div class="col-md-12">
                                    <ul>
                                        <li>
                                            <a href="{{ route('confirmed.show') }}">
                                                <i class="fas fa-truck-loading" style="margin-right: 5px"></i>
                                                Total Sell
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li> --}}
                        <!-- nav drop down view end -->


                    </ul>
                </div>
            </div>
            <!-- navbar item end -->

        </div>
    </section>
    <!-- left sidebar pc end -->