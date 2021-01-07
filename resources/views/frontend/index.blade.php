@include('frontend.include.header')
@include('frontend.include.navbar')

<style>
     body {
          overflow: auto;
     }

     .nav-header {
          display: block;
     }

     #popup-section {
          height: 100vh;
          background: rgba(1, 1, 1, 0.9);
          position: fixed;
          top: 0;
          width: 100%;
          z-index: 30;
          display: none
     }

     .reservation-button {
          position: absolute;
          top: 50%;
          transform: translateY(-50%);
          right: 0;
          z-index: 5;
     }

     .lec_slider {
          height: 100%;
          width: 100%;
          position: relative;
          background-position: unset !important;
          overflow: hidden;
          background: black;
     }

     .reservation-button a {
          border-radius: 0;
          display: inherit;
     }

     
</style>
<div id="fb-root"></div>

<!-- popup section start -->
<div class="popup-section" id="popup-section">
     <i class="fas fa-times" id="popup-close"></i>
     @foreach(App\Models\PopupVideoModal::all() as $video )
     <div class="popup-video">
          <iframe src="{{ $video->video }}" width="560" height="560" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowFullScreen="true"></iframe>
     </div>
     @endforeach
</div>
<!-- popup section end -->


<!-- Banner Start -->
<div class="lec_slider lec_image_bck lec_fixed lec_wht_txt">

     <div class="reservation-button">
          <a href="{{ route('reservation') }}" target="__blank">Reservation</a>
     </div>

     <!-- owl carouse start -->
     <div class="banner-carousel owl-carousel owl-theme">

          <!-- item start -->
          @foreach( App\Models\slider::orderBy('id','desc')->get() as $slider )
          <div class="item" style="background-image: url({{ asset('images/slider/'.$slider->image) }});">
               <div class="banner-overlay">
                    <div class="container">
                         <div class="row">
                              <div class="col-md-12">
                                    @foreach( App\Models\Logo::all() as $key => $logo )
                                    @if( $key == 2 )
                                    <img src="{{asset('images/logo/'.$logo->logo)}}"
                                         class="banner-logo garden">
                                    @endif
                                    @endforeach
                                   <h3 class="text-center powered_by" >powered by</h3>
                                   <div style="display: flex; position: relative">
                                        @foreach( App\Models\Logo::all() as $key => $logo )
                                        @if( $key == 0 )
                                        <img src="{{asset('images/logo/'.$logo->logo)}}"
                                             class="bottom_logo">
                                        @endif
                                        @endforeach
                                        @foreach( App\Models\Logo::all() as $key => $logo )
                                        @if( $key == 1 )
                                        <img src="{{asset('images/logo/'.$logo->logo)}}"
                                             class=" bottom_logo_sygmax">
                                        @endif
                                        @endforeach
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
          @endforeach
          <!-- item end -->

     </div>
     <!--- owl carousel end --->

</div>
<!-- Slider End -->


<!-- our garden barnet section start -->
<section class="lec_section lec_image_bck lec_fixed lec_section_no_overlay lec_wht_txt"
     data-stellar-background-ratio="0.2" id="specials">
     

     <!-- Over -->
     <div class="lec_over" data-color="#000" data-opacity="0.8" >
     </div>

     <div class="container text-center">

          <h3 class="text-center">Garden Gourmet At A Glance</h3>

          <!-- boxes -->
          <!-- owl carouse start -->
          <div class="row">
               <div class="event-carousel owl-carousel owl-theme lec_icon_boxes owl-loaded">

                    <!-- item start -->
                    @foreach( App\Models\Garden::orderBy('id','desc')->get() as $garden )
                    <div class="item">
                         <div class="col-md-12">
                              <div class="lec_news_block text-center">
                                   <span class="lec_news_img_parent"><span class="lec_news_img lec_image_bck"
                                             data-image="{{asset('images/garden/'. $garden->image)}}"
                                             style="background-image: url(&quot;images/sl5.jpg')}}&quot;);"></span></span>
                                   <span class="lec_gold lec_title_animation lec_wht_txt"><span
                                             class="char1 lec_letter_F">F</span><span
                                             class="char2 lec_letter_r">r</span><span
                                             class="char3 lec_letter_i">i</span><span
                                             class="char4 lec_letter_d">d</span><span
                                             class="char5 lec_letter_a">a</span><span
                                             class="char6 lec_letter_y">y</span></span>
                                   <span class="lec_news_title lec_gold_subtitle">{{ $garden->title }}</span>
                                   <p>{{ $garden->description ? $garden->description : '' }}</p>
                              </div>
                         </div>
                    </div>
                    @endforeach
                    <!-- item end -->



               </div>
          </div>
          <!-- owl carouse end -->

     </div>
     <!-- container end -->

</section>
<!-- our garden barnet section end -->


<!-- our specialities section start -->
<section class="lec_section lec_image_bck lec_fixed lec_section_no_overlay lec_wht_txt"
     data-stellar-background-ratio="0.2" id="specials">
     

     <!-- Over -->
     <div class="lec_over" data-color="#000" data-opacity="0.8" style="background-color: rgb(0, 0, 0); opacity: 0.8;">
     </div>

     <div class="container text-center">

          <h3 class="text-center">Our Specialities</h3>

          <!-- boxes -->
          <!-- owl carouse start -->
          <div class="row">
               <div class="event-carousel owl-carousel owl-theme lec_icon_boxes owl-loaded">

                    <!-- item start -->
                    @foreach( App\Models\specialities::orderBy('id','desc')->get() as $speciality )
                    <div class="item">
                         <div class="col-md-12">
                              <div class="lec_news_block text-center">
                                   <span class="lec_news_img_parent"><span class="lec_news_img lec_image_bck"
                                             data-image="{{asset('images/specialities/'. $speciality->image)}}"
                                             style="background-image: url(&quot;images/sl5.jpg')}}&quot;);"></span></span>
                                   <span class="lec_gold lec_title_animation lec_wht_txt"><span
                                             class="char1 lec_letter_F">F</span><span
                                             class="char2 lec_letter_r">r</span><span
                                             class="char3 lec_letter_i">i</span><span
                                             class="char4 lec_letter_d">d</span><span
                                             class="char5 lec_letter_a">a</span><span
                                             class="char6 lec_letter_y">y</span></span>
                                   <span class="lec_news_title lec_gold_subtitle">{{ $speciality->title }}</span>
                                   <p>{{ $speciality->description ? $speciality->description : '' }}</p>
                              </div>
                         </div>
                    </div>
                    @endforeach
                    <!-- item end -->



               </div>
          </div>
          <!-- owl carouse end -->

     </div>
     <!-- container end -->

</section>
<!-- our specialities section end -->


<!-- about section start -->
<section class="lec_section lec_section_no_overlay" id="story">

     <div class="lec_over" style="background: black">
     </div>

     <div class="container text-center">

          <!--- title start --->
          <div class="row">
               <div class="col-md-12">
                    <h1>Dine with us</h1>
               </div>
          </div>
          <!--- title end --->

          @foreach( App\Models\About::all() as $about )
          <div class="row">

               <!--- right part start --->
               <div class="col-md-10 col-md-offset-2 lec_animation_block skrollable skrollable-between"
                    data-bottom-top="transform:translate3d(0px, 80px, 0px)"
                    data-top-bottom="transform:translate3d(0px, -80px, 0px)"
                    style="transform: translate3d(0px, 18.4694px, 0px);">
                    <img src="{{asset('images/about/'. $about->image)}}" class="img-fluid" alt="">
               </div>
               <!--- right part end --->

               <!-- left part start -->
               <div class="col-md-5 lec_animation_block lec_animation_abs_block lec_posl lec_image_bck skrollable skrollable-between"
                    data-bottom-top="transform:translate3d(0px, 0px, 0px)"
                    data-top-bottom="transform:translate3d(0px, 80px, 0px)"
                    data-image="{{ asset('frontend/images/main_back.jpg') }}"
                    style="background-image: url({{ asset('frontend/images/main_back.jpg') }}); transform: translate3d(0px, 32.7679px, 0px);">

                    <div class="lec_over" data-color="#000" data-opacity="0.08"
                         style="background-color: rgb(0, 0, 0); opacity: 0.08;"></div>

                    <div class="lec_parallax_menu lec_image_bck lec_fixed" style="background-attachment: fixed;">
                         @foreach( App\Models\Logo::all() as $key => $logo )
                         @if( $key == 0 )
                         <img src="{{asset('images/logo/'.$logo->logo)}}" width="150px">
                         @endif
                         @endforeach
                         <h3 class="lec_gold_subtitle m-t-15">{{ $about->title }}</h3>
                         <p>
                              {!! $about->description !!}
                         </p>
                    </div>
               </div>
               <!-- left part end -->

          </div>
          @endforeach
          <!-- row end -->

     </div>
     <!-- container end -->

     <!-- about section start -->
</section>
<!-- about section end -->



<!-- event section start -->
<section class="lec_section lec_image_bck lec_fixed lec_section_no_overlay lec_wht_txt"
     data-stellar-background-ratio="0.2">

     <!-- Over -->
     <div class="lec_over" data-color="#000" data-opacity="0.8" style="background-color: rgb(0, 0, 0); opacity: 0.8;">
     </div>

     <div class="container text-center">

          <h3 class="text-center">Let Us Cater <br>Your Next Event</h3>

          <!-- boxes -->
          <!-- owl carouse start -->
          <div class="row">
               <div class="event-carousel owl-carousel owl-theme lec_icon_boxes owl-loaded">

                    <!-- item start -->
                    @foreach( App\Models\event::orderBy('id','desc')->get() as $event )
                    <div class="item">
                         <div class="col-md-12">
                              <div class="lec_news_block text-center">
                                   <span class="lec_news_img_parent"><span class="lec_news_img lec_image_bck"
                                             data-image="{{asset('images/event/'.$event->image)}}"
                                             style="background-image: url(&quot;images/sl5.jpg')}}&quot;);"></span></span>
                                   <span class="lec_gold lec_title_animation lec_wht_txt"><span
                                             class="char1 lec_letter_F">F</span><span
                                             class="char2 lec_letter_r">r</span><span
                                             class="char3 lec_letter_i">i</span><span
                                             class="char4 lec_letter_d">d</span><span
                                             class="char5 lec_letter_a">a</span><span
                                             class="char6 lec_letter_y">y</span></span>
                                   <span class="lec_news_title lec_gold_subtitle">{{ $event->title }}</span>
                                   <p>{{ $event->description ? $event->description : '' }}</p>
                              </div>
                         </div>
                    </div>
                    @endforeach
                    <!-- item end -->



               </div>
          </div>
          <!-- owl carouse end -->

          <div class="row m-t-30">
               <div class="col-md-12">
                    <a href="{{ route('contact') }}"
                         style="background: #f6bb6b; color:white; padding: 15px 30px; display: inline-block;">Get
                         Qoute</a>
               </div>
          </div>

     </div>
     <!-- container end -->

</section>
<!-- event section end -->

<script>
     
window.onload = e => {
    document.getElementById('popup-section').style.display = "block"
    document.getElementsByTagName("body")[0].style.overflow = "hidden"
}
</script>

<!-- main content start -->
<section id="lec_content" class="lec_content">

     <!-- section -->

     <!-- section end -->


     @include('frontend.include.footer')