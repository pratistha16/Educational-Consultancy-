<?php
phpinfo();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Get the uploaded file details
    $file = $_FILES['file'];

    // File upload validation (only Word and PDF files)
    $allowed_types = array('application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf');
    $file_type = $file['type'];

    // Check if file type is allowed
    if (!in_array($file_type, $allowed_types)) {
        echo "<p>Invalid file type. Only Word (.doc, .docx) and PDF files are allowed.</p>";
        exit;
    }

    // Path to save the file
    $file_tmp = $file['tmp_name'];
    $file_name = $file['name'];
    $file_path = 'uploads/' . $file_name;

    // Move the uploaded file to the server directory
    if (move_uploaded_file($file_tmp, $file_path)) {
        // Email settings
        $to = "panthipratistha@gmail.com"; // Replace with your email address
        $subject = "Contact Us Form Submission";
        $body = "You have received a new message from the contact form.\n\n".
                "Name: $name\n".
                "Email: $email\n\n".
                "Message:\n$message";

        // Headers for file attachment
        $headers = "From: $email";
        $boundary = md5(time());  // Define the boundary for the email

        $headers .= "\r\nMIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"$boundary\"";

        // Message body with the file attachment
        $message_body = "--$boundary\r\n";
        $message_body .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $message_body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $message_body .= "$body\r\n";

        // Attachment
        $file_content = file_get_contents($file_path);
        $encoded_file = chunk_split(base64_encode($file_content));

        $message_body .= "--$boundary\r\n";
        $message_body .= "Content-Type: $file_type; name=\"$file_name\"\r\n";
        $message_body .= "Content-Transfer-Encoding: base64\r\n";
        $message_body .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n\r\n";
        $message_body .= "$encoded_file\r\n";
        $message_body .= "--$boundary--";

        // Send the email
        if (mail($to, $subject, $message_body, $headers)) {
            echo "<p>Thank you for reaching out! We will get back to you shortly.</p>";
        } else {
            echo "<p>Sorry, there was an issue sending your message. Please try again later.</p>";
        }

        // Clean up (delete the uploaded file after processing)
        unlink($file_path);
    } else {
        echo "<p>Error uploading the file. Please try again.</p>";
    }
}
?>
