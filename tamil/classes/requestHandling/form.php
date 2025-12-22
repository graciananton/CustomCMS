<html>
    <head>
        <title>Form Submission Example</title>
        <link rel='stylesheet' href='css/form.css'/>
    </head>
    <body>
        <form action='welcome.php' enctype='multipart/form-data' method='post'>
            <div id='list'>
                <label for='firstName'>First Name:</label>
                <input type='text' id='firstName' name='firstName' value=''>
            </div>
            <div id='list'>
                <label for='lastName'>Last Name:</label>
                <input type='text' id='lastName' name='lastName' value=''>
            </div>
            <input type='submit' name='submit' value='Submit'/>
        </form>
    </body>
</html>
<!-- 
Sequential Array
Array(
[0] => "Tom"
[1] => "Bill"
[2] => "Bob"
)
Associative Array(key-value pair array, type of array used in form submission)
Array(
 'firstName' => "Bob"
 'lastName'  => "Bill"
 'submit'    => 'Submit'
)
$_POST
$_GET
$_REQUEST
