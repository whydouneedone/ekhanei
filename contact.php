<?php include 'assignment1/header.php'; ?>
<?php include 'assignment1/slider.php'; ?>

<?php 
// Initialize error and success messages
$errors = array();
$firstname = $lastname = $email = $message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // First Name Validation
    if (empty($_POST['firstname'])) {
        $errors['firstname'] = "First name is required.";
    } else {
        $firstname = htmlspecialchars(trim($_POST['firstname']));
    }

    // Last Name Validation
    if (empty($_POST['lastname'])) {
        $errors['lastname'] = "Last name is required.";
    } else {
        $lastname = htmlspecialchars(trim($_POST['lastname']));
    }

    // Email Validation
    if (empty($_POST['email'])) {
        $errors['email'] = "Email address is required.";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
    } else {
        $email = htmlspecialchars(trim($_POST['email']));
    }

    // Message Validation
    if (empty($_POST['message'])) {
        $errors['message'] = "Message is required.";
    } else {
        $message = htmlspecialchars(trim($_POST['message']));
    }

    // If no errors, process the form (insert into DB/send email)
    if (empty($errors)) {
        // For example, save to database or send email
        // (You can use the email sending logic here)
        
        echo "<p>Thank you for contacting us, $firstname! We will get back to you soon.</p>";
    }
}
?>

<!-- Display Contact Form -->
<div class="contentsection contemplete clear">
    <div class="maincontent clear">
        <div class="about">
            <h2>Contact us</h2>
            <form action="contact.php" method="post">
                <table>
                    <tr>
                        <td>Your First Name:</td>
                        <td>
                            <input type="text" name="firstname" placeholder="Enter first name" value="<?php echo $firstname; ?>" required />
                            <span style="color: red;"><?php echo isset($errors['firstname']) ? $errors['firstname'] : ''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Your Last Name:</td>
                        <td>
                            <input type="text" name="lastname" placeholder="Enter Last name" value="<?php echo $lastname; ?>" required />
                            <span style="color: red;"><?php echo isset($errors['lastname']) ? $errors['lastname'] : ''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Your Email Address:</td>
                        <td>
                            <input type="email" name="email" placeholder="Enter Email Address" value="<?php echo $email; ?>" required />
                            <span style="color: red;"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Your Message:</td>
                        <td>
                            <textarea name="message" placeholder="Enter your message" required><?php echo $message; ?></textarea>
                            <span style="color: red;"><?php echo isset($errors['message']) ? $errors['message'] : ''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" value="Submit" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <?php include 'assignment1/sidebar.php'; ?>
</div>

<?php include 'assignment1/footer.php'; ?>
