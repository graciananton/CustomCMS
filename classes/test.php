<html>
  <head>
    <title>reCAPTCHA demo: Simple page</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>
  <body>
<form id="frmContact" action="" method="POST" novalidate="novalidate">
    <div class="label">Name:</div>
    <div class="field">
        <input type="text" id="name" name="name"
            placeholder="enter your name here"
            title="Please enter your name" class="required"
            aria-required="true" required>
    </div>
    <div class="label">Email:</div>
    <div class="field">
        <input type="text" id="email" name="email"
            placeholder="enter your email address here"
            title="Please enter your email address"
            class="required email" aria-required="true" required>
    </div>
    <div class="label">Phone Number:</div>
    <div class="field">
        <input type="text" id="phone" name="phone"
            placeholder="enter your phone number here"
            title="Please enter your phone number"
            class="required phone" aria-required="true" required>
    </div>
    <div class="label">Comments:</div>
    <div class="field">
        <textarea id="comment-content" name="content"
            placeholder="enter your comments here"></textarea>
    </div>
    <div class="g-recaptcha" data-sitekey="6LdNWRkqAAAAAJdzASwXU70g7ISbwiuTvyYvLhGn"></div>
    <div id="mail-status"></div>
    <button type="Submit" id="send-message" style="clear: both;">Send
        Message</button>
</form>
</body>
</html>
