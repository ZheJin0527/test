<?php
// 测试视频显示
session_start();
include_once '../media_config.php';

echo "<h1>视频测试页面</h1>";

// 测试 getMediaConfig 函数
echo "<h2>1. 测试 getMediaConfig 函数：</h2>";
$media = getMediaConfig('home_background');
echo "<pre>";
print_r($media);
echo "</pre>";

// 测试 getMediaHtml 函数
echo "<h2>2. 测试 getMediaHtml 函数：</h2>";
$html = getMediaHtml('home_background');
echo "<pre>";
echo htmlspecialchars($html);
echo "</pre>";

// 显示实际的视频
echo "<h2>3. 实际视频显示：</h2>";
echo $html;

// 检查文件是否存在
echo "<h2>4. 文件存在性检查：</h2>";
$filePath = $media['file'];
echo "文件路径: " . $filePath . "<br>";
echo "文件存在: " . (file_exists($filePath) ? "是" : "否") . "<br>";
if (file_exists($filePath)) {
    echo "文件大小: " . filesize($filePath) . " bytes<br>";
    echo "最后修改时间: " . date('Y-m-d H:i:s', filemtime($filePath)) . "<br>";
}
?>
