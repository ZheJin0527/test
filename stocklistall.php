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
            gap: 16px;
        }

        /* 系统选择器样式 */
        .system-selector {
            position: relative;
        }

        .selector-button {
            background-color: #583e04;
            color: white;
            font-weight: 500;
            padding: 8px 20px;
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
        .stock-table th:nth-child(2), .stock-table td:nth-child(2) { width: 200px; } /* Product Name */
        .stock-table th:nth-child(3), .stock-table td:nth-child(3) { width: 120px; } /* Code Number */
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

        /* 页面模式选择器样式 */
        .page-mode-selector {
            position: relative;
        }

        .page-mode-selector .selector-button {
            background-color: #10b981;
            min-width: 120px;
        }

        .page-mode-selector .selector-button:hover {
            background-color: #059669;
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.2);
        }

        .page-mode-selector .selector-dropdown {
            min-width: 120px;
            border: 2px solid #10b981;
        }

        .page-mode-selector .dropdown-item.active {
            background-color: #10b981;
            color: white;
        }

        .page-mode-selector .selector-button:disabled {
            opacity: 0.5;
            cursor: not-allowed !important;
            background-color: #6b7280 !important;
        }

        .page-mode-selector .selector-button:disabled:hover {
            transform: none !important;
            box-shadow: none !important;
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
        
        .recordedit-body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f1dfbc;
            color: #111827;
        }
        
        .recordedit-container {
            max-width: 1800px;
            margin: 0 auto;
            padding: 24px;
        }
        
        .recordedit-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }
        
        .recordedit-header h1 {
            font-size: 56px;
            font-weight: bold;
            color: #583e04;
        }
        
        .recordedit-header .recordedit-controls {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .recordedit-back-button {
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
        
        .recordedit-back-button:hover {
            background-color: #462d03;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(88, 62, 4, 0.2);
        }

        /* Alert Messages */
        .recordedit-alert {
            padding: 12px 16px;
            margin-bottom: 16px;
            border-radius: 8px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .recordedit-alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        
        .recordedit-alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .recordedit-alert-info {
            background-color: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }

        /* 搜索和过滤区域 */
        .recordedit-filter-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            border: 2px solid #583e04;
            box-shadow: 0 2px 8px rgba(88, 62, 4, 0.1);
        }

        .recordedit-filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            margin-bottom: 16px;
        }

        .recordedit-filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .recordedit-filter-group label {
            font-size: 14px;
            font-weight: 600;
            color: #583e04;
        }

        .recordedit-filter-input, .recordedit-filter-select {
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            color: #583e04;
        }

        .recordedit-filter-input:focus, .recordedit-filter-select:focus {
            outline: none;
            border-color: #583e04;
            box-shadow: 0 0 0 3px rgba(88, 62, 4, 0.1);
        }

        .recordedit-filter-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .recordedit-btn {
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
        
        .recordedit-btn-primary {
            background-color: #583e04;
            color: white;
        }
        
        .recordedit-btn-primary:hover {
            background-color: #462d03;
            transform: translateY(-1px);
        }
        
        .recordedit-btn-success {
            background-color: #10b981;
            color: white;
        }
        
        .recordedit-btn-success:hover {
            background-color: #059669;
            transform: translateY(-1px);
        }

        .recordedit-btn-secondary {
            background-color: #6b7280;
            color: white;
        }
        
        .recordedit-btn-secondary:hover {
            background-color: #4b5563;
            transform: translateY(-1px);
        }

        .recordedit-btn-warning {
            background-color: #f59e0b;
            color: white;
        }
        
        .recordedit-btn-warning:hover {
            background-color: #d97706;
            transform: translateY(-1px);
        }

        .recordedit-btn-danger {
            background-color: #ef4444;
            color: white;
        }
        
        .recordedit-btn-danger:hover {
            background-color: #dc2626;
            transform: translateY(-1px);
        }

        .recordedit-stock-table {
            table-layout: fixed;
            width: 100%;
            min-width: 1400px;
            border-collapse: collapse;
            font-size: 14px;
        }

        .recordedit-stock-table th {
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

        .recordedit-stock-table td {
            padding: 0;
            border: 1px solid #d1d5db;
            text-align: center;
            position: relative;
        }

        .recordedit-stock-table tr:nth-child(even) {
            background-color: white;
        }

        .recordedit-stock-table tr:hover {
            background-color: #e5ebf8ff;
        }

        /* 确保显示文本和编辑输入框对齐 */
        .recordedit-stock-table td span {
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
        .recordedit-stock-table td span[style*="padding-left: 32px"] {
            text-align: right;
            padding-left: 32px;
            padding-right: 8px;
        }

        /* 日期单元格内的文本对齐 */
        .recordedit-date-cell {
            background: #f8f5eb !important;
            font-weight: 600;
            color: #583e04;
            padding: 12px 8px;
            min-width: 100px;
            text-align: center;
            vertical-align: middle;
        }

        /* 计算列内的文本对齐 */
        .recordedit-calculated-cell {
            background: #f0f9ff !important;
            color: #0369a1;
            font-weight: 600;
            padding: 12px 8px;
            min-width: 100px;
            text-align: center;
            vertical-align: middle;
        }

        /* 输入框容器样式 */
        .recordedit-input-container {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
            height: 40px;
        }

        .recordedit-currency-prefix {
            position: absolute;
            left: 8px;
            color: #6b7280;
            font-size: 13px;
            font-weight: 500;
            pointer-events: none;
            z-index: 2;
        }

        /* 表格输入框样式 */
        .recordedit-table-input {
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

        .recordedit-table-input.recordedit-currency-input {
            padding-left: 32px;
            text-align: center;
            padding-right: 8px;
        }

        .recordedit-table-input:focus {
            background: #fff;
            border: 2px solid #583e04;
            outline: none;
            z-index: 5;
            position: relative;
        }

        .recordedit-table-select {
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

        .recordedit-table-select:focus {
            background: #fff;
            border: 2px solid #583e04;
            outline: none;
        }

        /* 货币显示容器 */
        .recordedit-currency-display {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 8px 15px;
            height: 40px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .recordedit-currency-display .recordedit-currency-symbol {
            color: #6b7280;
            font-weight: 500;
            margin-right: 6px;
            min-width: 24px;
            text-align: left;
        }

        .recordedit-currency-display .recordedit-currency-amount {
            font-weight: 500;
            color: #583e04;
            text-align: center;
            min-width: 60px;
        }

        /* 输入框容器样式 */
        .recordedit-input-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            width: 100%;
            height: 40px;
        }

        .recordedit-currency-prefix {
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
            margin-right: 6px;
            min-width: 24px;
        }

        .recordedit-table-input.recordedit-currency-input {
            text-align: right;
            padding-left: 8px;
            padding-right: 4px;
            min-width: 60px;
            font-weight: 500;
        }

        /* 固定表格列宽，防止编辑时宽度变化 */
        .recordedit-stock-table {
            table-layout: fixed; /* 添加这行 */
            width: 100%;
            min-width: 1400px;
            border-collapse: collapse;
            font-size: 14px;
        }

        /* 为每列指定固定宽度 */
        .recordedit-stock-table th:nth-child(1), .recordedit-stock-table td:nth-child(1) { width: 90px; } /* DATE */
        .recordedit-stock-table th:nth-child(2), .recordedit-stock-table td:nth-child(2) { width: 100px; } /* Code Number */
        .recordedit-stock-table th:nth-child(3), .recordedit-stock-table td:nth-child(3) { width: 180px; } /* PRODUCT */
        .recordedit-stock-table th:nth-child(4), .recordedit-stock-table td:nth-child(4) { width: 70px; }  /* In */
        .recordedit-stock-table th:nth-child(5), .recordedit-stock-table td:nth-child(5) { width: 70px; }  /* Out */
        .recordedit-stock-table th:nth-child(6), .recordedit-stock-table td:nth-child(6) { width: 80px; } /* Target */
        .recordedit-stock-table th:nth-child(7), .recordedit-stock-table td:nth-child(7) { width: 90px; } /* Specification */
        .recordedit-stock-table th:nth-child(8), .recordedit-stock-table td:nth-child(8) { width: 100px; } /* Price */
        .recordedit-stock-table th:nth-child(9), .recordedit-stock-table td:nth-child(9) { width: 100px; } /* Total */
        .recordedit-stock-table th:nth-child(10), .recordedit-stock-table td:nth-child(10) { width: 150px; } /* Name */
        .recordedit-stock-table th:nth-child(11), .recordedit-stock-table td:nth-child(11) { width: 100px; } /* Remark */
        .recordedit-stock-table th:nth-child(12), .recordedit-stock-table td:nth-child(12) { width: 70px; } /* 操作 */

        /* 确保输入框和选择框填满单元格 */
        .recordedit-table-input, .recordedit-table-select {
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
        .recordedit-currency-input-edit {
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

        .recordedit-currency-input-edit:focus {
            background: #fff;
            border: 2px solid #583e04;
            outline: none;
            z-index: 15;
            position: relative;
        }

        /* 日期单元格样式 */
        .recordedit-date-cell {
            background: #f8f5eb !important;
            font-weight: 600;
            color: #583e04;
            padding: 12px 8px;
            min-width: 100px;
        }

        /* 计算列样式 */
        .recordedit-calculated-cell {
            background: #f0f9ff !important;
            color: #0369a1;
            font-weight: 600;
            padding: 12px 8px;
            min-width: 100px;
        }

        /* 操作按钮 */
        .recordedit-action-buttons {
            padding: 24px;
            background: #f8f5eb;
            border-top: 2px solid #583e04;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .recordedit-action-cell {
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
        .recordedit-stock-table td span.recordedit-action-cell {
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

        .recordedit-action-btn {
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

        .recordedit-action-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }

        .recordedit-action-btn.recordedit-edit-btn {
            background: #f59e0b;
        }

        .recordedit-action-btn.recordedit-edit-btn:hover {
            background: #d97706;
        }

        .recordedit-edit-btn.recordedit-save-mode {
            background: #10b981;
        }

        .recordedit-edit-btn.recordedit-save-mode:hover {
            background: #059669;
        }

        .recordedit-action-btn.recordedit-delete-btn {
            background: #ef4444;
        }

        .recordedit-action-btn.recordedit-delete-btn:hover {
            background: #dc2626;
        }

        .recordedit-action-btn.recordedit-approve-btn {
            background: #10b981;
        }

        .recordedit-action-btn.recordedit-approve-btn:hover {
            background: #059669;
        }

        /* 统计信息 */
        .recordedit-stats-info {
            display: flex;
            gap: 24px;
            align-items: center;
            font-size: 14px;
            color: #6b7280;
            flex-wrap: wrap;
        }

        .recordedit-stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 150px;
        }

        .recordedit-stat-value {
            font-size: 16px;
            font-weight: bold;
            color: #583e04;
        }

        /* 新增记录表单 */
        .recordedit-add-form {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            border: 2px solid #583e04;
            box-shadow: 0 2px 8px rgba(88, 62, 4, 0.1);
            display: none;
        }

        .recordedit-add-form.recordedit-show {
            display: block;
        }

        .recordedit-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            margin-bottom: 16px;
        }

        .recordedit-form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .recordedit-form-group label {
            font-size: 14px;
            font-weight: 600;
            color: #583e04;
        }

        .recordedit-form-input, .recordedit-form-select {
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            color: #583e04;
        }

        .recordedit-form-input:focus, .recordedit-form-select:focus {
            outline: none;
            border-color: #583e04;
            box-shadow: 0 0 0 3px rgba(88, 62, 4, 0.1);
        }

        .recordedit-form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        /* 加载状态 */
        .recordedit-loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #583e04;
            border-radius: 50%;
            animation: recordedit-spin 1s linear infinite;
        }
        
        @keyframes recordedit-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* 响应式设计 */
        @media (max-width: 768px) {
            .recordedit-header {
                flex-direction: column;
                gap: 16px;
                align-items: flex-start;
            }
            
            .recordedit-filter-grid {
                grid-template-columns: 1fr;
            }
            
            .recordedit-filter-actions {
                flex-direction: column;
                width: 100%;
            }
            
            .recordedit-action-buttons {
                flex-direction: column;
                gap: 12px;
            }
            
            .recordedit-stats-info {
                flex-direction: column;
                gap: 8px;
                align-items: flex-start;
            }

            .recordedit-stat-item {
                min-width: auto;
                width: 100%;
            }
        }

        /* 批准状态样式 */
        .recordedit-approval-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
        }

        .recordedit-approval-badge.recordedit-approved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .recordedit-approval-badge.recordedit-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        /* 隐藏类 */
        .recordedit-hidden {
            display: none;
        }

        /* Out 数值为负数的样式 */
        .recordedit-negative-value {
            color: #dc2626 !important;
            font-weight: 600;
        }

        /* 负数括号样式 - 只对数字部分添加括号 */
        .recordedit-negative-value.recordedit-negative-parentheses .recordedit-currency-amount::before {
            content: "(";
        }

        .recordedit-negative-value.recordedit-negative-parentheses .recordedit-currency-amount::after {
            content: ")";
        }

        /* 确保负数的货币显示也是红色 */
        .recordedit-negative-value .recordedit-currency-symbol,
        .recordedit-negative-value .recordedit-currency-amount {
            color: #dc2626 !important;
            font-weight: 600;
        }

        /* 产品名称列稍宽 */
        .recordedit-product-name-col {
            min-width: 150px !important;
        }

        .recordedit-receiver-col {
            min-width: 120px !important;
        }

        /* 新增行样式 */
        .recordedit-new-row {
            background-color: #f0f9ff !important;  
        }

        .recordedit-new-row .recordedit-table-input, .recordedit-new-row .recordedit-table-select {
            background: white;
        }

        /* 新增行样式 */
        .recordedit-new-row {
            background-color: #e0f2fe !important;  /* 浅蓝色背景 */
        }

        .recordedit-new-row td {
            background-color: #e0f2fe !important;
        }

        /* 编辑行样式 */
        .recordedit-editing-row {
            background-color: #e0f2fe !important;  /* 与新增行相同的浅蓝色背景 */
        }

        .recordedit-editing-row td {
            background-color: #e0f2fe !important;
        }

        /* 确保输入框背景透明，显示行的背景色 */
        .recordedit-new-row .recordedit-table-input, 
        .recordedit-new-row .recordedit-table-select,
        .recordedit-new-row .recordedit-currency-input-edit,
        .recordedit-editing-row .recordedit-table-input, 
        .recordedit-editing-row .recordedit-table-select,
        .recordedit-editing-row .recordedit-currency-input-edit {
            background: transparent !important;
        }

        /* 聚焦时的输入框样式 */
        .recordedit-new-row .recordedit-table-input:focus, 
        .recordedit-new-row .recordedit-table-select:focus,
        .recordedit-new-row .recordedit-currency-input-edit:focus,
        .recordedit-editing-row .recordedit-table-input:focus, 
        .recordedit-editing-row .recordedit-table-select:focus,
        .recordedit-editing-row .recordedit-currency-input-edit:focus {
            background: white !important;
        }

        .recordedit-save-new-btn {
            background: #10b981 !important;
        }

        .recordedit-cancel-new-btn {
            background: #ef4444 !important;
        }

        /* Combobox 样式 */
        .recordedit-combobox-container {
            position: relative;
            width: 100%;
        }

        .recordedit-combobox-input {
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

        .recordedit-combobox-input:focus {
            background: #fff;
            border: 2px solid #583e04;
            outline: none;
            z-index: 15;
            position: relative;
        }

        .recordedit-combobox-arrow {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6b7280;
            font-size: 12px;
        }

        .recordedit-combobox-dropdown {
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

        .recordedit-combobox-dropdown.recordedit-show {
            display: block;
        }

        .recordedit-combobox-option {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
            text-align: left;
        }

        .recordedit-combobox-option:hover {
            background-color: #f3f4f6;
        }

        .recordedit-combobox-option:last-child {
            border-bottom: none;
        }

        .recordedit-combobox-option.recordedit-highlighted {
            background-color: #583e04;
            color: white;
        }

        /* 输入框样式优化 */
        .recordedit-combobox-input {
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

        .recordedit-combobox-input:focus {
            background: #fff;
            border: 2px solid #583e04;
            outline: none;
            z-index: 15;
            position: relative;
        }

        /* 确保输入框可以正常输入 */
        .recordedit-combobox-input::-ms-clear {
            display: none;
        }

        .recordedit-no-results {
            padding: 8px 12px;
            color: #6b7280;
            font-style: italic;
            text-align: center;
        }

        /* 确保表格容器不会隐藏溢出内容 */
        .recordedit-table-container {
            background: white;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(88, 62, 4, 0.1);
            border: 2px solid #583e04;
            overflow: visible; /* 改为 visible，允许内容溢出 */
        }

        .recordedit-table-container > div:first-child {
            overflow-x: auto; /* 只对内部滚动容器设置 overflow */
        }

        /* 为了确保水平滚动正常，添加一个内部容器 */
        .recordedit-table-scroll-container {
            overflow-x: auto;
            overflow-y: visible;
        }

        .recordedit-price-select {
            min-width: 100px;
            background-color: white;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 2px 4px;
            font-size: 12px;
        }

        .recordedit-manual-price-input {
            border: 1px solid #3b82f6 !important;
            border-radius: 4px;
        }

        .recordedit-page-selector {
            background-color: #10b981;
            color: white;
            font-weight: 500;
            padding: 10px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            position: relative;
        }

        .recordedit-page-selector:hover {
            background-color: #059669;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.2);
        }

        .recordedit-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            border: 2px solid #10b981;
            border-radius: 8px;
            min-width: 130px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
            z-index: 1000;
            display: none;
            margin-top: 4px;
        }

        .recordedit-dropdown-menu.recordedit-show {
            display: block;
        }

        .recordedit-dropdown-item {
            padding: 10px 16px;
            color: #583e04;
            text-decoration: none;
            display: block;
            font-size: 14px;
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.2s;
        }

        .recordedit-dropdown-item:hover {
            background-color: #f0f9ff;
            color: #10b981;
        }

        .recordedit-dropdown-item:last-child {
            border-bottom: none;
        }

        /* 导出弹窗样式 */
        .recordedit-export-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .recordedit-export-modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 30px;
            border-radius: 12px;
            width: 450px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }

        .recordedit-export-modal h3 {
            margin: 0 0 20px 0;
            color: #1f2937;
            font-size: 18px;
            font-weight: 600;
        }

        .recordedit-export-form-group {
            margin-bottom: 16px;
        }

        .recordedit-export-form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #374151;
            font-size: 14px;
        }

        .recordedit-export-form-group input,
        .recordedit-export-form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .recordedit-export-form-group input:focus,
        .recordedit-export-form-group select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .recordedit-checkbox-group {
            display: flex;
            gap: 15px;
            margin-top: 8px;
        }

        .recordedit-checkbox-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .recordedit-checkbox-item input[type="checkbox"] {
            width: auto;
            margin: 0;
        }

        .recordedit-export-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .recordedit-close-export-modal {
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

        .recordedit-close-export-modal:hover {
            color: #374151;
        }
    </style>
</head>
<body id="page-body">
    <div class="container">
        <div class="header">
            <div>
                <h1 id="page-title">中央库存汇总报表</h1>
            </div>
            <div class="controls">
                <div class="system-selector">
                    <button class="selector-button" onclick="toggleSelector()">
                        <span id="current-system">中央库存</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="selector-dropdown" id="selector-dropdown">
                        <div class="dropdown-item active" onclick="switchSystem('central')">中央库存</div>
                        <div class="dropdown-item" onclick="switchSystem('j1')">J1库存</div>
                        <div class="dropdown-item" onclick="switchSystem('j2')">J2库存</div>
                        <div class="dropdown-item" onclick="switchSystem('remark')">价格分析</div>
                    </div>
                </div>
                <div class="page-mode-selector">
                    <button class="selector-button" onclick="togglePageModeSelector()">
                        <span id="current-page-mode">库存清单</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="selector-dropdown" id="page-mode-dropdown">
                        <div class="dropdown-item active" onclick="switchPageMode('summary')">库存清单</div>
                        <div class="dropdown-item" onclick="switchPageMode('records')">库存记录</div>
                    </div>
                </div>
                <button class="back-button" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i>
                    返回上一页
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
                            <label for="central-product-filter">产品名称</label>
                            <input type="text" id="central-product-filter" class="filter-input" placeholder="搜索产品名称...">
                        </div>
                        <div class="filter-group">
                            <label for="central-code-filter">产品编号</label>
                            <input type="text" id="central-code-filter" class="filter-input" placeholder="搜索产品编号...">
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
                                <th>No.</th>
                                <th>PRODUCT</th>
                                <th>Code Number</th>
                                <th>Total Stock</th>
                                <th>Specification</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
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
                            <label for="j1-product-filter">产品名称</label>
                            <input type="text" id="j1-product-filter" class="filter-input" placeholder="搜索产品名称...">
                        </div>
                        <div class="filter-group">
                            <label for="j1-code-filter">产品编号</label>
                            <input type="text" id="j1-code-filter" class="filter-input" placeholder="搜索产品编号...">
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
                                <th>No.</th>
                                <th>PRODUCT</th>
                                <th>Code Number</th>
                                <th>Total Stock</th>
                                <th>Specification</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
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
                            <label for="j2-product-filter">产品名称</label>
                            <input type="text" id="j2-product-filter" class="filter-input" placeholder="搜索产品名称...">
                        </div>
                        <div class="filter-group">
                            <label for="j2-code-filter">产品编号</label>
                            <input type="text" id="j2-code-filter" class="filter-input" placeholder="搜索产品编号...">
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
                                <th>No.</th>
                                <th>PRODUCT</th>
                                <th>Code Number</th>
                                <th>Total Stock</th>
                                <th>Specification</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
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
                        <label for="remark-product-filter">产品名称</label>
                        <input type="text" id="remark-product-filter" class="filter-input" placeholder="搜索产品名称...">
                    </div>
                    <div class="filter-group">
                        <label for="remark-code-filter">产品编号</label>
                        <input type="text" id="remark-code-filter" class="filter-input" placeholder="搜索产品编号...">
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
                            <option value="name_asc">产品名称 A-Z</option>
                            <option value="name_desc">产品名称 Z-A</option>
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
        let currentPageMode = 'summary'; // 'summary' 或 'records'
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

        // API配置
        const API_CONFIG = {
            central: 'stocklistapi.php',
            j1: 'j1stocklistapi.php',
            j2: 'j2stocklistapi.php',
            remark: 'stockremarkapi.php'
        };

        // 页面跳转URL配置
        const RECORDS_PAGE_URLS = {
            central: 'stockedit.php',
            j1: 'j1stockedit.php',  
            j2: 'j2stockedit.php'
        };

        const PAGE_TITLES = {
            summary: {
                central: '中央库存汇总报表',
                j1: 'J1库存汇总报表',
                j2: 'J2库存汇总报表',
                remark: '库存价格分析'
            },
            records: {
                central: '中央库存记录',
                j1: 'J1库存记录',
                j2: 'J2库存记录',
                remark: '库存记录分析'
            }
        };

        // 初始化应用
        function initApp() {
            loadData(currentSystem);
            // 点击外部关闭下拉菜单
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.system-selector')) {
                    document.getElementById('selector-dropdown').classList.remove('show');
                }
                if (!e.target.closest('.page-mode-selector')) {
                    document.getElementById('page-mode-dropdown').classList.remove('show');
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
            if (system === 'remark') {
                document.getElementById('page-title').textContent = '库存价格分析';
                // 禁用页面模式选择器，并重置为默认样式
                updatePageModeSelector(false);
                currentPageMode = 'summary';
                document.getElementById('page-body').className = '';
            } else {
                document.getElementById('page-title').textContent = PAGE_TITLES[currentPageMode][system];
                // 启用页面模式选择器
                updatePageModeSelector(true);
                // 保持当前页面模式的样式
                const body = document.getElementById('page-body');
                if (currentPageMode === 'records') {
                    body.className = 'recordedit';
                } else {
                    body.className = '';
                }
            }
            
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

        // 切换页面模式选择器
        function togglePageModeSelector() {
            // 如果是价格分析模式，不允许切换
            if (currentSystem === 'remark') {
                return;
            }
            document.getElementById('page-mode-dropdown').classList.toggle('show');
        }

        // 切换页面模式
        function switchPageMode(mode) {
            // 如果是价格分析模式，不允许切换
            if (currentSystem === 'remark') {
                return;
            }
            
            if (mode === currentPageMode) return;
            
            currentPageMode = mode;
            
            // 更新UI
            const modeNames = {
                'summary': '库存清单',
                'records': '库存记录'
            };
            
            document.getElementById('current-page-mode').textContent = modeNames[mode];
            
            // 更新页面标题
            document.getElementById('page-title').textContent = PAGE_TITLES[currentPageMode][currentSystem];
            
            // 切换CSS样式类
            const body = document.getElementById('page-body');
            if (mode === 'records') {
                body.className = 'recordedit';
            } else {
                body.className = '';
            }
            
            // 更新下拉菜单激活状态
            document.querySelectorAll('#page-mode-dropdown .dropdown-item').forEach(item => {
                item.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // 隐藏下拉菜单
            document.getElementById('page-mode-dropdown').classList.remove('show');
            
            // 根据模式处理页面跳转或数据加载
            if (mode === 'records') {
                redirectToRecordsPage(currentSystem);
            } else {
                loadData(currentSystem);
            }
        }

        // 跳转到库存记录页面
        function redirectToRecordsPage(system) {
            const pageUrls = {
                'central': 'stockedit.php',
                'j1': 'j1stockedit.php',
                'j2': 'j2stockedit.php'
            };
            
            if (pageUrls[system]) {
                // 显示跳转提示
                showAlert(`正在跳转到${SYSTEM_NAMES[system]}记录页面...`, 'info');
                
                // 延迟跳转，让用户看到提示信息
                setTimeout(() => {
                    window.location.href = pageUrls[system];
                }, 1000);
            } else {
                showAlert('未找到对应的记录页面', 'error');
                // 如果跳转失败，恢复到清单模式
                currentPageMode = 'summary';
                document.getElementById('current-page-mode').textContent = '库存清单';
                document.getElementById('page-body').className = '';
                
                // 更新下拉菜单激活状态
                document.querySelectorAll('#page-mode-dropdown .dropdown-item').forEach(item => {
                    item.classList.remove('active');
                });
                document.querySelector('#page-mode-dropdown .dropdown-item[onclick*="summary"]').classList.add('active');
            }
        }

        // 更新页面模式选择器状态
        function updatePageModeSelector(enabled) {
            const button = document.querySelector('.page-mode-selector .selector-button');
            const modeText = document.getElementById('current-page-mode');
            const dropdown = document.getElementById('page-mode-dropdown');
            
            if (enabled) {
                // 启用状态
                button.disabled = false;
                button.style.opacity = '1';
                button.style.cursor = 'pointer';
                button.style.backgroundColor = '#10b981';
                
                // 恢复正常文本
                const modeNames = {
                    'summary': '库存清单',
                    'records': '库存记录'
                };
                modeText.textContent = modeNames[currentPageMode];
                
                // 可以点击
                button.onclick = togglePageModeSelector;
            } else {
                // 禁用状态
                button.disabled = true;
                button.style.opacity = '0.5';
                button.style.cursor = 'not-allowed';
                button.style.backgroundColor = '#6b7280';
                
                // 显示 "--"
                modeText.textContent = '--';
                
                // 移除点击事件
                button.onclick = null;
                
                // 关闭下拉菜单
                dropdown.classList.remove('show');
                
                // 重置页面模式为summary并清除recordedit样式
                currentPageMode = 'summary';
                document.getElementById('page-body').className = '';
            }
        }

        // 修改 goBack 函数，添加返回汇总页面的选项
        function goBack() {
            // 检查是否来自汇总页面
            if (document.referrer && document.referrer.includes('stocksummary.php')) {
                window.location.href = 'stocksummary.php';
            } else if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '/';
            }
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
                            '当前没有发现多价格产品' : 
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
                showAlert(`找到 ${filteredData.remark.length} 个匹配产品`, 'success');
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
                        <td><strong>${item.product_name}</strong></td>
                        <td class="text-center">${item.code_number || '-'}</td>
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

        // 渲染价格分析产品列表
        function renderRemarkProducts() {
            const container = document.getElementById('remark-products-container');
            
            if (filteredData.remark.length === 0) {
                container.innerHTML = `
                    <div class="no-data">
                        <i class="fas fa-search"></i>
                        <h3>没有找到多价格产品</h3>
                        <p>当前筛选条件下没有发现产品有多个价格变体</p>
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
                                    <th>产品编号</th>
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
    </script>
</body>
</html>