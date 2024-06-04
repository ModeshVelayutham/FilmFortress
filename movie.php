<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FilmFortress</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
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
            margin-top: 80px;
            background-color: rgba(255, 255, 255, 0);
            padding: 10px 20px;
            border-radius: 5px;
            color: #333;
        }

        .movie-list {
            list-style-type: none;
            padding: 0;
        }

        .movie-list li {
            margin-bottom: 10px;
            font-weight:bold;
        }

        .movie-link {
            text-decoration: none;
            color: #333;
        }

        .movie-link:hover {
            color: #4CAF50;
        }

        .error-message {
            color: red;
        }
        .search{
            color:white;
            background-color: #4CAF50;
            border-radius: 5px;
        }
        .search:hover{
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Movie Details</h1>
    <form method="GET" action="movie.php">
        <input type="text" name="search" placeholder="Search for a movie...">
        <button type="submit" class="search">Search</button>
    </form>
    <?php

    function debug_to_console($data)
    {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $apiKey = '2e61f8ed';
        $url = "http://www.omdbapi.com/?i=$id&apikey=$apiKey";

        $response = file_get_contents($url);
        $movie = json_decode($response, true);

        if ($movie['Response'] == 'True') {
            echo '<h2>' . $movie['Title'] . ' (' . $movie['Year'] . ')</h2>';
            echo '<p><strong>Genre:</strong> ' . $movie['Genre'] . '</p>';
            echo '<p><strong>Director:</strong> ' . $movie['Director'] . '</p>';
            echo '<p><strong>Actors:</strong> ' . $movie['Actors'] . '</p>';
            echo '<p><strong>Plot:</strong> ' . $movie['Plot'] . '</p>';
            echo '<img src="' . $movie['Poster'] . '" alt="Poster">';
        } else {
            echo '<p>Movie not found.</p>';
        }
    }
    if (isset($_GET['search'])) {
        $search = urlencode($_GET['search']);
        $apiKey = '2e61f8ed';
        $url = "http://www.omdbapi.com/?s=$search&apikey=$apiKey";

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if ($data['Response'] == 'True') {
            echo '<ul class="movie-list">';
            foreach ($data['Search'] as $movie) {
                echo '<li>';
                echo '<a href="movie.php?id=' . $movie['imdbID'] . '" class="movie-link">' . $movie['Title'] . ' (' . $movie['Year'] . ')</a>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p class="error-message">No movies found.</p>';
        }
    }
    ?>
    <div class="navbar">
        <a href="user_dashboard.php">Go Back</a>
    </div>
</body>
</html>
