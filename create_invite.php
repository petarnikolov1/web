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

    function sendInvite($invite, $to, $conn, $faculty_number, $imagePath = null)
    {
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
            
            if ($imagePath) {
                $mail->addAttachment($imagePath);
                $mail->Body = "Invite meme";
            } else {
                $mail->Body = $invite;
            }

            $mail->isHTML(true);
            $mail->Subject = 'Presentation Invite';
            

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
        $sql = "SELECT meme_image FROM memes ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $meme_image_content = $row['meme_image'];
    $meme_image = imagecreatefromstring($meme_image_content);

    if ($meme_image !== false) {
        $font_path = 'DejaVuSans.ttf';
        $text_color = imagecolorallocate($meme_image, 0, 0, 0);

        $font_size = 15;

        $image_width = imagesx($meme_image);
        $image_height = imagesy($meme_image);

        $text = "Ела на $date във ФМИ от $hour ще презентира $presenter ($faculty_number)";

        $text_lines = explode("\n", wordwrap($text, 50)); 

        $line_height = $font_size + 10; 
        $y = 70;

        foreach ($text_lines as $line) {
            $bbox = imagettfbbox($font_size, 0, $font_path, $line);
            $text_width = $bbox[2] - $bbox[0];

            $x = ($image_width - $text_width) / 2;

            imagettftext($meme_image, $font_size, 0, $x, $y, $text_color, $font_path, $line);

            $y += $line_height;
        }

        header('Content-Type: image/jpeg');

        imagejpeg($meme_image);

        $imagePath = 'modified_meme.jpg';
        imagejpeg($meme_image, $imagePath);
        imagedestroy($meme_image);

        $invite = "";


        sendInvite($invite, $email, $conn, $faculty_number, $imagePath);
        unlink($imagePath);
    } else {
        echo "Error creating image from database content.";
    }
} else {
    echo "No meme image found in the database.";
}
    }

    $conn->close();
}
?>