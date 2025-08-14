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
            'label' => trim($_POST['main_label']),
            'address' => trim($_POST['main_address']),
            'phone' => trim($_POST['main_phone']),
            'map_url' => trim($_POST['main_map_url'])
        ],
        'branch_store' => [
            'label' => trim($_POST['branch_label']),
            'address' => trim($_POST['branch_address']),
            'phone' => trim($_POST['branch_phone']),
            'map_url' => trim($_POST['branch_map_url'])
        ]
    ];
    
    if (saveTokyoLocationConfig($config)) {
        $success = "位置信息更新成功！";
        // 添加页面重定向，清除缓存
        echo "<script>
            setTimeout(function() {
                window.location.href = window.location.href + '?updated=' + Date.now();
            }, 2000);
        </script>";
    } else {
        $error = "更新失败，请重试！";
    }
}

// 读取当前配置
$currentConfig = getTokyoLocationConfig();
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tokyo 位置信息管理 - KUNZZ HOLDINGS</title>
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
        
        .form-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            border-left: 5px solid #FF5C00;
        }
        
        .form-section h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.8em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .form-grid {
            display: grid;
            gap: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .form-group label {
            font-weight: 600;
            color: #555;
            font-size: 1.1em;
        }
        
        .form-input {
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1em;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #FF5C00;
            box-shadow: 0 0 0 3px rgba(255, 92, 0, 0.1);
        }
        
        .form-input.textarea {
            min-height: 80px;
            resize: vertical;
            font-family: inherit;
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
            background: #fff;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
        }
        
        .preview-section h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        
        .preview-content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #FF5C00;
        }
        
        .preview-content h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.5em;
        }
        
        .preview-content p {
            margin-bottom: 10px;
            line-height: 1.6;
        }
        
        .preview-content a {
            color: #FF5C00;
            text-decoration: none;
        }
        
        .preview-content a:hover {
            text-decoration: underline;
        }
        
        .store-section {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
        }
        
        .store-section h3 {
            color: #FF5C00;
            margin-bottom: 20px;
            font-size: 1.4em;
            border-bottom: 2px solid #FF5C00;
            padding-bottom: 10px;
        }
        
        .help-text {
            font-size: 0.9em;
            color: #6c757d;
            margin-top: 5px;
            font-style: italic;
        }
        
        @media (max-width: 768px) {
            .content {
                padding: 20px;
            }
            
            .form-section {
                padding: 20px;
            }
            
            .store-section {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Tokyo 位置信息管理</h1>
            <p>管理 Tokyo Japanese Cuisine 总店与分店信息</p>
        </div>
        
        <div class="breadcrumb">
            <a href="dashboard.php">仪表板</a> > 
            <a href="media_manager.php">媒体管理</a> > 
            <span>Tokyo 位置信息</span>
        </div>
        
        <div class="content">
            <a href="media_manager.php" class="back-btn">← 返回媒体管理</a>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="post" class="form-section">
                <h2>📍 编辑位置信息</h2>
                
                <!-- 总店信息 -->
                <div class="store-section">
                    <h3>🏪 总店信息</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="main_label">标签文字</label>
                            <input type="text" id="main_label" name="main_label" class="form-input" 
                                   value="<?php echo htmlspecialchars($currentConfig['main_store']['label']); ?>" required>
                            <div class="help-text">例如：总店：</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="main_address">地址</label>
                            <textarea id="main_address" name="main_address" class="form-input textarea" required><?php echo htmlspecialchars($currentConfig['main_store']['address']); ?></textarea>
                            <div class="help-text">请输入完整的店铺地址</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="main_phone">电话号码</label>
                            <input type="text" id="main_phone" name="main_phone" class="form-input" 
                                   value="<?php echo htmlspecialchars($currentConfig['main_store']['phone']); ?>" required>
                            <div class="help-text">例如：+60 19-710 8090</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="main_map_url">地图链接</label>
                            <input type="url" id="main_map_url" name="main_map_url" class="form-input" 
                                   value="<?php echo htmlspecialchars($currentConfig['main_store']['map_url']); ?>" required>
                            <div class="help-text">Google Maps 分享链接</div>
                        </div>
                    </div>
                </div>
                
                <!-- 分店信息 -->
                <div class="store-section">
                    <h3>🏬 分店信息</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="branch_label">标签文字</label>
                            <input type="text" id="branch_label" name="branch_label" class="form-input" 
                                   value="<?php echo htmlspecialchars($currentConfig['branch_store']['label']); ?>" required>
                            <div class="help-text">例如：分店：</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="branch_address">地址</label>
                            <textarea id="branch_address" name="branch_address" class="form-input textarea" required><?php echo htmlspecialchars($currentConfig['branch_store']['address']); ?></textarea>
                            <div class="help-text">请输入完整的店铺地址</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="branch_phone">电话号码</label>
                            <input type="text" id="branch_phone" name="branch_phone" class="form-input" 
                                   value="<?php echo htmlspecialchars($currentConfig['branch_store']['phone']); ?>" required>
                            <div class="help-text">例如：+60 18-773 8090</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="branch_map_url">地图链接</label>
                            <input type="url" id="branch_map_url" name="branch_map_url" class="form-input" 
                                   value="<?php echo htmlspecialchars($currentConfig['branch_store']['map_url']); ?>" required>
                            <div class="help-text">Google Maps 分享链接</div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn">💾 保存更改</button>
            </form>
            
            <!-- 预览区域 -->
            <div class="preview-section">
                <h3>📱 预览效果</h3>
                <div class="preview-content">
                    <?php echo getTokyoLocationHtml(); ?>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // 实时预览功能
        function updatePreview() {
            const previewContent = document.querySelector('.preview-content');
            
            const mainLabel = document.getElementById('main_label').value;
            const mainAddress = document.getElementById('main_address').value;
            const mainPhone = document.getElementById('main_phone').value;
            const mainMapUrl = document.getElementById('main_map_url').value;
            
            const branchLabel = document.getElementById('branch_label').value;
            const branchAddress = document.getElementById('branch_address').value;
            const branchPhone = document.getElementById('branch_phone').value;
            const branchMapUrl = document.getElementById('branch_map_url').value;
            
            let html = '<h2>我们在这</h2>';
            
            // 总店信息
            if (mainLabel || mainAddress) {
                html += `<p>${mainLabel}<a href="${mainMapUrl}" target="_blank" class="no-style-link">${mainAddress}</a></p>`;
                html += `<p>电话：${mainPhone}</p>`;
            }
            
            // 分店信息
            if (branchLabel || branchAddress) {
                html += `<p>${branchLabel}<a href="${branchMapUrl}" target="_blank" class="no-style-link">${branchAddress}</a></p>`;
                html += `<p>电话：${branchPhone}</p>`;
            }
            
            previewContent.innerHTML = html;
        }
        
        // 为所有输入框添加实时预览
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('input', updatePreview);
        });
        
        // 表单验证
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = document.querySelectorAll('.form-input[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#dc3545';
                } else {
                    field.style.borderColor = '#e9ecef';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('请填写所有必填字段！');
            }
        });
    </script>
</body>
</html>