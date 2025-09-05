<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <link rel="icon" type="image/png" href="images/images/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>库存管理系统</title>
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

        /* 系统选择器样式 */
        .system-selector {
            position: relative;
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
        }
        
        .selector-button:hover {
            background-color: #462d03;
            border-radius: 8px;
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
            z-index: 1000;
            display: none;
            margin-top: 4px;
        }

        .selector-dropdown.show {
            display: block;
        }

        .dropdown-item {
            padding: 8px 16px;
            cursor: pointer;
            border-bottom: 1px solid #e5e7eb;
            transition: all 0.2s;
            color: #583e04;
            font-size: 14px;
            font-weight: 500;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background-color: #f8f5eb;
            border-radius: 8px;
        }

        .dropdown-item.active {
            background-color: #583e04;
            color: white;
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

        .summary-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            border: 2px solid #583e04;
            box-shadow: 0 2px 8px rgba(88, 62, 4, 0.1);
            transition: transform 0.2s ease;
        }

        .summary-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(88, 62, 4, 0.15);
        }

        .summary-card h3 {
            color: #583e04;
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .summary-card .value {
            font-size: 32px;
            font-weight: 700;
            color: #583e04;
        }

        .summary-card.total-value .value {
            color: #583e04;
        }

        /* 货币显示容器 */
        .currency-display {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 20px;
            height: 40px;
            box-sizing: border-box;
            font-size: 14px;
            width: 100%;
        }

        .currency-display .currency-symbol {
            color: #6b7280;
            font-weight: 500;
            text-align: left;
            flex-shrink: 0;
        }

        .currency-display .currency-amount {
            font-weight: 500;
            color: #583e04;
            text-align: right;
            flex-shrink: 0;
        }

        .currency-symbol {
            font-size: 14px;
            color: #6b7280;
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
            padding: 12px 8px;
            border: 1px solid #d1d5db;
            text-align: center;
            vertical-align: middle;
        }

        .stock-table tr:nth-child(even) {
            background-color: white;
        }

        .stock-table tr:hover {
            background-color: #e5ebf8ff;
        }

        /* 固定表格列宽 */
        .stock-table th:nth-child(1), .stock-table td:nth-child(1) { width: 80px; }  /* No. */
        .stock-table th:nth-child(2), .stock-table td:nth-child(2) { width: 120px; } /* Code Number */
        .stock-table th:nth-child(3), .stock-table td:nth-child(3) { width: 200px; } /* Product Name */
        .stock-table th:nth-child(4), .stock-table td:nth-child(4) { width: 120px; } /* Total Stock */
        .stock-table th:nth-child(5), .stock-table td:nth-child(5) { width: 100px; } /* Specification */
        .stock-table th:nth-child(6), .stock-table td:nth-child(6) { width: 120px; } /* Unit Price */
        .stock-table th:nth-child(7), .stock-table td:nth-child(7) { width: 120px; } /* Total Price */

        .table-container {
            background: white;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(88, 62, 4, 0.1);
            border: 2px solid #583e04;
            overflow: visible;
        }

        .table-scroll-container {
            overflow-x: auto;
            overflow-y: visible;
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
            color: #10b981;
            font-weight: 600;
        }

        .zero-value {
            color: #6b7280;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #6b7280;
            font-style: italic;
        }

        .no-data i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
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

        .total-row {
            background: #f8f5eb !important;
            border-top: 2px solid #583e04;
            font-weight: 600;
            color: #583e04;
        }

        /* 总库存价值专用的货币显示样式 */
        .summary-currency-display {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .summary-currency-display .currency-symbol {
            font-size: 32px;
            font-weight: bold;
            color: #583e04;
        }

        .summary-currency-display .value {
            font-size: 32px;
            font-weight: 700;
            color: #10b981;
        }

        /* 主要内容行布局 */
        .main-content-row {
            display: flex;
            gap: 24px;
            margin-bottom: 24px;
            align-items: stretch;
        }

        /* 左侧总库存区域 */
        .summary-section {
            flex: 0 0 400px;
            min-width: 400px;
            display: flex;
            flex-direction: column;
        }

        /* 右侧搜索过滤区域 */
        .filter-section {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        /* 总库存卡片样式调整 */
        .summary-section .summary-card {
            width: 100%;
            margin-bottom: 24px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* 价格单元格样式 */
        .stock-table td.price-cell {
            padding: 0;
            text-align: left;
        }

        .stock-table td.stock-cell {
            padding: 0;
            text-align: center;
        }

        .stock-cell .currency-display {
            justify-content: center;
        }

        /* 确保价格单元格内容填满 */
        .price-cell .currency-display {
            width: 100%;
            margin: 0;
        }

        /* 价格分析专用样式 */
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
            table-layout: fixed;
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

        .price-variants-table th:nth-child(1) { width: 10%; }
        .price-variants-table th:nth-child(2) { width: 30%; }
        .price-variants-table th:nth-child(3) { width: 30%; }
        .price-variants-table th:nth-child(4) { width: 30%; }

        .price-variants-table td:nth-child(1) { width: 10%; }
        .price-variants-table td:nth-child(2) { width: 30%; }
        .price-variants-table td:nth-child(3) { width: 30%; }
        .price-variants-table td:nth-child(4) { width: 30%; }

        .price-variants-table tr:hover {
            background-color: #f9fafb;
        }

        .highest-price {
            background-color: #fef3c7 !important;
            font-weight: 600;
        }

        .highest-price .currency-amount {
            color: #dc2626;
            font-weight: 700;
        }

        /* 页面切换 */
        .page-section {
            display: none;
        }

        .page-section.active {
            display: block;
        }

        /* 回到顶部按钮 */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 20px;
            width: 50px;
            height: 50px;
            background-color: #583e04;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            box-shadow: 0 4px 12px rgba(88, 62, 4, 0.3);
            transition: all 0.3s ease;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            z-index: 1000;
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .back-to-top:hover {
            background-color: #462d03;
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(88, 62, 4, 0.4);
        }

        .back-to-top:active {
            transform: translateY(-1px);
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
            min-width: 120px;
        }

        .low-stock-modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease-out;
        }

        .low-stock-modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 0;
            border: none;
            border-radius: 12px;
            width: 80%;
            max-width: 800px;
            max-height: 80vh;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease-out;
        }

        .low-stock-modal-header {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white;
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .low-stock-modal-header h2 {
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .close-modal {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
        }

        .close-modal:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .low-stock-modal-body {
            padding: 24px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .low-stock-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        .low-stock-table th,
        .low-stock-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .low-stock-table th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #374151;
        }

        .low-stock-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .stock-critical {
            color: #dc2626;
            font-weight: 600;
        }

        .stock-warning {
            color: #d97706;
            font-weight: 600;
        }

        .modal-footer {
            padding: 20px 24px;
            background-color: #f9fafb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e5e7eb;
        }

        .alert-summary {
            color: #6b7280;
            font-size: 14px;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { 
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
            to { 
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 16px;
                align-items: flex-start;
            }
            
            .main-content-row {
                flex-direction: column;
                gap: 16px;
            }
            
            .summary-section {
                flex: none;
                width: 100%;
                min-width: auto;
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

            .selector-dropdown {
                right: auto;
                left: 0;
            }

            .back-to-top {
                bottom: 20px;
                right: 20px;
                width: 45px;
                height: 45px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- 低库存预警弹窗 -->
    <div id="low-stock-modal" class="low-stock-modal">
        <div class="low-stock-modal-content">
            <div class="low-stock-modal-header">
                <h2>
                    <i class="fas fa-exclamation-triangle"></i>
                    库存不足预警
                </h2>
                <button class="close-modal" onclick="closeLowStockModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="low-stock-modal-body">
                <div id="low-stock-content">
                    <!-- Dynamic content -->
                </div>
            </div>
            <div class="modal-footer">
                <div class="alert-summary" id="alert-summary">
                    <!-- Summary info -->
                </div>
                <div>
                    <button class="btn btn-secondary" onclick="closeLowStockModal()" style="margin-right: 10px;">
                        <i class="fas fa-times"></i>
                        关闭
                    </button>
                    <button class="btn btn-primary" onclick="goToMinimumSettings()">
                        <i class="fas fa-cog"></i>
                        设置最低库存
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <div>
                <h1 id="page-title">总库存 - 中央</h1>
            </div>
            <div class="controls">
                <div class="view-selector">
                    <button class="selector-button" onclick="toggleViewSelector()">
                        <span id="current-view">总库存</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="selector-dropdown" id="view-selector-dropdown">
                        <div class="dropdown-item active" onclick="switchView('list')">总库存</div>
                        <div class="dropdown-item" onclick="switchView('records')">进出货</div>
                        <div class="dropdown-item" onclick="switchView('remark')">货品备注</div>
                    </div>
                </div>
                <div class="system-selector">
                    <button class="selector-button" onclick="toggleSelector()">
                        <span id="current-system">中央</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="selector-dropdown" id="selector-dropdown">
                        <div class="dropdown-item active" onclick="switchSystem('central')">中央</div>
                        <div class="dropdown-item" onclick="switchSystem('j1')">J1</div>
                        <div class="dropdown-item" onclick="switchSystem('j2')">J2</div>
                    </div>
                </div>
                <button class="back-button" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i>
                    返回仪表盘
                </button>
            </div>
        </div>
        
        <!-- Alert Messages -->
        <div id="alert-container"></div>
        
        <!-- 中央库存页面 -->
        <div id="central-page" class="page-section active">
            <div class="main-content-row">
                <div class="summary-section">
                    <div class="summary-card total-value">
                        <h3>总库存</h3>
                        <div class="summary-currency-display">
                            <span class="currency-symbol">RM</span>
                            <span class="value" id="central-total-value">0.00</span>
                        </div>
                    </div>
                </div>
                
                <div class="filter-section">
                    <div class="filter-grid">
                        <div class="filter-group">
                            <label for="central-product-filter">货品名称</label>
                            <input type="text" id="central-product-filter" class="filter-input" placeholder="搜索货品名称...">
                        </div>
                        <div class="filter-group">
                            <label for="central-code-filter">货品编号</label>
                            <input type="text" id="central-code-filter" class="filter-input" placeholder="搜索货品编号...">
                        </div>
                        <div class="filter-group">
                            <label for="central-spec-filter">规格单位</label>
                            <input type="text" id="central-spec-filter" class="filter-input" placeholder="搜索规格单位...">
                        </div>
                    </div>
                    <div class="filter-actions">
                        <button class="btn btn-primary" onclick="searchData('central')">
                            <i class="fas fa-search"></i>
                            搜索
                        </button>
                        <button class="btn btn-secondary" onclick="resetFilters('central')">
                            <i class="fas fa-refresh"></i>
                            重置
                        </button>
                        <button class="btn btn-warning" onclick="exportData('central')">
                            <i class="fas fa-download"></i>
                            导出CSV
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <div class="action-buttons">
                    <div class="stats-info" id="central-stock-stats">
                        <div class="stat-item">
                            <i class="fas fa-chart-bar"></i>
                            <span>显示记录: <span class="stat-value" id="central-displayed-records">0</span></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-boxes"></i>
                            <span>总记录: <span class="stat-value" id="central-total-records">0</span></span>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 12px;">
                        <button class="btn btn-primary" onclick="refreshData('central')">
                            <i class="fas fa-sync-alt"></i>
                            刷新数据
                        </button>
                    </div>
                </div>
                
                <div class="table-scroll-container">
                    <table class="stock-table" id="central-stock-table">
                        <thead>
                            <tr>
                                <th>序号.</th>
                                <th>货品编号</th>
                                <th>货品</th>
                                <th>库存数量</th>
                                <th>规格</th>
                                <th>单价</th>
                                <th>总价</th>
                            </tr>
                        </thead>
                        <tbody id="central-stock-tbody">
                            <!-- Dynamic content -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- J1库存页面 -->
        <div id="j1-page" class="page-section">
            <div class="main-content-row">
                <div class="summary-section">
                    <div class="summary-card total-value">
                        <h3>J1总库存</h3>
                        <div class="summary-currency-display">
                            <span class="currency-symbol">RM</span>
                            <span class="value" id="j1-total-value">0.00</span>
                        </div>
                    </div>
                </div>
                
                <div class="filter-section">
                    <div class="filter-grid">
                        <div class="filter-group">
                            <label for="j1-product-filter">货品名称</label>
                            <input type="text" id="j1-product-filter" class="filter-input" placeholder="搜索货品名称...">
                        </div>
                        <div class="filter-group">
                            <label for="j1-code-filter">货品编号</label>
                            <input type="text" id="j1-code-filter" class="filter-input" placeholder="搜索货品编号...">
                        </div>
                        <div class="filter-group">
                            <label for="j1-spec-filter">规格单位</label>
                            <input type="text" id="j1-spec-filter" class="filter-input" placeholder="搜索规格单位...">
                        </div>
                    </div>
                    <div class="filter-actions">
                        <button class="btn btn-primary" onclick="searchData('j1')">
                            <i class="fas fa-search"></i>
                            搜索
                        </button>
                        <button class="btn btn-secondary" onclick="resetFilters('j1')">
                            <i class="fas fa-refresh"></i>
                            重置
                        </button>
                        <button class="btn btn-warning" onclick="exportData('j1')">
                            <i class="fas fa-download"></i>
                            导出CSV
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <div class="action-buttons">
                    <div class="stats-info" id="j1-stock-stats">
                        <div class="stat-item">
                            <i class="fas fa-chart-bar"></i>
                            <span>显示记录: <span class="stat-value" id="j1-displayed-records">0</span></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-boxes"></i>
                            <span>总记录: <span class="stat-value" id="j1-total-records">0</span></span>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 12px;">
                        <button class="btn btn-primary" onclick="refreshData('j1')">
                            <i class="fas fa-sync-alt"></i>
                            刷新数据
                        </button>
                    </div>
                </div>
                
                <div class="table-scroll-container">
                    <table class="stock-table" id="j1-stock-table">
                        <thead>
                            <tr>
                                <th>序号.</th>
                                <th>货品编号</th>
                                <th>货品</th>
                                <th>库存总量</th>
                                <th>规格</th>
                                <th>单价</th>
                                <th>总价</th>
                            </tr>
                        </thead>
                        <tbody id="j1-stock-tbody">
                            <!-- Dynamic content -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- J2库存页面 -->
        <div id="j2-page" class="page-section">
            <div class="main-content-row">
                <div class="summary-section">
                    <div class="summary-card total-value">
                        <h3>J2总库存</h3>
                        <div class="summary-currency-display">
                            <span class="currency-symbol">RM</span>
                            <span class="value" id="j2-total-value">0.00</span>
                        </div>
                    </div>
                </div>
                
                <div class="filter-section">
                    <div class="filter-grid">
                        <div class="filter-group">
                            <label for="j2-product-filter">货品名称</label>
                            <input type="text" id="j2-product-filter" class="filter-input" placeholder="搜索货品名称...">
                        </div>
                        <div class="filter-group">
                            <label for="j2-code-filter">货品编号</label>
                            <input type="text" id="j2-code-filter" class="filter-input" placeholder="搜索货品编号...">
                        </div>
                        <div class="filter-group">
                            <label for="j2-spec-filter">规格单位</label>
                            <input type="text" id="j2-spec-filter" class="filter-input" placeholder="搜索规格单位...">
                        </div>
                    </div>
                    <div class="filter-actions">
                        <button class="btn btn-primary" onclick="searchData('j2')">
                            <i class="fas fa-search"></i>
                            搜索
                        </button>
                        <button class="btn btn-secondary" onclick="resetFilters('j2')">
                            <i class="fas fa-refresh"></i>
                            重置
                        </button>
                        <button class="btn btn-warning" onclick="exportData('j2')">
                            <i class="fas fa-download"></i>
                            导出CSV
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <div class="action-buttons">
                    <div class="stats-info" id="j2-stock-stats">
                        <div class="stat-item">
                            <i class="fas fa-chart-bar"></i>
                            <span>显示记录: <span class="stat-value" id="j2-displayed-records">0</span></span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-boxes"></i>
                            <span>总记录: <span class="stat-value" id="j2-total-records">0</span></span>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 12px;">
                        <button class="btn btn-primary" onclick="refreshData('j2')">
                            <i class="fas fa-sync-alt"></i>
                            刷新数据
                        </button>
                    </div>
                </div>
                
                <div class="table-scroll-container">
                    <table class="stock-table" id="j2-stock-table">
                        <thead>
                            <tr>
                                <th>序号.</th>
                                <th>货品编号</th>
                                <th>货品</th>
                                <th>库存总量</th>
                                <th>规格</th>
                                <th>单价</th>
                                <th>总价</th>
                            </tr>
                        </thead>
                        <tbody id="j2-stock-tbody">
                            <!-- Dynamic content -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 价格分析页面 -->
        <div id="remark-page" class="page-section">
            <div class="filter-section">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label for="remark-product-filter">货品名称</label>
                        <input type="text" id="remark-product-filter" class="filter-input" placeholder="搜索货品名称...">
                    </div>
                    <div class="filter-group">
                        <label for="remark-code-filter">货品编号</label>
                        <input type="text" id="remark-code-filter" class="filter-input" placeholder="搜索货品编号...">
                    </div>
                    <div class="filter-group">
                        <label for="remark-min-variants">最少价格数量</label>
                        <select id="remark-min-variants" class="filter-select">
                            <option value="">全部</option>
                            <option value="2">2个或以上</option>
                            <option value="3">3个或以上</option>
                            <option value="4">4个或以上</option>
                            <option value="5">5个或以上</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="remark-sort-by">排序方式</label>
                        <select id="remark-sort-by" class="filter-select">
                            <option value="name_asc">货品名称 A-Z</option>
                            <option value="name_desc">货品名称 Z-A</option>
                            <option value="variants_desc">价格数量 (多-少)</option>
                            <option value="variants_asc">价格数量 (少-多)</option>
                            <option value="price_diff_desc">价格差异 (大-小)</option>
                            <option value="price_diff_asc">价格差异 (小-大)</option>
                        </select>
                    </div>
                </div>
                <div class="filter-actions">
                    <button class="btn btn-primary" onclick="searchData('remark')">
                        <i class="fas fa-search"></i>
                        搜索
                    </button>
                    <button class="btn btn-secondary" onclick="resetFilters('remark')">
                        <i class="fas fa-refresh"></i>
                        重置
                    </button>
                    <button class="btn btn-success" onclick="refreshData('remark')">
                        <i class="fas fa-sync-alt"></i>
                        刷新数据
                    </button>
                    <button class="btn btn-warning" onclick="exportData('remark')">
                        <i class="fas fa-download"></i>
                        导出CSV
                    </button>
                </div>
            </div>

            <div id="remark-products-container">
                <!-- Dynamic content -->
            </div>
        </div>
    </div>

    <!-- 回到顶部按钮 -->
    <button class="back-to-top" id="back-to-top-btn" onclick="scrollToTop()" title="回到顶部">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>
        // 全局状态
        let currentSystem = 'central';
        let stockData = {
            central: [],
            j1: [],
            j2: [],
            remark: []
        };
        let filteredData = {
            central: [],
            j1: [],
            j2: [],
            remark: []
        };
        let isLoading = {
            central: false,
            j1: false,
            j2: false,
            remark: false
        };
        let currentView = 'list';

        const VIEW_NAMES = {
            list: '总库存',
            records: '进出货',
            remark: '货品备注'
        };

        // API配置
        const API_CONFIG = {
            central: 'stocklistapi.php',
            j1: 'j1stocklistapi.php',
            j2: 'j2stocklistapi.php',
            remark: 'stockremarkapi.php'
        };

        const SYSTEM_NAMES = {
            central: '中央',
            j1: 'J1',
            j2: 'J2',
            remark: '货品备注'
        };

        const PAGE_TITLES = {
            central: '总库存 - 中央',
            j1: '总库存 - J1',
            j2: '总库存 - J2',
            remark: '货品备注'
        };

        // 初始化应用
        function initApp() {
            loadData(currentSystem);
            checkLowStockAlerts(); // 添加这一行
            
            // 点击外部关闭下拉菜单
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.system-selector')) {
                    document.getElementById('selector-dropdown').classList.remove('show');
                }
                if (!e.target.closest('.view-selector')) {
                    document.getElementById('view-selector-dropdown').classList.remove('show');
                }
            });
        }

        // 切换系统选择器
        function toggleSelector() {
            document.getElementById('selector-dropdown').classList.toggle('show');
        }

        // 切换系统
        function switchSystem(system) {
            if (system === currentSystem) return;
            
            currentSystem = system;
            
            // 更新UI
            document.getElementById('current-system').textContent = SYSTEM_NAMES[system];
            document.getElementById('page-title').textContent = PAGE_TITLES[system];
            
            // 更新下拉菜单激活状态
            document.querySelectorAll('.dropdown-item').forEach(item => {
                item.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // 切换页面
            document.querySelectorAll('.page-section').forEach(page => {
                page.classList.remove('active');
            });
            document.getElementById(system + '-page').classList.add('active');
            
            // 隐藏下拉菜单
            document.getElementById('selector-dropdown').classList.remove('show');
            
            // 加载数据
            loadData(system);
        }

        // 切换视图选择器
        function toggleViewSelector() {
            document.getElementById('view-selector-dropdown').classList.toggle('show');
        }

        function switchView(view) {
            if (view === currentView) return;
            
            if (view === 'records') {
                // 跳转到库存记录页面
                window.location.href = 'stockeditall.php';
                return;
            }
            
            if (view === 'remark') {
                // 跳转到Remark页面
                window.location.href = 'stockremark.php';
                return;
            }
            
            currentView = view;
            
            // 更新UI
            document.getElementById('current-view').textContent = VIEW_NAMES[view];
            
            // 更新下拉菜单激活状态
            document.querySelectorAll('#view-selector-dropdown .dropdown-item').forEach(item => {
                item.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // 隐藏下拉菜单
            document.getElementById('view-selector-dropdown').classList.remove('show');
        }

        // 返回仪表盘
        function goBack() {
            window.location.href = 'dashboard.php';
        }

        // API调用函数
        async function apiCall(system, endpoint, options = {}) {
            try {
                const baseUrl = API_CONFIG[system];
                const response = await fetch(`${baseUrl}${endpoint}`, {
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

        // 加载数据
        async function loadData(system) {
            if (isLoading[system]) return;
            
            isLoading[system] = true;
            setLoadingState(system, true);
            
            try {
                let result;
                if (system === 'remark') {
                    result = await apiCall(system, '?action=analysis');
                } else {
                    result = await apiCall(system, '?action=summary');
                }
                
                if (result.success) {
                    if (system === 'remark') {
                        stockData[system] = result.data.products || [];
                    } else {
                        stockData[system] = result.data.summary || [];
                        updateSummaryCards(system, result.data);
                    }
                    
                    filteredData[system] = [...stockData[system]];
                    
                    if (system === 'remark') {
                        renderRemarkProducts();
                    } else {
                        renderStockTable(system);
                        updateStats(system);
                    }
                    
                    if (stockData[system].length === 0) {
                        let message = system === 'remark' ? 
                            '当前没有发现多价格货品' : 
                            `当前没有${SYSTEM_NAMES[system]}数据`;
                        showAlert(message, 'info');
                    }
                } else {
                    stockData[system] = [];
                    filteredData[system] = [];
                    showAlert('获取数据失败: ' + (result.message || '未知错误'), 'error');
                    
                    if (system === 'remark') {
                        renderRemarkProducts();
                    } else {
                        renderStockTable(system);
                    }
                }
                
            } catch (error) {
                stockData[system] = [];
                filteredData[system] = [];
                showAlert('网络错误，请检查连接', 'error');
                
                if (system === 'remark') {
                    renderRemarkProducts();
                } else {
                    renderStockTable(system);
                }
            } finally {
                isLoading[system] = false;
                setLoadingState(system, false);
            }
        }

        // 搜索数据
        function searchData(system) {
            if (system === 'remark') {
                searchRemarkData();
                return;
            }

            const productFilter = document.getElementById(`${system}-product-filter`).value.toLowerCase();
            const codeFilter = document.getElementById(`${system}-code-filter`).value.toLowerCase();
            const specFilter = document.getElementById(`${system}-spec-filter`).value.toLowerCase();

            filteredData[system] = stockData[system].filter(item => {
                const matchProduct = !productFilter || item.product_name.toLowerCase().includes(productFilter);
                const matchCode = !codeFilter || (item.code_number && item.code_number.toLowerCase().includes(codeFilter));
                const matchSpec = !specFilter || (item.specification && item.specification.toLowerCase().includes(specFilter));

                return matchProduct && matchCode && matchSpec;
            });

            renderStockTable(system);
            updateStats(system);
            
            if (filteredData[system].length === 0) {
                showAlert('未找到匹配的记录', 'info');
            } else {
                showAlert(`找到 ${filteredData[system].length} 条匹配记录`, 'success');
            }
        }

        // 搜索价格分析数据
        function searchRemarkData() {
            const productFilter = document.getElementById('remark-product-filter').value.toLowerCase();
            const codeFilter = document.getElementById('remark-code-filter').value.toLowerCase();
            const minVariants = parseInt(document.getElementById('remark-min-variants').value) || 0;
            const sortBy = document.getElementById('remark-sort-by').value;

            // 过滤数据
            filteredData.remark = stockData.remark.filter(item => {
                const matchProduct = !productFilter || item.product_name.toLowerCase().includes(productFilter);
                const matchCode = !codeFilter || (item.code_number && item.code_number.toLowerCase().includes(codeFilter));
                const matchVariants = item.variants.length >= minVariants;

                return matchProduct && matchCode && matchVariants;
            });

            // 排序数据
            sortRemarkData(sortBy);
            renderRemarkProducts();
            
            if (filteredData.remark.length === 0) {
                showAlert('未找到匹配的记录', 'info');
            } else {
                showAlert(`找到 ${filteredData.remark.length} 个匹配货品`, 'success');
            }
        }

        // 排序价格分析数据
        function sortRemarkData(sortBy) {
            switch (sortBy) {
                case 'name_asc':
                    filteredData.remark.sort((a, b) => a.product_name.localeCompare(b.product_name));
                    break;
                case 'name_desc':
                    filteredData.remark.sort((a, b) => b.product_name.localeCompare(a.product_name));
                    break;
                case 'variants_desc':
                    filteredData.remark.sort((a, b) => b.variants.length - a.variants.length);
                    break;
                case 'variants_asc':
                    filteredData.remark.sort((a, b) => a.variants.length - b.variants.length);
                    break;
                case 'price_diff_desc':
                    filteredData.remark.sort((a, b) => b.price_difference - a.price_difference);
                    break;
                case 'price_diff_asc':
                    filteredData.remark.sort((a, b) => a.price_difference - b.price_difference);
                    break;
            }
        }

        // 重置搜索过滤器
        function resetFilters(system) {
            if (system === 'remark') {
                document.getElementById('remark-product-filter').value = '';
                document.getElementById('remark-code-filter').value = '';
                document.getElementById('remark-min-variants').value = '';
                document.getElementById('remark-sort-by').value = 'name_asc';
                
                filteredData.remark = [...stockData.remark];
                sortRemarkData('name_asc');
                renderRemarkProducts();
            } else {
                document.getElementById(`${system}-product-filter`).value = '';
                document.getElementById(`${system}-code-filter`).value = '';
                document.getElementById(`${system}-spec-filter`).value = '';
                
                filteredData[system] = [...stockData[system]];
                renderStockTable(system);
                updateStats(system);
            }
            
            showAlert('搜索条件已重置', 'info');
        }

        // 设置加载状态
        function setLoadingState(system, loading) {
            if (system === 'remark') {
                const container = document.getElementById('remark-products-container');
                if (loading) {
                    container.innerHTML = `
                        <div style="text-align: center; padding: 60px;">
                            <div class="loading"></div>
                            <div style="margin-top: 16px; color: #6b7280;">正在分析库存价格数据...</div>
                        </div>
                    `;
                }
            } else {
                const tbody = document.getElementById(`${system}-stock-tbody`);
                if (loading) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="7" style="padding: 40px; text-align: center;">
                                <div class="loading"></div>
                                <div style="margin-top: 16px; color: #6b7280;">正在加载${SYSTEM_NAMES[system]}数据...</div>
                            </td>
                        </tr>
                    `;
                }
            }
        }

        // 更新汇总卡片
        function updateSummaryCards(system, data) {
            document.getElementById(`${system}-total-value`).textContent = data.formatted_total_value || '0.00';
        }

        // 更新统计信息
        function updateStats(system) {
            const displayedRecords = filteredData[system].length;
            const totalRecords = stockData[system].length;
            
            document.getElementById(`${system}-displayed-records`).textContent = displayedRecords;
            document.getElementById(`${system}-total-records`).textContent = totalRecords;
        }

        // 渲染库存表格
        function renderStockTable(system) {
            const tbody = document.getElementById(`${system}-stock-tbody`);
            
            if (filteredData[system].length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="no-data">
                            <i class="fas fa-inbox"></i>
                            <div>暂无${SYSTEM_NAMES[system]}数据</div>
                        </td>
                    </tr>
                `;
                return;
            }
            
            let totalValue = 0;
            let tableRows = '';
            
            filteredData[system].forEach((item, index) => {
                const stockValue = parseFloat(item.total_stock) || 0;
                const priceValue = parseFloat(item.total_price) || 0;
                const stockClass = stockValue > 0 ? 'positive-value' : 'zero-value';
                const priceClass = priceValue > 0 ? 'positive-value' : 'zero-value';
                
                tableRows += `
                    <tr>
                        <td class="text-center">${item.no}</td>
                        <td class="text-center">${item.code_number || '-'}</td>
                        <td><strong>${item.product_name}</strong></td>
                        <td class="stock-cell">
                            <div class="currency-display ${stockClass}">
                                <span class="currency-symbol">&nbsp;</span>
                                <span class="currency-amount">${item.formatted_stock}</span>
                            </div>
                        </td>
                        <td class="text-center">${item.specification || '-'}</td>
                        <td class="price-cell">
                            <div class="currency-display">
                                <span class="currency-symbol">RM</span>
                                <span class="currency-amount">${item.formatted_price}</span>
                            </div>
                        </td>
                        <td class="price-cell">
                            <div class="currency-display ${priceClass}">
                                <span class="currency-symbol">RM</span>
                                <span class="currency-amount">${item.formatted_total_price}</span>
                            </div>
                        </td>
                    </tr>
                `;
                totalValue += priceValue;
            });
            
            // 添加总计行
            tableRows += `
                <tr class="total-row">
                    <td colspan="6" class="text-right" style="font-size: 16px; padding-right: 15px; text-align: right;">总计:</td>
                    <td class="price-cell positive-value" style="font-size: 16px;">
                        <div class="currency-display">
                            <span class="currency-symbol">RM</span>
                            <span class="currency-amount">${formatCurrency(totalValue)}</span>
                        </div>
                    </td>
                </tr>
            `;
            
            tbody.innerHTML = tableRows;
        }

        // 渲染价格分析货品列表
        function renderRemarkProducts() {
            const container = document.getElementById('remark-products-container');
            
            if (filteredData.remark.length === 0) {
                container.innerHTML = `
                    <div class="no-data">
                        <i class="fas fa-search"></i>
                        <h3>没有找到多价格货品</h3>
                        <p>当前筛选条件下没有发现货品有多个价格变体</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            
            filteredData.remark.forEach(product => {
                html += `
                    <div class="product-group">
                        <div class="product-header">
                            <span>${product.product_name}</span>
                            <span class="price-count">${product.variants.length} 个价格</span>
                        </div>
                        <table class="price-variants-table">
                            <thead>
                                <tr>
                                    <th>排序</th>
                                    <th>货品编号</th>
                                    <th>库存数量</th>
                                    <th>单价</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${renderVariants(product.variants, product.max_price)}
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

        // 格式化货币
        function formatCurrency(value) {
            if (!value || value === '' || value === '0') return '0.00';
            const num = parseFloat(value);
            return isNaN(num) ? '0.00' : num.toFixed(2);
        }

        // 刷新数据
        function refreshData(system) {
            loadData(system);
        }

        // 导出数据
        function exportData(system) {
            if (filteredData[system].length === 0) {
                showAlert('没有数据可导出', 'error');
                return;
            }
            
            try {
                let csvContent, fileName;
                
                if (system === 'remark') {
                    // 价格分析导出
                    const headers = ['Product Name', 'Rank', 'Code Number', 'Stock', 'Unit Price'];
                    csvContent = headers.join(',') + '\n';
                    
                    filteredData.remark.forEach(product => {
                        product.variants.forEach((variant, index) => {
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
                    
                    fileName = `stock_price_analysis_${new Date().toISOString().split('T')[0]}.csv`;
                } else {
                    // 库存汇总导出
                    const headers = ['No.', 'Product Name', 'Code Number', 'Total Stock', 'Specification', 'Unit Price', 'Total Price'];
                    csvContent = headers.join(',') + '\n';
                    
                    filteredData[system].forEach(item => {
                        const row = [
                            item.no,
                            `"${item.product_name}"`,
                            item.code_number || '',
                            item.formatted_stock,
                            item.specification || '',
                            item.formatted_price,
                            item.formatted_total_price
                        ];
                        csvContent += row.join(',') + '\n';
                    });
                    
                    fileName = `${system}_stock_summary_${new Date().toISOString().split('T')[0]}.csv`;
                }
                
                // 创建下载链接
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', fileName);
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

        // 页面加载完成后初始化
        document.addEventListener('DOMContentLoaded', initApp);

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
            // 使用防抖优化性能
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(function() {
                const backToTopBtn = document.getElementById('back-to-top-btn');
                const scrollThreshold = 150; // 滚动超过300px后显示按钮
                
                if (window.pageYOffset > scrollThreshold) {
                    backToTopBtn.classList.add('show');
                } else {
                    backToTopBtn.classList.remove('show');
                }
            }, 10);
        });

        // 键盘快捷键支持
        document.addEventListener('keydown', function(e) {
            // Ctrl+F 聚焦搜索框
            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                const activeFilterId = `${currentSystem}-product-filter`;
                const activeFilter = document.getElementById(activeFilterId);
                if (activeFilter) {
                    activeFilter.focus();
                }
            }
            
            // Escape键重置搜索
            if (e.key === 'Escape') {
                resetFilters(currentSystem);
            }

            // 数字键1-4快速切换系统
            if (e.ctrlKey && e.key >= '1' && e.key <= '4') {
                e.preventDefault();
                const systems = ['central', 'j1', 'j2', 'remark'];
                const systemIndex = parseInt(e.key) - 1;
                if (systems[systemIndex]) {
                    // 模拟点击切换
                    const dropdownItems = document.querySelectorAll('.dropdown-item');
                    if (dropdownItems[systemIndex]) {
                        switchSystem(systems[systemIndex]);
                    }
                }

                // Home键回到顶部
                    if (e.key === 'Home' && e.ctrlKey) {
                        e.preventDefault();
                        scrollToTop();
                    }
            }
        });

        // 定时刷新数据（每5分钟）
        setInterval(() => {
            if (!document.hidden) { // 只在页面可见时刷新
                loadData(currentSystem);
            }
        }, 300000); // 5分钟 = 300000毫秒

        // 检查低库存预警
        async function checkLowStockAlerts() {
            try {
                const result = await apiCall('central', '?action=low_stock_alerts');
                
                if (result.success && result.data.alerts && result.data.alerts.length > 0) {
                    showLowStockModal(result.data.alerts);
                }
            } catch (error) {
                console.error('检查低库存预警失败:', error);
            }
        }

        // 显示低库存弹窗
        function showLowStockModal(alerts) {
            const modal = document.getElementById('low-stock-modal');
            const content = document.getElementById('low-stock-content');
            const summary = document.getElementById('alert-summary');
            
            let html = `
                <div style="margin-bottom: 16px; padding: 12px; background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; color: #b91c1c;">
                    <i class="fas fa-exclamation-triangle" style="margin-right: 8px;"></i>
                    发现 ${alerts.length} 个货品库存不足，请及时补货！
                </div>
                <table class="low-stock-table">
                    <thead>
                        <tr>
                            <th>货品名称</th>
                            <th>货品编号</th>
                            <th>规格</th>
                            <th>当前库存</th>
                            <th>最低库存</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            alerts.forEach(alert => {
                const currentStock = parseFloat(alert.current_stock);
                const minimumStock = parseFloat(alert.minimum_quantity);
                
                let statusClass = 'stock-critical';
                if (currentStock <= 0) {
                    statusClass = 'stock-critical';
                } else if (currentStock <= minimumStock * 0.5) {
                    statusClass = 'stock-critical';
                } else {
                    statusClass = 'stock-warning';
                }
                
                html += `
                    <tr>
                        <td><strong>${alert.product_name}</strong></td>
                        <td>${alert.code_number || '-'}</td>
                        <td>${alert.specification || '-'}</td>
                        <td class="${statusClass}">${alert.formatted_stock}</td>
                        <td>${parseFloat(alert.minimum_quantity).toFixed(2)}</td>
                    </tr>
                `;
            });
            
            html += '</tbody></table>';
            
            content.innerHTML = html;
            summary.textContent = `共 ${alerts.length} 个货品库存不足`;
            modal.style.display = 'block';
        }

        // 关闭低库存弹窗
        function closeLowStockModal() {
            document.getElementById('low-stock-modal').style.display = 'none';
        }

        // 跳转到最低库存设置页面
        function goToMinimumSettings() {
            window.open('stockminimum.php', '_blank');
        }

        // 点击弹窗外部关闭
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('low-stock-modal');
            if (e.target === modal) {
                closeLowStockModal();
            }
        });
    </script>
</body>
</html>