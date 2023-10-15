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
        require 'hackathon_database.php';
        session_start();
        $user_id = $_SESSION['username'];
       /* $sort = $_POST['sort'];
        $orderClause = 'ORDER BY title ASC';
        if ($sort == 'Restaurant Name') {
            $orderClause = 'ORDER BY title ASC';
        } 
        if ($sort == 'Most recent') {
            $orderClause = 'ORDER BY id DESC';
        } */
     
        $stmt = $mysqli->prepare("SELECT * FROM `posts`");
        
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->execute();
        $result = $stmt ->get_result();
        echo "<ul class='restaurant-list'>\n";
        echo "<table class='restaurant-table'>";
        while ($row = $result->fetch_assoc()) {
            if ($row['posted_by'] == $user_id) {
                echo "<tr class='restaurant-row-mine'>";
                echo "<td class='posted-for-mine'> Suggested for: " . htmlspecialchars($row['for_who']) . "\n</td>";
                echo "<td class='restaurant-title-mine'>" . htmlspecialchars($row['title']) . "<br></td>";
                echo "<td class='restaurant-body'>" . htmlspecialchars($row['body']) . "<br></td>" ;
                echo "<td class='restaurant-link'><iframe src='" . htmlspecialchars($row['link']) . "' style='height: 60rem; width: 120rem;'></iframe></td>";
                echo "</tr>";
                echo "<br>";
                echo "<br>";
            }
        }
        echo "</table>";
        echo "</ul>\n"; 
    ?>
</body>
</html>