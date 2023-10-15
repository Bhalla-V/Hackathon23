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
  
    <?php
    session_start();
    if(!isset($_SESSION['username'])) {
        header("Location: main_site.php");
        exit;
    } 
    $user_id = $_SESSION['username'];
    $password = $_SESSION['password'];
    //echo htmlentities("Welcome ".$user_id."! Here are restaurants suggested for you: ");
    ?>

   <div class = "sort_wishlist">

   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST"> 
   <label for="sort_wishlist" style="font-size:20px; font-family: 'Georgia'">Sort by:</label>
    <select id="sort_wishlist" name="sort">
        <option value="Restaurant Name" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'Restaurant Name') echo 'selected'; ?>>Restaurant Name</option>
        <option value="Most recent" <?php if(isset($_POST['sort']) && $_POST['sort'] == 'Most recent') echo 'selected'; ?>>Most recent</option>
        <!-- Add similar logic for other sorting options if needed -->
    </select>
    <input type="submit" value="Sort" name="s" id="s_wishlist">
</form>
   </div>
    <?php
        require 'hackathon_database.php';
        $sort = $_POST['sort'];
        $orderClause = 'ORDER BY title ASC';
        if ($sort == 'Restaurant Name') {
            $orderClause = 'ORDER BY title ASC';
        } 
        if ($sort == 'Most recent') {
            $orderClause = 'ORDER BY id DESC';
        } 
   
        $stmt = $mysqli->prepare("SELECT * FROM `wishlist` WHERE `wisher` = ?");
        $stmt->bind_param('s', $user_id);
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->execute();
        $result = $stmt ->get_result();
        echo "<ul class='restaurant-list'>\n";
        echo "<table class='restaurant-table'>";
        while ($row = $result->fetch_assoc()) {
            $id = $row['post_id'];
            $stmt2 = $mysqli->prepare("SELECT * FROM `posts` WHERE `id` = ? $orderClause");
            $stmt2->bind_param('i',$id);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $post = $result2->fetch_assoc();
                echo "<tr class='restaurant-row-wishlist'>";
                echo "<td class='posted-by'> Suggested by: " . htmlspecialchars($post['posted_by']) . "\n</td>";
                echo "<td class='restaurant-title-wishlist'>" . htmlspecialchars($post['title']) . "<br></td>";
                echo "<td class='restaurant-link'><iframe src='" . htmlspecialchars($post['link']) . "' style='height: 60rem; width: 120rem;'></iframe></td>";
                echo "<td class='restaurant-body'>" . htmlspecialchars($post['body']) . "<br></td>" ;
        }
        echo "</table>";
        echo "</ul>\n"; 
    ?>
</body>
</html>