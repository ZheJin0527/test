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
            background-color: #f8fafc;
            color: #1a202c;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
        }

        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }

        .btn-success {
            background-color: #059669;
            color: white;
        }

        .btn-success:hover {
            background-color: #047857;
        }

        .btn-warning {
            background-color: #d97706;
            color: white;
        }

        .btn-warning:hover {
            background-color: #b45309;
        }

        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .filter-input {
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .filter-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .filter-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-card i {
            font-size: 24px;
            margin-bottom: 8px;
            color: #3b82f6;
        }

        .stat-card h3 {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .stat-card .value {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-header {
            padding: 20px;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-scroll-container {
            overflow-x: auto;
            max-height: 600px;
        }

        .settings-table {
            width: 100%;
            border-collapse: collapse;
        }

        .settings-table th,
        .settings-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .settings-table th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #374151;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .settings-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .quantity-input {
            width: 100px;
            padding: 6px 8px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 14px;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #3b82f6;
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-info {
            background-color: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .no-data i {
            font-size: 48px;
            margin-bottom: 16px;
            color: #d1d5db;
        }

        @media (max-width: 768px) {
            .container {
                padding: 12px;
            }

            .header {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .filter-actions {
                justify-content: center;
            }

            .stats-section {
                grid-template-columns: 1fr;
            }

            .table-header {
                flex-direction: column;
                gap: 16px;
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
                        <td colspan="4" class="no-data">
                            <i class="fas fa-inbox"></i>
                            <div>暂无货品数据</div>
                        </td>
                    </tr>
                `;
                return;
            }

            let html = '';
            filteredProducts.forEach((product, index) => {
                html += `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td><strong>${product.product_name}</strong></td>
                        <td>
                            <input type="number" 
                                   class="quantity-input"
                                   value="${product.minimum_quantity}"
                                   min="0"
                                   step="0.01"
                                   onchange="markAsChanged('${product.product_name}', this.value)"
                                   placeholder="最低数量">
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
            const configuredProducts = allProducts.filter(p => p.minimum_quantity > 0).length;
            const pendingCount = pendingChanges.size;
            
            document.getElementById('total-products').textContent = totalProducts;
            document.getElementById('configured-products').textContent = configuredProducts;
            document.getElementById('current-warnings').textContent = '加载中...';
            document.getElementById('pending-changes').textContent = pendingCount;
        }

        // 标记为已更改
        function markAsChanged(productName, minQuantity) {
            const product = allProducts.find(p => p.product_name === productName);
            if (product) {
                product.minimum_quantity = parseFloat(minQuantity) || 0;
                pendingChanges.add(productName);
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

            filteredProducts = allProducts.filter(product => {
                return !productFilter || product.product_name.toLowerCase().includes(productFilter);
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
            
            filteredProducts = [...allProducts];
            renderSettingsTable();
            
            showAlert('搜索条件已重置', 'info');
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