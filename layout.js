
document.getElementById('logout').addEventListener('click', function() {
    window.location.href = "logout.php";
});

document.getElementById('Home').addEventListener('click', function() {
    Words.style.display='block';
    Profile.style.display = 'none'
});

document.getElementById('Yourself').addEventListener('click', function() {
    Words.style.display='none';
    Profile.style.display = 'block'
});

document.getElementById('Post').addEventListener('click', function() {
    OpenPopup();
});

document.querySelectorAll('form button[type="button"]').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
    });
});

function OpenPopup() {
    document.getElementById("PopupContainer").style.display = "block";
}

function ClosePopup() {
    document.getElementById("PopupContainer").style.display = "none";
}

document.getElementById('customButton').addEventListener('click', function() {
    document.getElementById('fileInput').click(); // 觸發原始文件上傳框的點擊事件
});

document.getElementById('fileInput').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

document.getElementById('Next').addEventListener('click', function() {
    const uploadedImage = document.getElementById('previewImage').src;
    const postContent = document.getElementById('PostInputWord').value;
    
    // 儲存用戶上傳的圖片和輸入的文字
    localStorage.setItem('uploadedImage', uploadedImage);
    localStorage.setItem('postContent', postContent);
    
    OpenPopupTwo();
});

function OpenPopupTwo() {
    document.getElementById("PopupContainerTwo").style.display = "block";

    // 獲取上傳的圖片和輸入的文字
    const uploadedImage = localStorage.getItem('uploadedImage');
    const postContent = localStorage.getItem('postContent');
    
    // 在PopupDownTwo中顯示圖片和文字
    const popupDownTwo = document.getElementById('PopupDownTwo');
    popupDownTwo.innerHTML = `
        <div>
            <p>${postContent}</p>
            <img src="${uploadedImage}" alt="尚未選擇照片" style="max-width: 300px; max-height: 300px;">
        </div>
    `;
}

function ClosePopupTwo() {
    document.getElementById("PopupContainerTwo").style.display = "none";
    OpenPopup();
}
document.querySelector('.Container').addEventListener('wheel', function(event) {
    if (event.deltaY !== 0) {
        event.preventDefault();
    }
    document.querySelector('.Words').scrollTop += event.deltaY;
});
    function goarchive() {
        window.location.href = 'archive.html';
    }
    
    var closeButtons = document.getElementsByClassName('fas fa-times');
    Array.from(closeButtons).forEach(function(closeButton) {
    closeButton.addEventListener('click', function(event) {
        event.stopPropagation();
        var parentDivId = closeButton.closest('.message_print').id; // 获取最近的带有class="message_print"的父元素的ID
        var messageWrite = document.getElementById(parentDivId);
        if (messageWrite) {
            messageWrite.style.display = "none";
        }
    });
});
