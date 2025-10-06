<?php
// 调试页面 - 用于诊断页面空白问题
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 设置较长的执行时间限制
set_time_limit(60);

// 开始输出缓冲
ob_start();

echo "<!DOCTYPE html>
<html lang='zh-CN'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>页面调试工具</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .debug-section { background: white; margin: 20px 0; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .debug-title { color: #333; border-bottom: 2px solid #007cba; padding-bottom: 10px; }
        .status-ok { color: #28a745; font-weight: bold; }
        .status-error { color: #dc3545; font-weight: bold; }
        .status-warning { color: #ffc107; font-weight: bold; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 4px; overflow-x: auto; }
        .test-button { background: #007cba; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin: 5px; }
        .test-button:hover { background: #0056b3; }
    </style>
</head>
<body>";

echo "<h1>🔧 页面调试工具</h1>";

// 1. Session 状态检查
echo "<div class='debug-section'>
    <h2 class='debug-title'>1. Session 状态检查</h2>";

if (isset($_SESSION['user_id'])) {
    echo "<p class='status-ok'>✅ Session 存在</p>";
    echo "<p>用户ID: " . htmlspecialchars($_SESSION['user_id']) . "</p>";
    echo "<p>用户名: " . htmlspecialchars($_SESSION['username'] ?? '未设置') . "</p>";
    echo "<p>职位: " . htmlspecialchars($_SESSION['position'] ?? '未设置') . "</p>";
    
    if (isset($_SESSION['last_activity'])) {
        $timeDiff = time() - $_SESSION['last_activity'];
        echo "<p>最后活动时间: " . date('Y-m-d H:i:s', $_SESSION['last_activity']) . "</p>";
        echo "<p>距离最后活动: {$timeDiff} 秒</p>";
        
        if ($timeDiff > 60) {
            echo "<p class='status-warning'>⚠️ Session 可能已超时（超过60秒）</p>";
        } else {
            echo "<p class='status-ok'>✅ Session 仍然有效</p>";
        }
    } else {
        echo "<p class='status-error'>❌ 未设置 last_activity</p>";
    }
} else {
    echo "<p class='status-error'>❌ 没有有效的 Session</p>";
}

// Cookie 检查
echo "<h3>Cookie 状态:</h3>";
if (isset($_COOKIE['remember_token'])) {
    echo "<p class='status-ok'>✅ Remember token 存在: " . htmlspecialchars($_COOKIE['remember_token']) . "</p>";
} else {
    echo "<p class='status-warning'>⚠️ 没有 remember token</p>";
}

echo "</div>";

// 2. 数据库连接测试
echo "<div class='debug-section'>
    <h2 class='debug-title'>2. 数据库连接测试</h2>";

$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p class='status-ok'>✅ 数据库连接成功</p>";
    
    // 测试查询
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $result = $stmt->fetch();
    echo "<p>用户表记录数: " . $result['count'] . "</p>";
    
} catch (PDOException $e) {
    echo "<p class='status-error'>❌ 数据库连接失败: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "</div>";

// 3. 文件存在性检查
echo "<div class='debug-section'>
    <h2 class='debug-title'>3. 关键文件存在性检查</h2>";

$files_to_check = [
    'sidebar.php',
    'kpiedit.php',
    'stocklist.php',
    'generatecode.php',
    'kpiapi.php',
    'stockapi.php'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        echo "<p class='status-ok'>✅ {$file} 存在</p>";
    } else {
        echo "<p class='status-error'>❌ {$file} 不存在</p>";
    }
}

echo "</div>";

// 4. PHP 配置检查
echo "<div class='debug-section'>
    <h2 class='debug-title'>4. PHP 配置检查</h2>";

echo "<p>PHP 版本: " . PHP_VERSION . "</p>";
echo "<p>内存限制: " . ini_get('memory_limit') . "</p>";
echo "<p>最大执行时间: " . ini_get('max_execution_time') . "</p>";
echo "<p>错误报告级别: " . error_reporting() . "</p>";
echo "<p>显示错误: " . (ini_get('display_errors') ? '开启' : '关闭') . "</p>";

echo "</div>";

// 5. 测试页面加载
echo "<div class='debug-section'>
    <h2 class='debug-title'>5. 页面加载测试</h2>";

echo "<p>点击下面的按钮测试各个页面是否能正常加载：</p>";

$test_pages = [
    'kpiedit.php' => 'KPI编辑页面',
    'stocklist.php' => '库存列表页面', 
    'generatecode.php' => '代码生成页面'
];

foreach ($test_pages as $page => $name) {
    echo "<button class='test-button' onclick=\"testPage('{$page}')\">测试 {$name}</button>";
}

echo "<div id='test-results' style='margin-top: 20px;'></div>";

echo "</div>";

// 6. JavaScript 测试
echo "<div class='debug-section'>
    <h2 class='debug-title'>6. JavaScript 功能测试</h2>";

echo "<p>JavaScript 状态: <span id='js-status'>测试中...</span></p>";
echo "<p>控制台错误: <span id='console-errors'>无</span></p>";

echo "</div>";

// 7. 当前错误日志
echo "<div class='debug-section'>
    <h2 class='debug-title'>7. 最近的错误信息</h2>";

$error_log = ini_get('error_log');
if ($error_log && file_exists($error_log)) {
    echo "<p>错误日志文件: {$error_log}</p>";
    $errors = file_get_contents($error_log);
    if (strlen($errors) > 5000) {
        $errors = substr($errors, -5000); // 只显示最后5000个字符
    }
    echo "<pre>" . htmlspecialchars($errors) . "</pre>";
} else {
    echo "<p>未找到错误日志文件</p>";
}

echo "</div>";

// JavaScript 测试代码
echo "<script>
// JavaScript 测试
document.getElementById('js-status').innerHTML = '<span class=\"status-ok\">✅ JavaScript 正常工作</span>';

// 捕获控制台错误
let consoleErrors = [];
const originalError = console.error;
console.error = function(...args) {
    consoleErrors.push(args.join(' '));
    originalError.apply(console, args);
};

setTimeout(() => {
    if (consoleErrors.length > 0) {
        document.getElementById('console-errors').innerHTML = '<span class=\"status-error\">❌ ' + consoleErrors.length + ' 个错误</span>';
        console.log('捕获到的错误:', consoleErrors);
    } else {
        document.getElementById('console-errors').innerHTML = '<span class=\"status-ok\">✅ 无错误</span>';
    }
}, 2000);

// 页面加载测试函数
async function testPage(page) {
    const resultsDiv = document.getElementById('test-results');
    resultsDiv.innerHTML = '<p>正在测试 ' + page + '...</p>';
    
    try {
        const response = await fetch(page, { method: 'HEAD' });
        if (response.ok) {
            resultsDiv.innerHTML += '<p class=\"status-ok\">✅ ' + page + ' 可以访问 (状态码: ' + response.status + ')</p>';
        } else {
            resultsDiv.innerHTML += '<p class=\"status-error\">❌ ' + page + ' 返回错误状态码: ' + response.status + '</p>';
        }
    } catch (error) {
        resultsDiv.innerHTML += '<p class=\"status-error\">❌ ' + page + ' 加载失败: ' + error.message + '</p>';
    }
}

// 页面加载完成后的额外检查
document.addEventListener('DOMContentLoaded', function() {
    console.log('调试页面加载完成');
    
    // 检查是否有未捕获的错误
    window.addEventListener('error', function(e) {
        console.log('捕获到页面错误:', e.error);
        document.getElementById('console-errors').innerHTML = '<span class=\"status-error\">❌ 页面错误: ' + e.message + '</span>';
    });
});
</script>";

echo "</body></html>";

// 输出所有缓冲的内容
ob_end_flush();
?>
