<?php
session_start();
include_once 'media_config.php';

// 检查是否已登录（根据你的登录系统调整）
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $config = [
        'main_store' => [
            'name' => '总店',
            'address' => $_POST['main_address'] ?? '',
            'phone' => $_POST['main_phone'] ?? '',
            'map_url' => $_POST['main_map_url'] ?? ''
        ],
        'branch_store' => [
            'name' => '分店',
            'address' => $_POST['branch_address'] ?? '',
            'phone' => $_POST['branch_phone'] ?? '',
            'map_url' => $_POST['branch_map_url'] ?? ''
        ]
    ];
    
    if (saveLocationConfig($config)) {
        $success = "地址信息更新成功！";
        // 清除缓存
        echo "<script>
            setTimeout(function() {
                window.location.href = window.location.href + '?updated=' + Date.now();
            }, 2000);
        </script>";
    } else {
        $error = "保存失败，请重试！";
    }
}

// 读取当前配置
$locationConfig = getLocationConfig();
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tokyo Japanese Cuisine 地址管理 - KUNZZ HOLDINGS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #ffffffff 0%, #f3ebe0ff 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 3px solid #FF5C00;
        }
        
        .header {
            background: linear-gradient(135deg, #FF5C00 0%, #ff7a33 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 1.1em;
        }
        
        .breadcrumb {
            padding: 20px 40px;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        
        .breadcrumb a {
            color: #FF5C00;
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        .content {
            padding: 40px;
        }
        
        .location-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            border-left: 5px solid #FF5C00;
        }
        
        .location-section h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.8em;
        }
        
        .store-form {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
        }
        
        .store-form h3 {
            color: #FF5C00;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #FF5C00;
            box-shadow: 0 0 0 3px rgba(255, 92, 0, 0.1);
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #666;
            font-size: 12px;
        }
        
        .btn {
            background: linear-gradient(135deg, #FF5C00 0%, #ff7a33 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 92, 0, 0.3);
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        .back-btn {
            display: inline-block;
            background: #6c757d;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .back-btn:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }
        
        .preview-section {
            background: #e9f7ef;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
        }
        
        .preview-section h3 {
            color: #155724;
            margin-bottom: 15px;
        }
        
        .preview-content {
            background: white;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #28a745;
        }
        
        @media (max-width: 768px) {
            .content {
                padding: 20px;
            }
            
            .location-section {
                padding: 20px;
            }
            
            .store-form {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Tokyo Japanese Cuisine 地址管理</h1>
            <p>管理餐厅地址和联系信息</p>
        </div>
        
        <div class="breadcrumb">
            <a href="dashboard.php">仪表板</a> > 
            <a href="media_manager.php">媒体管理</a> > 
            <span>Tokyo Japanese Cuisine 地址管理</span>
        </div>
        
        <div class="content">
            <a href="media_manager.php" class="back-btn">← 返回媒体管理</a>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="location-section">
                <h2>📍 餐厅地址信息管理</h2>
                
                <form method="post">
                    <!-- 总店信息 -->
                    <div class="store-form">
                        <h3>🏪 总店信息</h3>
                        
                        <div class="form-group">
                            <label for="main_address">总店地址*</label>
                            <textarea id="main_address" name="main_address" required><?php echo htmlspecialchars($locationConfig['main_store']['address'] ?? ''); ?></textarea>
                            <small>请输入完整的总店地址</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="main_phone">总店电话*</label>
                            <input type="tel" id="main_phone" name="main_phone" value="<?php echo htmlspecialchars($locationConfig['main_store']['phone'] ?? ''); ?>" required>
                            <small>格式: +60 19-710 8090</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="main_map_url">总店地图链接*</label>
                            <input type="url" id="main_map_url" name="main_map_url" value="<?php echo htmlspecialchars($locationConfig['main_store']['map_url'] ?? ''); ?>" required>
                            <small>Google Maps 分享链接，例如: https://maps.app.goo.gl/...</small>
                        </div>
                    </div>
                    
                    <!-- 分店信息 -->
                    <div class="store-form">
                        <h3>🏢 分店信息</h3>
                        
                        <div class="form-group">
                            <label for="branch_address">分店地址*</label>
                            <textarea id="branch_address" name="branch_address" required><?php echo htmlspecialchars($locationConfig['branch_store']['address'] ?? ''); ?></textarea>
                            <small>请输入完整的分店地址</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="branch_phone">分店电话*</label>
                            <input type="tel" id="branch_phone" name="branch_phone" value="<?php echo htmlspecialchars($locationConfig['branch_store']['phone'] ?? ''); ?>" required>
                            <small>格式: +60 18-773 8090</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="branch_map_url">分店地图链接*</label>
                            <input type="url" id="branch_map_url" name="branch_map_url" value="<?php echo htmlspecialchars($locationConfig['branch_store']['map_url'] ?? ''); ?>" required>
                            <small>Google Maps 分享链接，例如: https://maps.app.goo.gl/...</small>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">💾 保存地址信息</button>
                </form>
                
                <!-- 预览区域 -->
                <div class="preview-section">
                    <h3>📋 当前页面显示预览</h3>
                    <div class="preview-content">
                        <?php echo getLocationHtml(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // 表单验证
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = ['main_address', 'main_phone', 'main_map_url', 'branch_address', 'branch_phone', 'branch_map_url'];
            let isValid = true;
            
            requiredFields.forEach(fieldName => {
                const field = document.querySelector(`[name="${fieldName}"]`);
                if (!field.value.trim()) {
                    field.style.borderColor = '#dc3545';
                    isValid = false;
                } else {
                    field.style.borderColor = '#e0e0e0';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('请填写所有必填项！');
            }
        });
        
        // 电话号码格式验证
        document.querySelectorAll('input[type="tel"]').forEach(input => {
            input.addEventListener('blur', function() {
                const phonePattern = /^\+\d{2}\s\d{2}-\d{3}\s\d{4}$/;
                if (this.value && !phonePattern.test(this.value)) {
                    this.style.borderColor = '#ffc107';
                    this.nextElementSibling.style.color = '#856404';
                    this.nextElementSibling.textContent = '建议格式: +60 19-710 8090 (不强制要求此格式)';
                } else {
                    this.style.borderColor = '#e0e0e0';
                    this.nextElementSibling.style.color = '#666';
                }
            });
        });
        
        // URL格式验证
        document.querySelectorAll('input[type="url"]').forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value && !this.value.startsWith('http')) {
                    this.style.borderColor = '#dc3545';
                } else {
                    this.style.borderColor = '#e0e0e0';
                }
            });
        });
    </script>
</body>
</html>