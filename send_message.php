<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);
    $copy = isset($_POST['copy']) ? 'Yes' : 'No';

    // Define recipient email and email subject
    $to = 'spongheen@gmail.com'; // Replace with your email address
    $subject = 'Contact Form Submission from ' . $name;
    $headers = "From: " . $email . "\r\n" .
               "Reply-To: " . $email . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // Create the email body
    $email_body = "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Phone: $phone\n";
    $email_body .= "Message:\n$message\n";
    $email_body .= "Copy to self: $copy\n";

    // Send the email to the site owner
    if (mail($to, $subject, $email_body, $headers)) {
        echo "Message sent successfully!";
        
        // Check if user requested a copy of the email
        if ($copy == 'Yes') {
            $user_subject = 'Copy of Your Message to Syeda Farheen Masroor';
            $user_headers = "From: " . $to . "\r\n" .
                            "Reply-To: " . $to . "\r\n" .
                            "X-Mailer: PHP/" . phpversion();
            $user_email_body = "Hi $name,\n\nThank you for your message. Here is a copy of what you sent:\n\n";
            $user_email_body .= $email_body;
            $user_email_body .= "\nBest regards,\nSyeda Farheen Masroor";

            // Send the copy to the user
            if (mail($email, $user_subject, $user_email_body, $user_headers)) {
                echo " and a copy has been sent to your email.";
            } else {
                echo " but failed to send a copy to your email.";
            }
        }
    } else {
        echo "Failed to send message.";
    }
}
?>
