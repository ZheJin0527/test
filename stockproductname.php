<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <link rel="icon" type="image/png" href="images/images/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>库存产品管理后台 - Excel模式</title>
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

        /* Excel样式表格 */
        .excel-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(88, 62, 4, 0.1);
            overflow: hidden;
            border: 2px solid #583e04;
            overflow-x: auto;
        }

        .excel-table {
            width: 100%;
            min-width: 1400px;
            border-collapse: collapse;
            font-size: 14px;
        }

        .excel-table th {
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
        }

        .excel-table td {
            padding: 0;
            border: 1px solid #d1d5db;
            text-align: center;
            position: relative;
        }

        .excel-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .excel-table tr:hover {
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

        /* 输入框样式 */
        .excel-input {
            width: 100%;
            height: 40px;
            border: none;
            background: #f0fdf4;
            text-align: center;
            font-size: 14px;
            padding: 8px 4px;
            transition: all 0.2s;
        }

        .excel-input.currency-input {
            padding-left: 32px;
            text-align: right;
            padding-right: 8px;
            background: #f0fdf4;
        }

        .excel-input.text-input {
            text-align: left;
            padding-left: 8px;
        }

        .excel-input.datetime-input {
            padding: 8px;
            text-align: center;
        }

        .excel-input:focus {
            background: #fff;
            border: 2px solid #583e04;
            outline: none;
            z-index: 5;
            position: relative;
        }

        .excel-input:not(:placeholder-shown) {
            background: #f0fdf4;
        }

        /* 下拉选择框样式 */
        .excel-select {
            width: 100%;
            height: 40px;
            border: none;
            background: #f0fdf4;
            text-align: center;
            font-size: 14px;
            padding: 8px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .excel-select:focus {
            background: #fff;
            border: 2px solid #583e04;
            outline: none;
            z-index: 5;
            position: relative;
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

        .btn-danger {
            background-color: #ef4444;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #dc2626;
            transform: translateY(-1px);
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
            min-width: 140px;
        }

        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #583e04;
        }

        /* 删除按钮 */
        .delete-row-btn {
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
            margin: 4px auto;
        }

        .delete-row-btn:hover {
            background: #dc2626;
            transform: scale(1.1);
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }

        .delete-row-btn:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            transform: none;
        }

        /* 状态指示 */
        .status-approved {
            background-color: #d1fae5 !important;
            color: #065f46;
        }

        .status-pending {
            background-color: #fef3c7 !important;
            color: #92400e;
        }

        /* 响应式设计 */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 16px;
                align-items: flex-start;
            }
            
            .header .controls {
                flex-wrap: wrap;
                justify-content: center;
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

        /* 提示信息 */
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

        /* 隐藏类 */
        .hidden {
            display: none;
        }

        /* 新行样式 */
        .new-row {
            background-color: #f0fdf4 !important;
        }

        /* 搜索过滤栏 */
        .filter-bar {
            background: white;
            border-radius: 12px;
            padding: 16px 24px;
            margin-bottom: 24px;
            border: 2px solid #583e04;
            box-shadow: 0 2px 8px rgba(88, 62, 4, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .filter-item label {
            font-size: 12px;
            font-weight: 600;
            color: #583e04;
        }

        .filter-input {
            padding: 6px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            background: white;
            color: #583e04;
            min-width: 120px;
        }

        .filter-input:focus {
            outline: none;
            border-color: #583e04;
            box-shadow: 0 0 0 2px rgba(88, 62, 4, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>库存产品管理后台</h1>
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
        
        <!-- 搜索过滤栏 -->
        <div class="filter-bar">
            <div class="filter-group">
                <div class="filter-item">
                    <label>产品编号</label>
                    <input type="text" class="filter-input" id="product-code-filter" placeholder="搜索产品编号">
                </div>
                <div class="filter-item">
                    <label>产品名字</label>
                    <input type="text" class="filter-input" id="product-name-filter" placeholder="搜索产品名字">
                </div>
                <div class="filter-item">
                    <label>批准状态</label>
                    <select class="filter-input" id="approval-status-filter">
                        <option value="">所有状态</option>
                        <option value="approved">已批准</option>
                        <option value="pending">待批准</option>
                    </select>
                </div>
            </div>
            <div class="filter-group">
                <button class="btn btn-primary" onclick="performSearch()">
                    <i class="fas fa-search"></i>
                    搜索
                </button>
                <button class="btn btn-secondary" onclick="clearFilters()">
                    <i class="fas fa-times"></i>
                    清空
                </button>
            </div>
        </div>
        
        <!-- Excel表格 -->
        <div class="excel-container">
            <div class="action-buttons">
                <div class="stats-info" id="stock-stats">
                    <div class="stat-item">
                        <i class="fas fa-boxes"></i>
                        <span>总记录数: <span class="stat-value" id="total-records">0</span></span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-check-circle"></i>
                        <span>已批准: <span class="stat-value" id="approved-count">0</span></span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-clock"></i>
                        <span>待批准: <span class="stat-value" id="pending-count">0</span></span>
                    </div>
                </div>
                
                <div style="display: flex; gap: 12px;">
                    <button class="btn btn-success" onclick="addNewRow()">
                        <i class="fas fa-plus"></i>
                        添加新记录
                    </button>
                    <button class="btn btn-primary" onclick="saveAllData()">
                        <i class="fas fa-save"></i>
                        保存所有数据
                    </button>
                </div>
            </div>
            
            <table class="excel-table" id="excel-table">
                <thead>
                    <tr>
                        <th style="min-width: 100px;">日期</th>
                        <th style="min-width: 80px;">时间</th>
                        <th style="min-width: 120px;">产品编号</th>
                        <th style="min-width: 200px;">产品名字</th>
                        <th style="min-width: 150px;">供应商</th>
                        <th style="min-width: 100px;">价格</th>
                        <th style="min-width: 120px;">申请人</th>
                        <th style="min-width: 120px;">批准人</th>
                        <th style="min-width: 80px;">状态</th>
                        <th style="min-width: 60px;">操作</th>
                    </tr>
                </thead>
                <tbody id="excel-tbody">
                    <!-- 动态生成行 -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // API 配置
        const API_BASE_URL = 'stockapi.php';  // 如果在同一目录
        
        // 应用状态
        let stockData = [];
        let isLoading = false;
        let nextRowId = 1;

        // 初始化应用
        function initApp() {
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
                console.log('API调用:', `${API_BASE_URL}${endpoint}`, options);
                
                const response = await fetch(`${API_BASE_URL}${endpoint}`, {
                    headers: {
                        'Content-Type': 'application/json',
                        ...options.headers
                    },
                    ...options
                });
                
                const responseText = await response.text();
                console.log('API响应:', responseText);
                
                if (!response.ok) {
                    throw new Error(`HTTP错误: ${response.status} - ${responseText}`);
                }
                
                const data = JSON.parse(responseText);
                console.log('解析后的数据:', data);
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
            // 获取搜索参数
            const productCode = document.getElementById('product-code-filter').value.trim();
            const productName = document.getElementById('product-name-filter').value.trim();
            const approvalStatus = document.getElementById('approval-status-filter').value.trim();

            // 构建URL参数
            const params = new URLSearchParams();
            params.append('action', 'list');
            
            if (productCode) params.append('product_code', productCode);
            if (productName) params.append('product_name', productName);
            if (approvalStatus) params.append('approval_status', approvalStatus);
            
            const url = `${API_BASE_URL}?${params.toString()}`;
            console.log('请求URL:', url);
            
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            
            const responseText = await response.text();
            console.log('API响应文本:', responseText);
            
            if (!response.ok) {
                throw new Error(`HTTP错误: ${response.status} - ${responseText}`);
            }
            
            const result = JSON.parse(responseText);
            console.log('解析后的数据:', result);
            
            if (result.success) {
                stockData = result.data || [];
                generateStockTable();
                updateStats();
                showAlert(`库存数据加载成功，共找到 ${stockData.length} 条记录`, 'success');
            } else {
                throw new Error(result.message || '加载失败');
            }
            
        } catch (error) {
            console.error('加载数据失败:', error);
            stockData = [];
            generateStockTable();
            updateStats();
            showAlert('数据加载失败: ' + error.message, 'error');
        } finally {
            isLoading = false;
        }
    }

        // 生成库存表格
        function generateStockTable() {
            const tbody = document.getElementById('excel-tbody');
            tbody.innerHTML = '';
            
            stockData.forEach((item, index) => {
                const row = createStockRow(item, index);
                tbody.appendChild(row);
            });
        }

        // 创建库存行
        function createStockRow(data = {}, index = -1) {
            const row = document.createElement('tr');
            const isNewRow = index === -1;
            const rowId = isNewRow ? `new-${nextRowId++}` : data.id || index;
            
            if (isNewRow) {
                row.classList.add('new-row');
            }
            
            // 根据批准状态设置行样式
            if (data.approver) {
                row.classList.add('status-approved');
            } else if (!isNewRow) {
                row.classList.add('status-pending');
            }
            
            row.innerHTML = `
                <td>
                    <input type="date" class="excel-input datetime-input" data-field="date" data-row="${rowId}" 
                        value="${data.date || ''}" required>
                </td>
                <td>
                    <input type="time" class="excel-input datetime-input" data-field="time" data-row="${rowId}" 
                        value="${data.time || ''}" required>
                </td>
                <td>
                    <input type="text" class="excel-input text-input" data-field="product_code" data-row="${rowId}" 
                        value="${data.product_code || ''}" placeholder="产品编号" required>
                </td>
                <td>
                    <input type="text" class="excel-input text-input" data-field="product_name" data-row="${rowId}" 
                        value="${data.product_name || ''}" placeholder="产品名称" required>
                </td>
                <td>
                    <input type="text" class="excel-input text-input" data-field="supplier" data-row="${rowId}" 
                        value="${data.supplier || ''}" placeholder="供应商名称" required>
                </td>
                <td>
                    <div class="input-container">
                        <span class="currency-prefix">RM</span>
                        <input type="number" class="excel-input currency-input" data-field="price" data-row="${rowId}" 
                            value="${data.price || ''}" min="0" step="0.01" placeholder="0.00" required>
                    </div>
                </td>
                <td>
                    <input type="text" class="excel-input text-input" data-field="applicant" data-row="${rowId}" 
                        value="${data.applicant || ''}" placeholder="申请人" required>
                </td>
                <td>
                    <input type="text" class="excel-input text-input" data-field="approver" data-row="${rowId}" 
                        value="${data.approver || ''}" placeholder="批准人">
                </td>
                <td style="padding: 8px;">
                    ${data.approver ? 
                        '<span style="color: #065f46; font-weight: 600;">已批准</span>' : 
                        '<span style="color: #92400e; font-weight: 600;">待批准</span>'
                    }
                </td>
                <td>
                    <button class="delete-row-btn" onclick="deleteRow('${rowId}')" title="删除此行">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
            
            return row;
        }

        // 添加新行
        function addNewRow() {
            const tbody = document.getElementById('excel-tbody');
            
            // 获取当前日期和时间作为默认值
            const now = new Date();
            const defaultDate = now.toISOString().split('T')[0];
            const defaultTime = now.toTimeString().slice(0, 5);
            
            const newData = {
                date: defaultDate,
                time: defaultTime,
                product_code: '',
                product_name: '',
                supplier: '',
                price: '',
                applicant: '',
                approver: ''
            };
            
            const newRow = createStockRow(newData);
            tbody.appendChild(newRow);
            
            // 聚焦到产品编号输入框
            const productCodeInput = newRow.querySelector('input[data-field="product_code"]');
            if (productCodeInput) {
                productCodeInput.focus();
            }
            
            updateStats();
        }

        function performSearch() {
            if (isLoading) return;
            
            showAlert('正在搜索...', 'info');
            loadStockData();
        }

        // 删除行
        function deleteRow(rowId) {
            if (!confirm('确定要删除这行数据吗？此操作不可恢复！')) {
                return;
            }
            
            const row = document.querySelector(`tr:has(input[data-row="${rowId}"])`);
            if (row) {
                // 如果是数据库中的记录，需要调用API删除
                if (!rowId.toString().startsWith('new-')) {
                    deleteFromDatabase(rowId);
                }
                
                row.remove();
                updateStats();
                showAlert('行已删除', 'success');
            }
        }

        // 从数据库删除记录
        async function deleteFromDatabase(id) {
            try {
                const response = await fetch(`${API_BASE_URL}?id=${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                const responseText = await response.text();
                console.log('DELETE响应:', responseText);
                const result = JSON.parse(responseText);
                
                if (!result.success) {
                    throw new Error(result.message || '删除失败');
                }
            } catch (error) {
                showAlert('删除记录失败: ' + error.message, 'error');
            }
        }

        // 保存所有数据
        async function saveAllData() {
            if (isLoading) return;
            
            const saveBtn = event.target;
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<div class="loading"></div> 保存中...';
            saveBtn.disabled = true;
            
            try {
                const rows = document.querySelectorAll('#excel-tbody tr');
                let successCount = 0;
                let errorCount = 0;
                const errors = [];
                
                for (const row of rows) {
                    const rowData = extractRowData(row);
                    
                    // 验证必填字段
                    if (!rowData.date || !rowData.time || !rowData.product_code || 
                        !rowData.product_name || !rowData.supplier || 
                        !rowData.price || !rowData.applicant) {
                        continue; // 跳过不完整的行
                    }
                    
                    try {
                        const rowId = row.querySelector('input').dataset.row;
                        let result;
                        
                        if (rowId.toString().startsWith('new-')) {
                            // 新记录
                            const response = await fetch(API_BASE_URL, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(rowData)
                            });
                            const responseText = await response.text();
                            console.log('POST响应:', responseText);
                            result = JSON.parse(responseText);
                        } else {
                            // 更新现有记录
                            rowData.id = rowId;
                            const response = await fetch(API_BASE_URL, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(rowData)
                            });
                            const responseText = await response.text();
                            console.log('PUT响应:', responseText);
                            result = JSON.parse(responseText);
                        }
                        
                        if (result.success) {
                            successCount++;
                            // 更新行ID（针对新记录）
                            if (rowId.toString().startsWith('new-') && result.data && result.data.id) {
                                updateRowId(row, rowId, result.data.id);
                            }
                        } else {
                            throw new Error(result.message || '保存失败');
                        }
                        
                    } catch (error) {
                        errorCount++;
                        errors.push(`第${Array.from(rows).indexOf(row) + 1}行: ${error.message}`);
                    }
                }
                
                if (successCount > 0) {
                    showAlert(`成功保存 ${successCount} 条记录${errorCount > 0 ? `，${errorCount} 条失败` : ''}`, 'success');
                    // 重新加载数据以确保同步
                    await loadStockData();
                } else if (errorCount > 0) {
                    showAlert(`保存失败：${errors.join('; ')}`, 'error');
                } else {
                    showAlert('没有需要保存的完整数据', 'info');
                }
                
            } catch (error) {
                showAlert('保存过程中发生错误', 'error');
                console.error('保存错误:', error);
            } finally {
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            }
        }

        // 提取行数据
        function extractRowData(row) {
            const data = {};
            const inputs = row.querySelectorAll('input');
            
            inputs.forEach(input => {
                const field = input.dataset.field;
                let value = input.value.trim();
                
                // 数值字段处理
                if (field === 'price') {
                    value = parseFloat(value) || 0;
                }
                
                data[field] = value;
            });
            
            return data;
        }

        // 更新行ID
        function updateRowId(row, oldId, newId) {
            const inputs = row.querySelectorAll('input');
            inputs.forEach(input => {
                if (input.dataset.row === oldId) {
                    input.dataset.row = newId;
                }
            });
            
            const deleteBtn = row.querySelector('.delete-row-btn');
            if (deleteBtn) {
                deleteBtn.setAttribute('onclick', `deleteRow('${newId}')`);
            }
            
            // 移除新行样式
            row.classList.remove('new-row');
        }

        // 更新统计信息
        function updateStats() {
            const rows = document.querySelectorAll('#excel-tbody tr');
            let totalRecords = rows.length;
            let approvedCount = 0;
            let pendingCount = 0;
            let totalValue = 0;
            
            rows.forEach(row => {
                const approverInput = row.querySelector('input[data-field="approver"]');
                const priceInput = row.querySelector('input[data-field="price"]');
                
                if (approverInput && approverInput.value.trim()) {
                    approvedCount++;
                } else {
                    pendingCount++;
                }
                
                if (priceInput && priceInput.value) {
                    totalValue += parseFloat(priceInput.value) || 0;
                }
            });
            
            document.getElementById('total-records').textContent = totalRecords;
            document.getElementById('approved-count').textContent = approvedCount;
            document.getElementById('pending-count').textContent = pendingCount;

            // 检查是否有总价值元素
            const totalValueElement = document.getElementById('total-value');
            if (totalValueElement) {
                totalValueElement.textContent = totalValue.toLocaleString();
            }
        }

        // 清空过滤器
        function clearFilters() {
            document.getElementById('product-code-filter').value = '';
            document.getElementById('product-name-filter').value = '';
            document.getElementById('approval-status-filter').value = '';
            
            showAlert('过滤器已清空，重新加载所有数据', 'info');
            loadStockData();
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
            }, 2000);
        }

        // 输入框事件处理
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('excel-input')) {
                const field = e.target.dataset.field;
                const value = e.target.value;
                const row = e.target.closest('tr');
                
                // 价格字段限制小数位数
                if (field === 'price') {
                    if (value.includes('.')) {
                        const parts = value.split('.');
                        if (parts[1] && parts[1].length > 2) {
                            e.target.value = parts[0] + '.' + parts[1].substring(0, 2);
                        }
                    }
                }
                
                // 批准人字段变化时更新状态
                if (field === 'approver') {
                    const statusCell = row.querySelector('td:nth-child(9)');
                    if (statusCell) {
                        if (value.trim()) {
                            statusCell.innerHTML = '<span style="color: #065f46; font-weight: 600;">已批准</span>';
                            row.classList.remove('status-pending');
                            row.classList.add('status-approved');
                        } else {
                            statusCell.innerHTML = '<span style="color: #92400e; font-weight: 600;">待批准</span>';
                            row.classList.remove('status-approved');
                            row.classList.add('status-pending');
                        }
                    }
                }
                
                updateStats();
            }
        });

        // 输入框事件处理
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('excel-input')) {
                // ... 现有代码保持不变 ...
            }
        });

        // 价格输入框失去焦点时格式化为两位小数
        document.addEventListener('blur', function(e) {
            if (e.target.classList.contains('currency-input')) {
                const value = e.target.value;
                if (value && !isNaN(value) && value !== '') {
                    const num = parseFloat(value);
                    e.target.value = num.toFixed(2);
                }
            }
        }, true);

        // 键盘快捷键支持
        document.addEventListener('keydown', function(e) {
            // Ctrl+S 保存数据
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                saveAllData();
            }
            
            // Ctrl+N 添加新行
            if (e.ctrlKey && e.key === 'n') {
                e.preventDefault();
                addNewRow();
            }
            
            // Tab键在输入框间移动
            if (e.key === 'Tab') {
                const inputs = Array.from(document.querySelectorAll('.excel-input'));
                const currentIndex = inputs.indexOf(document.activeElement);
                
                if (currentIndex !== -1) {
                    e.preventDefault();
                    const nextIndex = e.shiftKey ? 
                        (currentIndex - 1 + inputs.length) % inputs.length : 
                        (currentIndex + 1) % inputs.length;
                    inputs[nextIndex].focus();
                }
            }
            
            // Enter键移动到下一行同一列
            if (e.key === 'Enter' && document.activeElement.classList.contains('excel-input')) {
                e.preventDefault();
                const currentInput = document.activeElement;
                const field = currentInput.dataset.field;
                const currentRow = currentInput.closest('tr');
                const nextRow = currentRow.nextElementSibling;
                
                if (nextRow) {
                    const nextInput = nextRow.querySelector(`input[data-field="${field}"]`);
                    if (nextInput) {
                        nextInput.focus();
                    }
                } else {
                    // 如果是最后一行，添加新行并聚焦
                    addNewRow();
                    setTimeout(() => {
                        const newRow = document.querySelector('#excel-tbody tr:last-child');
                        const newInput = newRow.querySelector(`input[data-field="${field}"]`);
                        if (newInput) {
                            newInput.focus();
                        }
                    }, 100);
                }
            }
        });

        // Enter键搜索
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && e.target.classList.contains('filter-input')) {
                loadStockData();
            }
        });

        // 页面加载完成后初始化
        document.addEventListener('DOMContentLoaded', initApp);
    </script>
</body>
</html>