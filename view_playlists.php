<?php
session_start();
include 'config.php';

$username = $_SESSION['username'];

$sql = "SELECT * FROM playlists WHERE username = ?";
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
</head>
<body>
    <h2>Your Playlists</h2>
    <?php if (empty($playlists)): ?>
        <p>No playlists found. <a href="create_playlist.php">Create a new playlist</a></p>
    <?php else: ?>
        <ul>
            <?php foreach ($playlists as $playlist): ?>
                <li>
                    <strong><?php echo htmlspecialchars($playlist['playlist_name']); ?></strong><br>
                    Movies: <?php echo implode(', ', json_decode($playlist['movies'], true)); ?><br>
                    <a href="edit_playlist.php?id=<?php echo $playlist['id']; ?>">Edit</a>
                    <a href="delete_playlist.php?id=<?php echo $playlist['id']; ?>">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
