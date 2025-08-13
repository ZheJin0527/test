<?php
session_start();

// 检查是否已登录
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// 处理文件上传
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo_file'])) {
    $uploadDir = 'j12tb/j12tb/';
    $configFile = 'photos_config.json';
    
    // 确保上传目录存在
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $file = $_FILES['photo_file'];
    $photoIndex = $_POST['photo_index'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    // 允许的文件类型
    $allowedImage = ['jpg', 'jpeg', 'png', 'webp'];
    
    if (in_array($fileExtension, $allowedImage)) {
        // 生成文件名
        $fileName = $photoIndex . '.jpg';
        $targetPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // 更新配置文件
            $config = [];
            if (file_exists($configFile)) {
                $config = json_decode(file_get_contents($configFile), true) ?: [];
            }
            
            $config[$photoIndex] = [
                'file' => $targetPath,
                'original_name' => $file['name'],
                'updated' => date('Y-m-d H:i:s')
            ];
            
            file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
            $success = "照片 {$photoIndex} 上传成功！";
            
            // 页面重定向清除缓存
            echo "<script>
                setTimeout(function() {
                    window.location.href = window.location.href.split('?')[0] + '?updated=' + Date.now();
                }, 1500);
            </script>";
        } else {
            $error = "照片 {$photoIndex} 上传失败！";
        }
    } else {
        $error = "不支持的文件类型！只支持 JPG, PNG, WebP 格式";
    }
}

// 处理批量删除
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_photo'])) {
    $photoIndex = $_POST['delete_photo'];
    $configFile = 'photos_config.json';
    $filePath = 'j12tb/j12tb/' . $photoIndex . '.jpg';
    
    // 删除文件
    if (file_exists($filePath)) {
        unlink($filePath);
    }
    
    // 更新配置
    if (file_exists($configFile)) {
        $config = json_decode(file_get_contents($configFile), true) ?: [];
        unset($config[$photoIndex]);
        file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
    }
    
    $success = "照片 {$photoIndex} 删除成功！";
}

// 读取当前配置
$config = [];
if (file_exists('photos_config.json')) {
    $config = json_decode(file_get_contents('photos_config.json'), true) ?: [];
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我们的足迹照片管理 - KUNZZ HOLDINGS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 15px;
            font-size: 14px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2em;
            margin-bottom: 8px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 1em;
        }
        
        .breadcrumb {
            padding: 15px 30px;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            font-size: 13px;
        }
        
        .breadcrumb a {
            color: #f093fb;
            text-decoration: none;
        }
        
        .content {
            padding: 25px;
        }
        
        .back-btn {
            display: inline-block;
            background: #6c757d;
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 13px;
            transition: all 0.3s ease;
        }
        
        .back-btn:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }
        
        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 13px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 3px solid #28a745;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 3px solid #dc3545;
        }
        
        .photos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .photo-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .photo-card:hover {
            border-color: #f093fb;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(240, 147, 251, 0.2);
        }
        
        .photo-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }
        
        .photo-number {
            font-weight: 600;
            color: #f093fb;
            font-size: 14px;
        }
        
        .photo-status {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .status-uploaded {
            background: #d4edda;
            color: #155724;
        }
        
        .status-empty {
            background: #f8d7da;
            color: #721c24;
        }
        
        .photo-preview {
            width: 100%;
            height: 150px;
            background: #e9ecef;
            border-radius: 6px;
            margin-bottom: 10px;
            overflow: hidden;
            position: relative;
        }
        
        .photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .photo-preview.empty {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 12px;
            border: 2px dashed #dee2e6;
        }
        
        .upload-form {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .file-input-wrapper {
            position: relative;
            flex: 1;
        }
        
        .file-input-btn {
            width: 100%;
            padding: 8px 12px;
            background: #f093fb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        }
        
        .file-input-btn:hover {
            background: #e080ea;
        }
        
        .file-input-btn.selected {
            background: #28a745;
        }
        
        .file-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .upload-btn {
            padding: 8px 12px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
        }
        
        .upload-btn:hover {
            background: #218838;
        }
        
        .upload-btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }
        
        .delete-btn {
            padding: 6px 10px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 11px;
            margin-top: 8px;
        }
        
        .delete-btn:hover {
            background: #c82333;
        }
        
        .photo-info {
            font-size: 11px;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .section-title {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.4em;
            border-left: 4px solid #f093fb;
            padding-left: 12px;
        }
        
        @media (max-width: 768px) {
            .photos-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 12px;
            }
            
            .content {
                padding: 15px;
            }
        }
        
        @media (max-width: 480px) {
            .photos-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>我们的足迹照片管理</h1>
            <p>管理加入我们页面的34张照片</p>
        </div>
        
        <div class="breadcrumb">
            <a href="dashboard.php">仪表板</a> > 
            <a href="media_manager.php">媒体管理</a> > 
            <span>我们的足迹照片</span>
        </div>
        
        <div class="content">
            <a href="media_manager.php" class="back-btn">← 返回媒体管理</a>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <h2 class="section-title">照片管理 (1-34)</h2>
            
            <div class="photos-grid">
                <?php for ($i = 1; $i <= 34; $i++): ?>
                    <div class="photo-card">
                        <div class="photo-header">
                            <div class="photo-number">照片 <?php echo $i; ?></div>
                            <div class="photo-status <?php echo isset($config[$i]) ? 'status-uploaded' : 'status-empty'; ?>">
                                <?php echo isset($config[$i]) ? '已上传' : '未上传'; ?>
                            </div>
                        </div>
                        
                        <div class="photo-preview <?php echo !isset($config[$i]) ? 'empty' : ''; ?>">
                            <?php if (isset($config[$i]) && file_exists($config[$i]['file'])): ?>
                                <img src="<?php echo $config[$i]['file']; ?>?v=<?php echo time(); ?>" alt="照片 <?php echo $i; ?>">
                            <?php else: ?>
                                暂无照片
                            <?php endif; ?>
                        </div>
                        
                        <form method="post" enctype="multipart/form-data" class="upload-form">
                            <input type="hidden" name="photo_index" value="<?php echo $i; ?>">
                            
                            <div class="file-input-wrapper">
                                <button type="button" class="file-input-btn" id="btn-<?php echo $i; ?>">
                                    选择文件
                                </button>
                                <input type="file" name="photo_file" class="file-input" 
                                       accept="image/*" id="file-<?php echo $i; ?>" 
                                       onchange="updateFileName(<?php echo $i; ?>)">
                            </div>
                            
                            <button type="submit" class="upload-btn" id="upload-<?php echo $i; ?>" disabled>
                                上传
                            </button>
                        </form>
                        
                        <?php if (isset($config[$i])): ?>
                            <div class="photo-info">
                                原文件名: <?php echo htmlspecialchars($config[$i]['original_name']); ?><br>
                                更新时间: <?php echo $config[$i]['updated']; ?>
                            </div>
                            
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="delete_photo" value="<?php echo $i; ?>">
                                <button type="submit" class="delete-btn" 
                                        onclick="return confirm('确定要删除照片 <?php echo $i; ?> 吗？')">
                                    删除
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    
    <script>
        function updateFileName(index) {
            const fileInput = document.getElementById(`file-${index}`);
            const button = document.getElementById(`btn-${index}`);
            const uploadBtn = document.getElementById(`upload-${index}`);
            
            if (fileInput.files.length > 0) {
                const fileName = fileInput.files[0].name;
                button.textContent = fileName.length > 15 ? fileName.substring(0, 15) + '...' : fileName;
                button.classList.add('selected');
                uploadBtn.disabled = false;
            } else {
                button.textContent = '选择文件';
                button.classList.remove('selected');
                uploadBtn.disabled = true;
            }
        }
        
        // 为所有文件按钮添加点击事件
        document.addEventListener('DOMContentLoaded', function() {
            for (let i = 1; i <= 34; i++) {
                const button = document.getElementById(`btn-${i}`);
                const fileInput = document.getElementById(`file-${i}`);
                
                button.addEventListener('click', function() {
                    fileInput.click();
                });
            }
        });
    </script>
</body>
</html>