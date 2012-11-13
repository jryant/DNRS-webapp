<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
    <title>Health Survey | Dynamic Neural Retraining System&trade;</title>
	<meta charset="utf-8">
	<script src="includes/global.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="lib/jquery.tools.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="lib/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="lib/jquery-ui-1.8.18.custom.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="lib/jquery.numeric.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="css/styles.css" type="text/css" charset="utf-8" />
	<!-- <link rel="stylesheet" href="css/date.css" type="text/css"> -->
	<link rel="stylesheet" href="css/jquery-ui-1.8.18.custom.css" type="text/css" charset="utf-8" />
	<?php /*
		if(isset($page) && $page=="survey"){ ?>
			<script>
				$(document).ready(function(){
					$("#program_start_date").dateinput({
						format: 'yyyy-mm-dd'
					});	
				});
			</script>
		<?php }
	*/ ?>
	
	<script language="JavaScript">
	<!--
	// var sURL = unescape(window.location.pathname);
	var sURL = window.location.href;
	sURL = sURL.substring(sURL.indexOf("?"),0);
	function refresh(){
	    window.location.href = sURL;
	}
	//-->
	</script>

	<script language="JavaScript1.1">
	<!--
	function refresh(){
	    window.location.replace( sURL );
	}
	//-->
	</script>

	<script language="JavaScript1.2">
	<!--
	function refresh(){
	    window.location.reload( true );
	}
	//-->
	</script>
	
	<script>	
		$(document).ready(function(){
			// $("#program_start_date").dateinput({
			// 	format: 'yyyy-mm-dd'
			// });

			$("#program_start_date").datepicker({
				showOn: "button",
				buttonImage: "img/redmond/calendar.gif",
				buttonImageOnly: true,
				dateFormat: 'yy-mm-dd',
				showOn: 'both'
			});
						
			$("#age").numeric();
			
			var wizard = $("#survey");
			
			$("#survey").show(); //css("display","block");
			$("ul.tabs").tabs("#survey .section");
			
			// $("#survey .section input:radio").click(function(event, index){
			// 	var q = $(this).val();
			// 	console.log(q + " changed");
			// });
			
			
			$("ul.tabs", wizard).tabs("#survey .section:eq(0)", function(event, index){
				// var error = false;
				// var q1 = $("input:radio[name=program_method]");
				// if(index > 0 && !q1.get(0).checked){
				// 	q1.parent().addClass("error");
				// 	error = true;
				// } else {
				// 	q1.parent().removeClass("error");
				// }
				// 
				// var q2 = $("input[name=program_start_date]").val();
				// if(index > 0 && !q2){
				// 	$("input[name=program_start_date]").parent().addClass("error");
				// 	error = true;
				// } else {
				// 	$("input[name=program_start_date]").parent().removeClass("error");
				// }
				// 
				// if(error){
				// 	return false;
				// }
			});
			
			// var valres = $("#survey .section:eq(0) input").validate();
			// console.log(valres);
			$("ul.tabs", wizard).tabs("#survey .section", function(event, index){
				// var error = 0;
				// console.log("Index: "+index);
				// if(index!=0){
					// var section = $("#survey .section:eq("+index+")");
					// $("#survey .section:eq("+index+") input:radio").each(function(){
					// 	if($(this).get(0).checked){
					// 		$(this).parent().removeClass("error");
					// 	} else {
					// 		$(this).parent().addClass("error");
					// 		error++;
					// 	}
					// });
					
					// var section = "#survey .section:eq("+index+") ";
					// var total = $(section+"input").length/5;
					// var checked = $(section+"input:checked").length;
					// console.log(checked + "/" + total);
					// if (checked==total){
					// 	error = 0;
					// 	return true;
					// } else {
					// 	// $("#survey .section:eq("+index+") input").not(":checked").each(function(){
					// 	// 						$(this).parent().addClass("error");
					// 	// 					});
					// 	error = 1;
					// }
				// }
				// if(error>0){
				// 	console.log("Error! "+error);
				// 	// return false;
				// }
			});
			
			// $("#survey .section input").click(function(event, index){
			// 	if(!$(this).get(0).checked){
			// 		$(this).parent().addClass("error");
			// 	} else {
			// 		$(this).parent().removeClass("error");
			// 	}
			// });
			
			// 	// var section = $("#survey .section").eq(index);
			// 	$("#survey .section:eq("+index+") input:radio").each(function(){
			// 		error = false;
			// 		if($(this).is(":checked")){
			// 			error = false;
			// 			// var q = $(this).val();
			// 			// console.log(q + " is checked");
			// 		} else {
			// 			error = true;
			// 		}
			// 
					// console.log(this);
			// 		if(error){
			// 			return false;
			// 			$(this).parent().addClass("error");
			// 		}
			// 
				// });
				// var qs = $(section+" input");
				// console.log(qs);
				
				// var program_method = $("input[name=program_method]");
				// if(index > 0 && !program_method.get(0).checked){
				// if(!$("input[name=program_method]:checked").val()){
				// 	$("input[name=program_method]").parent().addClass("error");
				// 	return false;
				// }
				// console.log(program_method);
			// });

			$("#survey .guide .term span").hover(function(){
				var term = $(this).attr('id');
				// console.log(term);
				$("#survey .guide .term span").removeClass("active");
				$("#survey .guide .term #"+term).addClass("active");
				$("#survey .guide .def").css("display","none");
				$("#s"+term).css("display","block");
			});
			
			// $("#cond2, #cond3").hide();
						
			// $(".cond").each(function(index){
				// var num = index + 1;
				var num = "-m";
				$("#cond"+num+" input").change(function(index){
					if($("#cond"+num+" input.other").is(':checked')){
						$("#cond"+num+" input[type=text]").attr('disabled',false);
						$("#cond"+num+" input[type=text]").focus();
						var ans = $("#cond"+num+" input[type=text]").val();
						$("#cond-m_other_chk, #cond-s_other, #cond-s_other_radio").val(ans);
						// $("#cond-s li").append("<li><input onChange=\"checkInput('cond-s');\" type=\"radio\" value=\""+ans+"\"> "+ans+"</li>\n");
					}
					else {
						$("#cond"+num+" input[type=text]").attr('disabled',true);
						$("#cond"+num+" input[type=text]").val('');
						var ans = $("#cond"+num+" input:checked").val();
						// $("#cond-s li").append("<li><input onChange=\"checkInput('cond-s');\" type=\"radio\" value=\""+ans+"\"> "+ans+"</li>\n");
					}
					// if($("#cond"+num+" .ans").html()!=""){
					// 	$("#cond"+num+" .ans").append(", "+ans);
					// } else {
					// 	$("#cond"+num+" .ans").html(ans);
					// }
					// console.log(index);
				});
			// });

			$("#referral input").change(function(){
				if($("#referral input.other").is(':checked')){
					$("#referral input[type=text]").attr('disabled',false);
					$("#referral input[type=text]").focus();
					var ans = $("#referral input[type=text]").val();
				}
				else {
					$("#referral input[type=text]").attr('disabled',true);
					$("#referral input[type=text]").val('');
					var ans = $("#referral input:checked").val();
				}
				$("#referral .ans").html(ans);
			});
			
			$(".cond_res input[type=checkbox]").change(function(){
				var value = $(this).val();
				var query = "<?php echo $_SERVER['QUERY_STRING']; ?>";
				// console.log(query);
			});
			
			var api = $("ul.tabs", wizard).data("tabs");
			
			// "next tab" button
			// $(".next", wizard).click(function(event, index) {
			$(".next").click(function(){
				// var id = $(this).attr("id");
				// var id_str = id.split("");
				// var id_int = parseInt(id_str[1]);
				// id_int++;
				// var pid = "p"+id_int;
				var pid = $(this).attr("id");
				// console.log("Section: "+pid);
				var section = $("#survey ."+pid);
				// var valres = $("#survey ."+id+" input").validate();
				// console.log(valres);
				if(pid!="p1"){
					var inputs = [];
					$("#survey ."+pid+" .qline").each(function(){ // 
						var thisname = $(this).attr("id");
						// if (inputs.indexOf(thisname) != -1){
							// console.log("true");
						// } else {
							inputs.push(thisname);
						// }
						// if($(this + "").get(0).checked){
						// 	$(this).parent().removeClass("error");
						// } else {
						// 	$(this).parent().addClass("error");
						// 	// console.log($(this).attr("name"));
						// 	// error++;
						// }
						// var result = $(this).get(0).checked;
						// console.log($(this).attr("name") + " - " + result);

					});
					var error = 0;
					$(inputs).each(function(index){
						// console.log(inputs[index]);
						if(!$("#"+inputs[index]+" .radios input:checked").val()){
							// console.log(inputs[index]+" is unchecked");
							$("#"+inputs[index]).addClass("error");
							error++;
						} else {
							// console.log(inputs[index]+" CHECKED");
							$("#"+inputs[index]).removeClass("error");
						}
					});
					// error = 0; // DEBUG
					if(error==0){
						api.next();
						return false;
					}
					else {
						$("#error_"+pid).css("display","block");
						// console.log(error +" errors cannot continue");
					}
				} else {	
					var section = $(this).parent().parent();
					if($(section).hasClass("pre_survey")){
						var inputs = ["cond-m","cond-s","cond-duration","referral","program_method","program_start","gender","age"]; // debug - add location error checking
					}
					else if ($(section).hasClass("follow_up")){
						var inputs = ["practicing"];
					}
					var error = validate(inputs);
					if(error==0){
						api.next();
						return false;
					}
					else {
						$("#error_"+pid).css("display","block");
						// console.log(error +" errors cannot continue");
					}
				}
			});

			// "previous tab" button
			$(".prev", wizard).click(function() {
				$(".msg_error").css("display","none");
				api.prev();
				return false;
			});
			
		});

		function validate(inputs){
			var error = 0;
			$(inputs).each(function(index){
				if(inputs[index]=="age"){
					var age = $("#"+inputs[index]+" input").val();
					console.log(age);
					if(age<1 || age==""){
						$("#"+inputs[index]).addClass("error");
						error++;
					} else {
						// console.log("#"+inputs[index]+" CHECKED");
						$("#"+inputs[index]).removeClass("error");
					}												
				} else {
					if(!$("#"+inputs[index]+" input:checked").val()){
						// console.log("#"+inputs[index]+" is unchecked");
						$("#"+inputs[index]).addClass("error");
						error++;
					} else {
						// console.log("#"+inputs[index]+" CHECKED");
						$("#"+inputs[index]).removeClass("error");
					}							
				}
			});
			return error;
		}

		function checkInput(q){
			var qname = q;
			$("#"+qname).removeClass("error");
			// console.log(qname);
		}

		// function checkBtns(p){
		// 	console.log("checkBtns: "+p);
		// 	// var section = $("#survey .section:eq("+index+")");
		// 	// $("#survey .section:eq("+index+") input:radio").each(function(){
		// 	// 	if($(this).get(0).checked){
		// 	// 		$(this).parent().removeClass("error");
		// 	// 	} else {
		// 	// 		$(this).parent().addClass("error");
		// 	// 		error++;
		// 	// 	}
		// 	// });
		// 	$("ul.tabs", "#survey").data("tabs").next();
		// }
		
		/* Reveal condition questions in initial survey */
		function cond_expand(num){
			$("a."+num).hide();
			$("#"+num).show();
		}
		
		/* Login form */
		function submitLogin(){
			$('#output').html("");
			var user = $('.user').val();
			if(!user){
				$('#output').append("Please enter your username.<br/>");
			}
			var pass = $('.pass').val();
			if(!pass){
				$('#output').append("Please enter your password.<br/>");
			}
			// console.log("user = "+user+" / pass = "+pass);
			$('#busy').css("visibility", "visible");
			// $('.buttonSubmit', this).attr('disabled', 'disabled');
			$.ajax({
				url: "login.php",
				type: "POST",
				data: "user="+user+"&pass="+pass,
				success: function(html){
					if(html=="1"){
						// window.location = "index.php";
						// console.log("Login success!");
						refresh();
					}
					else {
						$('#busy').css("visibility", "hidden");
						$('#output').html("<div class=\"msg_error\"><ul><li>"+html+"</li></ul></div>");
					}
				}
			});			
		};
		
		// function swapForm(){
		// 	$.ajax({
		// 		url: "register.php",
		// 		type: "POST",
		// 		success: function(html){
		// 			$('#login').fadeOut('slow',function(){
		// 				$(this).html(html)
		// 			}).fadeIn('slow');	
		// 		}
		// 	});
		// 	$('#register').fadeIn('slow');				
		// }
		
		/* Registration form */
		var checkUname = false;
		var checkPass = false;
		var checkFirst = false;
		var checkLast = false;
		var checkEmail = false;
		function checkUsername(){
			var username = $('#username').val();
			var error = false;
			var msg = "";
			if (username==""){
				msg = "Username cannot be blank.";
				error = true;
			} else if (username.length < 3){
				msg = "Username cannot be less than 3 characters.";
				error = true;
			}
			else {
				$('.username .busy').show();
				$.ajax({
					url: "ajax.php",
					type: "POST",
					data: "action=checkUsername&username="+username,
					success: function(html){
						$('#register .username .busy').hide();
						if(html==0){
							msg = "Sorry, that username is taken.";
							error = true; // DEBUG
						}
						else if(html==1){
							msg = "That username is available.";
							error = false;
							checkUname = true;
						}
						$('.username .msg').html(msg);
					}
				});
			}
			if (error){
				$('.username input').addClass("error");
			} else {
				$('.username input').removeClass("error");
			}
			$('.username .msg').html(msg);
		}
		
		function checkPassMatch(){
			var pass1 = $('#pass1').val();
			var pass2 = $('#pass2').val();
			var msg = "";
			var error = false;
			if (pass1=="" && pass2==""){
				msg = "Password cannot be blank";
				error = true;
			}
			else {
				if (pass1==pass2){
					msg = "Passwords match";
					error = false;
				}
				else {
					msg = "Passwords do not match";
					error = true;
				}
			}
			if (error){
				$('.password input').addClass("error");
			} else {
				$('.password input').removeClass("error");
				checkPass = true;
			}
			$('.password .msg').html(msg);
		}
		
		function checkName(name){
			var msg = "";
			var error = false;
			var nameSeg = $('#'+name).val();
			var namePrint = name.replace(/^(.)|\s(.)/g, function($1){ return $1.toUpperCase( ); });			
			if(nameSeg==""){
				msg = namePrint + " name cannot be blank.";
				error = true;
				// console.log(namePrint + " = " + window["check"+namePrint]);
			} else {
				msg = "";
				error = false;
				// console.log(namePrint + " = " + window["check"+namePrint]);
			}
			if (error){
				$('.'+name+' input').addClass("error");
				window["check"+namePrint] = false; // DEBUG
			} else {
				$('.'+name+' input').removeClass("error");
				window["check"+namePrint] = true;
			}
			$('.'+name+' .msg').html(msg);
			// console.log(checkFirst + " " + checkLast);
			// console.log(nameSeg);
		}
		
		function validateEmail(){
			var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
			var email = $('#email').val();
			var result = pattern.test(email);
			var error = false;
			var msg = "";
			// console.log(result);
			if (!result){
				msg = "Not a valid email address.";
				error = true;
			}
			else {
				msg = "Valid email address."
				error = false;
			}
			if (error){
				$('.email input').addClass("error");
				checkEmail = false;
			}
			else {
				$('.email input').removeClass("error");
				checkEmail = true;
			}
			$('.email .msg').html(msg);
		}
		
		function checkForm(){
			// if(checks==5){
			// console.log("uname = " + checkUname + " / pass = " + checkPass + " / first = " + checkFirst + " / last = " + checkLast + " / email = " + checkEmail);
			if( checkUname && checkPass && checkFirst && checkLast && checkEmail
				// ($('.username input').hasClass("error") || $('.username input').val()=="") ||
				// ($('.password input').hasClass("error") || $('#pass2').val()=="") ||
				// ($('.email input').hasClass("error") || $('.email input').val()=="")
			){
				$("#submit").attr("disabled", false);
				// console.log('form complete!');
				return true;
			} else {
				$("#submit").attr("disabled", true);
				// console.log('form incomplete');
				return false;
			}
		}
		
		function register(){
			var username = $('#username').val();
			var password = $('#pass_conf').val();
			var first_name = $('#firstname').val();
			var last_name = $('#lastname').val();
			var email = $('#email').val();
			// console.log("register me!");
			$.ajax({
				url: "ajax.php",
				type: "POST",
				data: "action=register"
				+"&username="+username
				+"&password="+password
				+"&first_name="+first_name
				+"&last_name="+last_name
				+"&email="+email,
				success: function(html){
					// console.log(html);
				}
			});
		}
		
		function invite(){
			var email = $("#email").val();
			$.ajax({
				url: "ajax.php",
				type: "POST",
				data: "action=invite&email="+email,
				success: function(html){
					$("#output").append(html);
				}
			});
			// console.log(email);
		}
		
		function getCity(country_code){
			$("#city").html("<img src=\"img/ajax-loader.gif\">");
			country_code = country_code.toLowerCase();
			console.log(country_code);
			// var strURL="findCity.php?country="+countryId;
			$.ajax({
				url: "ajax.php",
				type: "POST",
				data: "action=findcity&country_code="+country_code,
				success: function(html){
					$("#city").html(html);
					console.log(html);
				}
			});
		  // var req = getXMLHTTP();
		  // if (req)
		  // {
		  //   req.onreadystatechange = function()
		  //   {
		  //     if (req.readyState == 4) // only if "OK"
		  //     {
		  //       if (req.status == 200)
		  //       {
		  //         document.getElementById('citydiv').innerHTML=req.responseText;
		  //       } else {
		  //         alert("There was a problem while using XMLHTTP:\n" + req.statusText);
		  //       }
		  //     }
		  //   }
		  //   req.open("GET", strURL, true);
		  //   req.send(null);
		  // }
		}
		
		function showDatepicker(){
			var $dp = $("#program_start_date").datepicker();
			$dp.datepicker("show");
		}
		
		function selectStarted(){
			$("#started").attr("checked","checked");
		}
		
	</script>
</head>
<body id="body">
	<div id="container">