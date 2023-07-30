<?php
//Farhans aziz hermansya-2440044251
session_start();

require 'config.php';
require 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['shorten_url'])) {
    handleURLShortening();
}

$user_id = $_SESSION['user_id'];
$urls = getShortenedURLs($user_id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>URL Shortener - Dashboard</title>
</head>
<body>
    <h1>Welcome to Your Dashboard, <?php echo $_SESSION['username']; ?></h1>
    <form method="post">
        <label for="long_url">Long URL:</label>
        <input type="text" name="long_url" required>
        <br>
        <label for="slug">Slug:</label>
        <input type="text" name="slug" required>
        <br>
        <button type="submit" name="shorten_url">Shorten URL</button>
    </form>

    <h2>Your Shortened URLs:</h2>
    <ul>
        <?php foreach ($urls as $url) { ?>
            <li>
                <a href="<?php echo $url['slug']; ?>" target="_blank">
                    <?php echo $url['slug']; ?>
                </a>
                (Visited <?php echo $url['visit_count']; ?> times)
            </li>
        <?php } ?>
    </ul>

    <form method="post" action="logout.php">
        <button type="submit" name="logout">Logout</button>
    </form>
</body>
</html>
