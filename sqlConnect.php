<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mapify | User Profile</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
  </head>
  <body>
    <?php
    session_start();
    //SET MAIN SESSION VARIABLES
    $_SESSION["clientUser"] = $_POST["emailInput"];
    $_SESSION["clientPWord"] = $_POST["passwordInput"];
    
    //SESSION VARIABLES READY TO SAVE RESULTS
    $_SESSION["clientFName"] = "";
    $_SESSION["clientLName"] = "";
    $_SESSION["clientUID"] = "";
    $_SESSION["clientAge"] = "";
    $_SESSION["clientCity"] = "";

    //old
    /*$clientFName = "";
    $clientLName = "";
    $clientUID = "";
    $clientAddress = "";
    $clientCity = "";*/

    //old, variables
    //$clientUser = $_POST["emailInput"];
    //$clientPWord = $_POST["passwordInput"];

    //new, PROTECT FROM MYSQL INJECTION
    $_SESSION["clientUser"] = stripslashes($_SESSION["clientUser"]);
    $_SESSION["clientPWord"] = stripslashes($_SESSION["clientPWord"]);

    //old, PROTECT FROM MYSQL INJECTION
    //$clientUser = stripslashes($clientUser);
    //$clientPWord = stripslashes($clientPWord);
    
    $loginStatus = 0;

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
    echo "..Connected to MySQL<br>";

    //select a database to work with
    $selectedDB = mysql_select_db($dbname,$con) 
      or die("..Could not select examples");
    echo "..Selected database: " . $dbname."<br><br>";

    //new
    $_SESSION["clientUser"] = mysql_real_escape_string($_SESSION["clientUser"]);
    $_SESSION["clientPWord"] = mysql_real_escape_string($_SESSION["clientPWord"]);
    $_SESSION["clientPWord"] = md5($_SESSION["clientPWord"]);

    $clientUser = $_SESSION["clientUser"];
    $clientPWord = $_SESSION["clientPWord"];

    //old
    /*$clientUser = mysql_real_escape_string($clientUser);
    $clientPWord = mysql_real_escape_string($clientPWord);
    $clientPWord = md5($clientPWord);*/
    
    //VERIFY LOGIN
    $sql="SELECT * FROM Users WHERE Email = '$clientUser' and PWord = '$clientPWord'";
    $verificationResult=mysql_query($sql);

    if(mysql_num_rows($verificationResult) == 1){
      echo "..Login successful";
      $loginStatus = 1;
    }
    else{
      echo "..Incorrect login details";
      $loginStatus = 0;
    }

    //IF LOGIN SUCCESS SHOW USER DETAILS
    if($loginStatus == 1){
      //execute the SQL query and SELECT appropriate rows FROM appropriate TABLE
      $result = mysql_query("SELECT * FROM Users WHERE Email = '".$clientUser."'");
      //$result = mysql_query($con,$sql);

      //$result = mysql_query("SELECT userID,UserName,FirstName,LastName,Address,City FROM Users");

      //set up table
      echo "<table border='1'>
      <tr>
      <th>User ID</th>
      <th>Email</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Age</th>
      <th>City</th>
      </tr>";

      //fetch the data from the database 
      while ($row = mysql_fetch_array($result)) {
        //echo "ID: ".$row{'userID'}.", Name: ".$row{'FirstName'}." ".$row{'LastName'}.", Address: ".$row{'Address'}.", Year: ".$row{'City'}."<br>"; //display the results
        $_SESSION["clientFName"] = $row['FirstName'];
        $_SESSION["clientLName"] = $row['LastName'];
        $_SESSION["clientUID"] = $row['userID'];
        $_SESSION["clientAge"] = $row['Age'];
        $_SESSION["clientCity"] = $row['City'];
        echo "<tr>";
        echo "<td>" . $row['userID'] . "</td>";
        echo "<td>" . $row['Email'] . "</td>";
        echo "<td>" . $row['FirstName'] . "</td>";
        echo "<td>" . $row['LastName'] . "</td>";
        echo "<td>" . $row['Age'] . "</td>";
        echo "<td>" . $row['City'] . "</td>";
        echo "</tr>";
      }
      echo "</table>";

      //welcome user
      echo "<h1>Welcome, ".$_SESSION['clientFName']." ".$_SESSION['clientLName']."</h1><br><br>";
      echo '<a href="logout.php"><button class="small button">Log Out</button></a>';
    }
    else{
      echo '<br><br><div class="row">
              <div class="large-4 columns">
                <div class="panel">
                  <h3>User Login</h3>
                  <div class="row">
                    <div class="large-12 medium-12 columns">
                      <!--LOGIN FORM START--> 
                        <!--POST METHOD WILL LOAD A NEW PAGE, DataLogin.js below will submit w/out new page load-->
                        <form id="loginForm" method="POST" action="sqlConnect.php">
                        <form id="loginForm">
                          <label>Username</label>
                          <input id="usernameInput" type="text" placeholder="username" name="usernameInput"/>
                          <label>Password</label>
                          <input id="passwordInput" type="password" placeholder="password" name="passwordInput"/>
                          <input type="submit" class="small button">
                        </form>
                      <!--LOGIN FORM END-->
                    </div>
                  </div>
                </div>
              </div>
            </div>';
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