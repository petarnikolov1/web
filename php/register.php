<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);

    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "presentation_invite_creator";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        header("Location: ../register.html");
        echo '<div style="color: red;">';
        echo "User with this email already exists.";
        echo '</div>';
        $stmt->close();
        $conn->close();
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        header("Location: ../login.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>