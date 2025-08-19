<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <link rel="icon" type="image/png" href="images/images/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>库存管理系统 - 进出货管理</title>
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
            gap: 16px;
        }

        .back-button {
            background-color: #583e04;
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
        }
        
        .back-button:hover {
            background-color: #462d03;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(88, 62, 4, 0.2);
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

        /* 搜索和过滤区域 */
        .filter-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            border: 2px solid #583e04;
            box-shadow: 0 2px 8px rgba(88, 62, 4, 0.1);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
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

        .btn-danger {
            background-color: #ef4444;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #dc2626;
            transform: translateY(-1px);
        }

        /* 表格样式 */
        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(88, 62, 4, 0.1);
            overflow: hidden;
            border: 2px solid #583e04;
            overflow-x: auto;
        }

        .stock-table {
            table-layout: fixed;
            width: 100%;
            min-width: 1400px;
            border-collapse: collapse;
            font-size: 14px;
        }

        .stock-table th {
            background: #583e04;
            color: white;
            padding: 12px 8px;
            text-align: center;
            font-weight: 600;
            border: 1px solid #462d03;
            position: sticky;
            top: 0;
            z-index: 10;
            white-space: nowrap;
            min-width: 80px;
        }

        .stock-table td {
            padding: 0;
            border: 1px solid #d1d5db;
            text-align: center;
            position: relative;
        }

        .stock-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .stock-table tr:hover {
            background-color: #f3f4f6;
        }

        /* 输入框容器样式 */
        .input-container {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
            height: 40px;
        }

        .currency-prefix {
            position: absolute;
            left: 8px;
            color: #6b7280;
            font-size: 13px;
            font-weight: 500;
            pointer-events: none;
            z-index: 2;
        }

        /* 表格输入框样式 */
        .table-input {
            width: 100%;
            height: 40px;
            border: none;
            background: transparent;
            text-align: center;
            font-size: 14px;
            padding: 8px 4px;
            transition: all 0.2s;
        }

        .table-input.currency-input {
            padding-left: 32px;
            text-align: right;
            padding-right: 8px;
        }

        .table-input:focus {
            background: #fff;
            border: 2px solid #583e04;
            outline: none;
            z-index: 5;
            position: relative;
        }

        .table-select {
            width: 100%;
            height: 40px;
            border: none;
            background: transparent;
            text-align: center;
            font-size: 14px;
            padding: 8px 4px;
            cursor: pointer;
            appearance: none;
        }

        .table-select:focus {
            background: #fff;
            border: 2px solid #583e04;
            outline: none;
        }

        /* 固定表格列宽，防止编辑时宽度变化 */
        .stock-table {
            table-layout: fixed; /* 添加这行 */
            width: 100%;
            min-width: 1400px;
            border-collapse: collapse;
            font-size: 14px;
        }

        /* 为每列指定固定宽度 */
        .stock-table th:nth-child(1), .stock-table td:nth-child(1) { width: 100px; } /* DATE */
        .stock-table th:nth-child(2), .stock-table td:nth-child(2) { width: 120px; } /* Code Number */
        .stock-table th:nth-child(3), .stock-table td:nth-child(3) { width: 150px; } /* PRODUCT */
        .stock-table th:nth-child(4), .stock-table td:nth-child(4) { width: 80px; }  /* In */
        .stock-table th:nth-child(5), .stock-table td:nth-child(5) { width: 80px; }  /* Out */
        .stock-table th:nth-child(6), .stock-table td:nth-child(6) { width: 100px; } /* Specification */
        .stock-table th:nth-child(7), .stock-table td:nth-child(7) { width: 100px; } /* Price */
        .stock-table th:nth-child(8), .stock-table td:nth-child(8) { width: 100px; } /* Total */
        .stock-table th:nth-child(9), .stock-table td:nth-child(9) { width: 120px; } /* Name */
        .stock-table th:nth-child(10), .stock-table td:nth-child(10) { width: 120px; } /* Remark */
        .stock-table th:nth-child(11), .stock-table td:nth-child(11) { width: 80px; } /* 操作 */

        /* 确保输入框和选择框填满单元格 */
        .table-input, .table-select {
            width: 100%;
            height: 40px;
            border: none;
            background: transparent;
            text-align: center;
            font-size: 14px;
            padding: 8px 4px;
            transition: all 0.2s;
            box-sizing: border-box; /* 添加这行 */
        }

        /* 日期单元格样式 */
        .date-cell {
            background: #f8f5eb !important;
            font-weight: 600;
            color: #583e04;
            padding: 12px 8px;
            min-width: 100px;
        }

        /* 计算列样式 */
        .calculated-cell {
            background: #f0f9ff !important;
            color: #0369a1;
            font-weight: 600;
            padding: 12px 8px;
            min-width: 100px;
        }

        /* 操作按钮 */
        .action-buttons {
            padding: 24px;
            background: #f8f5eb;
            border-top: 2px solid #583e04;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .action-cell {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 4px;
        }

        .action-btn {
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 6px;
            width: 32px;
            height: 32px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            font-size: 12px;
            margin: 2px;
        }

        .action-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }

        .action-btn.edit-btn {
            background: #f59e0b;
        }

        .action-btn.edit-btn:hover {
            background: #d97706;
        }

        .edit-btn.save-mode {
            background: #10b981;
        }

        .edit-btn.save-mode:hover {
            background: #059669;
        }

        .action-btn.delete-btn {
            background: #ef4444;
        }

        .action-btn.delete-btn:hover {
            background: #dc2626;
        }

        .action-btn.approve-btn {
            background: #10b981;
        }

        .action-btn.approve-btn:hover {
            background: #059669;
        }

        /* 统计信息 */
        .stats-info {
            display: flex;
            gap: 24px;
            align-items: center;
            font-size: 14px;
            color: #6b7280;
            flex-wrap: wrap;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 150px;
        }

        .stat-value {
            font-size: 16px;
            font-weight: bold;
            color: #583e04;
        }

        /* 新增记录表单 */
        .add-form {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            border: 2px solid #583e04;
            box-shadow: 0 2px 8px rgba(88, 62, 4, 0.1);
            display: none;
        }

        .add-form.show {
            display: block;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            margin-bottom: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: #583e04;
        }

        .form-input, .form-select {
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            color: #583e04;
        }

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #583e04;
            box-shadow: 0 0 0 3px rgba(88, 62, 4, 0.1);
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        /* 加载状态 */
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

        /* 响应式设计 */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 16px;
                align-items: flex-start;
            }
            
            .filter-grid {
                grid-template-columns: 1fr;
            }
            
            .filter-actions {
                flex-direction: column;
                width: 100%;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 12px;
            }
            
            .stats-info {
                flex-direction: column;
                gap: 8px;
                align-items: flex-start;
            }

            .stat-item {
                min-width: auto;
                width: 100%;
            }
        }

        /* 批准状态样式 */
        .approval-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
        }

        .approval-badge.approved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .approval-badge.pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        /* 隐藏类 */
        .hidden {
            display: none;
        }

        /* Out 数值为负数的样式 */
        .negative-value {
            color: #dc2626 !important;
            font-weight: 600;
        }

        /* 产品名称列稍宽 */
        .product-name-col {
            min-width: 150px !important;
        }

        .supplier-col {
            min-width: 120px !important;
        }

        /* 新增行样式 */
        .new-row {
            background-color: #f0f9ff !important;  
        }

        .new-row td {

        }

        .new-row .table-input, .new-row .table-select {
            background: white;
        }

        .save-new-btn {
            background: #10b981 !important;
        }

        .cancel-new-btn {
            background: #ef4444 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>库存进出货管理系统</h1>
            </div>
            <div class="controls">
                <button class="back-button" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i>
                    返回上一页
                </button>
            </div>
        </div>
        
        <!-- Alert Messages -->
        <div id="alert-container"></div>
        
        <!-- 搜索和过滤区域 -->
        <div class="filter-section">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="date-filter">日期</label>
                    <input type="date" id="date-filter" class="filter-input">
                </div>
                <div class="filter-group">
                    <label for="product-filter">产品名称</label>
                    <input type="text" id="product-filter" class="filter-input" placeholder="搜索产品名称...">
                </div>
                <div class="filter-group">
                    <label for="receiver-filter">收货人</label>
                    <input type="text" id="receiver-filter" class="filter-input" placeholder="搜索收货人...">
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
                <button class="btn btn-success" onclick="addNewRow()">
                    <i class="fas fa-plus"></i>
                    新增记录
                </button>
                <button class="btn btn-warning" onclick="exportData()">
                    <i class="fas fa-download"></i>
                    导出数据
                </button>
            </div>
        </div>

        <!-- 新增记录表单 -->
        <div id="add-form" class="add-form">
            <h3 style="color: #583e04; margin-bottom: 16px;">新增库存记录</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label for="add-date">日期 *</label>
                    <input type="date" id="add-date" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="add-time">时间 *</label>
                    <input type="time" id="add-time" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="add-product-code">产品编号 *</label>
                    <input type="text" id="add-product-code" class="form-input" placeholder="输入产品编号..." required>
                </div>
                <div class="form-group">
                    <label for="add-product-name">产品名称 *</label>
                    <input type="text" id="add-product-name" class="form-input" placeholder="输入产品名称..." required>
                </div>
                <div class="form-group">
                    <label for="add-in-qty">入库数量</label>
                    <input type="number" id="add-in-qty" class="form-input" min="0" step="0.01" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label for="add-out-qty">出库数量</label>
                    <input type="number" id="add-out-qty" class="form-input" min="0" step="0.01" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label for="add-specification">规格单位 *</label>
                    <select id="add-specification" class="form-select" required>
                        <option value="">请选择规格</option>
                        <option value="Tub">Tub</option>
                        <option value="Kilo">Kilo</option>
                        <option value="Piece">Piece</option>
                        <option value="Bottle">Bottle</option>
                        <option value="Box">Box</option>
                        <option value="Packet">Packet</option>
                        <option value="Carton">Carton</option>
                        <option value="Tin">Tin</option>
                        <option value="Roll">Roll</option>
                        <option value="Nos">Nos</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="add-price">单价 (RM)</label>
                    <input type="number" id="add-price" class="form-input" min="0" step="0.01" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label for="add-receiver">收货人 *</label>
                    <input type="text" id="add-receiver" class="form-input" placeholder="输入收货人..." required>
                </div>
                <div class="form-group">
                    <label for="add-applicant">申请人 *</label>
                    <input type="text" id="add-applicant" class="form-input" placeholder="输入申请人..." required>
                </div>
                <div class="form-group">
                    <label for="add-code-number">编号</label>
                    <input type="text" id="add-code-number" class="form-input" placeholder="输入编号...">
                </div>
                <div class="form-group">
                    <label for="add-remark">备注</label>
                    <input type="text" id="add-remark" class="form-input" placeholder="输入备注...">
                </div>
            </div>
            <div class="form-actions">
                <button class="btn btn-secondary" onclick="toggleAddForm()">
                    <i class="fas fa-times"></i>
                    取消
                </button>
                <button class="btn btn-success" onclick="saveNewRecord()">
                    <i class="fas fa-save"></i>
                    保存
                </button>
            </div>
        </div>
        
        <!-- 库存表格 -->
        <div class="table-container">
            <div class="action-buttons">
                <div class="stats-info" id="stock-stats">
                    <div class="stat-item">
                        <i class="fas fa-boxes"></i>
                        <span>总记录数: <span class="stat-value" id="total-records">0</span></span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-truck"></i>
                        <span>供应商数: <span class="stat-value" id="supplier-count">0</span></span>
                    </div>
                </div>
                
                <div style="display: flex; gap: 12px;">
                    <button class="btn btn-primary" onclick="refreshData()">
                        <i class="fas fa-sync-alt"></i>
                        刷新数据
                    </button>
                </div>
            </div>
            <table class="stock-table" id="stock-table">
                <thead>
                    <tr>
                        <th style="min-width: 100px;">DATE</th>
                        <th style="min-width: 100px;">Code Number</th>
                        <th class="product-name-col">PRODUCT</th>
                        <th style="min-width: 80px;">In</th>
                        <th style="min-width: 80px;">Out</th>
                        <th style="min-width: 100px;">Specification</th>
                        <th style="min-width: 100px;">Price</th>
                        <th style="min-width: 100px;">Total</th>
                        <th class="supplier-col">Name</th>
                        <th style="min-width: 100px;">Remark</th>
                        <th style="min-width: 80px;">操作</th>
                    </tr>
                </thead>
                <tbody id="stock-tbody">
                    <!-- 动态生成行 -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // API 配置
        const API_BASE_URL = 'stockeditapi.php';
        
        // 应用状态
        let stockData = [];
        let isLoading = false;
        let editingRowId = null;

        // 规格选项
        const specifications = ['Tub', 'Kilo', 'Piece', 'Bottle', 'Box', 'Packet', 'Carton', 'Tin', 'Roll', 'Nos'];

        // 初始化应用
        function initApp() {
            // 设置默认日期为今天
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('add-date').value = today;
            document.getElementById('add-time').value = new Date().toTimeString().slice(0, 5);
            
            // 加载数据
            loadStockData();
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

        // 加载库存数据
        async function loadStockData() {
            if (isLoading) return;
            
            isLoading = true;
            
            try {
                const result = await apiCall('?action=list');
                
                if (result.success) {
                    stockData = result.data || [];
                } else {
                    stockData = [];
                    showAlert('获取数据失败: ' + (result.message || '未知错误'), 'error');
                }
                
                renderStockTable();
                updateStats();
                
            } catch (error) {
                stockData = [];
                renderStockTable();
                updateStats();
                showAlert('网络错误，请检查连接', 'error');
            } finally {
                isLoading = false;
            }
        }

        // 搜索数据
        async function searchData() {
            if (isLoading) return;
            
            isLoading = true;
            
            try {
                const params = new URLSearchParams({
                    action: 'list'
                });
                
                const dateFilter = document.getElementById('date-filter').value;
                const productFilter = document.getElementById('product-filter').value;
                const receiverFilter = document.getElementById('receiver-filter').value;
                
                if (dateFilter) params.append('search_date', dateFilter);
                if (productFilter) params.append('product_name', productFilter);
                if (receiverFilter) params.append('receiver', receiverFilter);
                
                const result = await apiCall(`?${params}`);
                
                if (result.success) {
                    stockData = result.data || [];
                    showAlert(`找到 ${stockData.length} 条记录`, 'success');
                } else {
                    stockData = [];
                    showAlert('搜索失败: ' + (result.message || '未知错误'), 'error');
                }
                
                renderStockTable();
                updateStats();
                
            } catch (error) {
                showAlert('搜索时发生错误', 'error');
            } finally {
                isLoading = false;
            }
        }

        // 重置搜索过滤器
        function resetFilters() {
            document.getElementById('date-filter').value = '';
            document.getElementById('product-filter').value = '';
            document.getElementById('receiver-filter').value = '';
            loadStockData();
        }

        // 渲染库存表格
        function renderStockTable() {
            const tbody = document.getElementById('stock-tbody');
            tbody.innerHTML = '';
            
            if (stockData.length === 0) {
                tbody.innerHTML = '<tr><td colspan="11" style="padding: 20px; color: #6b7280;">暂无数据</td></tr>';
                return;
            }
            
            stockData.forEach(record => {
                const row = document.createElement('tr');
                const isEditing = editingRowId === record.id;
                
                // 计算总价
                const inQty = parseFloat(record.in_quantity) || 0;
                const outQty = parseFloat(record.out_quantity) || 0;
                const price = parseFloat(record.price) || 0;
                const netQty = inQty - outQty;
                const total = netQty * price;
                
                row.innerHTML = `
                    <td class="date-cell">${formatDate(record.date)}</td>
                    <td>
                        ${isEditing ? 
                            `<input type="text" class="table-input" value="${record.code_number || ''}" onchange="updateField(${record.id}, 'code_number', this.value)">` :
                            `<span>${record.code_number || '-'}</span>`
                        }
                    </td>
                    <td>
                        ${isEditing ? 
                            `<input type="text" class="table-input" value="${record.product_name}" onchange="updateField(${record.id}, 'product_name', this.value)">` :
                            `<span>${record.product_name}</span>`
                        }
                    </td>
                    <td>
                        ${isEditing ? 
                            `<input type="number" class="table-input" value="${record.in_quantity || ''}" min="0" step="0.01" onchange="updateField(${record.id}, 'in_quantity', this.value)">` :
                            `<span>${formatNumber(record.in_quantity)}</span>`
                        }
                    </td>
                    <td>
                        ${isEditing ? 
                            `<input type="number" class="table-input" value="${record.out_quantity || ''}" min="0" step="0.01" onchange="updateField(${record.id}, 'out_quantity', this.value)">` :
                            `<span class="${outQty > 0 ? 'negative-value' : ''}">${formatNumber(record.out_quantity)}</span>`
                        }
                    </td>
                    <td>
                        ${isEditing ? 
                            `<select class="table-select" onchange="updateField(${record.id}, 'specification', this.value)">
                                ${specifications.map(spec => 
                                    `<option value="${spec}" ${record.specification === spec ? 'selected' : ''}>${spec}</option>`
                                ).join('')}
                            </select>` :
                            `<span>${record.specification || '-'}</span>`
                        }
                    </td>
                    <td>
                        <div class="input-container">
                            <span class="currency-prefix">RM</span>
                            ${isEditing ? 
                                `<input type="number" class="table-input currency-input" value="${record.price || ''}" min="0" step="0.01" onchange="updateField(${record.id}, 'price', this.value)">` :
                                `<span style="padding-left: 32px; text-align: right; display: block;">${formatCurrency(record.price)}</span>`
                            }
                        </div>
                    </td>
                    <td class="calculated-cell">RM ${formatCurrency(total)}</td>
                    <td>
                        ${isEditing ? 
                            `<input type="text" class="table-input" value="${record.receiver || ''}" onchange="updateField(${record.id}, 'receiver', this.value)">` :
                            `<span>${record.receiver || '-'}</span>`
                        }
                    </td>
                    <td>
                        ${isEditing ? 
                            `<input type="text" class="table-input" value="${record.remark || ''}" onchange="updateField(${record.id}, 'remark', this.value)">` :
                            `<span>${record.remark || '-'}</span>`
                        }
                    </td>
                    <td class="action-cell">
                        ${isEditing ? 
                            `<button class="action-btn edit-btn save-mode" onclick="saveRecord(${record.id})" title="保存">
                                <i class="fas fa-save"></i>
                            </button>
                            <button class="action-btn" onclick="cancelEdit()" title="取消" style="background: #6b7280;">
                                <i class="fas fa-times"></i>
                            </button>` :
                            `<button class="action-btn edit-btn" onclick="editRecord(${record.id})" title="编辑">
                                <i class="fas fa-edit"></i>
                            </button>`
                        }
                        ${!isEditing ? 
                            `<button class="action-btn delete-btn" onclick="deleteRecord(${record.id})" title="删除">
                                <i class="fas fa-trash"></i>
                            </button>` : ''
                        }
                    </td>
                `;
                
                tbody.appendChild(row);
            });
        }

        // 格式化日期
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = date.getDate().toString().padStart(2, '0');
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const month = months[date.getMonth()];
            return `${day} ${month}`;
        }

        // 格式化数字
        function formatNumber(value) {
            if (!value || value === '' || value === '0') return '0.00';
            const num = parseFloat(value);
            return isNaN(num) ? '0.00' : num.toFixed(2);
        }

        // 格式化货币
        function formatCurrency(value) {
            if (!value || value === '' || value === '0') return '0.00';
            const num = parseFloat(value);
            return isNaN(num) ? '0.00' : num.toFixed(2);
        }

        // 更新统计信息
        function updateStats() {
            const totalRecords = stockData.length;
            const receiverCount = new Set(stockData.map(record => record.receiver)).size;
            
            document.getElementById('total-records').textContent = totalRecords;
            document.getElementById('supplier-count').textContent = receiverCount;
        }

        // 添加新行到表格
        function addNewRow() {
            if (editingRowId !== null) {
                showAlert('请先完成当前编辑操作', 'info');
                return;
            }
            
            if (document.querySelector('.new-row')) {
                showAlert('请先完成新记录的添加', 'info');
                return;
            }
            
            const tbody = document.getElementById('stock-tbody');
            const row = document.createElement('tr');
            row.className = 'new-row';
            
            const now = new Date();
            const today = now.toISOString().split('T')[0];
            const currentTime = now.toTimeString().slice(0, 5);
            
            row.innerHTML = `
                <td><input type="date" class="table-input" value="${today}" id="new-date"></td>
                <td><input type="text" class="table-input" placeholder="输入编号..." id="new-code-number"></td>
                <td><input type="text" class="table-input" placeholder="输入产品名称..." id="new-product-name"></td>
                <td><input type="number" class="table-input" min="0" step="0.01" placeholder="0.00" id="new-in-qty"></td>
                <td><input type="number" class="table-input" min="0" step="0.01" placeholder="0.00" id="new-out-qty"></td>
                <td>
                    <select class="table-select" id="new-specification">
                        <option value="">请选择规格</option>
                        ${specifications.map(spec => `<option value="${spec}">${spec}</option>`).join('')}
                    </select>
                </td>
                <td>
                    <div class="input-container">
                        <span class="currency-prefix">RM</span>
                        <input type="number" class="table-input currency-input" min="0" step="0.01" placeholder="0.00" id="new-price">
                    </div>
                </td>
                <td class="calculated-cell">RM 0.00</td>
                <td><input type="text" class="table-input" placeholder="输入收货人..." id="new-receiver"></td>
                <td><input type="text" class="table-input" placeholder="输入备注..." id="new-remark"></td>
                <td class="action-cell">
                    <button class="action-btn save-new-btn" onclick="saveNewRowRecord()" title="保存">
                        <i class="fas fa-save"></i>
                    </button>
                    <button class="action-btn cancel-new-btn" onclick="cancelNewRow()" title="取消">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            `;
            
            // 添加到表格顶部
            tbody.insertBefore(row, tbody.firstChild);
            
            // 自动聚焦到产品名称输入框
            document.getElementById('new-product-name').focus();
            
            // 添加实时计算总价功能
            ['new-in-qty', 'new-out-qty', 'new-price'].forEach(id => {
                document.getElementById(id).addEventListener('input', updateNewRowTotal);
            });
        }

        // 更新新行的总价计算
        function updateNewRowTotal() {
            const inQty = parseFloat(document.getElementById('new-in-qty').value) || 0;
            const outQty = parseFloat(document.getElementById('new-out-qty').value) || 0;
            const price = parseFloat(document.getElementById('new-price').value) || 0;
            const netQty = inQty - outQty;
            const total = netQty * price;
            
            const totalCell = document.querySelector('.new-row .calculated-cell');
            if (totalCell) {
                totalCell.textContent = `RM ${formatCurrency(total)}`;
            }
        }

        // 保存新行记录
        async function saveNewRowRecord() {
            const formData = {
                date: document.getElementById('new-date').value,
                time: new Date().toTimeString().slice(0, 5),
                product_code: document.getElementById('new-product-name').value, // 临时使用产品名称作为编号
                product_name: document.getElementById('new-product-name').value,
                in_quantity: parseFloat(document.getElementById('new-in-qty').value) || 0,
                out_quantity: parseFloat(document.getElementById('new-out-qty').value) || 0,
                specification: document.getElementById('new-specification').value,
                price: parseFloat(document.getElementById('new-price').value) || 0,
                receiver: document.getElementById('new-receiver').value,
                code_number: document.getElementById('new-code-number').value,
                remark: document.getElementById('new-remark').value
            };

            // 验证必填字段
            if (!formData.product_name || !formData.specification || !formData.receiver) {
                showAlert('请填写产品名称、规格单位和收货人', 'error');
                return;
            }

            try {
                const result = await apiCall('', {
                    method: 'POST',
                    body: JSON.stringify(formData)
                });

                if (result.success) {
                    showAlert('记录添加成功', 'success');
                    cancelNewRow();
                    loadStockData();
                } else {
                    showAlert('添加失败: ' + (result.message || '未知错误'), 'error');
                }
            } catch (error) {
                showAlert('保存时发生错误', 'error');
            }
        }

        // 取消新行
        function cancelNewRow() {
            const newRow = document.querySelector('.new-row');
            if (newRow) {
                newRow.remove();
            }
        }

        // 保存新记录
        async function saveNewRecord() {
            const formData = {
                date: document.getElementById('add-date').value,
                time: document.getElementById('add-time').value,
                product_code: document.getElementById('add-product-code').value,
                product_name: document.getElementById('add-product-name').value,
                in_quantity: parseFloat(document.getElementById('add-in-qty').value) || 0,
                out_quantity: parseFloat(document.getElementById('add-out-qty').value) || 0,
                specification: document.getElementById('add-specification').value,
                price: parseFloat(document.getElementById('add-price').value) || 0,
                receiver: document.getElementById('add-receiver').value,
                applicant: document.getElementById('add-applicant').value,
                code_number: document.getElementById('add-code-number').value,
                remark: document.getElementById('add-remark').value
            };

            // 验证必填字段
            const requiredFields = ['date', 'time', 'product_code', 'product_name', 'specification', 'receiver', 'applicant'];
            for (let field of requiredFields) {
                if (!formData[field]) {
                    showAlert(`请填写${getFieldLabel(field)}`, 'error');
                    return;
                }
            }

            try {
                const result = await apiCall('', {
                    method: 'POST',
                    body: JSON.stringify(formData)
                });

                if (result.success) {
                    showAlert('记录添加成功', 'success');
                    toggleAddForm();
                    loadStockData();
                } else {
                    showAlert('添加失败: ' + (result.message || '未知错误'), 'error');
                }
            } catch (error) {
                showAlert('保存时发生错误', 'error');
            }
        }

        // 获取字段标签
        function getFieldLabel(field) {
            const labels = {
                'date': '日期',
                'time': '时间',
                'product_code': '产品编号',
                'product_name': '产品名称',
                'specification': '规格单位',
                'receiver': '收货人',
                'applicant': '申请人'
            };
            return labels[field] || field;
        }

        // 编辑记录
        function editRecord(id) {
            if (editingRowId !== null) {
                showAlert('请先完成当前编辑操作', 'info');
                return;
            }
            editingRowId = id;
            renderStockTable();
        }

        // 取消编辑
        function cancelEdit() {
            editingRowId = null;
            renderStockTable();
        }

        // 更新字段
        function updateField(id, field, value) {
            const record = stockData.find(r => r.id === id);
            if (record) {
                record[field] = value;
                // 重新渲染该行以更新计算值
                renderStockTable();
            }
        }

        // 保存记录
        async function saveRecord(id) {
            const record = stockData.find(r => r.id === id);
            if (!record) return;

            try {
                const result = await apiCall('', {
                    method: 'PUT',
                    body: JSON.stringify(record)
                });

                if (result.success) {
                    showAlert('记录更新成功', 'success');
                    editingRowId = null;
                    loadStockData();
                } else {
                    showAlert('更新失败: ' + (result.message || '未知错误'), 'error');
                }
            } catch (error) {
                showAlert('保存时发生错误', 'error');
            }
        }

        // 批准记录
        async function approveRecord(id) {
            if (!confirm('确定要批准此记录吗？')) return;

            try {
                const result = await apiCall('?action=approve', {
                    method: 'PUT',
                    body: JSON.stringify({ id: id })
                });

                if (result.success) {
                    showAlert('记录批准成功', 'success');
                    loadStockData();
                } else {
                    showAlert('批准失败: ' + (result.message || '未知错误'), 'error');
                }
            } catch (error) {
                showAlert('批准时发生错误', 'error');
            }
        }

        // 删除记录
        async function deleteRecord(id) {
            if (!confirm('确定要删除此记录吗？此操作不可恢复！')) return;

            try {
                const result = await apiCall(`?id=${id}`, {
                    method: 'DELETE'
                });

                if (result.success) {
                    showAlert('记录删除成功', 'success');
                    loadStockData();
                } else {
                    showAlert('删除失败: ' + (result.message || '未知错误'), 'error');
                }
            } catch (error) {
                showAlert('删除时发生错误', 'error');
            }
        }

        // 刷新数据
        function refreshData() {
            loadStockData();
        }

        // 导出数据
        function exportData() {
            showAlert('导出功能开发中...', 'info');
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

        // 键盘快捷键支持
        document.addEventListener('keydown', function(e) {
            // Ctrl+S 保存当前编辑
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                if (editingRowId !== null) {
                    saveRecord(editingRowId);
                }
            }
            
            // Escape键取消编辑
            if (e.key === 'Escape') {
                if (editingRowId !== null) {
                    cancelEdit();
                } else if (document.querySelector('.new-row')) {
                    cancelNewRow();
                }
            }
        });
    </script>
</body>
</html>