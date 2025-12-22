<?php
session_start();
?>
<head>
      <title>Church Of Grace - Login</title>
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
      <link rel="stylesheet" href="../css/login.css">
</head>
<body>
            <?php
             $msg="";
              if(isset($_REQUEST['e'])){
                $msg="<font color=red>Invalid Login<br/></font>";
              }
              else if(isset($_REQUEST['m'])){
                $msg="<font color=green>You have been logged out<br/></font>";
              }
            ?>
          <div class="login">
            <div id="message">
              <?php echo $msg;?>
            </div> 
            <h1>Login</h1>
            <form action="index.php" method="post">
                <label for="username">
                  <i class="fas fa-user"></i>
                </label>
                <input type="text" name="username" placeholder="Username" id="username" required>
                <label for="password">
                  <i class="fas fa-lock"></i>
                </label>
                <input type="password" name="password" placeholder="Password" id="password" required>
                <input type="hidden" name ="req" value="pf-logged"/>
                <input type="submit" value="Login">
			      </form>
            </div>
</body>