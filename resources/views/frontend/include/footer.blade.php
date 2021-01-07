<footer class="lec_image_bck text-center lec_wht_txt">

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!-- Copyrights -->
                <p>
                    @foreach( App\Models\Logo::all() as $key => $logo )
                    @if( $key == 0 )
                    <img src="{{asset('images/logo/'.$logo->logo)}}" alt="" height="150">
                    @endif
                    @endforeach
                </p>

                @foreach( App\Models\contact::all() as $contact )
                <p>
                    {!! $contact->info !!}
                </p>
                <!-- Social Buttons -->
                <div class="lec_footer_social">
                    <div data-animation="animation_blocks" data-bottom="@class:noactive"
                        data--100-bottom="@class:active" class="active">
                        @if( $contact->facebook != NULL )
                        <a href="{{ $contact->facebook }}"><i class="fab fa-facebook-f lec_icon_box"
                                style="transition-delay: 0s;"></i></a>
                        @endif
                        @if( $contact->instagram != NULL )
                        <a href="{{ $contact->instagram }}"><i class="fab fa-instagram lec_icon_box"
                                style="transition-delay: 0.1s;"></i></a>
                        @endif
                        @if( $contact->twitter != NULL )
                        <a href="{{ $contact->twitter }}"><i class="fab fa-twitter lec_icon_box"
                                style="transition-delay: 0.2s;"></i></a>
                        @endif
                        @if( $contact->youtube != NULL )
                        <a href="{{ $contact->youtube }}"><i class="fab fa-youtube lec_icon_box"
                                style="transition-delay: 0.2s;"></i></a>
                        @endif
                        
                        
                                
                    </div>
                </div>
                @endforeach

                <p><a href="http://ssttechbd.com/" target="__blank">Developed By SST Tech Ltd.</a></p>

            </div>
        </div>
    </div>
</footer>

</section>
<!-- main content start -->

<!-- Footer -->
<!-- Footer End -->
</div>
<!-- Page End -->

<!-- JQuery -->
<script src="{{ asset('frontend/js/jquery-3.5.1.js') }}"></script>
<!-- Library JS -->
<script src="{{asset('frontend/js/library.js')}}"></script>

<script src="{{asset('frontend/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('frontend/js/fencybox.min.js')}}"></script>
<script src="{{asset('frontend/js/fency.js')}}"></script>
<script src="{{ asset('frontend/js/sweet-alert.js') }}"></script>
<!-- Theme JS -->
<script src="{{asset('frontend/js/script.js')}}"></script>
<script src="{{asset('frontend/js/step.js')}}"></script>

<script src="{{asset('frontend/js/custom.js')}}"></script>

</body>
</html>