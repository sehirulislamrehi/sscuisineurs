@include('frontend.include.header')
@include('frontend.include.navbar')

<style>
    .form-group .form-error {
        background: unset;
        display: block;
        position: unset;
            padding: 0;
        
    }
    .message_send{
        display: none;
    }
    .form-group p {
    cursor: unset;
    margin: 0;
    text-align: left;
}
</style>

<div class="lec_slider lec_slider_inside lec_image_bck lec_fixed lec_wht_txt" data-stellar-background-ratio="0.3">

    <!-- Firefly -->
    <div class="lec_slider_firefly" data-total="30" data-min="1" data-max="3"></div>

    <!-- Over -->
    <div class="lec_over" data-color="#000" data-opacity="0.8"></div>


    <div class="container">


        <!-- Slider Texts -->
        <div class="lec_slide_txt lec_slide_center_middle text-center">
            <img src="{{asset('frontend/images/bbq/bbq_logo.png')}}')}}" alt="" height="180"><br>
            <h1 class="text-center">Contact Us</h2>
                <div class="lec_slide_subtitle">S & S CUISINEURS</div>
        </div>
        <!-- Slider Texts End -->

    </div>
    <!-- container end -->


</div>
<!-- Slider End -->

<div class="please_wait">
    <div class="please_wait_box">
        <img src="{{ asset('frontend/images/loading.gif') }}">
        <p style="color: white; text-align: center">Please Wait.</p>
    </div>
</div>

<!-- Content -->
<section id="lec_content" class="lec_content"
    style="background-image: url(http://127.0.0.1:8000/frontend/images/main_back_bl.jpg)">



    <!-- section -->
    <section class="lec_section lec_section_no_overlay">

        <!-- Over -->
        <div class="lec_over" data-color="#333" data-opacity="0"></div>

        <div class="container text-center">


            <div class="row">

                <div class="col-md-9 lec_animation_block lec_map_hidden_top"
                    data-bottom-top="transform:translate3d(0px, 80px, 0px)"
                    data-top-bottom="transform:translate3d(0px, -80px, 0px)">
                    <div class="lec_map_container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14601.888303855378!2d90.4606904!3d23.8018066!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x8866c3154c47f6bb!2sGarden%20Gourmet%20by%20S%26S%20Cuisineurs!5e0!3m2!1sen!2sbd!4v1606805167829!5m2!1sen!2sbd"
                            width="100%" height="600" frameborder="0" style="border:0;" allowfullscreen=""
                            aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>

                <div class="col-md-5 lec_animation_block lec_animation_abs_block lec_posr lec_image_bck"
                    data-bottom-top="transform:translate3d(0px, 0px, 0px)"
                    data-top-bottom="transform:translate3d(0px, 80px, 0px)"
                    data-image="{{ asset('frontend/images/main_back.jpg') }}">

                    <!-- Over -->
                    <div class="lec_over" data-color="#000" data-opacity="0.05"></div>

                    <div class="lec_parallax_menu lec_image_bck lec_fixed">
                        <form action="{{ route('contact.form') }}" class="ajax-form" method="post" data-name="contact_form">
                            <!--<div class="alert alert-success message_send" role="alert" style="margin-top: 30px;">-->
                            <!--    Sending PLease Wait-->
                            <!--</div>-->
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Name" name="name">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email Address" name="email">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="017********" name="phone">
                            </div>
                            <div class="form-group">
                                <textarea rows="3" class="form-control" name="message" placeholder="Type Your Message"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="contact-form-button">Send</button>
                            </div>
                            
                        </form>
                    </div>
                </div>


            </div>
            <!-- row end -->
        </div>
        <!-- container end -->

    </section>
    <!-- section end -->


    <!-- section -->
    <section class="lec_section lec_section_no_overlay">

        <!-- Over -->
        <div class="lec_over" data-color="#333" data-opacity="0.05"  ></div>

        <div class="container text-center contact-section">

            <div class="row">
                <div class="col-md-10 lec_animation_block lec_wht_txt"
                    data-bottom-top="transform:translate3d(0px, 80px, 0px)"
                    data-top-bottom="transform:translate3d(0px, -80px, 0px)">

                    <img src="{{asset('frontend/images/contact.jpg')}}" class="img-fluid" alt="">

                </div>
                <!-- col end -->

                <div class="col-md-5 lec_animation_block lec_animation_abs_block lec_posr lec_image_bck"
                    data-bottom-top="transform:translate3d(0px, -80px, 0px)"
                    data-top-bottom="transform:translate3d(0px, 0px, 0px)"
                    data-image="{{ asset('frontend/images/main_back.jpg')}}">

                    <!-- Over -->
                    <div class="lec_over" data-color="#000" data-opacity="0.05"></div>

                    <div class="lec_parallax_menu lec_image_bck lec_fixed">
                        @php
                        $i = 0;
                        @endphp
                        @foreach( App\Models\Logo::all() as $logo )

                        @if( $i == 0 )
                        <img src="{{asset('images/logo/'.$logo->logo)}}" width="150px" class="img-fluid">
                        @endif
                        @php
                        $i++;
                        @endphp
                        @endforeach

                        <h3>Contact Info</h3>
                        @foreach( App\Models\contact::all() as $contact )
                        <div class="row lec_contacts_icons">
                            <i class="fas fa-map"></i>{!! $contact->address !!}<br>
                            <i class="fas fa-envelope"></i> {{ $contact->email }} <br>
                            <i class="fas fa-phone"></i> {{ $contact->phone }} <br>
                            <i class="fas fa-globe"></i> {{ $contact->website }} <br>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- col end -->


            </div>
            <!-- row end -->
        </div>
        <!-- container end -->


    </section>
    <!-- section end -->





</section>
<!-- Content End -->

@include('frontend.include.footer')