<?php
session_start();

// 检查是否已登录（根据你的登录系统调整）
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// 处理添加年份
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_year'])) {
    $newYear = trim($_POST['new_year']);
    $title = trim($_POST['new_title']);
    $description1 = trim($_POST['new_description1']);
    $description2 = trim($_POST['new_description2']);
    
    if (!empty($newYear) && !empty($title) && is_numeric($newYear)) {
        if (!isset($config[$newYear])) {
            $newData = [
                'title' => $title,
                'description1' => $description1,
                'description2' => $description2,
                'image' => '',
                'created' => date('Y-m-d H:i:s')
            ];
            
            if (addTimelineYear($newYear, $newData)) {
                $success = "年份 {$newYear} 添加成功！";
                // 重新读取配置
                $config = [];
                if (file_exists('timeline_config.json')) {
                    $config = json_decode(file_get_contents('timeline_config.json'), true) ?: [];
                }
                // 合并默认数据
                foreach ($defaultTimeline as $year => $data) {
                    if (!isset($config[$year])) {
                        $config[$year] = $data;
                    } else {
                        $config[$year] = array_merge($data, $config[$year]);
                    }
                }
                // 按年份排序
                uksort($config, function($a, $b) {
                    return (int)$a - (int)$b;
                });
            } else {
                $error = "添加年份失败！";
            }
        } else {
            $error = "年份 {$newYear} 已存在！";
        }
    } else {
        $error = "请填写有效的年份和标题！";
    }
}

// 处理删除年份
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_year'])) {
    $deleteYear = $_POST['delete_year'];
    
    // 防止删除默认年份
    $protectedYears = ['2022', '2023', '2025'];
    if (in_array($deleteYear, $protectedYears)) {
        $error = "无法删除默认年份 {$deleteYear}！";
    } else {
        if (deleteTimelineYear($deleteYear)) {
            $success = "年份 {$deleteYear} 删除成功！";
            // 重新读取配置
            $config = [];
            if (file_exists('timeline_config.json')) {
                $config = json_decode(file_get_contents('timeline_config.json'), true) ?: [];
            }
            // 合并默认数据
            foreach ($defaultTimeline as $year => $data) {
                if (!isset($config[$year])) {
                    $config[$year] = $data;
                } else {
                    $config[$year] = array_merge($data, $config[$year]);
                }
            }
            // 按年份排序
            uksort($config, function($a, $b) {
                return (int)$a - (int)$b;
            });
        } else {
            $error = "删除年份失败！";
        }
    }
}

// 处理文件上传和文案修改
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'images/images/';
    $configFile = 'timeline_config.json';
    
    // 确保上传目录存在
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // 处理照片上传
    if (isset($_FILES['timeline_image']) && $_FILES['timeline_image']['error'] === UPLOAD_ERR_OK) {
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
            } else {
                $error = "照片上传失败！";
            }
        } else {
            $error = "不支持的文件类型！仅支持 JPG, PNG, WebP 格式";
        }
    }
    
    // 处理文案更新
    if (isset($_POST['update_content'])) {
        $year = $_POST['year'];
        $title = $_POST['title'];
        $description1 = $_POST['description1'];
        $description2 = $_POST['description2'];
        
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
}

// 读取当前配置
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

// 合并配置
foreach ($defaultTimeline as $year => $data) {
    if (!isset($config[$year])) {
        $config[$year] = $data;
    } else {
        // 保留现有配置，但补充缺失的字段
        $config[$year] = array_merge($data, $config[$year]);
    }
}
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
        
        .year-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
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
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn-secondary {
                margin-left: 0;
            }
        }

        .year-management {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            margin: 30px 0;
            border: 2px solid #e9ecef;
        }

        .management-section {
            background: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #FF5C00;
        }

        .management-section:last-child {
            margin-bottom: 0;
        }

        .management-section h3 {
            margin-bottom: 20px;
            color: #333;
            font-size: 1.3em;
        }

        .add-year-form, .delete-year-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 20px;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .year-management {
                padding: 20px;
            }
            
            .management-section {
                padding: 20px;
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
                
                <!-- 年份选择标签 -->
                <div class="year-tabs">
                    <?php 
                    $isFirst = true;
                    foreach ($config as $year => $data): 
                    ?>
                    <button class="year-tab <?php echo $isFirst ? 'active' : ''; ?>" onclick="showYear('<?php echo $year; ?>')"><?php echo $year; ?>年</button>
                    <?php 
                    $isFirst = false;
                    endforeach; 
                    ?>
                </div>

                <!-- 年份管理区域 -->
                <div class="year-management">
                    <div class="management-section">
                        <h3>➕ 添加新年份</h3>
                        <form method="post" class="add-year-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>年份</label>
                                    <input type="number" name="new_year" class="form-input" placeholder="如: 2024" min="1900" max="2100" required>
                                </div>
                                <div class="form-group">
                                    <label>标题</label>
                                    <input type="text" name="new_title" class="form-input" placeholder="输入年份标题..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>第一段描述</label>
                                <textarea name="new_description1" class="form-textarea" placeholder="输入第一段描述..." required></textarea>
                            </div>
                            <div class="form-group">
                                <label>第二段描述</label>
                                <textarea name="new_description2" class="form-textarea" placeholder="输入第二段描述..." required></textarea>
                            </div>
                            <button type="submit" name="add_year" class="btn">添加年份</button>
                        </form>
                    </div>
                    
                    <div class="management-section">
                        <h3>🗑️ 删除年份</h3>
                        <form method="post" class="delete-year-form">
                            <div class="form-group">
                                <label>选择要删除的年份</label>
                                <select name="delete_year" class="form-input" required>
                                    <option value="">选择年份...</option>
                                    <?php foreach ($config as $year => $data): ?>
                                        <?php if (!in_array($year, ['2022', '2023', '2025'])): // 防止删除默认年份 ?>
                                        <option value="<?php echo $year; ?>"><?php echo $year; ?>年</option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" name="delete_year" class="btn btn-danger" onclick="return confirm('确定要删除这个年份吗？此操作无法撤销！')">删除年份</button>
                        </form>
                    </div>
                </div>
                
                <?php foreach ($config as $year => $data): ?>
                <div class="timeline-content <?php echo $year == '2022' ? 'active' : ''; ?>" id="content-<?php echo $year; ?>">
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
                            </div>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <script>
        // 年份切换功能 - 支持动态年份
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
            const targetTab = document.querySelector(`[onclick="showYear('${year}')"]`);
            if (targetTab) {
                targetTab.classList.add('active');
            }
        }

        // 动态生成内容区域（在页面加载时调用）
        document.addEventListener('DOMContentLoaded', function() {
            // 如果没有找到对应的内容区域，动态创建
            <?php foreach ($config as $year => $data): ?>
            if (!document.getElementById('content-<?php echo $year; ?>')) {
                // 这里可以添加动态创建内容区域的逻辑
                console.log('Creating content area for year: <?php echo $year; ?>');
            }
            <?php endforeach; ?>
        });
        
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
</body>
</html>