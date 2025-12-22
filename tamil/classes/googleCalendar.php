<?php
class googleCalendar{
    private $googleCalendar;
    function __construct(){

    }
    /*.calendar-container {
            max-width: 100%;
            height: 600px;
            border: 1px solid #ddd;
            overflow: hidden;
        }
        iframe {
            border: 0;
            width: 100%;
            height: 100%;
        }*/
    public function displayGoogleCalendar(){
        $this->googleCalendar= "
        <p>இந்த காலண்டர் எங்கள் சபையின் அடுத்த மாதத்துக்கான சேவைகளின் ஒட்டுமொத்தப் பார்வையை உங்களுக்கு வழங்கும். இந்த சேவைக்காலங்களைப் பார்வையிடச் சுதந்திரமாக இருக்கவும், சேவைகள் பற்றிய மேலும் தகவலுக்கு எங்களை <a href='index.php?pid=400'>இங்கு</a> தொடர்பு கொள்ளவும்.</p>
        <div class='calendar-container' style=''>
            <iframe 
            src='https://calendar.google.com/calendar/embed?src=gracian.anton%40gmail.com&ctz=America%2FToronto' 
            style='border: 0'
            width='800'
            height='600'
            frameborder='0' 
            scrolling='no'></iframe>
        </div>
        ";
        return $this->googleCalendar;
    }
}