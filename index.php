<?php

    require("dbconnect.php");
    $loggedIn = false;
    $username="";
    $userid="";
    if(isset($_COOKIE['username'])&&!empty($_COOKIE['username']))
    {
        $username = $_COOKIE['username'];
        $userid = $_COOKIE['id'];
        $loggedIn = true;
    }
    $selectLastCharSql = 'SELECT id,name,nickname,description,picUrl FROM characters ORDER BY id DESC LIMIT 2';

    $resultChar = mysqli_query($con,$selectLastCharSql);

    $rows = mysqli_fetch_all($resultChar);

    $charId1 = $rows[0][0];
    $charPic1 = $rows[0][4];
    $charName1 = $rows[0][1];
    $charNick1 = $rows[0][2];
    if($charNick1 == "")
    {
        $charNick1= "Nickname";
    }
    $charDesc1 = $rows[0][3];
    if($charDesc1 == "")
    {
        $charDesc1 = "This is the side description you would put in the Rp chat. Max Char 160";
    }
    $charDesc1 = wordwrap($charDesc1,75,"<br/>\n",TRUE);

    $charId2 = $rows[1][0];
    $charPic2 = $rows[1][4];
    $charName2 = $rows[1][1];
    $charNick2 = $rows[1][2];
    if($charNick2 == "")
    {
        $charNick2 = "Nickname";
    }
    $charDesc2 = $rows[1][3];
    if($charDesc2 == "")
    {
        $charDesc2 = "This is the side description you would put in the Rp chat. Max Char 160";
    }
    $charDesc2 = wordwrap($charDesc2,75,"<br/>\n",TRUE);

?>

<!doctype html>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Home Page</title>


    <!-- Jquery -->
    <script src="js/jquery-3.1.1.js"></script>

    <!-- Custom script file -->
    <script src="js/scripts.js"></script>

    <!-- Custom css -->
    <link rel="stylesheet" href="css/main.css">
    <link href="singlePageTemplate.css" rel="stylesheet" type="text/css">
</head>
	<header>
		<h2>
            <form role="form" method="post" id="searchForm">
                <input type="text" id="keyword" placeholder="Enter keyword">
                <label for="searchUser">Search by user</label>
                <input type="radio" value="searchUser" name="searchType" id="searchUser" checked>
                <label for="searchCharacter">Search by character</label>
                <input type="radio" value="searchCharacter" name="searchType" id="searchCharacter">
            </form>
            <ul id="content"></ul>
           
            <?php
                if(!$loggedIn)
                {
                    echo '<a href="signUp.php" class="button"> Sign Up</a>
                            <a href="login.php" class="button"> Log In</a>';
                }
                else
                {
                    echo '<label style="color: #2C9AB7;letter-spacing: 2px;font-family: serif;font-size: 1.2em;font-weight: bold">Welcome <a href="userProfile.php?uid='.$userid.'">'.$username.'</a></label>';
                }
            ?>
        </h2>
	</header>
	<body>
	<section class="hero" id="hero">
    <h2 class="hero_header">Welcome to the Island of Saari</h2>
    
</section>
  <!-- Stats Gallery Section -->
  <div class="gallery">
    <div class="thumbnail">
		<h1 class="stats"><a href="http://www.chatzy.com/62679342644637" class="button">The Chat</a></h1>
    </div>
    <div class="thumbnail">
      <h1 class="stats"><a href="Rulez.html" class="button">Chat Rules</a></h1>
    </div>
    <div class="thumbnail">
      <h1 class="stats"><a href="allcharacters.php" class="button">Characters</a></h1>
    </div>
    <div class="thumbnail">
      <h1 class="stats"><a href="allusers.php" class="button">Users</a></h1>
    </div>
  </div>
  <!-- Parallax Section -->
  <section class="banner">
    <h2 class="right_article"><a href="http://i.imgur.com/MQjnphd.jpg" class="button">The Map</a></h2>
 <h2 class="left_article"><a href="Floors.html" class="button">The House</a></h2>
    <h2 class="parallax">&nbsp;</h2>
  </section>
  <!-- More Info Section -->
    <article class="footer_column">
        <h3>Newest Character</h3>
        <img src="<?php echo $charPic1 ?>" alt="" style="width: 200px; height: 200px; object-fit: contain" class="cards"/>
        <h2><a href="characterProfile.php?cid=<?php echo $charId1 ?>"><?php echo $charName1 ?></a></h2>
        <h1> <?php echo $charNick1 ?> </h1>
        <p><?php echo $charDesc1 ?></p>
    </article>
    <article class="footer_column">
        <h3> Second Newest Character</h3>
        <img src="<?php echo $charPic2 ?>" alt="" style="width: 200px; height: 200px; object-fit: contain" class="cards"/>
        <h2> <a href="characterProfile.php?cid=<?php echo $charId2 ?>"><?php echo $charName2 ?></a> </h2>
        <h1> <?php echo $charNick2 ?> </h1>
        <p> <?php echo $charDesc2 ?> </p>
    </article>

  <!-- Parallax Section -->
  <section class="Banner">
    
 
    

  <!-- Copyrights Section -->
<!-- Main Container Ends -->

</body>
</html>