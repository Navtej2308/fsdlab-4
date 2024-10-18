<?php
// update.php
include 'db.php';

// Define the test_input function
function test_input($data) {
    $data = trim($data); // Remove unnecessary spaces
    $data = stripslashes($data); // Remove backslashes
    $data = htmlspecialchars($data); // Convert special characters to HTML entities
    return $data;
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM students WHERE id = $id");

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    echo "Student not found.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contact = test_input($_POST["contact"]);

    $stmt = $conn->prepare("UPDATE students SET contact = ? WHERE id = ?");
    $stmt->bind_param("si", $contact, $id);

    if ($stmt->execute()) {
        header("Location: view.php");
        exit; // Ensure to stop execution after redirection
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Contact</title>
</head>
<body>
<h2>Update Contact</h2>
<form method="post">
    Contact Number: <input type="text" name="contact" value="<?php echo htmlspecialchars($student['contact']); ?>"><br>
    <input type="submit" value="Update">
</form>
</body>
</html>
