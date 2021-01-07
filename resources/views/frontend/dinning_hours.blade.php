@include('frontend.include.header')
@include('frontend.include.navbar')


<style>
.pagination-row{
    margin-top: 30px;
}
    .pagination-row nav span,
    .pagination-row nav a{
            background: #f6bb6b;
        color: white;
        padding: 15px;
        display: inline-block;
    }
</style>


<div class="lec_slider lec_slider_inside lec_image_bck lec_fixed lec_wht_txt" style="background-image: url(http://127.0.0.1:8000/frontend/images/main_back_bl.jpg)">
    <!-- Firefly -->
    <div class="lec_slider_firefly" data-total="30" data-min="1" data-max="3"></div>

    <!-- Over -->
    <div class="lec_over" data-color="#000" data-opacity="0.8"></div>


    <div class="container">

        <!-- Slider Texts -->
        <div class="lec_slide_txt lec_slide_center_middle text-center">
            <img src="{{ asset('frontend/images/bbq/bbq_logo.png') }}" alt="" height="180"><br>
            <h1 class="text-center">Our Dining Hours</h2>
                <div class="lec_slide_subtitle">S & S CUISINEURS</div>
        </div>
        <!-- Slider Texts End -->

    </div>
    <!-- container end -->
</div>
<!-- Slider End -->


<!-- dining main section start -->
<section class="gallery-section" style="background-image: url(http://127.0.0.1:8000/frontend/images/main_back_bl.jpg)">
    <div class="container">
        <div class="row">

            <!-- dining image start -->
            @foreach( $dinings as $dining )
            <div class="dining-image">
                <a data-fancybox="dining" data-caption="{{ $dining->caption }}" href="{{ asset('images/dining/'.$dining->image) }}">
                    <img src="{{ asset('images/dining/'.$dining->image) }}" class="img-fluid">
                </a>
            </div>
            @endforeach
            <!-- dining image end -->

        </div>
        <div class="row pagination-row">
            {{ $dinings->links() }}
        </div>
    </div>
</section>
<!-- dining main section end -->

@include('frontend.include.footer')