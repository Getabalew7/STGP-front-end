<?php
// Connect to your MySQL database
$servername = "localhost";
$database = "ete52e_2324zs_02";
$username = "root";
$password = "";

session_start();

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
// Perform validation and check against database
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();  // fetch all results

    if (password_verify($password, $user['password'])) {
        $_SESSION['userid'] = $user['userid'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        echo "success";
    } else {
        echo 'Invalid Password!';
    }
} else {
    echo 'No user found with given email!';
}
$stmt->close();
mysqli_close($conn);
?>
