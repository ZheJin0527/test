<?php
// 简单测试页面
session_start();
include_once '../media_config.php';

$pageTitle = 'Test Page';
$showPageIndicator = false;
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="dist/output.css" />
    
    <!-- 字体 -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-inter bg-gray-100">

<h1 class="text-4xl font-bold text-center mt-20 text-kunzz-orange">测试页面 - 如果你看到这个，说明基础配置正常</h1>

<?php
// 测试 header
echo '<div class="mt-10 text-center">';
echo '<p class="text-xl">开始加载 Header...</p>';

try {
    include 'public/header_only.php';
    echo '<p class="text-green-600 mt-4">✅ Header 加载成功!</p>';
} catch (Exception $e) {
    echo '<p class="text-red-600 mt-4">❌ Header 加载失败: ' . $e->getMessage() . '</p>';
}

echo '</div>';
?>

<main class="container mx-auto px-4 py-20">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-4">测试内容</h2>
        <p class="text-gray-700">如果你看到这些内容，说明页面结构正常。</p>
        
        <div class="mt-6 space-y-2">
            <p class="font-semibold">检查清单：</p>
            <ul class="list-disc list-inside space-y-1 text-gray-600">
                <li>✅ PHP 运行正常</li>
                <li>✅ HTML 结构正确</li>
                <li>✅ Tailwind CSS 加载</li>
                <li>检查上方是否显示 Header</li>
            </ul>
        </div>
    </div>
</main>

</body>
</html>
