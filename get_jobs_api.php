<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// 处理预检请求
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// 数据库配置
$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 获取所有职位
    $stmt = $pdo->prepare("SELECT * FROM job_positions ORDER BY publish_date DESC, id DESC");
    $stmt->execute();
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // 按公司分组职位数据
    $companies = [
        'KUNZZHOLDINGS' => [
            'name' => 'KUNZZHOLDINGS',
            'jobs' => []
        ],
        'TOKYO CUISINE' => [
            'name' => 'TOKYO CUISINE',
            'jobs' => []
        ]
    ];
    
    // 处理每个职位
    foreach ($jobs as $job) {
        $company = $job['company_category'] ?? 'KUNZZHOLDINGS';
        
        // 确保公司存在
        if (!isset($companies[$company])) {
            $companies[$company] = [
                'name' => $company,
                'jobs' => []
            ];
        }
        
        // 添加职位到对应公司
        $jobData = [
            'id' => $job['id'],
            'title' => $job['job_title'],
            'count' => $job['recruitment_count'],
            'experience' => $job['work_experience'],
            'publish_date' => $job['publish_date'],
            'description' => $job['job_description']
        ];
        
        $companies[$company]['jobs'][] = $jobData;
    }
    
    // 返回结构化的数据
    $response = [
        'success' => true,
        'companies' => $companies
    ];
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    $response = [
        'success' => false,
        'error' => '获取职位数据失败: ' . $e->getMessage()
    ];
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
?>
