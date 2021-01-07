@include('frontend.include.header')
@include('frontend.include.navbar')

<style>
    .avaiable_day:last-child span{
        display: none
    }
    .menu-image-row{
        column-count: 3;
        column-gap: 0;
    }
</style>

<div class="lec_slider lec_slider_inside lec_image_bck lec_fixed lec_wht_txt"
    style="background-image: url(http://127.0.0.1:8000/frontend/images/main_back_bl.jpg)">
    <!-- Firefly -->
    <div class="lec_slider_firefly" data-total="30" data-min="1" data-max="3"></div>

    <!-- Over -->
    <div class="lec_over" data-color="#000" data-opacity="0.8"></div>


    <div class="container">

        <!-- Slider Texts -->
        <div class="lec_slide_txt lec_slide_center_middle text-center">
            <img src="{{asset('frontend/images/bbq/bbq_logo.png')}}" alt="" height="180"><br>
            <h1 class="text-center">Our Menus</h2>
                <div class="lec_slide_subtitle">S & S CUISINEURS</div>
        </div>
        <!-- Slider Texts End -->

    </div>
    <!-- container end -->
</div>
<!-- Slider End -->

<!-- menu section start -->
@foreach( App\Models\category::orderBy('id','desc')->get() as $category )
@if( $category->categoryimage->count() > 0 )

<section class="main-menu" style="background-image: url(http://127.0.0.1:8000/frontend/images/main_back_bl.jpg)">
    <div class="container">

        <!-- menu item start -->
        <div class="row">

            <!-- title start -->
            <div class="col-md-12">
                <h1 class="text-center">{{ $category->name }}</h1>
                <p class="text-center" style="color: white; margin-bottom: 0px;">
                    Available in : 
                    @foreach( $category->day as $single_day )
                    <span class="avaiable_day">{{ $single_day->day }} <span>,</span> </span>
                    @endforeach
                </p>

                <p class="text-center" style="color: white"> Menu Price : {{ $category->price }} </p>
                
            </div>
            <!-- title end -->

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="menu-image">
                            <img src="{{asset('images/menu/'.$category->image)}}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
                <div class="row menu-image-row">
                    @foreach( $category->categoryimage as $category_food_image )
                    <div class="menu-image">
                        <a data-fancybox="menu"  href="{{ asset('images/food/'.$category_food_image->image) }}">
                            <img src="{{ asset('images/food/'.$category_food_image->image) }}" class="img-fluid">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- food item start -->
            {{-- @foreach( $category->menu as $food )
            <div class="col-md-6">
                <div class="left">
                    <div class="row menu-food-item">
                        <div class="col-md-9">
                            <h3>{{ $food->name }}</h3>
                            <p>
                                {{ $food->description }}
                            </p>
                        </div>
                        <div class="col-md-3">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach --}}
            <!-- food item end -->

        </div>
        <!-- menu item end -->

    </div>
</section>
@endif
@endforeach
<!-- menu section end -->


@include('frontend.include.footer')