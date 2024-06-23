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
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'web123159@gmail.com';
            $mail->Password = 'cksbqxuahhkofnrb';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('web123159@gmail.com', 'Web presentation invite');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = 'Presentation Invite';
            $mail->Body    = $invite;

            $mail->send();
            $email_status = "sent";
        } catch (Exception $e) {
            echo "Failed to send invite to $to. Mailer Error: {$mail->ErrorInfo}";
            $email_status = "failed";
        }

        $sql = "INSERT INTO invite_log (faculty_number, email, status) VALUES ('$faculty_number', '$to', '$email_status')";
        if (!$conn->query($sql) === TRUE) {
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
         $sql = "SELECT meme_image FROM memes ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $meme_image = imagecreatefromstring($row['meme_image']);

            if ($meme_image !== false) {
                $black = imagecolorallocate($meme_image, 0, 0, 0);
                $font_path = 'path/to/your/font.ttf'; // Provide the path to your TrueType font file

                // Add text to the image
                imagettftext($meme_image, 20, 0, 10, 30, $black, $font_path, "Date: $date");
                imagettftext($meme_image, 20, 0, 10, 60, $black, $font_path, "Hour: $hour");
                imagettftext($meme_image, 20, 0, 10, 90, $black, $font_path, "Presenter: $presenter");
                imagettftext($meme_image, 20, 0, 10, 120, $black, $font_path, "Faculty Number: $faculty_number");

                ob_start();
                imagejpeg($meme_image);
                $image_data = ob_get_contents();
                ob_end_clean();

                imagedestroy($meme_image);

                $invite = "
                <html>
                <head>
                    <title>Presentation Invite</title>
                </head>
                <body>
                    <h2>Presentation Invite</h2>
                    <img src='data:image/jpeg;base64," . base64_encode($image_data) . "' alt='Meme Image'>
                </body>
                </html>
                ";

                sendInvite($invite, $email, $conn, $faculty_number);
            } else {
                echo "Error creating image from meme data.";
            }
        } else {
            echo "No meme image found in the database.";
        }
    }

    $conn->close();
}
?>