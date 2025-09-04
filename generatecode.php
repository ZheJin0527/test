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
            max-width: 1600px;
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
            background: white;
            padding: 10px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            border: 2px solid #ff5c00;
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
            border-bottom: 1px solid #d1d5db;
        }

        th:first-child {
            text-align: center;
        }

        td {
            padding: 12px 10px;
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
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .type-admin {
            background: #F8BBD9;
            color: #AD1457;
        }

        .type-hr {
            background: #C8E6C9;
            color: #2E7D32;
        }

        .type-design {
            background: #BBDEFB;
            color: #1565C0;
        }

        .type-support {
            background: #FFE0B2;
            color: #E65100;
        }

        .type-it {
            background: #D1C4E9;
            color: #4A148C;
        }

        .type-photograph {
            background: #FFCDD2;
            color: #C62828;
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
                    <div class="form-group" style="flex: 3;">
                        <label for="account_type">账户类型:</label>
                        <select id="account_type" name="account_type" required>
                            <option value="">请选择账户类型</option>
                            <option value="admin">管理员 (Admin)</option>
                            <option value="hr">人事部 (HR)</option>
                            <option value="design">设计部 (Design)</option>
                            <option value="support">支援部 (Support)</option>
                            <option value="IT">技术部 (IT)</option>
                            <option value="photograph">摄影部 (Photography)</option>
                        </select>
                    </div>
                    
                    <div class="form-group" style="flex: 1;">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn-generate">
                            <span id="btnText">生成代码</span>
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
                            <th>申请码</th>
                            <th>账户类型</th>
                            <th>使用状态</th>
                            <th>用户名</th>
                            <th>邮箱</th>
                            <th>性别</th>
                            <th>电话号码</th>
                            <th>创建时间</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 30px;">
                                <div class="loading"></div>
                                正在加载数据...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // 页面加载时获取数据
        document.addEventListener('DOMContentLoaded', function() {
            loadCodesAndUsers();
        });

        // 表单提交处理
        document.getElementById('generateForm').addEventListener('submit', function(e) {
            e.preventDefault();
            generateCode();
        });

        // 生成代码函数
        async function generateCode() {
            const accountType = document.getElementById('account_type').value;
            const btnText = document.getElementById('btnText');
            const messageArea = document.getElementById('messageArea');

            if (!accountType) {
                showMessage('请选择账户类型！', 'error');
                return;
            }

            // 生成6位随机代码
            const code = generateRandomCode();

            // 显示加载状态
            btnText.innerHTML = '<div class="loading"></div>生成中...';
            document.querySelector('.btn-generate').disabled = true;

            try {
                const response = await fetch('generatecodeapi.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'generate',
                        code: code,
                        account_type: accountType
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showMessage(`申请码 "${result.data.code}" 生成成功！`, 'success');
                    document.getElementById('generateForm').reset();
                    loadCodesAndUsers(); // 刷新表格
                } else {
                    showMessage(result.message || '生成失败，请重试！', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('网络错误，请检查连接！', 'error');
            } finally {
                // 恢复按钮状态
                btnText.innerHTML = '🚀 生成代码';
                document.querySelector('.btn-generate').disabled = false;
            }
        }

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
                            <td colspan="9" style="text-align: center; padding: 30px; color: #C62828;">
                                ❌ 加载失败: ${result.message}
                            </td>
                        </tr>
                    `;
                }
            } catch (error) {
                console.error('Error:', error);
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 30px; color: #C62828;">
                            ❌ 网络错误，请检查连接
                        </td>
                    </tr>
                `;
            }
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
                        <td colspan="9" style="text-align: center; padding: 30px; color: #666;">
                            📝 暂无数据
                        </td>
                    </tr>
                `;
                return;
            }

            // 定义账户类型的排序顺序
            const typeOrder = {
                'admin': 1,
                'hr': 2, 
                'design': 3,
                'support': 4,
                'IT': 5,
                'photograph': 6
            };
            
            // 按照指定顺序排序数据
            const sortedData = [...data].sort((a, b) => {
                const orderA = typeOrder[a.account_type] || 999;
                const orderB = typeOrder[b.account_type] || 999;
                return orderA - orderB;
            });

            const rows = sortedData.map((item, index) => `
                <tr>
                    <td style="text-align: center; font-weight: bold; color: black;">${index + 1}</td>
                    <td><strong>${item.code}</strong></td>
                    <td><span class="account-type-badge">${formatAccountType(item.account_type)}</span></td>
                    <td><span class="status-badge ${item.used == 1 ? 'status-used' : 'status-unused'}">${item.used == 1 ? '已使用' : '未使用'}</span></td>
                    <td>${item.username || '<em style="color: #999;">-</em>'}</td>
                    <td>${item.email || '<em style="color: #999;">-</em>'}</td>
                    <td>${formatGender(item.gender) || '<em style="color: #999;">-</em>'}</td>
                    <td>${item.phone_number || '<em style="color: #999;">-</em>'}</td>
                    <td>${formatDateTime(item.created_at)}</td>
                </tr>
            `).join('');

            tableBody.innerHTML = rows;
        }

        // 格式化账户类型
        function formatAccountType(type) {
            const types = {
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

        // 格式化日期时间
        function formatDateTime(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleString('zh-CN', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            });
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

        // 代码输入框自动转大写
        document.getElementById('code').addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });
    </script>
</body>
</html>