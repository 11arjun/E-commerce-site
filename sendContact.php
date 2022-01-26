<?php
require_once 'utils/mail.php';
require_once 'utils/utils.php';
require_once 'utils/sessionManager.php';
extract($_POST);

$old = $_POST;

$data = sanitize_array($_POST);

$name = $data['name'];
$email = $data['email'];
$subject = $data['subject'];
$message = $data['message'];

$errors = [];

if (empty($name)) {
    $errors['name'] = "Name is required";
}

if (empty($email)) {
    $errors['email'] = "Email is required";
} elseif (!preg_match('/^\S+@\S+\.\S+$/', $email)) {
    $errors['email'] = "Please enter a valid email";
}

if (empty($subject)) {
    $errors['subject'] = "Subject is required";
}

if (empty($message)) {
    $errors['message'] = "Message is required";
}

$mail = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #EFEEEA;
            font-family: Georgia, Times, \'Times New Roman\', serif;
            margin: 0;
        }

        a {
            color: #6A655F;
        }

        .yellow-back {
            background-color: #FFE01B;
            text-align: center;
            padding: 50px 0 100px 0;
            width: 100%;
        }

        .yellow-back img {
            height: 75px;
        }

        .contentbox {
            background-color: #ffffff;
            max-width: 640px;
            padding: 45px 0;
            text-align: center;
            margin: auto;
            margin-top: -50px;
            margin-bottom: 50px;
        }

        .content {
            word-wrap: break-word;
            width: 400px;
            margin: auto;
        }

        .message {
            font-weight: 400;
            line-height: 42px;
            font-size: 28px;
            letter-spacing: .3px;
        }

        .tagline {
            display: block;
            font-size: 16px;
            margin-bottom: 40px;
            color: #6A655F;
            font-family: \'Helvetica Neue\', Helvetica, Arial, Verdana, sans-serif;
        }

        .footer {
            font-size: 12px;
            padding-top: 40px;
            line-height: 24px;
            border-top: 2px solid #EFEEEA;
            color: #6A655F;
            font-family: \'Helvetica Neue\', Helvetica, Arial, Verdana, sans-serif;
        }

        .links a {
            color: #007C89;
            font-weight: 500;
            text-decoration: none;
        }

        table {
            border-collapse: collapse;
            box-shadow: 0 5px 10px #e1e5ee;
            background-color: white;
            text-align: left;
            overflow: hidden;
            width: 100%;
        }

        thead {
            box-shadow: 0 5px 10px #e1e5ee;
        }

        th {
            padding: 1rem 2rem;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            font-size: 0.7rem;
            font-weight: 900;
        }

        td {
            padding: 1rem 2rem;
        }

        tr:nth-child(even) {
            background-color: #f4f6fb;
        }
    </style>
</head>

<body>
    <div class="yellow-back">
        <img src="http://localhost/assets/images/black-white.png" alt="OnlineAppetite">
    </div>
    <div class="contentbox">
        <div class="content">
            <div class="message">Contact Mail From:<br> ' . $name . '</div>
            <span class="tagline">' . $email . '</span>
            <table>
                <tbody>
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tr>
                        <td>Name</td>
                        <td>' . $name . '</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>' . $email . '</td>
                    </tr>
                    <tr>
                        <td>Subject</td>
                        <td>' . $subject . '</td>
                    </tr>
                    <tr>
                        <td>Message</td>
                        <td>' . $message . '</td>
                    </tr>
                </tbody>
            </table>
            <div class="footer">
                &copy;2020-2021 OnlineAppetite<sup>&trade;</sup>, All rights reserved.<br>
                J-302 Suncity Apartments • Pepsicola, Kathmandu • Bagmati, Nepal
                <div class="links">
                    <a href="http://localhost/customer.php">Contact Us</a> •
                    <a href="http://localhost/toc.php">Terms of Use</a> •
                    <a href="http://localhost/privacy.php">Privacy Policy</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>';
if (count($errors) == 0) {
    $send = sendMail('appetiteonline0@gmail.com', 'Contact Form Recieved', $mail);
    if ($send) {
        $_SESSION['message'] = ['message' => 'Contact message recieved. Thank you', 'color' => 'success'];
    } else {
        $_SESSION['message'] = ['message' => 'Sorry, Error while sending contact form.', 'color' => 'danger'];
        $_SESSION['old'] = $old;
    }
} else {
    $_SESSION['message'] = ['message' => 'Please fix the following errors.', 'color' => 'danger'];
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $old;
}

header('Location: customerCare.php');
