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
        <title>Tamkang University Confession Version</title>
        <link rel="stylesheet" href="layout.css">
    </head>

    <body>
        <div class="Container">
            <div class="Title">
                <h1>Tamkang University Confession Version</h1>
            </div>
            <div class="Menu">
                <p id="Home">Home</p>
                <p id="Post">New Post</p>
                <p id="Yourself">Profile</p>
                <p id="logout">Logout</p>  
            </div>
            <div class="Words" id="Words">
                <div id="select" class="select">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <label for="facult">Search:</label>
                            <select id="facult" name="facult">
                                <option value="0">All</option>
                                <option value="1">Department of Chinese Literature</option>
                                <option value="2">Department of History</option>
                                <option value="3">Department of Information and Library Science</option>
                                <option value="4">Department of Mass Communication</option>
                                <option value="5">Department of Information and Communication</option>
                                <option value="6">Department of Mathematics</option>
                                <option value="7">Department of Physics</option>
                                <option value="8">Department of Chemistry</option>
                                <option value="9">Department of Architecture</option>
                                <option value="10">Department of Civil Engineering</option>
                                <option value="11">Department of Water Resources and Environmental Engineering</option>
                                <option value="12">Department of Mechanical and Electro-Mechanical Engineering</option>
                                <option value="13">Department of Chemical and Materials Engineering</option>
                                <option value="14">Department of Electrical and Computer Engineering</option>
                                <option value="15">Department of Computer Science and Information Engineering</option>
                                <option value="16">Department of Aerospace Engineering</option>
                                <option value="17">Department of International Business</option>
                                <option value="18">Department of Banking and Finance</option>
                                <option value="19">Department of Risk Management and Insurance</option>
                                <option value="20">Department of Industrial Economics</option>
                                <option value="21">Department of Economics</option>
                                <option value="22">Department of Business Administration</option>
                                <option value="23">Department of Accounting</option>
                                <option value="24">Department of Statistics</option>
                                <option value="25">Department of Information Management</option>
                                <option value="26">Department of Transportation Management</option>
                                <option value="27">Department of Public Administration</option>
                                <option value="28">Department of Management Sciences</option>
                                <option value="29">Department of English</option>
                                <option value="30">Department of Spanish</option>
                                <option value="31">Department of French</option>
                                <option value="32">Department of German</option>
                                <option value="33">Department of Japanese</option>
                                <option value="34">Department of Russian</option>
                                <option value="35">Department of Educational Technology</option>
                                <option value="36">Education and Futures Design</option>
                                <option value="37">Artificial Intelligence</option>
                                <option value="38">Department of Diplomacy and International Relations</option>
                                <option value="39">Department of International Tourism Management</option>
                                <option value="40">Department of Global Politics and Economics</option>
                            </select>
                            <button type="submit" class="select_form" name="select_button">Search</button>
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
                        $result = $stmt->get_result(); // 獲取结果集
                        while ($post_print = mysqli_fetch_assoc($result)) { // 使用 mysqli_fetch_assoc() 獲取關聯數組
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
                                                            <button id="delete_comment" type="submit" name="delete_comment">Delete</button>
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
                                        <label id="PostComment" for="textContent">Please enter a comment:</label><br>
                                        <textarea id="textContent" name="textContent" rows="10" cols="50"></textarea><br>
                                        <input type="hidden" name="postID" value="<?php echo $post_printID; ?>">
                                        <input id="PostBtn" type="submit" value="Post" name="message_button">
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
                        $gender = "Male" ;
                    }else if($genderID == '0'){
                        $gender = "Female" ;
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
                    <button id="Filebtn" onclick="goarchive()">Edit Profile</button>
                    <p>Gender : <?php echo nl2br(htmlspecialchars($gender)); ?></p>
                    <p>Department : <?php echo nl2br(htmlspecialchars($facultname)); ?></p>
                    <p>Email : <?php echo nl2br(htmlspecialchars($email)); ?></p>
                    <!--<p>自我介紹 : <?php echo nl2br(htmlspecialchars($introduce)); ?></p>-->
            </div>
        </div>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div id="PopupContainer">    
                <div id="PopupUp">
                    <button type="button" id="CloseSmallWindows" onclick="ClosePopup()">Close</button>
                    <button type="button" id="Next">Next</button>
                </div>
                <div id="PopupLeft">
                    <input type="file" id="fileInput" name="fileInput" accept="image/*">
                    <button type="button" id="customButton">Select Image</button>
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
                    <button type="submit" id="Finish">Post</button>
                </div>
                <div id="PopupDownTwo">
                    
                </div>
            </div>
        </form>
        <script src="layout.js"></script>
    </body>
</html>