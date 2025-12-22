<?php

error_reporting(1);

    include "classes/Config.php";
    include "classes/adminRequestResolver.php";
    include "classes/View.php";
    include "classes/Page.php";
    include "classes/databaseManager.php";    
    include "classes/WebSite.php";
    include "classes/requestResolver.php";
    include "classes/tagResolver.php";
    include "classes/contactForm.php";
    include "classes/googleCalendar.php";
    include "classes/validateInput.php";
    include "classes/Sermon.php";
    include "classes/webAnalytics.php";
   include "classes/search.php";
   include "classes/adminDatabaseManager.php";
    /*
    if(count($_REQUEST)>2){
        $message = $_REQUEST['message'];
        $email = $_REQUEST['email'];
        $name = $_REQUEST['name'];
       /* echo "<pre>";
        print_r($_SESSION['submitted_message']);
        echo "</pre>";*/
    /*
        if (
            isset($_SESSION['submitted_message']) 
            && in_array($message, $_SESSION['submitted_message']) 
            //&& $_SESSION['submitted_message']==$message

            && isset($_SESSION['submitted_email']) 
            && in_array($email, $_SESSION['submitted_email'])
            //&& $_SESSION['submitted_email']==$email

            && isset($_SESSION['submitted_name'])
            && in_array($name,$_SESSION['submitted_name'])
            //&& $_SESSION['submitted_name']==$name
            ) 
            {
            // Email already submitted
            echo "You have already submitted this email!";
            } 
        else {
            // Add email to submitted list
            //$_SESSION['submitted_message'][] = $message;
            //$_SESSION['submitted_email'][] =$email;
            //$_SESSION['submitted_name'][]=$name;
            array_push($_SESSION['submitted_message'],$message);
            array_push($_SESSION['submitted_email'],$email);
            array_push($_SESSION['submitted_name'],$name);

            // Process form or store email
            echo "Email processed!";
            $aRequestResolver = new requestResolver($_REQUEST);   
        }
    }
    else{
    */
   // print_r($_REQUEST);
   //echo "Index.php";
    $aValidateInput = new validateInput($_REQUEST);

    $_REQUEST=$aValidateInput->validateInput();
    //echo "Web Page Index";
   // print_r($_REQUEST);
  
    $aRequestResolver = new requestResolver($_REQUEST);  
    // 
    //}
?>

