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
?>
<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {   //評論表單接收
    if (isset($_POST['message_button'])){
        $sql = "SELECT * FROM comment";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $commentID = $result->num_rows+1;  
        $postID = $_POST['postID'];
        $studentID = $_SESSION['studentID'];
        $textContent = $_POST['textContent'];
        echo "<script>alert('$textContent,$studentID,$commentID,$postID');</script>";
        $stmt = $conn->prepare("INSERT INTO comment (CommentContent,StudentID,CommentID,PostID) VALUES (?,?,?,?)");
        $stmt->bind_param("siii", $textContent,$studentID,$commentID,$postID);
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } 
}
?>
<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_comment'])) {
        $commentID = $_POST['commentID'];
        $stmt = $conn->prepare("DELETE FROM comment WHERE CommentID = ?");
        $stmt->bind_param("i", $commentID);
        if ($stmt->execute()) {
            echo "Comment deleted successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
        // Redirect to same page to refresh comments
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['select_button'])){
            $selected_faculty = $_POST['facult'];
            $_SESSION['facult'] = $selected_faculty;
            header("Location: " . $_SERVER['PHP_SELF']);
        }
    }
    ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <title>淡江大學告白版</title>
        <link rel="stylesheet" href="layout.css">
    </head>

    <body>
        <div class="Container">
            <div class="Title">
                <h1>淡江大學告白版</h1>
            </div>
            <div class="Menu">
                <p id="Home">首頁</p>
                <p id="Post">新增貼文</p>
                <p id="Yourself">個人檔案</p>
                <p id="logout">登出</p>  
            </div>
            <div class="Words" id="Words">
                <div id="select" class="select">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <label for="facult">搜尋:</label>
                            <select id="facult" name="facult">
                                <option value="0">全部</option>
                                <option value="1">中國文學學系</option>
                                <option value="2">歷史學系</option>
                                <option value="3">資訊與圖書館學系</option>
                                <option value="4">大眾傳播學系</option>
                                <option value="5">資訊傳播學系</option>
                                <option value="6">數學學系</option>
                                <option value="7">物理學系</option>
                                <option value="8">化學學系</option>
                                <option value="9">建築學系</option>
                                <option value="10">土木工程學系</option>
                                <option value="11">水資源及環境工程學系</option>
                                <option value="12">機械與機電工程學系</option>
                                <option value="13">化學工程與材料工程學系</option>
                                <option value="14">電機工程學系</option>
                                <option value="15">資訊工程學系</option>
                                <option value="16">航空太空工程學系</option>
                                <option value="17">國際企業學系</option>
                                <option value="18">財務金融學系</option>
                                <option value="19">風險管理與保險學系</option>
                                <option value="20">產業經濟學系</option>
                                <option value="21">經濟學系</option>
                                <option value="22">企業管理學系</option>
                                <option value="23">會計學系</option>
                                <option value="24">統計學系</option>
                                <option value="25">資訊管理學系</option>
                                <option value="26">運輸管理學系</option>
                                <option value="27">公共行政學系</option>
                                <option value="28">管理科學學系</option>
                                <option value="29">英文學系</option>
                                <option value="30">西班牙語文學系</option>
                                <option value="31">法國語文學系</option>
                                <option value="32">德國語文學系</option>
                                <option value="33">日本語文學系</option>
                                <option value="34">俄國語文學系</option>
                                <option value="35">教育科技學系</option>
                                <option value="36">教育與未來設計學系</option>
                                <option value="37">人工智慧學系</option>
                                <option value="38">外交與國際關係學系</option>
                                <option value="39">國際觀光管理學系</option>
                                <option value="40">全球政治經濟學系</option>
                            </select>
                            <button type="submit" class="select_form" name="select_button">查詢</button>
                    </form>
                </div>
                <?php
                    if (isset($_SESSION['facult'])) {
                    } else {
                        $_SESSION['facult'] = '0';
                    }
                    $select_facult = $_SESSION['facult'];
                    if($select_facult == '0'){
                        $sql = "SELECT * FROM articlecontent,account,facult WHERE articlecontent.StudentID=account.StudentID AND account.FacultID=facult.FacultID ORDER BY PostID DESC;";
                        $stmt = $conn->prepare($sql);
                    }else{
                        $sql = "SELECT * FROM articlecontent,account,facult WHERE articlecontent.StudentID=account.StudentID AND account.FacultID=facult.FacultID AND account.FacultID = ? ORDER BY PostID DESC;";
                        $stmt = $conn->prepare($sql);
	                    $stmt->bind_param("i",$select_facult);
                    }
                    $stmt->execute();

                    if ($stmt) {
                        $result = $stmt->get_result(); // 获取结果集
                        while ($post_print = mysqli_fetch_assoc($result)) { // 使用 mysqli_fetch_assoc() 获取关联数组
                            $postFound = true;
                            $post_printID = $post_print['PostID'];
                            ?>
                            <div id="message_write_<?php echo $post_printID?>" class="message_print">
                                <?php
                                    $sql1 = "SELECT * FROM comment,account,facult WHERE PostID = ? AND account.StudentID = comment.StudentID AND account.FacultID = facult.FacultID ORDER BY CommentID DESC";
                                    $stmt1 = $conn->prepare($sql1);
                                    $stmt1->bind_param("i", $post_printID);
                                    $stmt1->execute();
                                    if ($stmt1){
                                        $result1 = $stmt1->get_result();
                                        while ($comment = mysqli_fetch_assoc($result1)){
                                            ?>
                                            <div id="comment_print" class="comment_print">
                                                <?php
                                                    if ($comment['Gender'] == 1) {
                                                        $genderImage = "http://localhost/web/Boy.jpg";
                                                    } else if ($comment['Gender'] == 0) {
                                                        $genderImage = "http://localhost/web/Girl.jpg";
                                                    }
                                                    $facultname = $comment['FacultName'];
                                                    if($comment["Anonymous"] == 1){
                                                        $post_name = "";
                                                    }else{
                                                        $post_name = $comment["StudentName"];
                                                    }
                                                    $commentcontent = $comment["CommentContent"]
                                                ?>
                                                <div id="comment_img" class="comment_img">
                                                    <img src="<?php echo htmlspecialchars($genderImage); ?>" alt="ERROR">
                                                </div>
                                                <div id="comment_word" class="comment_word">
                                                    <p><?php echo nl2br(htmlspecialchars($facultname)); ?>&nbsp;&nbsp;<?php echo nl2br(htmlspecialchars($post_name)); ?></p>
                                                    <p><?php echo nl2br(htmlspecialchars($commentcontent)); ?></p>
                                                    <?php if ($comment['StudentID'] == $_SESSION['studentID']): ?>
                                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                            <input type="hidden" name="commentID" value="<?php echo $comment['CommentID']; ?>">
                                                            <button id="delete_comment" type="submit" name="delete_comment">刪除</button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div> 
                                            </div>
                                        <?php
                                        }
                                    }if (!$postFound): 
                                        ?>
                                        <p>No comment found.</p>
                                    <?php endif; ?>
                                <div id="message_form" class="message_form">
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <label id="PostComment" for="textContent">請輸入評論:</label><br>
                                        <textarea id="textContent" name="textContent" rows="10" cols="50"></textarea><br>
                                        <input type="hidden" name="postID" value="<?php echo $post_printID; ?>">
                                        <input id="PostBtn" type="submit" value="發布" name="message_button">
                                    </form>    
                                </div>
                                <button id="closeButton" class="fas fa-times"></button>
                            </div>
                            <div id="Post_print" class="Post_print"  data-post-id="<?php echo $post_printID; ?>">
                                <?php if (is_array($post_print)): ?>
                                <div id="Post_information" class="Post_information">
                                <?php
                                    if ($post_print['Gender'] == 1) {
                                        $genderImage = "http://localhost/web/Boy.jpg";
                                    } else if ($post_print['Gender'] == 0) {
                                        $genderImage = "http://localhost/web/Girl.jpg";
                                    }
                                    $facultname = $post_print['FacultName'];
                                    if($post_print["Anonymous"] == 1){
                                        $post_name = "";
                                    }else{
                                        $post_name = $post_print["StudentName"];
                                    }
                                ?>
                                <img src="<?php echo htmlspecialchars($genderImage); ?>" alt="ERROR">
                                <p><?php echo nl2br(htmlspecialchars($facultname)); ?></p>
                                <p>&nbsp;&nbsp;<?php echo nl2br(htmlspecialchars($post_name)); ?></p>
                                </div>   
                                <div id="Post_print_word" class="Post_print_word"><p><?php echo nl2br(htmlspecialchars($post_print['Content'])); ?></p></div>
                                <?php
                                    $urlString = strval($post_print['PostID']);
                                    $imageUrl = "http://localhost/web/picture/" . $urlString . ".jpg";
                                ?>
                                <div id="Post_print_img" class="Post_print_img"><img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="Post Image"></div>
                                <?php else: ?>
                                <p>Error: Invalid post data.</p>
                                <?php endif; ?>
                            </div>
                        <?php
                        }
                    }
                    if (!$postFound): 
                    ?>
                        <p>No posts found.</p>
                <?php endif; ?>
                <script>
                    document.getElementById('Words').addEventListener('click', function(event) {
                    var target = event.target;
                    while (target && !target.classList.contains('Post_print')) {
                        target = target.parentElement;
                    }

                    if (target && target.classList.contains('Post_print')) {
                        var postId = target.getAttribute('data-post-id');
                        alert('Post with PostID ' + postId + ' was clicked!');
                        var messageWrite= document.getElementById('message_write_' + postId);
                        messageWrite.style.display = "block";
                    }
                    });
                </script>
            </div>
            <div id="Profile" class="Profile">
                <?php
                    $studentID = $_SESSION['studentID'];
                    $sql = "SELECT * FROM account,facult WHERE StudentID = ? AND account.facultID = facult.facultID";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $studentID);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $profile = $result->fetch_assoc();
                    if ($profile['Gender'] == 1) {
                        $genderImage = "http://localhost/web/Boy.jpg";
                    } else if ($profile['Gender'] == 0) {
                        $genderImage = "http://localhost/web/Girl.jpg";
                    }
                    $facultname = $profile['FacultName'];
                    $studentname = $profile['StudentName'];
                    $email = $profile['Email'];
                    $genderID = $profile['Gender'];
                    $introduce = $profile['Introduce'];
                    if($genderID == '1'){
                        $gender = "男生" ;
                    }else if($genderID == '0'){
                        $gender = "女生" ;
                    }else{
                        $gender = "" ;
                    }
                ?>
                <div id="profile_print" class="profile_print">
                    <div id="profile_head" class="profile_head">
                        <img src="<?php echo htmlspecialchars($genderImage); ?>" alt="ERROR">
                    </div>
                    <div id="profile_word" class="profile_word">
                        <p><?php echo nl2br(htmlspecialchars($studentname)); ?></p>
                    </div>
                </div>
                    <button id="Filebtn" onclick="goarchive()">編輯個人檔案</button>
                    <p>性別 : <?php echo nl2br(htmlspecialchars($gender)); ?></p>
                    <p>科系 : <?php echo nl2br(htmlspecialchars($facultname)); ?></p>
                    <p>Email : <?php echo nl2br(htmlspecialchars($email)); ?></p>
                    <!--<p>自我介紹 : <?php echo nl2br(htmlspecialchars($introduce)); ?></p>-->
            </div>
        </div>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div id="PopupContainer">    
                <div id="PopupUp">
                    <button type="button" id="CloseSmallWindows" onclick="ClosePopup()">關閉</button>
                    <button type="button" id="Next">下一步</button>
                </div>
                <div id="PopupLeft">
                    <input type="file" id="fileInput" name="fileInput" accept="image/*">
                    <button type="button" id="customButton">選擇圖片</button>
                    <div id="previewContainer">
                        <img id="previewImage" src="#" alt="">
                    </div>
                </div>
                <div id="PopupRight">
                    <textarea id="PostInputWord" name="PostInputWord" rows="25" cols="50" placeholder="請輸入想發布的內容(限500字)..." style="resize: none;"></textarea>               
                </div>
            </div>
            <div id="PopupContainerTwo">
                <div id="PopupUpTwo">
                    <button type="button" id="BackToOneSmallWindows" onclick="ClosePopupTwo()">上一步</button>
                    <button type="submit" id="Finish">發布</button>
                </div>
                <div id="PopupDownTwo">
                    
                </div>
            </div>
        </form>
        <script src="layout.js"></script>
    </body>
</html>