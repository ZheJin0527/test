<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <link rel="icon" type="image/png" href="images/images/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>库存管理系统</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="animation.css" />
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
            padding: 20px 24px;
            height: 100vh; /* 设置容器高度为视口高度 */
            display: flex;
            flex-direction: column;
            overflow: hidden; /* 防止整个页面滚动 */
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
            padding: 13px 20px;
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
            gap: 0px;
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
            padding: 7px 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 13px;
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
            border: 1px solid #d1d5db;
            position: sticky;
            top: 0;
            z-index: 100;
            white-space: nowrap;
            min-width: 80px;
        }

        .stock-table td {
            padding: 0;
            border: 1px solid #d1d5db;
            text-align: center;
            position: relative;
        }

        /* 确保表格头部完全遮盖滚动的数据 */
        .stock-table thead {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #583e04;
        }

        .stock-table thead tr {
            position: sticky;
            top: 0;
            z-index: 100;
        }

        /* 确保表格容器占用剩余空间 */
        .table-container {
            flex: 1;
            overflow: hidden;
        }

        /* 防止新增表单影响布局 */
        .add-form {
            flex-shrink: 0; /* 不允许压缩 */
        }

        /* 响应式调整 */
        @media (max-width: 768px) {
            .table-container {
                height: calc(100vh - 500px);
                min-height: 300px;
            }
        }

        .stock-table tr:nth-child(even) {
            background-color: white;
        }

        .stock-table tr:hover {
            background-color: #e5ebf8ff;
        }

        /* 确保显示文本和编辑输入框对齐 */
        .stock-table td span {
            display: inline-block;
            width: 100%;
            height: 40px;
            line-height: 24px;
            padding: 8px 4px;
            box-sizing: border-box;
            vertical-align: middle;
            text-align: center;
            font-size: 14px;
        }

        /* 货币显示的特殊样式 */
        .stock-table td span[style*="padding-left: 32px"] {
            text-align: right;
            padding-left: 32px;
            padding-right: 8px;
        }

        /* 日期单元格内的文本对齐 */
        .date-cell {
            background: #f8f5eb !important;
            font-weight: 600;
            color: #583e04;
            padding: 12px 8px;
            min-width: 100px;
            text-align: center;
            vertical-align: middle;
        }

        /* 计算列内的文本对齐 */
        .calculated-cell {
            background: #f0f9ff !important;
            color: #0369a1;
            font-weight: 600;
            padding: 12px 8px;
            min-width: 100px;
            text-align: center;
            vertical-align: middle;
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
            box-sizing: border-box;
            vertical-align: middle;
            line-height: 24px; /* 保持行高一致 */
        }

        .table-input.currency-input {
            padding-left: 32px;
            text-align: center;
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
            box-sizing: border-box;
            vertical-align: middle;
            line-height: 24px; /* 保持行高一致 */
        }

        .table-select:focus {
            background: #fff;
            border: 2px solid #583e04;
            outline: none;
        }

        /* 货币显示容器 */
        .currency-display {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 8px 10px;
            height: 40px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .currency-display .currency-symbol {
            color: #6b7280;
            font-weight: 500;
            margin-right: 6px;
            min-width: 24px;
            text-align: left;
        }

        .currency-display .currency-amount {
            font-weight: 500;
            color: #583e04;
            text-align: center;
            min-width: 60px;
        }

        /* 输入框容器样式 */
        .input-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            width: 100%;
            height: 40px;
        }

        .currency-prefix {
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
            margin-right: 6px;
            min-width: 24px;
        }

        .table-input.currency-input {
            text-align: right;
            padding-left: 8px;
            padding-right: 4px;
            min-width: 60px;
            font-weight: 500;
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
        .stock-table th:nth-child(1), .stock-table td:nth-child(1) { width: 90px; } /* 日期 */
        .stock-table th:nth-child(2), .stock-table td:nth-child(2) { width: 100px; } /* 货品编号 */
        .stock-table th:nth-child(3), .stock-table td:nth-child(3) { width: 225px; } /* 货品 */
        .stock-table th:nth-child(4), .stock-table td:nth-child(4) { width: 70px; }  /* 进货 */
        .stock-table th:nth-child(5), .stock-table td:nth-child(5) { width: 70px; }  /* 出货 */
        .stock-table th:nth-child(6), .stock-table td:nth-child(6) { width: 80px; } /* 收货单位 */
        .stock-table th:nth-child(7), .stock-table td:nth-child(7) { width: 70px; } /* 规格 */
        .stock-table th:nth-child(8), .stock-table td:nth-child(8) { width: 100px; } /* 单价 */
        .stock-table th:nth-child(9), .stock-table td:nth-child(9) { width: 100px; } /* 总价 */
        .stock-table th:nth-child(10), .stock-table td:nth-child(10) { width: 80px; } /* 类型 */
        .stock-table th:nth-child(11), .stock-table td:nth-child(11) { width: 70px; } /* 产品备注 checkbox */
        .stock-table th:nth-child(12), .stock-table td:nth-child(12) { width: 80px; } /* 备注编号 */
        .stock-table th:nth-child(13), .stock-table td:nth-child(13) { width: 160px; } /* 名字/收货人 */
        .stock-table th:nth-child(14), .stock-table td:nth-child(14) { width: 140px; } /* 备注 */
        .stock-table th:nth-child(15), .stock-table td:nth-child(15) { width: 100px; } /* 操作 */

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

        /* 编辑状态下的价格输入框样式 */
        .currency-input-edit {
            text-align: right;
            padding: 8px 4px;
            min-width: 60px;
            font-weight: 500;
            border: none;
            background: transparent;
            font-size: 14px;
            box-sizing: border-box;
            vertical-align: middle;
            line-height: 24px;
        }

        .currency-input-edit:focus {
            background: #fff;
            border: 2px solid #583e04;
            outline: none;
            z-index: 15;
            position: relative;
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
            padding: 14px 24px;
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
            padding: 8px 4px;
            width: 100%;
            height: 40px;
            box-sizing: border-box;
        }

        /* 确保操作列的span容器也正确显示 */
        .stock-table td span.action-cell {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 8px 4px;
            width: 100%;
            height: 40px;
            line-height: normal;
            box-sizing: border-box;
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
            min-width: 120px;
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

        /* 负数括号样式 - 只对数字部分添加括号 */
        .negative-value.negative-parentheses .currency-amount::before {
            content: "(";
        }

        .negative-value.negative-parentheses .currency-amount::after {
            content: ")";
        }

        /* 确保负数的货币显示也是红色 */
        .negative-value .currency-symbol,
        .negative-value .currency-amount {
            color: #dc2626 !important;
            font-weight: 600;
        }

        /* 货品名称列稍宽 */
        .product-name-col {
            min-width: 150px !important;
        }

        .receiver-col {
            min-width: 120px !important;
        }

        /* 新增行样式 */
        .new-row {
            background-color: #f0f9ff !important;  
        }

        .new-row .table-input, .new-row .table-select {
            background: white;
        }

        /* 新增行样式 */
        .new-row {
            background-color: #e0f2fe !important;  /* 浅蓝色背景 */
        }

        .new-row td {
            background-color: #e0f2fe !important;
        }

        /* 编辑行样式 */
        .editing-row {
            background-color: #e0f2fe !important;  /* 与新增行相同的浅蓝色背景 */
        }

        .editing-row td {
            background-color: #e0f2fe !important;
        }

        /* 确保输入框背景透明，显示行的背景色 */
        .new-row .table-input, 
        .new-row .table-select,
        .new-row .currency-input-edit,
        .editing-row .table-input, 
        .editing-row .table-select,
        .editing-row .currency-input-edit {
            background: transparent !important;
        }

        /* 聚焦时的输入框样式 */
        .new-row .table-input:focus, 
        .new-row .table-select:focus,
        .new-row .currency-input-edit:focus,
        .editing-row .table-input:focus, 
        .editing-row .table-select:focus,
        .editing-row .currency-input-edit:focus {
            background: white !important;
        }

        .save-new-btn {
            background: #10b981 !important;
        }

        .cancel-new-btn {
            background: #6b7280 !important;
        }

        /* Combobox 样式 */
        .combobox-container {
            position: relative;
            width: 100%;
        }

        .combobox-input {
            width: 100%;
            height: 40px;
            border: none;
            background: transparent;
            text-align: center;
            font-size: 14px;
            padding: 8px 20px 8px 4px;
            transition: all 0.2s;
            box-sizing: border-box;
            cursor: text;
            ime-mode: disabled; /* 禁用输入法 */
            vertical-align: middle;
            line-height: 24px; /* 保持行高一致 */
        }

        .combobox-input:focus {
            background: #fff;
            border: 2px solid #583e04;
            outline: none;
            z-index: 15;
            position: relative;
        }

        .combobox-arrow {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6b7280;
            font-size: 12px;
        }

        .combobox-dropdown {
            position: fixed; /* 改为 fixed 定位，避免被表格限制 */
            background: white;
            border: 2px solid #583e04;
            border-radius: 4px;
            max-height: 300px;
            overflow-y: auto;
            z-index: 9999; /* 提高层级，确保显示在最前面 */
            display: none;
            box-shadow: 0 4px 12px rgba(88, 62, 4, 0.2);
            min-width: 200px; /* 设置最小宽度 */
        }

        .combobox-dropdown.show {
            display: block;
        }

        .combobox-option {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
            text-align: left;
        }

        .combobox-option:hover {
            background-color: #f3f4f6;
        }

        .combobox-option:last-child {
            border-bottom: none;
        }

        .combobox-option.highlighted {
            background-color: #583e04;
            color: white;
        }

        /* 输入框样式优化 */
        .combobox-input {
            width: 100%;
            height: 40px;
            border: none;
            background: transparent;
            text-align: center;
            font-size: 14px;
            padding: 8px 20px 8px 4px;
            transition: all 0.2s;
            box-sizing: border-box;
            cursor: text;
            ime-mode: disabled; /* 禁用输入法 */
        }

        .combobox-input:focus {
            background: #fff;
            border: 2px solid #583e04;
            outline: none;
            z-index: 15;
            position: relative;
        }

        /* 确保输入框可以正常输入 */
        .combobox-input::-ms-clear {
            display: none;
        }

        .no-results {
            padding: 8px 12px;
            color: #6b7280;
            font-style: italic;
            text-align: center;
        }

        /* 确保表格容器不会隐藏溢出内容 */
        .table-container {
            background: white;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(88, 62, 4, 0.1);
            border: 2px solid #583e04;
            overflow: visible;
            display: flex;
            flex-direction: column;
            height: calc(100vh - 400px); /* 设置固定高度 */
            min-height: 500px;
        }

        .table-container > div:first-child {
            overflow-x: auto; /* 只对内部滚动容器设置 overflow */
        }

        /* 为了确保水平滚动正常，添加一个内部容器 */
        .table-scroll-container {
            overflow-x: auto;
            overflow-y: auto;
            flex: 1;
            position: relative;
        }

        .price-select {
            min-width: 60px;
            background-color: white;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 2px 4px;
            font-size: 12px;
        }

        .manual-price-input {
            border: 1px solid #3b82f6 !important;
            border-radius: 4px;
        }

        /* 导出弹窗样式 */
        .export-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .export-modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 30px;
            border-radius: 12px;
            width: 450px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }

        .export-modal h3 {
            margin: 0 0 20px 0;
            color: #1f2937;
            font-size: 18px;
            font-weight: 600;
        }

        .export-form-group {
            margin-bottom: 16px;
        }

        .export-form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #374151;
            font-size: 14px;
        }

        .export-form-group input,
        .export-form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .export-form-group input:focus,
        .export-form-group select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .checkbox-group {
            display: flex;
            gap: 15px;
            margin-top: 8px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .checkbox-item input[type="checkbox"] {
            width: auto;
            margin: 0;
        }

        .export-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .close-export-modal {
            position: absolute;
            right: 15px;
            top: 15px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6b7280;
            padding: 5px;
        }

        .close-export-modal:hover {
            color: #374151;
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
            position: relative; /* 添加这个，因为下拉菜单需要 */
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
            border-radius: 8px;
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
            min-width: 120px;
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

        /* 在现有CSS中添加这些样式，替换原有的alert样式 */

        /* 通知容器 */
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 8px;
            pointer-events: none;
        }

        /* 通知基础样式 */
        .toast {
            min-width: 300px;
            max-width: 400px;
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            pointer-events: auto;
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }

        .toast.hide {
            transform: translateX(100%);
            opacity: 0;
        }

        /* 通知类型样式 */
        .toast-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.9), rgba(5, 150, 105, 0.9));
            color: white;
            border-color: rgba(16, 185, 129, 0.3);
        }

        .toast-error {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.9), rgba(220, 38, 38, 0.9));
            color: white;
            border-color: rgba(239, 68, 68, 0.3);
        }

        .toast-info {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.9), rgba(37, 99, 235, 0.9));
            color: white;
            border-color: rgba(59, 130, 246, 0.3);
        }

        .toast-warning {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.9), rgba(217, 119, 6, 0.9));
            color: white;
            border-color: rgba(245, 158, 11, 0.3);
        }

        /* 通知图标 */
        .toast-icon {
            font-size: 18px;
            flex-shrink: 0;
        }

        /* 通知内容 */
        .toast-content {
            flex: 1;
            font-weight: 500;
            line-height: 1.4;
        }

        /* 关闭按钮 */
        .toast-close {
            background: none;
            border: none;
            color: inherit;
            font-size: 16px;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            opacity: 0.8;
            transition: opacity 0.2s;
            flex-shrink: 0;
        }

        .toast-close:hover {
            opacity: 1;
            background: rgba(255, 255, 255, 0.1);
        }

        /* 进度条 */
        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 0 0 8px 8px;
            transform-origin: left;
            animation: toastProgress 4s linear forwards;
        }

        .batch-select-checkbox {
            transform: scale(1.2);
            margin: 0;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
            border: 1px solid #dc3545;
        }

        .btn-danger:hover {
            background: #c82333;
            border-color: #bd2130;
        }

        #confirm-batch-delete-btn:disabled {
            background: #6c757d;
            border-color: #6c757d;
            opacity: 0.6;
            cursor: not-allowed;
        }

        .search-row {
            display: flex;
            align-items: flex-end;
            gap: 20px;
            margin-bottom: 24px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            min-width: 150px;
        }

        .filter-group label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
            font-size: 14px;
        }

        .search-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .search-group label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
            font-size: 14px;
        }

        .unified-search-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .unified-search-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .unified-search-input::placeholder {
            color: #9ca3af;
        }

        .action-buttons-group {
            display: flex;
            gap: 12px;
        }

        @media (max-width: 1024px) {
            .search-row {
                flex-wrap: wrap;
            }
            
            .action-buttons-group {
                width: 100%;
                justify-content: flex-start;
            }
        }

        @media (max-width: 768px) {
            .search-row {
                flex-direction: column;
                align-items: stretch;
                gap: 16px;
            }
            
            .filter-group,
            .search-group {
                width: 100%;
            }
        }

        .search-controls {
            display: flex;
            align-items: flex-end;
            gap: 0px;
            flex-wrap: wrap;
        }

        .search-controls .filter-group,
        .search-controls .search-group {
            display: flex;
            flex-direction: column;
            min-width: auto;
        }

        .search-controls label {
            font-weight: 600;
            color: #583e04;
            white-space: nowrap;
        }

        /* 日期过滤器样式 */
        .header-filter {
            display: flex;
            align-items: center; /* 改为水平对齐 */
            gap: 12px; /* 添加间距 */
            min-width: 140px;
            flex-shrink: 0;
        }

        .filter-input {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .filter-input:focus {
            outline: none;
            border-color: #583e04;
            box-shadow: 0 0 0 3px rgba(88, 62, 4, 0.1);
        }

        /* 批量操作按钮组 */
        .batch-actions {
            flex-shrink: 0;
        }

        /* 调整按钮大小，使其更紧凑 */
        .unified-header-row .btn {
            padding: 8px 12px;
            font-size: 13px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        /* 统一顶部行样式 - 进出货页面专用 */
        .unified-header-row {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 22px 24px;
            background: white;
            border-radius: 12px;
            margin-bottom: 24px;
            border: 2px solid #583e04;
            box-shadow: 0 2px 8px rgba(88, 62, 4, 0.1);
            flex-wrap: nowrap;
            justify-content: space-between;
        }

        .header-right-group {
            display: flex;
            align-items: flex-end;  /* 改为 flex-end，让元素底部对齐 */
            gap: 20px;
            margin-left: auto;
        }

        .search-label {
            font-size: 12px;
            font-weight: 600;
            color: #583e04;
            margin-bottom: 4px;
            display: block;
        }

        .header-search {
            flex: 1;
            min-width: 200px;
            max-width: 350px;
            display: flex;
            align-items: center; /* 改为水平对齐 */
            gap: 12px; /* 添加间距 */
        }

        .unified-search-input {
            width: 250px;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .filter-input {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .filter-input:focus, 
        .unified-search-input:focus {
            outline: none;
            border-color: #583e04;
            box-shadow: 0 0 0 3px rgba(88, 62, 4, 0.1);
        }

        /* 统计信息样式 */
        .header-stats {
            display: flex;
            flex-direction: column;
            gap: 4px;
            font-size: 12px;
            color: #6b7280;
            flex-shrink: 0;
            white-space: nowrap;
            padding-bottom: 8px;  /* 添加底部内边距来微调位置 */
        }

        .header-stats .stat-value {
            font-weight: bold;
            color: #583e04;
        }

        /* 按钮样式调整 */
        .unified-header-row .btn {
            padding: 8px 12px;
            font-size: 13px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        /* 批量操作按钮组 */
        .batch-actions {
            flex-shrink: 0;
            display: flex;
            gap: 8px;
        }

        /* 响应式调整 */
        @media (max-width: 1400px) {
            .unified-header-row {
                flex-wrap: wrap;
                gap: 12px;
            }
            
            .batch-actions {
                order: 3;
                width: 100%;
                justify-content: flex-start;
            }
        }

        @media (max-width: 1024px) {
            .header-search {
                order: 3;
                width: 100%;
                min-width: auto;
                max-width: none;
            }
            
            .header-stats {
                flex-direction: row;
                gap: 16px;
                min-width: auto;
            }
        }

        @media (max-width: 768px) {
            .unified-header-row {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }
            
            .header-filter,
            .header-stats {
                align-items: center;
                text-align: center;
            }
            
            .batch-actions {
                justify-content: center;
                order: initial;
                width: auto;
            }
        }

        /* 响应式调整 */
        @media (max-width: 1400px) {
            .unified-header-row {
                flex-wrap: wrap;
                gap: 12px;
            }
            
            .batch-actions {
                order: 3;
                width: 100%;
                justify-content: flex-start;
            }
        }

        @media (max-width: 1024px) {
            .header-search {
                order: 3;
                width: 100%;
                min-width: auto;
            }
            
            .header-stats {
                flex-direction: row;
                gap: 16px;
                min-width: auto;
            }
        }

        @media (max-width: 1200px) {
            .action-buttons {
                flex-direction: column;
                gap: 16px;
                align-items: stretch;
            }
            
            .search-controls {
                justify-content: flex-start;
            }
            
            .search-controls .search-group input {
                min-width: 250px;
            }
        }

        @media (max-width: 768px) {
            .search-controls {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }
            
            .search-controls .filter-group,
            .search-controls .search-group {
                width: 100%;
            }
            
            .search-controls .search-group input {
                min-width: auto;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="container">
        <div class="header">
            <div>
                <h1 id="page-title">进出货 - 中央</h1>
            </div>
            <div class="controls">
                <div class="view-selector">
                    <button class="selector-button" onclick="toggleViewSelector()">
                        <span id="current-view">进出货</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="selector-dropdown" id="view-selector-dropdown">
                        <div class="dropdown-item" onclick="switchView('list')">总库存</div>
                        <div class="dropdown-item active" onclick="switchView('records')">进出货</div>
                        <div class="dropdown-item" onclick="switchView('remark')">货品备注</div>
                    </div>
                </div>
                <div class="system-selector">
                    <button class="selector-button" onclick="toggleStockSelector()">
                        <span id="current-stock-type">中央</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="selector-dropdown" id="stock-dropdown">
                        <a href="#" class="dropdown-item active" onclick="switchStock('central', event); return false;" data-type="central">
                            中央
                        </a>
                        <a href="#" class="dropdown-item" onclick="switchStock('j1', event); return false;" data-type="j1">
                            J1
                        </a>
                        <a href="#" class="dropdown-item" onclick="switchStock('j2', event); return false;" data-type="j2">
                            J2
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Alert Messages -->
        <div id="alert-container"></div>

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
                    <label for="add-product-name">货品名称 *</label>
                    <select id="add-product-name" class="form-select" onchange="handleProductChange(this, document.getElementById('add-code-number'))" required>
                        <option value="">请选择货品名称</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="add-in-qty">入库数量</label>
                    <input type="number" id="add-in-qty" class="form-input" min="0" step="0.001" placeholder="0.000" oninput="handleAddFormOutQuantityChange()">
                </div>
                <div class="form-group">
                    <label for="add-out-qty">出库数量</label>
                    <input type="number" id="add-out-qty" class="form-input" min="0" step="0.001" placeholder="0.000" oninput="handleAddFormOutQuantityChange()">
                </div>
                <select id="add-target" class="form-select" disabled>
                    <option value="">请选择</option>
                    ${generateTargetOptions()}
                </select>
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
                    <label for="add-price">单价</label>
                    <div class="currency-display" style="border: 1px solid #d1d5db; border-radius: 8px; background: white;">
                        <span class="currency-symbol">RM</span>
                        <select id="add-price-select" class="form-select" style="border: none; background: transparent; display: none;" onchange="handleAddFormPriceChange()">
                            <option value="">请先选择货品</option>
                        </select>
                        <input type="number" id="add-price" class="currency-input-edit" min="0" step="0.01" placeholder="0.00" style="border: none; background: transparent;">
                    </div>
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
                    <select id="add-code-number" class="form-select" onchange="handleCodeNumberChange(this, document.getElementById('add-product-name'))">
                        <option value="">请选择编号</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="add-remark">备注</label>
                    <input type="text" id="add-remark" class="form-input" placeholder="输入备注...">
                </div>
                <div class="form-group" id="type-form-group">
                    <label for="add-type">类型</label>
                    <select id="add-type" class="form-select">
                        <option value="">请选择类型</option>
                        <option value="Kitchen">Kitchen</option>
                        <option value="SushiBar">SushiBar</option>
                        <option value="Drink">Drink</option>
                        <option value="Sake">Sake</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="add-product-remark">货品备注</label>
                    <input type="checkbox" id="add-product-remark" onchange="toggleRemarkNumber()">
                </div>
                <div class="form-group">
                    <label for="add-remark-number">备注编号</label>
                    <div class="remark-number-input-wrapper" style="display: flex; align-items: center; border: 1px solid #d1d5db; border-radius: 8px; background: white; padding: 0;" id="add-remark-wrapper">
                        <input type="text" id="add-remark-prefix" class="form-input" placeholder="" style="border: none; border-radius: 8px 0 0 8px; width: 30px; text-align: center; background: transparent;" disabled>
                        <span style="padding: 0 4px; color: #6b7280; font-weight: bold;">-</span>
                        <input type="text" id="add-remark-suffix" class="form-input" placeholder="" style="border: none; border-radius: 0 8px 8px 0; width: 30px; text-align: center; background: transparent;" disabled>
                    </div>
                    <input type="hidden" id="add-remark-number">
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

        <div class="unified-header-row">
            <div class="header-filter">
                <span style="font-size: 14px; font-weight: 600; color: #583e04; white-space: nowrap;">日期</span>
                <input type="date" id="date-filter" class="filter-input">
            </div>
            
            <div class="header-right-group">
                <div class="header-search">
                    <span style="font-size: 14px; font-weight: 600; color: #583e04; white-space: nowrap;">搜索</span>
                    <input type="text" id="unified-filter" class="unified-search-input" 
                        placeholder="搜索货品编号、货品名称或收货人...">
                </div>
                
                <button class="btn btn-success" onclick="addNewRow()">
                    <i class="fas fa-plus"></i>
                    新增记录
                </button>
                
                <button class="btn btn-warning" onclick="exportData()">
                    <i class="fas fa-download"></i>
                    导出数据
                </button>
                
                <div class="batch-actions" style="display: flex; gap: 8px;">
                    <button class="btn btn-danger" id="batch-delete-btn" onclick="toggleBatchDelete()">
                        <i class="fas fa-trash-alt"></i>
                        批量删除
                    </button>
                    <button class="btn btn-success" id="confirm-batch-delete-btn" onclick="confirmBatchDelete()" style="display: none;">
                        <i class="fas fa-check"></i>
                        确认删除
                    </button>
                    <button class="btn btn-secondary" id="cancel-batch-delete-btn" onclick="cancelBatchDelete()" style="display: none;">
                        <i class="fas fa-times"></i>
                        取消
                    </button>
                </div>
                
                <div class="header-stats">
                    <span>总记录数: <span class="stat-value" id="total-records">0</span></span>
                </div>
            </div>
        </div>
        
        <!-- 库存表格 -->
        <div class="table-container">
            <div class="table-scroll-container">
            <table class="stock-table" id="stock-table">
                <thead>
                    <tr>
                        <th style="min-width: 100px;">日期</th>
                        <th style="min-width: 100px;">货品编号</th>
                        <th class="product-name-col">货品</th>
                        <th style="min-width: 80px;">进货</th>
                        <th style="min-width: 80px;">出货</th>
                        <th style="min-width: 100px;">收货单位</th>
                        <th style="min-width: 100px;">规格</th>
                        <th style="min-width: 100px;">单价</th>
                        <th style="min-width: 100px;">总价</th>
                        <th style="min-width: 80px;" id="type-header">类型</th>
                        <th style="min-width: 80px;">货品备注</th>
                        <th style="min-width: 100px;">备注编号</th>
                        <th class="receiver-col">名字</th>
                        <th style="min-width: 100px;">备注</th>
                        <th style="min-width: 80px;" id="action-header">操作</th>
                    </tr>
                </thead>
                <tbody id="stock-tbody">
                    <!-- 动态生成行 -->
                </tbody>
            </table>
            </div>
        </div>

        <!-- 导出数据弹窗 -->
        <div id="export-modal" class="export-modal">
            <div class="export-modal-content">
                <button class="close-export-modal" onclick="closeExportModal()">&times;</button>
                <h3>生成PDF发票</h3>
                
                <div class="export-form-group">
                    <label for="export-start-date">开始日期</label>
                    <input type="date" id="export-start-date" required>
                </div>
                
                <div class="export-form-group">
                    <label for="export-end-date">结束日期</label>
                    <input type="date" id="export-end-date" required>
                </div>
                
                <div class="export-form-group">
                    <label for="export-system">店面</label>
                    <select id="export-system" required onchange="handleExportSystemChange()">
                        <option value="">请选择系统</option>
                        <option value="j1">J1</option>
                        <option value="j2">J2</option>
                    </select>
                </div>

                <div class="export-form-group">
                    <label for="export-invoice-date">发票日期</label>
                    <input type="date" id="export-invoice-date">
                </div>

                
                <div class="export-modal-actions">
                    <button class="btn btn-secondary" onclick="closeExportModal()">
                        <i class="fas fa-times"></i>
                        取消
                    </button>
                    <button class="btn btn-success" onclick="confirmExport()">
                        <i class="fas fa-download"></i>
                        导出发票
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container" id="toast-container">
    <!-- 动态通知内容 -->
    </div>

    <!-- 回到顶部按钮 -->
    <button class="back-to-top" id="back-to-top-btn" onclick="scrollToTop()" title="回到顶部">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>
        // API 配置
        let API_BASE_URL = 'stockeditapi.php';
        let currentStockType = 'central';
        
        // 应用状态
        let stockData = [];
        let isLoading = false;
        let editingRowIds = new Set(); // 改为Set来存储多个正在编辑的行ID
        let originalEditData = new Map();
        // 批量删除状态
        let isBatchDeleteMode = false;
        let selectedRecords = new Set();

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
            loadCodeNumbers();
            loadProducts();
            
            // 添加实时搜索监听器
            setupRealTimeSearch();

            // 设置默认active状态
            document.querySelector('.selector-dropdown .dropdown-item[data-type="central"]').classList.add('active');

            // 设置默认active状态
            setTimeout(() => {
                const centralItem = document.querySelector('.selector-dropdown .dropdown-item[data-type="central"]');
                if (centralItem) {
                    centralItem.classList.add('active');
                }
            }, 100);

            // 控制Type字段的启用/禁用状态
            const typeSelect = document.getElementById('add-type');
            if (typeSelect) {
                if (currentStockType === 'central') {
                    typeSelect.disabled = true;
                    typeSelect.value = '';
                } else {
                    typeSelect.disabled = false;
                }
            }

            // 新增：初始化时根据当前系统类型控制导出按钮
            const exportButton = document.querySelector('.btn-warning[onclick="exportData()"]');
            if (exportButton) {
                if (currentStockType === 'central') {
                    exportButton.style.display = 'inline-block';
                } else {
                    exportButton.style.display = 'none';
                }
            }
        }

        // 设置实时搜索
        function setupRealTimeSearch() {
            const dateInput = document.getElementById('date-filter');
            const searchInput = document.getElementById('unified-filter');
            
            // 防抖处理，避免频繁搜索
            let debounceTimer;
            
            function handleSearch() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    searchData();
                }, 300); // 300ms延迟
            }
            
            if (dateInput) {
                dateInput.addEventListener('change', handleSearch);
            }
            
            if (searchInput) {
                searchInput.addEventListener('input', handleSearch);
            }
        }

        // 切换库存选择器下拉菜单
        function toggleStockSelector() {
            const dropdown = document.getElementById('stock-dropdown');
            dropdown.classList.toggle('show');
        }

        function switchStock(stockType, event = null) {
            currentStockType = stockType;
            
            // 更新API地址
            switch(stockType) {
                case 'central':
                    API_BASE_URL = 'stockeditapi.php';
                    document.getElementById('page-title').textContent = '进出货 - 中央';
                    document.getElementById('current-stock-type').textContent = '中央';
                    break;
                case 'j1':
                    API_BASE_URL = 'j1stockeditpageapi.php';
                    document.getElementById('page-title').textContent = '进出货 - J1';
                    document.getElementById('current-stock-type').textContent = 'J1';
                    break;
                case 'j2':
                    API_BASE_URL = 'j2stockeditpageapi.php';
                    document.getElementById('page-title').textContent = '进出货 - J2';
                    document.getElementById('current-stock-type').textContent = 'J2';
                    break;
            }

            const exportButton = document.querySelector('.btn-warning[onclick="exportData()"]');
            if (exportButton) {
                if (stockType === 'central') {
                    exportButton.style.display = 'inline-block';
                } else {
                    exportButton.style.display = 'none';
                }
            }

            // 修改Type列的控制 - 不要隐藏，而是控制禁用状态
            const typeHeader = document.getElementById('type-header');
            const typeFormGroup = document.getElementById('type-form-group');
            
            if (stockType === 'central') {
                // 中央页面：显示Type列但禁用表单字段
                if (typeHeader) typeHeader.style.display = 'table-cell';
                if (typeFormGroup) {
                    typeFormGroup.style.display = 'block';
                    const typeSelect = document.getElementById('add-type');
                    if (typeSelect) {
                        typeSelect.disabled = true;
                        typeSelect.value = '';
                    }
                }
            } else {
                // J1/J2页面：显示Type列并启用
                if (typeHeader) typeHeader.style.display = 'table-cell';
                if (typeFormGroup) {
                    typeFormGroup.style.display = 'block';
                    const typeSelect = document.getElementById('add-type');
                    if (typeSelect) {
                        typeSelect.disabled = false;
                    }
                }
            }
            
            // 更新active状态
            document.querySelectorAll('.selector-dropdown .dropdown-item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelector(`.selector-dropdown .dropdown-item[data-type="${stockType}"]`).classList.add('active');
            
            // 立即隐藏下拉菜单
            const dropdown = document.getElementById('stock-dropdown');
            if (dropdown) {
                dropdown.classList.remove('show');
            }

            // 阻止事件冒泡，防止全局点击事件重新显示下拉菜单
            if (event) {
                event.stopPropagation();
                event.preventDefault();
            }
            
            // 清空当前数据并重新加载
            stockData = [];
            editingRowIds.clear();
            if (originalEditData) {
                originalEditData.clear();
            }
            
            // 重新加载数据
            loadStockData();
            loadCodeNumbers();
            loadProducts();
        }

        // 切换视图选择器下拉菜单
        function toggleViewSelector() {
            const dropdown = document.getElementById('view-selector-dropdown');
            dropdown.classList.toggle('show');
        }

        function switchView(viewType) {
            if (viewType === 'list') {
                // 直接跳转到库存清单页面，不带参数
                window.location.href = 'stocklistall.php';
            } else if (viewType === 'remark') {
                // 跳转到备注页面
                window.location.href = 'stockremark.php';
            } else {
                // 保持在当前页面（库存记录）
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

        // 根据当前库存类型生成target选项
        function generateTargetOptions(selectedValue = '') {
            let options = '';
            
            if (currentStockType === 'central') {
                // Central页面显示所有选项
                options += `<option value="j1" ${selectedValue === 'j1' ? 'selected' : ''}>J1</option>`;
                options += `<option value="j2" ${selectedValue === 'j2' ? 'selected' : ''}>J2</option>`;
                options += `<option value="central" ${selectedValue === 'central' ? 'selected' : ''}>中央</option>`;
            } else if (currentStockType === 'j1') {
                // J1页面只显示J1选项
                options += `<option value="j1" ${selectedValue === 'j1' ? 'selected' : ''}>J1</option>`;
            } else if (currentStockType === 'j2') {
                // J2页面只显示J2选项
                options += `<option value="j2" ${selectedValue === 'j2' ? 'selected' : ''}>J2</option>`;
            }
            
            return options;
        }

        // 返回仪表盘
        function goBack() {
            window.location.href = 'dashboard.php';
        }

        // 点击其他地方关闭下拉菜单
        document.addEventListener('click', function(event) {
            const selector = event.target.closest('.selector-button');
            const dropdown = event.target.closest('.selector-dropdown');
            const dropdownItem = event.target.closest('.dropdown-item');
            
            // 如果点击的是下拉选项，立即隐藏对应的下拉菜单
            if (dropdownItem) {
                const parentDropdown = dropdownItem.closest('.selector-dropdown');
                if (parentDropdown) {
                    parentDropdown.classList.remove('show');
                }
                return;
            }
            
            // 如果点击的不是选择器按钮且不是下拉菜单内部，则隐藏所有下拉菜单
            if (!selector && !dropdown) {
                document.getElementById('stock-dropdown')?.classList.remove('show');
                document.getElementById('view-selector-dropdown')?.classList.remove('show');
            }
        });

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
                const result = await apiCall('?action=list&limit=1000');
                
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

        // 加载code number选项
        async function loadCodeNumbers() {
            try {
                const result = await apiCall('?action=codenumbers');
                if (result.success && result.data) {
                    window.codeNumberOptions = result.data;
                } else {
                    window.codeNumberOptions = [];
                }
            } catch (error) {
                console.error('加载编号列表失败:', error);
                window.codeNumberOptions = [];
            }
        }

        // 加载product name选项
        async function loadProducts() {
            try {
                const result = await apiCall('?action=products_list');
                if (result.success && result.data) {
                    window.productOptions = result.data;
                } else {
                    window.productOptions = [];
                }
            } catch (error) {
                console.error('加载货品列表失败:', error);
                window.productOptions = [];
            }
        }

        // 根据货品名称获取货品编号
        async function getCodeByProduct(productName) {
            try {
                const result = await apiCall(`?action=code_by_product&product_name=${encodeURIComponent(productName)}`);
                if (result.success && result.data) {
                    return result.data.product_code;
                }
            } catch (error) {
                console.error('获取货品编号失败:', error);
            }
            return '';
        }

        // 生成货品名称下拉选项
        function generateProductOptions(selectedValue = '') {
            if (!window.productOptions) return '<option value="">加载中...</option>';
            
            let options = '<option value="">请选择货品</option>';
            window.productOptions.forEach(item => {
                const selected = item.product_name === selectedValue ? 'selected' : '';
                options += `<option value="${item.product_name}" ${selected}>${item.product_name}</option>`;
            });
            return options;
        }

        // 处理货品名称变化
        async function handleProductChange(selectElement, codeNumberElement) {
            const productName = selectElement.value;
            if (productName) {
                const productCode = await getCodeByProduct(productName);
                if (productCode) {
                    // 如果没有传入codeNumberElement，自动查找
                    if (!codeNumberElement) {
                        const row = selectElement.closest('tr');
                        codeNumberElement = row.querySelector('td:nth-child(2) select') || row.querySelector('td:nth-child(2) input');
                    }
                    
                    if (codeNumberElement) {
                        if (codeNumberElement.tagName === 'SELECT') {
                            // 如果是下拉框，设置对应的值
                            codeNumberElement.value = productCode;
                        } else if (codeNumberElement.tagName === 'INPUT') {
                            codeNumberElement.value = productCode;
                        } else {
                            codeNumberElement.textContent = productCode;
                        }
                    }
                    
                    // 如果是在编辑模式，更新数据
                    const row = selectElement.closest('tr');
                    if (row && !row.classList.contains('new-row')) {
                        const recordId = parseInt(selectElement.getAttribute('data-record-id'));
                        if (recordId) {
                            updateField(recordId, 'code_number', productCode);
                        }
                    }
                }
            }
        }

        // 根据code number获取货品名称
        async function getProductByCode(codeNumber) {
            try {
                const result = await apiCall(`?action=product_by_code&code_number=${encodeURIComponent(codeNumber)}`);
                if (result.success && result.data) {
                    return result.data.product_name;
                }
            } catch (error) {
                console.error('获取货品名称失败:', error);
            }
            return '';
        }

        // 生成code number下拉选项
        function generateCodeNumberOptions(selectedValue = '') {
            if (!window.codeNumberOptions) return '<option value="">加载中...</option>';
            
            let options = '<option value="">请选择编号</option>';
            window.codeNumberOptions.forEach(item => {
                const selected = item.code_number === selectedValue ? 'selected' : '';
                options += `<option value="${item.code_number}" ${selected}>${item.code_number}</option>`;
            });
            return options;
        }

        // 处理code number变化
        async function handleCodeNumberChange(selectElement, productNameElement) {
            const codeNumber = selectElement.value;
            if (codeNumber) {
                const productName = await getProductByCode(codeNumber);
                if (productName) {
                    // 如果没有传入productNameElement，自动查找
                    if (!productNameElement) {
                        const row = selectElement.closest('tr');
                        productNameElement = row.querySelector('td:nth-child(3) select') || row.querySelector('td:nth-child(3) input');
                    }
                    
                    if (productNameElement) {
                        if (productNameElement.tagName === 'INPUT') {
                            productNameElement.value = productName;
                        } else if (productNameElement.tagName === 'SELECT') {
                            productNameElement.value = productName;
                        } else {
                            productNameElement.textContent = productName;
                        }
                    }
                    
                    // 如果是在编辑模式，更新数据
                    const row = selectElement.closest('tr');
                    if (row && !row.classList.contains('new-row')) {
                        const recordId = parseInt(selectElement.getAttribute('data-record-id'));
                        if (recordId) {
                            updateField(recordId, 'product_name', productName);
                        }
                    }
                }
            }
        }

        // 实时搜索数据
        async function searchData() {
            if (isLoading) return;

            isLoading = true;

            try {
                const params = new URLSearchParams({
                    action: 'list'
                });

                const dateFilter = document.getElementById('date-filter').value;
                const unifiedSearch = document.getElementById('unified-filter').value.trim().toLowerCase();

                if (dateFilter) params.append('search_date', dateFilter);

                // 不再 append product_code / product_name / receiver
                const result = await apiCall(`?${params}`);

                if (result.success) {
                    let data = result.data || [];

                    if (unifiedSearch) {
                        data = data.filter(record =>
                            (record.code_number && record.code_number.toLowerCase().includes(unifiedSearch)) ||
                            (record.product_name && record.product_name.toLowerCase().includes(unifiedSearch)) ||
                            (record.receiver && record.receiver.toLowerCase().includes(unifiedSearch))
                        );
                    }

                    stockData = data;
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
            document.getElementById('code-filter').value = '';  // 新添加
            document.getElementById('product-filter').value = '';
            document.getElementById('receiver-filter').value = '';
            loadStockData();
        }

        // 渲染库存表格
        function renderStockTable() {
            const tbody = document.getElementById('stock-tbody');
            tbody.innerHTML = '';
            
            if (stockData.length === 0) {
                tbody.innerHTML = '<tr><td colspan="15" style="padding: 20px; color: #6b7280;">暂无数据</td></tr>';
                return;
            }
            
            stockData.forEach(record => {
                const row = document.createElement('tr');
                const isEditing = editingRowIds.has(record.id);

                if (isEditing) {
                    row.classList.add('editing-row');
                }
                
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
                            createCombobox('code', record.code_number, record.id) :
                            `<span>${record.code_number || '-'}</span>`
                        }
                    </td>
                    <td>
                        ${isEditing ? 
                            createCombobox('product', record.product_name, record.id) :
                            `<span>${record.product_name}</span>`
                        }
                    </td>
                    <td>
                        ${isEditing ? 
                            `<input type="number" class="table-input" value="${record.in_quantity || ''}" min="0" step="0.001" onchange="updateField(${record.id}, 'in_quantity', this.value)">` :
                            `<span>${formatNumber(record.in_quantity)}</span>`
                        }
                    </td>
                    <td>
                        ${isEditing ? 
                            `<input type="number" class="table-input" value="${record.out_quantity || ''}" min="0" step="0.001" onchange="updateField(${record.id}, 'out_quantity', this.value)">` :
                            `<span class="${outQty > 0 ? 'negative-value' : ''}">${formatNumber(record.out_quantity)}</span>`
                        }
                    </td>
                    <td>
                        ${isEditing ? 
                            `<select class="table-select" id="target-select-${record.id}" onchange="updateField(${record.id}, 'target_system', this.value)" ${(parseFloat(record.out_quantity || 0) === 0) ? 'disabled' : ''}>
                                <option value="">请选择</option>
                                ${generateTargetOptions(record.target_system)}
                            </select>` :
                            `<span>${record.target_system ? record.target_system.toUpperCase() : '-'}</span>`
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
                        ${isEditing ? 
                            (parseFloat(record.out_quantity || 0) > 0 && parseFloat(record.in_quantity || 0) === 0 ? 
                                `<div class="currency-display">
                                    <span class="currency-symbol">RM</span>
                                    <select class="table-select price-select" id="price-select-${record.id}" 
                                            onchange="updateField(${record.id}, 'price', this.value)"
                                            data-product-name="${record.product_name}" 
                                            data-current-price="${record.price}">
                                        <option value="">请选择价格</option>
                                    </select>
                                </div>` :
                                `<div class="currency-display">
                                    <span class="currency-symbol">RM</span>
                                    <input type="number" class="currency-input-edit" 
                                        value="${record.price || ''}" min="0" step="0.01" 
                                        onchange="updateField(${record.id}, 'price', this.value)">
                                </div>`
                            ) :
                            `<div class="currency-display">
                                <span class="currency-symbol">RM</span>
                                <span class="currency-amount">${formatCurrency(record.price)}</span>
                            </div>`
                        }
                    </td>
                    <td class="calculated-cell ${total < 0 ? 'negative-value negative-parentheses' : ''}">
                        <div class="currency-display ${total < 0 ? 'negative-value negative-parentheses' : ''}">
                            <span class="currency-symbol">RM</span>
                            <span class="currency-amount">${formatCurrency(Math.abs(total))}</span>
                        </div>
                    </td>
                    <td>
                        ${isEditing ? 
                            (currentStockType !== 'central' ? 
                                `<select class="table-select" onchange="updateField(${record.id}, 'type', this.value)">
                                    ${generateTypeOptions(record.type)}
                                </select>` :
                                `<select class="table-select" disabled>
                                    ${generateTypeOptions(record.type)}
                                </select>`
                            ) :
                            `<span>${record.type || '-'}</span>`
                        }
                    </td>
                    <td style="text-align: center;">
                        ${isEditing ? 
                            `<input type="checkbox" class="remark-checkbox" ${record.product_remark_checked ? 'checked' : ''} 
                            onchange="updateRemarkCheck(${record.id}, this.checked)">` :
                            `<input type="checkbox" class="remark-checkbox" ${record.product_remark_checked ? 'checked' : ''} disabled>`
                        }
                    </td>
                    <td>
                        ${isEditing ? 
                            createRemarkNumberInput(record.remark_number || '', record.id, !record.product_remark_checked) :
                            `<span>${record.remark_number || '-'}</span>`
                        }
                    </td>
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
                    <td>
                        <span class="action-cell">
                            ${isBatchDeleteMode ? 
                                `<input type="checkbox" class="batch-select-checkbox" 
                                        data-record-id="${record.id}" 
                                        onchange="toggleRecordSelection(${record.id}, this.checked)"
                                        ${selectedRecords.has(record.id) ? 'checked' : ''}>` :
                                (isEditing ? 
                                    `<button class="action-btn edit-btn save-mode" onclick="saveRecord(${record.id})" title="保存">
                                        <i class="fas fa-save"></i>
                                    </button>
                                    <button class="action-btn" onclick="cancelEdit(${record.id})" title="取消" style="background: #6b7280;">
                                        <i class="fas fa-times"></i>
                                    </button>` :
                                    `<button class="action-btn edit-btn" onclick="editRecord(${record.id})" title="编辑">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn delete-btn" onclick="deleteRecord(${record.id})" title="删除">
                                        <i class="fas fa-trash"></i>
                                    </button>`
                                )
                            }
                        </span>
                    </td>
                `;
                
                tbody.appendChild(row);
            });

            setTimeout(bindComboboxEvents, 0);

            // 加载所有编辑中记录的价格选项
            setTimeout(() => {
                stockData.forEach(record => {
                    if (editingRowIds.has(record.id) && record.product_name) {
                        const outQty = parseFloat(record.out_quantity || 0);
                        const inQty = parseFloat(record.in_quantity || 0);
                        // 只有纯出库时才加载价格选项（带库存检查）
                        if (outQty > 0 && inQty === 0) {
                            loadProductPricesWithStock(record.product_name, `price-select-${record.id}`, record.price, outQty);
                        }
                    }
                });
            }, 200);
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
            if (isNaN(num)) return '0.00';
            // 四舍五入到2位小数
            return (Math.round(num * 100) / 100).toFixed(2);
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
            
            document.getElementById('total-records').textContent = totalRecords;
        }

        // 添加新行到表格
        function addNewRow() {
            const tbody = document.getElementById('stock-tbody');
            const row = document.createElement('tr');
            row.className = 'new-row';
            
            const now = new Date();
            const today = now.toISOString().split('T')[0];
            const rowId = 'new-' + Date.now(); // 生成唯一ID

            row.innerHTML = `
                <td><input type="date" class="table-input" value="${today}" id="${rowId}-date"></td>
                <td>${createCombobox('code', '', null, rowId)}</td>
                <td>${createCombobox('product', '', null, rowId)}</td>
                <td><input type="number" class="table-input" min="0" step="0.001" placeholder="0.000" id="${rowId}-in-qty" oninput="updateNewRowTotal(this)"></td>
                <td><input type="number" class="table-input" min="0" step="0.001" placeholder="0.000" id="${rowId}-out-qty" oninput="updateNewRowTotal(this)"></td>
                <td>
                    <select class="table-select" id="${rowId}-target" disabled>
                        <option value="">请选择</option>
                        ${generateTargetOptions()}
                    </select>
                </td>
                <td>
                    <select class="table-select" id="${rowId}-specification">
                        <option value="">请选择规格</option>
                        ${specifications.map(spec => `<option value="${spec}">${spec}</option>`).join('')}
                    </select>
                </td>
                <td>
                    <div class="currency-display">
                        <span class="currency-symbol">RM</span>
                        <input type="number" class="currency-input-edit" min="0" step="0.01" placeholder="0.00" id="${rowId}-price" oninput="updateNewRowTotal(this)">
                    </div>
                </td>
                <td class="calculated-cell">
                    <div class="currency-display">
                        <span class="currency-symbol">RM</span>
                        <span class="currency-amount">0.00</span>
                    </div>
                </td>
                <td>
                    <select class="table-select" id="${rowId}-type" ${currentStockType === 'central' ? 'disabled' : ''}>
                        <option value="">请选择类型</option>
                        <option value="Kitchen">Kitchen</option>
                        <option value="SushiBar">SushiBar</option>
                        <option value="Drink">Drink</option>
                        <option value="Sake">Sake</option>
                    </select>
                </td>
                <td style="text-align: center;">
                    <input type="checkbox" class="remark-checkbox" id="${rowId}-product-remark" onchange="toggleNewRowRemarkNumber('${rowId}')">
                </td>
                <td>
                    ${createNewRowRemarkNumberInput(rowId)}
                </td>
                <td><input type="text" class="table-input" placeholder="输入收货人..." id="${rowId}-receiver"></td>
                <td><input type="text" class="table-input" placeholder="输入备注..." id="${rowId}-remark"></td>
                <td>
                    <span class="action-cell">
                        <button class="action-btn save-new-btn" onclick="saveNewRowRecord(this)" title="保存">
                            <i class="fas fa-save"></i>
                        </button>
                        <button class="action-btn cancel-new-btn" onclick="cancelNewRow(this)" title="取消">
                            <i class="fas fa-times"></i>
                        </button>
                    </span>
                </td>
            `;
            
            // 添加到表格顶部
            tbody.insertBefore(row, tbody.firstChild);
            
            // 绑定 combobox 事件
            setTimeout(() => {
                bindComboboxEvents();
                
                // 自动聚焦到货品名称输入框
                const productInput = document.getElementById('new-product_name-input');
                if (productInput) {
                    productInput.focus();
                }
            }, 100);
        }

        // 更新新行的总价计算
        function updateNewRowTotal(element) {
            const row = element.closest('tr');
            const rowId = element.id.split('-')[0] + '-' + element.id.split('-')[1]; // 获取行的唯一ID
            
            const inQty = parseFloat(document.getElementById(`${rowId}-in-qty`).value) || 0;
            const outQty = parseFloat(document.getElementById(`${rowId}-out-qty`).value) || 0;
            const price = parseFloat(document.getElementById(`${rowId}-price`).value) || 0;

            // 新增：控制Target下拉框的启用/禁用状态
            const targetSelect = document.getElementById(`${rowId}-target`);
            if (targetSelect) {
                if (outQty > 0) {
                    targetSelect.disabled = false;
                    targetSelect.required = true;
                } else {
                    targetSelect.disabled = true;
                    targetSelect.value = '';
                    targetSelect.required = false;
                }
            }
            
            // 新增：检查是否需要显示价格下拉列表
            const productInput = document.getElementById(`${rowId}-product_name-input`);
            const productName = productInput ? productInput.value : '';
            const priceCell = document.getElementById(`${rowId}-price`).closest('.currency-display');
            
            if (outQty > 0 && inQty === 0 && productName) {
                // 纯出库且有货品名称，创建价格下拉选项（带库存检查）
                createNewRowPriceSelectWithStock(rowId, productName, price, outQty);
            } else if (outQty === 0 || inQty > 0) {
                // 恢复普通输入框
                restoreNewRowPriceInput(rowId);
            }
            
            const netQty = inQty - outQty;
            const total = netQty * price;
            
            const totalCell = row.querySelector('.calculated-cell');
            const currencyDisplay = totalCell.querySelector('.currency-display');
            const currencyAmount = totalCell.querySelector('.currency-amount');
            
            if (totalCell && currencyDisplay && currencyAmount) {
                // 更新数值
                currencyAmount.textContent = formatCurrency(Math.abs(total));
                
                // 添加或移除负数样式
                if (total < 0) {
                    totalCell.classList.add('negative-value', 'negative-parentheses');
                    currencyDisplay.classList.add('negative-value', 'negative-parentheses');
                } else {
                    totalCell.classList.remove('negative-value', 'negative-parentheses');
                    currencyDisplay.classList.remove('negative-value', 'negative-parentheses');
                }
            }
        }

        // 更新货品备注勾选状态
        function updateRemarkCheck(id, checked) {
            const record = stockData.find(r => r.id === id);
            if (record) {
                record.product_remark_checked = checked;
                
                // 控制备注编号输入框的启用/禁用状态
                const remarkInput = document.querySelector(`input[onchange*="updateField(${id}, 'remark_number'"]`);
                if (remarkInput) {
                    remarkInput.disabled = !checked;
                    if (!checked) {
                        remarkInput.value = '';
                        record.remark_number = '';
                    }
                }
                
                // 更新数据库
                updateField(id, 'product_remark_checked', checked);
            }
        }

        // 获取表单中的完整备注编号
        function getFormRemarkNumber() {
            const prefix = document.getElementById('add-remark-prefix').value.trim();
            const suffix = document.getElementById('add-remark-suffix').value.trim();
            return (prefix || suffix) ? `${prefix}-${suffix}` : '';
        }

        // 控制新增表单中备注编号的启用状态
        function toggleRemarkNumber() {
            const checkbox = document.getElementById('add-product-remark');
            const wrapper = document.getElementById('add-remark-wrapper');
            const prefixInput = document.getElementById('add-remark-prefix');
            const suffixInput = document.getElementById('add-remark-suffix');
            
            if (checkbox.checked) {
                wrapper.style.opacity = '1';
                prefixInput.disabled = false;
                suffixInput.disabled = false;
            } else {
                wrapper.style.opacity = '0.5';
                prefixInput.disabled = true;
                suffixInput.disabled = true;
                prefixInput.value = '';
                suffixInput.value = '';
                document.getElementById('add-remark-number').value = '';
            }
        }

        function toggleNewRowRemarkNumber(rowId) {
            const checkbox = document.getElementById(`${rowId}-product-remark`);
            const wrapper = document.getElementById(`${rowId}-remark-wrapper`);
            const prefixInput = document.getElementById(`${rowId}-remark-prefix`);
            const suffixInput = document.getElementById(`${rowId}-remark-suffix`);
            
            if (checkbox && wrapper && prefixInput && suffixInput) {
                if (checkbox.checked) {
                    wrapper.style.opacity = '1';
                    wrapper.setAttribute('data-disabled', 'false');
                    prefixInput.disabled = false;
                    suffixInput.disabled = false;
                    
                    // 绑定输入事件
                    prefixInput.oninput = suffixInput.oninput = () => updateNewRowRemarkNumber(rowId);
                } else {
                    wrapper.style.opacity = '0.5';
                    wrapper.setAttribute('data-disabled', 'true');
                    prefixInput.disabled = true;
                    suffixInput.disabled = true;
                    prefixInput.value = '';
                    suffixInput.value = '';
                    updateNewRowRemarkNumber(rowId);
                }
            }
        }

        // 创建备注编号输入框（用于编辑模式）
        function createRemarkNumberInput(value, recordId, disabled) {
            const parts = value ? value.split('-') : ['', ''];
            const prefix = parts[0] || '';
            const suffix = parts[1] || '';
            
            return `
                <div class="remark-number-input-wrapper" style="display: flex; align-items: center; border: 1px solid #d1d5db; border-radius: 4px; background: white; padding: 0;" ${disabled ? 'data-disabled="true"' : ''}>
                    <input type="text" class="table-input remark-prefix" value="${prefix}" placeholder="" 
                        style="border: none; border-radius: 4px 0 0 4px; width: 30px; text-align: center; background: transparent; padding: 4px;" 
                        ${disabled ? 'disabled' : ''} 
                        onchange="updateRemarkNumber(${recordId})">
                    <span style="padding: 0 2px; color: #6b7280; font-weight: bold;">-</span>
                    <input type="text" class="table-input remark-suffix" value="${suffix}" placeholder="" 
                        style="border: none; border-radius: 0 4px 4px 0; width: 30px; text-align: center; background: transparent; padding: 4px;" 
                        ${disabled ? 'disabled' : ''} 
                        onchange="updateRemarkNumber(${recordId})">
                </div>
            `;
        }

        // 创建新行备注编号输入框
        function createNewRowRemarkNumberInput(rowId) {
            return `
                <div class="remark-number-input-wrapper" style="display: flex; align-items: center; border: 1px solid #d1d5db; border-radius: 4px; background: white; padding: 0;" id="${rowId}-remark-wrapper" data-disabled="true">
                    <input type="text" class="table-input remark-prefix" placeholder="" 
                        style="border: none; border-radius: 4px 0 0 4px; width: 30px; text-align: center; background: transparent; padding: 4px;" 
                        id="${rowId}-remark-prefix" disabled>
                    <span style="padding: 0 2px; color: #6b7280; font-weight: bold;">-</span>
                    <input type="text" class="table-input remark-suffix" placeholder="" 
                        style="border: none; border-radius: 0 4px 4px 0; width: 30px; text-align: center; background: transparent; padding: 4px;" 
                        id="${rowId}-remark-suffix" disabled>
                </div>
            `;
        }

        // 更新备注编号（合并前缀和后缀）
        function updateRemarkNumber(recordId) {
            const row = document.querySelector(`[onchange*="updateRemarkNumber(${recordId})"]`).closest('tr');
            const wrapper = row.querySelector('.remark-number-input-wrapper');
            const prefixInput = wrapper.querySelector('.remark-prefix');
            const suffixInput = wrapper.querySelector('.remark-suffix');
            
            const prefix = prefixInput.value.trim();
            const suffix = suffixInput.value.trim();
            const fullValue = (prefix || suffix) ? `${prefix}-${suffix}` : '';
            
            updateField(recordId, 'remark_number', fullValue);
        }

        // 更新新行备注编号
        function updateNewRowRemarkNumber(rowId) {
            const prefixInput = document.getElementById(`${rowId}-remark-prefix`);
            const suffixInput = document.getElementById(`${rowId}-remark-suffix`);
            
            if (prefixInput && suffixInput) {
                const prefix = prefixInput.value.trim();
                const suffix = suffixInput.value.trim();
                const fullValue = (prefix || suffix) ? `${prefix}-${suffix}` : '';
                
                // 更新隐藏的完整值（用于保存）
                const hiddenInput = document.getElementById(`${rowId}-remark-number`);
                if (!hiddenInput) {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.id = `${rowId}-remark-number`;
                    hidden.value = fullValue;
                    prefixInput.closest('td').appendChild(hidden);
                } else {
                    hiddenInput.value = fullValue;
                }
            }
        }

        // 提取行数据的辅助函数
        function extractRowData(row) {
            const rowId = row.querySelector('input').id.split('-')[0] + '-' + row.querySelector('input').id.split('-')[1];
            return {
                date: document.getElementById(`${rowId}-date`).value,
                codeValue: document.getElementById(`${rowId}-code_number-input`) ? document.getElementById(`${rowId}-code_number-input`).value : '',
                productValue: document.getElementById(`${rowId}-product_name-input`) ? document.getElementById(`${rowId}-product_name-input`).value : '',
                inQty: document.getElementById(`${rowId}-in-qty`).value,
                outQty: document.getElementById(`${rowId}-out-qty`).value,
                specification: document.getElementById(`${rowId}-specification`).value,
                price: document.getElementById(`${rowId}-price`).value,
                receiver: document.getElementById(`${rowId}-receiver`).value,
                remark: document.getElementById(`${rowId}-remark`).value,
                target: document.getElementById(`${rowId}-target`).value
            };
        }

        // 恢复行数据的辅助函数
        function restoreRowData(element, data) {
            const rowId = element.querySelector('input').id.split('-')[0] + '-' + element.querySelector('input').id.split('-')[1];
            
            if (document.getElementById(`${rowId}-date`)) document.getElementById(`${rowId}-date`).value = data.date;
            if (document.getElementById(`${rowId}-code_number-input`)) document.getElementById(`${rowId}-code_number-input`).value = data.codeValue;
            if (document.getElementById(`${rowId}-product_name-input`)) document.getElementById(`${rowId}-product_name-input`).value = data.productValue;
            if (document.getElementById(`${rowId}-in-qty`)) document.getElementById(`${rowId}-in-qty`).value = data.inQty;
            if (document.getElementById(`${rowId}-out-qty`)) document.getElementById(`${rowId}-out-qty`).value = data.outQty;
            if (document.getElementById(`${rowId}-specification`)) document.getElementById(`${rowId}-specification`).value = data.specification;
            if (document.getElementById(`${rowId}-price`)) document.getElementById(`${rowId}-price`).value = data.price;
            if (document.getElementById(`${rowId}-receiver`)) document.getElementById(`${rowId}-receiver`).value = data.receiver;
            if (document.getElementById(`${rowId}-remark`)) document.getElementById(`${rowId}-remark`).value = data.remark;
        }

        // 保存新行记录
        async function saveNewRowRecord(buttonElement) {
            const row = buttonElement.closest('tr');
            const rowId = row.querySelector('input').id.split('-')[0] + '-' + row.querySelector('input').id.split('-')[1];
            
            console.log('保存新行记录，rowId:', rowId);
            console.log('行元素:', row);
            
            const codeInput = document.getElementById(`${rowId}-code_number-input`);
            const productInput = document.getElementById(`${rowId}-product_name-input`);
            
            console.log('codeInput:', codeInput);
            console.log('productInput:', productInput);

            const formData = {
                date: document.getElementById(`${rowId}-date`) ? document.getElementById(`${rowId}-date`).value : '',
                time: new Date().toTimeString().slice(0, 5),
                product_name: productInput ? productInput.value : '',
                in_quantity: parseFloat(document.getElementById(`${rowId}-in-qty`) ? document.getElementById(`${rowId}-in-qty`).value : 0) || 0,
                out_quantity: parseFloat(document.getElementById(`${rowId}-out-qty`) ? document.getElementById(`${rowId}-out-qty`).value : 0) || 0,
                specification: document.getElementById(`${rowId}-specification`) ? document.getElementById(`${rowId}-specification`).value : '',
                price: parseFloat(document.getElementById(`${rowId}-price`) ? document.getElementById(`${rowId}-price`).value : 0) || 0,
                receiver: document.getElementById(`${rowId}-receiver`) ? document.getElementById(`${rowId}-receiver`).value : '',
                code_number: codeInput ? codeInput.value : '',
                remark: document.getElementById(`${rowId}-remark`) ? document.getElementById(`${rowId}-remark`).value : '',
                product_remark_checked: document.getElementById(`${rowId}-product-remark`) ? document.getElementById(`${rowId}-product-remark`).checked : false,
                remark_number: document.getElementById(`${rowId}-remark-number`) ? document.getElementById(`${rowId}-remark-number`).value : '',
                type: document.getElementById(`${rowId}-type`) ? document.getElementById(`${rowId}-type`).value : ''
            };

            // 验证必填字段
            if (!formData.product_name || !formData.specification || !formData.receiver) {
                showAlert('请填写货品名称、规格单位和收货人', 'error');
                return;
            }

            // 添加target验证
            if (formData.out_quantity > 0) {
                const targetInput = document.getElementById(`${rowId}-target`);
                if (!targetInput || !targetInput.value) {
                    showAlert('当有出库数量时，请选择目标系统（J1或J2）', 'error');
                    return;
                }
                formData.target_system = targetInput.value;
            }

            // 验证货品名称是否存在于数据库中
            if (formData.product_name && window.productOptions) {
                const validProducts = window.productOptions.map(p => p.product_name);
                if (!validProducts.includes(formData.product_name)) {
                    showAlert('货品名称不存在，请从下拉列表中选择有效的货品', 'error');
                    return;
                }
            }

            // 验证编号是否存在于数据库中
            if (formData.code_number && window.codeNumberOptions) {
                const validCodes = window.codeNumberOptions.map(c => c.code_number);
                if (!validCodes.includes(formData.code_number)) {
                    showAlert('货品编号不存在，请从下拉列表中选择有效的编号', 'error');
                    return;
                }
            }

            // 检查库存是否足够
            if (formData.out_quantity > 0) {
                const stockCheck = await checkProductStock(formData.product_name, formData.out_quantity, formData.price);
                if (!stockCheck.sufficient) {
                    showAlert(`库存不足！当前可用库存: ${stockCheck.availableStock}，请求出库: ${stockCheck.requested}`, 'error');
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
                
                // 保存其他新增行
                const otherNewRows = Array.from(document.querySelectorAll('.new-row')).filter(r => r !== row);
                const savedRows = otherNewRows.map(r => ({
                    element: r.cloneNode(true),
                    data: extractRowData(r)
                }));
                
                // 移除当前保存的行
                row.remove();
                
                // 添加新记录到 stockData 数组的开头
                const newRecord = {
                    id: result.data.id || Date.now(),
                    date: formData.date,
                    time: formData.time,
                    code_number: formData.code_number,
                    product_name: formData.product_name,
                    in_quantity: formData.in_quantity,
                    out_quantity: formData.out_quantity,
                    target_system: formData.target_system,
                    specification: formData.specification,
                    price: formData.price,
                    receiver: formData.receiver,
                    remark: formData.remark,
                    product_remark_checked: formData.product_remark_checked,  // 添加这行
                    remark_number: formData.remark_number,  // 添加这行
                    created_at: new Date().toISOString()
                };
                
                stockData.unshift(newRecord); // 添加到数组开头
                
                // 重新渲染表格
                renderStockTable();
                
                // 恢复其他新增行
                setTimeout(() => {
                    const tbody = document.getElementById('stock-tbody');
                    savedRows.forEach(({element}) => {
                        tbody.insertBefore(element, tbody.firstChild);
                    });
                    bindComboboxEvents();
                }, 100);
                
                // 更新统计
                updateStats();
            } else {
                    showAlert('添加失败: ' + (result.message || '未知错误'), 'error');
                }
            } catch (error) {
                showAlert('保存时发生错误', 'error');
            }
        }

        // 取消新行
        function cancelNewRow(buttonElement) {
            const row = buttonElement.closest('tr');
            row.remove();
        }

        // 保存新记录
        async function saveNewRecord() {
            // 确保表单中的下拉选项已加载
            if (window.codeNumberOptions && window.codeNumberOptions.length > 0) {
                const selectElement = document.getElementById('add-code-number');
                if (selectElement && selectElement.options.length <= 1) {
                    selectElement.innerHTML = generateCodeNumberOptions();
                }
            }

            const formData = {
                date: document.getElementById('add-date').value,
                time: document.getElementById('add-time').value,
                product_name: document.getElementById('add-product-name').value,
                in_quantity: parseFloat(document.getElementById('add-in-qty').value) || 0,
                out_quantity: parseFloat(document.getElementById('add-out-qty').value) || 0,
                specification: document.getElementById('add-specification').value,
                price: parseFloat(document.getElementById('add-price').value) || 0,
                receiver: document.getElementById('add-receiver').value,
                applicant: document.getElementById('add-applicant').value,
                code_number: document.getElementById('add-code-number').value,
                remark: document.getElementById('add-remark').value,
                product_remark_checked: document.getElementById('add-product-remark').checked,
                remark_number: getFormRemarkNumber(),
                type: document.getElementById('add-type').value
            };

            // 验证必填字段
            const requiredFields = ['date', 'time', 'product_name', 'specification', 'receiver', 'applicant'];
            for (let field of requiredFields) {
                if (!formData[field]) {
                    showAlert(`请填写${getFieldLabel(field)}`, 'error');
                    return;
                }
            }

            // 验证货品名称是否存在于数据库中
            if (formData.product_name && window.productOptions) {
                const validProducts = window.productOptions.map(p => p.product_name);
                if (!validProducts.includes(formData.product_name)) {
                    showAlert('货品名称不存在，请从下拉列表中选择有效的货品', 'error');
                    return;
                }
            }

            // 验证编号是否存在于数据库中
            if (formData.code_number && window.codeNumberOptions) {
                const validCodes = window.codeNumberOptions.map(c => c.code_number);
                if (!validCodes.includes(formData.code_number)) {
                    showAlert('货品编号不存在，请从下拉列表中选择有效的编号', 'error');
                    return;
                }
            }

            // 检查库存是否足够
            if (formData.out_quantity > 0) {
                // 添加target验证
                const targetSystem = document.getElementById('add-target').value;
                if (!targetSystem) {
                    showAlert('当有出库数量时，请选择目标系统（J1或J2）', 'error');
                    return;
                }
                formData.target_system = targetSystem;
                
                // 现有库存检查代码
                const stockCheck = await checkProductStock(formData.product_name, formData.out_quantity, formData.price);
                if (!stockCheck.sufficient) {
                    showAlert(`库存不足！当前可用库存: ${stockCheck.availableStock}，请求出库: ${formData.out_quantity}`, 'error');
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
                
                // 添加新记录到 stockData 数组的开头并立即显示
                const newRecord = {
                    id: result.data.id || Date.now(), 
                    date: formData.date,
                    time: formData.time,
                    code_number: formData.code_number,
                    product_name: formData.product_name,
                    in_quantity: formData.in_quantity,
                    out_quantity: formData.out_quantity,
                    target_system: formData.target_system,
                    specification: formData.specification,
                    price: formData.price,
                    receiver: formData.receiver,
                    applicant: formData.applicant,
                    remark: formData.remark,
                    product_remark_checked: formData.product_remark_checked,  // 添加这行
                    remark_number: formData.remark_number,  // 添加这行
                    created_at: new Date().toISOString()
                };
                
                stockData.unshift(newRecord);
                renderStockTable();
                updateStats();
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
                'product_name': '货品名称',
                'specification': '规格单位',
                'receiver': '收货人',
                'applicant': '申请人'
            };
            return labels[field] || field;
        }

        // 编辑记录
        function editRecord(id) {
            // 如果已经在编辑中，直接返回
            if (editingRowIds.has(id)) {
                return;
            }
            
            editingRowIds.add(id);
            
            // 保存原始数据的深拷贝 - 初始化Map如果不存在
            if (!originalEditData) {
                originalEditData = new Map();
            }
            
            const record = stockData.find(r => r.id === id);
            if (record) {
                originalEditData.set(id, JSON.parse(JSON.stringify(record)));
            }
            
            renderStockTable();
        }

        // 取消单个记录的编辑
        function cancelEdit(id = null) {
            if (id !== null) {
                // 取消指定记录的编辑
                if (originalEditData && originalEditData.has(id)) {
                    const recordIndex = stockData.findIndex(r => r.id === id);
                    if (recordIndex !== -1) {
                        stockData[recordIndex] = JSON.parse(JSON.stringify(originalEditData.get(id)));
                    }
                    originalEditData.delete(id);
                }
                editingRowIds.delete(id);
            } else {
                // 取消所有编辑
                if (originalEditData) {
                    editingRowIds.forEach(editId => {
                        if (originalEditData.has(editId)) {
                            const recordIndex = stockData.findIndex(r => r.id === editId);
                            if (recordIndex !== -1) {
                                stockData[recordIndex] = JSON.parse(JSON.stringify(originalEditData.get(editId)));
                            }
                        }
                    });
                    originalEditData.clear();
                }
                editingRowIds.clear();
            }
            
            renderStockTable();
        }

        // 更新字段
        function updateField(id, field, value) {
            const record = stockData.find(r => r.id === id);
            if (record) {
                record[field] = value;
                
                // 特殊处理出库数量变化
                if (field === 'out_quantity') {
                    const outQty = parseFloat(value) || 0;
                    const targetSelect = document.getElementById(`target-select-${id}`);
                    if (targetSelect) {
                        if (outQty > 0) {
                            targetSelect.disabled = false;
                            targetSelect.required = true;
                        } else {
                            targetSelect.disabled = true;
                            targetSelect.value = '';
                            record.target_system = '';
                        }
                    }
                }
                
                // 移除自动重新渲染，改为只更新计算值
                if (field === 'in_quantity' || field === 'out_quantity' || field === 'price') {
                    updateCalculatedValues(id);
                }
            }
        }

        // 更新计算值（不重新渲染整个表格）
        function updateCalculatedValues(id) {
            const record = stockData.find(r => r.id === id);
            if (!record) return;
            
            // 计算总价
            const inQty = parseFloat(record.in_quantity) || 0;
            const outQty = parseFloat(record.out_quantity) || 0;
            const price = parseFloat(record.price) || 0;
            const netQty = inQty - outQty;
            const total = netQty * price;
            
            // 更新页面上的总价显示
            const row = document.querySelector(`[data-record-id="${id}"]`)?.closest('tr');
            if (row) {
                const totalCell = row.querySelector('.calculated-cell');
                const currencyDisplay = totalCell?.querySelector('.currency-display');
                const currencyAmount = totalCell?.querySelector('.currency-amount');
                
                if (totalCell && currencyDisplay && currencyAmount) {
                    // 更新数值
                    currencyAmount.textContent = formatCurrency(Math.abs(total));
                    
                    // 添加或移除负数样式
                    if (total < 0) {
                        totalCell.classList.add('negative-value', 'negative-parentheses');
                        currencyDisplay.classList.add('negative-value', 'negative-parentheses');
                    } else {
                        totalCell.classList.remove('negative-value', 'negative-parentheses');
                        currencyDisplay.classList.remove('negative-value', 'negative-parentheses');
                    }
                }
                
                // 更新出库数量的显示样式
                const outCell = row.querySelector('td:nth-child(5)');
                if (outCell) {
                    const outSpan = outCell.querySelector('span');
                    if (outSpan) {
                        if (outQty > 0) {
                            outSpan.classList.add('negative-value');
                        } else {
                            outSpan.classList.remove('negative-value');
                        }
                    }
                }
            }
        }

        // 切换新增表单显示状态
        function toggleAddForm() {
            const form = document.getElementById('add-form');
            const isVisible = form.classList.contains('show');
            
            if (isVisible) {
                form.classList.remove('show');
            } else {
                form.classList.add('show');
                
                // 确保选项已加载
                setTimeout(() => {
                    // 加载code number选项
                    if (window.codeNumberOptions && window.codeNumberOptions.length > 0) {
                        const selectElement = document.getElementById('add-code-number');
                        if (selectElement) {
                            selectElement.innerHTML = generateCodeNumberOptions();
                        }
                    }

                    // 更新target选项
                    const targetSelect = document.getElementById('add-target');
                    if (targetSelect) {
                        const currentValue = targetSelect.value;
                        const optionsHtml = generateTargetOptions(currentValue);
                        const selectOptions = targetSelect.querySelectorAll('option:not([value=""])');
                        selectOptions.forEach(option => option.remove());
                        targetSelect.insertAdjacentHTML('beforeend', optionsHtml);
                    }
                    
                    // 为表单中的下拉框绑定联动事件
                    const addProductSelect = document.getElementById('add-product-name');
                    const addCodeSelect = document.getElementById('add-code-number');
                    
                    if (addProductSelect) {
                        addProductSelect.onchange = function() {
                            handleAddFormProductChange(this, addCodeSelect);
                        };
                    }
                    
                    if (addCodeSelect) {
                        addCodeSelect.onchange = function() {
                            handleCodeNumberChange(this, addProductSelect);
                        };
                    }

                    // 重置备注相关字段
                    document.getElementById('add-product-remark').checked = false;
                    document.getElementById('add-remark-number').value = '';
                    document.getElementById('add-remark-number').disabled = true;
                }, 100);
            }
        }

        // 保存记录
        async function saveRecord(id) {
            const record = stockData.find(r => r.id === id);
            if (!record) return;

            // 验证货品名称是否存在于数据库中
            if (record.product_name && window.productOptions) {
                const validProducts = window.productOptions.map(p => p.product_name);
                if (!validProducts.includes(record.product_name)) {
                    showAlert('货品名称不存在，请从下拉列表中选择有效的货品', 'error');
                    return;
                }
            }

            // 验证编号是否存在于数据库中
            if (record.code_number && window.codeNumberOptions) {
                const validCodes = window.codeNumberOptions.map(c => c.code_number);
                if (!validCodes.includes(record.code_number)) {
                    showAlert('货品编号不存在，请从下拉列表中选择有效的编号', 'error');
                    return;
                }
            }

            try {
                const result = await apiCall('', {
                    method: 'PUT',
                    body: JSON.stringify(record)
                });

                if (result.success) {
                    showAlert('记录更新成功', 'success');
                    editingRowIds.delete(id);
                    if (originalEditData) {
                        originalEditData.delete(id);
                    }
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

        // 刷新数据但保留新增行
        function refreshDataKeepNewRows() {
            // 保存所有新增行
            const newRows = Array.from(document.querySelectorAll('.new-row')).map(row => ({
                element: row.cloneNode(true),
                parent: row.parentNode
            }));
            
            // 重新加载数据
            loadStockData().then(() => {
                // 恢复新增行
                newRows.forEach(({element, parent}) => {
                    parent.insertBefore(element, parent.firstChild);
                });
                
                // 重新绑定事件
                setTimeout(bindComboboxEvents, 0);
            });
        }

        // 导出数据
        function exportData() {
            // 设置默认日期（最近30天）
            const endDate = new Date();
            const startDate = new Date();
            startDate.setDate(endDate.getDate() - 30);
            
            document.getElementById('export-start-date').value = startDate.toISOString().split('T')[0];
            document.getElementById('export-end-date').value = endDate.toISOString().split('T')[0];
            
            // 设置发票日期默认为今天
            document.getElementById('export-invoice-date').value = endDate.toISOString().split('T')[0];
            
            // 显示导出弹窗
            document.getElementById('export-modal').style.display = 'block';
        }

        // 完全替换现有的 showAlert 函数
        function showAlert(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            // 先检查并限制通知数量（在添加新通知之前）
            const existingToasts = container.querySelectorAll('.toast');
            while (existingToasts.length >= 3) {
                closeToast(existingToasts[0].id);
                // 立即从DOM移除，不等待动画
                if (existingToasts[0].parentNode) {
                    existingToasts[0].parentNode.removeChild(existingToasts[0]);
                }
                // 重新获取当前通知列表
                existingToasts = container.querySelectorAll('.toast');
            }

            const toastId = 'toast-' + Date.now();
            const iconClass = {
                'success': 'fa-check-circle',
                'error': 'fa-exclamation-circle', 
                'info': 'fa-info-circle',
                'warning': 'fa-exclamation-triangle'
            }[type] || 'fa-check-circle';

            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.id = toastId;
            toast.innerHTML = `
                <i class="fas ${iconClass} toast-icon"></i>
                <div class="toast-content">${message}</div>
                <button class="toast-close" onclick="closeToast('${toastId}')">
                    <i class="fas fa-times"></i>
                </button>
                <div class="toast-progress"></div>
            `;

            container.appendChild(toast);

            // 显示动画
            setTimeout(() => {
                toast.classList.add('show');
            }, 0);

            // 自动关闭
            setTimeout(() => {
                closeToast(toastId);
            }, 700);
        }

        // 添加关闭通知的函数
        function closeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.remove('show');
                toast.classList.add('hide');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }
        }

        // 添加关闭所有通知的函数（可选）
        function closeAllToasts() {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                closeToast(toast.id);
            });
        }

        // 页面加载完成后初始化
        document.addEventListener('DOMContentLoaded', initApp);

        // 键盘快捷键支持
        document.addEventListener('keydown', function(e) {
            // Ctrl+S 保存所有编辑
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                if (editingRowIds.size > 0) {
                    // 保存所有正在编辑的记录
                    editingRowIds.forEach(id => {
                        saveRecord(id);
                    });
                }
            }
            
            // Escape键取消新增行
            if (e.key === 'Escape') {
                if (document.querySelector('.new-row')) {
                    cancelNewRow();
                }
                // 移除自动取消所有编辑的功能，让用户手动取消
            }

            // Home键回到顶部
            if (e.key === 'Home' && e.ctrlKey) {
                e.preventDefault();
                scrollToTop();
            }
        });
    </script>
    <script>
        // 创建 Combobox 组件
        function createCombobox(type, value = '', recordId = null, isNewRow = false) {
            const options = type === 'code' ? window.codeNumberOptions : window.productOptions;
            const placeholder = type === 'code' ? '输入或选择编号...' : '输入或选择货品...';
            const fieldName = type === 'code' ? 'code_number' : 'product_name';
            const displayField = type === 'code' ? 'code_number' : 'product_name';
            
            let containerId;
            if (isNewRow === true) {
                containerId = `new-${fieldName}`;
            } else if (typeof isNewRow === 'string') {
                containerId = `${isNewRow}-${fieldName}`;
            } else {
                containerId = `combo-${fieldName}-${recordId}`;
            }
            const inputId = `${containerId}-input`;
            const dropdownId = `${containerId}-dropdown`;
            
            return `
                <div class="combobox-container" id="${containerId}">
                    <input 
                        type="text" 
                        class="combobox-input" 
                        id="${inputId}"
                        value="${value || ''}" 
                        placeholder="${placeholder}"
                        autocomplete="off"
                        ${recordId ? `data-record-id="${recordId}"` : ''}
                        data-field="${fieldName}"
                        data-type="${type}"
                    />
                    <i class="fas fa-chevron-down combobox-arrow"></i>
                    <div class="combobox-dropdown" id="${dropdownId}">
                        ${generateComboboxOptions(options, displayField)}
                    </div>
                </div>
            `;
        }

        // 生成下拉选项
        function generateComboboxOptions(options, displayField) {
            if (!options || options.length === 0) {
                return '<div class="no-results">暂无选项</div>';
            }
            
            return options.map(option => 
                `<div class="combobox-option" data-value="${option[displayField]}">
                    ${option[displayField]}
                </div>`
            ).join('');
        }

        // 计算下拉列表位置
        function calculateDropdownPosition(inputElement, dropdownElement) {
            const inputRect = inputElement.getBoundingClientRect();
            const viewportHeight = window.innerHeight;
            const dropdownHeight = Math.min(200, dropdownElement.scrollHeight);
            
            let top = inputRect.bottom;
            let left = inputRect.left;
            
            // 检查是否会超出视口底部
            if (top + dropdownHeight > viewportHeight) {
                // 显示在输入框上方
                top = inputRect.top - dropdownHeight;
            }
            
            // 确保不会超出视口左右边界
            const dropdownWidth = Math.max(200, inputRect.width);
            if (left + dropdownWidth > window.innerWidth) {
                left = window.innerWidth - dropdownWidth - 10;
            }
            if (left < 10) {
                left = 10;
            }
            
            return { top, left, width: dropdownWidth };
        }

        // 显示下拉列表
        function showComboboxDropdown(input) {
            // 隐藏其他所有下拉列表
            hideAllDropdowns();
            
            const container = input.closest('.combobox-container');
            const dropdown = container.querySelector('.combobox-dropdown');
            
            if (dropdown) {
                const position = calculateDropdownPosition(input, dropdown);
                dropdown.style.top = position.top + 'px';
                dropdown.style.left = position.left + 'px';
                dropdown.style.width = position.width + 'px';
                dropdown.classList.add('show');
                
                // 重置高亮
                dropdown.querySelectorAll('.combobox-option').forEach(option => {
                    option.classList.remove('highlighted');
                });
            }
        }

        // 隐藏所有下拉列表
        function hideAllDropdowns() {
            document.querySelectorAll('.combobox-dropdown.show').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
        }

        // 过滤下拉选项 - 修复版本
        function filterComboboxOptions(input) {
            // 使用防抖来提高性能
            clearTimeout(input._filterTimeout);
            input._filterTimeout = setTimeout(() => {
                const container = input.closest('.combobox-container');
                const dropdown = container.querySelector('.combobox-dropdown');
                const type = input.dataset.type;
                
                if (!dropdown) return;
                
                const searchTerm = input.value.toLowerCase();
                const options = type === 'code' ? window.codeNumberOptions : window.productOptions;
                const displayField = type === 'code' ? 'code_number' : 'product_name';
                
                if (!options) return;
                
                const filteredOptions = options.filter(option => 
                    option[displayField].toLowerCase().includes(searchTerm)
                );
                
                if (filteredOptions.length === 0) {
                    dropdown.innerHTML = '<div class="no-results">未找到匹配项</div>';
                } else {
                    dropdown.innerHTML = generateComboboxOptions(filteredOptions, displayField);
                    
                    // 重新绑定点击事件
                    dropdown.querySelectorAll('.combobox-option').forEach(option => {
                        option.addEventListener('click', () => selectComboboxOption(option, input));
                    });
                }
                
                showComboboxDropdown(input);
                
                // 如果是编辑模式，只更新数据，不重新渲染表格
                const recordId = input.dataset.recordId;
                const fieldName = input.dataset.field;
                if (recordId && fieldName) {
                    const record = stockData.find(r => r.id === parseInt(recordId));
                    if (record) {
                        record[fieldName] = input.value;
                        // 不调用 updateField 避免重新渲染
                    }
                }
            }, 100); // 100ms 防抖延迟
        }

        // 选择下拉选项
        async function selectComboboxOption(optionElement, input) {
            const value = optionElement.dataset.value;
            const type = input.dataset.type;
            const recordId = input.dataset.recordId;
            
            // 标记正在进行选择操作
            input._isSelecting = true;
            
            input.value = value;
            hideAllDropdowns();
            
            // 清除选择标记
            setTimeout(() => {
                input._isSelecting = false;
            }, 200);
            
            // 触发联动更新
            if (type === 'code') {
                const productName = await getProductByCode(value); // 注意：这里应该是 getProductByCode
                if (productName) {
                    const containerId = input.closest('.combobox-container').id;
                    const isNewRow = containerId.includes('new-');
                    
                    let relatedInputId;
                    if (isNewRow) {
                        // 对于新增行，提取行ID
                        const rowIdMatch = containerId.match(/^(new-\d+)-/);
                        if (rowIdMatch) {
                            relatedInputId = `${rowIdMatch[1]}-product_name-input`;
                        } else {
                            relatedInputId = 'new-product_name-input'; // 兼容旧格式
                        }
                    } else {
                        relatedInputId = `combo-product_name-${recordId}-input`;
                    }
                    
                    const relatedInput = document.getElementById(relatedInputId);
                    if (relatedInput) {
                        relatedInput.value = productName;
                        if (recordId) {
                            updateField(parseInt(recordId), 'product_name', productName);
                        }
                    }
                }
            } else if (type === 'product') {
                const productCode = await getCodeByProduct(value);
                if (productCode) {
                    const containerId = input.closest('.combobox-container').id;
                    const isNewRow = containerId.includes('new-');
                    
                    let relatedInputId;
                    if (isNewRow) {
                        // 对于新增行，提取行ID
                        const rowIdMatch = containerId.match(/^(new-\d+)-/);
                        if (rowIdMatch) {
                            relatedInputId = `${rowIdMatch[1]}-code_number-input`;
                        } else {
                            relatedInputId = 'new-code_number-input'; // 兼容旧格式
                        }
                    } else {
                        relatedInputId = `combo-code_number-${recordId}-input`;
                    }
                    
                    const relatedInput = document.getElementById(relatedInputId);
                    if (relatedInput) {
                        relatedInput.value = productCode;
                        if (recordId) {
                            updateField(parseInt(recordId), 'code_number', productCode);
                        }
                    }
                }

                // 新增：检查是否需要更新价格下拉列表
                const containerId = input.closest('.combobox-container').id;
                if (containerId.includes('new-')) {
                    const rowIdMatch = containerId.match(/^(new-\d+)-/) || containerId.match(/^(new)-/);
                    if (rowIdMatch) {
                        const baseRowId = rowIdMatch[1];
                        const outInput = document.getElementById(`${baseRowId}-out-qty`);
                        const inInput = document.getElementById(`${baseRowId}-in-qty`);
                        
                        if (outInput && inInput) {
                            const outQty = parseFloat(outInput.value) || 0;
                            const inQty = parseFloat(inInput.value) || 0;
                            
                            if (outQty > 0 && inQty === 0) {
                                createNewRowPriceSelect(baseRowId, value);
                            }
                        }
                    }
                }
            }
            
            // 如果是编辑模式，更新字段
            if (recordId) {
                updateField(parseInt(recordId), input.dataset.field, value);
            }

            // 如果是编辑模式，确保数据已更新
            if (recordId) {
                const record = stockData.find(r => r.id === parseInt(recordId));
                if (record) {
                    record[input.dataset.field] = value;
                }
            }
        }

        // 验证输入值是否在允许的选项中
        function validateComboboxInput(input) {
            const type = input.dataset.type;
            const value = input.value.trim();
            
            if (!value) return true; // 空值允许
            
            if (type === 'code' && window.codeNumberOptions) {
                const validCodes = window.codeNumberOptions.map(c => c.code_number);
                return validCodes.includes(value);
            } else if (type === 'product' && window.productOptions) {
                const validProducts = window.productOptions.map(p => p.product_name);
                return validProducts.includes(value);
            }
            
            return true;
        }

        // 处理键盘事件
        function handleComboboxKeydown(event, input) {
            const container = input.closest('.combobox-container');
            const dropdown = container.querySelector('.combobox-dropdown');
            
            if (!dropdown.classList.contains('show')) {
                if (event.key === 'ArrowDown' || event.key === 'Enter') {
                    showComboboxDropdown(input);
                    return;
                }
                return;
            }
            
            const options = dropdown.querySelectorAll('.combobox-option');
            let highlighted = dropdown.querySelector('.combobox-option.highlighted');
            
            switch (event.key) {
                case 'ArrowDown':
                    event.preventDefault();
                    if (!highlighted) {
                        if (options.length > 0) {
                            options[0].classList.add('highlighted');
                        }
                    } else {
                        highlighted.classList.remove('highlighted');
                        const next = highlighted.nextElementSibling;
                        if (next && next.classList.contains('combobox-option')) {
                            next.classList.add('highlighted');
                        } else if (options.length > 0) {
                            options[0].classList.add('highlighted');
                        }
                    }
                    break;
                    
                case 'ArrowUp':
                    event.preventDefault();
                    if (!highlighted) {
                        if (options.length > 0) {
                            options[options.length - 1].classList.add('highlighted');
                        }
                    } else {
                        highlighted.classList.remove('highlighted');
                        const prev = highlighted.previousElementSibling;
                        if (prev && prev.classList.contains('combobox-option')) {
                            prev.classList.add('highlighted');
                        } else if (options.length > 0) {
                            options[options.length - 1].classList.add('highlighted');
                        }
                    }
                    break;
                    
                case 'Enter':
                    event.preventDefault();
                    if (highlighted) {
                        selectComboboxOption(highlighted, input);
                    }
                    break;
                    
                case 'Escape':
                    hideAllDropdowns();
                    break;
            }
        }

        // 修改渲染后的事件绑定
        function bindComboboxEvents() {
        // 为所有 combobox 输入框绑定事件
        document.querySelectorAll('.combobox-input').forEach(input => {
            // 只有在没有绑定过的情况下才绑定事件
            if (!input._eventsbound) {
                // 创建事件处理器
                const focusHandler = () => showComboboxDropdown(input);
                const inputHandler = () => filterComboboxOptions(input);
                const keydownHandler = (e) => {
                    // 限制只能输入英文、数字和空格
                    const allowedKeys = ['Backspace', 'Delete', 'Tab', 'Escape', 'Enter', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown', ' '];
                    const isAlphaNumeric = /^[a-zA-Z0-9]$/.test(e.key);
                    
                    if (!allowedKeys.includes(e.key) && !isAlphaNumeric) {
                        e.preventDefault();
                        return;
                    }
                    
                    handleComboboxKeydown(e, input);
                };
                
                // 添加 blur 事件处理器，确保编辑模式下数据被保存
                const blurHandler = (e) => {
                    // 检查是否是点击下拉选项导致的blur
                    const container = input.closest('.combobox-container');
                    const dropdown = container.querySelector('.combobox-dropdown');
                    
                    // 如果下拉列表显示中且点击的是下拉选项，则不执行验证
                    if (dropdown && dropdown.classList.contains('show')) {
                        // 延迟执行验证，给点击事件时间完成
                        setTimeout(() => {
                            // 再次检查下拉列表是否还显示，如果隐藏了说明选择已完成
                            if (!dropdown.classList.contains('show')) {
                                performValidation();
                            }
                        }, 150);
                        return;
                    }
                    
                    performValidation();
                    
                    function performValidation() {

                        if (input._isSelecting) {
                            return;
                        }
                        // 验证输入值
                        if (input.value.trim() && !validateComboboxInput(input)) {
                            const type = input.dataset.type;
                            const fieldName = type === 'code' ? '货品编号' : '货品名称';
                            showAlert(`${fieldName}不存在，请从下拉列表中选择`, 'error');
                            // 不要立即重新聚焦，给用户机会点击其他地方
                            setTimeout(() => {
                                if (document.activeElement !== input) {
                                    input.focus();
                                }
                            }, 100);
                            return;
                        }
                        
                        const recordId = input.dataset.recordId;
                        const fieldName = input.dataset.field;
                        if (recordId && fieldName) {
                            const record = stockData.find(r => r.id === parseInt(recordId));
                            if (record && record[fieldName] !== input.value) {
                                record[fieldName] = input.value;
                                // 如果是数值相关字段，需要重新计算
                                if (fieldName === 'in_quantity' || fieldName === 'out_quantity' || fieldName === 'price') {
                                    renderStockTable();
                                }
                            }
                        }
                    }
                };
                
                // 绑定事件监听器
                input.addEventListener('focus', focusHandler);
                input.addEventListener('input', inputHandler);
                input.addEventListener('keydown', keydownHandler);
                input.addEventListener('blur', blurHandler); // 这是新添加的一行
                
                // 标记已绑定
                input._eventsbound = true;
            }
        });
            
            // 为所有 combobox 选项绑定点击事件
            document.querySelectorAll('.combobox-option').forEach(option => {
                if (!option._eventsbound) {
                    const clickHandler = () => {
                        const container = option.closest('.combobox-container');
                        const input = container.querySelector('.combobox-input');
                        selectComboboxOption(option, input);
                    };
                    option.addEventListener('click', clickHandler);
                    option._eventsbound = true;
                }
            });
        }

        // 全局点击事件（隐藏下拉列表）
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.combobox-container')) {
                hideAllDropdowns();
            }
        });

        // 窗口滚动和大小变化时重新计算位置
        window.addEventListener('scroll', hideAllDropdowns);
        window.addEventListener('resize', hideAllDropdowns);
    </script>
    <script>
        // 加载货品的所有进货价格选项
        async function loadProductPrices(productName, selectElementId, currentPrice = '') {
            try {
                const result = await apiCall(`?action=product_prices&product_name=${encodeURIComponent(productName)}`);
                const selectElement = document.getElementById(selectElementId);
                
                if (!selectElement) return;
                
                if (result.success && result.data && result.data.length > 0) {
                    let options = '<option value="">请选择价格</option>';
                    // 添加手动输入选项
                    options += '<option value="manual">手动输入价格</option>';
                    
                    result.data.forEach(price => {
                        const selected = price == currentPrice ? 'selected' : '';
                        options += `<option value="${price}" ${selected}>${parseFloat(price).toFixed(2)}</option>`;
                    });
                    selectElement.innerHTML = options;
                } else {
                    selectElement.innerHTML = '<option value="">暂无历史价格</option><option value="manual">手动输入价格</option>';
                }
                
                // 如果选择了"手动输入价格"，显示输入框
                selectElement.addEventListener('change', function() {
                    handlePriceSelectChange(this);
                });
                
            } catch (error) {
                console.error('加载货品价格失败:', error);
                const selectElement = document.getElementById(selectElementId);
                if (selectElement) {
                    selectElement.innerHTML = '<option value="">加载失败</option><option value="manual">手动输入价格</option>';
                }
            }
        }

        async function createNewRowPriceSelectWithStock(rowId, productName, currentPrice = '', requiredQty = 0) {
            const priceInput = document.getElementById(`${rowId}-price`);
            const priceCell = priceInput.closest('.currency-display');
            
            // 检查是否已经是下拉选项
            if (priceCell.querySelector('.price-select')) {
                return;
            }
            
            // 创建下拉选项
            const selectElement = document.createElement('select');
            selectElement.className = 'table-select price-select';
            selectElement.id = `${rowId}-price-select`;
            selectElement.innerHTML = '<option value="">正在加载...</option>';
            
            // 隐藏输入框，显示下拉选项
            priceInput.style.display = 'none';
            priceCell.appendChild(selectElement);
            
            // 加载价格选项（带库存检查）
            await loadNewRowProductPricesWithStock(productName, selectElement.id, currentPrice, requiredQty);
            
            // 绑定变化事件
            selectElement.addEventListener('change', function() {
                handleNewRowPriceSelectChange(this, rowId);
            });
        }

        // 3. 新增函数：加载新行货品价格选项（带库存检查）
        async function loadNewRowProductPricesWithStock(productName, selectElementId, currentPrice = '', requiredQty = 0) {
            try {
                const result = await apiCall(`?action=product_prices_with_stock&product_name=${encodeURIComponent(productName)}&required_qty=${requiredQty}`);
                const selectElement = document.getElementById(selectElementId);
                
                if (!selectElement) return;
                
                if (result.success && result.data && result.data.length > 0) {
                    let options = '<option value="">请选择价格</option>';
                    options += '<option value="manual">手动输入价格</option>';
                    
                    result.data.forEach(item => {
                        const price = item.price;
                        const availableStock = item.available_stock;
                        const selected = price == currentPrice ? 'selected' : '';
                        
                        // 只显示库存足够的价格选项
                        if (availableStock >= requiredQty) {
                            options += `<option value="${price}" ${selected}>${parseFloat(price).toFixed(2)} (库存: ${availableStock})</option>`;
                        }
                    });
                    
                    selectElement.innerHTML = options;
                } else {
                    selectElement.innerHTML = '<option value="">暂无足够库存的价格</option><option value="manual">手动输入价格</option>';
                }
                
            } catch (error) {
                console.error('加载货品价格失败:', error);
                const selectElement = document.getElementById(selectElementId);
                if (selectElement) {
                    selectElement.innerHTML = '<option value="">加载失败</option><option value="manual">手动输入价格</option>';
                }
            }
        }

        async function loadAddFormProductPricesWithStock(productName, requiredQty = 0) {
            try {
                const result = await apiCall(`?action=product_prices_with_stock&product_name=${encodeURIComponent(productName)}&required_qty=${requiredQty}`);
                const selectElement = document.getElementById('add-price-select');
                
                if (!selectElement) return;
                
                if (result.success && result.data && result.data.length > 0) {
                    let options = '<option value="">请选择价格</option>';
                    options += '<option value="manual">手动输入价格</option>';
                    
                    result.data.forEach(item => {
                        const price = item.price;
                        const availableStock = item.available_stock;
                        
                        // 只显示库存足够的价格选项
                        if (availableStock >= requiredQty) {
                            options += `<option value="${price}">${parseFloat(price).toFixed(2)} (库存: ${availableStock})</option>`;
                        }
                    });
                    selectElement.innerHTML = options;
                } else {
                    selectElement.innerHTML = '<option value="">暂无足够库存的价格</option><option value="manual">手动输入价格</option>';
                }
                
            } catch (error) {
                console.error('加载货品价格失败:', error);
                const selectElement = document.getElementById('add-price-select');
                if (selectElement) {
                    selectElement.innerHTML = '<option value="">加载失败</option><option value="manual">手动输入价格</option>';
                }
            }
        }

        async function loadProductPricesWithStock(productName, selectElementId, currentPrice = '', requiredQty = 0) {
            try {
                const result = await apiCall(`?action=product_prices_with_stock&product_name=${encodeURIComponent(productName)}&required_qty=${requiredQty}`);
                const selectElement = document.getElementById(selectElementId);
                
                if (!selectElement) return;
                
                if (result.success && result.data && result.data.length > 0) {
                    let options = '<option value="">请选择价格</option>';
                    options += '<option value="manual">手动输入价格</option>';
                    
                    result.data.forEach(item => {
                        const price = item.price;
                        const availableStock = item.available_stock;
                        const selected = price == currentPrice ? 'selected' : '';
                        
                        // 只显示库存足够的价格选项，但当前价格即使库存不足也要显示（已选中的选项）
                        if (availableStock >= requiredQty || price == currentPrice) {
                            const stockInfo = availableStock >= requiredQty ? `(库存: ${availableStock})` : `(库存不足: ${availableStock})`;
                            options += `<option value="${price}" ${selected}>${parseFloat(price).toFixed(2)} ${stockInfo}</option>`;
                        }
                    });
                    
                    selectElement.innerHTML = options;
                } else {
                    selectElement.innerHTML = '<option value="">暂无足够库存的价格</option><option value="manual">手动输入价格</option>';
                }
                
                // 绑定变化事件
                selectElement.addEventListener('change', function() {
                    handlePriceSelectChange(this);
                });
                
            } catch (error) {
                console.error('加载货品价格失败:', error);
                const selectElement = document.getElementById(selectElementId);
                if (selectElement) {
                    selectElement.innerHTML = '<option value="">加载失败</option><option value="manual">手动输入价格</option>';
                }
            }
        }

        // 处理价格选择变化
        function handlePriceSelectChange(selectElement) {
            const recordId = selectElement.id.replace('price-select-', '');
            const container = selectElement.closest('.currency-display');
            
            if (selectElement.value === 'manual') {
                // 显示输入框
                const input = document.createElement('input');
                input.type = 'number';
                input.className = 'table-input currency-input-edit manual-price-input';
                input.min = '0';
                input.step = '0.01';
                input.placeholder = '输入价格';
                input.style.marginLeft = '5px';
                input.style.width = '80px';
                
                input.addEventListener('change', function() {
                    updateField(parseInt(recordId), 'price', this.value);
                    // 更新下拉选择框的值
                    selectElement.value = this.value;
                });
                
                input.addEventListener('blur', function() {
                    if (!this.value) {
                        selectElement.value = '';
                        updateField(parseInt(recordId), 'price', '');
                    }
                });
                
                // 移除已存在的输入框
                const existingInput = container.querySelector('.manual-price-input');
                if (existingInput) {
                    existingInput.remove();
                }
                
                container.appendChild(input);
                input.focus();
            } else {
                // 移除手动输入框
                const existingInput = container.querySelector('.manual-price-input');
                if (existingInput) {
                    existingInput.remove();
                }
                
                // 更新价格值
                updateField(parseInt(recordId), 'price', selectElement.value);
            }
        }
    </script>
    <script>
        // 处理新增表单中货品变化时加载价格选项
        function handleAddFormProductChange(selectElement, codeNumberElement) {
            const productName = selectElement.value;
            
            // 原有的货品变化处理
            handleProductChange(selectElement, codeNumberElement);
            
            // 根据出库数量决定是否加载价格选项
            if (productName) {
                handleAddFormOutQuantityChange();
            } else {
                const priceSelect = document.getElementById('add-price-select');
                const priceInput = document.getElementById('add-price');
                if (priceSelect) {
                    priceSelect.innerHTML = '<option value="">请先选择货品</option>';
                    priceSelect.style.display = 'none';
                }
                if (priceInput) {
                    priceInput.style.display = 'block';
                    priceInput.value = '';
                }
            }
        }

        // 加载新增表单的价格选项
        async function loadAddFormProductPrices(productName) {
            try {
                const result = await apiCall(`?action=product_prices&product_name=${encodeURIComponent(productName)}`);
                const selectElement = document.getElementById('add-price-select');
                
                if (!selectElement) return;
                
                if (result.success && result.data && result.data.length > 0) {
                    let options = '<option value="">请选择价格</option>';
                    options += '<option value="manual">手动输入价格</option>';
                    
                    result.data.forEach(price => {
                        options += `<option value="${price}">${parseFloat(price).toFixed(2)}</option>`;
                    });
                    selectElement.innerHTML = options;
                    selectElement.style.display = 'block';
                    document.getElementById('add-price').style.display = 'none';
                } else {
                    selectElement.innerHTML = '<option value="">暂无历史价格</option><option value="manual">手动输入价格</option>';
                }
                
            } catch (error) {
                console.error('加载货品价格失败:', error);
            }
        }

        // 处理新增表单价格选择变化
        function handleAddFormPriceChange() {
            const selectElement = document.getElementById('add-price-select');
            const inputElement = document.getElementById('add-price');
            
            if (selectElement.value === 'manual') {
                selectElement.style.display = 'none';
                inputElement.style.display = 'block';
                inputElement.focus();
            } else {
                inputElement.value = selectElement.value;
            }
        }
    </script>
    <script>
        // 处理新增表单出库数量变化
        function handleAddFormOutQuantityChange() {
            const outQty = parseFloat(document.getElementById('add-out-qty').value) || 0;
            const inQty = parseFloat(document.getElementById('add-in-qty').value) || 0;
            const productName = document.getElementById('add-product-name').value;
            const priceSelect = document.getElementById('add-price-select');
            const priceInput = document.getElementById('add-price');
            
            if (outQty > 0 && inQty === 0 && productName) {
                // 纯出库且有货品名称，显示价格下拉选项（带库存检查）
                priceSelect.style.display = 'block';
                priceInput.style.display = 'none';
                priceInput.value = '';
                loadAddFormProductPricesWithStock(productName, outQty);
            } else {
                // 入库或出库为0，显示普通输入框
                priceSelect.style.display = 'none';
                priceInput.style.display = 'block';
                if (outQty === 0 && inQty === 0) {
                    priceInput.value = '';
                }
            }

            // 控制Target下拉框状态
            const targetSelect = document.getElementById('add-target');
            if (outQty > 0) {
                targetSelect.disabled = false;
                targetSelect.required = true;
            } else {
                targetSelect.disabled = true;
                targetSelect.value = '';
                targetSelect.required = false;
            }
        }
    </script>
    <script>
        // 加载新增表单的价格选项
        async function loadAddFormProductPrices(productName) {
            try {
                const result = await apiCall(`?action=product_prices&product_name=${encodeURIComponent(productName)}`);
                const selectElement = document.getElementById('add-price-select');
                
                if (!selectElement) return;
                
                if (result.success && result.data && result.data.length > 0) {
                    let options = '<option value="">请选择价格</option>';
                    options += '<option value="manual">手动输入价格</option>';
                    
                    result.data.forEach(price => {
                        options += `<option value="${price}">${parseFloat(price).toFixed(2)}</option>`;
                    });
                    selectElement.innerHTML = options;
                } else {
                    selectElement.innerHTML = '<option value="">暂无历史价格</option><option value="manual">手动输入价格</option>';
                }
                
            } catch (error) {
                console.error('加载货品价格失败:', error);
                const selectElement = document.getElementById('add-price-select');
                if (selectElement) {
                    selectElement.innerHTML = '<option value="">加载失败</option><option value="manual">手动输入价格</option>';
                }
            }
        }
    </script>
    <script>
        // 检查货品库存是否足够（按货品名称和价格分别计算）
        async function checkProductStock(productName, outQuantity, price = null) {
            if (!productName || outQuantity <= 0) {
                return { sufficient: true, availableStock: 0, currentStock: 0 };
            }
            
            try {
                let apiUrl;
                if (price !== null && price !== '') {
                    // 按货品名称和价格检查库存
                    apiUrl = `?action=product_stock_by_price&product_name=${encodeURIComponent(productName)}&price=${encodeURIComponent(price)}`;
                } else {
                    // 按货品名称检查总库存
                    apiUrl = `?action=product_stock&product_name=${encodeURIComponent(productName)}`;
                }
                
                const result = await apiCall(apiUrl);
                
                if (result.success && result.data) {
                    const availableStock = parseFloat(result.data.available_stock || 0);
                    const currentStock = parseFloat(result.data.current_stock || 0);
                    
                    return {
                        sufficient: availableStock >= outQuantity,
                        availableStock: availableStock,
                        currentStock: currentStock,
                        requested: outQuantity
                    };
                } else {
                    // 如果无法获取库存信息，默认允许（可能是新货品）
                    return { sufficient: true, availableStock: 0, currentStock: 0 };
                }
                
            } catch (error) {
                console.error('检查库存失败:', error);
                // 网络错误时默认允许保存
                return { sufficient: true, availableStock: 0, currentStock: 0 };
            }
        }
    </script>
    <script>
        // 为新行创建价格下拉选项
        function createNewRowPriceSelect(rowId, productName, currentPrice = '') {
            const priceInput = document.getElementById(`${rowId}-price`);
            const priceCell = priceInput.closest('.currency-display');
            
            // 检查是否已经是下拉选项
            if (priceCell.querySelector('.price-select')) {
                return;
            }
            
            // 创建下拉选项
            const selectElement = document.createElement('select');
            selectElement.className = 'table-select price-select';
            selectElement.id = `${rowId}-price-select`;
            selectElement.innerHTML = '<option value="">正在加载...</option>';
            
            // 隐藏输入框，显示下拉选项
            priceInput.style.display = 'none';
            priceCell.appendChild(selectElement);
            
            // 加载价格选项
            loadNewRowProductPrices(productName, selectElement.id, currentPrice);
            
            // 绑定变化事件
            selectElement.addEventListener('change', function() {
                handleNewRowPriceSelectChange(this, rowId);
            });
        }

        // 恢复新行价格输入框
        function restoreNewRowPriceInput(rowId) {
            const priceInput = document.getElementById(`${rowId}-price`);
            const priceCell = priceInput.closest('.currency-display');
            const selectElement = priceCell.querySelector('.price-select');
            
            if (selectElement) {
                selectElement.remove();
                priceInput.style.display = 'block';
                priceInput.value = '';
            }
        }

        // 加载新行货品价格选项
        async function loadNewRowProductPrices(productName, selectElementId, currentPrice = '') {
            try {
                const result = await apiCall(`?action=product_prices&product_name=${encodeURIComponent(productName)}`);
                const selectElement = document.getElementById(selectElementId);
                
                if (!selectElement) return;
                
                if (result.success && result.data && result.data.length > 0) {
                    let options = '<option value="">请选择价格</option>';
                    options += '<option value="manual">手动输入价格</option>';
                    
                    result.data.forEach(price => {
                        const selected = price == currentPrice ? 'selected' : '';
                        options += `<option value="${price}" ${selected}>${parseFloat(price).toFixed(2)}</option>`;
                    });
                    selectElement.innerHTML = options;
                } else {
                    selectElement.innerHTML = '<option value="">暂无历史价格</option><option value="manual">手动输入价格</option>';
                }
                
            } catch (error) {
                console.error('加载货品价格失败:', error);
                const selectElement = document.getElementById(selectElementId);
                if (selectElement) {
                    selectElement.innerHTML = '<option value="">加载失败</option><option value="manual">手动输入价格</option>';
                }
            }
        }

        // 处理新行价格下拉选择变化
        function handleNewRowPriceSelectChange(selectElement, rowId) {
            const priceInput = document.getElementById(`${rowId}-price`);
            const container = selectElement.closest('.currency-display');
            
            if (selectElement.value === 'manual') {
                // 显示手动输入框
                const manualInput = document.createElement('input');
                manualInput.type = 'number';
                manualInput.className = 'table-input currency-input-edit manual-price-input';
                manualInput.min = '0';
                manualInput.step = '0.01';
                manualInput.placeholder = '输入价格';
                manualInput.style.marginLeft = '5px';
                manualInput.style.width = '80px';
                
                manualInput.addEventListener('input', function() {
                    priceInput.value = this.value;
                    updateNewRowTotal(priceInput);
                });
                
                manualInput.addEventListener('blur', function() {
                    if (!this.value) {
                        selectElement.value = '';
                        priceInput.value = '';
                        updateNewRowTotal(priceInput);
                    }
                });
                
                // 移除已存在的手动输入框
                const existingInput = container.querySelector('.manual-price-input');
                if (existingInput) {
                    existingInput.remove();
                }
                
                container.appendChild(manualInput);
                manualInput.focus();
            } else {
                // 移除手动输入框
                const existingInput = container.querySelector('.manual-price-input');
                if (existingInput) {
                    existingInput.remove();
                }
                
                // 更新价格值
                priceInput.value = selectElement.value;
                updateNewRowTotal(priceInput);
            }
        }
    </script>
    <script>
        // 关闭导出弹窗
        function closeExportModal() {
            document.getElementById('export-modal').style.display = 'none';
            
            // 重置导出按钮状态
            const exportBtn = document.querySelector('.export-modal-actions .btn-success');
            if (exportBtn) {
                exportBtn.innerHTML = '<i class="fas fa-download"></i> 导出PDF发票';
                exportBtn.disabled = false;
            }
        }

        // 确认导出
        async function confirmExport() {
            const startDate = document.getElementById('export-start-date').value;
            const endDate = document.getElementById('export-end-date').value;
            const exportSystem = document.getElementById('export-system').value;
            const invoiceNumber = ''; // 自动生成，不需要用户输入
            const invoiceDate = document.getElementById('export-invoice-date').value;

            // 验证输入
            if (!startDate || !endDate) {
                showAlert('请选择开始和结束日期', 'error');
                return;
            }

            if (!exportSystem) {
                showAlert('请选择导出系统', 'error');
                return;
            }

            // J1和J2系统都自动生成发票号码（分开计算）
            const generatedInvoiceNumber = generateInvoiceNumber(exportSystem);
            
            if (new Date(startDate) > new Date(endDate)) {
                showAlert('开始日期不能晚于结束日期', 'error');
                return;
            }
            
            // 显示加载状态
            const exportBtn = document.querySelector('.export-modal-actions .btn-success');
            const originalText = exportBtn.innerHTML;
            exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 生成中...';
            exportBtn.disabled = true;
            
            try {
                
                // 获取指定日期范围内的出库数据
                const params = new URLSearchParams({
                    action: 'list',
                    search_start_date: startDate,
                    search_end_date: endDate
                });
                
                const result = await apiCall(`?${params}`);
                
                if (!result.success) {
                    throw new Error('获取数据失败');
                }
                
                // 过滤出库数据 - 按日期范围、出库数量和收货单位筛选
                const outData = (result.data || []).filter(record => {
                    const outQty = parseFloat(record.out_quantity);
                    if (outQty <= 0) return false;
                    
                    // 检查收货单位是否匹配选择的店面
                    const targetSystem = record.target_system;
                    if (!targetSystem || targetSystem.toLowerCase() !== exportSystem.toLowerCase()) {
                        return false;
                    }
                    
                    // 检查日期范围
                    const recordDate = record.date || record.out_date || record.created_at;
                    if (!recordDate) return false;
                    
                    const recordDateObj = new Date(recordDate);
                    const startDateObj = new Date(startDate);
                    const endDateObj = new Date(endDate);
                    
                    // 设置时间为当天的开始和结束
                    startDateObj.setHours(0, 0, 0, 0);
                    endDateObj.setHours(23, 59, 59, 999);
                    
                    return recordDateObj >= startDateObj && recordDateObj <= endDateObj;
                });
                
                if (outData.length === 0) {
                    showAlert('指定日期范围内没有出库数据', 'error');
                    return;
                }
                
                // 根据记录数量决定使用单页还是多页模板
                const recordCount = outData.length;
                const useMultiPage = (exportSystem === 'j1' && recordCount > 30) || (exportSystem === 'j2' && recordCount > 25);
                
                if (useMultiPage) {
                    // 使用多页模板
                    const pageCount = Math.ceil(recordCount / (exportSystem === 'j1' ? 30 : 25));
                    showAlert(`记录数量较多(${recordCount}条)，将使用多页模板生成PDF (共${pageCount}页)`, 'info');
                    await generateMultiPageInvoicePDF(outData, startDate, endDate, exportSystem, generatedInvoiceNumber, invoiceDate);
                } else {
                    // 使用单页模板
                    await generateInvoicePDF(outData, startDate, endDate, exportSystem, generatedInvoiceNumber, invoiceDate);
                }
                
                showAlert('PDF发票生成成功', 'success');
                closeExportModal();
                
            } catch (error) {
                console.error('导出失败:', error);
                showAlert('生成PDF发票失败，请重试', 'error');
            } finally {
                // 恢复按钮状态
                const exportBtn = document.querySelector('.export-modal-actions .btn-success');
                exportBtn.innerHTML = originalText;
                exportBtn.disabled = false;
            }
        }

        // 点击弹窗外部关闭
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('export-modal');
            if (event.target === modal) {
                closeExportModal();
            }
        });

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
                const scrollThreshold = 150; // 滚动超过150px后显示按钮
                
                if (window.pageYOffset > scrollThreshold) {
                    backToTopBtn.classList.add('show');
                } else {
                    backToTopBtn.classList.remove('show');
                }
            }, 10);
        });

        // 生成发票号码 - J1和J2分开计算，从00001开始
        function generateInvoiceNumber(exportSystem) {
            // 根据系统类型使用不同的计数器
            const systemKey = `invoice_counter_${exportSystem}`;
            let counter = parseInt(localStorage.getItem(systemKey)) || 0;
            counter++;
            localStorage.setItem(systemKey, counter.toString());
            
            // 生成5位数字的发票号码，从00001开始
            const invoiceNumber = String(counter).padStart(5, '0');
            
            console.log(`${exportSystem.toUpperCase()}系统发票号码: ${invoiceNumber}`);
            return invoiceNumber;
        }

        // 生成PDF发票
        async function generateInvoicePDF(outData, startDate, endDate, exportSystem, invoiceNumber = '', invoiceDate = '') {
            try {
                
                console.log('开始生成PDF发票:', {
                    exportSystem,
                    dataLength: outData ? outData.length : 0,
                    startDate,
                    endDate,
                    invoiceNumber
                });
                
                // 如果没有提供发票号码，自动生成一个
                if (!invoiceNumber) {
                    invoiceNumber = generateInvoiceNumber(exportSystem);
                }
                
                // 下载现有的PDF模板
                const templateFile = exportSystem === 'j2' ? `invoice/invoice/j2invoice.pdf?ts=${Date.now()}` : `invoice/invoice/j1invoice.pdf?ts=${Date.now()}`;
                const templateResponse = await fetch(templateFile);
                if (!templateResponse.ok) {
                    throw new Error('无法加载PDF模板');
                }
                
                const templateBytes = await templateResponse.arrayBuffer();
                
                // 使用PDF-lib库来编辑PDF
                const { PDFDocument, rgb, StandardFonts } = PDFLib;
                const pdfDoc = await PDFDocument.load(templateBytes);

                // 获取第一页
                const page = pdfDoc.getPage(0);
                const { width, height } = page.getSize();

                // 嵌入字体
                const boldFont = await pdfDoc.embedFont(StandardFonts.HelveticaBold);
                const regularFont = await pdfDoc.embedFont(StandardFonts.Helvetica);

                // 设置字体大小和颜色
                const fontSize = 14;
                const smallFontSize = 10;
                const textColor = rgb(0, 0, 0);
                const whiteColor = rgb(1, 1, 1); // 白色
                
                // 字体对齐辅助函数
                function getRightAlignedX(text, maxX, charWidth = 6) {
                    return maxX - (text.length * charWidth);
                }
                
                function getCenterAlignedX(text, centerX, charWidth = 6) {
                    return centerX - (text.length * charWidth / 2);
                }
                
                // 填入日期 (右上角区域)
                const currentDate = invoiceDate ? 
                    new Date(invoiceDate).toLocaleDateString('en-GB') : 
                    new Date().toLocaleDateString('en-GB');

                if (exportSystem === 'j1') {
                    // J1模板的日期位置
                    page.drawText(` ${currentDate}`, {
                        x: 470, // J1模板DATE冒号后面的位置
                        y: height - 129.5, 
                        size: fontSize,
                        color: whiteColor,
                        font: boldFont,
                    });
                    
                    // J1模板的发票号码位置
                    if (invoiceNumber) {
                        page.drawText(invoiceNumber, {
                            x: 105, // J1模板Invoice No位置
                            y: height - 129.5, // 调整到Invoice No行
                            size: fontSize,
                            color: whiteColor,
                            font: boldFont,
                        });
                    }
                } else if (exportSystem === 'j2') {
                    // J2模板的日期位置
                    page.drawText(` ${currentDate}`, {
                        x: 470, // J2模板DATE冒号后面的位置 (可根据需要调整)
                        y: height - 175, // J2模板的Y坐标 (可根据需要调整)
                        size: fontSize,
                        color: whiteColor,
                        font: boldFont,
                    });
                    
                    // J2模板的发票号码位置
                    if (invoiceNumber) {
                        page.drawText(invoiceNumber, {
                            x: 105,
                            y: height - 175, // 调整到Invoice No行
                            size: fontSize,
                            color: whiteColor,
                            font: boldFont,
                        });
                    }
                }
                
                // 计算总金额
                let grandTotal = 0;
                
                // 填入数据行 (从第一个数据行开始)
                let yPosition, lineHeight;
                if (exportSystem === 'j1') {
                    yPosition = height - 185; // J1模板的起始Y坐标
                    lineHeight = 16.01; // J1模板的行高
                } else { // j2
                    yPosition = height - 223; // J2模板的起始Y坐标
                    lineHeight = 16.01; // J2模板的行高
                }

                // 清除缓存并强制刷新 - 版本 2.0
                console.log('=== PDF生成调试信息 v2.0 ===');
                console.log('outData类型:', typeof outData);
                console.log('outData长度:', outData.length);
                console.log('outData内容:', outData);
                
                if (outData.length === 0) {
                    console.warn('警告：outData为空，将显示空白发票');
                }
                
                outData.forEach((record, index) => {
                    const itemNumber = index + 1;
                    const outQty = parseFloat(record.out_quantity) || 0;
                    const price = parseFloat(record.price) || 0;
                    const total = outQty * price;
                    grandTotal += total;
                    
                    // NO (第一列) - 居中对齐
                    const itemText = itemNumber.toString();
                    page.drawText(itemText, {
                        x: getCenterAlignedX(itemText, exportSystem === 'j1' ? 39 : 39, 6),
                        y: yPosition,
                        size: smallFontSize,
                        color: textColor,
                        font: boldFont,
                    });
                    
                    // Descriptions (第二列) - 左对齐，调整产品名称显示，处理长文本
                    const productName = record.product_name || '';
                    const maxProductNameLength = 20;
                    const displayProductName = productName.length > maxProductNameLength 
                        ? productName.substring(0, maxProductNameLength) + '...' 
                        : productName;
                    
                    page.drawText(displayProductName.toUpperCase(), {
                        x: exportSystem === 'j1' ? 62 : 62,
                        y: yPosition,
                        size: smallFontSize,
                        color: textColor,
                        font: boldFont,
                    });
                    
                    // Quantity (第三列) - 右对齐
                    const qtyText = outQty.toFixed(2);
                    page.drawText(qtyText, {
                        x: getRightAlignedX(qtyText, exportSystem === 'j1' ? 360 : 360, 5),
                        y: yPosition,
                        size: smallFontSize,
                        color: textColor,
                        font: boldFont,
                    });
                    
                    // UOM (第四列) - 左对齐
                    const uomText = record.specification || '';
                    page.drawText(uomText.toUpperCase(), {
                        x: exportSystem === 'j1' ? 370 : 370,
                        y: yPosition,
                        size: 8, 
                        color: textColor,
                        font: boldFont,
                    });
                    
                    // Price RM (第五列) - 右对齐
                    const priceText = price.toFixed(2);
                    page.drawText(priceText, {
                        x: getRightAlignedX(priceText, exportSystem === 'j1' ? 480 : 480, 6),
                        y: yPosition,
                        size: smallFontSize,
                        color: textColor,
                        font: boldFont,
                    });
                    
                    // Total RM (第六列) - 右对齐
                    const totalText = total.toFixed(2);
                    page.drawText(totalText, {
                        x: getRightAlignedX(totalText, exportSystem === 'j1' ? 565 : 565, 6),
                        y: yPosition,
                        size: smallFontSize,
                        color: textColor,
                        font: boldFont,
                    });
                    
                    yPosition -= lineHeight;
                });                

                if (exportSystem === 'j2') {
                    // J2模板：计算subtotal, charge 15%, 和最终total
                    const subtotal = grandTotal;
                    const charge = subtotal * 0.15;
                    const finalTotal = subtotal + charge;
                    
                    // 填入Subtotal
                    const subtotalText = `RM${subtotal.toFixed(2)}`;
                    page.drawText(subtotalText, {
                        x: getRightAlignedX(subtotalText, 565, 6.5),
                        y: height - 708, // 调整到Subtotal行
                        size: 11,
                        color: textColor,
                        font: boldFont,
                    });
                    
                    // 填入Charge 15%
                    const chargeText = `RM${charge.toFixed(2)}`;
                    page.drawText(chargeText, {
                        x: getRightAlignedX(chargeText, 565, 6.5),
                        y: height - 721, // 调整到Charge行
                        size: 11,
                        color: textColor,
                        font: boldFont,
                    });
                    
                    // 填入最终Total
                    const finalTotalText = `RM${finalTotal.toFixed(2)}`;
                    page.drawText(finalTotalText, {
                        x: getRightAlignedX(finalTotalText, 565, 8),
                        y: height - 745, // 调整到最终Total行
                        size: fontSize,
                        color: textColor,
                        font: boldFont,
                    });
                } else {
                    // J1模板：只显示总计
                    const totalText = `RM${grandTotal.toFixed(2)}`;
                    page.drawText(totalText, {
                        x: getRightAlignedX(totalText, 565, 8),
                        y: height - 755,
                        size: fontSize,
                        color: textColor,
                        font: boldFont,
                    });
                }
                
                // 生成并下载PDF
                const pdfBytes = await pdfDoc.save();
                
                // 创建下载链接
                const blob = new Blob([pdfBytes], { type: 'application/pdf' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.download = `invoice_${exportSystem}_${startDate}_${endDate}.pdf`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                URL.revokeObjectURL(url);
                
            } catch (error) {
                console.error('PDF生成失败:', error);
                console.error('错误详情:', {
                    message: error.message,
                    stack: error.stack,
                    exportSystem: exportSystem,
                    dataLength: outData ? outData.length : 0
                });
                throw error;
            }
        }

        // 生成多页PDF发票
        async function generateMultiPageInvoicePDF(outData, startDate, endDate, exportSystem, invoiceNumber = '', invoiceDate = '') {
            try {
                console.log('开始生成多页PDF发票:', {
                    exportSystem,
                    dataLength: outData ? outData.length : 0,
                    startDate,
                    endDate,
                    invoiceNumber
                });
                
                // 如果没有提供发票号码，自动生成一个
                if (!invoiceNumber) {
                    invoiceNumber = generateInvoiceNumber(exportSystem);
                }
                
                // 计算每页可容纳的记录数
                const recordsPerPage = exportSystem === 'j1' ? 30 : 28;
                const totalPages = Math.ceil(outData.length / recordsPerPage);
                
                console.log(`多页PDF: 总记录数 ${outData.length}, 每页 ${recordsPerPage} 条, 共 ${totalPages} 页`);
                
                // 加载所需的模板文件
                const templateFiles = [];
                for (let pageIndex = 0; pageIndex < totalPages; pageIndex++) {
                    let templateFile;
                    if (pageIndex === 0) {
                        // 第一页使用 (1) 模板
                        templateFile = exportSystem === 'j2' ? `invoice/invoice/j2invoiceMulti(1).pdf?ts=${Date.now()}` : `invoice/invoice/j1invoiceMulti(1).pdf?ts=${Date.now()}`;
                    } else {
                        // 后续页使用 (2) 模板
                        templateFile = exportSystem === 'j2' ? `invoice/invoice/j2invoiceMulti(2).pdf?ts=${Date.now()}` : `invoice/invoice/j1invoiceMulti(2).pdf?ts=${Date.now()}`;
                    }
                    templateFiles.push(templateFile);
                }
                
                // 使用PDF-lib库来创建最终PDF
                const { PDFDocument, rgb, StandardFonts } = PDFLib;
                const finalPdfDoc = await PDFDocument.create();

                // 嵌入字体
                const boldFont = await finalPdfDoc.embedFont(StandardFonts.HelveticaBold);
                const regularFont = await finalPdfDoc.embedFont(StandardFonts.Helvetica);

                // 设置字体大小和颜色
                const fontSize = 14;
                const smallFontSize = 10;
                const textColor = rgb(0, 0, 0);
                const whiteColor = rgb(1, 1, 1);
                
                // 字体对齐辅助函数
                function getRightAlignedX(text, maxX, charWidth = 6) {
                    return maxX - (text.length * charWidth);
                }
                
                function getCenterAlignedX(text, centerX, charWidth = 6) {
                    return centerX - (text.length * charWidth / 2);
                }
                
                let grandTotal = 0;
                
                // 为每页加载模板并填入数据
                for (let pageIndex = 0; pageIndex < totalPages; pageIndex++) {
                    try {
                        // 加载当前页的模板
                        const templateResponse = await fetch(templateFiles[pageIndex]);
                        if (!templateResponse.ok) {
                            throw new Error(`无法加载模板文件: ${templateFiles[pageIndex]}`);
                        }
                        
                        const templateBytes = await templateResponse.arrayBuffer();
                        const templateDoc = await PDFDocument.load(templateBytes);
                        
                        // 复制模板页到最终文档
                        const [templatePage] = await finalPdfDoc.copyPages(templateDoc, [0]);
                        const page = finalPdfDoc.addPage(templatePage);
                        const { width, height } = page.getSize();
                        
                        // 填入日期和发票号码
                        if (pageIndex === 0) {
                            const currentDate = invoiceDate ? 
                                new Date(invoiceDate).toLocaleDateString('en-GB') : 
                                new Date().toLocaleDateString('en-GB');

                            if (exportSystem === 'j1') {
                                // J1模板的日期位置
                                page.drawText(` ${currentDate}`, {
                                    x: 470,
                                    y: height - 129.5, 
                                    size: fontSize,
                                    color: whiteColor,
                                    font: boldFont,
                                });
                                
                                // J1模板的发票号码位置
                                if (invoiceNumber) {
                                    page.drawText(invoiceNumber, {
                                        x: 105,
                                        y: height - 129.5,
                                        size: fontSize,
                                        color: whiteColor,
                                        font: boldFont,
                                    });
                                }
                            } else if (exportSystem === 'j2') {
                                // J2模板的日期位置 (J2保持每页都显示)
                                page.drawText(` ${currentDate}`, {
                                    x: 470,
                                    y: height - 175,
                                    size: fontSize,
                                    color: whiteColor,
                                    font: boldFont,
                                });
                                
                                // J2模板的发票号码位置
                                if (invoiceNumber) {
                                    page.drawText(invoiceNumber, {
                                        x: 105,
                                        y: height - 175,
                                        size: fontSize,
                                        color: whiteColor,
                                        font: boldFont,
                                    });
                                }
                            }
                        }
                        
                        // 计算当前页的数据范围
                        const startIndex = pageIndex * recordsPerPage;
                        const endIndex = Math.min(startIndex + recordsPerPage, outData.length);
                        const pageData = outData.slice(startIndex, endIndex);
                        
                        // 填入数据行
                        let yPosition, lineHeight;
                        if (exportSystem === 'j1') {
                            if (pageIndex === 0) {
                                yPosition = height - 185; // J1第一页位置
                            } else {
                                yPosition = height - 25;  // J1第二页位置
                            }
                            lineHeight = 16.01;
                        } else { // j2
                            if (pageIndex === 0) {
                                yPosition = height - 223; // J2第一页位置（原来的位置）
                            } else {
                                yPosition = height - 32; // J2第二页位置（可调整这个数值）
                            }
                            lineHeight = 16.01;
                        }

                        pageData.forEach((record, index) => {
                            const itemNumber = startIndex + index + 1;
                            const outQty = parseFloat(record.out_quantity) || 0;
                            const price = parseFloat(record.price) || 0;
                            const total = outQty * price;
                            grandTotal += total;
                            
                            // NO (第一列)
                            const itemText = itemNumber.toString();
                            page.drawText(itemText, {
                                x: getCenterAlignedX(itemText, 39, 6),
                                y: yPosition,
                                size: smallFontSize,
                                color: textColor,
                                font: boldFont,
                            });
                            
                            // Descriptions (第二列)
                            const productName = record.product_name || '';
                            const maxProductNameLength = 20;
                            const displayProductName = productName.length > maxProductNameLength 
                                ? productName.substring(0, maxProductNameLength) + '...' 
                                : productName;
                            
                            page.drawText(displayProductName.toUpperCase(), {
                                x: 62,
                                y: yPosition,
                                size: smallFontSize,
                                color: textColor,
                                font: boldFont,
                            });
                            
                            // Quantity (第三列)
                            const qtyText = outQty.toFixed(2);
                            page.drawText(qtyText, {
                                x: getRightAlignedX(qtyText, 360, 5),
                                y: yPosition,
                                size: smallFontSize,
                                color: textColor,
                                font: boldFont,
                            });
                            
                            // UOM (第四列)
                            const uomText = record.specification || '';
                            page.drawText(uomText.toUpperCase(), {
                                x: 370,
                                y: yPosition,
                                size: 8, 
                                color: textColor,
                                font: boldFont,
                            });
                            
                            // Price RM (第五列)
                            const priceText = price.toFixed(2);
                            page.drawText(priceText, {
                                x: getRightAlignedX(priceText, 480, 6),
                                y: yPosition,
                                size: smallFontSize,
                                color: textColor,
                                font: boldFont,
                            });
                            
                            // Total RM (第六列)
                            const totalText = total.toFixed(2);
                            page.drawText(totalText, {
                                x: getRightAlignedX(totalText, 565, 6),
                                y: yPosition,
                                size: smallFontSize,
                                color: textColor,
                                font: boldFont,
                            });
                            
                            yPosition -= lineHeight;
                        });
                        
                        // 只在最后一页显示总计
                        if (pageIndex === totalPages - 1) {
                            if (exportSystem === 'j2') {
                                // J2模板：计算subtotal, charge 15%, 和最终total
                                const subtotal = grandTotal;
                                const charge = subtotal * 0.15;
                                const finalTotal = subtotal + charge;
                                
                                // 填入Subtotal
                                const subtotalText = `RM${subtotal.toFixed(2)}`;
                                page.drawText(subtotalText, {
                                    x: getRightAlignedX(subtotalText, 565, 6.5),
                                    y: height - 708,
                                    size: 11,
                                    color: textColor,
                                    font: boldFont,
                                });
                                
                                // 填入Charge 15%
                                const chargeText = `RM${charge.toFixed(2)}`;
                                page.drawText(chargeText, {
                                    x: getRightAlignedX(chargeText, 565, 6.5),
                                    y: height - 721,
                                    size: 11,
                                    color: textColor,
                                    font: boldFont,
                                });
                                
                                // 填入最终Total
                                const finalTotalText = `RM${finalTotal.toFixed(2)}`;
                                page.drawText(finalTotalText, {
                                    x: getRightAlignedX(finalTotalText, 565, 8),
                                    y: height - 745,
                                    size: fontSize,
                                    color: textColor,
                                    font: boldFont,
                                });
                            } else {
                                // J1模板：只显示总计
                                const totalText = `RM${grandTotal.toFixed(2)}`;
                                page.drawText(totalText, {
                                    x: getRightAlignedX(totalText, 565, 8),
                                    y: height - 755,
                                    size: fontSize,
                                    color: textColor,
                                    font: boldFont,
                                });
                            }
                        }
                        
                    } catch (templateError) {
                        console.error(`加载模板 ${templateFiles[pageIndex]} 失败:`, templateError);
                        throw new Error(`无法加载模板文件: ${templateFiles[pageIndex]}`);
                    }
                }
                
                // 生成并下载PDF
                const pdfBytes = await finalPdfDoc.save();
                
                // 创建下载链接
                const blob = new Blob([pdfBytes], { type: 'application/pdf' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.download = `invoice_${exportSystem}_multipage_${startDate}_${endDate}.pdf`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                URL.revokeObjectURL(url);
                
            } catch (error) {
                console.error('多页PDF生成失败:', error);
                console.error('错误详情:', {
                    message: error.message,
                    stack: error.stack,
                    exportSystem: exportSystem,
                    dataLength: outData ? outData.length : 0
                });
                throw error;
            }
        }

        // 处理导出系统选择变化
        function handleExportSystemChange() {
            // 发票号码现在完全自动生成，不需要处理界面变化
            console.log('导出系统已选择:', document.getElementById('export-system').value);
        }

        // 切换批量删除模式
        function toggleBatchDelete() {
            isBatchDeleteMode = true;
            selectedRecords.clear();
            
            // 显示/隐藏按钮
            document.getElementById('batch-delete-btn').style.display = 'none';
            document.getElementById('confirm-batch-delete-btn').style.display = 'inline-block';
            document.getElementById('cancel-batch-delete-btn').style.display = 'inline-block';
            
            // 更改表头
            document.getElementById('action-header').textContent = '选择';
            
            // 重新渲染表格
            renderStockTable();
            
            showAlert('批量删除模式已启用，请勾选要删除的记录', 'info');
        }

        // 取消批量删除模式
        function cancelBatchDelete() {
            isBatchDeleteMode = false;
            selectedRecords.clear();
            
            // 显示/隐藏按钮
            document.getElementById('batch-delete-btn').style.display = 'inline-block';
            document.getElementById('confirm-batch-delete-btn').style.display = 'none';
            document.getElementById('cancel-batch-delete-btn').style.display = 'none';
            
            // 恢复表头
            document.getElementById('action-header').textContent = '操作';
            
            // 重新渲染表格
            renderStockTable();
        }

        // 切换记录选择状态
        function toggleRecordSelection(recordId, isSelected) {
            if (isSelected) {
                selectedRecords.add(recordId);
            } else {
                selectedRecords.delete(recordId);
            }
            
            // 更新确认按钮状态
            const confirmBtn = document.getElementById('confirm-batch-delete-btn');
            if (selectedRecords.size > 0) {
                confirmBtn.innerHTML = `<i class="fas fa-check"></i> 确认删除 (${selectedRecords.size})`;
                confirmBtn.disabled = false;
            } else {
                confirmBtn.innerHTML = '<i class="fas fa-check"></i> 确认删除';
                confirmBtn.disabled = true;
            }
        }

        // 生成Type选项
        function generateTypeOptions(selectedValue = '') {
            const typeOptions = ['Kitchen', 'SushiBar', 'Drink', 'Sake'];
            let options = '<option value="">请选择类型</option>';
            typeOptions.forEach(type => {
                const selected = type === selectedValue ? 'selected' : '';
                options += `<option value="${type}" ${selected}>${type}</option>`;
            });
            return options;
        }

        // 确认批量删除
        async function confirmBatchDelete() {
            if (selectedRecords.size === 0) {
                showAlert('请至少选择一条记录', 'error');
                return;
            }
            
            if (!confirm(`确定要删除选中的 ${selectedRecords.size} 条记录吗？此操作不可恢复！`)) {
                return;
            }
            
            const confirmBtn = document.getElementById('confirm-batch-delete-btn');
            const originalText = confirmBtn.innerHTML;
            confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 删除中...';
            confirmBtn.disabled = true;
            
            try {
                let successCount = 0;
                let failCount = 0;
                
                // 逐个删除选中的记录
                for (const recordId of selectedRecords) {
                    try {
                        const result = await apiCall(`?id=${recordId}`, {
                            method: 'DELETE'
                        });
                        
                        if (result.success) {
                            successCount++;
                        } else {
                            failCount++;
                        }
                    } catch (error) {
                        failCount++;
                        console.error(`删除记录 ${recordId} 失败:`, error);
                    }
                }
                
                // 显示删除结果
                if (successCount > 0) {
                    showAlert(`成功删除 ${successCount} 条记录${failCount > 0 ? `，${failCount} 条失败` : ''}`, 
                            failCount > 0 ? 'warning' : 'success');
                } else {
                    showAlert('删除失败', 'error');
                }
                
                // 退出批量删除模式并刷新数据
                cancelBatchDelete();
                loadStockData();
                
            } catch (error) {
                showAlert('批量删除时发生错误', 'error');
                confirmBtn.innerHTML = originalText;
                confirmBtn.disabled = false;
            }
        }
    </script>
</body>
</html>