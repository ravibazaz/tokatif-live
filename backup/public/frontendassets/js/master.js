var base_url = $("#base_url").val();

$(document).ready(function(){
   
    
    
});

function validateEmail(email) {
var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
return re.test(email);
                }

//For User Registration


  $('#user_phone_number').keypress(function(e) {
  //   console.log(event.which);
      if(event.which != 8 && isNaN(String.fromCharCode(event.which)))
        {
            event.preventDefault();
         }
    });


  $('#verificationcode').keypress(function(e) {
	//   console.log(event.which);
		if(event.which != 8 && isNaN(String.fromCharCode(event.which)))
		  {
			  event.preventDefault();
		   }
	});



$("#register_form_submit").submit(function(event){
    event.preventDefault();
    var token = $("input[name=_token]").val();
    var user_name = $("#user_name").val();
    var user_email = $("#user_email").val();
    // var user_phone_number = $("#user_phone_number").val();
    var user_password = $("#user_password").val();
    var confirm_password = $("#confirm_password").val();
    var $form = $(this);

    url = $form.attr('action');
    
    
    if(user_name == "")
    {
       $("#error_message")
			.html("Enter Your Username please.")
			.css("color", "red");
		setTimeout(function() {
			$("#error_message").html("");
		}, 5000);
		$("#user_name").focus();
		return false;
    }

    if (user_email == "") {
		$("#error_message")
			.html("Enter email address please.")
			.css("color", "red");
		setTimeout(function() {
			$("#error_message").html("");
		}, 5000);
		$("#user_email").focus();
		return false;
	}

	if (!validateEmail(user_email)) {
		$("#error_message").html("Enter valid Email id.").css("color", "red");
		setTimeout(function() {
			$("#error_message").html("");
		}, 5000);
		$("#user_email").focus();
		return false;
	}
    
    if(user_password == "")
    {
       $("#error_message")
			.html("Enter Your Passowrd please.")
			.css("color", "red");
		setTimeout(function() {
			$("#error_message").html("");
		}, 5000);
		$("#user_password").focus();
		return false;
    }
    
    if(confirm_password == "")
    {
       $("#error_message")
			.html("Enter Your Confirm Passowrd please.")
			.css("color", "red");
		setTimeout(function() {
			$("#error_message").html("");
		}, 5000);
		$("#confirm_password").focus();
		return false;
    }
    
    if(confirm_password != user_password){
        $("#error_message").html('Confirm Password does not match your Password');
        $("#error_message").css('color','red');
        $("#confirm_password").focus();
        return;
    }
    
    $.ajax({
		type: "POST",
		url: url,
		data: {
            _token:token,
			user_name:user_name,
            user_email:user_email,
            user_password:confirm_password
        },
		success: function(res) {
			console.log(res);
			res = JSON.parse(res);

			if (res.status == 200) {

				$("#error_message")
				.html(res.message)
				.css("color", "green");
				setTimeout(function() {
			  $("#error_message").html("");
				}, 5000);
				// window.location.href = "{{route{'registeruser'}}}";

				clearmsgemail()

			} else if(res.status == 202)
			{
				$("#error_message")
				.html(res.message)
				.css("color", "red");
				setTimeout(function() {
			  $("#error_message").html("");
				}, 5000);
			}else {
				/*$("#messageforcart").modal("show");*/
			}
		},
		error: function(msg) {
			console.log("errorrrr" + JSON.stringify(msg));
		}
	});
    
});


function clearmsgemail()
{
	$("#user_name").val("");
    $("#user_email").val("");
    $("#user_password").val("");
    $("#confirm_password").val("");
    $("#verificationcode").val("");
}


function sendcode_mail()
{
	var token = $("input[name=_token]").val();
	var user_email = $("#user_email").val();
	if (user_email == "") {
		$("#error_message_mail_verify")
			.html("Enter email address please.")
			.css("color", "red");
		setTimeout(function() {
			$("#error_message_mail_verify").html("");
		}, 5000);
		$("#user_email").focus();
		return false;
	}

	if (!validateEmail(user_email)) {
		$("#error_message_mail_verify").html("Enter valid Email id.").css("color", "red");
		setTimeout(function() {
			$("#error_message_mail_verify").html("");
		}, 5000);
		$("#user_email").focus();
		return false;
	}



	$.ajax({
		type: "POST",
		url: base_url+'/sendcode',
		data: {
			_token:token,
            user_email:user_email,
        },
		success: function(res) {
			console.log(res);
			res = JSON.parse(res);

			if (res.status == 200) {
				$("#message_code")
				.html(res.message)
				.css("color", "green");
				setTimeout(function() {
			  $("#message_code").html("");
				}, 5000);
                
              $("#code_received_email").removeClass('disabled');
			} else if(res.status == 201) 
			
			{
				$("#message_code")
				.html(res.message)
				.css("color", "red");
				setTimeout(function() {
			  $("#message_code").html("");
				}, 5000);
				/*$("#messageforcart").modal("show");*/
			}
			
		},
		error: function(msg) {
			console.log("errorrrr" + JSON.stringify(msg));
		}
	});

}

//verifycode

function verify_code()
{
	var token = $("input[name=_token]").val();
	var verificationcode = $("#verificationcode").val();



	if(verificationcode == "")
	{
			$("#message_code")
			.html("Enter Verification Code please.")
			.css("color", "red");
			setTimeout(function() {
			$("#message_code").html("");
			}, 5000);
			$("#verificationcode").focus();
			return false;
	}



	$.ajax({
		type: "POST",
		url: base_url+'/verifycode',
		data: {
			_token:token,
            verificationcode:verificationcode,
        },
		success: function(res) {
			console.log(res);
			res = JSON.parse(res);

			if (res.status == 200) {
				$("#message_code")
				.html(res.message)
				.css("color", "green");
				setTimeout(function() {
			  $("#message_code").html("");
				}, 5000);
			} else if(res.status == 201) 
			
			{
				$("#message_code")
				.html(res.message)
				.css("color", "red");
				setTimeout(function() {
			  $("#message_code").html("");
				}, 5000);
				/*$("#messageforcart").modal("show");*/
			}
		},
		error: function(msg) {
			console.log("errorrrr" + JSON.stringify(msg));
		}
	});

}


//phone register area

function verify_code_phone()
{
	var token = $("input[name=_token]").val();
	var verification_code_phone = $("#verification_code_phone").val();
	

	if(verification_code_phone == "")
	{
			$("#message_code_phone")
			.html("Enter Verification Code please.")
			.css("color", "red");
			setTimeout(function() {
			$("#message_code_phone").html("");
			}, 5000);
			$("#verification_code_phone").focus();
			return false;
	}



	$.ajax({
		type: "POST",
		url: base_url+'/verifycodephone',
		data: {
			_token:token,
            verification_code_phone:verification_code_phone,
        },
		success: function(res) {
			console.log(res);
			res = JSON.parse(res);

			if (res.status == 200) {
				$("#message_code_phone")
				.html(res.message)
				.css("color", "green");
				setTimeout(function() {
			  $("#message_code_phone").html("");
				}, 5000);
			} else if(res.status == 201) 
			
			{
				$("#message_code_phone")
				.html(res.message)
				.css("color", "red");
				setTimeout(function() {
			  $("#message_code_phone").html("");
				}, 5000);
				/*$("#messageforcart").modal("show");*/
			}
		},
		error: function(msg) {
			console.log("errorrrr" + JSON.stringify(msg));
		}
	});

}


function sendcode_phone()
{
	var token = $("input[name=_token]").val();
	var phone_number = $("#phone_number").val();
	if (phone_number == "") {
		$("#error_message_phone_verify")
			.html("Enter Phone Number please.")
			.css("color", "red");
		setTimeout(function() {
			$("#error_message_phone_verify").html("");
		}, 5000);
		$("#phone_number").focus();
		return false;
	}





	$.ajax({
		type: "POST",
		url: base_url+'/sendcodephone',
		data: {
			_token:token,
            phone_number:phone_number,
        },
		success: function(res) {
			console.log(res);
			res = JSON.parse(res);

			if (res.status == 200) {
				$("#message_code_phone")
				.html(res.message)
				.css("color", "green");
				setTimeout(function() {
			  $("#message_code_phone").html("");
				}, 5000);
            // alert();
                $("#code_received_phn").removeClass('disabled');
             
			} else if(res.status == 201) 
			
			{
				$("#message_code_phone")
				.html(res.message)
				.css("color", "red");
				setTimeout(function() {
			  $("#message_code_phone").html("");
				}, 5000);
				/*$("#messageforcart").modal("show");*/
			}
			
		},
		error: function(msg) {
			console.log("errorrrr" + JSON.stringify(msg));
		}
	});

}


$("#register_form_submit_phone").submit(function(event){
    event.preventDefault();
    var token = $("input[name=_token]").val();
    var user_name_phone = $("#user_name_phone").val();
    var country_code = $("#country_code").val();
    var phone_number = $("#phone_number").val();
    var user_password = $("#user_password_phone").val();
    var confirm_password = $("#confirm_password_phone").val();
    var $form = $(this);

    url = $form.attr('action');
    
    
    if(user_name_phone == "")
    {
       $("#error_message_phone")
			.html("Enter Your Username please.")
			.css("color", "red");
		setTimeout(function() {
			$("#error_message_phone").html("");
		}, 5000);
		$("#user_name_phone").focus();
		return false;
    }

	if(phone_number == "")
    {
       $("#error_message_phone")
			.html("Enter Your Phone Number please.")
			.css("color", "red");
		setTimeout(function() {
			$("#error_message_phone").html("");
		}, 5000);
		$("#user_password").focus();
		return false;
    }

	
    
    if(user_password == "")
    {
       $("#error_message_phone")
			.html("Enter Your Passowrd please.")
			.css("color", "red");
		setTimeout(function() {
			$("#error_message_phone").html("");
		}, 5000);
		$("#user_password_phone").focus();
		return false;
    }
    
    if(confirm_password == "")
    {
       $("#error_message_phone")
			.html("Enter Your Confirm Passowrd please.")
			.css("color", "red");
		setTimeout(function() {
			$("#error_message_phone").html("");
		}, 5000);
		$("#confirm_password_phone").focus();
		return false;
    }
    
    if(confirm_password != user_password){
        $("#error_message_phone").html('Confirm Password does not match your Password');
        $("#error_message_phone").css('color','red');
        $("#confirm_password_phone").focus();
        return;
    }
    
    $.ajax({
		type: "POST",
		url: url,
		data: {
            _token:token,
			user_name_phone:user_name_phone,
			country_code:country_code,
            phone_number:phone_number,
            user_password:user_password
        },
		success: function(res) {
			console.log(res);
			res = JSON.parse(res);

			if (res.status == 200) {

				$("#error_message_phone")
				.html(res.message)
				.css("color", "green");
				setTimeout(function() {
			  $("#error_message_phone").html("");
				}, 5000);
				clearmsgphone()
				// window.location.href = "{{route{'registeruser'}}}";
			} else if(res.status == 202)
			{
				$("#error_message_phone")
				.html(res.message)
				.css("color", "red");
				setTimeout(function() {
			  $("#error_message_phone").html("");
				}, 5000);
			}else {
				/*$("#messageforcart").modal("show");*/
			}
		},
		error: function(msg) {
			console.log("errorrrr" + JSON.stringify(msg));
		}
	});
    
});


function clearmsgphone()
{
	 $("#user_name_phone").val("");
    //  $("#country_code").val("");
     $("#phone_number").val("");
     $("#user_password_phone").val("");
     $("#confirm_password_phone").val("");
     $("#verification_code_phone").val("");
	 
}

// login user function

$("#loginuser").submit(function(event){
    event.preventDefault();
    var token = $("input[name=_token]").val();
    var user_name = $("#user_name").val();
    var password = $("#password").val();
    var $form = $(this);

    url = $form.attr('action');
    
    
    if(user_name == "")
    {
       $("#login_message")
			.html("Enter Phone Number / Email.")
			.css("color", "white");
		setTimeout(function() {
			$("#login_message").html("");
		}, 5000);
		$("#user_name").focus();
		return false;
    }

    if (password == "") {
		$("#login_message")
			.html("Enter Password please.")
			.css("color", "white");
		setTimeout(function() {
			$("#login_message").html("");
		}, 5000);
		$("#password").focus();
		return false;
	}


    
    $.ajax({
		type: "POST",
		url: url,
		data: {
            _token:token,
			user_name:user_name,
            password:password
        },
		success: function(res) {
			console.log(res);
			res = JSON.parse(res);

			if (res.status == 200) {

				$("#login_message")
				.html(res.message)
				.css("color", "white");
				setTimeout(function() {
			  $("#login_message").html("");
				}, 5000);
				// window.location.href = "{{route{'registeruser'}}}";

			//	clearmsgemail()

			} else if(res.status == 201)
			{
				$("#login_message")
				.html(res.message)
				.css("color", "white");
				setTimeout(function() {
			  $("#login_message").html("");
				}, 5000);
			}else {
				/*$("#messageforcart").modal("show");*/
			}
		},
		error: function(msg) {
			console.log("errorrrr" + JSON.stringify(msg));
		}
	});
    
});


//For User Registration

$("#resetpassword").submit(function(event){
    event.preventDefault();
    var token = $("input[name=_token]").val();
    var new_password = $("#new_password").val();
    var repeat_password = $("#repeat_password").val();
    var $form = $(this);

    url = $form.attr('action');
    
    
	if(new_password == "")
    {
       $("#error_message")
			.html("Enter Your Passowrd please.")
			.css("color", "red");
		setTimeout(function() {
			$("#error_message").html("");
		}, 5000);
		$("#new_password").focus();
		return false;
    }
    
    if(repeat_password == "")
    {
       $("#error_message")
			.html("Enter Your Confirm Passowrd please.")
			.css("color", "red");
		setTimeout(function() {
			$("#error_message").html("");
		}, 5000);
		$("#repeat_password").focus();
		return false;
    }
    
    if(new_password != repeat_password){
        $("#error_message").html('Confirm Password does not match your Password');
        $("#error_message").css('color','red');
		setTimeout(function() {
			$("#error_message").html("");
		}, 5000);
        $("#repeat_password").focus();
        return;
    }

    
    $.ajax({
		type: "POST",
		url: url,
		data: {
            _token:token,
			new_password:new_password,
            repeat_password:repeat_password
        },
		success: function(res) {
			console.log(res);
			res = JSON.parse(res);

			if (res.status == 200) {

				$("#error_message")
				.html(res.message)
				.css("color", "red");
				setTimeout(function() {
			  $("#error_message").html("");
				}, 5000);

				clearmsgepswd()

			} else if(res.status == 201)
			{
				$("#error_message")
				.html(res.message)
				.css("color", "white");
				setTimeout(function() {
			  $("#error_message").html("");
				}, 5000);
			}else {
				/*$("#messageforcart").modal("show");*/
			}
		},
		error: function(msg) {
			console.log("errorrrr" + JSON.stringify(msg));
		}
	});
    
});


function clearmsgepswd()
{
    $("#new_password").val("");
    $("#repeat_password").val("");
}



 

