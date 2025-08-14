<?php
session_start();

// 检查是否已登录（根据你的登录系统调整）
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// 处理添加新年份
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_year'])) {
    $newYear = $_POST['new_year'];
    $configFile = 'timeline_config.json';
    
    // 如果是AJAX请求，直接处理并返回JSON
    if (isset($_POST['ajax'])) {
        if (preg_match('/^\d{4}$/', $newYear) && $newYear >= 2020 && $newYear <= 2050) {
            $config = [];
            if (file_exists($configFile)) {
                $config = json_decode(file_get_contents($configFile), true) ?: [];
            }
            
            if (!isset($config[$newYear])) {
                $config[$newYear] = [
                    'title' => '请输入标题',
                    'description1' => '请输入第一段描述...',
                    'description2' => '请输入第二段描述...',
                    'image' => 'images/images/default-timeline.jpg',
                    'created' => date('Y-m-d H:i:s')
                ];
                
                // 按年份排序
                ksort($config);
                
                file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
                
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => "年份 {$newYear} 添加成功！",
                    'year' => $newYear,
                    'data' => $config[$newYear]
                ]);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => "年份 {$newYear} 已存在！"
                ]);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => "请输入有效的年份（2020-2050）！"
            ]);
            exit;
        }
    } else {
        // 非AJAX请求的原有逻辑
        if (preg_match('/^\d{4}$/', $newYear) && $newYear >= 2020 && $newYear <= 2050) {
            $config = [];
            if (file_exists($configFile)) {
                $config = json_decode(file_get_contents($configFile), true) ?: [];
            }
            
            if (!isset($config[$newYear])) {
                $config[$newYear] = [
                    'title' => '请输入标题',
                    'description1' => '请输入第一段描述...',
                    'description2' => '请输入第二段描述...',
                    'image' => 'images/images/default-timeline.jpg',
                    'created' => date('Y-m-d H:i:s')
                ];
                
                // 按年份排序
                ksort($config);
                
                file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
                $success = "年份 {$newYear} 添加成功！";
            } else {
                $error = "年份 {$newYear} 已存在！";
            }
        } else {
            $error = "请输入有效的年份（2020-2050）！";
        }
    }
}

// 处理删除年份
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_year'])) {
    $yearToDelete = $_POST['year_to_delete'];
    $configFile = 'timeline_config.json';
    
    // 如果是AJAX请求，直接处理并返回JSON
    if (isset($_POST['ajax'])) {
        if (file_exists($configFile)) {
            $config = json_decode(file_get_contents($configFile), true) ?: [];
            
            if (isset($config[$yearToDelete])) {
                // 删除对应的图片文件
                if (isset($config[$yearToDelete]['image']) && 
                    $config[$yearToDelete]['image'] !== 'images/images/default-timeline.jpg' && 
                    file_exists($config[$yearToDelete]['image'])) {
                    unlink($config[$yearToDelete]['image']);
                }
                
                unset($config[$yearToDelete]);
                file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
                
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => "年份 {$yearToDelete} 删除成功！",
                    'year' => $yearToDelete
                ]);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => "年份 {$yearToDelete} 不存在！"
                ]);
                exit;
            }
        }
    } else {
        // 非AJAX请求的原有逻辑
        if (file_exists($configFile)) {
            $config = json_decode(file_get_contents($configFile), true) ?: [];
            
            if (isset($config[$yearToDelete])) {
                // 删除对应的图片文件
                if (isset($config[$yearToDelete]['image']) && 
                    $config[$yearToDelete]['image'] !== 'images/images/default-timeline.jpg' && 
                    file_exists($config[$yearToDelete]['image'])) {
                    unlink($config[$yearToDelete]['image']);
                }
                
                unset($config[$yearToDelete]);
                file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
                $success = "年份 {$yearToDelete} 删除成功！";
            } else {
                $error = "年份 {$yearToDelete} 不存在！";
            }
        }
    }
}

// 处理文件上传和文案修改
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['timeline_image'])) {
    $uploadDir = 'images/images/';
    $configFile = 'timeline_config.json';
    
    // 确保上传目录存在
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $file = $_FILES['timeline_image'];
    $year = $_POST['year'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    // 允许的文件类型
    $allowedImage = ['jpg', 'jpeg', 'png', 'webp'];
    
    if (in_array($fileExtension, $allowedImage)) {
        // 生成新文件名
        $newFileName = $year . '发展.' . $fileExtension;
        $targetPath = $uploadDir . $newFileName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // 更新配置文件
            $config = [];
            if (file_exists($configFile)) {
                $config = json_decode(file_get_contents($configFile), true) ?: [];
            }
            
            if (!isset($config[$year])) {
                $config[$year] = [];
            }
            
            $config[$year]['image'] = $targetPath;
            $config[$year]['updated'] = date('Y-m-d H:i:s');
            
            file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
            $success = "照片上传成功！";

            // 添加页面重定向，清除缓存
            echo "<script>
                setTimeout(function() {
                    window.location.href = window.location.href + '?updated=' + Date.now();
                }, 2000);
            </script>";
        } else {
            $error = "照片上传失败！";
        }
    } else {
        $error = "不支持的文件类型！仅支持 JPG, PNG, WebP 格式";
    }
}

// 处理文案更新
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_content'])) {
    $year = $_POST['year'];
    $title = $_POST['title'];
    $description1 = $_POST['description1'];
    $description2 = $_POST['description2'];
    $configFile = 'timeline_config.json';
    
    // 更新配置文件
    $config = [];
    if (file_exists($configFile)) {
        $config = json_decode(file_get_contents($configFile), true) ?: [];
    }
    
    if (!isset($config[$year])) {
        $config[$year] = [];
    }
    
    $config[$year]['title'] = $title;
    $config[$year]['description1'] = $description1;
    $config[$year]['description2'] = $description2;
    $config[$year]['updated'] = date('Y-m-d H:i:s');
    
    file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
    $success = "文案更新成功！";
}

// 读取当前配置并按年份排序
$config = [];
if (file_exists('timeline_config.json')) {
    $config = json_decode(file_get_contents('timeline_config.json'), true) ?: [];
}

// 默认时间线数据
$defaultTimeline = [
    '2022' => [
        'title' => '一味入魂，情暖人间 ✨',
        'description1' => '在人生的餐桌上，总有一些味道能够唤醒记忆，一些瞬间能够触动心弦。Tokyo Japanese Cuisine，这个名字不仅仅代表着精致的日式料理，更承载着一份对美食与服务的深情承诺。',
        'description2' => '我们的故事，始于 2022 年，那一年，我们怀揣着一个简单而又宏大的梦想：以热情的服务，让每一位走进Tokyo Japanese Cuisine的顾客，都能享受一场愉悦而难忘的用餐体验。',
        'image' => 'images/images/2022发展.jpg'
    ],
    '2023' => [
        'title' => '用心铸就，梦想生长 🌱',
        'description1' => 'Kunzz Holdings Sdn Bhd，一个承载着梦想与温度的名字，犹如一棵在希望沃土上扎根的幼苗，于 2023 年破土而出。我们不仅仅是一家肩负使命的控股公司，更是旗下每一家子公司最坚实的后盾与最真挚的引路人。',
        'description2' => '我们深信，唯有用心管理，倾力推广，才能让每一个独特的创意与梦想，在时代的舞台上绽放出最璀璨的光芒，成为改变世界的力量。',
        'image' => 'images/images/2023的发展.jpg'
    ],
    '2025' => [
        'title' => '规范管理，稳健前行 🚀',
        'description1' => '2025年，我们迎来了规范化管理的新纪元。通过建立完善的管理体系和标准化流程，我们不断提升运营效率，确保每一个项目都能在规范的轨道上稳健发展。',
        'description2' => '我们始终坚持以客户为中心，以质量为生命，用专业的态度和创新的思维，为客户创造更大价值，为行业树立新的标杆。',
        'image' => 'images/images/2025的发展.jpg'
    ]
];

// 合并配置，如果没有自定义配置则使用默认配置
foreach ($defaultTimeline as $year => $data) {
    if (!isset($config[$year])) {
        $config[$year] = $data;
    } else {
        // 保留现有配置，但补充缺失的字段
        $config[$year] = array_merge($data, $config[$year]);
    }
}

// 按年份排序
ksort($config);
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>发展历史管理 - KUNZZ HOLDINGS</title>
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
        
        .timeline-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            border-left: 5px solid #FF5C00;
        }
        
        .timeline-section h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.8em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .year-management {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            border: 1px solid #dee2e6;
        }
        
        .add-year-form h3,
        .delete-year-form h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.2em;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }
        
        .btn-danger:hover {
            background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }
        
        .year-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .year-tab {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        
        .year-tab.active {
            background: #FF5C00;
        }
        
        .year-tab:hover {
            transform: translateY(-2px);
        }
        
        .timeline-content {
            display: none;
        }
        
        .timeline-content.active {
            display: block;
        }
        
        .upload-form {
            display: grid;
            gap: 20px;
            margin-bottom: 30px;
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
        
        .file-input {
            border: 2px dashed #FF5C00;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            background: #fff9f5;
            transition: all 0.3s ease;
            cursor: pointer;
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
            font-size: 1.1em;
            font-weight: 500;
        }
        
        .current-file {
            margin-top: 15px;
            padding: 15px;
            background: #e8f4f8;
            border-radius: 8px;
            border-left: 4px solid #FF5C00;
        }
        
        .current-file strong {
            color: #155724;
        }
        
        .preview-container {
            margin-top: 20px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .preview-image {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
        }
        
        .content-form {
            background: white;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #dee2e6;
            margin-top: 20px;
        }
        
        .content-form h3 {
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #FF5C00;
        }
        
        .form-input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #FF5C00;
        }
        
        .form-textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            font-size: 1em;
            min-height: 100px;
            resize: vertical;
            font-family: inherit;
            transition: border-color 0.3s ease;
        }
        
        .form-textarea:focus {
            outline: none;
            border-color: #FF5C00;
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
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 92, 0, 0.3);
        }
        
        .btn-secondary {
            background: #6c757d;
            margin-left: 10px;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
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
        
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        @media (max-width: 768px) {
            .content {
                padding: 20px;
            }
            
            .timeline-section {
                padding: 20px;
            }
            
            .year-tabs {
                flex-wrap: wrap;
            }
            
            .year-management {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn-secondary {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>发展历史管理</h1>
            <p>管理关于我们页面的时间线照片和文案内容</p>
        </div>
        
        <div class="breadcrumb">
            <a href="dashboard.php">仪表板</a> > 
            <a href="media_manager.php">媒体管理</a> > 
            <span>发展历史管理</span>
        </div>
        
        <div class="content">
            <a href="media_manager.php" class="back-btn">← 返回媒体管理</a>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="timeline-section">
                <h2>📅 时间线内容管理</h2>
                
                <!-- 年份管理区域 -->
                <div class="year-management">
                    <div class="add-year-form">
                        <h3>➕ 添加新年份</h3>
                        <form id="addYearForm" method="post" style="display: flex; gap: 10px; align-items: end;">
                            <div class="form-group" style="flex: 1;">
                                <label>年份</label>
                                <input type="number" id="newYearInput" name="new_year" class="form-input" 
                                    min="2020" max="2050" placeholder="例: 2024" required>
                            </div>
                            <button type="submit" name="add_year" class="btn">添加年份</button>
                        </form>
                    </div>
                    
                    <div class="delete-year-form">
                        <h3>🗑️ 删除年份</h3>
                        <form method="post" style="display: flex; gap: 10px; align-items: end;">
                            <div class="form-group" style="flex: 1;">
                                <label>选择要删除的年份</label>
                                <select name="year_to_delete" class="form-input" required>
                                    <option value="">请选择...</option>
                                    <?php foreach (array_keys($config) as $year): ?>
                                        <option value="<?php echo $year; ?>"><?php echo $year; ?>年</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" name="delete_year" class="btn btn-danger" 
                                    onclick="return confirm('确定要删除这个年份吗？此操作不可恢复！')">删除年份</button>
                        </form>
                    </div>
                </div>
                
                <!-- 年份选择标签 -->
                <div class="year-tabs">
                    <?php $firstYear = true; foreach ($config as $year => $data): ?>
                        <button class="year-tab <?php echo $firstYear ? 'active' : ''; ?>" 
                                onclick="showYear('<?php echo $year; ?>')"><?php echo $year; ?>年</button>
                    <?php $firstYear = false; endforeach; ?>
                </div>
                
                <?php $firstYear = true; foreach ($config as $year => $data): ?>
                <div class="timeline-content <?php echo $firstYear ? 'active' : ''; ?>" id="content-<?php echo $year; ?>">
                    <!-- 照片上传表单 -->
                    <form method="post" enctype="multipart/form-data" class="upload-form">
                        <input type="hidden" name="year" value="<?php echo $year; ?>">
                        
                        <div class="form-group">
                            <label>上传 <?php echo $year; ?> 年照片</label>
                            <div class="file-input" onclick="document.getElementById('image-<?php echo $year; ?>').click()">
                                <input type="file" id="image-<?php echo $year; ?>" name="timeline_image" accept="image/*">
                                <div class="file-input-text">
                                    点击选择照片或拖拽到此处<br>
                                    <small>支持 JPG, PNG, WebP 格式，建议尺寸 800x600</small>
                                </div>
                            </div>
                            
                            <?php if (isset($data['image']) && file_exists($data['image'])): ?>
                                <div class="current-file">
                                    <strong>当前照片:</strong> <?php echo basename($data['image']); ?><br>
                                    <small>更新时间: <?php echo $data['updated'] ?? '未知'; ?></small>
                                    
                                    <div class="preview-container">
                                        <img class="preview-image" src="<?php echo $data['image']; ?>?v=<?php echo time(); ?>" alt="<?php echo $year; ?>年照片">
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <button type="submit" class="btn">上传照片</button>
                    </form>
                    
                    <!-- 文案编辑表单 -->
                    <div class="content-form">
                        <h3>📝 编辑 <?php echo $year; ?> 年文案内容</h3>
                        <form method="post">
                            <input type="hidden" name="year" value="<?php echo $year; ?>">
                            <input type="hidden" name="update_content" value="1">
                            
                            <div class="form-group">
                                <label>标题</label>
                                <input type="text" name="title" class="form-input" 
                                       value="<?php echo htmlspecialchars($data['title'] ?? ''); ?>" 
                                       placeholder="输入标题...">
                            </div>
                            
                            <div class="form-group">
                                <label>第一段描述</label>
                                <textarea name="description1" class="form-textarea" 
                                          placeholder="输入第一段描述..."><?php echo htmlspecialchars($data['description1'] ?? ''); ?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>第二段描述</label>
                                <textarea name="description2" class="form-textarea" 
                                          placeholder="输入第二段描述..."><?php echo htmlspecialchars($data['description2'] ?? ''); ?></textarea>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn">保存文案</button>
                                <button type="button" class="btn btn-secondary" onclick="resetForm('<?php echo $year; ?>')">重置</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php $firstYear = false; endforeach; ?>
            </div>
        </div>
    </div>
    
    <script>
        // 年份切换功能（动态生成）
        function showYear(year) {
            // 隐藏所有内容
            document.querySelectorAll('.timeline-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // 移除所有标签的active状态
            document.querySelectorAll('.year-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // 显示选中年份的内容
            const targetContent = document.getElementById('content-' + year);
            if (targetContent) {
                targetContent.classList.add('active');
            }
            
            // 激活选中的标签
            event.target.classList.add('active');
        }
        
        // 重置表单
        function resetForm(year) {
            const form = document.querySelector(`#content-${year} .content-form form`);
            if (confirm('确定要重置表单吗？所有未保存的更改将丢失。')) {
                form.reset();
            }
        }
        
        // 文件拖拽和选择功能
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
        
        // 表单验证
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
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
                    alert('请填写所有必填字段');
                }
            });
        });
    </script>
    <script>
// AJAX添加年份功能
document.getElementById('addYearForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('add_year', '1');
    formData.append('new_year', document.getElementById('newYearInput').value);
    formData.append('ajax', '1');
    
    fetch('', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 显示成功消息
            showAlert(data.message, 'success');
            
            // 清空输入框
            document.getElementById('newYearInput').value = '';
            
            // 添加新的年份标签
            addYearTab(data.year);
            
            // 添加新的内容区域
            addYearContent(data.year, data.data);
            
            // 更新删除下拉列表
            updateDeleteOptions(data.year);
        }
    })
    .then(response => response.text())
    .then(text => {
        console.log('服务器返回:', text); // 调试用
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error('JSON解析失败:', text);
            throw new Error('服务器响应格式错误');
        }
    })
    .then(data => {
        if (data.success) {
            // 显示成功消息
            showAlert(data.message, 'success');
            
            // 清空输入框
            document.getElementById('newYearInput').value = '';
            
            // 添加新的年份标签
            addYearTab(data.year);
            
            // 添加新的内容区域
            addYearContent(data.year, data.data);
            
            // 更新删除下拉列表
            updateDeleteOptions(data.year);
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('错误详情:', error);
        showAlert('添加失败：请检查网络连接', 'error');
    });
});

// 显示提示消息
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    
    const content = document.querySelector('.content');
    content.insertBefore(alertDiv, content.firstChild);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}

// 添加年份标签
function addYearTab(year) {
    const yearTabs = document.querySelector('.year-tabs');
    const newTab = document.createElement('button');
    newTab.className = 'year-tab';
    newTab.textContent = year + '年';
    newTab.onclick = function() { showYear(year); };
    yearTabs.appendChild(newTab);
    localStorage.setItem('timeline_updated', Date.now().toString());
}

// 添加年份内容区域
function addYearContent(year, data) {
    const timelineSection = document.querySelector('.timeline-section');
    const newContent = document.createElement('div');
    newContent.className = 'timeline-content';
    newContent.id = 'content-' + year;
    newContent.innerHTML = `
        <!-- 照片上传表单 -->
        <form method="post" enctype="multipart/form-data" class="upload-form">
            <input type="hidden" name="year" value="${year}">
            
            <div class="form-group">
                <label>上传 ${year} 年照片</label>
                <div class="file-input" onclick="document.getElementById('image-${year}').click()">
                    <input type="file" id="image-${year}" name="timeline_image" accept="image/*">
                    <div class="file-input-text">
                        点击选择照片或拖拽到此处<br>
                        <small>支持 JPG, PNG, WebP 格式，建议尺寸 800x600</small>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn">上传照片</button>
        </form>
        
        <!-- 文案编辑表单 -->
        <div class="content-form">
            <h3>📝 编辑 ${year} 年文案内容</h3>
            <form method="post">
                <input type="hidden" name="year" value="${year}">
                <input type="hidden" name="update_content" value="1">
                
                <div class="form-group">
                    <label>标题</label>
                    <input type="text" name="title" class="form-input" 
                           value="${data.title || ''}" placeholder="输入标题...">
                </div>
                
                <div class="form-group">
                    <label>第一段描述</label>
                    <textarea name="description1" class="form-textarea" 
                              placeholder="输入第一段描述...">${data.description1 || ''}</textarea>
                </div>
                
                <div class="form-group">
                    <label>第二段描述</label>
                    <textarea name="description2" class="form-textarea" 
                              placeholder="输入第二段描述...">${data.description2 || ''}</textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn">保存文案</button>
                    <button type="button" class="btn btn-secondary" onclick="resetForm('${year}')">重置</button>
                </div>
            </form>
        </div>
    `;
    
    // 添加这两行来创建对应的卡片
    addTimelineCard(year, data);
    
    // 通知about.php页面刷新时间线数据（如果在同一窗口）
    if (window.parent && window.parent.refreshTimelineData) {
        window.parent.refreshTimelineData();
    }
}

// 添加新的时间线卡片函数
function addTimelineCard(year, data) {
    // 这个函数用于在about.php中添加新卡片
    // 由于管理页面和显示页面是分开的，这里主要是为了保持一致性
    console.log('添加时间线卡片:', year, data);
}

// 更新删除下拉列表
function updateDeleteOptions(year) {
    const deleteSelect = document.querySelector('select[name="year_to_delete"]');
    const newOption = document.createElement('option');
    newOption.value = year;
    newOption.textContent = year + '年';
    deleteSelect.appendChild(newOption);
}
</script>
</body>
</html>