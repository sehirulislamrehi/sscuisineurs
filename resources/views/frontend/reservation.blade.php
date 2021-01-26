@include('frontend.include.header')
@include('frontend.include.navbar')

<style>
    p,
    label {
        color: white;
    }
</style>

<!-- Slider -->
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
            <h1 class="text-center">Make Your Reservation</h2>
                <div class="lec_slide_subtitle">S & S CUISINEURS</div>
        </div>
        <!-- Slider Texts End -->

    </div>
    <!-- container end -->


</div>
<!-- Slider End -->

<!-- checkout main section start -->
<section class="checkout section-padding">
    <div class="container">

        @if( session()->has('payment_done') )
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success">
                    {{ session()->get('payment_done') }}
                </div>
            </div>
        </div>
        @endif

        @if( session()->has('payment_failed') )
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    {{ session()->get('payment_failed') }}
                </div>
            </div>
        </div>
        @endif

        <!-- progress row start -->
        <div class="row">
            <div class="col-md-12">
                <div class="progress-bar">
                    <div class="step">
                        
                        <div class="bullet">
                            <span>1</span>
                            <div class="check">
                                <i class="fas fa-check"> </i>
                            </div>
                        </div>
                        <p>Reservation Form</p>
                    </div>
                    <div class="step">
                        
                        <div class="bullet">
                            <span>2</span>
                            <div class="check">
                                <i class="fas fa-check"> </i>
                            </div>
                        </div>
                        <p>Payment Information</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- progress row end -->

        <!-- form item row start -->
        <div class="row">
            <div class="col-md-12">
                <div class="form-outer">
                    <form action="{{ route('make_reservation') }}" class="ajax-form" method="post">
                        
                        <!-- page one start start -->
                        <div class="page slidepage">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 style="color: white; text-align: center; font-size: 16px;margin-top: 15px;margin-bottom: 0">All government holiday will observe weekend offerings</h2>
                                    <h2 style="color: white; text-align: center; font-size: 16px;border: 1px solid #f6bb6b;padding: 10px 0;margin: 15px 0;">We are closed on sunday</h2>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label style="text-align:left;display: block;">Booking Date</label>
                                    <input type="date" name="booking_date" id="start_date" placeholder="Date" class="form-control"
                                        max="2021-03-31" />
                                </div>
                                <script>
                                    var today = new Date();
                                    var dd = String(today.getDate()).padStart(2, '0');
                                    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                                    var yyyy = today.getFullYear();
                                    today = yyyy + "-" + mm + "-" + dd;
                                    document.getElementById('start_date').setAttribute("min", today)
                                </script>
                                <div class="col-md-6">
                                    <label style="text-align:left;display: block;">Name</label>
                                    <input type="text" name="name" placeholder="Name" class="form-control" />
                                </div>
            
                                <div class="col-md-6">
                                    <label style="text-align:left;display: block;">Select Time</label>
                                    <select id="menu_id" name="menu_id" class="form-control">
                                        <option>Please Select Your Time</option>
                                        @foreach( App\Models\category::all() as $category )
                                        @foreach( $category->day as $c_day )
                                        @if( $c_day->day == \Carbon\Carbon::now()->format('l') )
                                        <option value="{{ $category->id }}" id="menu_price" data-price="{{ $category->price }}">
                                            {{ $category->name }} ( {{ $category->price }} BDT )
                                        </option>
                                        @endif
                                        @endforeach
                                        @endforeach
                                    </select>
                                </div>
            
                                <div class="col-md-6">
                                    <label style="text-align:left;display: block;">Phone</label>
                                    <input type="text" name="phone" placeholder="01*********" class="form-control" />
                                </div>
            
                                <div class="col-md-6">
                                    <label style="text-align:left;display: block;">Number of Adult</label>
                                    <input type="number" min="1" id="adult" name="adult" placeholder="Example- 1/2" oninput="updatePrice()"
                                        class="form-control" />
            
                                </div>
            
                                <div class="col-md-6">
                                    <label style="text-align:left;display: block;">Email ( Please use a valid email address
                                        )</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" />
                                </div>
                                <div class="col-md-6">
                                    <label style="text-align:left;display: block;">Child if any ( Below 12 years )</label>
                                    <input type="number" id="child_132" min="0" value="0" name="child_under_132_cm"
                                        placeholder="Example- 0/1" oninput="updatePrice()" class="form-control" />
            
                                </div>
                                <div class="col-md-6">
                                    <label style="text-align:left;display: block;">City</label>
                                    <input type="text" name="city" placeholder="City" class="form-control" />
                                </div>
            
                                <div class="col-md-6">
                                    <label style="text-align:left;display: block;">Child if any ( Below 5 years )</label>
                                    <input type="number" min="0" value="0" name="child_under_120_cm" id="child_132"
                                        placeholder="Example- 0/1" class="form-control" />
            
                                </div>
            
                                <div class="col-md-6">
                                    <label style="text-align:left;display: block;">Country</label>
                                    <select name="country" class="form-control">
                                        <option value="Bangladesh">Bangladesh</option>
                                    </select>
                                </div>
            
                                <div class="col-md-12">
                                    <label style="text-align:left;display: block;">Address</label>
                                    <textarea class="form-control" placeholder="Address" name="address" rows="1"></textarea>
                                </div>
            
                                <div class="col-md-12">
                                    <label style="text-align:left;display: block;">Message</label>
                                    <textarea class="form-control" placeholder="Message" name="message" rows="1"></textarea>
                                </div>
                            </div>

                            <!-- page change start -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group nextBtn text-right">
                                        <p>Next Step</p>
                                    </div>
                                </div>
                            </div>
                            <!-- page change end -->
                            
                        </div>
                        <!-- page one start end -->

                        <!-- page two start start -->
                        <div class="page">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="booking_price">
                                        <p class="text-center" style="max-width: unset; margin: 15px;">
                                            Our Price Packages
                                        </p>
                                        <p class="text-center" style="max-width: unset; margin-left: 15px;">
                                            For Adults BDT : <span id="amount_for_adult"></span> Each
                                        </p>
                                        <p class="text-center" style="max-width: unset; margin-left: 15px;">
                                            For Child ( Under 12 years old ) BDT : <span id="amount_for_132"></span> Each
                                        </p>
                                        <p class="text-center" style="max-width: unset; margin-left: 15px;">
                                            For Child ( Under 5 years old ) BDT : <span id="amount_for_120">0</span> Each
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p style="text-align: center">Grand Total : <span id="total">0</span> BDT</p>
                                    <p style="text-align: center">Grand Total After Discount : <span id="total_after_discount">You have no discount in</span> BDT</p>
                                    <input type="hidden" value="0" id="discount_amount" name="discount_amount">
                                </div>
            
                                <!-- get discount block start -->
                                <div class="col-md-12 discount_block">
            
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 style="color: white">Get Your Discount</h3>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 15px">
            
                                        <!-- gp start start -->
                                        <div class="col-md-6">
                                            <div class="gp_star all_card">
                                                <input class="form-check-input" type="radio" name="discount" id="gp_star"
                                                    value="GPStar">
                                                <label class="form-check-label" for="gp_star">
                                                    GPSTARs get 20% Discount <img src="{{ asset('frontend/images/gp_star.png') }}"
                                                        width="40px" alt="">
                                                </label>
            
                                                <div class="get_code" id="get_code_gp_star">
                                                    <p style="margin: 15px 0">GP STAR kindly type GOURMET and send a free SMS to 29000</p>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="gp_code" name="gp_code"
                                                            placeholder="Please Enter Your Code">
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" id="gp_code_submit" style="background: #f6bb6b;
                                                            color: white;" class="btn" data-method="post">Submit</button>
                                                    </div>
                                                </div>
            
                                            </div>
                                        </div>
                                        <!-- gp start end -->
            
                                        <!-- city gem start start -->
                                        <div class="col-md-6">
                                            <div class="city_gem all_card">
                                                <input class="form-check-input" type="radio" name="discount" id="city_gem"
                                                    value="CityGem">
                                                <label class="form-check-label" for="city_gem">
                                                    Citygem get 15% Discount <img src="{{ asset('frontend/images/city_gem.jpg') }}"
                                                        width="40px" alt="">
                                                </label>
            
                                                <div class="get_code" id="get_code_city_gem">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="city_code" name="gem_code"
                                                            placeholder="Please Enter Your Code">
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" id="city_code_submit" style="background: #f6bb6b;
                                                            color: white;" class="btn" data-method="post">Submit</button>
                                                    </div>
                                                </div>
            
                                            </div>
                                        </div>
                                        <!-- city gem start end -->
            
                                    </div>
            
                                </div>
                                <!-- get discount block end -->
            
                                <!-- get bogo offer block start -->
                                <div class="col-md-12 discount_block">
            
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 style="color: white">Get Bogo Offer</h3>
                                            <p style="color: red; font-size: 18px;">NB: Please Bring Your AmEx / EBL / Brac Bank Card With You When Arrive ( If Your Are
                                                Applicable For Bogo. Else we will cancel your reservation )</p>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 15px">
            
                                        <!-- AmEx Card start -->
                                        <div class="col-md-6">
                                            <div class="amex-card">
                                                <label class="form-check-label" for="amex">
                                                    AmEx Platinum & Gold Card holders avails to avail BoGo offer please proceed to Reception Counter @ Garden Gourmet
                                                    <img src="{{ asset('frontend/images/amex.jpg') }}" width="40px"alt="">
                                                </label>
            
                                            </div>
                                        </div>
                                        <!-- AmEx Card end -->
            
                                        <!-- EBL Card start -->
                                        <div class="col-md-6">
                                            <div class="amex-card all_card">
                                                <input class="form-check-input" type="radio" name="discount" id="ebl" value="EBL">
                                                <label class="form-check-label" for="ebl">
                                                    EBL ( Visa Platinum Credit, Visa Corporate Platinum Credit, Visa Signature Credit, Visa Ifinite Credit, Mastercard Titanium Credit, MasterCard World Credit, UPI Platinum Credit, Visa Signature Debit, EBL Visa Infinite Debit, Mastercard World Debit ) card get BoGo 
                                                    offer <img src="{{ asset('frontend/images/ebl.jpg') }}" width="40px" alt="">
                                                </label>
            
                                                <div class="get_bogo" id="get_bogo_ebl">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="ebl_card" name="ebl_card"
                                                            placeholder="Please Enter Your Card Number">
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" id="ebl_card_submit" style="background: #f6bb6b;
                                                            color: white; margin-bottom: 15px" class="btn" data-method="post">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- EBL Card end -->

                                        <!-- Brac Bank start -->
                                        <div class="col-md-6">
                                            <div class="brack_bank-card all_card">
                                                <input class="form-check-input" type="radio" name="discount" id="brac_bank" value="Brac">
                                                <label class="form-check-label" for="brac_bank">
                                                    Brac Bank ( Visa Signature, Visa Platinum, MasterCard Platinum, Visa Tara Platinum Credit, Visa Platinum Debit (PB), Visa Tara Platinum Debit (PB), Corporate Platinum Credit, Visa Infinite ) card get BoGo 
                                                    offer <img src="{{ asset('frontend/images/brac_bank.png') }}" width="50px" alt="">
                                                </label>
            
                                                <div class="get_bogo" id="get_bogo_bracbank">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="brac_bank_card" name="brac_bank_card"
                                                            placeholder="Please Enter Your Card Number">
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" id="brac_bank_card_submit" style="background: #f6bb6b;
                                                            color: white; margin-bottom: 15px" class="btn" data-method="post">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Brac Bank end -->
            
            
                                    </div>
            
                                </div>
                                <!-- get bogo offer block end -->
            
                                <div class="col-md-12" style="margin-top: 30px">
                                    <p>Please select your payment method</p>
                                    <div class="form-check">
                                        <div>
                                            <input class="form-check-input" type="radio" name="payment_method" id="on_spot_payment"
                                                value="0">
                                            <label class="form-check-label" for="on_spot_payment">
                                                On Spot Payment
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-bottom: 30px">
                                    <div class="form-check">
                                        <div>
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                id="online_payment" value="1">
                                            <label class="form-check-label" for="online_payment">
                                                Online Payment 
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!--<div class="alert alert-success reservation_send" role="alert" style="margin-top: 30px;">-->
                            <!--    Sending Please Wait-->
                            <!--</div>-->
                
                            <div class="alert alert-danger reservation_failed" role="alert" style="margin-top: 30px;">
                                Something went wrong. Please give us valid information.
                            </div>
                
                            <div class="alert alert-danger holiday" role="alert" style="margin-top: 30px;">
                
                            </div>

                            <!-- page change start -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group nextBtn text-right">
                                        <p class="prev-1 prev">Previous Step</p>
                                        <button type="submit" class="make-reservation">Make Reservation</button>
                                    </div>
                                </div>
                            </div>
                            <!-- page change end -->

                            

                        </div>
                        <!--page two end -->


                    </form>
                </div>
            </div>
        </div>
        <!-- form item row end -->

    </div>
</section>
<!-- checkout main section end -->

<div class="please_wait">
    <div class="please_wait_box">
        <img src="{{ asset('frontend/images/loading.gif') }}">
        <p style="color: white; text-align: center">Please Wait.</p>
    </div>
</div>


<section class="reservation_info">
    <div class="block"></div>
    <a href="" style="display: block; text-align: center;margin-top: 15px">Okay</a>
</section>

<script>
    var price = []
    var adultPrice = 0
    var childPrice = 0
    
    

    document.getElementById('menu_id').onchange = (e) => {
        document.getElementById('total').innerHTML = 0
        document.getElementById('discount_amount').value = 0
        document.getElementById('amount_for_adult').innerHTML = 0
        document.getElementById('amount_for_132').innerHTML = 0
        document.getElementById('amount_for_120').innerHTML = 0

        
        document.getElementById('adult').value = ''
        document.getElementById('child_132').value = ''
        
        value = e.target.value

        document.getElementById("discount_amount").value = 0
        let city = document.getElementById("city_code_submit").nextSibling
        let gp = document.getElementById("gp_code_submit").nextSibling
        if( city.nextSibling ){
            city.nextSibling.remove()
        }
        else if( gp.nextSibling ){
            gp.nextSibling.remove()
        }
        
        

        let thePrice = price.filter(v => v.id == value)
        adultPrice = thePrice[0].price
        childPrice = Math.floor(thePrice[0].price / 2)

        document.getElementById('amount_for_adult').innerHTML = adultPrice
        document.getElementById('amount_for_132').innerHTML = childPrice
        document.getElementById('amount_for_120').innerHTML = 0
    }

    function updatePrice(){
        let total_price = 0;
        var child_132 = document.getElementById('child_132').value;
        var adult = document.getElementById('adult').value;

        if( adult >= 1 && child_132 >= 0 ){
            total_price =  ( adult * adultPrice ) + ( child_132 * childPrice ) 
        }
        
        document.getElementById('total_after_discount').innerHTML = 'You have no discount in'
        document.getElementById('amount_for_120').innerHTML = 0
        document.getElementById('total').innerHTML = total_price
        document.getElementById("discount_amount").value = 0
        
        
        if( document.getElementById("city_code_submit").nextElementSibling ){
            document.getElementById("city_code_submit").nextElementSibling.remove()
        }
        if( document.getElementById("gp_code_submit").nextElementSibling ){
            document.getElementById("gp_code_submit").nextElementSibling.remove()
            
        }
        if( document.getElementById('ebl_card_submit').nextElementSibling ){
            document.getElementById("ebl_card_submit").nextElementSibling.remove()
        }
        if( document.getElementById('brac_bank_card_submit').nextElementSibling ){
            document.getElementById("brac_bank_card_submit").nextElementSibling.remove()
        }
        
    }

    

</script>
<!-- Content End -->
@include('frontend.include.footer')