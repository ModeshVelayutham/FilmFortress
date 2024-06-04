<?php
include 'config.php';

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['username'];
    $pwd = $_POST['password'];
    
    debug_to_console("User pwd: {$_POST['password']}");
        
    $sql = "SELECT * FROM users WHERE username =?";

    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uname);

    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $db_name = $row['username'];
        $db_pwd = $row['password'];  
        
        if (password_verify($pwd, $db_pwd)) {
            session_start();
            $_SESSION['username'] = $uname;
            header('Location: user_dashboard.php');
        } else {
            $error_message = "Invalid username or password";
        }
    } else {
        $error_message = "Invalid username or password";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmFortress</title>
    <style>
        body {
            background-image: url('background.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Roboto';
        }

        #content {
            background-color: rgba(255, 255, 255, 0);
            padding: 20px;
            border-radius: 5px;
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

        #login-form {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: rgba(155, 155, 155, 0.5);
        }

        #login-form label {
            display: block;
            font-weight: bold;
            font-size: 18px;
        }

        #login-form input[type="text"],
        #login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 30px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        #login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .button {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            margin: 5px;
        }

        .button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
        
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Home</a>
    </div>
    <div id="content">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="login-form">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <input type="submit" value="Login">
            <div id="button-container">
                <a href="index.php" class="button">Go Back</a>
                <a href="register.php" class="button">Not a Registered User?</a>
            </div>
        </form>
        <?php
        if (!empty($error_message)) {
            echo '<div class="error-message">' . $error_message . '</div>';
        }
        ?>
    </div>
</body>
</html>
