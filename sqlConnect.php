<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mapify | User Profile</title>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.1.min.js"></script>
     <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,100,100italic,400italic,700,500' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/custom.css"/>
    <link rel="stylesheet" href="css/foundation.css" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
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
    //echo "..Connected to MySQL<br>";

    //select a database to work with
    $selectedDB = mysql_select_db($dbname,$con) 
      or die("..Could not select examples");
    //echo "..Selected database: " . $dbname."<br><br>";

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
      //echo "..Login successful";
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

      //fetch the data from the database 
      while ($row = mysql_fetch_array($result)) {
        //echo "ID: ".$row{'userID'}.", Name: ".$row{'FirstName'}." ".$row{'LastName'}.", Address: ".$row{'Address'}.", Year: ".$row{'City'}."<br>"; //display the results
        $_SESSION["clientFName"] = $row['FirstName'];
        $_SESSION["clientLName"] = $row['LastName'];
        $_SESSION["clientUID"] = $row['userID'];
        $_SESSION["clientAge"] = $row['Age'];
        $_SESSION["clientCity"] = $row['City'];  
      }

      //$result = mysql_query("SELECT userID,UserName,FirstName,LastName,Address,City FROM Users");
      //ECHO NAV BAR
      echo '<nav class="top-bar" data-topbar role="navigation">
        <ul class="title-area">
          <li class="name">
            <h1><a href="#">Mapify</a></h1>
          </li>
           <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
          <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
        </ul>

        <section class="top-bar-section">
          <!-- Right Nav Section -->
          <ul class="right">
          <li>
            <img src="img/uploads/'.$_SESSION["clientUID"].'.jpg" class ="profilePic"/>
          </li>
          <li><a href="#" onclick="toggleLeftNav()">Map Editor Tools</a></li>
          <li><a href="#" onclick="toggleRightNav()">Account</a></li>
          <a href="logout.php"><li><i class="fa fa-times"></i></li></a>
        </ul>
        </section>
      </nav>';
      
      //MAIN SECTION 
      echo '<section class="main-section">
          <!--ALL CONTENT GOES INSIDE THIS SECTION-->
          <div id="map"></div>
              <div class="row">
                <div class="large-4 medium-4 columns" id="leftNavPanel">        
                  <ul>
                    <li>New Marker</li>
                    <li>Move Marker</li>
                    <li>Edit Map Details</li>
                    <li>Share this map</li>
                  </ul>
                </div>    
              </div>
              <div class="row">
                <div class="large-4 medium-4 columns" id="rightNavPanel">
                <img src="img/uploads/'.$_SESSION["clientUID"].'.jpg" class ="profilePicLarge"/>
                  <ul>
                    <li>'.$_SESSION["clientFName"].' '.$_SESSION["clientLName"].'</li>
                    <li>Email: '.$_SESSION["clientUser"].'</li>
                    <li>Age: '.$_SESSION["clientAge"].'</li>
                    <li>City: '.$_SESSION["clientCity"].'</li>
                  </ul>
                  <a href="profileSettings.html"><button class="small button">Update Profile Info</button></a><br>
                  <a href="accountSettings.html"><button class="small button">Update Account Info</button></a>

                  <form action="upload.php" method="post" enctype="multipart/form-data">
                    Select image to upload:
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="submit" class="small button" value="Upload Image" name="submit">
                  </form>
                </div>
              </div>
          <!--END OF CONTENT-->
        </section>';
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
    <script src="js/multi.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>