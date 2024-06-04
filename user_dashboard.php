<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmFortress</title>
    <style>
        body {
            font-family: 'Roboto';
            background-image: url('background.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        .navbar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            background-color: rgba(255, 255, 255, 0);
            padding: 10px 0;
            box-sizing: border-box;
            position: absolute;
            top: 0;
            z-index: 9999;
        }

        .navbar a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 0 5px;
        }

        .navbar a:hover {
            background-color: #4CAF50;
            color: white;
        }

        .navbar a:active {
            background-color: #45a049;
        }

        .container {
            margin-top: 80px;
            padding: 20px;
            width: 80%;
            max-width: 800px;
            background-color: rgba(255, 255, 255, 0);
            border-radius: 5px;
            text-align: center;
        }

        .title {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 0.5em;
            color: #fff;
            text-shadow: 
                -1.5px -1.5px 0 #4CAF50,  
                1.5px -1.5px 0 #4CAF50,
                -1.5px 1.5px 0 #4CAF50,
                1.5px 1.5px 0 #4CAF50;
        }

        .greeting {
            color: #fff;
            text-shadow: 
                -1.5px -1.5px 0 #4CAF50,  
                1.5px -1.5px 0 #4CAF50,
                -1.5px 1.5px 0 #4CAF50,
                1.5px 1.5px 0 #4CAF50;
            font-weight: bold;
            font-size: 1.5em;
            margin-bottom: 0.5em;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .button-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(255, 255, 255, 0);
            padding: 20px;
            border-radius: 5px;
            width: 45%;
        }

        .button-box button {
            margin-bottom: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        .button-box button:hover {
            background-color: #45a048;
        }
        
    </style>
</head>
<body>
    <div class="navbar">
        <div></div>
        <a href="index.php">Logout</a>
    </div>
    <div class="container">
        <?php
        session_start();
        include 'config.php';
        
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                echo '<div class="greeting">Hello, ' . $username . '!</div>';
            }

            $stmt->close();
        } else {
            echo '<div class="greeting">Hello, Guest!</div>';
        }
        ?>
        <div class="title">Welcome to FilmFortress</div>
        <div class="button-container">
            <div class="button-box">
                <button onclick="window.location.href='movie.php'">Browse Movies</button>
            </div>
            <div class="button-box">
                <button onclick="window.location.href='manage_playlist.php'">Playlists</button>
            </div>
        </div>
    </div>
</body>
</html>
