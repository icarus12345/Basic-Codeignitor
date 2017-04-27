<?php

session_start();
error_reporting(1);
$R["result"] = -1;
$R["message"] = ("This function to requires an administrative account.<br/>Please check your authority, and try again.");
if (
        isset($_SESSION["auth"]["user"]) &&
        (
        $_SESSION["auth"]["user"]->ause_authority == 'Administrator' ||
        $_SESSION["auth"]["user"]->ause_authority == 'Admin' ||
        $_SESSION["auth"]["user"]->ause_authority == 'User'
        )
) {
    if (isset($_FILES['file'])) {
        $file_contents = file_get_contents($_FILES['file']['tmp_name']);
        if (
                $_FILES['file']['type'] == "image/jpeg" || $_FILES['file']['type'] == "image/png" || $_FILES['file']['type'] == "image/gif"
        ) {
            // là file ảnh// Tiến hành code upload
            if ($_FILES['file']['size'] < 512 * 1024) {
                $path = "../../data/image/clipboard/" . date('Y/m') . '/'; // file lưu vào thư mục data
                if (!file_exists($path)) {
                    if (!mkdir($path, 0755, true)) {
                        echo json_encode(array(
                            'result' => -2001,
                            'message' => "Folder doest exists."
                        ));
                        die;
                    }
                }
                $tmp_name = $_FILES['file']['tmp_name'];
                $name = date('d-H-i-s'); //$_FILES['file']['name'];
                $type = $_FILES['file']['type'];
                $size = $_FILES['file']['size'];
                move_uploaded_file($tmp_name, "$path$name.jpg");
                if (function_exists('chmod'))
                    @chmod("$path$name.jpg", 0644);
                echo json_encode(array(
                    'result' => 1,
                    'imgpath' => "/data/image/clipboard/" . date('Y/m') . "/$name.jpg"
                ));
            }else {
                echo json_encode(array(
                    'result' => -1001,
                    'message' => "Sorry. Image size(" . (int) ($_FILES['file']['size'] / 1024) . "KB) must be less than 512KB."
                ));
            }
        } else {
            echo json_encode(array(
                'result' => -1002,
                'message' => "Sorry. File type doest Image."
            ));
        }
        @unlink($_FILES['file']['tmp_name']);
		die;
    } elseif (isset($_REQUEST['base64imagestring'])) {
        $name = date('d-H-i-s');
        $imageData = base64_decode($_REQUEST['base64imagestring']);
        $im = imagecreatefromstring($imageData);
        $path = "../../data/image/clipboard/" . date('Y/m') . '/'; // file lưu vào thư mục data
        if (!file_exists($path)) {
            if (!mkdir($path, 0755, true)) {
                echo json_encode(array(
                    'result' => -2001,
                    'message' => "Folder doest exists."
                ));
                die;
            }
        }
        if ($im !== false) {
            imagejpeg($im, "$path$name.jpg", 100);
            imagedestroy($im);
            if (function_exists('chmod'))
                @chmod("$path$name.jpg", 0644);
            echo json_encode(array(
                'result' => 1000,
                'imgpath' => "/data/image/clipboard/" . date('Y/m') . "/$name.jpg"
            ));
        }else {
            echo json_encode(array(
                'result' => -1004,
                'message' => "HTTP/1.1 400 Bad Request."
            ));
        }
    } else {
        echo json_encode(array(
            'result' => -1003,
            'message' => "HTTP/1.1 400 Bad Request."
        ));
    }
	die;
}
echo json_encode($R);
?>