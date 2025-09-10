<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// 处理预检请求
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// 包含数据库配置
include_once 'media_config.php';

try {
    // 获取所有活跃的职位
    $jobs = getJobsConfig();
    
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
    foreach ($jobs as $jobId => $job) {
        if ($job['status'] !== 'active') continue;
        
        $company = $job['category'] ?? 'KUNZZHOLDINGS';
        
        // 确保公司存在
        if (!isset($companies[$company])) {
            $companies[$company] = [
                'name' => $company,
                'jobs' => []
            ];
        }
        
        // 添加职位到对应公司
        $jobData = [
            'id' => $jobId,
            'title' => $job['title'],
            'count' => $job['count'],
            'experience' => $job['experience'],
            'publish_date' => $job['publish_date'],
            'description' => $job['description']
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
