//navbar mob
$(document).ready(function(){
	$(".show-nav").click(function(){
		$(".left-sidebar").css({
			'display' : 'block',
			'width' : '100%'
		})
		$(".main-content").css({
			'display' : 'none',
		});
		$(".show-nav").hide();
		$(".hide-nav").show();
	})
	$(".hide-nav").click(function(){
		$(".left-sidebar").css({
			'display' : 'none',
			'width' : '0'
		})
		$(".main-content").css({
			'display' : 'block',
			'width' : '100%'

		});
		$(".show-nav").show();
		$(".hide-nav").hide();
	})
})

//navbar dropdown
$(document).ready(function(){
	$('.navbar-dropdown-top').click(function(){
		var navId = $(this).attr('id');
		if( navId != 'all'){
			$('.' + navId).slideToggle();
			
		}
	})
})


//filtering row
$(document).ready(function(){
	$(".filter-item").click(function(){
		var selectItem 	= $(this).attr('id');
		var selectRow 	= $(this).attr('id');
		if( selectItem != 'all' ){
			$(".filter-item").removeClass("active-item");
			$("." + selectItem).addClass("active-item");
		}
		if( selectRow != 'all' ){
			$(".filter-row").removeClass("active-row");
			$(".filter-row").removeClass("active-item");
			$("." + selectRow).addClass("active-row");
		}
	})
})

$('#image').change(function(){
          
    let reader = new FileReader();
    reader.onload = (e) => { 
    $('#image_preview_container').attr('src', e.target.result); 
    }
    reader.readAsDataURL(this.files[0]); 

});

$('#image2').change(function(){
          
    let reader = new FileReader();
    reader.onload = (e) => { 
    $('#image_preview_container_2').attr('src', e.target.result); 
    }
    reader.readAsDataURL(this.files[0]); 

});

$('#image3').change(function(){
          
    let reader = new FileReader();
    reader.onload = (e) => { 
    $('#image_preview_container_3').attr('src', e.target.result); 
    }
    reader.readAsDataURL(this.files[0]); 

});

window.onload = function(){
	$("input[type=search]").focus();
}
	

$(".chosen").chosen()



$(document).ready(function(){

	//validate bogo start
	$(".validate_bogo").click(function(e){
		let $this = $(this);
		let card_number = e.target.previousElementSibling.value;

		$(".check_bogo ~").remove();
		$(".check_bogo_brac ~").remove();
		$("#check_bogo_amex ~").remove();
		$("#apply_custom_discount ~").remove();
		
		$(".card_number").val('');
		$("#amex_card").val('');
		$(".card_number_brac").val('');
		$(".custom_discount").val('');

		if(card_number.length >= 16 ){
			$.ajax({
				type:  $this.attr('method'),
				url: '/validate/bogo/'+ card_number,
				data: card_number,
				contentType: false,
				processData: false,
				cache: false,
				success: function(response){
					if( response.validation_success ){
						$(".validate_bogo ~ .bogo-success").remove();
						$(".validate_bogo ~ .bogo-failed").remove();
						$(".validate_bogo").parent().append('<p class="bogo-success mb-0">'+response.validation_success+'</p>')
						$("#discount_price").val(0);
					}else if( response.validation_failed ){
						$(".validate_bogo ~ .bogo-success").remove();
						$(".validate_bogo ~ .bogo-failed").remove();
						$(".validate_bogo").parent().append('<p class="bogo-failed mb-0">'+ response.validation_failed +'</p>')
						$("#discount_price").val(0);
					}                
				},
				error: function(response){
					
				}
			})
		}
		else{
			$(".validate_bogo ~ .bogo-success").remove();
			$(".validate_bogo ~ .bogo-failed").remove();
			$(".validate_bogo").parent().append('<p class="bogo-failed mb-0">invalid Card Number</p>')
			$("#discount_price").val(0);
		}
	})

	//ebl
	$(".check_bogo").click(function(e){
		let $this = $(this);
		let card_number = e.target.previousElementSibling.value;
		
		let total_amount = $("#total_amount").val();
		let menu_price = $("#menu_price").val();
		let date = $("#reservation_date").val();

		$("#amex_card").val('');
		$(".card_number_brac").val('');
		$(".validate_card").val('');
		$(".custom_discount").val('');

		$(".validate_bogo ~").remove();
		$(".check_bogo_brac ~").remove();
		$("#check_bogo_amex ~").remove();
		$("#apply_custom_discount ~").remove();


		if(card_number.length >= 16 ){
			$.ajax({
				type:  $this.attr('method'),
				url: '/validate/ebl/'+ card_number+ '/bogo/'+menu_price+'/'+total_amount+'/'+date,
				data: card_number,
				contentType: false,
				processData: false,
				cache: false,
				success: function(response){
					if( response.validation_success ){
						$(".check_bogo ~ .bogo-success").remove();
						$(".check_bogo ~ .bogo-failed").remove();
						$(".check_bogo").parent().append('<p class="bogo-success mb-0"> He has got bogo offer from ebl. Grand Total After Discount is '+ response.validation_success +' BDT</p>')
						$("#discount_price").val(response.validation_success);
					}else if( response.validation_failed ){
						$(".check_bogo ~ .bogo-success").remove();
						$(".check_bogo ~ .bogo-failed").remove();
						$(".check_bogo").parent().append('<p class="bogo-failed mb-0">'+ response.validation_failed +'</p>')
						$("#discount_price").val(0);
					}                
				},
				error: function(response){
					
				}
			})
		}
		else{
			$(".check_bogo ~ .bogo-success").remove();
			$(".check_bogo ~ .bogo-failed").remove();
			$(".check_bogo").parent().append('<p class="bogo-failed mb-0">invalid Card Number</p>')
			$("#discount_price").val(0);
		}
		
	})

	//brac bank
	$(".check_bogo_brac").click(function(e){
		let $this = $(this);
		let card_number = e.target.previousElementSibling.value;

		let total_amount = $("#total_amount").val();
		let menu_price = $("#menu_price").val();
		let date = $("#reservation_date").val();

		$("#amex_card").val('');
		$(".card_number").val('');
		$(".validate_card").val('');
		$(".custom_discount").val('');

		$(".validate_bogo ~").remove();
		$(".check_bogo ~").remove();
		$("#check_bogo_amex ~").remove();
		$("#apply_custom_discount ~").remove();

		if(card_number.length >= 16){
			$.ajax({
				type:  $this.attr('method'),
				url: '/validate/brac/'+ card_number+ '/bogo/'+menu_price+'/'+total_amount+'/'+date,
				data: card_number,
				contentType: false,
				processData: false,
				cache: false,
				success: function(response){
					if( response.validation_success ){
						$(".check_bogo_brac ~ .bogo-success").remove();
						$(".check_bogo_brac ~ .bogo-failed").remove();
						$(".check_bogo_brac").parent().append('<p class="bogo-success mb-0"> He has got bogo offer from Brac Bank. Grand Total After Discount is '+ response.validation_success +' BDT</p>')
						$("#discount_price").val(response.validation_success);
					}else if( response.validation_failed ){
						$(".check_bogo_brac ~ .bogo-success").remove();
						$(".check_bogo_brac ~ .bogo-failed").remove();
						$(".check_bogo_brac").parent().append('<p class="bogo-failed mb-0">'+ response.validation_failed +'</p>')
						$("#discount_price").val(0);
					}                
				},
				error: function(response){
					
				}
			})
		}
		else{
			$(".check_bogo_brac ~ .bogo-success").remove();
			$(".check_bogo_brac ~ .bogo-failed").remove();
			$(".check_bogo_brac").parent().append('<p class="bogo-failed mb-0">invalid Card Number</p>')
			$("#discount_price").val(0);
		}
		
	})


	//amex check
	$("#check_bogo_amex").click(function(e){
		let $this = $(this);
		let amex_card_number = $("#amex_card").val();
		let total_amount = $("#total_amount").val();
		let menu_price = $("#menu_price").val();
		let reservation_date = $("#reservation_date").val();

		$(".card_number").val('');
		$(".card_number_brac").val('');
		$(".validate_card").val('');
		$(".custom_discount").val('');

		$(".validate_bogo ~").remove();
		$(".check_bogo ~").remove();
		$(".check_bogo_brac ~").remove();
		$("#apply_custom_discount ~").remove();

		
		if( amex_card_number.length  == 15 ){
			$.ajax({
				type: 'GET',
				url: '/validate/'+ amex_card_number+'/amex/'+menu_price+'/card/'+total_amount+'/date/'+reservation_date,
				contentType: false,
				processData: false,
				cache: false,
				success: function(response){
					if(response.already_exist){
						$("#check_bogo_amex ~ .bogo-success").remove();
						$("#check_bogo_amex ~ .bogo-failed").remove();
						$("#check_bogo_amex").parent().append('<p class="bogo-failed mb-0">'+response.already_exist+'</p>')
						$("#discount_price").val(0);
					}  
					else if(response.bogo_success){
						$("#check_bogo_amex ~ .bogo-success").remove();
						$("#check_bogo_amex ~ .bogo-failed").remove();
						$("#check_bogo_amex").parent().append('<p class="bogo-failed mb-0">He has got bogo offer from AmEx. Grand Total After Discount is '+response.bogo_success+' BDT</p>')
						$("#discount_price").val(response.bogo_success);
					}
				},
				error: function(response){
					
				}
			})
		}else{
			$("#check_bogo_amex ~ .bogo-success").remove();
			$("#check_bogo_amex ~ .bogo-failed").remove();
			$("#check_bogo_amex").parent().append('<p class="bogo-failed mb-0">invalid Card Number</p>')
			$("#discount_price").val(0);
		}
	})

	//custom discount start
	$("#apply_custom_discount").click(function(e){
		let discount_percent = e.target.previousElementSibling.value
		let $this = $(this);
		let total_amount = $("#total_amount").val();
		let new_amount; 

		$("#apply_custom_discount ~ .bogo-failed").remove();

		$(".card_number").val('');
		$(".card_number_brac").val('');
		$(".validate_card").val('');
		$("#amex_card").val('');

		$(".validate_bogo ~").remove();
		$(".check_bogo ~").remove();
		$(".check_bogo_brac ~").remove();
		$("#check_bogo_amex ~").remove();

		if( discount_percent > 100 ){
			$("#apply_custom_discount").parent().append('<p class="bogo-failed mb-0">Please give discount less than 100%</p>')
		}
		else if( discount_percent > 0 &&  discount_percent ){
			new_amount = Math.floor(total_amount - ( ( discount_percent / 100 ) * total_amount ));
			$("#discount_price").val(new_amount)
			$("#apply_custom_discount").parent().append('<p class="bogo-failed mb-0">'+discount_percent+'% discount successfully added. Grand total after discount is '+new_amount+' BDT</p>')
		}
		else{
			$("#discount_price").val(0);
			$("#apply_custom_discount").parent().append('<p class="bogo-failed mb-0">Please give discount more than 0%</p>')
		}
	})
	//custom discount end

})



$(document).on('click','[data-toggle="modal"]',function(e) {
	var target_modal_element = $(e.currentTarget).data('content');
	var target_modal = $(e.currentTarget).data('target');
 
	var modal = $(target_modal);
	var modalBody = $(target_modal + ' .modal-content');
 
	modalBody.load(target_modal_element,function(){
	    modal.modal({show:true});
	});
 });