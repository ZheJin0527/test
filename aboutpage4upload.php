<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// 处理文件上传
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['media_file'])) {
    $uploadDir = 'images/images/';
    $configFile = 'media_config.json';
    
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $file = $_FILES['media_file'];
    $mediaType = $_POST['media_type'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    $allowedImage = ['jpg', 'jpeg', 'png', 'webp'];
    
    if (in_array($fileExtension, $allowedImage)) {
        // 保持原文件名或使用自定义名称
        if (!empty($_POST['custom_filename'])) {
            $newFileName = $_POST['custom_filename'] . '.' . $fileExtension;
        } else {
            $newFileName = $mediaType . '_' . time() . '.' . $fileExtension;
        }
        
        $targetPath = $uploadDir . $newFileName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $config = [];
            if (file_exists($configFile)) {
                $config = json_decode(file_get_contents($configFile), true) ?: [];
            }
            
            // 为发展历史页面创建数组存储
            if (!isset($config['about_timeline_images'])) {
                $config['about_timeline_images'] = [];
            }
            
            $config['about_timeline_images'][] = [
                'file' => $targetPath,
                'filename' => $newFileName,
                'original_name' => $file['name'],
                'type' => 'image',
                'uploaded' => date('Y-m-d H:i:s'),
                'description' => $_POST['image_description'] ?? ''
            ];
            
            file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
            $success = "图片上传成功！文件名：" . $newFileName;
        } else {
            $error = "文件上传失败！";
        }
    } else {
        $error = "仅支持图片格式：JPG, JPEG, PNG, WebP";
    }
}

// 处理删除图片
if (isset($_POST['delete_image'])) {
    $configFile = 'media_config.json';
    $imageIndex = (int)$_POST['image_index'];
    
    if (file_exists($configFile)) {
        $config = json_decode(file_get_contents($configFile), true) ?: [];
        
        if (isset($config['about_timeline_images'][$imageIndex])) {
            $imageToDelete = $config['about_timeline_images'][$imageIndex];
            
            // 删除文件
            if (file_exists($imageToDelete['file'])) {
                unlink($imageToDelete['file']);
            }
            
            // 从配置中移除
            array_splice($config['about_timeline_images'], $imageIndex, 1);
            
            file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
            $success = "图片删除成功！";
        }
    }
}

// 读取当前配置
$config = [];
if (file_exists('media_config.json')) {
    $config = json_decode(file_get_contents('media_config.json'), true) ?: [];
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>关于我们第四页 - 发展历史图片管理</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .breadcrumb {
            padding: 20px 40px;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        
        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
        }
        
        .content {
            padding: 40px;
        }
        
        .media-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            border-left: 5px solid #28a745;
        }
        
        .upload-form {
            display: grid;
            gap: 20px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
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
        }
        
        .form-input {
            padding: 12px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            font-size: 1em;
        }
        
        .form-input:focus {
            border-color: #28a745;
            outline: none;
        }
        
        .file-input {
            border: 2px dashed #28a745;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            background: #f8fff8;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .file-input:hover {
            border-color: #1e7e34;
            background: #f0fff0;
        }
        
        .file-input input {
            display: none;
        }
        
        .file-input-text {
            color: #28a745;
            font-size: 1.1em;
            font-weight: 500;
        }
        
        .btn {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
        }
        
        .btn-danger:hover {
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }
        
        .images-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .image-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .image-card:hover {
            transform: translateY(-5px);
        }
        
        .image-preview {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .image-info {
            padding: 20px;
        }
        
        .image-info h4 {
            color: #333;
            margin-bottom: 8px;
        }
        
        .image-info p {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 5px;
        }
        
        .image-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
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
        
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .images-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>关于我们第四页 - 发展历史</h1>
            <p>管理发展历史时间线的图片</p>
        </div>
        
        <div class="breadcrumb">
            <a href="dashboard.php">仪表板</a> > 
            <a href="media_manager.php">媒体管理</a> > 
            <span>关于我们第四页</span>
        </div>
        
        <div class="content">
            <a href="media_manager.php" class="back-btn">← 返回媒体管理</a>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="media-section">
                <h2>上传新的历史图片</h2>
                <form method="post" enctype="multipart/form-data" class="upload-form">
                    <input type="hidden" name="media_type" value="about_timeline">
                    
                    <div class="file-input" onclick="document.getElementById('timeline-file').click()">
                        <input type="file" id="timeline-file" name="media_file" accept="image/*">
                        <div class="file-input-text">
                            点击选择图片或拖拽到此处<br>
                            <small>支持 JPG, JPEG, PNG, WebP 格式</small>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>自定义文件名（可选）</label>
                            <input type="text" name="custom_filename" class="form-input" placeholder="例如：2022发展，2023发展">
                        </div>
                        <div class="form-group">
                            <label>图片描述（可选）</label>
                            <input type="text" name="image_description" class="form-input" placeholder="简单描述这张图片的内容">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">上传图片</button>
                </form>
            </div>
            
            <div class="media-section">
                <h2>当前历史图片 (<?php echo isset($config['about_timeline_images']) ? count($config['about_timeline_images']) : 0; ?> 张)</h2>
                
                <?php if (isset($config['about_timeline_images']) && !empty($config['about_timeline_images'])): ?>
                    <div class="images-grid">
                        <?php foreach ($config['about_timeline_images'] as $index => $image): ?>
                            <div class="image-card">
                                <img src="<?php echo $image['file']; ?>" alt="历史图片" class="image-preview">
                                <div class="image-info">
                                    <h4><?php echo $image['filename']; ?></h4>
                                    <p><strong>原文件名：</strong><?php echo $image['original_name']; ?></p>
                                    <p><strong>上传时间：</strong><?php echo $image['uploaded']; ?></p>
                                    <?php if (!empty($image['description'])): ?>
                                        <p><strong>描述：</strong><?php echo htmlspecialchars($image['description']); ?></p>
                                    <?php endif; ?>
                                    
                                    <div class="image-actions">
                                        <button onclick="copyToClipboard('<?php echo $image['file']; ?>')" class="btn">复制路径</button>
                                        <form method="post" style="display: inline;" onsubmit="return confirm('确定要删除这张图片吗？');">
                                            <input type="hidden" name="image_index" value="<?php echo $index; ?>">
                                            <button type="submit" name="delete_image" class="btn btn-danger">删除</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>暂无历史图片，请上传第一张图片。</p>
                <?php endif; ?>
            </div>
            
            <div class="media-section">
                <h2>使用说明</h2>
                <p><strong>如何在HTML中使用这些图片：</strong></p>
                <ul style="margin-left: 20px; margin-top: 10px;">
                    <li>点击"复制路径"按钮获取图片完整路径</li>
                    <li>在HTML中使用：<code>&lt;img src="图片路径" alt="描述"&gt;</code></li>
                    <li>建议为发展历史的每个年份上传对应的图片</li>
                    <li>文件名建议使用年份，如："2022发展.jpg"</li>
                </ul>
            </div>
        </div>
    </div>
    
    <script>
        // 复制路径到剪贴板
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('图片路径已复制到剪贴板：' + text);
            });
        }
        
        // 文件拖拽功能
        document.querySelectorAll('.file-input').forEach(input => {
            input.addEventListener('dragover', (e) => {
                e.preventDefault();
                input.style.borderColor = '#1e7e34';
                input.style.background = '#f0fff0';
            });
            
            input.addEventListener('dragleave', (e) => {
                e.preventDefault();
                input.style.borderColor = '#28a745';
                input.style.background = '#f8fff8';
            });
            
            input.addEventListener('drop', (e) => {
                e.preventDefault();
                const files = e.dataTransfer.files;
                const fileInput = input.querySelector('input[type="file"]');
                fileInput.files = files;
                
                input.style.borderColor = '#28a745';
                input.style.background = '#f8fff8';
                
                if (files.length > 0) {
                    const textDiv = input.querySelector('.file-input-text');
                    textDiv.innerHTML = `已选择: ${files[0].name}`;
                }
            });
        });
        
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const textDiv = this.parentElement.querySelector('.file-input-text');
                if (this.files.length > 0) {
                    textDiv.innerHTML = `已选择: ${this.files[0].name}`;
                }
            });
        });
    </script>
</body>
</html>