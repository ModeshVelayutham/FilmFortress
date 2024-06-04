<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $playlist_id = $_POST['playlist_id'];
    $new_movies = $_POST['new_movies'];

    $sql = "SELECT movies FROM playlists WHERE id = ? AND username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $playlist_id, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $existing_movies = json_decode($row['movies'], true);

        $updated_movies = array_merge($existing_movies, $new_movies);
        $updated_movies_json = json_encode($updated_movies);

        $sql = "UPDATE playlists SET movies = ? WHERE id = ? AND username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $updated_movies_json, $playlist_id, $username);

        if ($stmt->execute()) {
            header("Location: manage_playlist.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Playlist not found.";
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
        }
        .button {
            margin: 5px 0;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        function addMovieField() {
            var container = document.getElementById("newMovieFields");
            var input = document.createElement("input");
            input.type = "text";
            input.name = "new_movies[]";
            input.placeholder = "New Movie";
            container.appendChild(input);
            container.appendChild(document.createElement("br"));
        }
    </script>
</head>
<body>
    <h2>Add Movies to Playlist</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="playlist_id" value="<?php echo $_GET['id']; ?>">
        <label for="new_movies">New Movies:</label><br>
        <div id="newMovieFields">
            <input type="text" name="new_movies[]" placeholder="New Movie 1"><br>
        </div>
        <button type="button" class="button" onclick="addMovieField()">Add Movie</button><br>
        <input type="submit" value="Add Movies" class="button">
    </form>
</body>
</html>
