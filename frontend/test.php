<?php
// 简单的测试文件
echo "PHP is working!<br>";
echo "Current directory: " . getcwd() . "<br>";
echo "File exists check:<br>";

// 检查关键文件是否存在
$files_to_check = [
    '../media_config.php',
    '../public/header.php',
    'css/frontend-main.css',
    'css/animation.css'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        echo "✓ $file exists<br>";
    } else {
        echo "✗ $file NOT found<br>";
    }
}

// 检查是否有PHP错误
if (error_get_last()) {
    echo "PHP Error: " . print_r(error_get_last(), true);
}
?>
