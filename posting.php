
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
<header>
<nav class= "header_bar">
       <div class="fixed_bar"> 
            <img src="images/logo.png" class="main_icon" alt="mainicon">
            <div class="tabs">
                <div class="home">
                    <form action="user_home.php" method="POST">
                        <input type='hidden' name = 'token' value = <?php echo $_SESSION['token']?>>
                        <input type="Submit" value="HOME" name="homepage" id="homepage"> 
                    </form>
                </div> <!--post option ends-->
                <div class="posting">
                    <form action="posting.php" method="POST">
                        <input type='hidden' name = 'token' value = <?php echo $_SESSION['token']?>>
                        <input type="Submit" value="+ POST" name="post" id="posted"> 
                    </form>
                </div> <!--post option ends-->
                <div class="wish">
                    <form action="wishlist.php" method="POST">
                        <input type='hidden' name='wisher' value=<?php echo $_SESSION['username']?>>
                        <input type="Submit" value=" &#9829; MY WISHLIST" name="wishlist" id="wishlist"> 
                    </form>
                </div> <!--wishlist option ends-->
                <div class="my_posts">
                    <form action="my_posts.php" method="POST">
                    <input type='hidden' name='user' value=<?php echo $_SESSION['username']?>>
                    <input type="Submit" value=" &#128064; VIEW MY POSTS" name="view_posts" id="view_posts"> 
                    </form>
                </div>
                <div class="other_wish">
                    <form action="other_wishes.php" method="POST">
                        <input type='hidden' name = 'token' value = <?php echo $_SESSION['token']?>>
                        <input type="Submit" value="VIEW FRIEND'S WISHLISTS" name="other_wish" id="other_wish"> 
                    </form>
                </div>
                <div class ="logout">
                    <form action="logout.php" method="POST">
                        <input type="Submit" value="&#8618; Logout "name="logout" id="logging_out">
                    </form> 
                </div> 
                    <img src="images/Astronaut.png" class="astronaut" alt="astro">
                </div>
            </div>
        </div>
    </nav>
 </header>
    <div class="suggestions">
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST"> 
        <label for="for_who" style="font-size:20px; font-family: 'Georgia'">Who are you suggesting this for?:</label>
        <select id="for_who" name="for_who">
            <?php
            session_start();

            $user_id = $_SESSION['username'];
            require 'hackathon_database.php';
            // Query to retrieve existing usernames from the user_data table
            $query = "SELECT username FROM user_data";
            $result = $mysqli->query($query);
            // Populate dropdown options with existing usernames
            while ($row = $result->fetch_assoc()) {
                if ($row['username']!= $user_id) {
                    echo '<option value="' . $row['username'] . '">' . $row['username'] . '</option>';
                }
            }

            // Free the result set
            $result->free_result();
            ?>
        </select> 
        <label for="restaurant" style="font-size:20px; font-family: 'Georgia'">Restaurant name:</label>
        <input type="text" id="restaurant_sugg" name="restaurant" required>  
        <label for="article" style="font-size:20px; font-family: 'Georgia'">Write your review here:</label>
        <input type="text" id="article" name="article" required>  
        <label for="link" style="font-size:20px; font-family: 'Georgia'">Add a link to the restaurants homepage!</label>
        <input type="text" id="link_sugg" name="link" required>
        <input type='hidden' name = 'token' value = <?php echo $_SESSION['token']?>>
        <input type = "Submit" name="publish" value="publish"> 
    </form>
    

<?php


session_start();

$user_id = $_SESSION['username'];
    if(isset($_POST['publish'])) {
        require 'hackathon_database.php';
        $restuarant = $_POST['restaurant'];
        $article_content = $_POST['article'];
        $link = $_POST['link']; 
        $for_who = $_POST['for_who'];
        $insert_query = "INSERT INTO posts (title,link, posted_by, body, for_who) VALUES ('$restuarant','$link','$user_id','$article_content','$for_who')";
        if ($mysqli->query($insert_query)) {
            echo "Post successfully submitted!";
        } else {
            printf("Query prep failed: %s\n", $mysqli->error);
            exit;
        }       
        $_SESSION['restaurant'] = $restaurant;
        $_SESSION['body'] = $article_content;
        $_SESSION['poster'] = $user_id;
        $_SESSION['link'] = $link;
        header("Location: user_home.php");
        exit();
    }
?>
 </div>
</body>
</html>


