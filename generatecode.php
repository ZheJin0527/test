<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <link rel="icon" type="image/png" href="images/images/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>生成申请码管理系统</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #ffffffff 0%, #f3ebe0ff 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1850px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .header h1 {
            color: #ff5c00;
            font-size: 50px;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .header p {
            color: #ff5c00;
            font-size: 17px;
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
            position: absolute;
            top: 10px;
            right: 0;
        }

        .back-button:hover {
            background-color: #4b5563;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(107, 114, 128, 0.2);
        }

        /* 生成代码表单样式 */
        .generate-form {
            background: transparent;
            padding: 10px 900px 10px 0px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .form-title {
            color: #E65100;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            border-bottom: 2px solid #ff5c00;
            padding-bottom: 12px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            align-items: end;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #BF360C;
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ff5c00;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #ff5c00;
            box-shadow: 0 0 10px rgba(255, 115, 0, 0.8);
        }

        /* 添加用户模态框中的表单样式 - 超紧凑版本 */
        #addUserModal .modal-content {
            max-width: 900px;
            max-height: 95vh;
            overflow-y: auto;
            padding: 15px;
        }

        #addUserModal .form-group {
            margin-bottom: 6px;
        }

        #addUserModal .form-group label {
            display: block;
            margin-bottom: 2px;
            color: #000000ff;
            font-weight: bold;
            font-size: 12px;
            text-align: left;
        }

        #addUserModal .form-group input:not(#add_home_address),
        #addUserModal .form-group select:not(#add_account_type),
        #addUserModal .form-group textarea:not(#add_home_address) {
            width: 98%;
            padding: 4px 6px;
            border: 1px solid #ff5c00;
            border-radius: 4px;
            font-size: 12px;
            transition: all 0.3s ease;
            height: 28px;
        }

        #addUserModal .form-group textarea {
            height: 50px;
            resize: vertical;
        }

        #addUserModal .form-group input:not(#add_home_address):focus,
        #addUserModal .form-group select:not(#add_account_type):focus,
        #addUserModal .form-group textarea:not(#add_home_address):focus {
            outline: none;
            border-color: #ff5c00;
            box-shadow: 0 0 4px rgba(255, 115, 0, 0.4);
        }

        /* 家庭地址和账号类型的独立样式 */
        #addUserModal #add_home_address {
            padding: 6px 8px;
            font-size: 13px;
            height: 60px;
            border: 1px solid #ff5c00;
            border-radius: 6px;
            width: 99%;
        }

        #addUserModal #add_account_type {
            padding: 6px 8px;
            font-size: 13px;
            height: 32px;
            border: 1px solid #ff5c00;
            border-radius: 6px;
            width: 99%;
        }

        #addUserModal #add_home_address:focus,
        #addUserModal #add_account_type:focus {
            outline: none;
            border-color: #ff5c00;
            box-shadow: 0 0 6px rgba(255, 115, 0, 0.5);
        }

        /* 搜索框特殊样式 */
        #searchInput {
            transition: all 0.3s ease;
        }

        #searchInput:focus {
            outline: none;
            border-color: #ff5c00 !important;
            box-shadow: 0 0 10px rgba(255, 115, 0, 0.8) !important;
        }

        #searchInput::placeholder {
            color: #999;
            font-style: italic;
        }

        /* 高亮搜索结果 */
        .highlight {
            background-color: #fff3cd;
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: bold;
        }

        /* 隐藏不匹配的行 */
        .hidden-row {
            display: none !important;
        }

        .btn-generate {
            background: linear-gradient(270deg, #FF9800 0%, #E65100 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 17.6px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-generate:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255,152,0,0.4);
        }

        /* 消息提示样式 */
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
        }

        .message.success {
            background: #C8E6C9;
            color: #2E7D32;
            border: 2px solid #4CAF50;
        }

        .message.error {
            background: #FFCDD2;
            color: #C62828;
            border: 2px solid #F44336;
        }

        /* 表格样式 */
        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            border: 2px solid #ff5c00;
        }

        .table-title {
            background: #ff5c00;
            color: white;
            padding: 20px;
            font-size: 20.8px;
            font-weight: bold;
            text-align: center;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #fff9f1;
            color: black;
            padding: 15px 10px;
            text-align: left;
            font-weight: bold;
            font-size: 14px;
            border-bottom: 1px solid #d1d5db;
        }

        th:first-child {
            text-align: center;
        }

        th:last-child {
            text-align: center;
        }

        td {
            padding: 12px 10px;
            font-size: 12px;
            font-weight: 500;
            border-bottom: 1px solid #d1d5db;
            vertical-align: middle;
        }

        tr:hover {
            background: #fff9f1;
            transition: all 0.2s ease;
        }

        /* 状态标签样式 */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14.4px;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            min-width: 80px;
        }

        .status-used {
            background: #C8E6C9;
            color: #2E7D32;
        }

        .status-unused {
            background: #FFE0B2;
            color: #E65100;
        }

        .account-type-badge {
            padding: 4px 0px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* 响应式设计 */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .header h1 {
                font-size: 40px;
            }

            .generate-form {
                padding: 20px;
            }

            th, td {
                padding: 8px 6px;
                font-size: 14.4px;
            }
        }

        /* 加载动画 */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #FFE0B2;
            border-radius: 50%;
            border-top-color: #FF9800;
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* 操作按钮样式 */
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            min-width: 65px;
        }

        .btn-edit {
            background: #f59e0b;
            color: white;
        }

        .btn-edit:hover {
            background: #d97706;
            transform: translateY(-1px);
        }

        .btn-save {
            background: #10b981;
            color: white;
        }

        .btn-save:hover {
            background: #059669;
            transform: translateY(-1px);
        }

        .btn-cancel {
            background: #6b7280;
            color: white;
        }

        .btn-cancel:hover {
            background: #6b7280;
            transform: translateY(-1px);
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        /* 编辑模式下的输入框 */
        .edit-input {
            width: 100%;
            padding: 6px 10px;
            border: 1px solid #2196F3;
            border-radius: 4px;
            font-size: 14px;
            background: #f8f9fa;
            box-sizing: border-box;
        }

        .edit-select {
            width: 100%;
            padding: 6px 10px;
            border: 1px solid #2196F3;
            border-radius: 4px;
            font-size: 14px;
            background: #f8f9fa;
            box-sizing: border-box;
        }

        .edit-input:focus,
        .edit-select:focus {
            outline: none;
            border-color: #1976D2;
            box-shadow: 0 0 5px rgba(33, 150, 243, 0.3);
        }

        /* 确认删除模态框 */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 25px;
            border-radius: 10px;
            width: 90%;
            max-width: 450px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            color: #f44336;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .modal-body {
            margin-bottom: 25px;
            color: #333;
            line-height: 1.5;
        }

        .modal-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        /* 编辑状态下的行高亮 */
        .editing-row {
            background: #e3f2fd !important;
            box-shadow: 0 0 10px rgba(33, 150, 243, 0.2);
        }

        /* 响应式设计 */
        @media (max-width: 768px) {
            .btn-action {
                font-size: 11px;
                padding: 5px 8px;
                min-width: 60px;
            }
            
            .action-buttons {
                gap: 5px;
            }
            
            .modal-content {
                width: 95%;
                margin: 10% auto;
                padding: 20px;
            }
        }

        /* 回到顶部按钮 */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 20px;
            width: 50px;
            height: 50px;
            background-color: #eb8e02ff;
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
            background-color: #d16003ff;
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(88, 62, 4, 0.4);
        }

        .back-to-top:active {
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- 页面标题 -->
        <div class="header">
            <button class="back-button" onclick="goBack()">
                <i class="fas fa-arrow-left"></i>
                返回仪表盘
            </button>
            <h1>申请码管理系统</h1>
        </div>

        <!-- 生成代码表单 -->
        <div class="generate-form">
            
            <div id="messageArea"></div>

            <form id="generateForm">
                <div class="form-row">
                    <div class="form-group" style="flex: 2; position: relative;">
                        <label for="searchInput">搜索账号类型:</label>
                        <div style="position: relative;">
                            <input type="text" id="searchInput" placeholder="输入账号类型进行筛选（如：管理员、人事部）..."
                                style="padding: 12px 40px 12px 12px; border: 2px solid #ff5c00; border-radius: 8px; font-size: 16px; width: 100%;">
                            <button type="button" onclick="clearSearch()" 
                                    style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #999; cursor: pointer; font-size: 16px;"
                                    title="清除搜索">
                                ×
                            </button>
                        </div>
                    </div>
                    
                    <!-- 添加新用户按钮 -->
                    <div class="form-group" style="flex: 1;">
                        <label>&nbsp;</label> <!-- 空标签保持对齐 -->
                        <button type="button" class="btn-generate" onclick="openAddUserModal()" 
                                style="background: #10b981; font-size: 16px; padding: 12px 20px; width: 100%;">
                            <i class="fas fa-user-plus"></i> 添加新用户
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- 代码和用户列表 -->
        <div class="table-container">
            <div class="table-title">
                申请码和用户列表
            </div>
            
            <div class="table-wrapper">
                <table id="codesTable">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>类型</th>
                            <th>全名(英)</th>
                            <th>全名(中)</th>
                            <th>小名</th>
                            <th>身份证</th>
                            <th>生日</th>
                            <th>性别</th>
                            <th>国籍</th>
                            <th>联络号码</th>
                            <th>邮箱</th>
                            <th>地址</th>
                            <th>职位</th>
                            <th>紧急联络人</th>
                            <th>紧急联络号码</th>
                            <th>银行名称</th>
                            <th>银行账号</th>
                            <th>银行持有人</th>
                            <th>申请码</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr>
                            <td colspan="20" style="text-align: center; padding: 30px;">
                                <div class="loading"></div>
                                正在加载数据...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 添加用户模态框 -->
    <div id="addUserModal" class="modal">
        <div class="modal-content" style="max-width: 600px; max-height: 90vh; overflow-y: auto;">
            <div class="modal-header" style="color: #10b981; font-size: 16px; margin-bottom: 10px;">
                <i class="fas fa-user-plus"></i> 添加新用户
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px;">
                        <div class="form-group">
                            <label for="add_username">英文姓名 *:</label>
                            <input type="text" id="add_username" name="username" required maxlength="50">
                        </div>
                        
                        <div class="form-group">
                            <label for="add_username_cn">中文姓名:</label>
                            <input type="text" id="add_username_cn" name="username_cn" maxlength="100">
                        </div>
                        
                        <div class="form-group">
                            <label for="add_nickname">小名:</label>
                            <input type="text" id="add_nickname" name="nickname" maxlength="50">
                        </div>
                        
                        <div class="form-group">
                            <label for="add_email">邮箱 *:</label>
                            <input type="email" id="add_email" name="email" required maxlength="100">
                        </div>
                        
                        <div class="form-group">
                            <label for="add_ic_number">身份证号码:</label>
                            <input type="text" id="add_ic_number" name="ic_number" maxlength="20">
                        </div>
                        
                        <div class="form-group">
                            <label for="add_date_of_birth">出生日期:</label>
                            <input type="date" id="add_date_of_birth" name="date_of_birth">
                        </div>
                        
                        <div class="form-group">
                            <label for="add_nationality">国籍:</label>
                            <input type="text" id="add_nationality" name="nationality" maxlength="50">
                        </div>
                        
                        <div class="form-group">
                            <label for="add_gender">性别:</label>
                            <select id="add_gender" name="gender">
                                <option value="">请选择</option>
                                <option value="male">男</option>
                                <option value="female">女</option>
                                <option value="other">其他</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="add_race">种族:</label>
                            <input type="text" id="add_race" name="race" maxlength="50">
                        </div>
                        
                        <div class="form-group">
                            <label for="add_phone_number">电话号码:</label>
                            <input type="tel" id="add_phone_number" name="phone_number" maxlength="20">
                        </div>
                        
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="add_home_address">家庭地址:</label>
                            <textarea id="add_home_address" name="home_address" rows="2" maxlength="255"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="add_bank_account_holder_en">银行账户持有人:</label>
                            <input type="text" id="add_bank_account_holder_en" name="bank_account_holder_en" maxlength="50">
                        </div>
                        
                        <div class="form-group">
                            <label for="add_bank_account">银行账号:</label>
                            <input type="text" id="add_bank_account" name="bank_account" maxlength="30">
                        </div>
                        
                        <div class="form-group">
                            <label for="add_bank_name">银行名称:</label>
                            <input type="text" id="add_bank_name" name="bank_name" maxlength="100">
                        </div>
                        
                        <div class="form-group">
                            <label for="add_position">职位:</label>
                            <input type="text" id="add_position" name="position" maxlength="100">
                        </div>
                        
                        <div class="form-group">
                            <label for="add_emergency_contact_name">紧急联系人:</label>
                            <input type="text" id="add_emergency_contact_name" name="emergency_contact_name" maxlength="100">
                        </div>
                        
                        <div class="form-group">
                            <label for="add_emergency_phone_number">紧急联系人电话:</label>
                            <input type="tel" id="add_emergency_phone_number" name="emergency_phone_number" maxlength="20">
                        </div>
                        
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="add_account_type">账号类型 *:</label>
                            <select id="add_account_type" name="account_type" required>
                                <option value="">请选择账号类型</option>
                                <option value="boss">老板 (Boss)</option>
                                <option value="admin">管理员 (Admin)</option>
                                <option value="hr">人事部 (HR)</option>
                                <option value="design">设计部 (Design)</option>
                                <option value="support">支援部 (Support)</option>
                                <option value="IT">技术部 (IT)</option>
                                <option value="photograph">摄影部 (Photography)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-buttons" style="margin-top: 15px;">
                        <button type="submit" class="btn-action btn-save" style="padding: 12px 30px; font-size: 16px;">
                            <i class="fas fa-user-plus"></i> 添加用户
                        </button>
                        <button type="button" class="btn-action btn-cancel" onclick="closeAddUserModal()" style="padding: 12px 30px; font-size: 16px;">
                            <i class="fas fa-times"></i> 取消
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 回到顶部按钮 -->
    <button class="back-to-top" id="back-to-top-btn" onclick="scrollToTop()" title="回到顶部">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>
        // 页面加载时获取数据
        document.addEventListener('DOMContentLoaded', function() {
            loadCodesAndUsers();
            
            // 添加实时搜索功能
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function(e) {
                filterTable(e.target.value);
            });

            // 初始化事件监听器
            rebindEventListeners();
        });

        // 加载代码和用户数据
        async function loadCodesAndUsers() {
            const tableBody = document.getElementById('tableBody');
            
            try {
                const response = await fetch('generatecodeapi.php?action=list');
                const result = await response.json();

                if (result.success) {
                    displayData(result.data);
                } else {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="20" style="text-align: center; padding: 30px; color: #C62828;">
                                ❌ 加载失败: ${result.message}
                            </td>
                        </tr>
                    `;
                }
            } catch (error) {
                console.error('Error:', error);
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="20" style="text-align: center; padding: 30px; color: #C62828;">
                            ❌ 网络错误，请检查连接
                        </td>
                    </tr>
                `;
            }
            
            // 添加这段代码来重新绑定事件监听器
            rebindEventListeners();
        }

        // 重新绑定事件监听器
        function rebindEventListeners() {
            // 重新绑定添加用户表单提交事件
            const addUserForm = document.getElementById('addUserForm');
            if (addUserForm) {
                // 移除旧的事件监听器（如果存在）
                addUserForm.removeEventListener('submit', handleAddUserSubmit);
                // 添加新的事件监听器
                addUserForm.addEventListener('submit', handleAddUserSubmit);
            }
            
            // 重新绑定模态框外部点击关闭事件
            const addUserModal = document.getElementById('addUserModal');
            if (addUserModal) {
                addUserModal.onclick = function(event) {
                    if (event.target === this) {
                        closeAddUserModal();
                    }
                };
            }
        }

        // 提取表单提交处理函数
        function handleAddUserSubmit(e) {
            e.preventDefault();
            addNewUser();
        }

        // 生成6位随机代码（数字字母结合）
        function generateRandomCode() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let result = '';
            for (let i = 0; i < 6; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return result;
        }

        // 返回仪表盘
        function goBack() {
            window.location.href = 'dashboard.php';
        }

        // 显示数据
        function displayData(data) {
            const tableBody = document.getElementById('tableBody');
            
            if (!data || data.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="20" style="text-align: center; padding: 30px; color: #666;">
                            📝 暂无数据
                        </td>
                    </tr>
                `;
                return;
            }

            // 定义账号类型的排序顺序
            const typeOrder = {
                'boss': 1,
                'admin': 2,
                'hr': 3, 
                'design': 4,
                'support': 5,
                'IT': 6,
                'photograph': 7
            };
            
            // 按照指定顺序排序数据
            const sortedData = [...data].sort((a, b) => {
                const orderA = typeOrder[a.account_type] || 999;
                const orderB = typeOrder[b.account_type] || 999;
                return orderA - orderB;
            });

            const rows = sortedData.map((item, index) => `
                <tr id="row-${item.id}" data-id="${item.id}">
                    <td style="text-align: center; font-weight: bold; color: black;">${index + 1}</td>
                    <td data-field="account_type" data-original="${item.account_type}">
                        <span class="account-type-badge type-${item.account_type}">${formatAccountType(item.account_type)}</span>
                    </td>
                    <td data-field="username" data-original="${item.username || ''}">${item.username || '<em style="color: #999;">-</em>'}</td>
                    <td data-field="username_cn" data-original="${item.username_cn || ''}">${item.username_cn || '<em style="color: #999;">-</em>'}</td>
                    <td data-field="nickname" data-original="${item.nickname || ''}">${item.nickname || '<em style="color: #999;">-</em>'}</td>
                    <td data-field="ic_number" data-original="${item.ic_number || ''}">${item.ic_number || '<em style="color: #999;">-</em>'}</td>
                    <td data-field="date_of_birth" data-original="${item.date_of_birth || ''}">${item.date_of_birth || '<em style="color: #999;">-</em>'}</td>
                    <td data-field="gender" data-original="${item.gender || ''}">${formatGender(item.gender) || '<em style="color: #999;">-</em>'}</td>
                    <td data-field="nationality" data-original="${item.nationality || ''}">${item.nationality || '<em style="color: #999;">-</em>'}</td>
                    <td data-field="phone_number" data-original="${item.phone_number || ''}">${item.phone_number || '<em style="color: #999;">-</em>'}</td>
                    <td data-field="email" data-original="${item.email || ''}">${item.email || '<em style="color: #999;">-</em>'}</td>
                    <td data-field="home_address" data-original="${item.home_address || ''}">${item.home_address || '<em style="color: #999;">-</em>'}</td>
                    <td data-field="position" data-original="${item.position || ''}">${item.position || '<em style="color: #999;">-</em>'}</td>
                    <td data-field="emergency_contact_name" data-original="${item.emergency_contact_name || ''}">${item.emergency_contact_name || '<em style="color: #999;">-</em>'}</td>
                    <td data-field="emergency_phone_number" data-original="${item.emergency_phone_number || ''}">${item.emergency_phone_number || '<em style="color: #999;">-</em>'}</td>
                    <td data-field="bank_name" data-original="${item.bank_name || ''}">${item.bank_name || '<em style="color: #999;">-</em>'}</td>
                    <td data-field="bank_account" data-original="${item.bank_account || ''}">${item.bank_account || '<em style="color: #999;">-</em>'}</td>
                    <td data-field="bank_account_holder_en" data-original="${item.bank_account_holder_en || ''}">${item.bank_account_holder_en || '<em style="color: #999;">-</em>'}</td>
                    <td data-field="registration_code" data-original="${item.registration_code || ''}">${item.registration_code || '<em style="color: #999;">-</em>'}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action btn-edit" onclick="editRow(${item.id})">
                                <i class="fas fa-edit"></i> 编辑
                            </button>
                            <button class="btn-action btn-delete" onclick="confirmDelete(${item.id}, '${item.registration_code}')">
                                <i class="fas fa-trash"></i> 删除
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');

            tableBody.innerHTML = rows;

            // 保存原始数据用于搜索
            originalTableData = sortedData;

            // 如果有搜索词，重新应用过滤
            const searchInput = document.getElementById('searchInput');
            if (searchInput && searchInput.value.trim()) {
                filterTable(searchInput.value);
            }
        }

        // 格式化账号类型
        function formatAccountType(type) {
            const types = {
                'boss': '老板',
                'admin': '管理员',
                'hr': '人事部',
                'design': '设计部',
                'support': '支援部',
                'IT': '技术部',
                'photograph': '摄影部'
            };
            return types[type] || type;
        }

        // 格式化性别
        function formatGender(gender) {
            const genders = {
                'male': '男',
                'female': '女',
                'other': '其他'
            };
            return genders[gender] || gender;
        }

        // 显示消息
        function showMessage(message, type) {
            const messageArea = document.getElementById('messageArea');
            messageArea.innerHTML = `<div class="message ${type}">${message}</div>`;
            
            // 3秒后自动隐藏
            setTimeout(() => {
                messageArea.innerHTML = '';
            }, 3000);
        }

        // 刷新表格
        function refreshTable() {
            loadCodesAndUsers();
        }

        // 全局变量存储原始数据
        let originalTableData = [];

        // 实时过滤表格（只搜索账号类型列）
        function filterTable(searchTerm) {
            const tableBody = document.getElementById('tableBody');
            const rows = tableBody.getElementsByTagName('tr');
            
            // 如果没有搜索词，显示所有行
            if (!searchTerm.trim()) {
                for (let row of rows) {
                    row.classList.remove('hidden-row');
                }
                return;
            }
            
            const searchLower = searchTerm.toLowerCase();
            
            // 遍历每一行进行过滤
            for (let row of rows) {
                // 跳过加载中或无数据的行
                if (row.cells.length === 1 && row.cells[0].colSpan > 1) {
                    continue;
                }
                
                // 只检查账号类型列（第3列，索引为2）
                const accountTypeCell = row.cells[2];
                if (accountTypeCell) {
                    const cellText = accountTypeCell.textContent.toLowerCase();
                    
                    // 显示或隐藏行
                    if (cellText.includes(searchLower)) {
                        row.classList.remove('hidden-row');
                    } else {
                        row.classList.add('hidden-row');
                    }
                }
            }
        }

        // 清除搜索
        function clearSearch() {
            const searchInput = document.getElementById('searchInput');
            searchInput.value = '';
            filterTable('');
        }

        // 回到顶部功能
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // 编辑行数据
        function editRow(id) {
            const row = document.getElementById(`row-${id}`);
            const editBtn = row.querySelector('.btn-edit');
            const deleteBtn = row.querySelector('.btn-delete');
            
            // 如果已经在编辑模式，不重复处理
            if (editBtn.textContent.includes('保存')) {
                return;
            }
            
            // 添加编辑状态样式
            row.classList.add('editing-row');
            
            // 获取所有可编辑的字段
            const editableFields = [
                'account_type', 'username', 'username_cn', 'nickname', 'ic_number', 
                'date_of_birth', 'gender', 'nationality', 'phone_number', 'email', 
                'home_address', 'position', 'emergency_contact_name', 'emergency_phone_number',
                'bank_name', 'bank_account', 'bank_account_holder_en', 'registration_code'
            ];
            
            editableFields.forEach(field => {
                const cell = row.querySelector(`[data-field="${field}"]`);
                if (cell) {
                    const originalValue = cell.getAttribute('data-original') || '';
                    
                    if (field === 'account_type') {
                        cell.innerHTML = `
                            <select class="edit-select">
                                <option value="boss" ${originalValue === 'boss' ? 'selected' : ''}>老板</option>
                                <option value="admin" ${originalValue === 'admin' ? 'selected' : ''}>管理员</option>
                                <option value="hr" ${originalValue === 'hr' ? 'selected' : ''}>人事部</option>
                                <option value="design" ${originalValue === 'design' ? 'selected' : ''}>设计部</option>
                                <option value="support" ${originalValue === 'support' ? 'selected' : ''}>支援部</option>
                                <option value="IT" ${originalValue === 'IT' ? 'selected' : ''}>技术部</option>
                                <option value="photograph" ${originalValue === 'photograph' ? 'selected' : ''}>摄影部</option>
                            </select>
                        `;
                    } else if (field === 'gender') {
                        cell.innerHTML = `
                            <select class="edit-select">
                                <option value="">请选择</option>
                                <option value="male" ${originalValue === 'male' ? 'selected' : ''}>男</option>
                                <option value="female" ${originalValue === 'female' ? 'selected' : ''}>女</option>
                                <option value="other" ${originalValue === 'other' ? 'selected' : ''}>其他</option>
                            </select>
                        `;
                    } else if (field === 'date_of_birth') {
                        cell.innerHTML = `<input type="date" class="edit-input" value="${originalValue}">`;
                    } else if (field === 'email') {
                        cell.innerHTML = `<input type="email" class="edit-input" value="${originalValue}" maxlength="100" placeholder="邮箱">`;
                    } else if (field === 'phone_number' || field === 'emergency_phone_number') {
                        cell.innerHTML = `<input type="tel" class="edit-input" value="${originalValue}" maxlength="20" placeholder="联络号码">`;
                    } else if (field === 'home_address') {
                        cell.innerHTML = `<textarea class="edit-input" maxlength="255" placeholder="地址" style="min-height: 60px;">${originalValue}</textarea>`;
                    } else if (field === 'ic_number') {
                        cell.innerHTML = `<input type="text" class="edit-input" value="${originalValue}" maxlength="20" placeholder="身份证号码">`;
                    } else if (field === 'bank_account') {
                        cell.innerHTML = `<input type="text" class="edit-input" value="${originalValue}" maxlength="30" placeholder="银行账号">`;
                    } else if (field === 'registration_code') {
                        cell.innerHTML = `<input type="text" class="edit-input" value="${originalValue}" maxlength="50" placeholder="申请码" readonly style="background-color: #f5f5f5; cursor: not-allowed;">`;
                    } else {
                        // 其他文本字段的通用处理
                        const maxLength = getFieldMaxLength(field);
                        const placeholder = getFieldPlaceholder(field);
                        cell.innerHTML = `<input type="text" class="edit-input" value="${originalValue}" maxlength="${maxLength}" placeholder="${placeholder}">`;
                    }
                }
            });
            
            // 修改按钮
            editBtn.innerHTML = '<i class="fas fa-save"></i> 保存';
            editBtn.className = 'btn-action btn-save';
            editBtn.setAttribute('onclick', `saveRow(${id})`);
            
            deleteBtn.innerHTML = '<i class="fas fa-times"></i> 取消';
            deleteBtn.className = 'btn-action btn-cancel';
            deleteBtn.setAttribute('onclick', `cancelEdit(${id})`);
        }

        // 保存行数据
        async function saveRow(id) {
            const row = document.getElementById(`row-${id}`);
            
            // 收集所有数据
            const newData = {
                id: id,
                account_type: row.querySelector('[data-field="account_type"] select').value,
                username: row.querySelector('[data-field="username"] input').value.trim(),
                username_cn: row.querySelector('[data-field="username_cn"] input').value.trim(),
                nickname: row.querySelector('[data-field="nickname"] input').value.trim(),
                ic_number: row.querySelector('[data-field="ic_number"] input').value.trim(),
                date_of_birth: row.querySelector('[data-field="date_of_birth"] input').value,
                gender: row.querySelector('[data-field="gender"] select').value,
                nationality: row.querySelector('[data-field="nationality"] input').value.trim(),
                phone_number: row.querySelector('[data-field="phone_number"] input').value.trim(),
                email: row.querySelector('[data-field="email"] input').value.trim(),
                home_address: row.querySelector('[data-field="home_address"] textarea').value.trim(),
                position: row.querySelector('[data-field="position"] input').value.trim(),
                emergency_contact_name: row.querySelector('[data-field="emergency_contact_name"] input').value.trim(),
                emergency_phone_number: row.querySelector('[data-field="emergency_phone_number"] input').value.trim(),
                bank_name: row.querySelector('[data-field="bank_name"] input').value.trim(),
                bank_account: row.querySelector('[data-field="bank_account"] input').value.trim(),
                bank_account_holder_en: row.querySelector('[data-field="bank_account_holder_en"] input').value.trim(),
                registration_code: row.querySelector('[data-field="registration_code"] input').value.trim()
            };
            
            // 验证必填数据
            if (!newData.username) {
                showMessage('全名（英）不能为空！', 'error');
                return;
            }

            if (!newData.account_type) {
                showMessage('账户类型不能为空！', 'error');
                return;
            }

            if (!newData.email) {
                showMessage('邮箱不能为空！', 'error');
                return;
            }

            // 验证邮箱格式
            if (newData.email && !isValidEmail(newData.email)) {
                showMessage('邮箱格式不正确！', 'error');
                return;
            }
            
            // 显示保存状态
            const saveBtn = row.querySelector('.btn-save');
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<div class="loading"></div>保存中...';
            saveBtn.disabled = true;
            
            try {
                const response = await fetch('generatecodeapi.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'update',
                        ...newData
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showMessage('保存成功！', 'success');
                    loadCodesAndUsers(); // 重新加载数据
                } else {
                    showMessage(result.message || '保存失败！', 'error');
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('网络错误，请检查连接！', 'error');
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            }
        }

        // 取消编辑
        function cancelEdit(id) {
            const row = document.getElementById(`row-${id}`);
            const editBtn = row.querySelector('.btn-save');
            const cancelBtn = row.querySelector('.btn-cancel');
            
            // 移除编辑状态样式
            row.classList.remove('editing-row');
            
            // 恢复原始数据
            const editableFields = [
                'account_type', 'username', 'username_cn', 'nickname', 'ic_number', 
                'date_of_birth', 'gender', 'nationality', 'phone_number', 'email', 
                'home_address', 'position', 'emergency_contact_name', 'emergency_phone_number',
                'bank_name', 'bank_account', 'bank_account_holder_en', 'registration_code'
            ];
            
            editableFields.forEach(field => {
                const cell = row.querySelector(`[data-field="${field}"]`);
                if (cell) {
                    const originalValue = cell.getAttribute('data-original') || '';
                    
                    if (field === 'account_type') {
                        cell.innerHTML = `<span class="account-type-badge type-${originalValue}">${formatAccountType(originalValue)}</span>`;
                    } else if (field === 'gender') {
                        cell.innerHTML = formatGender(originalValue) || '<em style="color: #999;">-</em>';
                    } else if (field === 'registration_code') {
                        cell.innerHTML = originalValue || '<em style="color: #999;">-</em>';
                    } else {
                        cell.innerHTML = originalValue || '<em style="color: #999;">-</em>';
                    }
                }
            });
            
            // 恢复按钮
            editBtn.innerHTML = '<i class="fas fa-edit"></i> 编辑';
            editBtn.className = 'btn-action btn-edit';
            editBtn.setAttribute('onclick', `editRow(${id})`);
            
            cancelBtn.innerHTML = '<i class="fas fa-trash"></i> 删除';
            cancelBtn.className = 'btn-action btn-delete';
            cancelBtn.setAttribute('onclick', `confirmDelete(${id}, '${row.querySelector('[data-field="code"]').getAttribute('data-original')}')`);
        }

        // 确认删除
        function confirmDelete(id, code) {
            // 先关闭已存在的模态框
            closeModal();
            
            // 创建模态框
            const modal = document.createElement('div');
            modal.className = 'modal';
            modal.id = `deleteModal_${id}`; // 添加唯一ID
            modal.innerHTML = `
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="fas fa-exclamation-triangle"></i> 确认删除
                    </div>
                    <div class="modal-body">
                        确定要删除申请码 "<strong style="color: #f44336;">${code}</strong>" 吗？<br><br>
                        <strong style="color: #ff9800;">⚠️ 此操作不可撤销！</strong>
                    </div>
                    <div class="modal-buttons">
                        <button class="btn-action btn-delete" onclick="deleteRowAndClose(${id})">
                            <i class="fas fa-trash"></i> 确认删除
                        </button>
                        <button class="btn-action btn-cancel" onclick="closeModal()">
                            <i class="fas fa-times"></i> 取消
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            modal.style.display = 'block';
            
            // 点击模态框外部关闭
            modal.onclick = function(event) {
                if (event.target === modal) {
                    closeModal();
                }
            };
            
            // ESC 键关闭
            const escHandler = function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                    document.removeEventListener('keydown', escHandler);
                }
            };
            document.addEventListener('keydown', escHandler);
        }

        // 获取字段最大长度
        function getFieldMaxLength(field) {
            const maxLengths = {
                'username': 50,
                'username_cn': 100,
                'nickname': 50,
                'nationality': 50,
                'position': 100,
                'emergency_contact_name': 100,
                'bank_name': 100,
                'bank_account_holder_en': 50,
                'race': 50
            };
            return maxLengths[field] || 100;
        }

        // 获取字段占位符文本
        function getFieldPlaceholder(field) {
            const placeholders = {
                'username': '全名（英）',
                'username_cn': '全名（中）',
                'nickname': '小名',
                'nationality': '国籍',
                'position': '职位',
                'emergency_contact_name': '紧急联络人',
                'bank_name': '银行名称',
                'bank_account_holder_en': '银行持有人',
                'race': '种族'
            };
            return placeholders[field] || field;
        }

        // 关闭模态框
        function closeModal() {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.style.display = 'none';
                // 延迟移除，确保动画完成
                setTimeout(() => {
                    if (modal.parentNode) {
                        modal.parentNode.removeChild(modal);
                    }
                }, 100);
            });
        }

        // 删除行数据
        async function deleteRow(id) {
            try {
                const response = await fetch('generatecodeapi.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'delete',
                        id: id
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showMessage('删除成功！', 'success');
                    loadCodesAndUsers(); // 重新加载数据
                } else {
                    showMessage(result.message || '删除失败！', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('网络错误，请检查连接！', 'error');
            }
        }

        // 验证邮箱格式
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // 获取账号类型的键值（用于取消编辑时）
        function getAccountTypeKey(displayName) {
            const typeMap = {
                '老板': 'boss',
                '管理员': 'admin',
                '人事部': 'hr',
                '设计部': 'design',
                '支援部': 'support',
                '技术部': 'IT',
                '摄影部': 'photograph'
            };
            return typeMap[displayName] || displayName;
        }

        // 打开添加用户模态框
        function openAddUserModal() {
            document.getElementById('addUserModal').style.display = 'block';
        }

        // 关闭添加用户模态框
        function closeAddUserModal() {
            document.getElementById('addUserModal').style.display = 'none';
            document.getElementById('addUserForm').reset();
        }

        // 修改 addNewUser 函数，添加更多调试信息
        async function addNewUser() {
            const formData = new FormData(document.getElementById('addUserForm'));
            const userData = {};
            
            // 收集表单数据
            for (let [key, value] of formData.entries()) {
                userData[key] = value.trim();
            }
            
            console.log('发送的数据:', userData); // 调试信息
            
            // 验证必填字段
            if (!userData.username || !userData.email || !userData.account_type) {
                showMessage('请填写所有必填字段（英文姓名、邮箱、账号类型）！', 'error');
                return;
            }
            
            // 验证邮箱格式
            if (!isValidEmail(userData.email)) {
                showMessage('邮箱格式不正确！', 'error');
                return;
            }
            
            // 显示加载状态
            const submitBtn = document.querySelector('#addUserForm .btn-save');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<div class="loading"></div>添加中...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch('generatecodeapi.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'add_user',
                        ...userData
                    })
                });
                
                console.log('响应状态:', response.status); // 调试信息
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const result = await response.json();
                console.log('服务器响应:', result); // 调试信息
                
                if (result.success) {
                    showMessage(`用户 "${result.data.username}" 添加成功！申请码：${result.data.code}，默认密码：${result.data.default_password}`, 'success');
                    closeAddUserModal();
                    loadCodesAndUsers(); // 刷新表格
                } else {
                    showMessage(result.message || '添加失败，请重试！', 'error');
                }
            } catch (error) {
                console.error('详细错误信息:', error);
                showMessage(`网络错误：${error.message}`, 'error');
            } finally {
                // 恢复按钮状态
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }

        // 删除行数据并关闭模态框
        async function deleteRowAndClose(id) {
            // 显示删除中状态
            const modal = document.querySelector('.modal');
            const deleteBtn = modal.querySelector('.btn-delete');
            const cancelBtn = modal.querySelector('.btn-cancel');
            
            // 禁用按钮并显示加载状态
            deleteBtn.innerHTML = '<div class="loading"></div>删除中...';
            deleteBtn.disabled = true;
            cancelBtn.disabled = true;
            
            try {
                const response = await fetch('generatecodeapi.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'delete',
                        id: id
                    })
                });
                
                const result = await response.json();
                
                // 确保关闭模态框
                closeModal();
                
                if (result.success) {
                    showMessage('删除成功！', 'success');
                    loadCodesAndUsers(); // 重新加载数据
                } else {
                    showMessage(result.message || '删除失败！', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                closeModal(); // 确保出错时也关闭模态框
                showMessage('网络错误，请检查连接！', 'error');
            }
        }

        // 点击模态框外部关闭（为添加用户模态框）
        document.getElementById('addUserModal').onclick = function(event) {
            if (event.target === this) {
                closeAddUserModal();
            }
        };

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
    </script>
</body>
</html>