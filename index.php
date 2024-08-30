<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📄文件管理中枢</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>

<?php

$directory = '.'; 
$dir = isset($_GET['dir']) ? $_GET['dir'] : $directory;
$fileList = getFileList($dir);
all($dir, $fileList);


function getFileList($directory) {
    $fileList = [];
    $folderList = [];
    
    if (is_dir($directory)) {
        if ($dh = opendir($directory)) {
            while (($file = readdir($dh)) !== false) {
                $filePath = $directory . DIRECTORY_SEPARATOR . $file;
                if (is_file($filePath)) { 
                    $fileList[] = $filePath;
                } else {
                    $folderList[] = $filePath;
                }
            }
            closedir($dh); 
        }
    } else {
        return false; 
    }
    return ['files' => $fileList, 'folders' => $folderList];
}

function all($directory, $fileList) {
    if ($fileList !== false) {
        echo "当前路径  $directory";
        
        echo "<h2>文件夹：</h2>";
        foreach ($fileList['folders'] as $folder) {
            $folderName = basename($folder);
            echo "📁<a href=\"?dir=" . urlencode($folder) . "\">$folderName</a>  ";
        }
        
        echo "<h2>文件：";
        echo '<select id="fileAction" onchange="updateLinks()">
        <option value="view">查看</option>
        <option value="download">下载</option>
        </select></h2>';

        foreach ($fileList['files'] as $file) {
            $fileName = basename($file);
            $encodedFile = urlencode($file);
            $mimeType = mime_content_type($file);
            $action = strpos($mimeType, 'image/') === 0 ? 'view' : 'download'; // 默认行为
        
            if (strpos($mimeType, 'image/') === 0) {
                echo "<div class=\"imgcss\">
                      <a href=\"$file\"><img src=\"$file\" alt=\"$fileName\"></a>
                      </div> ";
            } else {
                echo "<div class=\"txtcss\">
                      📄<a href=\"$file\">$fileName</a>
                      </div>";
            }
            echo "</div>";
        }
    } else {
        echo "<h1>❌无法读取目录内容</h1>";
    }
}

?>
