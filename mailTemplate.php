<?php

function makeMail($message, $link, $button, $secondaryLink, $tagline)
{
    $mail = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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

        .action {
            margin: 40px 0;
        }

        .action a {
            display: inline-block;
            margin: auto;
            padding: 20px;
            letter-spacing: .3px;
            background-color: #007C89;
            border: 1px solid #007C89;
            box-shadow: 0 2px 5px #999;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            color: #ffffff;
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
    </style>
</head>

<body>
    <div class="yellow-back">
        <img src="https://i.imgur.com/Renb0Dn.png" alt="OnlineAppetite">
    </div>
    <div class="contentbox">
        <div class="content">
            <div class="message">' . $message . '</div>';
    if (isset($button))
        $mail .= '<div class="action"><a href="' . $link . '">' . $button . '</a></div>';
    if (isset($secondaryLink))
        $mail .= 'or click the link below:<br><a href='.$secondaryLink.'>'.$secondaryLink.'</a>';
    if (isset($tagline))
        $mail .= '<span class="tagline">' . $tagline . '</span>';
    $mail .= '<div class="footer">
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
    return $mail;
}