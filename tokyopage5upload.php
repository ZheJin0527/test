<?php
session_start();
include_once 'media_config.php';

// 检查是否已登录（根据你的登录系统调整）
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// 处理删除店铺
if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['store_key'])) {
    $currentConfig = getTokyoLocationConfig();
    unset($currentConfig[$_POST['store_key']]);
    if (saveTokyoLocationConfig($currentConfig)) {
        $success = "店铺信息删除成功！";
    } else {
        $error = "删除失败，请重试！";
    }
}

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!isset($_POST['action']) || $_POST['action'] !== 'delete')) {
    $config = [];
    
    // 获取当前配置以保持order
    $currentConfig = getTokyoLocationConfig();

    // 添加标题处理
    if (isset($_POST['section_title'])) {
        $config['section_title'] = trim($_POST['section_title']);
    }
    
    // 处理所有店铺（包括新添加的）
    foreach ($_POST as $key => $value) {
        if (strpos($key, '_label') !== false) {
            $storeKey = str_replace('_label', '', $key);
            
            // 检查是否所有相关字段都存在
            $label = trim($value);
            $address = isset($_POST[$storeKey . '_address']) ? trim($_POST[$storeKey . '_address']) : '';
            $phone = isset($_POST[$storeKey . '_phone']) ? trim($_POST[$storeKey . '_phone']) : '';
            $map_url = isset($_POST[$storeKey . '_map_url']) ? trim($_POST[$storeKey . '_map_url']) : '';
            
            // 如果至少有标签或地址，就保存这个店铺
            if (!empty($label) || !empty($address)) {
                // 保持原有的order值（如果存在），否则分配新的order
                $order = isset($currentConfig[$storeKey]['order']) ? $currentConfig[$storeKey]['order'] : (count($config) + 1);
                
                $config[$storeKey] = [
                    'label' => $label,
                    'address' => $address,
                    'phone' => $phone,
                    'map_url' => $map_url,
                    'order' => $order,
                    'updated' => date('Y-m-d H:i:s')
                ];
            }
        }
    }
    
    // 确保至少保留标题
    if (empty($config) || (!isset($config['section_title']) && count($config) == 0)) {
        $config['section_title'] = '我们在这';
    }
    
    try {
        if (saveTokyoLocationConfig($config)) {
            $success = "位置信息更新成功！";
            // 重定向避免重复提交
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1&updated=" . time());
            exit();
        } else {
            $error = "更新失败，请重试！";
        }
    } catch (Exception $e) {
        $error = "保存过程中发生错误：" . $e->getMessage();
    }
}

// 处理成功消息显示
if (isset($_GET['success']) && $_GET['success'] == '1') {
    $success = "位置信息更新成功！";
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
        
        .btn-secondary {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            margin-left: 10px;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
            padding: 8px 16px;
            font-size: 0.9em;
            margin-left: 10px;
        }
        
        .btn-add {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
            position: relative;
        }
        
        .store-section.new-store {
            border-color: #17a2b8;
            background: #f8fdfe;
        }
        
        .store-section h3 {
            color: #FF5C00;
            margin-bottom: 20px;
            font-size: 1.4em;
            border-bottom: 2px solid #FF5C00;
            padding-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .help-text {
            font-size: 0.9em;
            color: #6c757d;
            margin-top: 5px;
            font-style: italic;
        }
        
        .section-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .store-counter {
            background: #FF5C00;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: bold;
        }
        
        .dynamic-stores {
            margin-top: 20px;
        }
        
        .store-template {
            display: none;
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
            
            .section-actions {
                flex-direction: column;
                gap: 5px;
            }
            
            .btn-danger {
                margin-left: 0;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Tokyo 位置信息管理</h1>
            <p>管理 Tokyo Japanese Cuisine 所有店铺信息</p>
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
            
            <form method="post" id="mainForm" class="form-section">
                <h2>📍 编辑位置信息</h2>
                
                <!-- 标题编辑区域 -->
                <div class="store-section">
                    <h3>节标题设置</h3>
                    <div class="form-group">
                        <label for="section_title">标题文字</label>
                        <input type="text" id="section_title" name="section_title" class="form-input" 
                            value="<?php echo htmlspecialchars($currentConfig['section_title'] ?? '我们在这'); ?>" required>
                        <div class="help-text">显示在位置信息顶部的标题</div>
                    </div>
                </div>
                
                <button type="button" class="btn btn-add" onclick="addNewStore()">
                    ➕ 添加新店铺
                </button>
                
                <div id="storesContainer">
                    <?php foreach ($currentConfig as $storeKey => $storeData): ?>
                        <?php if ($storeKey === 'section_title') continue; // 跳过标题配置 ?>
                        <div class="store-section" data-store-key="<?php echo $storeKey; ?>">
                            <!-- 店铺编辑内容保持不变 -->
                            <h3>
                                <span>
                                    <?php 
                                    // 获取所有非标题的店铺键名
                                    $storeKeys = array_filter(array_keys($currentConfig), function($key) { 
                                        return $key !== 'section_title'; 
                                    });
                                    // 重新索引数组，从0开始
                                    $storeKeys = array_values($storeKeys);
                                    // 找到当前店铺的位置并+1
                                    echo array_search($storeKey, $storeKeys) + 1;
                                    ?>
                                </span>
                                <div class="section-actions">
                                    <?php if (!in_array($storeKey, ['main_store', 'branch_store'])): ?>
                                    <button type="button" class="btn btn-danger" onclick="deleteStore('<?php echo $storeKey; ?>')">
                                        🗑️ 删除
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </h3>
                            <!-- 其余店铺表单字段保持不变 -->
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="<?php echo $storeKey; ?>_label">标签文字</label>
                                    <input type="text" id="<?php echo $storeKey; ?>_label" name="<?php echo $storeKey; ?>_label" class="form-input" 
                                        value="<?php echo htmlspecialchars($storeData['label']); ?>">
                                    <div class="help-text">例如：总店：、分店：、三店：</div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="<?php echo $storeKey; ?>_address">地址</label>
                                    <textarea id="<?php echo $storeKey; ?>_address" name="<?php echo $storeKey; ?>_address" class="form-input textarea"><?php echo htmlspecialchars($storeData['address']); ?></textarea>
                                    <div class="help-text">请输入完整的店铺地址</div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="<?php echo $storeKey; ?>_phone">电话号码</label>
                                    <input type="text" id="<?php echo $storeKey; ?>_phone" name="<?php echo $storeKey; ?>_phone" class="form-input" 
                                        value="<?php echo htmlspecialchars($storeData['phone']); ?>">
                                    <div class="help-text">例如：+60 19-710 8090</div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="<?php echo $storeKey; ?>_map_url">地图链接</label>
                                    <input type="url" id="<?php echo $storeKey; ?>_map_url" name="<?php echo $storeKey; ?>_map_url" class="form-input" 
                                        value="<?php echo htmlspecialchars($storeData['map_url']); ?>">
                                    <div class="help-text">Google Maps 分享链接</div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <button type="submit" class="btn">保存所有更改</button>
            </form>
            
            <!-- 隐藏的店铺模板 -->
            <div class="store-template" id="storeTemplate">
                <div class="store-section new-store" data-store-key="">
                    <h3>
                        <span></span>
                        <div class="section-actions">
                            <button type="button" class="btn btn-danger" onclick="removeNewStore(this)">
                                🗑️ 移除
                            </button>
                        </div>
                    </h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>标签文字</label>
                            <input type="text" class="form-input" name="">
                            <div class="help-text">例如：三店：、四店：、旗舰店：</div>
                        </div>
                        
                        <div class="form-group">
                            <label>地址</label>
                            <textarea class="form-input textarea" name=""></textarea>
                            <div class="help-text">请输入完整的店铺地址</div>
                        </div>
                        
                        <div class="form-group">
                            <label>电话号码</label>
                            <input type="text" class="form-input" name="">
                            <div class="help-text">例如：+60 19-710 8090</div>
                        </div>
                        
                        <div class="form-group">
                            <label>地图链接</label>
                            <input type="url" class="form-input" name="">
                            <div class="help-text">Google Maps 分享链接</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 删除确认表单 -->
    <form id="deleteForm" method="post" style="display: none;">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="store_key" id="deleteStoreKey">
    </form>
    
    <script>
        let storeCounter = <?php echo count(array_filter($currentConfig, function($key) { return $key !== 'section_title'; }, ARRAY_FILTER_USE_KEY)); ?>;
        
        // 添加新店铺
        function addNewStore() {
            const template = document.getElementById('storeTemplate');
            const newStore = template.cloneNode(true);
            newStore.style.display = 'block';
            newStore.id = '';
            
            const storeKey = 'store_' + Date.now();
            const storeSection = newStore.querySelector('.store-section');
            storeSection.setAttribute('data-store-key', storeKey);
            
            // 先添加到容器
            document.getElementById('storesContainer').appendChild(storeSection);
            
            // 然后更新所有序号
            updateStoreCounters();
            
            // 更新表单字段名称
            const inputs = storeSection.querySelectorAll('input, textarea');
            const labels = storeSection.querySelectorAll('label');
            
            // 确保按正确顺序设置字段名
            if (inputs.length >= 4 && labels.length >= 4) {
                inputs[0].name = storeKey + '_label';
                inputs[0].id = storeKey + '_label';
                labels[0].setAttribute('for', storeKey + '_label');
                
                inputs[1].name = storeKey + '_address';
                inputs[1].id = storeKey + '_address';
                labels[1].setAttribute('for', storeKey + '_address');
                
                inputs[2].name = storeKey + '_phone';
                inputs[2].id = storeKey + '_phone';
                labels[2].setAttribute('for', storeKey + '_phone');
                
                inputs[3].name = storeKey + '_map_url';
                inputs[3].id = storeKey + '_map_url';
                labels[3].setAttribute('for', storeKey + '_map_url');
                
                // 为新字段添加默认提示
                inputs[0].placeholder = '例如：三店：';
                inputs[2].placeholder = '+60 19-710 8090';
                inputs[3].placeholder = 'https://maps.app.goo.gl/...';
                
                // 添加事件监听
                inputs.forEach(input => {
                    input.addEventListener('input', updatePreview);
                });
            }
            
            // 滚动到新添加的店铺
            storeSection.scrollIntoView({ behavior: 'smooth' });
        }
        
        // 移除新店铺（未保存的）
        function removeNewStore(button) {
            if (confirm('确定要移除这个新店铺吗？')) {
                button.closest('.store-section').remove();
                updateStoreCounters();
                updatePreview();
            }
        }
        
        // 删除已保存的店铺
        function deleteStore(storeKey) {
            if (confirm('确定要删除这个店铺吗？此操作不可撤销！')) {
                document.getElementById('deleteStoreKey').value = storeKey;
                document.getElementById('deleteForm').submit();
            }
        }
        
        // 更新店铺序号
        function updateStoreCounters() {
            const stores = document.querySelectorAll('.store-section[data-store-key]'); // 只选择有data-store-key的店铺
            stores.forEach((store, index) => {
                const titleSpan = store.querySelector('h3 span');
                if (titleSpan) {
                    titleSpan.textContent = index + 1; // 从1开始计数
                }
            });
            storeCounter = stores.length;
        }
        
        // 实时预览功能
        function updatePreview() {
        const previewContent = document.getElementById('previewContent');
        const stores = document.querySelectorAll('.store-section[data-store-key]'); // 只选择有data-store-key的店铺
        
        // 获取标题
        const sectionTitle = document.getElementById('section_title')?.value || '我们在这';
        let html = `<h2>${sectionTitle}</h2>`;
        
        stores.forEach(store => {
            const storeKey = store.getAttribute('data-store-key');
            const label = store.querySelector(`input[name="${storeKey}_label"]`)?.value || '';
            const address = store.querySelector(`textarea[name="${storeKey}_address"]`)?.value || '';
            const phone = store.querySelector(`input[name="${storeKey}_phone"]`)?.value || '';
            const mapUrl = store.querySelector(`input[name="${storeKey}_map_url"]`)?.value || '';
            
            if (label || address) {
                html += `<p>${label}<a href="${mapUrl}" target="_blank" class="no-style-link">${address}</a></p>`;
                html += `<p>电话：${phone}</p>`;
            }
        });
        
        previewContent.innerHTML = html;
    }
        
        // 为所有现有输入框添加实时预览
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('input', updatePreview);
        });

        // 表单验证 - 修改为更宽松的验证
        document.getElementById('mainForm').addEventListener('submit', function(e) {
            // 只验证标题是否填写
            const sectionTitle = document.getElementById('section_title');
            
            if (!sectionTitle.value.trim()) {
                e.preventDefault();
                alert('请至少填写标题文字！');
                sectionTitle.style.borderColor = '#dc3545';
                sectionTitle.scrollIntoView({ behavior: 'smooth' });
                sectionTitle.focus();
                return;
            }
            
            // 重置所有字段的边框颜色
            document.querySelectorAll('.form-input').forEach(field => {
                field.style.borderColor = '#e9ecef';
            });
            
            // 可选：检查是否至少有一个店铺有基本信息
            const stores = document.querySelectorAll('.store-section[data-store-key]');
            let hasValidStore = false;
            
            stores.forEach(store => {
                const storeKey = store.getAttribute('data-store-key');
                const label = store.querySelector(`input[name="${storeKey}_label"]`)?.value || '';
                const address = store.querySelector(`textarea[name="${storeKey}_address"]`)?.value || '';
                
                if (label.trim() || address.trim()) {
                    hasValidStore = true;
                }
            });
            
            // 如果没有任何店铺信息，给出警告但仍允许保存
            if (!hasValidStore) {
                const confirmSave = confirm('当前没有填写任何店铺信息，确定要保存吗？');
                if (!confirmSave) {
                    e.preventDefault();
                    return;
                }
            }
        });
        
        // 页面加载完成后更新计数器
        document.addEventListener('DOMContentLoaded', function() {
            updateStoreCounters();
        });
        
        // 为标题输入框添加实时预览
        document.getElementById('section_title').addEventListener('input', updatePreview);

        // 键盘快捷键
        document.addEventListener('keydown', function(e) {
            // Ctrl+N 添加新店铺
            if (e.ctrlKey && e.key === 'n') {
                e.preventDefault();
                addNewStore();
            }
            // Ctrl+S 保存
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                document.getElementById('mainForm').submit();
            }
            // Ctrl+P 预览
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                updatePreview();
            }
        });
    </script>
</body>
</html>