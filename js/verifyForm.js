function checkPasswordMatch(){
	var password = $("#passwordReg").val();
    var confirmPassword = $("#passwordRegConfirm").val();
    if (password != confirmPassword && confirmPassword != ""){
        $("#divCheckPasswordMatch").html("Passwords do not match!");
    	alert("Oops! Please make sure that your passwords are matching.");
    }
    else{
        $("#divCheckPasswordMatch").html("Passwords match.");
    }
}
