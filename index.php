<?php
// Simple index.php for testing
$title = "Welcome to My Website";
$current_year = date("Y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
            text-align: center;
        }
        h1 {
            color: #3498db;
            margin-bottom: 15px;
        }
        p {
            margin-bottom: 20px;
        }
        .status {
            background-color: #e8f4fd;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .success {
            color: #28a745;
            font-weight: bold;
        }
        footer {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $title; ?></h1>
        
        <p>This is a simple PHP test page to verify that everything is working correctly.</p>
        
        <div class="status">
            PHP Version: <span class="success"><?php echo PHP_VERSION; ?></span><br>
            Server: <span class="success"><?php echo $_SERVER['SERVER_SOFTWARE']; ?></span>
        </div>
        
        <p>If you can see this page, your PHP setup is working properly!</p>
        
        <footer>
            &copy; <?php echo $current_year; ?> My Website. All rights reserved.
        </footer>
    </div>
</body>
</html>