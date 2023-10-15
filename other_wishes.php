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
<div class="friends">
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST"> 
        <label for="friends" style="font-size:20px; font-family: 'Georgia'">Which friend would you like to view?:</label>
        <select id="friends" name="friends">
            <?php
            require 'hackathon_database.php';

            // Query to retrieve existing usernames from the user_data table
            $query = "SELECT username FROM user_data";
            $result = $mysqli->query($query);

            // Get the selected friend from the form submission
            $selectedFriend = isset($_POST['friends']) ? $_POST['friends'] : '';

            // Populate dropdown options with existing usernames
            while ($row = $result->fetch_assoc()) {
                if ($row['username'] != $user_id) {
                    // Check if the current option is the selected one, and add 'selected' attribute
                    $selected = ($row['username'] == $selectedFriend) ? 'selected' : '';
                    echo '<option value="' . $row['username'] . '" ' . $selected . '>' . $row['username'] . '</option>';
                }
            }

            // Free the result set
            $result->free_result();
            ?>
        </select>
        <input type="submit" value="Select" name="f" id="f">
    </form>
</div>

    <?php
    session_start();
    if(!isset($_SESSION['username'])) {
        header("Location: main_site.php");
        exit;
    } 
    $user_id = $_SESSION['username'];
    $password = $_SESSION['password'];
    ?>


    <?php
        require 'hackathon_database.php';
        $friend = $_POST['friends'];
        $stmt = $mysqli->prepare("SELECT * FROM `wishlist` WHERE `wisher` = ?");
        $stmt->bind_param('s', $friend);
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
            $stmt2 = $mysqli->prepare("SELECT * FROM `posts` WHERE `id` = ?");
            $stmt2->bind_param('i',$id);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $post = $result2->fetch_assoc();
                echo "<tr class='restaurant-row-wishlist'>";
                echo "<td class='restaurant-link'><iframe src='" . htmlspecialchars($post['link']) . "' style='height: 60rem; width: 120rem;'></iframe></td>";
                echo "<td class='posted-by'> Suggested by: " . htmlspecialchars($post['posted_by']) . "\n</td>";
                echo "<td class='restaurant-title-wishlist'>" . htmlspecialchars($post['title']) . "<br></td>";
                echo "<td class='restaurant-body'>" . htmlspecialchars($post['body']) . "<br></td>" ;
        }
        echo "</table>";
        echo "</ul>\n"; 
    ?>
</body>
</html>