<!DOCTYPE html>
<html>
<head>
    <title>Mail Form Page</title>
    <script>
        function validateEmails() {
            const emailField = document.getElementById('to_mail');
            const emails = emailField.value.split(',');
            for (let email of emails) {
                email = email.trim();
                if (!validateEmail(email)) {
                    alert('Invalid email address: ' + email);
                    return false;
                }
            }
            return true;
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(String(email).toLowerCase());
        }
    </script>
</head>
<body>
    <h2>Mail Form</h2>
    <form action="confirm_page.php" method="post" onsubmit="return validateEmails();">
        <label for="from_mail">From Email:</label><br>
        <input type="email" id="from_mail" name="from_mail" required><br><br>

        <label for="from_name">From Name:</label><br>
        <input type="text" id="from_name" name="from_name" required><br><br>
        
        <label for="to_mail">To Email (comma-separated for multiple emails):</label><br>
        <input type="text" id="to_mail" name="to_mail" required><br><br>
        
        <label for="subject">Subject:</label><br>
        <input type="text" id="subject" name="subject" required><br><br>
        
        <label for="message">Message:</label><br>
        <textarea id="message" name="message" required></textarea><br><br>
        
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
