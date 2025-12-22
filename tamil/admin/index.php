<?php
  /*
  if(
    isset($_SESSION['username']) &&
    isset($_SESSION['password']) &&
    $_SESSION['username'] =='test' &&
    $_SESSION['password'] =='test'
    )
    {
      echo "SESSION IS SET<br/>";
      $user="Admin2";
    }
  else if( 
      isset($_REQUEST['username']) && 
      isset($_REQUEST['password']) && 
      $_REQUEST['username'] =='test' &&
      $_REQUEST['password'] =='test' &&
      !isset($_SESSION['username']) &&
      !isset($_SESSION['password'])
      )
      {
      echo "<br/>username and password set to test, sessions are not set<br/>";
      $_SESSION['username']=$_REQUEST['username'];// or set equal to 'test'
      $_SESSION['password']=$_REQUEST['password'];// or set equal to 'test'
      $user="Admin1";
      } 
  else if(!isset($_SESSION['username']))
  {
        header("Location: login.php?e=invalid");
        die();
  }*/
  session_start();
  error_reporting(0);
 // error_reporting(E_ALL);
//ini_set('display_errors', 'On');
  include "../classes/loginPage.php";
  include "../classes/Config.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Church of Grace - Admin</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       <link rel="stylesheet" href="../includes/dark.min.css">
       <!--<link rel="stylesheet" href="../css/adminStylesheet.css">-->
        <script src="../includes/tinymce/js/tinymce/tinymce.min.js"></script>
        <script>
            tinymce.init({
                selector: '#content', // Replace with your textarea ID or class
                plugins: 'table advlist code media autolink lists link image charmap print preview anchor',      
                toolbar: 'table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol | undo redo | code | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image',
                menubar: true
           
            });
        </script>
        
        <?php
          $aLogin = new loginPage($_REQUEST);
        ?>
      </head>
    <body>
      <?php
          include "../classes/adminRequestResolver.php";
          include "../classes/requestResolver.php";
          include "../classes/View.php";
          include "../classes/Page.php";
          include "../classes/databaseManager.php";    
          include "../classes/WebSite.php";
          include "../classes/Sermon.php";
      ?>
      <a href="https://gracian.ca/churchofgrace/index.php?pid=378" target="_blank">Home Page</a> &nbsp;| &nbsp;
      <a href="logout.php">Logout</a><br/>
      <?php
        include "../templates/menu.php";
      ?>
      <div id='pageContent'>
          <?php
              error_reporting(1);
              //print_r($_REQUEST);
              $aRequestResolver = new adminRequestResolver($_REQUEST);
              $aRequestResolver->process();
          ?> 
       </div>
    </body>
</html>