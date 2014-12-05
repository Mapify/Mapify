<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mapify | User Registration</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="css/custom.css" />
    <script src="js/vendor/modernizr.js"></script>
  </head>
  <body>
    <?php
    session_start();
    //SET MAIN SESSION VARIABLES
    $_SESSION["clientUser"] = $_POST["emailRegInput"];
    $_SESSION["clientPWord"] = $_POST["pwordRegInput"];
    
    //SESSION VARIABLES READY TO SAVE
    $_SESSION["clientFName"] = $_POST["fNameInput"];
    $_SESSION["clientLName"] = $_POST["lNameInput"];
    $_SESSION["clientUID"] = "";

    //old,variables
    /*$clientUser = $_POST["emailRegInput"];
    $clientPWord = $_POST["pwordRegInput"];*/

    //PROTECT FROM MYSQL INJECTION
    $_SESSION["clientUser"] = stripslashes($_SESSION["clientUser"]);
    $_SESSION["clientPWord"] = stripslashes($_SESSION["clientPWord"]);

    $loginStatus = 0;

    //VARIABLES READY TO SAVE RESULTS
    /*$clientFName = $_POST["fNameInput"];
    $clientLName = $_POST["lNameInput"];
    $clientUID = "";*/

    //MYSQL SERVER LOGIN DETAILS
    $currIP=getHostByName(getHostName());
    if($currIP == "131.244.54.3"){
      $host="localhost";
    }
    else{
      $host="131.244.54.3";
    }

    //$host="131.244.54.3"; // for local testing
    //$host="localhost"; // for on server
    //$port=3306;
    $username = "13277172";
    $password = "13277172";
    $dbname="mappingDB";

    //connection to the database
    $con = mysql_connect($host, $username, $password, $dbname) 
      or die("..Unable to connect to MySQL");
    //echo "..Connected to MySQL<br>";

    //select a database to work with
    $selectedDB = mysql_select_db($dbname,$con) 
      or die("..Could not select examples");
    //echo "..Selected database: " . $dbname."<br><br>";

    $_SESSION["clientUser"] = mysql_real_escape_string($_SESSION["clientUser"]);
    $_SESSION["clientPWord"] = mysql_real_escape_string($_SESSION["clientPWord"]);
    $_SESSION["clientPWord"] = md5($_SESSION["clientPWord"]);

    $clientUser = $_SESSION["clientUser"];
    $clientPWord = $_SESSION["clientPWord"];
    $clientLName = $_SESSION["clientLName"];
    $clientFName = $_SESSION["clientFName"];

    //INSERT NEW USER VALUES INTO TABLE
    mysql_query("INSERT INTO Users (Email, PWord, LastName, FirstName)
    VALUES ('$clientUser', '$clientPWord', '$clientLName', '$clientFName')");

    //START SESSION
    $sql="SELECT * FROM Users WHERE Email = '$clientUser'";
    $verificationResult=mysql_query($sql);

    if(mysql_num_rows($verificationResult) == 0){
      //echo "..Login successful";
      $loginStatus = 1;
    }
    else{
      echo "This email already has a Mapify Account attached to it. Please choose another.";
      $loginStatus = 0;
    }

    //IF LOGIN SUCCESS SHOW USER DETAILS
    if($loginStatus == 1){
      //execute the SQL query and SELECT appropriate rows FROM appropriate TABLE
      $result = mysql_query("SELECT userID, PWord, LastName, FirstName FROM Users WHERE Email = '".$clientUser."'");
      //$result = mysql_query($con,$sql);

      //fetch the data from the database 
      while ($row = mysql_fetch_array($result)) {
        //echo "ID: ".$row{'userID'}.", Name: ".$row{'FirstName'}." ".$row{'LastName'}.", Address: ".$row{'Address'}.", Year: ".$row{'City'}."<br>"; //display the results
        $_SESSION["clientFName"] = $row['FirstName'];
        $_SESSION["clientLName"] = $row['LastName'];
        $_SESSION["clientUID"] = $row['userID']; 
      }
      $_SESSION["clientAge"] = "Empty";
      $_SESSION["clientCity"] = "Empty";
      header("Location: home.php");
    }
    //close the connection
    mysql_close($con);
    ?>

<script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <!--<script src="loginSubmit.js"></script>-->
    <script>
      $(document).foundation();
    </script>
  </body>
</html>