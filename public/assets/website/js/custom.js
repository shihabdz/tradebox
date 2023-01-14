obj   = JSON.parse(BDTASK.phrase());
theme = JSON.parse(BDTASK.theme());
$(function($){
	"use strict";
    //index coin-stream inline js start
    $('#deposit_amount_block').hide();
    $('#deposit_with_block').hide();
    $('#payment_block').hide();
    $('#waletfield').hide(); 
    if(path == ""){
	    //Ajax Subscription index
	    $("#subscribeForm").on("submit", function(event) {
	        event.preventDefault();
	        var inputdata = $("#subscribeForm").serialize();
	        var email 	  = $('input[name=subscribe_email]').val();

	        if (email == "") {
	            allert_warning('warning', obj['please_enter_valid_email'][langusge]);
	            return false;
	        }
	        if (!isValidEmailAddress(email)) {
	        	allert_warning('warning', obj['please_enter_valid_email'][langusge]);
	            return false;
	        }
	        $.ajax({
	            url: BDTASK.getSiteAction('subscribe'),
	            type: "post",
	            data: inputdata,
	            success: function(result,status,xhr) {
	                allert_warning('success',"Subscribtion complete");
	                location.reload();
	            },
	            error: function (xhr,status,error) {
	                if (xhr.status === 500) {
	                	allert_warning('warning', obj['already_subscribe'][langusge]);
	                }
	            }
	        });
	    });
	}
	if(path == "profile-verify"){
		$("#verify_type").on("change", function(event) {
            event.preventDefault();
            var verify_type = $("#verify_type").val();
            if (verify_type == 'passport') {
                $("#verify_field").html("<div class='form-group row'><label for='document1' class='col-md-4 col-form-label'>Passport Cover </label><div class='col-md-8'><input name='document1' type='file' class='form-control' id='document1' required></div></div><div class='form-group row'><label for='document2' class='col-md-4 col-form-label'>Passport Inner </label><div class='col-md-8'><input name='document2' type='file' class='form-control' id='document2' required></div></div>");
            } else if (verify_type == 'driving_license') {
                $("#verify_field").html("<div class='form-group row'><label for='document1' class='col-md-4 col-form-label'>Driving License </label><div class='col-md-8'><input name='document1' type='file' class='form-control' id='document1' required></div></div>");
            } else if (verify_type == 'nid') {
                $("#verify_field").html("<div class='form-group row'><label for='document1' class='col-md-4 col-form-label'>NID With selfie </label><div class='col-md-8'><input name='document1' type='file' class='form-control' id='document1' required></div></div>");
            } else {
                $("#verify_field").html();
            }
        });
	}
	if(path == "register"){

		var myInput = document.getElementById("pass");
        var letter  = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var special = document.getElementById("special");
        var number  = document.getElementById("number");
        var length  = document.getElementById("length");

        myInput.onfocus = function() {
            document.getElementById("message").style.display = "block";
        }
        myInput.onblur = function() {
            document.getElementById("message").style.display = "none";
        }

        myInput.onkeyup = function() {

          var lowerCaseLetters = /[a-z]/g;
          if(myInput.value.match(lowerCaseLetters)) {  
            letter.classList.remove("invalid");
            letter.classList.add("valid");
          } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
          }

          var upperCaseLetters = /[A-Z]/g;
          if(myInput.value.match(upperCaseLetters)) {  
            capital.classList.remove("invalid");
            capital.classList.add("valid");
          } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
          }

          var specialCharacter = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/g;
          if(myInput.value.match(specialCharacter)) {  
            special.classList.remove("invalid");
            special.classList.add("valid");
          } else {
            special.classList.remove("valid");
            special.classList.add("invalid");
          }

          var numbers = /[0-9]/g;
          if(myInput.value.match(numbers)) {  
            number.classList.remove("invalid");
            number.classList.add("valid");
          } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
          }

          if(myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
          } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
          }
        }
        //Registration From validation check
    //user the bracket end of segment
	}

    window.onscroll = function () {

      scrollFunction();
    };

  
    $("#btn-back-to-top").on('click', function(){            
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
    });

   
	// Ajax Contract From
	$("body").on("submit","#contactForm", function(event) {
		event.preventDefault();

		var first_name  = $('#first_name').val();
		var email   	= $('#email').val();
		var phone   	= $('#phone').val();
		var comment 	= $('#comment').val();
		if(first_name == ""){
			allert_warning('warning', obj['first_name'][langusge]);
			return false;
		} else if(phone == ""){
			allert_warning('warning', obj['phone_required'][langusge]);
			return false;
		} else if (email == "") {
			allert_warning('warning', obj['email_required'][langusge]);
			return false;
		} else if (comment == "") {
			allert_warning('warning', obj['comments_required'][langusge]);
			return false;
		}

		var inputdata = $("#contactForm").serialize();

		$.ajax({
			url: BDTASK.getSiteAction("home/contactMsg"),
			type: "post",
			data: inputdata,
			success: function(d) {

				allert_warning('success',obj['message_send_successfuly'][langusge]); 
				location.reload();
			},
			error: function(){
				allert_warning('error', obj['message_send_fail'][langusge]);
			}
		});
	});

	//Ajax Language Change start
	$("#lang-change").on("change", function(event) {
        event.preventDefault();     
        var inputdata = {};
            inputdata[BDTASK.csrf_token()] = BDTASK.csrf_hash();
            inputdata['lang']              = $("#lang-change").val();

        $.ajax({
            url: BDTASK.getSiteAction('langChange'),
            type: "post",
            data: inputdata,
            success: function(result,status,xhr) {
                location.reload();
            },
            error: function(xhr,status,error){
                location.reload();
            }
        });
    });
	//Ajax Language Change end

//deposit inline js start
if (path == "deposit") {

	$("#deposit_type").on("change", function(event) {	

				var deposit_type = $("#deposit_type").val() || 0;
				$.getJSON(BDTASK.getSiteAction("get-coin/" + deposit_type), function(data) {
					var htmlCoin = "<option>" + obj['select_option'][langusge] + "</option>";
					$.each(data.coin_list, function(index, element) {
						htmlCoin += "<option value=" + element.symbol + " >" + element.full_name + "("+  element.symbol +")</option>";
					});
					$("#crypto_coin").html(htmlCoin);

				});



				if (deposit_type == 'crypto_deposit') {
					$("#coinlabel").empty();
					$("#coinlabel").append(obj['coin'][langusge] + '<span class="text-danger">*</span>');
					$("#depositmethodlabel").empty();
					$("#depositmethodlabel").append(obj['deposit_network'][langusge] + '<span class="text-danger">*</span>');
					$('#deposit_amount').removeAttr('required');
					$('#deposit_amount_block').hide();
					$('#deposit_with_block').show();


					$("#crypto_coin").on("change", function(event) {
						var crypto_coin = $("#crypto_coin").val() || 0;
						$.getJSON(BDTASK.getSiteAction("get-payment-method/" + deposit_type), function(data) {
							var htmlGateway = "<option>" + obj['deposit_method'][langusge] + "</option>";
							$.each(data.payment_gateway, function(index, v) {
								//if(v.identity != "bitcoin" && v.identity != "coinpayment"){
								htmlGateway += "<option value=" + v.identifire + " >" + v.heading + "</option>";
								//}
							});
							$("#payment_method").html(htmlGateway);
						});
					});


				} else {					
					$("#coinlabel").empty();
					$("#coinlabel").append(obj['currency'][langusge] + '<span class="text-danger">*</span>');
					$("#depositmethodlabel").empty();
					$("#depositmethodlabel").append(obj['deposit_method'][langusge] + '<span class="text-danger">*</span>');
					$('#deposit_amount').attr('required',true);
					$('#deposit_amount_block').show();
					$('#deposit_with').removeAttr('required');
					$('#deposit_with_block').hide();
					$('#payment_block').show();

					$("#crypto_coin").on("change", function(event) {
						var crypto_coin = $("#crypto_coin").val() || 0;
						$.getJSON(BDTASK.getSiteAction("get-payment-method/" + deposit_type), function(data) {
							var htmlGateway = "<option>" + obj['deposit_method'][langusge] + "</option>";
							$.each(data.payment_gateway, function(index, v) {
								//if(v.identity != "bitcoin" && v.identity != "coinpayment"){
								htmlGateway += "<option value=" + v.identity + " >" + v.agent + "</option>";
								//}
							});
							$("#payment_method").html(htmlGateway);
						});
					});

				}


				$("#deposit_with").on("change", function(event) {
					event.preventDefault();
					$("#notavailable").html('');
					var deposit_type = $("#deposit_type").val() || 0;
					var crypto_coin = $("#crypto_coin").val() || 0;
					var deposit_with = $("#deposit_with").val() || 0;
					if(deposit_with != "blockchain_network") {
						$('#deposit_amount').attr('required',true);
					    $('#deposit_amount_block').show();
						$("#depositmethodlabel").empty();
					    $("#depositmethodlabel").append(obj['deposit_method'][langusge] + '<span class="text-danger">*</span>');
					    var htmlGateway = "<option>" + obj['deposit_method'][langusge] + "</option>";
					} else {
						$("#depositmethodlabel").empty();
						$("#depositmethodlabel").append(obj['deposit_network'][langusge] + '<span class="text-danger">*</span>');
						$('#deposit_amount').removeAttr('required');
					    $('#deposit_amount_block').hide();
					    var htmlGateway = "<option>" + obj['deposit_network'][langusge] + "</option>";

					}

					$.getJSON(BDTASK.getSiteAction("get-payment-network/" + deposit_with + "/" + crypto_coin), function(data) {						
						$.each(data.payment_gateway, function(index, v) {
							if (deposit_with == "blockchain_network") {
								htmlGateway += "<option value=" + v.identifire + " >" + v.heading + "</option>";
							} else {

                               	var coinarray = v.coinlist.split(',').map(element => element.trim()).filter(element => element !== '');
								if (coinarray.includes(crypto_coin)) {
									htmlGateway += "<option value=" + v.identity + " >" + v.agent + "</option>";
								}
							}
						});
						if (data.payment_gateway.length == 0) {
							$("#notavailable").html('<i class="fa fa-info-circle"></i>  ' + obj['coin_not_supported'][langusge]);
						}

						$("#payment_method").html(htmlGateway);
					});

					$('#payment_block').show();

				});

				$("#payment_method").on("change", function(event) {
					event.preventDefault();
					var payment_method = $("#payment_method").val() || 0;
					
					var deposit_type = $("#deposit_type").val() || 0;
					var deposit_with = $("#deposit_with").val() || 0;

					var gourl = "";
					if (deposit_type == 'crypto_deposit') {
						if (deposit_with == 'blockchain_network') {
							gourl = BDTASK.getSiteAction(payment_method + '/payment-gateway');
							$('#deposit_form').attr('action', gourl);
						} else {
							gourl = BDTASK.getSiteAction('deposit/payment_gateway');
							$('#deposit_form').attr('action', gourl);
						}

					} else {
						gourl = BDTASK.getSiteAction('deposit/payment_gateway');
						$('#deposit_form').attr('action', gourl);
					}

					 if (payment_method == 'token') {

						$(".payment_info").html("<div class='form-group'><label for='comment' class=''>Your Wallet</label><textarea class='form-control' name='comment' id='comment' rows='1'></textarea></div>");

					} else {

						$(".payment_info").html("<div class='form-group'><label for='comment' class=''>" + obj['comments'][langusge] + "</label><textarea class='form-control' name='comment' id='comment' rows='3'></textarea></div>");
					}
				});
				//deposit inline js end
				//end of segment condition

			});
}

	//deposit segment start
if(path == "deposit"){
	function Fee_deposit(method){
	            
	    var amount      = document.forms['deposit_form'].elements['amount'].value;
	    var method      = document.forms['deposit_form'].elements['method'].value;
	    var crypto_coin = document.forms['deposit_form'].elements['crypto_coin'].value;
	    var level       = document.forms['deposit_form'].elements['level'].value;

	    var inputdata = $("#deposit_form").serialize();

	    if (amount=="" || amount==0) {
	        $('#fee').text("Fees is "+0);
	    }
	    if (amount!="" && method!=""){
	        $.ajax({
	            url     : BDTASK.getSiteAction('fees-load'),
	            type    : 'POST', //the way you want to send data to your URL
	            data    : inputdata,
	            dataType: "JSON",
	            success : function(data) { 
	                if(data){
	                    $('[name="fees"]').val(data.fees);
	                    $('#fee').text("Fees is "+data.fees);              
	                } else {
	                    alert('Error!');
	                }  
	            }
	        });
	    } 
	}
}
//deposit segment end


// start withdraw section
if(path == "withdraw"){
		$("#withdraw_type").on("change", function(event){
			var withdraw_type = $("#withdraw_type").val()|| 0;
			    $('#amount').val('');
				$('#fees').val(0);
				$('#fee').html("");  
				 
				$.getJSON(BDTASK.getSiteAction("get-coin/" + withdraw_type), function(data) {
					var htmlCoin = "<option>" + obj['select_option'][langusge] + "</option>";
					$.each(data.coin_list, function(index, element) {
						htmlCoin += "<option value=" + element.symbol + " >" + element.full_name + "("+  element.symbol +")</option>";
					});
					$("#crypto_coin").html(htmlCoin);

				});



				if (withdraw_type == 'crypto_currency') {
					$('#walletidis').html(""); 
					$("#coinlabel").empty();
					$("#coinlabel").append(obj['coin'][langusge] + '<span class="text-danger">*</span>');
					$("#depositmethodlabel").empty();
					$("#depositmethodlabel").append(obj['deposit_network'][langusge] + '<span class="text-danger">*</span>');
                    
					$("#payment_method").attr("placeholder", obj['deposit_network'][langusge] );
				
					$('#deposit_with_block').show();

					$("#crypto_coin").on("change", function(event) {
						var crypto_coin = $("#crypto_coin").val() || 0;
						$.getJSON(BDTASK.getSiteAction("get-payment-method-widthraw/" + withdraw_type+'/'+ crypto_coin), function(data) {
							$('#amount').val(data.balance );
							$('#fees').val(data.fees);
							$('#fee').html(obj['fees'][langusge] +': ' + data.fees + ' ' + obj['receivable_amount'][langusge] +' '+ data.amount);  
							var htmlGateway = "<option>" + obj['withdraw_method'][langusge] + "</option>";
							$.each(data.payment_gateway, function(index, v) {								
								htmlGateway += "<option value=" + v.identifire + " >" + v.heading + "</option>";								
							});
							$("#payment_method").html(htmlGateway);
						});
					});


				} else {					
					$("#coinlabel").empty();
					$("#coinlabel").append(obj['currency'][langusge] + '<span class="text-danger">*</span>');
					$("#depositmethodlabel").empty();
					$("#depositmethodlabel").append(obj['withdraw_method'][langusge] + '<span class="text-danger">*</span>');
					$("#payment_method").attr("placeholder", obj['withdraw_method'][langusge] );
					$('#walletid').removeAttr('required');
					$('#walletid').val('');
					$('#waletfield').hide();

					$('#withdraw_with').removeAttr('required');
					$('#deposit_with_block').hide();
					$('#payment_block').show();

					$("#crypto_coin").on("change", function(event) {
						var crypto_coin = $("#crypto_coin").val() || 0;
						$.getJSON(BDTASK.getSiteAction("get-payment-method-widthraw/" + withdraw_type+'/'+ crypto_coin), function(data) {

							$('#amount').val(data.balance );
							$('#fees').val(data.fees);
							$('#fee').html(obj['fees'][langusge] +': ' + data.fees + ' ' + obj['receivable_amount'][langusge] +' '+ data.amount);  
							var htmlGateway = "<option>" + obj['withdraw_method'][langusge] + "</option>";
							$.each(data.payment_gateway, function(index, v) {
								htmlGateway += "<option value=" + v.identity + " >" + v.agent + "</option>";								
							});
							$("#payment_method").html(htmlGateway);
						});
					});

				}


				$("#withdraw_with").on("change", function(event) {
					event.preventDefault();
					$("#notavailable").html('');
					var withdraw_type = $("#withdraw_type").val() || 0;
					var crypto_coin = $("#crypto_coin").val() || 0;
					var withdraw_with = $("#withdraw_with").val() || 0;

					$.getJSON(BDTASK.getSiteAction("get-payment-network/" + withdraw_with + "/" + crypto_coin), function(data) {
						if (withdraw_with == "blockchain_network") {
							$("#depositmethodlabel").empty();
							$("#depositmethodlabel").append(obj['deposit_network'][langusge] + '<span class="text-danger">*</span>');
					       var htmlGateway = "<option>" + obj['deposit_network'][langusge] + "</option>";
						} else {
							$("#depositmethodlabel").empty();
							$("#depositmethodlabel").append(obj['withdraw_method'][langusge] + '<span class="text-danger">*</span>');
						   var htmlGateway = "<option>" + obj['withdraw_method'][langusge] + "</option>";
						}

						$.each(data.payment_gateway, function(index, v) {
							if (withdraw_with == "blockchain_network") {
								htmlGateway += "<option value=" + v.identifire + " >" + v.heading + "</option>";
							} else {								
								var coinarray = v.coinlist.split(',');
								if (coinarray.includes(crypto_coin)) {
									htmlGateway += "<option value=" + v.identity + " >" + v.agent + "</option>";
								}
							}
						});
						if (data.payment_gateway.length == 0) {
							$("#notavailable").html('<i class="fa fa-info-circle"></i>  ' + obj['coin_not_supported_withdraw'][langusge]);
						}

						$("#payment_method").html(htmlGateway);
					});

					$('#payment_block').show();

				});

				$("#payment_method").on("change", function(event) {
					event.preventDefault();
					var payment_method = $("#payment_method").val() || 0;					

					var withdraw_type = $("#withdraw_type").val() || 0;
					var withdraw_with = $("#withdraw_with").val() || 0;

					var gourl = "";
					if (withdraw_type == 'crypto_currency') {
						if (withdraw_with == 'blockchain_network') {
							$('#walletid').attr('required', 'true');
							$('#walletid').val('');
							$('#waletfield').show();
							gourl = BDTASK.getSiteAction(payment_method + '/withdraw');
							$('#withdraw_form').attr('action', gourl);
						} else {
							$('#walletid').removeAttr('required');
							$('#walletid').val('');
							$('#waletfield').hide();
							gourl = BDTASK.getSiteAction('withdraw');
							$('#withdraw_form').attr('action', gourl);
						}

					} else {
						$('#walletid').removeAttr('required');
						$('#walletid').val('');
						$('#waletfield').hide();
						gourl = BDTASK.getSiteAction('withdraw');
						$('#withdraw_form').attr('action', gourl);
					}

					 if (payment_method == 'token') {

						$(".payment_info").html("<div class='form-group'><label for='comment' class=''>Your Wallet</label><textarea class='form-control' name='comment' id='comment' rows='1'></textarea></div>");

					} else {

						$(".payment_info").html("<div class='form-group'><label for='comment' class=''>" + obj['comments'][langusge] + "</label><textarea class='form-control' name='comment' id='comment' rows='3'></textarea></div>");
					}
				});
				//deposit inline js end
				//end of segment condition

			});
}

	//coinmarket js end
});

$(function(){
    "use strict";
    var info = $('table tbody tr');
    info.click(function() {
        var email    = $(this).children().first().text(); 
        var password = $(this).children().first().next().text();
        var user_role = $(this).attr('data-role');  

        $("input[name=luseremail]").val(email);
        $("input[name=lpassword]").val(password);
        $('select option[value='+user_role+']').attr("selected", "selected"); 
    });

    $('.footerHide').on('click', function(){
       $('#footer').hide();
    });

    $('.footerShow').on('click', function(){
       $('#footer').show();
    });
});
//Confirm Password check
function rePassword() {
    var pass = document.getElementById("pass").value;
    var r_pass = document.getElementById("r_pass").value;

    if (pass !== r_pass) {
        document.getElementById("r_pass").style.borderColor = '#f00';
        document.getElementById("r_pass").style.boxShadow = '0 0 0 0.2rem rgba(255, 0, 0,.25)';
        return false;
    }
    else{
        document.getElementById("r_pass").style.borderColor = '#ced4da';
        document.getElementById("r_pass").style.boxShadow = 'unset';
        return true;
    }
}

function validateForm() {

    var name     = document.forms["registerForm"]["rf_name"].value;
    var email    = document.forms["registerForm"]["remail"].value;
    var pass     = document.forms["registerForm"]["rpass"].value;
    var r_pass   = document.forms["registerForm"]["rr_pass"].value;
    var checkbox = document.forms["registerForm"]["accept_terms"].value;

    if (name == "") {

    	allert_warning('warning', obj['first_name_required'][langusge]);
        return false;
    } else if (email == "") {

        allert_warning('warning', obj['please_enter_valid_email'][langusge]);
        return false;

    } else if (pass == "") {

        allert_warning('warning', obj['password_required'][langusge]);
        return false;

    } else if (!pass.match(/[a-z]/)) {

		allert_warning('warning', obj['a_lowercase_letter'][langusge]);
		return false;

	} else if (!pass.match(/[A-Z]/)) {
		
		allert_warning('warning', obj['a_capital_uppercase_letter'][langusge]);
		return false;

	} else if (!pass.match(/\d/)) {

		allert_warning('warning', obj['a_number'][langusge]);
		return false;

	} else if (!pass.match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/g)) {

		allert_warning('warning', obj['a_special'][langusge]);
		return false;

	} else if (pass.length < 8) {

        allert_warning('warning', obj['please_enter_at_least_8_characters_input'][langusge]);
        return false;

    } else if (r_pass == "") {

        allert_warning('warning', obj['confirm_password_must_be_filled_out'][langusge]);
        return false;

    } else if ($('input[type="checkbox"]').prop("checked") != true) {

        allert_warning('warning', obj['must_confirm_privacy_policy_and_terms_and_conditions'][langusge]);
        return false;
    }
}
function allert_warning(type, message){

	toastr[type]("", message)
	toastr.options = {
	  "closeButton": true,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": false,
	  "positionClass": "toast-top-right",
	  "preventDuplicates": false,
	  "onclick": null,
	  "showDuration": "300",
	  "hideDuration": "1000",
	  "timeOut": "5000",
	  "extendedTimeOut": "1000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}
}
//Valid Email Address Check
function checkEmail() {
    var email = document.getElementById('email');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(email.value)) {
        document.getElementById("email").style.borderColor = '#f00';
        document.getElementById("email").style.boxShadow = '0 0 0 0.2rem rgba(255, 0, 0,.25)';
        return false;
    }
    else{
        document.getElementById("email").style.borderColor = '#ced4da';
        document.getElementById("email").style.boxShadow = 'unset';
        return true;
    }
}

function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return pattern.test(emailAddress);
}
//print a div
function printContent(el){
	var restorepage  = $('body').html();
	var printcontent = $('#' + el).clone();
	$('body').empty().html(printcontent);
	window.print();
	$('body').html(restorepage);
	location.reload();
}
//copy url clickbord
function copyFunction() {
  var copyText = document.getElementById("copyed");
  copyText.select();
  document.execCommand("Copy");
}
//deposit segment start
if(path == "deposit"){
	function Fee(method){
	            
	    var amount      = document.forms['deposit_form'].elements['amount'].value;
	    var method      = document.forms['deposit_form'].elements['method'].value;
	    var crypto_coin = document.forms['deposit_form'].elements['crypto_coin'].value;
	    var level       = document.forms['deposit_form'].elements['level'].value;

	    var inputdata = $("#deposit_form").serialize();

	    /*if (amount!="" || amount==0) {
	        $("#payment_method" ).prop("disabled", false);
	    }*/
	    if (amount=="" || amount==0) {
	        $('#fee').text("Fees is "+0);
	    }
	    if (amount!="" && method!=""){
	        $.ajax({
	            url     : BDTASK.getSiteAction('fees-load'),
	            type    : 'POST', //the way you want to send data to your URL
	            data    : inputdata,
	            dataType: "JSON",
	            success : function(data) { 
	                if(data){
	                    $('[name="fees"]').val(data.fees);
	                    $('#fee').text("Fees is "+data.fees);              
	                } else {
	                    alert('Error!');
	                }  
	            }
	        });
	    } 
	}
}
//deposit segment end

//withdraw confirm start
if(path == "withdraw"){
	function Fee(method){
        var amount      = document.forms['withdraw'].elements['amount'].value;
        var method      = document.forms['withdraw'].elements['method'].value;
        var crypto_coin = document.forms['withdraw'].elements['crypto_coin'].value;
        var level       = document.forms['withdraw'].elements['level'].value;
        var inputdata = $("#withdraw_form").serialize();
        
        if (amount=="" || amount==0) {
            $('#fee').text("Fees is "+0);
        }
        if (amount!="" && method!=""){
            $.ajax({
                url     : BDTASK.getSiteAction('fees-load'),
                type    : 'POST', //the way you want to send data to your URL
                data    : inputdata,
                dataType: "JSON",
                success : function(data) { 
                    if(data){
                        $('[name="fees"]').val(data.fees);
                        $('#fee').text("Fees is "+data.fees);                    
                    } else {
                        alert('Error!');
                    }  
                }
            });
        } 
    }

    function WalletId(method){  
    var withdraw_with  = $("#withdraw_with").val();  

      if (withdraw_with != "blockchain_network") {         

        var inputdata = $("#withdraw_form").serialize();
        console.log(" mehedi -----------",inputdata);

        $.ajax({
            url     : BDTASK.getSiteAction('get-wallet-id'),
            type    : 'POST', //the way you want to send data to your URL
            data    : inputdata,
            dataType:'JSON',
            success: function(data) { 
                if(data){
                    if (method=='bank') {
                        var bank = JSON.parse(data.wallet_id);
                        $('[name="walletid"]').val(data.wallet_id);
                        $('button[type=submit]').prop('disabled', false);
                        $('#walletidis').html("<small>Account Name: "+ bank.acc_name +"</small><br><small>Account No: "+ bank.acc_no +"</small><br><small>Branch Name: "+ bank.branch_name +"</small><br><small>SWIFT Code: "+ bank.swift_code +"</small><br><small>ABN No: "+ bank.abn_no +"</small><br><small>Country: "+ bank.country +"</small><br><small>Bank Name: "+ bank.bank_name +"</small><br>");
                    } else {
                        $('[name="walletid"]').val(data.wallet_id);
                        $('button[type=submit]').prop('disabled', false);
                        $('#walletidis').text('Your Account Id Is '+data.wallet_id);

                    };
                    $('#coinwallet').html("");
                    $('#walletidis').removeClass("text-danger");
	                $('#walletidis').addClass("text-success");
                } else {

                    if(method=='coinpayment' || method=='token'){
                        $('button[type=submit]').prop('disabled', false);
                        $('#coinwallet').html("<div class='form-group'><label for='amount'>Your Address</label><input class='form-control' name='wallet_address' type='text' id='wallet_address'></div>");
                        $('#walletidis').text('');

                    } else {
                        $('#coinwallet').html("");
                        $('button[type=submit]').prop('disabled', true);
                        $('#walletidis').text('Your have no withdrawal account');
                    }

                    $('#walletidis').removeClass("text-success");
	                $('#walletidis').addClass("text-danger");

                }  
            }
        });
     } else {
     	$('button[type=submit]').prop('disabled', false);
     }
    }
//end is if condition
}
function withdraw(id){

    var inputdata = $("#confirm_withdraw").serialize();
    swal({
        title: 'Please Wait......',
        type: 'warning',
        showConfirmButton: false,
        onOpen: function () {
            swal.showLoading();
        }
    });

    $.ajax({
        url: BDTASK.getSiteAction('withdraw-verify'),
        type: 'POST', //the way you want to send data to your URL
        data: inputdata+'&id='+id,
        dataType:'JSON',
        success: function(res) {
        	console.log('==============',res);

            if(res.status == 'success'){
                swal({
                    title: "Good job!",
                    text: res.msg,
                    type: "success",
                    showConfirmButton: false,
                    timer: 1500
                });

               window.location.href = BDTASK.getSiteAction('withdraw-details/'+res.wid);
                
            } else if(res.status == "fail"){
                swal({
                    title: "Wops!",
                    text: res.msg,
                    type: "error",
                    showConfirmButton: false,
                    timer: 1500
                });
 
                window.location.href = BDTASK.getSiteAction('withdraw-confirm/'+id);
            }
        }
    });
}
//withdraw confirm end
if(path == "transfer"){
	function ReciverChack(receiver_id){

        var inputdata = $("#transfer").serialize();

        $.ajax({
            url  : BDTASK.getSiteAction('checke-reciver-id'),
            type : 'POST', //the way you want to send data to your URL
            data : inputdata,
            success: function(data) {                    
                if(data!=0){
                    $('#receiver_id').css("border","1px green solid");
                    $('#receiver_alert').css("color","green");
                    $('button[type=submit]').prop('disabled', false);
                } else {
                    $('button[type=submit]').prop('disabled', true);
                    $('#receiver_id').css("border","1px red solid");
                    $('#receiver_alert').css("color","red");
                }  
            },
        });
    }
//this end is if condition
}
if(path == "transfer-confirm"){
	function transfer(id){

	    var inputdata = $("#transfer_confirm").serialize();
	    swal({
	        title: 'Please Wait......',
	        type: 'warning',
	        showConfirmButton: false,
	        onOpen: function () {
	            swal.showLoading();
	        }
	    });

	    $.ajax({
	        url: BDTASK.getSiteAction('transfer-verify'),
	        type: 'POST', //the way you want to send data to your URL
	        data: inputdata+'&id='+id,
	        success: function(response) { 

	            if(response != ''){
	                swal({
	                    title: "Good job!",
	                    text: "Your Custom Email Send Successfully",
	                    type: "success",
	                    showConfirmButton: false,
	                    timer: 1500,
	                });

	             	window.location.replace(BDTASK.getSiteAction('transfer_details/'+response));
	            } else {
	                swal({
	                    title: "Wops!",
	                    text: "Something Went Wrong, Please Try Again!",
	                    type: "error",
	                    showConfirmButton: false,
	                    timer: 1500
	                });
	            }
	        }
	    });
	}
}

$(document).ready(function () {
    //SlimScroll
    $('.markert-table, .history-table').slimScroll({
        height: '411px',
        color: theme.theme_color,
        allowPageScroll: true,
        size: '8px',
        distance: '0px'

    });
    $('.buyOrder, .sellOrder, .sellRequest').slimScroll({
        height: '454px',
        color: theme.theme_color,
        allowPageScroll: true,
        size: '8px',
        distance: '0px'
    });
    $('.notice').slimScroll({
        height: '358px',
        color: theme.theme_color,
        allowPageScroll: true,
        size: '8px',
        distance: '0px'
    });
    $('#live_chat_list').slimScroll({
        height: '300px',
        color: theme.theme_color,
        allowPageScroll: true,
        size: '8px',
        distance: '0px'
    });

 	if(path == ""){
	    var $particles_js = $('#banner_bg_effect');
	    if ($particles_js.length > 0) {
	        particlesJS('banner_bg_effect',
	        // Update your personal code.
	        {
	            "particles": {
	                "number": {
	                    "value": 120,
	                    "density": {
	                        "enable": true,
	                        "value_area": 800
	                    }
	                },
	                "color": {
	                    "value": theme.theme_color
	                },
	                "shape": {
	                    "type": "polygon",
	                    "stroke": {
	                        "width": 0,
	                        "color": "#000000"
	                    },
	                    "polygon": {
	                        "nb_sides": 5
	                    },
	                    "image": {
	                        "src": BDTASK.getSiteAction('img/github.svg'),
	                        "width": 100,
	                        "height": 100
	                    }
	                },
	                "opacity": {
	                    "value": 0.4,
	                    "random": false,
	                    "anim": {
	                        "enable": false,
	                        "speed": 1,
	                        "opacity_min": 0.1,
	                        "sync": false
	                    }
	                },
	                "size": {
	                    "value": 3,
	                    "random": true,
	                    "anim": {
	                        "enable": false,
	                        "speed": 40,
	                        "size_min": 0.1,
	                        "sync": false
	                    }
	                },
	                "line_linked": {
	                    "enable": true,
	                    "distance": 150,
	                    "color": theme.theme_color,
	                    "opacity": 0.1,
	                    "width": 1
	                },
	                "move": {
	                    "enable": true,
	                    "speed": 6,
	                    "direction": "none",
	                    "random": false,
	                    "straight": false,
	                    "out_mode": "out",
	                    "bounce": false,
	                    "attract": {
	                        "enable": false,
	                        "rotateX": 600,
	                        "rotateY": 1200
	                    }
	                }
	            },
	            "interactivity": {
	                "detect_on": "canvas",
	                "events": {
	                    "onhover": {
	                        "enable": true,
	                        "mode": "repulse"
	                    },
	                    "onclick": {
	                        "enable": true,
	                        "mode": "push"
	                    },
	                    "resize": true
	                },
	                "modes": {
	                    "grab": {
	                        "distance": 400,
	                        "line_linked": {
	                            "opacity": 1
	                        }
	                    },
	                    "bubble": {
	                        "distance": 400,
	                        "size": 40,
	                        "duration": 2,
	                        "opacity": 8,
	                        "speed": 3
	                    },
	                    "repulse": {
	                        "distance": 200,
	                        "duration": 0.4
	                    },
	                    "push": {
	                        "particles_nb": 4
	                    },
	                    "remove": {
	                        "particles_nb": 2
	                    }
	                }
	            },
	            "retina_detect": true
	        });
	    }
	}
});

$('#search_keyword').on('keyup', function(){

    var inputdata = {};
    inputdata[BDTASK.csrf_token()] = BDTASK.csrf_hash();
    inputdata['keyword']           = $('#search_keyword').val();

    $.ajax({
        url: BDTASK.getSiteAction("balance-search"),
        type: "post",
        data: inputdata,
        success: function(data) {

            console.log(data);

            $('#searchList').html(data);
           
        },
        error: function(){
           allert_warning('success',"no"); 
        }
    });
});

// When the user scrolls down 20px from the top of the document, show the button
function scrollFunction() {
  if (
    document.body.scrollTop > 20 ||
    document.documentElement.scrollTop > 20
  ) {
    $("#btn-back-to-top").show();
  } else {  	
    $("#btn-back-to-top").hide();    
  }
}
function widthdrawFee(){
	var amount      = $('#amount').val(); // document.forms['withdraw'].elements['amount'].value;
	var method      = $('#payment_method').val(); //  document.forms['withdraw'].elements['method'].value;
	var crypto_coin = $('#crypto_coin').val(); //document.forms['withdraw'].elements['crypto_coin'].value;
	var level       = $('#level').val(); //document.forms['withdraw'].elements['level'].value;

	var inputdata = $("#withdraw_form").serialize();
	
	if (amount=="" || amount==0) {
		$('#fee').html("Fees is "+0);
	}
	if (amount!="" && method!=""){
		$.ajax({
			url     : BDTASK.getSiteAction('fees-load'),
			type    : 'POST', //the way you want to send data to your URL
			data    : inputdata,
			dataType: "JSON",
			success : function(data) { 

				if(data){
					// $('#fees').val(data.fees);
					$('#fee').html("");  					
					$('#fees').val(data.fees);
					$('#fee').html(obj['fees'][langusge] +': ' + data.fees +  ' ' +obj['receivable_amount'][langusge] +' '+ data.amount);                
				} else {
					alert('Error!');
				}  
			}
		});
	} 
}
function calculateFee(){

	var amount      = $('#deposit_amount').val(); // document.forms['deposit_form'].elements['amount'].value;
	var method      = $('#payment_method').val(); //  document.forms['deposit_form'].elements['method'].value;
	var crypto_coin = $('#crypto_coin').val(); //document.forms['deposit_form'].elements['crypto_coin'].value;
	var level       = $('#level').val(); //document.forms['deposit_form'].elements['level'].value;	   

	var inputdata = $("#deposit_form").serialize();
	
	
	if (amount=="" || amount==0) {
		$('#fee').html("Fees is "+0);
	}
	if (amount!="" && method!=""){
		$.ajax({
			url     : BDTASK.getSiteAction('fees-load'),
			type    : 'POST', //the way you want to send data to your URL
			data    : inputdata,
			dataType: "JSON",
			success : function(data) { 					
				if(data){
					$('#fees').val(data.fees);
					$('#fee').html("Fees is "+data.fees);              
				} else {
					alert('Error!');
				}  
			}
		});
	} 
}
if(path == "edit-profile"){
	var input = document.querySelector("#phone");
	window.intlTelInput(input, {
	  nationalMode: false,
	  hiddenInput: "phonenumber",
	  utilsScript: "public/assets/website/build/js/utils.js",
	});
}
function getCurrentURL () {
  return window.location.href
}