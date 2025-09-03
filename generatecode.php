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
    background: linear-gradient(135deg, #fff8f5 0%, #ffe8dc 100%);
    min-height: 100vh;
    color: #2d2d2d;
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
    text-shadow: 2px 2px 4px rgba(255, 92, 0, 0.15);
    font-weight: 700;
}

.header p {
    color: #8b4513;
    font-size: 17px;
    font-weight: 500;
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
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(255, 92, 0, 0.08);
    margin-bottom: 30px;
    border: 2px solid #ff5c00;
}

.form-title {
    color: #ff5c00;
    font-size: 24px;
    margin-bottom: 25px;
    text-align: center;
    border-bottom: 3px solid #ff5c00;
    padding-bottom: 12px;
    font-weight: 700;
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
    color: #8b4513;
    font-weight: 600;
    font-size: 15px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #ffb380;
    border-radius: 10px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: #fff;
    color: #2d2d2d;
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #ff5c00;
    box-shadow: 0 0 0 3px rgba(255, 92, 0, 0.15);
}

.btn-generate {
    background: linear-gradient(135deg, #ff5c00 0%, #e65100 100%);
    color: white;
    border: none;
    padding: 14px 32px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 4px 16px rgba(255, 92, 0, 0.2);
}

.btn-generate:hover {
    background: linear-gradient(135deg, #e65100 0%, #d84315 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(255, 92, 0, 0.3);
}

.btn-generate:disabled {
    opacity: 0.7;
    transform: none;
    cursor: not-allowed;
}

/* 消息提示样式 */
.message {
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-weight: 600;
    text-align: center;
    border-width: 2px;
    border-style: solid;
}

.message.success {
    background: #e8f5e8;
    color: #2e7d32;
    border-color: #4caf50;
}

.message.error {
    background: #ffebee;
    color: #d32f2f;
    border-color: #f44336;
}

/* 表格样式 */
.table-container {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(255, 92, 0, 0.08);
    border: 2px solid #ff5c00;
}

.table-title {
    background: linear-gradient(135deg, #ff5c00 0%, #e65100 100%);
    color: white;
    padding: 24px;
    font-size: 22px;
    font-weight: 700;
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
    background: linear-gradient(135deg, #fff2e6 0%, #ffe0cc 100%);
    color: #8b4513;
    padding: 16px 12px;
    text-align: left;
    font-weight: 700;
    border-bottom: 2px solid #ffb380;
    font-size: 15px;
}

th:first-child {
    text-align: center;
}

td {
    padding: 14px 12px;
    font-weight: 500;
    border-bottom: 1px solid #ffe0cc;
    vertical-align: middle;
    color: #2d2d2d;
}

tr:hover {
    background: linear-gradient(135deg, #fff8f5 0%, #fff2e6 100%);
    transition: all 0.2s ease;
}

/* 状态标签样式 */
.status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    text-align: center;
    display: inline-block;
    min-width: 80px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-used {
    background: linear-gradient(135deg, #c8e6c9 0%, #a5d6a7 100%);
    color: #1b5e20;
    box-shadow: 0 2px 8px rgba(76, 175, 80, 0.2);
}

.status-unused {
    background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
    color: #bf360c;
    box-shadow: 0 2px 8px rgba(255, 152, 0, 0.2);
}

.account-type-badge {
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
}

.type-admin {
    background: linear-gradient(135deg, #f8bbd9 0%, #f48fb1 100%);
    color: #880e4f;
}

.type-hr {
    background: linear-gradient(135deg, #c8e6c9 0%, #a5d6a7 100%);
    color: #1b5e20;
}

.type-design {
    background: linear-gradient(135deg, #bbdefb 0%, #90caf9 100%);
    color: #0d47a1;
}

.type-support {
    background: linear-gradient(135deg, #ffe0b2 0%, #ffcc02 100%);
    color: #e65100;
}

.type-it {
    background: linear-gradient(135deg, #d1c4e9 0%, #b39ddb 100%);
    color: #4a148c;
}

.type-photograph {
    background: linear-gradient(135deg, #ffcdd2 0%, #ef9a9a 100%);
    color: #b71c1c;
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
        padding: 10px 8px;
        font-size: 14px;
    }

    .back-button {
        position: static;
        margin-bottom: 20px;
    }
}

/* 加载动画 */
.loading {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid #ffe0b2;
    border-radius: 50%;
    border-top-color: #ff5c00;
    animation: spin 1s ease-in-out infinite;
    margin-right: 10px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* 空状态和错误状态的文字颜色 */
em {
    color: #999 !important;
    font-style: italic;
}

/* 强调文字 */
strong {
    color: #ff5c00;
    font-weight: 700;
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
            <h2 class="form-title">生成申请码</h2>
            
            <div id="messageArea"></div>

            <form id="generateForm">
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label for="code">申请码:</label>
                        <input type="text" id="code" name="code" required 
                               placeholder="请输入申请码 (例如: ADMIN001)" 
                               maxlength="50">
                    </div>
                    
                    <div class="form-group" style="flex: 2;">
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
                            <th>代码</th>
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
            const code = document.getElementById('code').value.trim();
            const accountType = document.getElementById('account_type').value;
            const btnText = document.getElementById('btnText');
            const messageArea = document.getElementById('messageArea');

            if (!code || !accountType) {
                showMessage('请填写所有必填字段！', 'error');
                return;
            }

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
                    showMessage(`代码 "${code}" 生成成功！`, 'success');
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

            const rows = data.map((item, index) => `
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