<?php

//session_start();
// Cookie name
/*
$cookie_name = "visit_counter";

// Check if the cookie exists
if (isset($_COOKIE[$cookie_name])) {
    // Cookie exists, increment the count
    $visit_count = $_COOKIE[$cookie_name] + 1;
} else {
    // Cookie does not exist, start with 1
    $visit_count = 1;
}

// Set or update the cookie with the new count
// Expire in 1 year
setcookie($cookie_name, $visit_count, time() + (86400 * 365), "/");

// Display the visit count
echo "You have visited this site $visit_count times.";
echo "Hi";
*/

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
   // include "classes/search.php";
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
    //print_r($_REQUEST);
    $aValidateInput = new validateInput($_REQUEST);

    $_REQUEST=$aValidateInput->validateInput();
    //echo "Web Page Index";
    $aRequestResolver = new requestResolver($_REQUEST);  
    // 
    //}
?>
<?php

?>
