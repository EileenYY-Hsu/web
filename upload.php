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
    
    $studentID=$_SESSION['studentID'];     //獲取studentID

    $sql ="SELECT * FROM articlecontent";
    $stmt = $conn->prepare($sql);
	$stmt->execute();
    $result = $stmt->get_result();
    $postID = $result->num_rows+1;      //獲取postID
    $picID = (string)$postID.".jpg";     //利用postID取得照片儲存路徑

    // 確認是否為圖片檔案
    if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] == 0){
        $target_dir = "picture/"; // 設置照片存儲目錄
        $target_file = $target_dir .$picID;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if(isset($_POST["pic_submit"])) {
            $check = getimagesize($_FILES["fileInput"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        // 檢查檔案是否已存在
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // 檢查檔案大小
        if ($_FILES["fileInput"]["size"] > 1000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // 允許特定檔案格式
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // 檢查 $uploadOk 是否為 0
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // 如果一切都正確，嘗試上傳檔案
        } else {
            if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["fileInput"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 获取 textarea 的值
        $content = $_POST['PostInputWord'];
        //去除额外的空格
        $content = trim($content);
    }

    $sql1 ="INSERT INTO articlecontent(PostID,Content,StudentID) VALUES(?,?,?)";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("isi",$postID,$content,$studentID);
	$stmt1->execute();
    header("Location: layout.php");
?>