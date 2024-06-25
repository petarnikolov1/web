<?php
if ($argc != 2) {
    echo "Usage: php add_meme.php <path_to_image>\n";
    exit(1);
}

$image_path = $argv[1];

if (!file_exists($image_path)) {
    echo "Error: File not found at '$image_path'\n";
    exit(1);
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "presentation_invite_creator";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$image_content = addslashes(file_get_contents($image_path));

$sql = "INSERT INTO memes (meme_image) VALUES ('$image_content')";
if ($conn->query($sql) === TRUE) {
    echo "Meme image added to the database\n";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
