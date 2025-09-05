<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>最低库存设置 - 库存管理系统</title>
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
        .alert-info { background-color: #FFE0B2; color: #E65100; border: 1px solid #FF9800; }
        .alert-warning { background-color: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }

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
            box-shadow: 0 0 0 3px rgba(255, 92, 0, 0.3);
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

        .btn-primary { background-color: #ff5c00; color: white; }
        .btn-primary:hover { background-color: #E65100; }
        
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
            color: #BF360C;
            border-bottom: 2px solid #ff5c00;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .threshold-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
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
            box-shadow: 0 0 0 2px rgba(255, 92, 0, 0.2);
        }

        .threshold-checkbox {
            transform: scale(1.2);
            cursor: pointer;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 92, 0, 0.3);
            border-radius: 50%;
            border-top-color: #ff5c00;
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
            background: #ff5c00;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            box-shadow: 0 4px 15px rgba(255, 92, 0, 0.4);
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
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 92, 0, 0.6);
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
            <h1>
                <i class="fas fa-cog"></i>
                最低库存设置
            </h1>
            <button class="btn btn-secondary" onclick="goBack()">
                <i class="fas fa-arrow-left"></i>
                返回库存管理
            </button>
        </div>

        <!-- Alert Messages -->
        <div id="alert-container"></div>

        <!-- Statistics Section -->
        <div class="stats-section">
            <div class="stat-card">
                <i class="fas fa-boxes"></i>
                <h3>总货品数量</h3>
                <div class="value" id="total-products">0</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-toggle-on"></i>
                <h3>已启用预警</h3>
                <div class="value" id="active-alerts">0</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-exclamation-triangle"></i>
                <h3>当前警告</h3>
                <div class="value" id="current-warnings">0</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-check-circle"></i>
                <h3>库存充足</h3>
                <div class="value" id="sufficient-stock">0</div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="product-filter">货品名称</label>
                    <input type="text" id="product-filter" class="filter-input" placeholder="搜索货品名称...">
                </div>
                <div class="filter-group">
                    <label for="status-filter">预警状态</label>
                    <select id="status-filter" class="filter-input">
                        <option value="">全部状态</option>
                        <option value="active">已启用</option>
                        <option value="inactive">未启用</option>
                        <option value="warning">库存不足</option>
                    </select>
                </div>
            </div>
            <div class="filter-actions">
                <button class="btn btn-primary" onclick="searchSettings()">
                    <i class="fas fa-search"></i>
                    搜索
                </button>
                <button class="btn btn-secondary" onclick="resetFilters()">
                    <i class="fas fa-refresh"></i>
                    重置
                </button>
                <button class="btn btn-success" onclick="refreshData()">
                    <i class="fas fa-sync-alt"></i>
                    刷新数据
                </button>
                <button class="btn btn-warning" onclick="saveAllSettings()">
                    <i class="fas fa-save"></i>
                    批量保存
                </button>
            </div>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <div class="table-header">
                <h3>最低库存设置</h3>
                <div id="table-stats">
                    显示 <span id="displayed-count">0</span> 个货品
                </div>
            </div>
            
            <div class="table-scroll-container">
                <table class="settings-table" id="settings-table">
                    <thead>
                        <tr>
                            <th>货品名称</th>
                            <th>当前库存</th>
                            <th>最低库存数量</th>
                            <th>启用预警</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody id="settings-tbody">
                        <!-- Dynamic content -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // 全局变量
        let allProducts = [];
        let filteredProducts = [];
        let isLoading = false;
        let pendingChanges = new Set();

        // 初始化
        function initApp() {
            loadProductsAndSettings();
        }

        // 加载货品和设置数据
        async function loadProductsAndSettings() {
            if (isLoading) return;
            
            isLoading = true;
            setLoadingState(true);
            
            try {
                // 这里需要创建对应的API接口
                const response = await fetch('stockminimumapi.php?action=list');
                const result = await response.json();
                
                if (result.success) {
                    allProducts = result.data || [];
                    filteredProducts = [...allProducts];
                    renderSettingsTable();
                    updateStats();
                } else {
                    showAlert('获取数据失败: ' + (result.message || '未知错误'), 'error');
                }
                
            } catch (error) {
                showAlert('网络错误，请检查连接', 'error');
                console.error('Error:', error);
            } finally {
                isLoading = false;
                setLoadingState(false);
            }
        }

        // 设置加载状态
        function setLoadingState(loading) {
            const tbody = document.getElementById('settings-tbody');
            if (loading) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" style="padding: 40px; text-align: center;">
                            <div class="loading"></div>
                            <div style="margin-top: 16px; color: #6b7280;">正在加载数据...</div>
                        </td>
                    </tr>
                `;
            }
        }

        // 渲染设置表格
        function renderSettingsTable() {
            const tbody = document.getElementById('settings-tbody');
            
            if (filteredProducts.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="no-data">
                            <i class="fas fa-inbox"></i>
                            <div>暂无货品数据</div>
                        </td>
                    </tr>
                `;
                return;
            }

            let html = '';
            filteredProducts.forEach(product => {
                const isWarning = product.current_stock <= product.minimum_quantity && product.is_active;
                const statusClass = isWarning ? 'style="color: #dc2626; font-weight: 600;"' : '';
                const statusText = isWarning ? '库存不足' : product.is_active ? '预警启用' : '未启用';
                const statusIcon = isWarning ? 'fa-exclamation-triangle' : product.is_active ? 'fa-check-circle' : 'fa-times-circle';

                html += `
                    <tr>
                        <td><strong>${product.product_name}</strong></td>
                        <td ${statusClass}>${product.formatted_current_stock}</td>
                        <td>
                            <input type="number" 
                                   class="quantity-input"
                                   value="${product.minimum_quantity}"
                                   min="0"
                                   step="0.01"
                                   onchange="markAsChanged('${product.product_name}', this.value, ${product.is_active ? 1 : 0})"
                                   placeholder="最低数量">
                        </td>
                        <td>
                            <label class="toggle-switch">
                                <input type="checkbox" 
                                       ${product.is_active ? 'checked' : ''}
                                       onchange="markAsChanged('${product.product_name}', ${product.minimum_quantity}, this.checked ? 1 : 0)">
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td ${statusClass}>
                            <i class="fas ${statusIcon}"></i>
                            ${statusText}
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm" 
                                    onclick="saveIndividualSetting('${product.product_name}')"
                                    style="padding: 4px 8px; font-size: 12px;">
                                <i class="fas fa-save"></i>
                                保存
                            </button>
                        </td>
                    </tr>
                `;
            });

            tbody.innerHTML = html;
            document.getElementById('displayed-count').textContent = filteredProducts.length;
        }

        // 更新统计
        function updateStats() {
            const totalProducts = allProducts.length;
            const activeAlerts = allProducts.filter(p => p.is_active).length;
            const currentWarnings = allProducts.filter(p => p.current_stock <= p.minimum_quantity && p.is_active).length;
            const sufficientStock = allProducts.filter(p => p.current_stock > p.minimum_quantity || !p.is_active).length;

            document.getElementById('total-products').textContent = totalProducts;
            document.getElementById('active-alerts').textContent = activeAlerts;
            document.getElementById('current-warnings').textContent = currentWarnings;
            document.getElementById('sufficient-stock').textContent = sufficientStock;
        }

        // 标记为已更改
        function markAsChanged(productName, minQuantity, isActive) {
            const product = allProducts.find(p => p.product_name === productName);
            if (product) {
                product.minimum_quantity = parseFloat(minQuantity) || 0;
                product.is_active = isActive;
                pendingChanges.add(productName);
                
                // 重新渲染表格以更新状态
                renderSettingsTable();
                updateStats();
            }
        }

        // 保存单个设置
        async function saveIndividualSetting(productName) {
            const product = allProducts.find(p => p.product_name === productName);
            if (!product) return;

            try {
                const response = await fetch('stockminimumapi.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'save_single',
                        product_name: productName,
                        minimum_quantity: product.minimum_quantity,
                        is_active: product.is_active
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    pendingChanges.delete(productName);
                    showAlert(`${productName} 设置保存成功`, 'success');
                } else {
                    showAlert('保存失败: ' + (result.message || '未知错误'), 'error');
                }

            } catch (error) {
                showAlert('保存失败，请检查网络连接', 'error');
                console.error('Error:', error);
            }
        }

        // 批量保存所有更改
        async function saveAllSettings() {
            if (pendingChanges.size === 0) {
                showAlert('没有需要保存的更改', 'info');
                return;
            }

            const changedProducts = Array.from(pendingChanges).map(productName => {
                const product = allProducts.find(p => p.product_name === productName);
                return {
                    product_name: productName,
                    minimum_quantity: product.minimum_quantity,
                    is_active: product.is_active
                };
            });

            try {
                const response = await fetch('stockminimumapi.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'save_batch',
                        products: changedProducts
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    pendingChanges.clear();
                    showAlert(`成功保存 ${changedProducts.length} 个货品的设置`, 'success');
                } else {
                    showAlert('批量保存失败: ' + (result.message || '未知错误'), 'error');
                }

            } catch (error) {
                showAlert('保存失败，请检查网络连接', 'error');
                console.error('Error:', error);
            }
        }

        // 搜索设置
        function searchSettings() {
            const productFilter = document.getElementById('product-filter').value.toLowerCase();
            const statusFilter = document.getElementById('status-filter').value;

            filteredProducts = allProducts.filter(product => {
                const matchProduct = !productFilter || product.product_name.toLowerCase().includes(productFilter);
                
                let matchStatus = true;
                if (statusFilter) {
                    const isWarning = product.current_stock <= product.minimum_quantity && product.is_active;
                    switch (statusFilter) {
                        case 'active':
                            matchStatus = product.is_active;
                            break;
                        case 'inactive':
                            matchStatus = !product.is_active;
                            break;
                        case 'warning':
                            matchStatus = isWarning;
                            break;
                    }
                }

                return matchProduct && matchStatus;
            });

            renderSettingsTable();
            
            if (filteredProducts.length === 0) {
                showAlert('未找到匹配的记录', 'info');
            } else {
                showAlert(`找到 ${filteredProducts.length} 条匹配记录`, 'success');
            }
        }

        // 重置过滤器
        function resetFilters() {
            document.getElementById('product-filter').value = '';
            document.getElementById('status-filter').value = '';
            
            filteredProducts = [...allProducts];
            renderSettingsTable();
            
            showAlert('搜索条件已重置', 'info');
        }

        // 刷新数据
        function refreshData() {
            if (pendingChanges.size > 0) {
                if (!confirm('有未保存的更改，刷新将丢失这些更改。确定要继续吗？')) {
                    return;
                }
                pendingChanges.clear();
            }
            
            loadProductsAndSettings();
        }

        // 返回库存管理
        function goBack() {
            if (pendingChanges.size > 0) {
                if (!confirm('有未保存的更改，离开将丢失这些更改。确定要离开吗？')) {
                    return;
                }
            }
            
            window.location.href = 'stocklistall.php';
        }

        // 显示提示信息
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alert-container');
            const alertClass = type === 'error' ? 'alert-error' : type === 'info' ? 'alert-info' : 'alert-success';
            const iconClass = type === 'error' ? 'fa-exclamation-circle' : type === 'info' ? 'fa-info-circle' : 'fa-check-circle';
            
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

        // 页面加载完成后初始化
        document.addEventListener('DOMContentLoaded', initApp);

        // 键盘快捷键
        document.addEventListener('keydown', function(e) {
            // Ctrl+S 保存
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                saveAllSettings();
            }
            
            // Ctrl+F 聚焦搜索框
            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                document.getElementById('product-filter').focus();
            }
            
            // Escape键重置搜索
            if (e.key === 'Escape') {
                resetFilters();
            }
        });

        // 离开页面前检查未保存更改
        window.addEventListener('beforeunload', function(e) {
            if (pendingChanges.size > 0) {
                e.preventDefault();
                e.returnValue = '有未保存的更改，确定要离开吗？';
            }
        });
    </script>
</body>
</html>