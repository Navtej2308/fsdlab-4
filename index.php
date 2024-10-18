<?php
// index.php
include 'db.php';  // Include the database connection

$firstNameErr = $lastNameErr = $rollNoErr = $passwordErr = $contactErr = "";
$firstName = $lastName = $rollNo = $password = $confirmPassword = $contact = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    if (empty($_POST["first_name"])) {
        $firstNameErr = "First name is required";
    } else {
        $firstName = test_input($_POST["first_name"]);
    }

    if (empty($_POST["last_name"])) {
        $lastNameErr = "Last name is required";
    } else {
        $lastName = test_input($_POST["last_name"]);
    }

    if (empty($_POST["roll_no"])) {
        $rollNoErr = "Roll No is required";
    } else {
        $rollNo = test_input($_POST["roll_no"]);
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
    }

    if (empty($_POST["contact"])) {
        $contactErr = "Contact number is required";
    } else {
        $contact = test_input($_POST["contact"]);
    }

    if (empty($firstNameErr) && empty($lastNameErr) && empty($rollNoErr) && empty($passwordErr) && empty($contactErr)) {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO students (first_name, last_name, roll_no, password, contact) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstName, $lastName, $rollNo, $password, $contact);
        if ($stmt->execute()) {
            echo "Student registered successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Sanitize input
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Register Student</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    First Name: <input type="text" name="first_name" value="<?php echo $firstName; ?>">
    <span><?php echo $firstNameErr; ?></span><br>

    Last Name: <input type="text" name="last_name" value="<?php echo $lastName; ?>">
    <span><?php echo $lastNameErr; ?></span><br>

    Roll No/ID: <input type="text" name="roll_no" value="<?php echo $rollNo; ?>">
    <span><?php echo $rollNoErr; ?></span><br>

    Password: <input type="password" name="password">
    <span><?php echo $passwordErr; ?></span><br>

    Contact Number: <input type="text" name="contact" value="<?php echo $contact; ?>">
    <span><?php echo $contactErr; ?></span><br>

    <input type="submit" value="Register">
</form>
<a href="view.php">View Registered Students</a>
</body>
</html>
