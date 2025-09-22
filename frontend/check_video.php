<?php
// 简单检查视频文件
echo "<h1>视频文件检查</h1>";

$videoPath = '../video/video/home_background.webm';
echo "<p>检查路径: " . $videoPath . "</p>";
echo "<p>文件存在: " . (file_exists($videoPath) ? "是" : "否") . "</p>";

if (file_exists($videoPath)) {
    echo "<p>文件大小: " . filesize($videoPath) . " bytes</p>";
    echo "<p>最后修改: " . date('Y-m-d H:i:s', filemtime($videoPath)) . "</p>";
    
    // 显示视频
    echo "<h2>视频预览:</h2>";
    echo "<video controls style='width: 100%; max-width: 600px;'>";
    echo "<source src='$videoPath' type='video/webm'>";
    echo "你的浏览器不支持视频标签。";
    echo "</video>";
} else {
    echo "<p style='color: red;'>视频文件不存在！请检查路径是否正确。</p>";
    echo "<p>当前工作目录: " . getcwd() . "</p>";
    echo "<p>尝试的完整路径: " . realpath($videoPath) . "</p>";
}
?>
