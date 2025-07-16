<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tamkang University Confession Version</title>
    <link rel="stylesheet" href="create.css">
</head>

<body>
    <div>
        <h1>Tamkang University Confession Version</h1>
    </div>
    <div class="CreateAccount">
        <h3>Create New Account</h3>
        <form action="create.php" id="CreateAccount" method="post">
            <label for="CAccountID">Student ID:</label>
            <input type="text" id="CAccountID" name="CAccountID" required>
            <label for="CPassword">Password:</label>
            <input type="password" id="CPassword" name="CPassword" required>
            <button type="submit" class="submit">Create</button>
        </form>
        <div class="message" id="message"></div>
        <button type="button" class="button"  onclick="LoginAccount()">Back to Login Page</button>
    </div>
</body>
	<script>function LoginAccount() {
    	window.location.href = "login.php";
	}</script>
</html>

<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tamkang confession version";

    $conn = new mysqli($servername, $username, $password, $dbname);     // 建立資料庫連接

    if ($conn->connect_error) {     // 檢查連接
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $studentID = $_POST['CAccountID'];
        $password = $_POST['CPassword'];

        $sql = "SELECT * FROM account WHERE StudentID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $studentID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('This student ID has already been used to register an account.');</script>";
            echo "<script>window.location.href = 'create.php';</script>";
        }

        $sql = "INSERT INTO account (StudentID, Password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $studentID, $password);
        $stmt->execute();

        $sql = "SELECT * FROM account WHERE StudentID = ? AND Password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $studentID, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Creation successful.');</script>";
            echo "<script>window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Creation failed.');</script>";
            echo "<script>window.location.href = 'create.php';</script>";
        }
    }
?>