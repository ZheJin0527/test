<?php
// 错误处理文件 - 用于捕获和显示页面错误

// 设置错误处理
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    // 不显示错误，只记录
    error_log("PHP Error: $errstr in $errfile on line $errline");
    
    // 如果是致命错误，显示用户友好的错误页面
    if ($errno === E_ERROR || $errno === E_PARSE || $errno === E_CORE_ERROR) {
        showErrorPage("页面加载失败", "系统遇到了一个错误，请稍后重试。");
    }
    
    return true; // 阻止PHP默认错误处理
}

function customExceptionHandler($exception) {
    error_log("Uncaught Exception: " . $exception->getMessage());
    showErrorPage("页面加载失败", "系统遇到了一个错误，请稍后重试。");
}

function showErrorPage($title, $message) {
    // 清除之前的输出
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    echo "<!DOCTYPE html>
    <html lang='zh-CN'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>{$title}</title>
        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                margin: 0;
                padding: 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .error-container {
                background: white;
                padding: 40px;
                border-radius: 12px;
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
                text-align: center;
                max-width: 500px;
                width: 90%;
            }
            .error-icon {
                font-size: 64px;
                color: #ff6b6b;
                margin-bottom: 20px;
            }
            .error-title {
                font-size: 24px;
                color: #333;
                margin-bottom: 16px;
                font-weight: 600;
            }
            .error-message {
                color: #666;
                margin-bottom: 30px;
                line-height: 1.6;
            }
            .error-actions {
                display: flex;
                gap: 12px;
                justify-content: center;
                flex-wrap: wrap;
            }
            .btn {
                padding: 12px 24px;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                text-decoration: none;
                font-weight: 500;
                transition: all 0.2s;
            }
            .btn-primary {
                background: #007cba;
                color: white;
            }
            .btn-primary:hover {
                background: #0056b3;
                transform: translateY(-1px);
            }
            .btn-secondary {
                background: #6c757d;
                color: white;
            }
            .btn-secondary:hover {
                background: #545b62;
                transform: translateY(-1px);
            }
            .debug-info {
                margin-top: 30px;
                padding: 20px;
                background: #f8f9fa;
                border-radius: 8px;
                text-align: left;
                font-size: 14px;
            }
            .debug-info h4 {
                margin-top: 0;
                color: #495057;
            }
        </style>
    </head>
    <body>
        <div class='error-container'>
            <div class='error-icon'>⚠️</div>
            <h1 class='error-title'>{$title}</h1>
            <p class='error-message'>{$message}</p>
            
            <div class='error-actions'>
                <a href='javascript:history.back()' class='btn btn-secondary'>返回上页</a>
                <a href='index.php' class='btn btn-primary'>返回首页</a>
                <a href='debug_pages.php' class='btn btn-secondary'>调试工具</a>
            </div>
            
            <div class='debug-info'>
                <h4>调试信息:</h4>
                <p><strong>时间:</strong> " . date('Y-m-d H:i:s') . "</p>
                <p><strong>页面:</strong> " . basename($_SERVER['PHP_SELF']) . "</p>
                <p><strong>Session状态:</strong> " . (isset($_SESSION) ? '已启动' : '未启动') . "</p>";
                
                if (isset($_SESSION['user_id'])) {
                    echo "<p><strong>用户:</strong> " . htmlspecialchars($_SESSION['username'] ?? '未知') . "</p>";
                }
                
                echo "<p><strong>建议:</strong> 如果问题持续存在，请检查网络连接或联系管理员。</p>
            </div>
        </div>
    </body>
    </html>";
    
    exit;
}

// 设置错误和异常处理
set_error_handler('customErrorHandler');
set_exception_handler('customExceptionHandler');

// 设置较长的执行时间
set_time_limit(60);

// 增加内存限制
ini_set('memory_limit', '256M');

// 启用错误日志记录
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

// 检查关键文件是否存在
function checkCriticalFiles() {
    $critical_files = ['sidebar.php'];
    
    foreach ($critical_files as $file) {
        if (!file_exists($file)) {
            showErrorPage("文件缺失", "系统关键文件缺失，请联系管理员。");
        }
    }
}

// 检查数据库连接
function checkDatabaseConnection() {
    $host = 'localhost';
    $dbname = 'u857194726_kunzzgroup';
    $dbuser = 'u857194726_kunzzgroup';
    $dbpass = 'Kholdings1688@';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        // 不立即显示错误，让页面尝试加载
        return null;
    }
}

// 执行检查
checkCriticalFiles();
?>
