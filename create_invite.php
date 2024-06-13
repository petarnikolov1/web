<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = htmlspecialchars($_POST['date']);
    $hour = htmlspecialchars($_POST['hour']);
    $presenter = htmlspecialchars($_POST['presenter']);
    $faculty_number = htmlspecialchars($_POST['faculty_number']);
    $email = htmlspecialchars($_POST['email']);
    $invite_type = htmlspecialchars($_POST['invite_type']);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "presentation_invite_creator";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function sendInvite($invite, $to, $conn, $faculty_number) {
        $mail = new PHPMailer(true);
        
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'web12345678@abv.bg';
            $mail->Password = 'Web123456789';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('web12345678@abv.bg', 'Invite Sender');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = 'Presentation Invite';
            $mail->Body    = $invite;

            $mail->send();
            echo "Invite has been sent to $to";
            $email_status = "sent";
        } catch (Exception $e) {
            echo "Failed to send invite to $to. Mailer Error: {$mail->ErrorInfo}";
            $email_status = "failed";
        }

        $sql = "INSERT INTO invite_log (faculty_number, email, status) VALUES ('$faculty_number', '$to', '$email_status')";
        if ($conn->query($sql) === TRUE) {
            echo "Invite log entry added to database";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if ($invite_type == "standard") {
        $invite = "
        <html>
        <head>
            <title>Presentation Invite</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    text-align: center;
                    padding: 50px;
                }
                .invite {
                    border: 2px solid #ccc;
                    padding: 20px;
                    border-radius: 10px;
                    display: inline-block;
                    max-width: 600px;
                    margin: auto;
                }
                .invite h2 {
                    color: #5cb85c;
                }
                .invite p {
                    font-size: 18px;
                }
            </style>
        </head>
        <body>
            <div class='invite'>
                <h2>Presentation Invite</h2>
                <p><strong>Date:</strong> $date</p>
                <p><strong>Hour:</strong> $hour</p>
                <p><strong>Presenter:</strong> $presenter</p>
                <p><strong>Faculty Number:</strong> $faculty_number</p>
            </div>
        </body>
        </html>
        ";

        echo $invite;

        sendInvite($invite, $email, $conn, $faculty_number);

    } elseif ($invite_type == "meme") {
        if ($_FILES['meme_image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['meme_image']['tmp_name'])) {
            $meme_image_tmp = $_FILES['meme_image']['tmp_name'];
            $meme_image_content = addslashes(file_get_contents($meme_image_tmp)); // Prevent SQL injection
            $sql = "INSERT INTO memes (meme_image) VALUES ('$meme_image_content')";
            if ($conn->query($sql) === TRUE) {
                echo "Meme image added to the database";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $sql = "SELECT meme_image FROM memes ORDER BY id DESC LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $meme_image_encoded = base64_encode($row['meme_image']);

                $invite = "
                <html>
                <head>
                    <title>Presentation Invite</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            text-align: center;
                            padding: 50px;
                            background: url('path/to/your/meme.jpg') no-repeat center center fixed;
                            background-size: cover;
                        }
                        .invite {
                            background: rgba(255, 255, 255, 0.8);
                            border: 2px solid #ccc;
                            padding: 20px;
                            border-radius: 10px;
                            display: inline-block;
                            max-width: 600px;
                            margin: auto;
                        }
                        .invite h2 {
                            color: #5cb85c;
                        }
                        .invite p {
                            font-size: 18px;
                        }
                    </style>
                </head>
                <body>
                    <div class='invite'>
                        <h2>Presentation Invite</h2>
                        <p><strong>Date:</strong> $date</p>
                        <p><strong>Hour:</strong> $hour</p>
                        <p><strong>Presenter:</strong> $presenter</p>
                        <p><strong>Faculty Number:</strong> $faculty_number</p>
                        <img src='data:image/jpeg;base64,$meme_image_encoded' alt='Meme Image'>
                    </div>
                </body>
                </html>
                ";
                
                sendInvite($invite, $email, $conn, $faculty_number);
            } else {
                echo "Error retrieving meme image from database";
            }
        } else {
            echo "Failed to upload meme image.";
        }
    }

    $conn->close();
}
?>