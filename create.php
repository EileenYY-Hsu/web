<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>淡江大學告白版</title>
    <link rel="stylesheet" href="create.css">
</head>

<body>
    <div>
        <h1>淡江大學告白版</h1>
    </div>
    <div class="CreateAccount">
        <h3>建立新帳號</h3>
        <form action="create.php" id="CreateAccount" method="post">
            <label for="CAccountID">學號:</label>
            <input type="text" id="CAccountID" name="CAccountID" required>
            <label for="CPassword">密碼:</label>
            <input type="password" id="CPassword" name="CPassword" required>
            <button type="submit" class="submit">建立</button>
        </form>
        <div class="message" id="message"></div>
        <button type="button" class="button"  onclick="LoginAccount()">返回登入頁面</button>
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
            echo "<script>alert('此學號已註冊帳號');</script>";
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
            echo "<script>alert('建立成功');</script>";
            echo "<script>window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('建立失敗');</script>";
            echo "<script>window.location.href = 'create.php';</script>";
        }
    }
?>