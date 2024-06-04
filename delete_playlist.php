<?php
session_start();
include 'config.php';

if (isset($_GET['id'])) {
    $playlist_id = $_GET['id'];

    $sql = "DELETE FROM playlists WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $playlist_id);

    if ($stmt->execute()) {
        header("Location: manage_playlist.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();

header("Location: manage_playlist.php");
exit();
?>
