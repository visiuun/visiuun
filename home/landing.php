<?php
session_start();
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "my_visiuun";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve logged-in user data if the session is active
$userProfilePicture = "/data/Landing/profile.png"; // Default profile picture
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT profile_picture FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userProfilePicture = $row['profile_picture'] ?: $userProfilePicture; // Use database picture if available
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Visiuun Landing Page">
    <meta property="og:title" content="Visiuun - Landing Page">
    <meta property="og:description" content="Welcome to Visiuun, a platform for various tools and products. Explore Nekobox, Neko chatbot, Weather app, Fetish Wiki, and much more!">
    <meta property="og:image" content="https://visiuun.altervista.org/data/Landing/preview.png">
    <meta property="og:url" content="https://visiuun.altervista.org/home/landing">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Visiuun">
    <meta property="og:locale" content="en_US">
    <title>Landing Page</title>
    <link rel="stylesheet" href="/data/Styles/landing.css">
    <link rel="manifest" href="/data/Landing/manifest.json">
    <link rel="icon" href="/data/Icons/visiuun_altervista_logow-s.png" type="image/x-icon">
    
    <!-- Additional Open Graph tags -->
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Preloading critical resources -->
    <link rel="preload" href="https://visiuun.altervista.org/data/Landing/nekobox.png" as="image">
    <link rel="preload" href="https://visiuun.altervista.org/data/Landing/chatbot.png" as="image">
    <link rel="preload" href="https://visiuun.altervista.org/data/Landing/rps.png" as="image">
    <link rel="preload" href="https://visiuun.altervista.org/data/Landing/clock.png" as="image">
    <link rel="preload" href="https://visiuun.altervista.org/data/Landing/keyboard.png" as="image">
    <link rel="preload" href="https://visiuun.altervista.org/data/Landing/weather.png" as="image">
    <link rel="preload" href="https://visiuun.altervista.org/data/Landing/signature.png" as="image">
    <link rel="preload" href="https://visiuun.altervista.org/data/Landing/wikithumbnaill.png" as="image">

    <!-- Preloading JavaScript files -->
    <link rel="preload" href="/data/Scripts/JS/cookies.js" as="script">
    <link rel="preload" href="/data/Scripts/JS/pageFX.js" as="script">
</head>
<body>
    <!-- Navigation Bar -->
    <header class="navbar">
        <div class="logo">
            <a href="/home/landing">
                <img src="/data/Icons/visiuun_altervista_logow.png" alt="Visiuun Logo">
            </a>
        </div>
        <nav>
            <a href="#products">Products</a>
            <a href="/home/privacy">Privacy Policy</a>
            <a href="/home/terms">Terms Of Service</a>
            <!-- Profile Picture with Link -->
            <?php if($userId==''){?>
            <a href="/home/login" class="profile-link">
            <img src="https://visiuun.altervista.org/data/Landing/profile.png" alt="Profile Picture" class="profile-pic">
            </a>
            <?php }else{?>
            <a href="/home/profile" class="profile-link">
                <img src="<?php echo htmlspecialchars($userProfilePicture); ?>" alt="Profile Picture" class="profile-pic">
                <!-- script js per rendere invisibile la pfp predefinita e rimpiazzarla con quella loggata (predefinita default-pic, utente user-pic)-->
            </a>
            <?php } ?>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero" data-scroll>
        <h1 class="fancy-wipe">
            <span class="animated-text">
                Hi, I am Vis.	
            </span>
            <span class="wipe-in">
                Hi, I am Vis.	
            </span>
            <span class="blur-in">
                Hi, I am Vis.
            </span>
        </h1>
        <p class="fancy-wipe">
            <span class="animated-text">
                Welcome To My Website.	
            </span>
            <span class="wipe-in">
                Welcome To My Website.	
            </span>
            <span class="blur-in">
                Welcome To My Website.
            </span>
        </p>

        <a href="#products" class="cta">Explore Now</a>
    </section>

<!-- Products Section -->
<section id="products" class="products" data-scroll>
    <h2>My Products</h2>
    <div class="product-grid">
        <div class="product" data-scroll>
            <a href="/Nekobox/upload" target="_blank">
                <img src="https://visiuun.altervista.org/data/Landing/nekobox.png" alt="Nekobox">
            </a>
            <h3>Nekobox</h3>
            <p>Free File Hosting And Sharing Platform.</p>
            <div class="button-container">
                <a href="/Nekobox/upload" class="button" target="_blank">Try it out</a>
            </div>
        </div>

        <div class="product" data-scroll>
            <a href="/chatbot/neko" target="_blank">
                <img src="https://visiuun.altervista.org/data/Landing/chatbot.png" alt="Neko">
            </a>
            <h3>Neko</h3>
            <p>A Very Basic Chatbot That Almost Never Works.</p>
            <div class="button-container">
                <a href="/chatbot/neko" class="button" target="_blank">Try V1</a>  
                <a href="/chatbotv2/neko" class="button" target="_blank">Try V2</a>
            </div>
        </div>

        <div class="product" data-scroll>
            <a href="/home/apis" target="_blank">
                <img src="https://pic.re/image" alt="APIS">
            </a>
            <h3>APIS</h3>
            <p>Documentation And Information On My API Endpoints</p>
            <div class="button-container">
                <a href="/home/apis" class="button" target="_blank">Documentation</a>
            </div>
        </div>

        <div class="product" data-scroll>
            <a href="/tools/rps/rps" target="_blank">
                <img src="https://visiuun.altervista.org/data/Landing/rps.png" alt="RPS">
            </a>
            <h3>Rock Paper Scissors Dice</h3>
            <p>A Rock Paper Scissors Dice Game.</p>
            <div class="button-container">
                <a href="/tools/rps/rps" class="button" target="_blank">Play</a>
            </div>
        </div>

        <div class="product" data-scroll>
            <a href="/clock/pink" target="_blank">
                <img src="https://visiuun.altervista.org/data/Landing/clock.png" alt="clock">
            </a>
            <h3>Animated Clock</h3>
            <p>A Pink Or Black Animated Clock.</p>
            <div class="button-container">
                <a href="/clock/pink" class="button" target="_blank">Pink Clock</a>  
                <a href="/clock/dark/dark" class="button" target="_blank">Black Clock</a>
            </div>
        </div>

        <div class="product" data-scroll>
            <a href="/games/keyboard/keyboard" target="_blank">
                <img src="https://visiuun.altervista.org/data/Landing/keyboard.png" alt="keyboard">
            </a>
            <h3>Keyboard Speed Game</h3>
            <p>A Challenging Game To Test Your Reaction Speed And Accuracy.</p>
            <div class="button-container">
                <a href="/games/keyboard/keyboard" class="button" target="_blank">Play</a>  
            </div>
        </div>

        <div class="product" data-scroll>
            <a href="/tools/weather/app" target="_blank">
                <img src="https://visiuun.altervista.org/data/Landing/weather.png" alt="weather">
            </a>
            <h3>Weather App</h3>
            <p>A weather interface showing your weather forecast based on actual location.</p>
            <div class="button-container">
                <a href="/tools/weather/app" class="button" target="_blank">Try it out</a>  
            </div>
        </div>

        <div class="product" data-scroll>
            <a href="/tools/signature/ui" target="_blank">
                <img src="https://visiuun.altervista.org/data/Landing/signature.png" alt="signature">
            </a>
            <h3>Signature Animator</h3>
            <p>A signature text animator: You input text and it animates it for you.</p>
            <div class="button-container">
                <a href="/tools/signature/ui" class="button" target="_blank">Try it out</a>  
            </div>
        </div>

        <div class="product" data-scroll>
            <a href="/home/fetishes/home" target="_blank">
                <img src="https://visiuun.altervista.org/data/Landing/wikithumbnaill.png" alt="fetish">
            </a>
            <h3>Fetish Wiki</h3>
            <p>A Work In Progress Wiki About Most Of The Existing Fetishes (For Information Purposes).</p>
            <div class="button-container">
                <a href="/home/fetishes/home" class="button" target="_blank">Open The Wiki</a>  
            </div>
        </div>
    </div>
</section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Visiuun. All rights reserved.</p>
        <p><a href="/home/privacy">Privacy Policy</a> | <a href="/home/terms">Terms of Service</a></p>
    </footer>
</body>
</html>
<script src="/data/Scripts/JS/cookies.js"></script>
<script src="/data/Scripts/JS/pageFX.js"></script>
</body>
</html>