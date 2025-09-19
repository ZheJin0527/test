<?php
session_start();

// 检查是否已登录
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// 处理文件上传
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['media_file'])) {
    $uploadDir = 'comphoto/comphoto/';
    $configFile = 'media_config.json';
    
    // 确保上传目录存在
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $file = $_FILES['media_file'];
    $photoNumber = $_POST['photo_number'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    // 允许的文件类型
    $allowedImage = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($fileExtension, $allowedImage)) {
        // 生成新文件名
        $newFileName = $photoNumber . '.' . $fileExtension;
        $targetPath = $uploadDir . $newFileName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // 尝试压缩与调整图片尺寸以减少页面加载压力
            try {
                if (function_exists('getimagesize')) {
                    $imageInfo = @getimagesize($targetPath);
                    if ($imageInfo) {
                        $originalWidth = $imageInfo[0] ?? 0;
                        $originalHeight = $imageInfo[1] ?? 0;
                        $mime = $imageInfo['mime'] ?? '';

                        // 仅在图片较大时进行缩放（例如宽或高大于1600）
                        $maxDimension = 1600;
                        if ($originalWidth > 0 && $originalHeight > 0 && (max($originalWidth, $originalHeight) > $maxDimension)) {
                            $scale = $maxDimension / max($originalWidth, $originalHeight);
                            $newWidth = (int) floor($originalWidth * $scale);
                            $newHeight = (int) floor($originalHeight * $scale);

                            // 创建源图像资源
                            $src = null;
                            if ($mime === 'image/jpeg' || $fileExtension === 'jpg' || $fileExtension === 'jpeg') {
                                if (function_exists('imagecreatefromjpeg')) {
                                    $src = @imagecreatefromjpeg($targetPath);
                                }
                            } elseif ($mime === 'image/png' || $fileExtension === 'png') {
                                if (function_exists('imagecreatefrompng')) {
                                    $src = @imagecreatefrompng($targetPath);
                                }
                            } elseif ($mime === 'image/webp' || $fileExtension === 'webp') {
                                if (function_exists('imagecreatefromwebp')) {
                                    $src = @imagecreatefromwebp($targetPath);
                                }
                            }

                            if ($src) {
                                $dst = imagecreatetruecolor($newWidth, $newHeight);

                                // 处理 PNG 透明度
                                if ($mime === 'image/png' || $fileExtension === 'png') {
                                    imagealphablending($dst, false);
                                    imagesavealpha($dst, true);
                                }

                                imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

                                // 覆盖保存，使用合理质量
                                if (($mime === 'image/jpeg' || $fileExtension === 'jpg' || $fileExtension === 'jpeg') && function_exists('imagejpeg')) {
                                    @imagejpeg($dst, $targetPath, 82);
                                } elseif (($mime === 'image/png' || $fileExtension === 'png') && function_exists('imagepng')) {
                                    // PNG 压缩级别 0-9（数值越大压缩越高）
                                    @imagepng($dst, $targetPath, 6);
                                } elseif (($mime === 'image/webp' || $fileExtension === 'webp') && function_exists('imagewebp')) {
                                    @imagewebp($dst, $targetPath, 82);
                                }

                                imagedestroy($dst);
                                imagedestroy($src);
                            }
                        }
                    }
                }
            } catch (\Throwable $t) {
                // 忽略压缩失败，继续后续逻辑
            }
            // 更新配置文件
            $config = [];
            if (file_exists($configFile)) {
                $config = json_decode(file_get_contents($configFile), true) ?: [];
            }
            
            $config['comphoto_' . $photoNumber] = [
                'file' => $targetPath,
                'type' => 'image',
                'updated' => date('Y-m-d H:i:s')
            ];
            
            file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
            $success = "照片 #{$photoNumber} 上传成功！";

            // 页面重定向，清除缓存
            echo "<script>
                setTimeout(function() {
                    window.location.href = window.location.href + '?updated=' + Date.now();
                }, 1500);
            </script>";
        } else {
            $error = "照片上传失败！";
        }
    } else {
        $error = "只支持图片格式（JPG, PNG, WebP）！";
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
    <link rel="icon" type="image/png" href="images/images/logo.png">
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
            background: linear-gradient(135deg, #ffffffff 0%, #f3ebe0ff 100%);
            min-height: 100vh;
            padding: 15px;
        }
        
        .container {
            max-width: 1400px;
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
            padding: 25px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.2em;
            margin-bottom: 8px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 1.05em;
        }
        
        .breadcrumb {
            padding: 15px 30px;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            font-size: 0.9em;
        }
        
        .breadcrumb a {
            color: #FF5C00;
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        .content {
            padding: 30px;
        }
        
        .back-btn {
            display: inline-block;
            background: #6c757d;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.9em;
            transition: all 0.3s ease;
        }
        
        .back-btn:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }
        
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
            font-size: 0.9em;
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
        
        .photos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .photo-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid #FF5C00;
            transition: all 0.3s ease;
        }
        
        .photo-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .photo-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .photo-number {
            background: #FF5C00;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 12px;
            font-size: 0.9em;
        }
        
        .photo-title {
            font-size: 1.1em;
            font-weight: 600;
            color: #333;
        }
        
        .file-input {
            border: 2px dashed #FF5C00;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background: #fff9f5;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-bottom: 15px;
        }
        
        .file-input:hover {
            border-color: #e54a00;
            background: #fff5f0;
        }
        
        .file-input input {
            display: none;
        }
        
        .file-input-text {
            color: #FF5C00;
            font-size: 0.9em;
            font-weight: 500;
        }
        
        .current-image {
            margin-bottom: 15px;
        }
        
        .current-image img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e9ecef;
        }
        
        .image-info {
            margin-top: 8px;
            padding: 8px;
            background: #e8f4f8;
            border-radius: 6px;
            font-size: 0.8em;
            color: #155724;
        }
        
        .upload-btn {
            background: linear-gradient(135deg, #FF5C00 0%, #ff7a33 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 0.9em;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .upload-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(255, 92, 0, 0.3);
        }
        
        .section-title {
            color: #333;
            font-size: 1.5em;
            margin-bottom: 20px;
            text-align: center;
            border-bottom: 2px solid #FF5C00;
            padding-bottom: 10px;
        }
        
        .stats-bar {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
            border: 1px solid #dee2e6;
        }
        
        .stats-item {
            display: inline-block;
            margin: 0 20px;
            color: #666;
        }
        
        .stats-number {
            font-size: 1.2em;
            font-weight: 600;
            color: #FF5C00;
        }
        
        @media (max-width: 768px) {
            .photos-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .content {
                padding: 20px;
            }
            
            .stats-item {
                display: block;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="container">
        <div class="header">
            <h1>我们的足迹照片管理</h1>
            <p>管理30张公司活动照片</p>
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

            <?php
            // 统计已上传的照片
            $uploadedCount = 0;
            for ($i = 1; $i <= 30; $i++) {
                if (isset($config['comphoto_' . $i]) && file_exists($config['comphoto_' . $i]['file'])) {
                    $uploadedCount++;
                }
            }
            ?>
            
            <div class="stats-bar">
                <div class="stats-item">
                    总照片数: <span class="stats-number">30</span>
                </div>
                <div class="stats-item">
                    已上传: <span class="stats-number"><?php echo $uploadedCount; ?></span>
                </div>
                <div class="stats-item">
                    待上传: <span class="stats-number"><?php echo 30 - $uploadedCount; ?></span>
                </div>
            </div>
            
            <h2 class="section-title">照片上传管理</h2>
            
            <div class="photos-grid">
                <?php for ($i = 1; $i <= 30; $i++): ?>
                    <div class="photo-card">
                        <div class="photo-header">
                            <div class="photo-number"><?php echo $i; ?></div>
                            <div class="photo-title">照片 #<?php echo $i; ?></div>
                        </div>
                        
                        <?php if (isset($config['comphoto_' . $i]) && file_exists($config['comphoto_' . $i]['file'])): ?>
                            <div class="current-image">
                                <img loading="lazy" src="<?php echo $config['comphoto_' . $i]['file']; ?>?v=<?php echo file_exists($config['comphoto_' . $i]['file']) ? filemtime($config['comphoto_' . $i]['file']) : time(); ?>" alt="照片 <?php echo $i; ?>">
                                <div class="image-info">
                                    <strong>已上传</strong><br>
                                    <small>更新: <?php echo $config['comphoto_' . $i]['updated']; ?></small>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" name="photo_number" value="<?php echo $i; ?>">
                            
                            <div class="file-input" onclick="document.getElementById('file-<?php echo $i; ?>').click()">
                                <input type="file" id="file-<?php echo $i; ?>" name="media_file" accept="image/*">
                                <div class="file-input-text">
                                    点击选择图片<br>
                                    <small>支持 JPG, PNG, WebP</small>
                                </div>
                            </div>
                            
                            <button type="submit" class="upload-btn">
                                <?php echo isset($config['comphoto_' . $i]) ? '更新照片' : '上传照片'; ?>
                            </button>
                        </form>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    
    <script>
        // 文件选择时显示文件名
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const textDiv = this.parentElement.querySelector('.file-input-text');
                if (this.files.length > 0) {
                    textDiv.innerHTML = `已选择: ${this.files[0].name}<br><small>点击上传按钮完成上传</small>`;
                }
            });
        });
        
        // 拖拽功能
        document.querySelectorAll('.file-input').forEach(input => {
            input.addEventListener('dragover', (e) => {
                e.preventDefault();
                input.style.borderColor = '#e54a00';
                input.style.background = '#fff5f0';
            });
            
            input.addEventListener('dragleave', (e) => {
                e.preventDefault();
                input.style.borderColor = '#FF5C00';
                input.style.background = '#fff9f5';
            });
            
            input.addEventListener('drop', (e) => {
                e.preventDefault();
                const files = e.dataTransfer.files;
                const fileInput = input.querySelector('input[type="file"]');
                fileInput.files = files;
                
                input.style.borderColor = '#FF5C00';
                input.style.background = '#fff9f5';
                
                if (files.length > 0) {
                    const textDiv = input.querySelector('.file-input-text');
                    textDiv.innerHTML = `已选择: ${files[0].name}<br><small>点击上传按钮完成上传</small>`;
                }
            });
        });
    </script>
</body>
</html>