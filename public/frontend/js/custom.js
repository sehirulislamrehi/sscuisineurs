
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function(){
    $(".ajax-form").submit(function(e){
        e.preventDefault()
        $(".reservation_send").show();
        $(".please_wait").show();
        $(".message_send").show();
        $(".reservation_failed").hide();
        let $this = $(this);
        let formData = new FormData(this);
        $this.find(".has-danger").removeClass('has-error');
        $this.find(".has-danger .form-control").css({
            'border': "none"
        });
        $this.find(".form-error").remove();
        $.ajax({
            type: $this.attr('method'),
            url: $this.attr('action'),
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(response){
                
                $(".reservation_send").hide();
                $(".please_wait").hide();
                $(".reservation_failed").hide();
                $(".holiday").html('')

                if( response[0] == 'failed' ){
                    $(".holiday").show();
                    $(".holiday").append(`${response[1]}`);
                }
                else if( response.payment_method == 0 ){
                    $(".reservation_info").show();
                    $('html,body').css({
                        'overflow' : 'hidden',
                    })
                    $(".reservation_info .block").append(`
                    <div class="block">
                        <h2 class="text-center">Thanks for your reservation</h2>
                        <p style="color: #000000; text-align:center; margin: 0; font-size: 18px" >Grand Total : ${response.booking_transation.amount} BDT</p>
                        
                        <p style="color: #000000; text-align:center; margin: 0; font-size: 18px" >Grand Total After Discount : ${response.booking_transation.discounted_amount ? response.booking_transation.discounted_amount : 'You Have No Discount in' } BDT</p>

                        <p style="color: #000000; text-align:center; margin: 0; font-size: 18px" > Discount From : 
                        ${response.discount_type  ? ( response.discount_type == 'Brac' ? 'Brac Bank' : response.discount_type ) : 'N/A'}
                        </p>
                        <p style="color: #000000; text-align:center; margin: 0; font-size: 18px" >Code Number ( Please remember this code number when arrive ) : ${response.random}</p>
                        <p style="color: #000000; text-align:center; margin: 0; font-size: 18px" >We also mail you in your given email address. Please check it.</p>
                        <h2 class="text-center">Please Take A ScreenShot Of This Page And Remember The Code Number!</h2>
                    </div>
                    `);
                }
                else if( $this.attr('data-name') == 'contact_form' ){
                    $(".message_send").hide();
                    swal('','Thanks for messaging us','success')
                }
                else{
                    let redirectURl = JSON.parse(response).GatewayPageURL
                    console.log(redirectURl)
                    return window.location.href = redirectURl
                }

                
                
                $(".ajax-form textarea").val('');
                $(".ajax-form input[type=text]").val('');
                $(".ajax-form input[type=email]").val('');

                
            },
            error: function(response){
                $(".holiday").hide();
                $(".reservation_send").hide();
                $(".please_wait").hide();
                $(".message_send").hide();
                $(".reservation_failed").show();
                data = response.responseJSON
                $.each(data.errors, (key, value) => {
                        $(".prev-1").click();
                    
                    $("[name^="+key+"]").parent().addClass('has-error')
                    $("[name^="+key+"]").parent().append('<p class="form-error mb-0"><small class="danger text-muted">'+value[0]+'</small></p>');
                })
            }
        })
    })
})

//discount gp star
$(document).ready(function(){
    $("#gp_code_submit").click(function(e){
        let code = $("#gp_code").val();
        let amount = $("#total").html();
        $('#gp_code_submit ~ .form-error').remove();
        if(code.length == 3){
            $.ajax({
                type: $(this).attr('data-method'),
                url: '/gp_star/discount/'+ code +'/'+ amount,
                data: code,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response){
                    if( response.discount_failed ){
                        $('#gp_code_submit').parent().append('<p class="discount-failed mb-0">'+ response.discount_failed +'</p>');
                        $("#discount_amount").val(0)
                        $("#gp_code_submit ~ .form-error").remove();
                        $("#gp_code_submit ~ .no-amount").remove();
                        $("#total_after_discount").html('You have no discount in')
                    }
                    else if( response.please_select ){
                        $('#gp_code_submit').parent().append('<p class="no-amount mb-0">'+ response.please_select +'</p>');
                        $("#discount_amount").val(0)
                        $("#gp_code_submit ~ .form-error").remove();
                        $("#total_after_discount").html('You have no discount in')
                    }
                    else{
                        $('#gp_code_submit').parent().append('<p class="discount-success mb-0">Congratulations you have got 20% off. Your amount after discount is '+ response.discount_amount +' BDT</p>');
                        $("#discount_amount").val(response.discount_amount)
                        $("#total_after_discount").html(response.discount_amount)
                        $("#gp_code_submit ~ .form-error").remove();
                        $("#gp_code_submit ~ .no-amount").remove();
                    }
                    
                },
                error: function(e){

                }
            })
            if(e.target.nextElementSibling){
                e.target.nextElementSibling.remove();
            }
        }else{
            
            $("#gp_code_submit ~ .discount-success").remove();
            $("#gp_code_submit ~ .discount-failed").hide();
            $("#gp_code_submit ~ .form-error").hide();
            $("#gp_code_submit ~ .no-amount").remove();
            $("#discount_amount").val(0)
            $("#gp_code_submit .discount-success").remove();
            $("#total_after_discount").html('You have no discount in')
            $('#gp_code_submit').parent().append('<p class="form-error mb-0"><small class="danger text-muted">Invalid Code</small></p>');

        }
    })
});

//discount city gem
$(document).ready(function(){
    $("#city_code_submit").click(function(e){
        let code = $("#city_code").val();
        let amount = $("#total").html();
        $('#city_code_submit ~ .form-error').remove();
        if(code){
            $.ajax({
                type: $(this).attr('data-method'),
                url: '/city_gem/discount/'+ code +'/'+ amount,
                data: code,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response){
                    if( response.discount_failed ){
                        $('#city_code_submit').parent().append('<p class="discount-failed mb-0">'+ response.discount_failed +'</p>');
                        $("#discount_amount").val(0)
                        $("#city_code_submit ~ .form-error").remove();
                        $("#total_after_discount").html('You have no discount in')
                    }
                    else if( response.please_select ){
                        $('#city_code_submit').parent().append('<p class="no-amount mb-0">'+ response.please_select +'</p>');
                        $("#discount_amount").val(0)
                        $("#city_code_submit ~ .form-error").remove();
                        $("#total_after_discount").html('You have no discount in')
                    }
                    else{
                        $('#city_code_submit').parent().append('<p class="discount-success mb-0">Congratulations you have got 15% off. Your amount after discount is '+ response.discount_amount +' BDT</p>');
                        $("#discount_amount").val(response.discount_amount)
                        $("#total_after_discount").html(response.discount_amount)
                        $("#city_code_submit ~ .form-error").remove();
                        $("#city_code_submit ~ .no-amount").remove();
                    }
                    
                },
                error: function(e){

                }
            })
            if(e.target.nextElementSibling){
                e.target.nextElementSibling.remove();
            }
            
        }else{
            $('#city_code_submit').parent().append('<p class="form-error mb-0"><small class="danger text-muted">Invalid Code</small></p>');
            $("#city_code_submit ~ .discount-success").remove();
            $("#city_code_submit ~ .discount-failed").remove();
            $("#total_after_discount").html('You have no discount in')
            $("#discount_amount").val(0)
        }
    })
});


//bogo ebl start
$(document).ready(function(){
    $("#ebl_card_submit").click(function(e){
        let card = $("#ebl_card").val();
        let amount = $("#total").html();
        let menu = $("#menu_id").val();
        let adult = $("#adult").val();
        let date = $("#start_date").val();
        if(date){
            if( adult > 1 ){
                if(card.length >= 16){
                    $.ajax({
                        type: $(this).attr('data-method'),
                        url: '/ebl/bogo/'+ card +'/'+ amount + '/' + menu + '/' + date,
                        data: card,
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: function(response){
                            if( response.select_menu ){
                                $("#ebl_card_submit ~ .form-error").remove();
                                $("#ebl_card_submit ~ .bogo-success").remove();
                                $("#discount_amount").val(0)
                                $("#ebl_card_submit").parent().append('<p class="form-error mb-0"><small class="danger text-muted">'+ response.select_menu +'</small></p>')
                                $("#total_after_discount").html('You have no discount in')
                            }
                            else if( response.bogo_failed ){
                                $("#ebl_card_submit ~ .form-error").remove();
                                $("#ebl_card_submit ~ .bogo-success").remove();
                                $("#discount_amount").val(0)
                                $("#ebl_card_submit").parent().append('<p class="form-error mb-0"><small class="danger text-muted">'+ response.bogo_failed +'</small></p>')
                                $("#total_after_discount").html('You have no discount in')
                            }
                            else if( response.already_taken ){
                                $("#ebl_card_submit ~ .form-error").remove();
                                $("#ebl_card_submit ~ .bogo-success").remove();
                                $("#discount_amount").val(0)
                                $("#ebl_card_submit").parent().append('<p class="form-error mb-0"><small class="danger text-muted">'+ response.already_taken +'</small></p>')
                                $("#total_after_discount").html('You have no discount in')
                            }
                            else{
                                $("#ebl_card_submit ~ .form-error").remove();
                                $("#ebl_card_submit ~ .bogo-success").remove();
                                $("#ebl_card_submit").parent().append('<p class="bogo-success mb-0">Congratulations You have got a bogo offer. Your Total Amount is '+ response.bogo_success +' BDT</p>')
                                $("#discount_amount").val(response.bogo_success)
                                console.log(response.discount_amount)
                                $("#total_after_discount").html(response.bogo_success)
                            }
                        },
                        error: function(error){
        
                        }
                    })
                }
                else{
                    $("#ebl_card_submit ~ .form-error").remove();
                    $("#ebl_card_submit ~ .bogo-success").remove();
                    $("#discount_amount").val(0)
                    $("#ebl_card_submit").parent().append('<p class="form-error mb-0"><small class="danger text-muted">Invalid Card Number</small></p>')
                    $("#total_after_discount").html('You have no discount in')
                }
            }
            else{
                $("#ebl_card_submit ~ .form-error").remove();
                $("#ebl_card_submit ~ .bogo-success").remove();
                $("#discount_amount").val(0)
                $("#ebl_card_submit").parent().append('<p class="form-error mb-0"><small class="danger text-muted">Please Select Adult More Than One</small></p>')
                $("#total_after_discount").html('You have no discount in')
            }
        }else{
            $("#ebl_card_submit ~ .form-error").remove();
                $("#ebl_card_submit ~ .bogo-success").remove();
                $("#discount_amount").val(0)
                $("#ebl_card_submit").parent().append('<p class="form-error mb-0"><small class="danger text-muted">Please Select Booking Date</small></p>')
                $("#total_after_discount").html('You have no discount in')
        }

        
        
    })
})



//bogo brac bank card start
$(document).ready(function(){
    $("#brac_bank_card_submit").click(function(e){
        let card = $("#brac_bank_card").val();
        let amount = $("#total").html();
        let menu = $("#menu_id").val();
        let adult = $("#adult").val();
        let date = $("#start_date").val();
        
        if( date ){
            if( adult > 1 ){
                if(card.length == 16){
                    $.ajax({
                        type: $(this).attr('data-method'),
                        url: '/brac_bank/bogo/'+ card +'/'+ amount + '/' + menu + '/' + date,
                        data: card,
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: function(response){
                            if( response.select_menu ){
                                $("#brac_bank_card_submit ~ .form-error").remove();
                                $("#brac_bank_card_submit ~ .bogo-success").remove();
                                $("#discount_amount").val(0)
                                $("#brac_bank_card_submit").parent().append('<p class="form-error mb-0"><small class="danger text-muted">'+ response.select_menu +'</small></p>')
                                $("#total_after_discount").html('You have no discount in')
                            }
                            else if( response.bogo_failed ){
                                $("#brac_bank_card_submit ~ .form-error").remove();
                                $("#brac_bank_card_submit ~ .bogo-success").remove();
                                $("#discount_amount").val(0)
                                $("#brac_bank_card_submit").parent().append('<p class="form-error mb-0"><small class="danger text-muted">'+ response.bogo_failed +'</small></p>')
                                $("#total_after_discount").html('You have no discount in')
                            }
                            else if( response.already_taken ){
                                $("#brac_bank_card_submit ~ .form-error").remove();
                                $("#brac_bank_card_submit ~ .bogo-success").remove();
                                $("#discount_amount").val(0)
                                $("#brac_bank_card_submit").parent().append('<p class="form-error mb-0"><small class="danger text-muted">'+ response.already_taken +'</small></p>')
                                $("#total_after_discount").html('You have no discount in')
                            }
                            else{
                                $("#brac_bank_card_submit ~ .form-error").remove();
                                $("#brac_bank_card_submit ~ .bogo-success").remove();
                                $("#brac_bank_card_submit").parent().append('<p class="bogo-success mb-0">Congratulations You have got a bogo offer. Your Total Amount is '+ response.bogo_success +' BDT</p>')
                                $("#discount_amount").val(response.bogo_success)
                                $("#total_after_discount").html(response.bogo_success)
                            }
                        },
                        error: function(error){
        
                        }
                    })
                }else{
                    $("#brac_bank_card_submit ~ .form-error").remove();
                    $("#brac_bank_card_submit ~ .bogo-success").remove();
                    $("#discount_amount").val(0)
                    $("#brac_bank_card_submit").parent().append('<p class="form-error mb-0"><small class="danger text-muted">Invalid Card Number</small></p>')
                    $("#total_after_discount").html('You have no discount in')
                }
            }
            else{
                $("#brac_bank_card_submit ~ .form-error").remove();
                $("#brac_bank_card_submit ~ .bogo-success").remove();
                $("#discount_amount").val(0)
                $("#brac_bank_card_submit").parent().append('<p class="form-error mb-0"><small class="danger text-muted">Please Select Adult More Than One </small></p>')
                $("#total_after_discount").html('You have no discount in')
            }
        }else{
            $("#brac_bank_card_submit ~ .form-error").remove();
            $("#brac_bank_card_submit ~ .bogo-success").remove();
            $("#discount_amount").val(0)
            $("#brac_bank_card_submit").parent().append('<p class="form-error mb-0"><small class="danger text-muted">Please Select Booking Date </small></p>')
            $("#total_after_discount").html('You have no discount in')
        }
        
        
    })
})





$(document).ready(function(){
    $("#gp_star").on("click", function(e){
        if( e.target.checked == true ){
            $("#get_code_gp_star").show();
            $("#get_code_city_gem").hide();
            $("#get_bogo_ebl").hide();
            $("#get_bogo_bracbank").hide();

            $("#gp_code").val('')
            $("#discount_amount").val(0)
            $("#total_after_discount").html('You have no discount in')
            $("#gp_code_submit ~ .discount-success").remove();
            $("#gp_code_submit ~ .discount-failed").remove();
            $("#gp_code_submit ~ .form-error").remove();
            $("#gp_code_submit ~ .no-amount").remove();


        }
    })
    $("#city_gem").on("click", function(e){
        if( e.target.checked == true ){
            $("#get_code_gp_star").hide();
            $("#get_code_city_gem").show();
            $("#get_bogo_ebl").hide();
            $("#get_bogo_bracbank").hide();

            $("#city_code").val('')
            $("#discount_amount").val(0)
            $("#total_after_discount").html('You have no discount in')
            $("#city_code_submit ~ .discount-success").remove();
            $("#city_code_submit ~ .discount-failed").remove();
            $("#city_code_submit ~ .form-error").remove();
        }
    })
    $("#ebl").on('click', function(e){
        if( e.target.checked == true ){
            $("#get_code_gp_star").hide();
            $("#get_code_city_gem").hide();
            $("#get_bogo_amex").hide();
            $("#get_bogo_bracbank").hide();
            $("#get_bogo_ebl").show();
            

            $("#ebl_card").val('')
            $("#discount_amount").val(0)
            $("#total_after_discount").html('You have no discount in')
            $("#ebl_card_submit ~ .bogo-success").remove();
            $("#ebl_card_submit ~ .form-error").remove();
            $("#ebl_card_submit ~ .no-amount").remove();
        }
    })

    $("#brac_bank").click(function(e){
        if( e.target.checked == true ){
            $("#get_code_gp_star").hide();
            $("#get_code_city_gem").hide();
            $("#get_bogo_amex").hide();
            $("#get_bogo_ebl").hide();
            $("#get_bogo_bracbank").show();

            $("#brac_bank_card").val('')
            $("#discount_amount").val(0)
            $("#total_after_discount").html('You have no discount in')
            $("#brac_bank_card_submit ~ .bogo-success").remove();
            $("#brac_bank_card_submit ~ .form-error").remove();
            $("#brac_bank_card_submit ~ .no-amount").remove();
        }
    })
})



$("#close_reservation_info").click(function(){
    $(".reservation_info").hide();
    $('html,body').css({
        'overflow' : 'auto',
    })
})



$('.banner-carousel').owlCarousel({
    loop:true,
    nav:false,
    dots:true,
    autoplay:false,
    autoplayTimeout:7000,
    autoplayHoverPause:false,
        responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})

$('.event-carousel').owlCarousel({
    loop:true,
    nav:false,
    dots:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:3
        }
    }
})

$(document).ready(function(){
    $(window).scroll(function(){
        if($(window).scrollTop() > 10){
            $(".nav-header").css({
                "background" : "rgba(1,1,1,0.6)",
                "transition" : "0.4s ease-in-out"
            })
        }
        else{
            $(".nav-header").css({
                "background" : "unset"
            })
        }
    })
})


$(document).ready(function(){
    $(".onspot").click(function(){
        $(".onspot").addClass('active-reservation');
        $(".online").removeClass('active-reservation');

        $(".on-spot-reservation-form").show();
        $(".online-reservation-form").hide();
    })
    $(".online").click(function(){
        $(".onspot").removeClass('active-reservation');
        $(".online").addClass('active-reservation');

        $(".on-spot-reservation-form").hide();
        $(".online-reservation-form").show();
    })

    $(".payment-modal-button").click(function(){
        $(".payment-modal").show();
        $(".nav-header").css({
            "zIndex": "0"
        })
    })

    $("#popup-close").click(function(){
        $("#popup-section").remove();
        $('body').css({
            "overflow" : "auto"
        })
    })
})





$(document).ready(function(){
    jQuery('input[name="booking_date"]').on('change', function(){
        var booking_date = jQuery(this).val()
        if( booking_date ){
            $.ajax({
                url : 'dynamic_dependent/'+ booking_date,
                type : "GET",
                dataType : "JSON",
                success : function(data){
                    price = data
                   
                    $('select[name="menu_id"]').empty();
                    $('select[name="menu_id"]').append('<option>Please Select Your Time</option>');
                    $.each(data, function(key, value){
                        $('select[name="menu_id"]').append('<option value="'+value.id+'" data-price="'+value.price+'"  id="menu_price" >'+value.name + ' ' + '( ' + value.price + 'BDT' + ' )' + '</option>');
                    })
                }
            })
        }
    })
})



document.onkeydown = function(e) {
    if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
        return false;
    }
    if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
        return false;
    }
}
document.addEventListener('contextmenu', e => e.preventDefault())
