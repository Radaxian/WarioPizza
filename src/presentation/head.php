<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="autor" value="Thomas Stynes">
    <link href="https://fonts.googleapis.com/css2?family=MuseoModerno&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./public/styles/main.css">
    <title>Wario Pizza</title>
</head>
<body>
    <a href="../index.php">home</a>
    <header id="banner">
        <h1><a href="index.php">WARIO PIZZA</a></h1>
        <nav>
            <ul>
                <li><a href="menu.php">Menu</a></li>
                <?php if (!isset($_SESSION['authorized'])) :?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main class="container">

    
    
