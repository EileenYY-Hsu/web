<?php 
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tamkang confession version";

$conn = new mysqli($servername, $username, $password, $dbname);      // 建立資料庫連接

if ($conn->connect_error) {        // 檢查連接
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentID=$_POST['LAccountID'];
    $password=$_POST['LPassword']; 
    $sql = "SELECT * FROM account WHERE StudentID = ? AND Password  = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",$studentID, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {    //如果找到匹配的記錄，跳轉至主頁
        $_SESSION['login'] = true;
        $_SESSION['studentID'] = $studentID ;
        $sql2 = "SELECT * FROM account WHERE StudentID = ? AND StudentName IS NULL";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("s",$studentID);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if($result2->num_rows > 0){
            header("Location: archive.html");
            exit();
        }else{
            header("Location: layout.php");
            exit();
        }
    }else{
        echo "<script>alert('The username or password you entered is incorrect.');</script>";
        echo "<script> window.location.href = 'login.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tamkang University Confession Version</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div>
        <h1>Tamkang University Confession Version</h1>
    </div>
    <div class="LoginAccount">
        <h3>Login Account</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="LoginAccount" method="post">
            <label for="LAccountID">Student ID:</label>
            <input type="text" id="LAccountID" name="LAccountID" required>
            <label for="LPassword">Password:</label>
            <input type="password" id="LPassword" name="LPassword" required>
            <button type="submit">Login</button>
        </form>
        <div class="message" id="message"></div>
        <button type="button" class="button" onclick="CreateAccount()">Create New Account</button>
    </div>
</body>
	<script>function CreateAccount() {
    	window.location.href = "create.php";
	}</script>
</html>