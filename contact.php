<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

// Sanitize inputs
$name    = htmlspecialchars(strip_tags(trim($_POST['name'] ?? '')));
$email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$inquiry = htmlspecialchars(strip_tags(trim($_POST['inquiry'] ?? '')));
$message = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')));

// Basic validation
if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: index.html?status=error');
    exit;
}

// Email settings
$to      = 'info@resoluteintentllc.com';
$subject = 'Website Inquiry: ' . $inquiry;
$body    = "You have a new inquiry from resoluteintentllc.com\n\n"
         . "Name:    $name\n"
         . "Email:   $email\n"
         . "Type:    $inquiry\n"
         . "-------------------------------------------\n"
         . "$message\n";

$headers = "From: no-reply@resoluteintentllc.com\r\n"
         . "Reply-To: $email\r\n"
         . "X-Mailer: PHP/" . phpversion();

if (mail($to, $subject, $body, $headers)) {
    header('Location: index.html?status=sent');
} else {
    header('Location: index.html?status=error');
}
exit;
?>
