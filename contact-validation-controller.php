<?php

require_once 'phpmailer/class.phpmailer.php';
require_once 'phpmailer/class.smtp.php';

// $MAIL_HOST = 'nuagecx.com';
// $MAIL_USERNAME = 'info@nuagecx.com';
// $MAIL_PORT = 465;
// $MAIL_PASSWORD = "NuageCx#86";
// $MAIL_ENCRYPTION = "ssl";
// $MAIL_FROM_ADDRESS = "info@nuagecx.com";
// $CAPTCHA_SITE_KEY = "6LcMigMoAAAAAE-5TNHGvyJoPIcquK183r3OAXay";
// $CAPTCHA_SECRET_KEY = "6LcMigMoAAAAAGBT7Mbg-cGWVS8aIaJdFTQ_fECd";


$MAIL_HOST = 'smtp.hostinger.com';
$MAIL_USERNAME = 'prathmesh.rasal@asesadigital.com';
$MAIL_PORT = 465;
$MAIL_PASSWORD = "Prathmesh@2003";
$MAIL_ENCRYPTION = "ssl";
$MAIL_FROM_ADDRESS = "prathmesh.rasal@asesadigital.com";


function redirect($path)
{
    header('Location: ' . $path);
    exit();
}

function validatePhoneNumber($value)
{
    // Remove any non-digit characters from the value
    $normalizedValue = preg_replace('/\D/', '', $value);

    // Define a regular expression pattern for a valid phone number
    $pattern = '/^\d{10}$/';

    // Check if the normalized value matches the pattern
    return preg_match($pattern, $normalizedValue) === 1;
}

function validateName($value)
{
    // Remove any non-alphabetic characters and white spaces from the value
    $normalizedValue = preg_replace('/[^a-zA-Z ]/', '', $value);

    // Check if the normalized value matches the original value (no other characters present)
    return $normalizedValue === $value;
}

function validateSubject($value)
{
    // Remove any non-alphabetic characters and white spaces from the value
    $normalizedValue = preg_replace('/[^a-zA-Z\s!@#$%^&*()_+{}\[\]:;<>,.?~\-]+/', '', $value);

    // Check if the normalized value matches the original value (no other characters present)
    return $normalizedValue === $value;
}

function validateEmail($value)
{
    return filter_var($value, FILTER_VALIDATE_EMAIL);
}

function validateString($value, $min = 1, $max = INF)
{
    $result = strlen(trim($value));
    return $result >= $min && $result <= $max;
}



if ($_SERVER['REQUEST_METHOD'] == "POST") {

    session_start();

    // unset previous errors array
    if (isset($_SESSION['_flash'])) {
        unset($_SESSION['_flash']);
    }

    $name = $_POST['name'];

    $subject = $_POST['subject'];

    $email = $_POST['email'];

    $phone = $_POST['phone'];

    $query = $_POST['query'];


    // if (!$_POST['g-recaptcha-response'] ?? false) {
    //     $_SESSION['_flash']['errors']['recaptcha'] = 'Please fill recaptcha.';
    // }

    // if (strlen($_POST['g-recaptcha-response']) !== 0) {

    //     $response = $_POST['g-recaptcha-response'];
    //     $url = "https://www.google.com/recaptcha/api/siteverify?secret=$CAPTCHA_SECRET_KEY&response=$response";

    //     $data = json_decode(file_get_contents($url));
    //     if ($data->success == false) {
    //         $_SESSION['_flash']['errors']['recaptcha'] = 'Please fill recaptcha again.';
    //     }
    // }

    if (empty($name)) {
        $_SESSION['_flash']['errors']['name'] = 'Please enter your name.';
    }
    if (!validateName($name)) {
        $_SESSION['_flash']['errors']['name'] = 'Name Should contain only capital and small letters';
    }

    if (!validateEmail($email)) {
        $_SESSION['_flash']['errors']['email'] = 'Please enter a valid email';
    }

    if (empty($phone)) {
        $_SESSION['_flash']['errors']['phone'] = 'Please enter phone number.';
    }
    if (!validatePhoneNumber($phone)) {
        $_SESSION['_flash']['errors']['phone'] = 'Phone number should contain only ten digits';
    }

    if (empty($subject)) {
        $_SESSION['_flash']['errors']['subject'] = 'Please enter subject.';
    }
    if (!validateSubject($subject)) {
        $_SESSION['_flash']['errors']['subject'] = 'Subject Should contain only letters';
    }


    if (!validateString($value = $query, 1, 500)) {
        $_SESSION['_flash']['errors']['query'] = 'Please provide message no more than 500 characters';
    }

    if ($_SESSION['_flash']['errors'] ?? false) {
        $_SESSION['_flash']['old'] = $_POST;
        $_SESSION['_flash']['error'] = 'Please check errors';
        header('Location: Contact.php');
        exit();
    }



    // ------------ SEND EMAILS TO ADMIN AND USER ------------

    // Admin Mail
    // try {
    //     $mail_to_admin = new PHPMailer(true);
    //     $mail_to_admin->isSMTP();
    //     $mail_to_admin->SMTPAuth = true;
    //     $mail_to_admin->Host = $MAIL_HOST;
    //     $mail_to_admin->Username = $MAIL_USERNAME;
    //     $mail_to_admin->Password = $MAIL_PASSWORD;
    //     // $mail_to_admin->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    //     $mail_to_admin->SMTPSecure = $MAIL_ENCRYPTION;
    //     $mail_to_admin->Port = 465;

    //     $mail_to_admin->setFrom($MAIL_FROM_ADDRESS, 'NuageCX');
    //     $mail_to_admin->addAddress('sales@nuagecx.in', 'Admin');
    //     // $mail_to_admin->addCC('saurabh.salokhe@asesadigital.com','Test User');
    //     // $mail_to_admin->addCC('pravin@asesasoft.com', 'Asesa Soft');
    //     $mail_to_admin->isHTML(true);
    //     $mail_to_admin->Subject = 'New Customer Enquiry';
    //     $mail_to_admin->Body = '
    //                         <!DOCTYPE html>
    //                         <html lang="en">
    //                         <head>
    //                             <meta charset="UTF-8">
    //                             <meta name="viewport" content="width=device-width, initial-scale=1.0">
    //                             <title>New Enquiry Notification</title>
    //                         </head>
    //                         <body>
    //                             <h2>New Enquiry Notification</h2>
    //                             <p>Hello Admin,</p>
    //                             <p>A new enquiry has been submitted. Here are the details:</p>

    //                             <table>
    //                                 <tr>
    //                                     <th>Name:</th>
    //                                     <td>' . $name . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <th>Email:</th>
    //                                     <td>' . $email . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <th>Contact:</th>
    //                                     <td>' . $phone . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <th>Company Name:</th>

    //                                 </tr>
    //                                 <tr>
    //                                     <th>Enquiry For:</th>

    //                                 </tr>
    //                                 <tr>
    //                                     <th>Queries:</th>
    //                                     <td>' . $query . '</td>
    //                                 </tr>
    //                             </table>

    //                             <p>Please take appropriate action as needed.</p>

    //                             <p>Thank you!</p>
    //                         </body>
    //                         </html>
    //                     ';

    //     $mail_to_admin->send();
    // } catch (Exception $e) {
    //     echo "Message could not be sent. Mailer Error: {$mail_to_admin->ErrorInfo}";
    //     $_SESSION['_flash'] = [
    //         'failure' =>
    //         "Admin Email sending failed: " . $mail_to_admin->ErrorInfo
    //     ];
    //     // header('Location: Contact.php');
    //     // exit();
    // }

    // User Mail
    try {

        $mail_to_user = new PHPMailer(true);
        $mail_to_user->isSMTP();
        $mail_to_user->SMTPAuth = true;
        $mail_to_user->Host = $MAIL_HOST;
        $mail_to_user->Username = $MAIL_USERNAME;
        $mail_to_user->Password = $MAIL_PASSWORD;
        $mail_to_user->SMTPSecure = $MAIL_ENCRYPTION;
        $mail_to_user->Port = 465;
        $mail_to_user->setFrom($MAIL_FROM_ADDRESS, 'dev@asesadigital.com');
        $mail_to_user->addAddress($email, ucwords($_POST['name']));
        $mail_to_user->isHTML(true);
        $mail_to_user->Subject = 'Thank you for contacting us';
        $mail_to_user->Body = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>New Enquiry Notification</title>
            </head>
            <body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
                <table role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 20px; text-align: center;">
                        <a href="https://gruhashobhainteriors.in/index.html" target="_blank" style="text-decoration: none; color: #333;">
                    <img src="https://gruhashobhainteriors.in/Asset/Images/Logo-Gruhashobha-SVG%201.png" alt="Gruhashobha Logo" style="max-width: 150px; margin-bottom: 20px;">
                   
                </a>
                            <h1 style="margin: 0; color: #333;">Thank You for Contacting Us!</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px;">
                            <p style="margin: 0;">Dear ' . $_POST['name'] . ' </p>
                            <p style="margin-top: 10px;">We received your message and will get back to you as soon as possible.</p>
                            <p style="margin-top: 10px;">In the meantime, feel free to explore our website for more information about our products and services.</p>
                            <p style="margin-top: 20px;">Best regards,</p>
                            <p style="margin-top: 5px;">Team The Gruhshobha </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px; text-align: center; background-color: #f4f4f4;">
                            <p style="margin: 0; font-size: 12px; color: #888;">This is an auto-generated email. Please do not reply.</p>
                        </td>
                    </tr>
                </table>
            </body>
            </html>
        ';

        $mail_to_user->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail_to_user->ErrorInfo}";
        $_SESSION['_flash'] = [
            'failure' =>
                "User Email sending failed: " . $mail_to_user->ErrorInfo
        ];
        header('Location: Contact.php');
        exit();
    }

    // if (!$mail_to_user || !$mail_to_admin) {
    //     echo "Something went wrong, Emil not sent.";
    //     $_SESSION['_flash'] = [
    //         'failure' =>
    //         "Email sending failed: "
    //     ];
    //     // header('Location: Contact.php');
    //     // exit();
    // }

    // echo "Email sent successfully.";

    $_SESSION['_flash'] = [
        'success' =>
            'Thank you for contacting us!'
        // 'Response submitted & email sent successfully.'
    ];
    header('Location: Contact.php');
    exit();
}
