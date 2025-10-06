<?php
// 快速页面状态检查脚本
session_start();

echo "<h1>🔍 快速页面状态检查</h1>";
echo "<p><strong>当前时间:</strong> " . date('Y-m-d H:i:s') . "</p>";

// 检查Session
echo "<h2>Session 状态:</h2>";
if (isset($_SESSION['user_id'])) {
    echo "✅ 用户已登录: " . htmlspecialchars($_SESSION['username'] ?? '未知') . "<br>";
    
    if (isset($_SESSION['last_activity'])) {
        $timeDiff = time() - $_SESSION['last_activity'];
        echo "最后活动: {$timeDiff} 秒前<br>";
        
        if ($timeDiff > 1800) {
            echo "⚠️ Session可能已超时<br>";
        }
    }
} else {
    echo "❌ 用户未登录<br>";
}

// 检查数据库连接
echo "<h2>数据库连接:</h2>";
try {
    $host = 'localhost';
    $dbname = 'u857194726_kunzzgroup';
    $dbuser = 'u857194726_kunzzgroup';
    $dbpass = 'Kholdings1688@';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
    echo "✅ 数据库连接正常<br>";
} catch (PDOException $e) {
    echo "❌ 数据库连接失败: " . htmlspecialchars($e->getMessage()) . "<br>";
}

// 检查关键文件
echo "<h2>关键文件:</h2>";
$files = ['sidebar.php', 'kpiedit.php', 'stocklist.php', 'generatecode.php'];
foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✅ {$file}<br>";
    } else {
        echo "❌ {$file} 缺失<br>";
    }
}

echo "<hr>";
echo "<p><a href='debug_pages.php'>🔧 完整调试工具</a></p>";
echo "<p><a href='kpiedit.php'>📊 KPI编辑页面</a></p>";
echo "<p><a href='stocklist.php'>📦 库存列表页面</a></p>";
echo "<p><a href='generatecode.php'>👥 职员管理页面</a></p>";
?>
