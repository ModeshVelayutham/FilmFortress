<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FilmFortress</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <style>
        body {
            background-image: url('background.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
            font-family: 'Roboto';
        }

        .navbar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            background-color: rgba(255, 255, 255, 0);
            padding: 10px 20px;
            box-sizing: border-box;
            position: absolute;
            top: 0;
        }

        .navbar a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .navbar a:hover {
            background-color: #4CAF50;
            color: white;
        }

        .login-button {
            margin-top: 10px;
        }
        .login-button a {
            
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
        }

        .login-button a:hover {
            background-color: #45a049;
        }

        h1 {
            margin-top: 80px;
            color: #fff;
            text-shadow: 
                -1.5px -1.5px 0 #4CAF50,  
                1.5px -1.5px 0 #4CAF50,
                -1.5px 1.5px 0 #4CAF50,
                1.5px 1.5px 0 #4CAF50;
            padding: 10px 20px;
            border-radius: 5px;
        }

        h2 {
            color: #fff;
            text-shadow: 
                -1.5px -1.5px 0 #4CAF50,  
                1.5px -1.5px 0 #4CAF50,
                -1.5px 1.5px 0 #4CAF50,
                1.5px 1.5px 0 #4CAF50;
            padding: 10px 20px;
            border-radius: 5px;
            width: 80%;
            text-align: center;
        }

        .button {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
        }

        .button:hover {
            background-color: #45a049;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: rgba(255, 255, 255, 0);
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
        }

        li a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }

        li a:hover {
            color: #45a049;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        input[type="text"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 80%;
            box-sizing: border-box;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    
    </style>
    <div class="navbar">
        <a href="index.php">Home</a>
        <div class="login-button">
            <a href="login.php">Login</a>
        </div>
    </div>
    <h1>FilmFortress</h1>
    <h2>Welcome to the movie library!</h2>
    <a href="register.php" class="button">Sign Up</a>
    <a href="login.php" class="button">Sign In</a>
    
    <?php
    
    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

    ?>
    
</body>
</html>