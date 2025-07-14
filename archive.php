<?php 
	session_start();
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "tamkang confession version";
	
	$conn = new mysqli($servername, $username, $password, $dbname);		// 建立資料庫連接

	if ($conn->connect_error) {		// 檢查連接
		die("Connection failed: " . $conn->connect_error);
	}
	
	$anonymous=$_POST['anonymous'];
	$gender=$_POST['Sex'];
	$name=$_POST['Name']; 
    $facult=$_POST['facult'];
	$email=$_POST['email'];
	$studentID = $_SESSION['studentID'];
	$sql = "UPDATE account SET Gender = ?, StudentName = ?, FacultID = ?,Email = ?,Anonymous = ? WHERE StudentID = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("isisii",$gender,$name,$facult, $email,$anonymous,$studentID);
	$stmt->execute();
	$stmt->close();

	$sql = "SELECT * FROM account WHERE Gender = ? AND StudentName = ? AND FacultID = ? AND Email = ? AND Anonymous = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("isisi",$gender,$name,$facult, $email,$anonymous);
	$stmt->execute();
	$result = $stmt->get_result();
	
	
	if ($result->num_rows > 0) {
		echo "<script>alert('個人檔案修改成功');</script>";
        echo "<script> window.location.href = 'layout.php';</script>";
	}else{
		echo "<script>alert('ERROR!!! ');</script>";
        echo "<script> window.location.href = 'login.php';</script>";
	}
?>