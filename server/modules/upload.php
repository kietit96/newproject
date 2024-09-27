<?php
include_once("function.php");
?>
<?php
$domain = 'https://' . $_SERVER['SERVER_NAME'];
$folderName = 'server_reactjs';

// Allowed origins to upload images
$accepted_origins = array("https://localhost", "https://107.161.82.130", $domain);

// Images upload path
$imageFolder = "../upload/";

reset($_FILES);
$temp = current($_FILES);
if (is_uploaded_file($temp['tmp_name'])) {
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Same-origin requests won't set an origin. If the origin is set, it must be valid.
        if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        } else {
            header("HTTP/1.1 403 Origin Denied");
            return;
        }
    }

    // Sanitize input
    // if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])){
    //     header("HTTP/1.1 400 Invalid file name.");
    //     return;
    // }

    // Verify extension
    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
        header("HTTP/1.1 400 Invalid extension.");
        return;
    }

    /* create new name file */
    $timeNow = '-' . renameTitle(timeNow());
    $filename = explode('.', $temp['name']);
    $rename = renameTitle($filename[0]);
    $newfilename = $rename . '_' . $timeNow . '.' . $filename[1];



    // Accept upload if there was no origin, or if it is an accepted origin
    $filetowrite = $imageFolder . $newfilename;
    move_uploaded_file($temp['tmp_name'], $filetowrite);

    // Respond to the successful upload with JSON.
    echo json_encode(array('location' => $domain . '/' . $folderName . '/upload/' . $filetowrite));
} else {
    // Notify editor that the upload failed
    header("HTTP/1.1 500 Server Error");
}
?>