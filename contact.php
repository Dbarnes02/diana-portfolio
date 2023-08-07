<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/home/dh_us6ygn/PHPMailer/src/Exception.php';
require '/home/dh_us6ygn/PHPMailer/src/PHPMailer.php';
require '/home/dh_us6ygn/PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function sanitize_input($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    $name = $email = $message = "";
    $nameErr = $emailErr = $messageErr = "";
    $successMessage = "";
    $failedMessage = "";
    
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = sanitize_input($_POST["name"]);
        // Check if name contains only letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and whitespace allowed";
        }
    }
    
    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = sanitize_input($_POST["email"]);
        // Check if email address is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }
    
    // Validate message
    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
    } else {
        $message = sanitize_input($_POST["message"]);
    }

    // If there are no errors, you can proceed with further processing
    if (empty($nameErr) && empty($emailErr) && empty($messageErr)) {
        $mail = new PHPMailer(true);                  // Passing `true` enables exceptions
        try {
            //Server settings
            // $mail->SMTPDebug = 2;                       // Enable verbose debug output
            $mail->isSMTP();                            // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                      // Enable SMTP authentication
            $mail->Username = 'diana.barnes.357@gmail.com';      // SMTP username
            $mail->Password = 'tseshfdrrfyraufe';              // SMTP password
            $mail->SMTPSecure = 'ssl';                    // Enable SSL encryption, TLS also accepted with port 465
            $mail->Port = 465;                           // TCP port to connect to

            //Recipients
            $mail->setFrom($email, $name);          //This is the email your form sends From
            $mail->addAddress('diana.barnes.357@gmail.com'); // Add a recipient address
            //$mail->addAddress('contact@example.com');               // Name is optional
            $mail->addReplyTo($email);
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Portfolio Contact Form';
            $mail->Body    = "$message" . "<br>" . $name;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            $successMessage = "Email sent successfully thank you!";
            $name = $email = $message = "";
        } catch (Exception $e) {
            $failedMessage = 'Failed to send email. Please try again later.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Diana Barnes | diana.barnes.357@gmail.ca">
    <meta name="description" content="portfolio website fro diana barnes">
    <meta name="keywords" content="portfolio, website, web developer, media and it, coding.">

    <title>Diana | Web Design & Developer</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Corinthia:wght@400;700&family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/reset.css">
	<link rel="stylesheet" href="assets/css/styles.css" media="screen">
    <script src="js/main.js" defer></script>

</head>
<body>
<header></header>
    <main>
        <div class="container contact">
            <h4>Let's Connect!</h4>
            <form action="" method="POST">
                <span class="success"><?php echo isset($successMessage) ? $successMessage : ''; ?></span>
                    <span class="error"><?php echo isset($failedMessage) ? $failedMessage : ''; ?></span>
                <div>
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" placeholder="Your Full Name..." required value="<?php echo isset($name) ? $name : ''; ?>">
                    <span class="error"><?php echo isset($nameErr) ? $nameErr : ''; ?></span>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" placeholder="Your Email Address..." required value="<?php echo isset($email) ? $email : ''; ?>">
                    <span class="error"><?php echo isset($emailErr) ? $emailErr : ''; ?></span>
                </div>
                <div>
                    <label for="message">Message</label>
                    <textarea name="message" id="message" cols="30" rows="10" placeholder="Your Message..." required value="<?php echo isset($message) ? $message : ''; ?>"></textarea>
                    <span class="error"><?php echo isset($messageErr) ? $messageErr : ''; ?></span>
                </div>
                <div>
                    <input class="button" type="submit" name="submit" value="Send Message">
                </div>
            </form>
        </div>
    </main>
    <footer></footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</body>
</html>