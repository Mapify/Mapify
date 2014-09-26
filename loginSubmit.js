$('#loginForm').submit(function () {
  alert("form submitted");
  var un = document.getElementById("usernameInput").value;
  var pw = document.getElementById("passwordInput").value;
  alert(un + typeof(un) + ", " + pw + typeof(pw));
  userLogin(un);
  return false;
});

function userLogin(username) {
  if (username=="") {
    document.getElementById("resultsDiv").innerHTML="No username entered.";
    return;
  }
  alert("username contained something");
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("resultsDiv").innerHTML=xmlhttp.responseText;
    }
  }
  alert("ready to send request");
  //xmlhttp.open("GET","sqlConnect.php?q=" + un + "&r=" + pn, true);
  xmlhttp.open("GET","sqlConnect.php?q=" + username, true);
  xmlhttp.send();
  alert("sent request");
}