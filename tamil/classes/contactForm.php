<?php
class contactForm{
    private $contactForm;
    private $confirmationMessage;
    private $errorForm;
    public function __construct(){
    }
    public function viewForm(){
        $this->contactForm = "
            <div style='padding-left:10px;padding-bottom:7px;'>எங்கள் இணையதளத்தை பார்வையிட்டதற்கு நன்றி. உங்களுக்கு ஆதரவு வழங்குவதற்கும், உங்களுக்குள்ள கேள்விகளை பதிலளிப்பதற்கும் நாங்கள் இங்கே இருக்கிறோம். நீங்கள் புதியவர், ஆன்மிக வழிகாட்டலுக்காக தேடுகிறீர்கள், எங்கள் தேவாலயத்தை அணுக உதவ வேண்டும், பிரார்த்தனை கோரிக்கைகள் உள்ளன, அல்லது எங்களைப் பற்றி மேலும் அறிய விரும்புகிறீர்கள் என்பதற்கேநாம் நீங்கள் எங்களை தொடர்புகொள்வதை விரும்புகிறோம். கீழே உள்ள படிவத்தை பயன்படுத்தி கேள்விகளை கேட்கவோ, அல்லது 613-762-2174 என்ற எண்ணை அழைக்கவோ தயவுசெய்து எங்களை தொடர்புகொள்ளவும்.</div>
            <div id='contactForm' style='width:60%;'>
                <form id='contact_form'  action='https://gracian.ca/churchofgrace/tamil/index.php' method='get' enctype='multipart/form-data'>
                <div class='row' style='width:95%;'>
                    <label class='required' for='name' id='name'>உங்கள் பெயர்:</label><br />
                    <input id='name' class='input' name='name' type='text' value=''><br />
                    <span id='name_validation' class='error_message'></span>
                </div>
                <div class='row' style='width:95%;'>
                    <label class='required' for='email' id='email'>உங்கள் மின்னஞ்சல் முகவரி:</label><br/>
                    <input id='email' class='input' name='email' type='text' value=''><br/>
                    <span id='email_validation' class='error_message'></span>
                </div>
                <div class='row' style='width:95%;'>
                    <label class='required' for='message' id='message'>உங்கள் முகவரி:</label><br/>
                    <textarea id='message' class='input' name='message'   rows='7' cols='1'></textarea><br/>
                    <span id='message_validation' class='error_message'></span>
                </div>
                <div class='row' style='margin-top:15px;margin-bottom:15px;'>
                    <div class='g-recaptcha' data-sitekey='6LdNWRkqAAAAAJdzASwXU70g7ISbwiuTvyYvLhGn'></div>
                    <div id='mail-status'></div>
                </div>
                    <input id='submit' type='submit' value='மின்னஞ்சல் அனுப்பவும்' style='background-color:#C41E3A; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; font-size:16px;'/>
                    <input id='hidden' type='hidden' name='pid' value='400'/>
                </form>
              </div>
              <div id='prayerRequest' style='width:40%;'>
                    <div id='prayerPrompt' style='margin-left:5%;font-size:20px;color:#C41E3A;'><b>பிரார்த்தனை கோரிக்கைகள்</b></div>
                    <font class='pr_name'>
                    <p><font class='pr_name'><font class='pr_name'><strong>மத்தேயு 18:19:<br></strong></font>நான் உங்களுக்கு மீண்டும் சொல்கிறேன், நீங்கள் இருவரும் பூமியில் எதுவேனும் கேட்டால், அது என் மேல் உள்ள அப்பனால் உங்களுக்காக நடக்கவேண்டும்.</font></p>

                    <font class='pr_name'>
                    <p><font class='pr_name'><font class='pr_name'><strong>மத்தேயு 21:22: <br></strong></font> நீங்கள் நம்பினால், நீங்கள் பிரார்த்தனையில் கேட்ட அனைத்தையும் பெறுவீர்கள்.</font></p>

                    <font class='pr_name'>
                    <p><font class='pr_name'><font class='pr_name'><strong>மார்க்கு 9:23: <br></strong></font> நம்புகிறவனுக்கு எல்லாமும் சாத்தியம்.</font></p>

                    <font class='pr_name'>
                    <p><font class='pr_name'><font class='pr_name'><strong>1 யோவான் 5: 14-15: <br></strong></font>நாங்கள் தேவனை அணுகும் போது நம்பிக்கையுடன் இருப்பது இவ்வாறு: அவரது விருப்பத்திற்கு ஏற்ப எதுவேனும் கேட்டால், அவர் நம்மை கேட்கிறார். அவர் நம்மை கேட்கிறார் என்பதைக் நாங்கள் அறிவோம் - எதுவேனும் கேட்டால் - நாங்கள் அவரிடமிருந்து கேட்டதை நாங்கள் பெற்றுவிட்டோம்.</font></p>
                    </font>
                </div>
            ";
        return $this->contactForm;
    }

    function viewConfirmationMessage(){
        $this->confirmationMessage = "
            <div class='thank-you' style='font-family: Arial, sans-serif;text-align: center;padding: 20px;margin: 20px auto;border: 1px solid #ccc;max-width: 400px;background-color: #f9f9f9;'>
                <h2>நன்றி!</h2>
                <p>உங்கள் படிவம் வெற்றிகரமாக சமர்ப்பிக்கப்பட்டது. அடுத்த ஒரு நாளில் நாங்கள் பதிலளிக்க முயற்சிப்போம்.</p>
            </div>

        ";
        return $this->confirmationMessage;
    }
    function viewErrorForm($request,$output){
        $errorCode = "<div class='errorCode' style='color:red;'>".substr($output,8)."</div>";
        $this->errorForm ="
            ".$errorCode."
            <div id='contactForm' style='width:60%;'>
                <form id='contact_form'  action='https://gracian.ca/churchofgrace/tamil/index.php' method='get' enctype='multipart/form-data'>
                <div class='row' style='width:95%;'>
                    <label class='required' for='name' id='name'>உங்கள் பெயர்:</label><br />
                    <input id='name' class='input' name='name' type='text' value=".$request['name']."><br />
                    <span id='name_validation' class='error_message'></span>
                </div>
                <div class='row' style='width:95%;'>
                    <label class='required' for='email' id='email'>உங்கள் மின்னஞ்சல் முகவரி:</label><br/>
                    <input id='email' class='input' name='email' type='text' value=".$request['email']."><br/>
                    <span id='email_validation' class='error_message'></span>
                </div>
                <div class='row' style='width:95%;'>
                    <label class='required' for='message' id='message'>உங்கள் முகவரி:</label><br/>
                    <textarea id='message' class='input' name='message'   rows='7' cols='1'>".$request['message']."</textarea><br/>
                    <span id='message_validation' class='error_message'></span>
                </div>
                <div class='row' style='margin-top:15px;margin-bottom:15px;'>
                    <div class='g-recaptcha' data-sitekey='6LdNWRkqAAAAAJdzASwXU70g7ISbwiuTvyYvLhGn'></div>
                    <div id='mail-status'></div>
                </div>
                    <input id='submit' type='submit' value='மின்னஞ்சல் அனுப்பவும்' style='color:#C41E3A; background-color:#C41E3A;color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; font-size:16px;'/>
                    <input id='hidden' type='hidden' name='pid' value='400'/>
                </form>
              </div>
              <div id='prayerRequest' style='width:40%;'>
                <div id='prayerPrompt' style='margin-left:5%;font-size:20px;color:#C41E3A;'><b>ஆலோசனைகள்</b></div>
                <font class='pr_name'>
                <p><font class='pr_name'><font class='pr_name'><strong>மத்தேயு 18:19:<br></strong></font> நான் உங்களுக்கு மீண்டும் கூறுகிறேன், பூமியில் உங்களை இருவர் எதற்கும் ஒப்புக்கொண்டால், அவர்கள் கேட்டவற்றை என் பரிதியாகிய பிதா செய்யக்கூடும். </font></p>

                <font class='pr_name'>
                <p><font class='pr_name'><font class='pr_name'><strong>மத்தேயு 21:22: <br></strong></font> நீங்கள் நம்பினால், உங்கள் பிரார்த்தனையில் நீங்கள் கேட்ட எந்தவொரு விஷயத்தையும் பெறுவீர்கள். </font></p>

                <font class='pr_name'>
                <p><font class='pr_name'><font class='pr_name'><strong>மர்க்கு 9:23: <br></strong></font> நம்புகிறவருக்குப் புத்தியில் எல்லாம் சாத்தியமாகும். </font></p>

                <font class='pr_name'>
                <p><font class='pr_name'><font class='pr_name'><strong>யோவான் 5:14-15: <br></strong></font> நாம் தேவனை அணுகும்போது நமக்கு உள்ள உறுதி இதுவே: அவன் விருப்பத்திற்கு ஏற்ப எதையாவது கேட்பவர்களை அவன் கேட்கிறான். நமக்கு அவன் கேட்கிறான் என்பதை நாங்கள் தெரிந்தால் - நாங்கள் கேட்டதை - நாங்கள் அவன் கையிலிருந்ததை பெற்றிருப்பதாக நாங்கள் அறிந்தோம். </font></p>
                </font>
            </div>

               ";
        return $this->errorForm;
    }
}
?>