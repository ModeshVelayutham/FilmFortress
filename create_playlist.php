<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $playlist_name = $_POST['playlist_name'];
    $movies = $_POST['movies'];

    $sql = "INSERT INTO playlists (username, playlist_name, movies) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $movies_json = json_encode($movies);
    $stmt->bind_param("sss", $username, $playlist_name, $movies_json);

    if ($stmt->execute()) {
        header("Location: manage_playlist.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FilmFortress</title>
    <style>
        body {
            font-family: 'Roboto';
            background-color: #fff;
            padding: 20px;
        }

        h2 {
            justify-content: center;
            display: flex;
            margin-top: 180px;
            color: #333;
        }

        form {
            font-weight:bold;
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"] {
            width: calc(100% - 22px); 
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #777;
            border-radius: 5px;
        }

        button {
            width: calc(75% - 22px);
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .button-container {
            text-align: center;
        }
        .create {
            margin-top:10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .create:hover {
            background-color: #45a049;
        }

        .create {
            width: calc(75% - 22px);
            text-align: center;
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
            z-index: 9999;
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
    </style>
    <div class = "navbar">
        <a href=manage_playlist.php>Go Back</a>
    </div>
</head>
<body>
    <h2>Create Playlist</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="playlist_name">Playlist Name:</label><br>
        <input type="text" id="playlist_name" name="playlist_name" required placeholder="Your Playlist Name"><br>
        <label for="movies">Movies:</label><br>
        <div id="movieFields">
            <input type="text" name="movies[]" placeholder="Movie Name"><br>
        </div>
        <div class="button-container">
            <button type="button" onclick="addMovieField()">Add Movie</button><br>
            <input type="submit" class="create" value="Create Playlist">
        </div>
    </form>

    <script>
        function addMovieField() {
            var container = document.getElementById("movieFields");
            var input = document.createElement("input");
            input.type = "text";
            input.name = "movies[]";
            input.placeholder = "Movie Name";
            container.appendChild(input);
            container.appendChild(document.createElement("br"));
        }
    </script>
</body>
</html>
