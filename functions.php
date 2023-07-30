<?php
$db = new PDO('mysql:host=localhost;dbname=dbasg', 'root', '');
function handleRegistration() {
    global $db;
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $db->lastInsertId();
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: User registration failed.";
    }
}

function handleLogin() {
    global $db;
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: Invalid username or password.";
    }
}

function handleURLShortening() {
    global $db;
    $long_url = $_POST['long_url'];
    $slug = $_POST['slug'];
    $user_id = $_SESSION['user_id'];

    $stmt = $db->prepare("SELECT COUNT(*) FROM shortened_urls WHERE slug = :slug");
    $stmt->bindParam(':slug', $slug);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $slug = generateUniqueSlug($slug);
    }

    $stmt = $db->prepare("INSERT INTO shortened_urls (long_url, slug, user_id) VALUES (:long_url, :slug, :user_id)");
    $stmt->bindParam(':long_url', $long_url);
    $stmt->bindParam(':slug', $slug);
    $stmt->bindParam(':user_id', $user_id);

    if ($stmt->execute()) {
        $short_url = "http://<your_web_domain>/$slug"; 
        $stmt = $db->prepare("UPDATE shortened_urls SET short_url = :short_url WHERE slug = :slug");
        $stmt->bindParam(':short_url', $short_url);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();

        echo "Shortened URL: $short_url";
    } else {
        echo "Error: URL shortening failed.";
    }
}

function generateUniqueSlug($original_slug) {
    global $db;
    $slug = $original_slug;
    $counter = 1;

    while (true) {
        $temp_slug = $slug . $counter;
        $stmt = $db->prepare("SELECT COUNT(*) FROM shortened_urls WHERE slug = :slug");
        $stmt->bindParam(':slug', $temp_slug);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count === 0) {
            return $temp_slug;
        }

        $counter++;
    }
}

function getShortenedURLs($user_id) {
    global $db;

    $stmt = $db->prepare("SELECT * FROM shortened_urls WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $urls = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $urls;
}
?>

