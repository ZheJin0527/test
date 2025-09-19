<?php
// 测试数据库连接
$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

echo "正在测试数据库连接...\n";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ 数据库连接成功！\n";
    
    // 检查表是否存在
    $stmt = $pdo->query("SHOW TABLES LIKE 'job_positions'");
    if ($stmt->rowCount() > 0) {
        echo "✅ job_positions 表存在\n";
        
        // 检查表中的数据
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM job_positions");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "📊 职位数据数量: " . $result['count'] . "\n";
        
        if ($result['count'] > 0) {
            // 显示前几条数据
            $stmt = $pdo->query("SELECT id, job_title, company_category FROM job_positions LIMIT 5");
            $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "📋 前5条职位数据:\n";
            foreach ($jobs as $job) {
                echo "  - ID: {$job['id']}, 标题: {$job['job_title']}, 公司: {$job['company_category']}\n";
            }
        } else {
            echo "⚠️ 表中没有数据\n";
        }
    } else {
        echo "❌ job_positions 表不存在\n";
    }
    
} catch (Exception $e) {
    echo "❌ 数据库连接失败: " . $e->getMessage() . "\n";
}
?>
