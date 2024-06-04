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
    $pwd = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    
    debug_to_console("Username: {$uname}");
    debug_to_console("Password: {$_POST['password']}");
    debug_to_console("Email: {$email}");
    
    $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $uname, $pwd, $email);

    try {
        if ($stmt->execute()) {
            session_start();
            $_SESSION['username'] = $uname;
            header('Location: user_dashboard.php');
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            $error_message = "Username already exists. Please choose another username.";
        } else {
            $error_message = "Error: " . $e->getMessage();
        }
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
    <title>FilmFortress - Register</title>
    <style>
        body {
            background-image: url('background.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
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

        h1 {
            color: #fff;
            text-shadow: 
                -1.5px -1.5px 0 #4CAF50,  
                1.5px -1.5px 0 #4CAF50,
                -1.5px 1.5px 0 #4CAF50,
                1.5px 1.5px 0 #4CAF50;
            margin-top: 20px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0);
            padding: 10px 20px;
            border-radius: 5px;
        }

        #content {
            background-color: rgba(255, 255, 255, 0);
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }

        #register-form {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f2f2f2;
        }

        #register-form label {
            display: block;
            font-weight: bold;
            font-size: 18px;
        }

        #register-form input[type="text"],
        #register-form input[type="password"],
        #register-form input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        #register-form input[type="submit"] {
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
            justify-content: center;
            margin-top: 10px;
        }

        .button {
            display: inline-block;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
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
    <h1>FilmFortress</h1>
<div id="content">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="register-form">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <input type="submit" value="Register">
        <div id="button-container">
            <a href="index.php" class="button">Go Back</a>
        </div>
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
    </form>
</div>
</body>
</html>
