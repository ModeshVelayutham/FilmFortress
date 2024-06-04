<?php
session_start();
include 'config.php';

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

$username = $_SESSION['username'];
$sql = "SELECT DISTINCT playlist_name, movies, id FROM playlists WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$playlists = [];
while ($row = $result->fetch_assoc()) {
    $playlists[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FilmFortress</title>
    <style>
        p{
            font-weight: bold;
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
        h2 {
            background-color: rgba(255, 255, 255, 0);
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            color: #333;
        }
        body {
            font-family: 'Roboto';
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            display:flex;
            justify-content: center;
            align-items:center;
            min-height: 90vh;
            flex-direction: column;
        }
        .container {
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }
        .button {
            display: inline-block;
            margin: 10px 5px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            text-align: center;
        }
        .button:hover {
            background-color: #45a049;
        }
        .delete {
            display: inline-block;
            margin: 10px 5px;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            text-align: center;
        }
        .delete:hover {
            background-color: #e53935;
        }
        .playlist {
            margin-bottom: 20px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .playlist strong {
            display: block;
            margin-bottom: 5px;
            font-size: 1.2em;
            color: #333;
        }
        .playlist-actions {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="user_dashboard.php">Go Back</a>
        <a href="create_playlist.php">Create Playlist</a>
    </div>
    <h2>Manage Playlists</h2>
    <div class="container">
        <?php if (empty($playlists)): ?>
            <p>No playlists found. <a href="create_playlist.php" class="button">Create a new playlist</a></p>
        <?php else: ?>
            <ul>
                <?php foreach ($playlists as $playlist): ?>
                    <li class="playlist">
                        <strong><?php echo htmlspecialchars($playlist['playlist_name']); ?></strong><br>
                        Movies: <?php echo implode(', ', json_decode($playlist['movies'], true)); ?><br>
                        <a href="edit_playlist.php?id=<?php echo $playlist['id']; ?>" class="button">Edit</a>
                        <a href="delete_playlist.php?id=<?php echo $playlist['id']; ?>" class="delete">Delete</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>
