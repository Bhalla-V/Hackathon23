<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
<nav class= "header_bar">
    <!--
       <div class="fixed_bar_logout"> 
           <img src="images/logo_logout.png" class="main_icon_logout" alt="mainicon">
        <div class="About_us">
            xyz xyz 
            </div>
        <div class="Our_mission">
            123 123
            </div>
        </div>
        <img src="images/Astronaut_logout.png" class="astronaut_logout" alt="astro">
        </nav>
       </header> -->
    <div class="reg_class">
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST">
        <label for="new_user">new username</label>
        <input type="text" id="new_user" name="new_user" required>  
        <label for="new_password">new password</label>
        <input type="password" name="new_password" id="new_password" required>
        <input type="Submit" value="REGISTER" name="register"> 
</form>  
    </div>

<?php

if (isset($_POST['register'])) {
    session_start();
    $password = $_POST['new_password'];
    $username = $_POST['new_user'];
    $hashed_password = password_hash($password,PASSWORD_BCRYPT);

    require 'hackathon_database.php';
        $check_stmt = $mysqli->prepare("SELECT username FROM user_data WHERE username = ?");
        $check_stmt->bind_param('s', $username);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            echo htmlentities("Username already exists. Please choose another username.");
            exit();
        }
    $stmt = $mysqli->prepare("insert into user_data(username,pswd) values (? , ?)"); 
    $stmt->bind_param('ss',$username,$hashed_password); //fill in question marks in prepare line
    $stmt->execute();
    $stmt->close();
    header("Location:main_site.php");
    exit();
    
}
?>
</body>
</html>
