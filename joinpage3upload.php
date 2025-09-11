<?php
session_start();

// 检查是否已登录（根据你的登录系统调整）
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// 数据库配置
$host = 'localhost';
$dbname = 'u857194726_kunzzgroup';
$dbuser = 'u857194726_kunzzgroup';
$dbpass = 'Kholdings1688@';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("数据库连接失败：" . $e->getMessage());
}

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    
    if ($action === 'add') {
        // 添加职位
        try {
            $stmt = $pdo->prepare("
                INSERT INTO job_positions 
                (job_title, work_experience, recruitment_count, publish_date, company_category, job_description, company_location) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            
            $result = $stmt->execute([
                trim($_POST['job_title']),
                trim($_POST['job_experience']),
                trim($_POST['job_count']),
                $_POST['publish_date'],
                $_POST['job_category'],
                trim($_POST['job_description']),
                $_POST['company_location'] ?? ''
            ]);
            
            if ($result) {
                $success = "职位添加成功！";
            } else {
                $error = "职位添加失败！";
            }
        } catch (PDOException $e) {
            $error = "添加职位失败：" . $e->getMessage();
        }
        
    } elseif ($action === 'edit') {
        // 编辑职位
        try {
            $stmt = $pdo->prepare("
                UPDATE job_positions 
                SET job_title = ?, work_experience = ?, recruitment_count = ?, publish_date = ?, 
                    company_category = ?, job_description = ?, company_location = ?
                WHERE id = ?
            ");
            
            $result = $stmt->execute([
                trim($_POST['job_title']),
                trim($_POST['job_experience']),
                trim($_POST['job_count']),
                $_POST['publish_date'],
                $_POST['job_category'],
                trim($_POST['job_description']),
                $_POST['company_location'] ?? '',
                $_POST['job_id']
            ]);
            
            if ($result) {
                $success = "职位更新成功！";
            } else {
                $error = "职位更新失败！";
            }
        } catch (PDOException $e) {
            $error = "更新职位失败：" . $e->getMessage();
        }
        
    } elseif ($action === 'delete') {
        // 删除职位
        try {
            $stmt = $pdo->prepare("DELETE FROM job_positions WHERE id = ?");
            $result = $stmt->execute([$_POST['job_id']]);
            
            if ($result) {
                $success = "职位删除成功！";
            } else {
                $error = "职位删除失败！";
            }
        } catch (PDOException $e) {
            $error = "删除职位失败：" . $e->getMessage();
        }
    }
}

// 读取现有职位
try {
    $stmt = $pdo->prepare("SELECT * FROM job_positions ORDER BY publish_date DESC, id DESC");
    $stmt->execute();
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $jobs = [];
    $error = "读取职位数据失败：" . $e->getMessage();
}

// 处理编辑请求
$editJob = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    foreach ($jobs as $job) {
        if ($job['id'] == $editId) {
            $editJob = $job;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <link rel="icon" type="image/png" href="images/images/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>招聘职位管理 - KUNZZ HOLDINGS</title>
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
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
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
            margin-bottom: 25px;
            font-size: 1.8em;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        
        .form-group label {
            font-weight: 600;
            color: #555;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #FF5C00;
            box-shadow: 0 0 0 3px rgba(255, 92, 0, 0.1);
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 120px;
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
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .btn-danger {
            background: #dc3545;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .btn-small {
            padding: 8px 16px;
            font-size: 0.9em;
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
        
        .jobs-list {
            background: white;
            border-radius: 10px;
            padding: 30px;
            border-left: 5px solid #FF5C00;
        }
        
        .jobs-list h2 {
            color: #333;
            margin-bottom: 25px;
            font-size: 1.8em;
        }
        
        .job-item {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .job-item:hover {
            border-color: #FF5C00;
            box-shadow: 0 5px 15px rgba(255, 92, 0, 0.1);
        }
        
        .job-header-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        
        .job-title-item {
            font-size: 1.3em;
            font-weight: 700;
            color: #FF5C00;
            margin-bottom: 10px;
        }
        
        .job-meta-list {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }
        
        .job-meta-item-list {
            font-size: 0.9em;
            color: #666;
        }
        
        .job-actions {
            display: flex;
            gap: 10px;
        }
        
        .job-description-preview {
            color: #555;
            line-height: 1.6;
            max-height: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
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
        
        .form-buttons {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .content {
                padding: 20px;
            }
            
            .job-header-item {
                flex-direction: column;
                gap: 15px;
            }
            
            .job-meta-list {
                flex-direction: column;
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>招聘职位管理</h1>
            <p>管理加入我们页面的招聘职位信息</p>
        </div>
        
        <div class="breadcrumb">
            <a href="dashboard.php">仪表板</a> > 
            <a href="media_manager.php">媒体管理</a> > 
            <span>招聘职位管理</span>
        </div>
        
        <div class="content">
            <a href="media_manager.php" class="back-btn">← 返回媒体管理</a>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <!-- 添加/编辑职位表单 -->
            <div class="form-section">
                <h2><?php echo $editJob ? '编辑职位' : '添加新职位'; ?></h2>
                <form method="post">
                    <input type="hidden" name="action" value="<?php echo $editJob ? 'edit' : 'add'; ?>">
                    <?php if ($editJob): ?>
                        <input type="hidden" name="job_id" value="<?php echo $editJob['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="job_title">职位名称 *</label>
                            <input type="text" id="job_title" name="job_title" 
                                   value="<?php echo $editJob ? htmlspecialchars($editJob['job_title']) : ''; ?>" 
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label for="job_count">招聘人数 *</label>
                            <input type="text" id="job_count" name="job_count" 
                                   value="<?php echo $editJob ? htmlspecialchars($editJob['recruitment_count']) : ''; ?>" 
                                   placeholder="例如：1人" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="job_experience">工作经验要求 *</label>
                            <input type="text" id="job_experience" name="job_experience" 
                                   value="<?php echo $editJob ? htmlspecialchars($editJob['work_experience']) : ''; ?>" 
                                   placeholder="例如：3" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="publish_date">发布日期 *</label>
                            <input type="date" id="publish_date" name="publish_date" 
                                   value="<?php echo $editJob ? $editJob['publish_date'] : date('Y-m-d'); ?>" 
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label for="job_category">公司分类 *</label>
                            <select id="job_category" name="job_category" required>
                                <option value="">请选择公司</option>
                                <option value="KUNZZHOLDINGS" <?php echo ($editJob && $editJob['company_category'] === 'KUNZZHOLDINGS') ? 'selected' : ''; ?>>KUNZZHOLDINGS</option>
                                <option value="TOKYO CUISINE" <?php echo ($editJob && $editJob['company_category'] === 'TOKYO CUISINE') ? 'selected' : ''; ?>>TOKYO CUISINE</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="company_location">公司地址</label>
                            <input type="text" id="company_location" name="company_location" 
                                   value="<?php echo $editJob ? htmlspecialchars($editJob['company_location']) : ''; ?>" 
                                   placeholder="例如：25, Jln Tanjong 3, Taman Desa Cemerlang, 81800 Ulu Tiram, Johor">
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="job_description">职位详情 *</label>
                            <textarea id="job_description" name="job_description" 
                                      placeholder="请输入详细的职位描述..." required><?php echo $editJob ? htmlspecialchars($editJob['job_description']) : ''; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-buttons">
                        <button type="submit" class="btn">
                            <?php echo $editJob ? '更新职位' : '添加职位'; ?>
                        </button>
                        <?php if ($editJob): ?>
                            <a href="joinpage3upload.php" class="btn btn-secondary">取消编辑</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            
            <!-- 现有职位列表 -->
            <div class="jobs-list">
                <h2>现有职位列表 (<?php echo count($jobs); ?>)</h2>
                
                <?php if (empty($jobs)): ?>
                    <p style="text-align: center; color: #999; padding: 40px;">暂无职位信息</p>
                <?php else: ?>
                    <?php foreach ($jobs as $job): ?>
                        <div class="job-item">
                            <div class="job-header-item">
                                <div>
                                    <div class="job-title-item"><?php echo htmlspecialchars($job['job_title']); ?></div>
                                    <div class="job-meta-list">
                                        <span class="job-meta-item-list">👥 人数: <?php echo htmlspecialchars($job['recruitment_count']); ?></span>
                                        <span class="job-meta-item-list">💼 经验: <?php echo htmlspecialchars($job['work_experience']); ?></span>
                                        <span class="job-meta-item-list">📅 发布: <?php echo $job['publish_date']; ?></span>
                                        <span class="job-meta-item-list">🏷️ 公司: <?php echo htmlspecialchars($job['company_category'] ?? '未分类'); ?></span>
                                        <?php if (!empty($job['company_location'])): ?>
                                        <span class="job-meta-item-list">📍 地址: <?php echo htmlspecialchars($job['company_location']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="job-description-preview">
                                        <strong>职位详情：</strong><?php echo htmlspecialchars($job['job_description']); ?>
                                    </div>
                                </div>
                                <div class="job-actions">
                                    <a href="?edit=<?php echo $job['id']; ?>" class="btn btn-small">编辑</a>
                                    <form method="post" style="display: inline-block;" 
                                          onsubmit="return confirm('确定要删除这个职位吗？')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-small">删除</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>