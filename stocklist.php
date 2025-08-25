<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>库存汇总 - 库存管理系统</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f6f9fc 0%, #e9ecef 100%);
            color: #2c3e50;
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .controls {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-1px);
        }

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background: #219a52;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #545b62;
            transform: translateY(-1px);
        }

        .back-button {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            backdrop-filter: blur(10px);
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .summary-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .summary-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        }

        .summary-card h3 {
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .summary-card .value {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .summary-card.total-value .value {
            color: #27ae60;
        }

        .currency-display {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .currency-symbol {
            font-size: 1.2rem;
            color: #6c757d;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
        }

        .table-header {
            background: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: between;
            align-items: center;
            gap: 16px;
        }

        .table-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-actions {
            display: flex;
            gap: 12px;
            margin-left: auto;
        }

        .stock-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .stock-table th,
        .stock-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }

        .stock-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .stock-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .stock-table tbody tr:hover {
            background: #f8f9fa;
        }

        .stock-table tbody tr:nth-child(even) {
            background: rgba(0, 0, 0, 0.02);
        }

        .stock-table tbody tr:nth-child(even):hover {
            background: #f8f9fa;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-style: italic;
        }

        .no-data i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .loading i {
            animation: spin 1s linear infinite;
            font-size: 24px;
            margin-bottom: 16px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .alert {
            padding: 12px 16px;
            margin: 16px 0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #d1edff;
            color: #0c5460;
            border: 1px solid #b8daff;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-info {
            background: #cce7ff;
            color: #055160;
            border: 1px solid #b3d7ff;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-mono {
            font-family: 'Courier New', monospace;
        }

        .positive-value {
            color: #27ae60;
            font-weight: 600;
        }

        .zero-value {
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .header {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .controls {
                flex-wrap: wrap;
                justify-content: center;
            }

            .summary-cards {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .summary-card {
                padding: 16px;
            }

            .summary-card .value {
                font-size: 1.5rem;
            }

            .stock-table {
                font-size: 12px;
            }

            .stock-table th,
            .stock-table td {
                padding: 8px;
            }

            .table-header {
                flex-direction: column;
                gap: 12px;
            }

            .table-actions {
                margin-left: 0;
            }
        }

        .table-scroll {
            overflow-x: auto;
        }

        .refresh-btn.loading i {
            animation: spin 1s linear infinite;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>
                    <i class="fas fa-chart-bar"></i>
                    库存汇总报表
                </h1>
            </div>
            <div class="controls">
                <button class="btn back-button" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i>
                    返回上一页
                </button>
            </div>
        </div>
        
        <!-- Alert Messages -->
        <div id="alert-container"></div>
        
        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card total-value">
                <h3>总库存价值</h3>
                <div class="currency-display">
                    <span class="currency-symbol">RM</span>
                    <span class="value" id="total-value">0.00</span>
                </div>
            </div>
            <div class="summary-card">
                <h3>产品种类</h3>
                <div class="value" id="total-products">0</div>
            </div>
            <div class="summary-card">
                <h3>最后更新</h3>
                <div class="value" style="font-size: 1rem;" id="last-updated">-</div>
            </div>
        </div>

        <!-- Stock Summary Table -->
        <div class="table-container">
            <div class="table-header">
                <div class="table-title">
                    <i class="fas fa-list"></i>
                    库存明细
                </div>
                <div class="table-actions">
                    <button class="btn btn-primary refresh-btn" onclick="refreshData()">
                        <i class="fas fa-sync-alt"></i>
                        刷新数据
                    </button>
                    <button class="btn btn-success" onclick="exportData()">
                        <i class="fas fa-download"></i>
                        导出CSV
                    </button>
                </div>
            </div>
            
            <div class="table-scroll">
                <table class="stock-table" id="stock-table">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Product Name</th>
                            <th>Code Number</th>
                            <th class="text-right">Total Stock</th>
                            <th>Specification</th>
                            <th class="text-right">Unit Price</th>
                            <th class="text-right">Total Price</th>
                        </tr>
                    </thead>
                    <tbody id="stock-tbody">
                        <!-- Dynamic content -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // API 配置
        const API_BASE_URL = 'stocklistapi.php';
        
        // 应用状态
        let stockData = [];
        let isLoading = false;

        // 初始化应用
        function initApp() {
            loadStockSummary();
        }

        // 返回上一页
        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '/';
            }
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

        // 加载库存汇总数据
        async function loadStockSummary() {
            if (isLoading) return;
            
            isLoading = true;
            setLoadingState(true);
            
            try {
                const result = await apiCall('?action=summary');
                
                if (result.success) {
                    stockData = result.data.summary || [];
                    updateSummaryCards(result.data);
                    renderStockTable();
                    updateLastUpdated();
                    
                    if (stockData.length === 0) {
                        showAlert('当前没有库存数据', 'info');
                    }
                } else {
                    stockData = [];
                    showAlert('获取数据失败: ' + (result.message || '未知错误'), 'error');
                    renderStockTable();
                }
                
            } catch (error) {
                stockData = [];
                showAlert('网络错误，请检查连接', 'error');
                renderStockTable();
            } finally {
                isLoading = false;
                setLoadingState(false);
            }
        }

        // 设置加载状态
        function setLoadingState(loading) {
            const refreshBtn = document.querySelector('.refresh-btn');
            const tbody = document.getElementById('stock-tbody');
            
            if (loading) {
                refreshBtn.classList.add('loading');
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="loading">
                            <i class="fas fa-spinner"></i>
                            <div>正在加载库存数据...</div>
                        </td>
                    </tr>
                `;
            } else {
                refreshBtn.classList.remove('loading');
            }
        }

        // 更新汇总卡片
        function updateSummaryCards(data) {
            document.getElementById('total-value').textContent = data.formatted_total_value || '0.00';
            document.getElementById('total-products').textContent = data.total_products || '0';
        }

        // 更新最后更新时间
        function updateLastUpdated() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('zh-CN', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            document.getElementById('last-updated').textContent = timeString;
        }

        // 渲染库存表格
        function renderStockTable() {
            const tbody = document.getElementById('stock-tbody');
            
            if (stockData.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="no-data">
                            <i class="fas fa-inbox"></i>
                            <div>暂无库存数据</div>
                        </td>
                    </tr>
                `;
                return;
            }
            
            let totalValue = 0;
            let tableRows = '';
            
            stockData.forEach((item, index) => {
                const stockClass = item.total_stock > 0 ? 'positive-value' : 'zero-value';
                const priceClass = item.total_price > 0 ? 'positive-value' : 'zero-value';
                
                tableRows += `
                    <tr>
                        <td class="text-center font-mono">${item.no}</td>
                        <td><strong>${item.product_name}</strong></td>
                        <td class="font-mono">${item.code_number || '-'}</td>
                        <td class="text-right font-mono ${stockClass}">${item.formatted_stock}</td>
                        <td>${item.specification || '-'}</td>
                        <td class="text-right">
                            <div class="currency-display" style="justify-content: flex-end;">
                                <span class="currency-symbol">RM</span>
                                <span class="font-mono">${item.formatted_price}</span>
                            </div>
                        </td>
                        <td class="text-right">
                            <div class="currency-display ${priceClass}" style="justify-content: flex-end;">
                                <span class="currency-symbol">RM</span>
                                <span class="font-mono">${item.formatted_total_price}</span>
                            </div>
                        </td>
                    </tr>
                `;
                totalValue += parseFloat(item.total_price);
            });
            
            // 添加总计行
            tableRows += `
                <tr style="background: #f8f9fa; border-top: 2px solid #dee2e6; font-weight: 600;">
                    <td colspan="6" class="text-right" style="font-size: 16px;">总计:</td>
                    <td class="text-right positive-value" style="font-size: 16px;">
                        <div class="currency-display" style="justify-content: flex-end;">
                            <span class="currency-symbol">RM</span>
                            <span class="font-mono">${formatCurrency(totalValue)}</span>
                        </div>
                    </td>
                </tr>
            `;
            
            tbody.innerHTML = tableRows;
        }

        // 格式化货币
        function formatCurrency(value) {
            if (!value || value === '' || value === '0') return '0.00';
            const num = parseFloat(value);
            return isNaN(num) ? '0.00' : num.toFixed(2);
        }

        // 刷新数据
        function refreshData() {
            loadStockSummary();
        }

        // 导出数据
        function exportData() {
            if (stockData.length === 0) {
                showAlert('没有数据可导出', 'error');
                return;
            }
            
            try {
                const link = document.createElement('a');
                link.href = `${API_BASE_URL}?action=export`;
                link.download = `stock_summary_${new Date().toISOString().split('T')[0]}.csv`;
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

        // 定时刷新数据（可选，每5分钟刷新一次）
        setInterval(() => {
            if (!document.hidden) { // 只在页面可见时刷新
                loadStockSummary();
            }
        }, 300000); // 5分钟 = 300000毫秒
    </script>
</body>
</html>