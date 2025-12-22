<?php
class tagResolver{
    private $request;
    private $name;
    private $email;
    private $message;
    private $subject;
    private $header;
    private $headers;
    private $txt;
    private $aWebSite;
    private $aView;
    private $mailTo;
    private $msg;
    private $fontColor;
    private $text;
    private $output;
    private $contactForm;
    private $googleCalendar;
    private $blog;
    private $recaptcha;
    private $webAnalytics;
    private $search;
    private static $INCLUDE_CONTENT_REGEX="\/.*?(COG_INCLUDE_CONTENT_(\d*)).*\/";

    public function __construct($webPage,$request){
        //echo "Construct";
        $this->aWebSite = $webPage;
        $this->request = $request;
    }
    public function process(){
        $this->contactForm = new contactForm();
        $this->googleCalendar = new googleCalendar;
        $this->webAnalytics = new webAnalytics();
        $this->search = new Search("");
        $this->Sermon = new Sermon("");
       // preg_match ($INCLUDE_CONTENT_REGEX,$this->aWebSite,$match_list=array());
        //if(count($match_list)==3){
        //    $icontent_pid=$match_list[2];
        //    $this->aWebSite = str_replace("GoogleCalendarIsHere",$this->googleCalendar->displayGoogleCalendar(),$this->aWebSite);
        //    return $this->aWebSite;
        //}
        $match_list=array();
        //echo "Processing in tagResolver";
        if(strpos($this->aWebSite,"#COG_INCLUDE_CONTENT_1#")){
            //echo "Blog";
            //preg_match("#COG_INCLUDE_CONTENT_1#",$this->aWebSite,$match_list);
            preg_match('/.*?(COG_INCLUDE_CONTENT_(\d+)).*/', "#COG_INCLUDE_CONTENT_1#", $match_list);
            if(count($match_list)==3){
                $this->blog = new Page($match_list[2]);
                $this->aWebSite = str_replace("#COG_INCLUDE_CONTENT_1#",$this->blog->content,$this->aWebSite);
            }
            return $this->aWebSite;
        }
        else if(strpos($this->aWebSite,"#COG_GoogleCalendar")>0){
            //echo 'google';
            $this->aWebSite = str_replace("#COG_GoogleCalendar",$this->googleCalendar->displayGoogleCalendar(),$this->aWebSite);
            return $this->aWebSite;
        }
        else if(strpos($this->aWebSite,"#COG_SEARCH_RESULTS")>0){
            //echo "#COG_SEARCH_RESULTS";             
            $this->aWebSite = str_replace("#COG_SEARCH_RESULTS",$this->search->viewSearchResults($this->request),$this->aWebSite);
            return $this->aWebSite;
        }
        else if(strpos($this->aWebSite,"#COG_WEBANALYTICS")){
            //echo "Hi there";
            $this->aWebSite = str_replace("#COG_WEBANALYTICS",$this->webAnalytics->viewWebAnalytics()/*"Number of times"*/,$this->aWebSite);
            return $this->aWebSite;
        }
        else if(strpos($this->aWebSite,"#COG_ContactFormResolver")>0 && count($this->request)<=3){

            $this->aWebSite = str_replace("#COG_ContactFormResolver",$this->contactForm->viewForm(),$this->aWebSite);

            return $this->aWebSite;
        }
        
        else if(strpos($this->aWebSite,"#COG_ContactFormResolver")>0 && count($this->request)>3){
            if($this->validateForm()){

                $this->aWebSite = str_replace("#COG_ContactFormResolver",$this->contactForm->viewConfirmationMessage(),$this->aWebSite);
                
                return $this->aWebSite;
            }
            else{
                //occurs when validateForm is false
                //echo "Invalid Form Request";
                $this->aWebSite = str_replace("#COG_ContactFormResolver",$this->contactForm->viewErrorForm($this->request,$this->output),$this->aWebSite);
                return $this->aWebSite;
            }
        }
        else if(strpos($this->aWebSite,"#COG_SERMON")){
            //echo "#COG_SERMON";
            $this->aWebSite = str_replace("#COG_SERMON",$this->Sermon->showSermonPage(),$this->aWebSite);
            return $this->aWebSite;
        }
        else{
            //this is a normal page
            return $this->aWebSite;
        } 
        
    }
    public function validateForm(){ 
        $this->name      = filter_var($this->request["name"], FILTER_SANITIZE_STRING);
        $this->email     = filter_var($this->request["email"], FILTER_SANITIZE_EMAIL);
        $this->message   = filter_var($this->request["message"], FILTER_SANITIZE_STRING);
        $this->recaptcha  = $this->request['g-recaptcha-response'];

        $secret_key = "6LdNWRkqAAAAAJL-cBLZpB0_NFC9mFc_PqsASnHe";

        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='. $secret_key . '&response=' . $this->recaptcha;
        
        $response = file_get_contents($url);

        $response = json_decode($response);

        /*if ($response->success == true) {
            echo '<script>alert("Google reCAPTACHA verified")</script>';
        } else {
            echo '<script>alert("Error in Google reCAPTACHA")</script>';
        }*/

        $empty=array();
        if($response->success == false){
            $empty[] = "I'm not a robot";
        }
        if(empty($this->name) || !preg_match("/^[a-zA-Z]+$/",$this->name) || preg_match("/[^\w\s]/",$this->name)) {
            $empty[] = "Name";	                       
            //echo "Name is emtpy";
        }
        if(empty($this->email)) {
            $empty[] = "Email";
            //echo "Email is empty";
        }
        if(empty($this->message)) {
            $empty[] = "Comments";
            //echo "Comments is empty";
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL) && !empty($this->email)){
            $empty[] = "Email Address is not written correctly";
        }
        //!filter_var($this->email, FILTER_VALIDATE_EMAIL)
        if(!empty($empty)) {
            //echo "Empty is not empty, meaning not errors";
            $this->output = json_encode(array('text' => implode(", ",$empty) . ' has errors!'));
            return false;
        }
        if(empty($empty)){ //email validation
            //$this->output = json_encode(array('type'=>'error', 'text' => '<b>'.$this->email.'</b> is an invalid Email, please correct it.'));
            //die($output);
            $this->processForm();
            $this->sendMail();
            return true;
        }
    }
    public function processForm(){
        //ochurchofgrace@gmail.com
        $this->mailTo= "psanthia@yahoo.com";
        $this->subject="CHURCH OF GRACE MESSAGE";
        $this->headers = "From: info@gracian.ca" . "\r\n" .
        "CC: $this->email";
        $this->txt=$this->message;
    }
    public function sendMail(){
        if(mail($this->mailTo,$this->subject,$this->txt,$this->headers)){
            echo "Email sent successfully";
        }
        else{
            echo "Email not sent successfully";
        }
        header("Location: http://localhost/churchWebsite/index.php?pid=400?mailsend");
    }
}
?>