<?php
//Author: Huzzein Adebiyi
// Include the database connection file
//require_once 'db.php';
include 'db.php';
$nameErr = $emailErr = $phoneErr = "";
$name = $email = $phone = "";
$success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate name (only alphabets)
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } elseif (!preg_match("/^[a-zA-Z ]+$/", $_POST["name"])) {
        $nameErr = "Only letters and spaces are allowed in the name";
    } else {
        $name = htmlspecialchars(trim($_POST["name"]));
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } elseif (!preg_match("/\.(com|edu|gov)$/", $_POST["email"])) {
        $emailErr = "Email must end with .com, .edu, or .gov";
    } else {
        $email = htmlspecialchars(trim($_POST["email"]));
    }

    // Validate phone number (US format)
    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
    } elseif (!preg_match("/^\+1\d{10}$/", $_POST["phone"])) {
        $phoneErr = "Invalid US phone number format (+1 followed by 10 digits)";
    } else {
        $phone = htmlspecialchars(trim($_POST["phone"]));
    }

    // If all fields are valid, insert data into the database
    if (empty($nameErr) && empty($emailErr) && empty($phoneErr)) {
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $phone);

        if ($stmt->execute()) {
            // Redirect to dataset page after successful signup
            header("Location: dataset.php");
            exit(); // Ensure no further code is executed
        } else {
            $success = "Error: Could not save data. Please try again.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Signup Form</h1>
        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $name; ?>" required>
            <p class="error"><?php echo $nameErr; ?></p>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $email; ?>" required>
            <p class="error"><?php echo $emailErr; ?></p>

            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" value="<?php echo $phone; ?>" required>
            <p class="error"><?php echo $phoneErr; ?></p>

            <button type="submit">Signup</button>
        </form>
    </div>
</body>
</html>
