<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mapify | Home</title>
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
      if($_SESSION){
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
      echo '<section class="main-section" id="userHomeSection">
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
      header("Location: login.html");
    }
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