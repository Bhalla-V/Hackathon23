<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoodEatsSTL</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
<header>
<nav class= "header_bar">
       <div class="fixed_bar_logout"> 
           <img src="images/logo_logout.png" class="main_icon_logout" alt="mainicon">
            <div class="About_us">
            </div>
            <div class="Our_mission">
            </div>
            </div>
        <img src="images/Astronaut_logout.png" class="astronaut_logout" alt="astro">
        </nav>
       </header>
    <div class="main_content">
        <div class="intro">
            Hey You! Want new restaurant recs? Be able to suggest some to your friends who eat at the same places everyday? Plan your next outing?
            </div>
        <div class="intro_sub">
            Support local businesses and gather your friends while you do it! 
            </div>
    <div class="login">
    <div class="user_input">
        Go on and log in! 
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST">
        <label for="user">Username</label>
        <input type="text" id="user" name="user" required>  
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <input type="Submit" value="Login" name="login" id="login"> 
        </form>  
        </div>
        <div class="register">
    <form action="register.php" method="POST"> 
        <input type="Submit" value="Register Now!" name="Yes" id="reg">
    </form>
    </div>
</div>
<?php
 echo '<link rel="stylesheet" type="text/css" href="style.css"></head>';
session_start();

if (isset($_POST["Yes"])) {
    header("Location: register.php");
}
$username = $_POST['user'];
$guessed_password = $_POST['password'];
$hashed_password = password_hash($guessed_password,PASSWORD_BCRYPT);

require 'hackathon_database.php';
if (isset($_POST['login'])) {
    $stmt = $mysqli->prepare("SELECT COUNT(*),username, pswd FROM user_data WHERE username=?");
    $stmt->bind_param('s',$username);
    $stmt->execute();
    
    $stmt->bind_result($cnt, $user_id,$pwd_hash);
    $stmt->fetch();
    
    if ($username != $user_id) {
        echo htmlentities("Incorrect Username");
        exit;
    } else if($cnt == 1 && password_verify($guessed_password,$pwd_hash)) {
        $_SESSION['username']=$user_id;
        $_SESSION['password']=$guessed_password;
        $_SESSION['token'] = bin2hex(random_bytes(32)); 
        $var = $_SESSION['token'];
        $_POST['token'] = $var;
        header("Location: user_home.php"); 

    } else {
        echo '<span style="height: 60rem; width: 120rem;">' . htmlentities("Incorrect Password") . '</span>';
        exit; 
    }
}
?>
</body>
</html>


