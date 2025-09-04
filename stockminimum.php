<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>库存阈值管理 - 中央系统</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #ff5c00;
            color: white;
            padding: 20px 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
        }

        .back-button {
            background-color: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-button:hover {
            background-color: rgba(255,255,255,0.3);
            color: white;
            text-decoration: none;
        }

        .alert {
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease;
        }

        .alert-success { background-color: #C8E6C9; color: #2E7D32; border: 1px solid #4CAF50; }
        .alert-error { background-color: #FFCDD2; color: #C62828; border: 1px solid #F44336; }
        .alert-info { background-color: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .alert-warning { background-color: #FFE0B2; color: #E65100; border: 1px solid #FF9800; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .control-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 2px solid #ff5c00;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            margin-bottom: 8px;
            font-weight: 600;
            color: #BF360C;
        }

        .filter-input, .filter-select {
            padding: 10px 15px;
            border: 2px solid #ff5c00;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .filter-input:focus, .filter-select:focus {
            outline: none;
            border-color: #ff5c00;
            box-shadow: 0 0 10px rgba(255, 115, 0, 0.8);
        }

        .filter-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary { 
            background-color: #FF9800; 
            color: white; 
        }
        .btn-primary:hover { 
            background-color: #E65100;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255,152,0,0.3);
        }

        .btn-secondary { background-color: #6b7280; color: white; }
        .btn-secondary:hover { background-color: #4b5563; }

        .btn-success { background-color: #4CAF50; color: white; }
        .btn-success:hover { background-color: #2E7D32; }

        .btn-warning { background-color: #FF9800; color: white; }
        .btn-warning:hover { background-color: #E65100; }

        .btn-danger { background-color: #F44336; color: white; }
        .btn-danger:hover { background-color: #C62828; }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 2px solid #ff5c00;
        }

        .table-header {
            background: #ff5c00;
            color: white;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h2 {
            font-size: 20px;
            font-weight: 600;
        }

        .stats-info {
            display: flex;
            gap: 20px;
            align-items: center;
            font-size: 14px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .stat-value {
            font-weight: 600;
            color: #FFE0B2;
        }

        .table-scroll-container {
            max-height: 600px;
            overflow-y: auto;
        }

        .threshold-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .threshold-table th {
            background-color: #fff9f1;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            color: black;
            border-bottom: 2px solid #ff5c00;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .threshold-table td {
            padding: 12px;
            border-bottom: 1px solid #d1d5db;
            vertical-align: middle;
        }

        .threshold-table tbody tr:hover {
            background-color: #fff9f1;
        }

        .text-center {
            text-align: center;
        }

        .text-danger {
            color: #C62828 !important;
            font-weight: 600;
        }

        .text-success {
            color: #2E7D32 !important;
            font-weight: 600;
        }

        .threshold-input {
            width: 100px;
            padding: 6px 10px;
            border: 1px solid #ff5c00;
            border-radius: 4px;
            font-size: 13px;
        }

        .threshold-input:focus {
            outline: none;
            border-color: #ff5c00;
            box-shadow: 0 0 5px rgba(255, 115, 0, 0.5);
        }

        .threshold-checkbox {
            transform: scale(1.2);
            cursor: pointer;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #FFE0B2;
            border-radius: 50%;
            border-top-color: #FF9800;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .no-data i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background-color: #eb8e02ff;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            box-shadow: 0 4px 12px rgba(88, 62, 4, 0.3);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            background-color: #d16003ff;
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(88, 62, 4, 0.4);
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .filter-grid {
                grid-template-columns: 1fr;
            }
            
            .filter-actions {
                flex-direction: column;
            }
            
            .header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            
            .stats-info {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-cogs"></i> 库存阈值管理</h1>
            <a href="stocklistall.php" class="back-button">
                <i class="fas fa-arrow-left"></i>
                返回库存列表
            </a>
        </div>
        
        <!-- 提示信息容器 -->
        <div id="alert-container"></div>
        
        <!-- 控制面板 -->
        <div class="control-section">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="search-input">搜索货品：</label>
                    <input type="text" id="search-input" class="filter-input" placeholder="输入货品名称或编号..." onkeyup="filterTable()">
                </div>
                <div class="filter-group">
                    <label for="stock-filter">库存状态：</label>
                    <select id="stock-filter" class="filter-select" onchange="filterTable()">
                        <option value="">全部货品</option>
                        <option value="low">库存不足</option>
                        <option value="sufficient">库存充足</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="batch-threshold">批量设置阈值：</label>
                    <input type="number" id="batch-threshold" class="filter-input" min="0" step="0.01" placeholder="输入阈值数量">
                </div>
            </div>
            
            <div class="filter-actions">
                <button class="btn btn-success" onclick="loadThresholdData()">
                    <i class="fas fa-sync-alt"></i>
                    刷新数据
                </button>
                <button class="btn btn-warning" onclick="applyBatchThreshold()">
                    <i class="fas fa-magic"></i>
                    批量应用阈值
                </button>
                <button class="btn btn-primary" onclick="saveAllChanges()">
                    <i class="fas fa-save"></i>
                    保存所有更改
                </button>
                <button class="btn btn-secondary" onclick="resetAllInputs()">
                    <i class="fas fa-undo"></i>
                    重置输入
                </button>
            </div>
        </div>
        
        <!-- 阈值管理表格 -->
        <div class="table-container">
            <div class="table-header">
                <h2>货品阈值设置</h2>
                <div class="stats-info">
                    <div class="stat-item">
                        <i class="fas fa-list"></i>
                        <span>显示货品: <span class="stat-value" id="displayed-count">0</span></span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>库存不足: <span class="stat-value" id="low-stock-count">0</span></span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-boxes"></i>
                        <span>总货品: <span class="stat-value" id="total-count">0</span></span>
                    </div>
                </div>
            </div>
            
            <div class="table-scroll-container">
                <table class="threshold-table">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all" class="threshold-checkbox" onchange="toggleSelectAll()">
                            </th>
                            <th>货品名称</th>
                            <th>货品编号</th>
                            <th>当前库存</th>
                            <th>库存状态</th>
                            <th>当前阈值</th>
                            <th>新阈值设置</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody id="threshold-tbody">
                        <tr>
                            <td colspan="8" class="no-data">
                                <div class="loading"></div>
                                <div style="margin-top: 16px;">正在加载阈值数据...</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- 回到顶部按钮 -->
    <button class="back-to-top" id="back-to-top-btn" onclick="scrollToTop()">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>
        // 全局变量
        let allProducts = [];
        let filteredProducts = [];
        let currentThresholds = {};
        let isLoading = false;

        // API配置
        const API_BASE_URL = 'stocklistapi.php';

        // 页面初始化
        document.addEventListener('DOMContentLoaded', function() {
            loadThresholdData();
            
            // 监听回车键搜索
            document.getElementById('search-input').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    filterTable();
                }
            });
        });

        // 加载阈值数据
        async function loadThresholdData() {
            if (isLoading) return;
            
            isLoading = true;
            setLoadingState(true);
            
            try {
                // 获取库存数据
                const stockResponse = await fetch(API_BASE_URL + '?action=summary');
                const stockResult = await stockResponse.json();
                
                if (!stockResult.success) {
                    throw new Error(stockResult.message || '获取库存数据失败');
                }
                
                allProducts = stockResult.data.summary || [];
                
                // 获取当前阈值设置
                await loadCurrentThresholds();
                
                // 渲染表格
                filteredProducts = [...allProducts];
                renderTable();
                updateStats();
                
                showAlert('数据加载成功', 'success');
                
            } catch (error) {
                console.error('加载数据失败:', error);
                showAlert('加载数据失败: ' + error.message, 'error');
                
                document.getElementById('threshold-tbody').innerHTML = `
                    <tr>
                        <td colspan="8" class="no-data">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div>加载失败，请刷新页面重试</div>
                        </td>
                    </tr>
                `;
            } finally {
                isLoading = false;
                setLoadingState(false);
            }
        }

        // 加载当前阈值设置
        async function loadCurrentThresholds() {
            try {
                const response = await fetch(API_BASE_URL + '?action=get-thresholds');
                const result = await response.json();
                
                if (result.success) {
                    const serverThresholds = result.data.thresholds || {};
                    
                    // 为每个产品设置阈值（从服务器获取的或默认值）
                    currentThresholds = {};
                    allProducts.forEach(product => {
                        if (serverThresholds[product.product_name]) {
                            currentThresholds[product.product_name] = serverThresholds[product.product_name].threshold;
                        } else {
                            currentThresholds[product.product_name] = 10.00; // 默认阈值
                        }
                    });
                } else {
                    // 如果获取失败，使用默认阈值
                    console.warn('获取阈值失败，使用默认值:', result.message);
                    currentThresholds = {};
                    allProducts.forEach(product => {
                        currentThresholds[product.product_name] = 10.00;
                    });
                }
            } catch (error) {
                console.error('获取阈值数据失败:', error);
                // 使用默认阈值
                currentThresholds = {};
                allProducts.forEach(product => {
                    currentThresholds[product.product_name] = 10.00;
                });
            }
        }

        // 设置加载状态
        function setLoadingState(loading) {
            const tbody = document.getElementById('threshold-tbody');
            if (loading) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" style="padding: 40px; text-align: center;">
                            <div class="loading"></div>
                            <div style="margin-top: 16px; color: #6b7280;">正在加载阈值数据...</div>
                        </td>
                    </tr>
                `;
            }
        }

        // 渲染表格
        function renderTable() {
            const tbody = document.getElementById('threshold-tbody');
            
            if (filteredProducts.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="no-data">
                            <i class="fas fa-search"></i>
                            <div>没有找到匹配的货品</div>
                        </td>
                    </tr>
                `;
                return;
            }
            
            let html = '';
            
            filteredProducts.forEach((product, index) => {
                const currentStock = parseFloat(product.total_stock) || 0;
                const threshold = currentThresholds[product.product_name] || 10.00;
                const isLowStock = currentStock <= threshold;
                const stockStatusClass = isLowStock ? 'text-danger' : 'text-success';
                const stockStatusText = isLowStock ? '库存不足' : '库存充足';
                const stockStatusIcon = isLowStock ? 'fa-exclamation-triangle' : 'fa-check-circle';
                
                html += `
                    <tr data-product-name="${product.product_name}" ${isLowStock ? 'style="background-color: #fef2f2;"' : ''}>
                        <td class="text-center">
                            <input type="checkbox" class="threshold-checkbox product-checkbox" 
                                   value="${product.product_name}">
                        </td>
                        <td>
                            <strong>${product.product_name}</strong>
                        </td>
                        <td class="text-center">${product.code_number || '-'}</td>
                        <td class="text-center ${stockStatusClass}">${product.formatted_stock}</td>
                        <td class="text-center">
                            <span class="${stockStatusClass}">
                                <i class="fas ${stockStatusIcon}"></i>
                                ${stockStatusText}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="current-threshold" data-product="${product.product_name}">
                                ${threshold.toFixed(2)}
                            </span>
                        </td>
                        <td class="text-center">
                            <input type="number" class="threshold-input" 
                                   data-product="${product.product_name}"
                                   min="0" step="0.01" placeholder="新阈值">
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary" 
                                    onclick="saveProductThreshold('${product.product_name}')">
                                <i class="fas fa-save"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            
            tbody.innerHTML = html;
        }

        // 过滤表格
        function filterTable() {
            const searchValue = document.getElementById('search-input').value.toLowerCase();
            const stockFilter = document.getElementById('stock-filter').value;
            
            filteredProducts = allProducts.filter(product => {
                // 文本搜索过滤
                const matchText = !searchValue || 
                    product.product_name.toLowerCase().includes(searchValue) ||
                    (product.code_number && product.code_number.toLowerCase().includes(searchValue));
                
                // 库存状态过滤
                let matchStock = true;
                if (stockFilter) {
                    const currentStock = parseFloat(product.total_stock) || 0;
                    const threshold = currentThresholds[product.product_name] || 10.00;
                    const isLowStock = currentStock <= threshold;
                    
                    if (stockFilter === 'low') {
                        matchStock = isLowStock;
                    } else if (stockFilter === 'sufficient') {
                        matchStock = !isLowStock;
                    }
                }
                
                return matchText && matchStock;
            });
            
            renderTable();
            updateStats();
            
            if (filteredProducts.length === 0 && (searchValue || stockFilter)) {
                showAlert('没有找到匹配的货品', 'info');
            }
        }

        // 更新统计信息
        function updateStats() {
            const displayedCount = filteredProducts.length;
            const totalCount = allProducts.length;
            
            let lowStockCount = 0;
            allProducts.forEach(product => {
                const currentStock = parseFloat(product.total_stock) || 0;
                const threshold = currentThresholds[product.product_name] || 10.00;
                if (currentStock <= threshold) {
                    lowStockCount++;
                }
            });
            
            document.getElementById('displayed-count').textContent = displayedCount;
            document.getElementById('total-count').textContent = totalCount;
            document.getElementById('low-stock-count').textContent = lowStockCount;
        }

        // 全选/取消全选
        function toggleSelectAll() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.product-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        }

        // 批量应用阈值
        function applyBatchThreshold() {
            const batchValue = document.getElementById('batch-threshold').value;
            if (!batchValue || parseFloat(batchValue) < 0) {
                showAlert('请输入有效的批量阈值', 'error');
                return;
            }
            
            const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
            if (checkedBoxes.length === 0) {
                showAlert('请至少选择一个货品', 'error');
                return;
            }
            
            checkedBoxes.forEach(checkbox => {
                const productName = checkbox.value;
                const input = document.querySelector(`input[data-product="${productName}"]`);
                if (input) {
                    input.value = batchValue;
                }
            });
            
            showAlert(`已为 ${checkedBoxes.length} 个货品设置阈值`, 'success');
        }

        // 保存单个产品阈值
        async function saveProductThreshold(productName) {
            const input = document.querySelector(`input[data-product="${productName}"]`);
            const threshold = input.value;
            
            if (!threshold || parseFloat(threshold) < 0) {
                showAlert('请输入有效的阈值', 'error');
                return;
            }
            
            try {
                const response = await fetch(API_BASE_URL + '?action=set-threshold', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        product_name: productName,
                        threshold: parseFloat(threshold)
                    })
                });
                
                const result = await response.json();
                if (result.success) {
                    // 更新本地阈值记录
                    currentThresholds[productName] = parseFloat(threshold);
                    
                    // 更新显示的当前阈值
                    const currentThresholdSpan = document.querySelector(`span[data-product="${productName}"]`);
                    if (currentThresholdSpan) {
                        currentThresholdSpan.textContent = parseFloat(threshold).toFixed(2);
                    }
                    
                    // 清空输入框
                    input.value = '';
                    
                    // 重新渲染表格以更新库存状态
                    renderTable();
                    updateStats();
                    
                    showAlert('阈值保存成功', 'success');
                } else {
                    showAlert('保存失败: ' + result.message, 'error');
                }
            } catch (error) {
                showAlert('网络错误，请重试', 'error');
            }
        }

        // 保存所有更改
        async function saveAllChanges() {
            const inputs = document.querySelectorAll('.threshold-input');
            const updates = [];
            
            inputs.forEach(input => {
                if (input.value && parseFloat(input.value) >= 0) {
                    updates.push({
                        product_name: input.getAttribute('data-product'),
                        threshold: parseFloat(input.value)
                    });
                }
            });
            
            if (updates.length === 0) {
                showAlert('没有需要保存的更改', 'info');
                return;
            }
            
            let successCount = 0;
            let failCount = 0;
            
            showAlert('正在批量保存阈值设置...', 'info');
            
            for (const update of updates) {
                try {
                    const response = await fetch(API_BASE_URL + '?action=set-threshold', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(update)
                    });
                    
                    const result = await response.json();
                    if (result.success) {
                        successCount++;
                        // 更新本地记录
                        currentThresholds[update.product_name] = update.threshold;
                        
                        // 更新显示
                        const currentThresholdSpan = document.querySelector(`span[data-product="${update.product_name}"]`);
                        if (currentThresholdSpan) {
                            currentThresholdSpan.textContent = update.threshold.toFixed(2);
                        }
                        
                        // 清空输入框
                        const input = document.querySelector(`input[data-product="${update.product_name}"]`);
                        if (input) {
                            input.value = '';
                        }
                    } else {
                        failCount++;
                    }
                } catch (error) {
                    failCount++;
                }
                
                // 添加小延迟避免服务器压力
                await new Promise(resolve => setTimeout(resolve, 100));
            }
            
            // 重新渲染表格
            renderTable();
            updateStats();
            
            if (failCount === 0) {
                showAlert(`成功保存 ${successCount} 个阈值设置`, 'success');
            } else {
                showAlert(`成功保存 ${successCount} 个，失败 ${failCount} 个阈值设置`, 'warning');
            }
        }

        // 重置所有输入
        function resetAllInputs() {
            const inputs = document.querySelectorAll('.threshold-input');
            inputs.forEach(input => {
                input.value = '';
            });
            
            // 取消所有选择
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            document.getElementById('select-all').checked = false;
            
            // 清空批量阈值输入
            document.getElementById('batch-threshold').value = '';
            
            showAlert('已重置所有输入', 'info');
        }

        // 显示提示信息
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alert-container');
            const alertClass = type === 'error' ? 'alert-error' : 
                              type === 'info' ? 'alert-info' : 
                              type === 'warning' ? 'alert-warning' : 'alert-success';
            const iconClass = type === 'error' ? 'fa-exclamation-circle' : 
                             type === 'info' ? 'fa-info-circle' : 
                             type === 'warning' ? 'fa-exclamation-triangle' : 'fa-check-circle';
            
            const alertElement = document.createElement('div');
            alertElement.className = `alert ${alertClass}`;
            alertElement.innerHTML = `
                <i class="fas ${iconClass}"></i>
                <span>${message}</span>
            `;
            
            alertContainer.appendChild(alertElement);
            
            setTimeout(() => {
                alertElement.remove();
            }, 5000);
        }

        // 回到顶部功能
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // 监听滚动事件，控制回到顶部按钮显示
        let scrollTimeout;
        window.addEventListener('scroll', function() {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(function() {
                const backToTopBtn = document.getElementById('back-to-top-btn');
                const scrollThreshold = 300;
                
                if (window.pageYOffset > scrollThreshold) {
                    backToTopBtn.classList.add('show');
                } else {
                    backToTopBtn.classList.remove('show');
                }
            }, 10);
        });

        // 键盘快捷键支持
        document.addEventListener('keydown', function(e) {
            // Ctrl+S 保存所有更改
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                saveAllChanges();
            }
            
            // Ctrl+F 聚焦搜索框
            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                document.getElementById('search-input').focus();
            }
            
            // Escape键重置搜索
            if (e.key === 'Escape') {
                document.getElementById('search-input').value = '';
                document.getElementById('stock-filter').value = '';
                filterTable();
            }
            
            // Ctrl+A 全选
            if (e.ctrlKey && e.key === 'a' && e.target.tagName !== 'INPUT') {
                e.preventDefault();
                document.getElementById('select-all').checked = true;
                toggleSelectAll();
            }
        });
    </script>
</body>
</html>