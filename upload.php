<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// ตรวจสอบว่าไฟล์ที่อัปโหลดเป็นภาพจริงหรือไม่
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }
}

// ตรวจสอบว่าไฟล์มีอยู่แล้วหรือไม่
if (file_exists($target_file)) {
    echo "Sorry, file already exists.<br>";
    $uploadOk = 0;
}

// ตรวจสอบขนาดไฟล์
if ($_FILES["fileToUpload"]["size"] > 5000000) { // 5MB
    echo "Sorry, your file is too large.<br>";
    $uploadOk = 0;
}

// อนุญาตเฉพาะไฟล์ประเภท JPG, JPEG, PNG, GIF เท่านั้น
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
    $uploadOk = 0;
}

// ตรวจสอบว่า $uploadOk ถูกตั้งค่าเป็น 0 โดยข้อผิดพลาด
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.<br>";
// ถ้าทุกอย่างโอเค พยายามอัปโหลดไฟล์
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // เปลี่ยนเส้นทางไปยังหน้าโปรไฟล์พร้อมกับชื่อไฟล์ที่อัปโหลด
        header("Location: profile.php?img=" . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])));
        exit();
    } else {
        echo "Sorry, there was an error uploading your file.<br>";
    }
}
?>
