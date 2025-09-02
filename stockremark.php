<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <link rel="icon" type="image/png" href="images/images/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>库存价格分析 - 库存管理系统</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f1dfbc;
            color: #111827;
        }
        
        .container {
            max-width: 1800px;
            margin: 0 auto;
            padding: 24px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }
        
        .header h1 {
            font-size: 56px;
            font-weight: bold;
            color: #583e04;
        }
        
        .header .controls {
            display: flex;
            align-items: center;
            gap: 0px;
        }

        .back-button {
            background-color: #6b7280;
            color: white;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            text-decoration: none;
            margin-left: 16px;
        }
        
        .back-button:hover {
            background-color: #4b5563;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(107, 114, 128, 0.2);
        }

        /* Alert Messages */
        .alert {
            padding: 12px 16px;
            margin-bottom: 16px;
            border-radius: 8px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        
        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .alert-info {
            background-color: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }

        .alert-warning {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        /* 搜索和过滤区域 */
        .filter-section {
            background: white;
            border-radius: 12px;
            padding: 24px 40px;
            margin-bottom: 24px;
            border: 2px solid #583e04;
            box-shadow: 0 2px 8px rgba(88, 62, 4, 0.1);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 50px;
            margin-bottom: 16px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .filter-group label {
            font-size: 14px;
            font-weight: 600;
            color: #583e04;
        }

        .filter-input, .filter-select {
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            color: #583e04;
        }

        .filter-input:focus, .filter-select:focus {
            outline: none;
            border-color: #583e04;
            box-shadow: 0 0 0 3px rgba(88, 62, 4, 0.1);
        }

        .filter-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }
        
        .btn-primary {
            background-color: #583e04;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #462d03;
            transform: translateY(-1px);
        }
        
        .btn-success {
            background-color: #10b981;
            color: white;
        }
        
        .btn-success:hover {
            background-color: #059669;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #4b5563;
            transform: translateY(-1px);
        }

        .btn-warning {
            background-color: #f59e0b;
            color: white;
        }
        
        .btn-warning:hover {
            background-color: #d97706;
            transform: translateY(-1px);
        }

        /* 货品组显示 */
        .product-group {
            background: white;
            border-radius: 12px;
            margin-bottom: 24px;
            border: 2px solid #583e04;
            box-shadow: 0 2px 8px rgba(88, 62, 4, 0.1);
            overflow: hidden;
        }

        .product-header {
            background: #583e04;
            color: white;
            padding: 16px 24px;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-header .price-count {
            font-size: 14px;
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 20px;
        }

        .price-variants-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            table-layout: fixed; /* 添加这行 */
        }

        .price-variants-table th {
            background: #f8f5eb;
            color: #583e04;
            padding: 12px;
            text-align: center;
            font-weight: 600;
            border-bottom: 2px solid #583e04;
        }

        .price-variants-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
            vertical-align: middle;
        }

        .price-variants-table th,
        .price-variants-table td {
            width: 25%; /* 平均分配4列 */
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
            vertical-align: middle;
        }

        .price-variants-table th:nth-child(1) { width: 10%; } /* 排序 */
        .price-variants-table th:nth-child(2) { width: 30%; } /* 货品编号 */
        .price-variants-table th:nth-child(3) { width: 30%; } /* 库存数量 */
        .price-variants-table th:nth-child(4) { width: 30%; } /* 单价 */

        .price-variants-table td:nth-child(1) { width: 10%; }
        .price-variants-table td:nth-child(2) { width: 30%; }
        .price-variants-table td:nth-child(3) { width: 30%; }
        .price-variants-table td:nth-child(4) { width: 30%; }

        .price-variants-table tr:hover {
            background-color: #f9fafb;
        }

        /* 价格差异高亮 */
        .highest-price {
            background-color: #fef3c7 !important;
            font-weight: 600;
        }

        .price-difference {
            font-size: 12px;
            color: #dc2626;
            font-weight: 500;
        }

        /* 货币显示 */
        .currency-display {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .currency-symbol {
            color: #6b7280;
            font-weight: 500;
        }

        .currency-amount {
            font-weight: 600;
            color: #583e04;
        }

        .highest-price .currency-amount {
            color: #dc2626;
            font-weight: 700;
        }

        /* 统计信息 */
        .stats-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            border: 2px solid #583e04;
            box-shadow: 0 2px 8px rgba(88, 62, 4, 0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 24px;
        }

        .stat-card {
            text-align: center;
            padding: 16px;
            background: #f8f5eb;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #583e04;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #583e04;
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
            font-style: italic;
        }

        .no-data i {
            font-size: 64px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .no-data h3 {
            font-size: 18px;
            margin-bottom: 8px;
            color: #374151;
        }

        .selector-button {
            background-color: #583e04;
            color: white;
            font-weight: 500;
            padding: 11px 24px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            min-width: 130px;
            justify-content: space-between;
            position: relative; /* 添加这个，因为下拉菜单需要 */
        }

        .selector-button:hover {
            background-color: #462d03;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(88, 62, 4, 0.2);
        }

        .selector-dropdown {
            position: absolute;
            top: 96%;
            right: 0;
            background: white;
            border: 2px solid #583e04;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(88, 62, 4, 0.2);
            min-width: 130px;
            z-index: 10000;
            display: none;
            margin-top: 4px;
        }

        .selector-dropdown.show {
            display: block;
        }

        .selector-dropdown .dropdown-item {
            padding: 8px 16px;
            cursor: pointer;
            border-bottom: 1px solid #e5e7eb;
            transition: all 0.2s;
            color: #583e04;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: block;
        }

        .selector-dropdown .dropdown-item:last-child {
            border-bottom: none;
        }

        .selector-dropdown .dropdown-item:hover {
            background-color: #f8f5eb;
        }

        .selector-dropdown .dropdown-item.active {
            background-color: #583e04 !important;
            color: white !important;
        }

        /* 视图选择器样式 */
        .view-selector {
            position: relative;
            margin-right: 16px;
        }

        .view-selector .selector-button {
            background-color: #583e04;
            min-width: 120px;
        }

        .view-selector .selector-button:hover {
            background-color: #462d03;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(88, 62, 4, 0.2);
        }

        .view-selector .selector-dropdown {
            min-width: 133px;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 16px;
                align-items: flex-start;
            }
            
            .filter-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            
            .filter-actions {
                flex-direction: column;
                width: 100%;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .product-header {
                flex-direction: column;
                gap: 8px;
                align-items: flex-start;
            }

            .price-variants-table {
                font-size: 12px;
            }

            .price-variants-table th,
            .price-variants-table td {
                width: auto;
                min-width: 80px;
                padding: 8px 4px;
                word-wrap: break-word;
                overflow-wrap: break-word;
                white-space: nowrap; /* 防止换行 */
            }
        }

        /* 排序指示器 */
        .sort-indicator {
            margin-left: 8px;
            opacity: 0.5;
        }

        .sort-indicator.active {
            opacity: 1;
            color: #583e04;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>货品备注</h1>
            </div>
            <div class="controls">
                <div class="view-selector">
                    <button class="selector-button" onclick="toggleViewSelector()">
                        <span id="current-view">货品备注</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="selector-dropdown" id="view-selector-dropdown">
                        <div class="dropdown-item" onclick="switchView('list')">总库存</div>
                        <div class="dropdown-item" onclick="switchView('records')">进出货</div>
                        <div class="dropdown-item active" onclick="switchView('remark')">货品备注</div>
                    </div>
                </div>
                <button class="selector-button" style="justify-content: center;">
                    <span id="current-stock-type">中央</span>
                </button>
                <button class="back-button" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i>
                    返回仪表盘
                </button>
            </div>
        </div>
        
        <!-- Alert Messages -->
        <div id="alert-container"></div>
        
        <!-- 搜索和过滤区域 -->
        <div class="filter-section">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="product-filter">货品名称</label>
                    <input type="text" id="product-filter" class="filter-input" placeholder="搜索货品名称...">
                </div>
                <div class="filter-group">
                    <label for="code-filter">货品编号</label>
                    <input type="text" id="code-filter" class="filter-input" placeholder="搜索货品编号...">
                </div>
            </div>
            <div class="filter-actions">
                <button class="btn btn-primary" onclick="searchData()">
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
                <button class="btn btn-warning" onclick="exportData()">
                    <i class="fas fa-download"></i>
                    导出CSV
                </button>
            </div>
        </div>

        <!-- 货品列表 -->
        <div id="products-container">
            <!-- Dynamic content -->
        </div>
    </div>

    <script>
        // API 配置
        let API_BASE_URL = 'stockremarkapi.php';
        
        // 应用状态
        let stockData = [];
        let filteredData = [];
        let isLoading = false;

        // 初始化应用
        function initApp() {
            loadStockRemarks();
        }

        // 切换视图选择器下拉菜单
        function toggleViewSelector() {
            const dropdown = document.getElementById('view-selector-dropdown');
            dropdown.classList.toggle('show');
        }

        function switchView(viewType) {
            if (viewType === 'list') {
                window.location.href = 'stocklistall.php';
            } else if (viewType === 'records') {
                window.location.href = 'stockeditall.php';
            } else {
                // 保持在当前页面（库存价格分析）
                hideViewDropdown();
            }
        }

        // 隐藏视图选择器下拉菜单
        function hideViewDropdown() {
            const dropdown = document.getElementById('view-selector-dropdown');
            if (dropdown) {
                dropdown.classList.remove('show');
            }
        }

        // 返回仪表盘
        function goBack() {
            window.location.href = 'dashboard.php';
        }

        // API 调用函数
        async function apiCall(endpoint, options = {}) {
            try {
                const response = await fetch(`${API_BASE_URL}${endpoint}`, {
                    headers: {
                        'Content-Type': 'application/json',
                        ...options.headers
                    },
                    ...options
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP错误: ${response.status}`);
                }
                
                const data = await response.json();
                return data;
            } catch (error) {
                console.error('API调用失败:', error);
                throw error;
            }
        }

        // 加载库存价格分析数据
        async function loadStockRemarks() {
            if (isLoading) return;
            
            isLoading = true;
            setLoadingState(true);
            
            try {
                const result = await apiCall('?action=analysis');
                
                if (result.success) {
                    stockData = result.data.products || [];
                    filteredData = [...stockData];
                    renderProducts();
                    
                    if (stockData.length === 0) {
                        showAlert('当前没有发现多价格货品', 'info');
                    } else {
                        showAlert(`发现 ${stockData.length} 个货品有多个价格变体`, 'success');
                    }
                } else {
                    stockData = [];
                    filteredData = [];
                    showAlert('获取数据失败: ' + (result.message || '未知错误'), 'error');
                    renderProducts();
                }
                
            } catch (error) {
                stockData = [];
                filteredData = [];
                showAlert('网络错误，请检查连接', 'error');
                renderProducts();
            } finally {
                isLoading = false;
                setLoadingState(false);
            }
        }

        function searchData() {
            const productFilter = document.getElementById('product-filter').value.toLowerCase();
            const codeFilter = document.getElementById('code-filter').value.toLowerCase();
            
            // 过滤数据
            filteredData = stockData.filter(item => {
                const matchProduct = !productFilter || item.product_name.toLowerCase().includes(productFilter);
                const matchCode = !codeFilter || (item.variants && item.variants.some(variant => 
                    variant.code_number && variant.code_number.toLowerCase().includes(codeFilter)));

                return matchProduct && matchCode;
            });

            renderProducts();
            
            if (filteredData.length === 0) {
                showAlert('未找到匹配的记录', 'info');
            } else {
                showAlert(`找到 ${filteredData.length} 个匹配货品`, 'success');
            }
        }

        // 重置搜索过滤器
        function resetFilters() {
            document.getElementById('product-filter').value = '';
            document.getElementById('code-filter').value = '';
            
            filteredData = [...stockData];
            renderProducts();
            showAlert('搜索条件已重置', 'info');
        }

        // 设置加载状态
        function setLoadingState(loading) {
            const container = document.getElementById('products-container');
            
            if (loading) {
                container.innerHTML = `
                    <div style="text-align: center; padding: 60px;">
                        <div class="loading"></div>
                        <div style="margin-top: 16px; color: #6b7280;">正在分析库存价格数据...</div>
                    </div>
                `;
            }
        }

        // 渲染货品列表
        function renderProducts() {
            const container = document.getElementById('products-container');
            
            if (filteredData.length === 0) {
                container.innerHTML = `
                    <div class="no-data">
                        <i class="fas fa-search"></i>
                        <h3>没有找到货品备注</h3>
                        <p>当前筛选条件下没有发现已标记备注的货品</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            
            filteredData.forEach(product => {
                html += `
                    <div class="product-group">
                        <div class="product-header">
                            <span>${product.product_name}</span>
                        </div>
                        <table class="price-variants-table">
                            <thead>
                                <tr>
                                    <th>货品编号</th>
                                    <th>备注编号</th>
                                    <th>数量/重量</th>
                                    <th>规格</th>
                                    <th>单价</th>
                                </tr>
                            </thead>
                            <tbody>`;
                
                // 为每个variant添加一行
                product.variants.forEach(variant => {
                    html += `
                                <tr>
                                    <td>${variant.code_number || '-'}</td>
                                    <td>${variant.remark_number || '-'}</td>
                                    <td>${variant.formatted_quantity}</td>
                                    <td>${variant.specification || '-'}</td>
                                    <td>
                                        <div class="currency-display">
                                            <span class="currency-symbol">RM</span>
                                            <span class="currency-amount">${variant.formatted_price}</span>
                                        </div>
                                    </td>
                                </tr>`;
                });
                
                html += `
                            </tbody>
                        </table>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }

        // 渲染价格变体
        function renderVariants(variants, maxPrice) {
            let html = '';
            
            variants.forEach((variant, index) => {
                const isHighest = parseFloat(variant.price) === parseFloat(maxPrice);
                const rowClass = isHighest ? 'highest-price' : '';
                
                html += `
                    <tr class="${rowClass}">
                        <td><strong>${index + 1}</strong></td>
                        <td>${variant.code_number || '-'}</td>
                        <td>${variant.formatted_stock}</td>
                        <td>
                            <div class="currency-display">
                                <span class="currency-symbol">RM</span>
                                <span class="currency-amount">${variant.formatted_price}</span>
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            return html;
        }

        // 刷新数据
        function refreshData() {
            loadStockRemarks();
        }

        // 导出数据
        function exportData() {
            if (filteredData.length === 0) {
                showAlert('没有数据可导出', 'error');
                return;
            }
            
            try {
                // 创建CSV数据
                const headers = ['Product Name', 'Rank', 'Code Number', 'Stock', 'Unit Price'];
                let csvContent = headers.join(',') + '\n';
                
                filteredData.forEach(product => {
                    product.variants.forEach((variant, index) => {
                        const priceDiff = product.max_price - parseFloat(variant.price);
                        const row = [
                            `"${product.product_name}"`,
                            index + 1,
                            variant.code_number || '',
                            variant.formatted_stock,
                            variant.formatted_price
                        ];
                        csvContent += row.join(',') + '\n';
                    });
                });
                
                // 创建下载链接
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', `stock_price_analysis_${new Date().toISOString().split('T')[0]}.csv`);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                showAlert('数据导出成功', 'success');
            } catch (error) {
                showAlert('导出失败', 'error');
            }
        }

        // 显示提示信息
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alert-container');
            const alertClass = type === 'error' ? 'alert-error' : type === 'info' ? 'alert-info' : type === 'warning' ? 'alert-warning' : 'alert-success';
            const iconClass = type === 'error' ? 'fa-exclamation-circle' : type === 'info' ? 'fa-info-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-check-circle';
            
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

        document.addEventListener('click', function(event) {
            const selector = event.target.closest('.selector-button');
            const dropdown = event.target.closest('.selector-dropdown');
            const dropdownItem = event.target.closest('.dropdown-item');
            
            // 移除库存选择器相关的逻辑，只保留视图选择器
            if (dropdownItem) {
                const parentDropdown = dropdownItem.closest('.selector-dropdown');
                if (parentDropdown) {
                    parentDropdown.classList.remove('show');
                }
                return;
            }
            
            if (!selector && !dropdown) {
                document.getElementById('view-selector-dropdown')?.classList.remove('show');
            }
        });

        // 页面加载完成后初始化
        document.addEventListener('DOMContentLoaded', initApp);

        // 键盘快捷键支持
        document.addEventListener('keydown', function(e) {
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

        // 定时刷新数据（可选，每10分钟刷新一次）
        setInterval(() => {
            if (!document.hidden) { // 只在页面可见时刷新
                loadStockRemarks();
            }
        }, 600000); // 10分钟 = 600000毫秒
    </script>
</body>
</html>