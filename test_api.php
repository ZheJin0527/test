<?php
// 测试API响应
echo "正在测试 get_jobs_api.php...\n";

$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/get_jobs_api.php';
echo "API URL: $url\n";

$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => 'Content-Type: application/json'
    ]
]);

$response = file_get_contents($url, false, $context);

if ($response === FALSE) {
    echo "❌ API请求失败\n";
} else {
    echo "✅ API响应成功\n";
    echo "响应内容:\n";
    echo $response . "\n";
    
    // 解析JSON
    $data = json_decode($response, true);
    if ($data) {
        echo "JSON解析成功\n";
        echo "Success: " . ($data['success'] ? 'true' : 'false') . "\n";
        if (isset($data['companies'])) {
            echo "公司数量: " . count($data['companies']) . "\n";
            foreach ($data['companies'] as $company => $info) {
                echo "  - $company: " . count($info['jobs']) . " 个职位\n";
            }
        }
    } else {
        echo "❌ JSON解析失败\n";
    }
}
?>
