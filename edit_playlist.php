<?php
session_start();
include 'config.php';

$playlist_name = "";
$movies = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $playlist_id = $_POST['playlist_id'];
    $playlist_name = $_POST['playlist_name'];
    $movies = $_POST['movies'];

    $sql = "UPDATE playlists SET playlist_name = ?, movies = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $movies_json = json_encode($movies);
    $stmt->bind_param("ssi", $playlist_name, $movies_json, $playlist_id);

    if ($stmt->execute()) {
        header("Location: manage_playlist.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

if (isset($_GET['id'])) {
    $playlist_id = $_GET['id'];

    $sql = "SELECT * FROM playlists WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $playlist_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $playlist = $result->fetch_assoc();
        $playlist_name = $playlist['playlist_name'];
        $movies = json_decode($playlist['movies'], true);
    } else {
        echo "Playlist not found.";
        exit();
    }

    $stmt->close();
} else {
    header("Location: manage_playlist.php");
    exit();
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
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input[type="text"] {
            width: calc(100% - 80px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #777;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"], button {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #45a049;
        }

        .add{
            background-color: #4CAF50;
        }

        .remove {
            background-color: #f44336;
        }

        .remove:hover{
            background-color: #e53935;
        }
        
        .update{
            margin-top: 10px;
        }

        .movie-input {
            display: flex;
            align-items: center;
        }

        .movie-input input[type="text"] {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <span></span>
            <button class="back-btn" onclick="window.location.href='manage_playlist.php'">Back</button>
        </div>
        <h2>Edit Playlist</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="playlist_id" value="<?php echo $playlist_id; ?>">
            <label for="playlist_name">Playlist Name:</label><br>
            <input type="text" id="playlist_name" name="playlist_name" value="<?php echo htmlspecialchars($playlist_name); ?>" required><br>
            <label for="movies">Movies:</label><br>
            <div id="movieFields">
                <?php if (!empty($movies)): ?>
                    <?php foreach ($movies as $index => $movie): ?>
                        <div class="movie-input">
                            <input type="text" name="movies[]" value="<?php echo htmlspecialchars($movie); ?>" required>
                            <?php if ($index > 0): ?>
                                <button type="button" class="remove" onclick="removeMovieField(this)">Remove</button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="movie-input">
                        <input type="text" name="movies[]" required>
                    </div>
                <?php endif; ?>
            </div>
            <button type="button" class="add" onclick="addMovieField()">Add Movie</button><br>
            <input type="submit" class="update" value="Update Playlist">
        </form>
    </div>

    <script>
        function addMovieField() {
            var container = document.getElementById("movieFields");
            var input = document.createElement("input");
            input.type = "text";
            input.name = "movies[]";
            input.placeholder = "Enter movie";
            input.required = true;
            container.appendChild(document.createElement("br"));
            container.appendChild(input);
            var button = document.createElement("button");
            button.type = "button";
            button.textContent = "Remove";
            button.onclick = function() {
                removeMovieField(button);
            };
            container.appendChild(button);
        }

        function removeMovieField(button) {
            var div = button.parentElement;
            div.remove();
        }
    </script>
</body>
</html>

