<?php
/**
 * Contact Form API Endpoint
 * Handles contact form submissions and sends emails via SMTP
 */

require_once __DIR__ . '/../admin/includes/config.php';
require_once __DIR__ . '/../admin/includes/functions.php';

header('Content-Type: application/json');

// CORS headers (if needed for cross-origin requests)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Method not allowed'], 405);
    exit;
}

// Simple rate limiting (using session)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$rateLimitKey = 'contact_form_submissions';
$rateLimitWindow = 300; // 5 minutes
$maxSubmissions = 3; // Max 3 submissions per 5 minutes

if (!isset($_SESSION[$rateLimitKey])) {
    $_SESSION[$rateLimitKey] = [];
}

// Clean old entries
$_SESSION[$rateLimitKey] = array_filter($_SESSION[$rateLimitKey], function($timestamp) use ($rateLimitWindow) {
    return (time() - $timestamp) < $rateLimitWindow;
});

// Check rate limit
if (count($_SESSION[$rateLimitKey]) >= $maxSubmissions) {
    jsonResponse(['success' => false, 'message' => 'Too many requests. Please try again later.'], 429);
    exit;
}

// Record this submission
$_SESSION[$rateLimitKey][] = time();

// Get input data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validate JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    jsonResponse(['success' => false, 'message' => 'Invalid JSON data'], 400);
    exit;
}

// Validate required fields
$required = ['name', 'email', 'subject', 'message'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        jsonResponse(['success' => false, 'message' => "Field '$field' is required"], 400);
        exit;
    }
}

// Sanitize and validate input
$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$subject = trim($data['subject'] ?? '');
$message = trim($data['message'] ?? '');

// Validate required fields
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    jsonResponse(['success' => false, 'message' => 'All fields are required'], 400);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(['success' => false, 'message' => 'Invalid email address'], 400);
    exit;
}

// Prevent email header injection
if (preg_match("/[\r\n]/", $email)) {
    jsonResponse(['success' => false, 'message' => 'Invalid email address'], 400);
    exit;
}

// Validate length limits
if (strlen($name) > 255) {
    jsonResponse(['success' => false, 'message' => 'Name is too long'], 400);
    exit;
}
if (strlen($email) > 255) {
    jsonResponse(['success' => false, 'message' => 'Email is too long'], 400);
    exit;
}
if (strlen($subject) > 255) {
    jsonResponse(['success' => false, 'message' => 'Subject is too long'], 400);
    exit;
}
if (strlen($message) > 5000) {
    jsonResponse(['success' => false, 'message' => 'Message is too long'], 400);
    exit;
}

// Sanitize for output (XSS prevention)
$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$subject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
$message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

// Get SMTP settings
$smtpHost = getSetting('smtp_host', '');
$smtpPort = getSetting('smtp_port', '587');
$smtpUsername = getSetting('smtp_username', '');
$smtpPassword = getSetting('smtp_password', '');
$smtpEncryption = getSetting('smtp_encryption', 'tls');
$smtpFromEmail = getSetting('smtp_from_email', '');
$smtpFromName = getSetting('smtp_from_name', 'Hotel Contact Form');

// Get recipient email
$contactEmail = getSetting('contact_email', getSetting('footer_email', 'reservations@emiltonhotels.com'));

// Check if SMTP is configured
if (empty($smtpHost) || empty($smtpUsername) || empty($smtpPassword)) {
    error_log('Contact form: SMTP not configured');
    jsonResponse(['success' => false, 'message' => 'Email service is not configured. Please contact the administrator.'], 500);
    exit;
}

try {
    // Use PHPMailer if available, otherwise use basic mail()
    $phpmailerLoaded = false;
    if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        $phpmailerLoaded = true;
    } elseif (file_exists(__DIR__ . '/../vendor/autoload.php')) {
        require_once __DIR__ . '/../vendor/autoload.php';
        if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            $phpmailerLoaded = true;
        }
    }
    
    if ($phpmailerLoaded) {
        // PHPMailer implementation
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        
        // Server settings
        $mail->isSMTP();
        $mail->Host = $smtpHost;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUsername;
        $mail->Password = $smtpPassword;
        $mail->SMTPSecure = $smtpEncryption === 'ssl' ? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS : PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int)$smtpPort;
        
        // Recipients
        $mail->setFrom($smtpFromEmail ?: $smtpUsername, $smtpFromName);
        $mail->addAddress($contactEmail);
        $mail->addReplyTo($email, $name);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Contact Form: ' . $subject;
        $mail->Body = "
            <h2>New Contact Form Submission</h2>
            <p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>
            <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
            <p><strong>Subject:</strong> " . htmlspecialchars($subject) . "</p>
            <p><strong>Message:</strong></p>
            <p>" . nl2br(htmlspecialchars($message)) . "</p>
        ";
        $mail->AltBody = "New Contact Form Submission\n\nName: $name\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";
        
        $mail->send();
    } else {
        // Fallback to basic mail() function
        $to = $contactEmail;
        $emailSubject = 'Contact Form: ' . $subject;
        $emailMessage = "New Contact Form Submission\n\n";
        $emailMessage .= "Name: $name\n";
        $emailMessage .= "Email: $email\n";
        $emailMessage .= "Subject: $subject\n\n";
        $emailMessage .= "Message:\n$message\n";
        
        $fromEmail = $smtpFromEmail ?: $email;
        // As a final guard, strip CRLF from header values
        $fromEmail = str_replace(["\r", "\n"], '', $fromEmail);
        $replyTo = str_replace(["\r", "\n"], '', $email);
        $headers = "From: " . $fromEmail . "\r\n";
        $headers .= "Reply-To: " . $replyTo . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        if (!mail($to, $emailSubject, $emailMessage, $headers)) {
            throw new Exception('Failed to send email');
        }
    }
    
    jsonResponse(['success' => true, 'message' => 'Your message has been sent successfully']);
    
} catch (Exception $e) {
    error_log('Contact form error: ' . $e->getMessage());
    jsonResponse(['success' => false, 'message' => 'Failed to send message. Please try again later.'], 500);
}
