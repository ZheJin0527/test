<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Application Code - Kunzz Group</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <style>
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        
        .card-header {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            border-bottom: none;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #004085);
            transform: translateY(-1px);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }
        
        .badge {
            font-size: 0.85em;
            padding: 0.5em 0.75em;
        }
        
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        
        .spinner-border {
            color: #007bff;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="text-white mt-2">Processing...</div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 text-dark mb-0">
                    <i class="fas fa-key text-primary me-2"></i>
                    Generate Application Code
                </h1>
                <p class="text-muted mb-0">Create registration codes for new users</p>
            </div>
        </div>

        <!-- Generate Code Form -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-plus-circle me-2"></i>
                            Generate New Code
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="generateCodeForm">
                            <div class="mb-3">
                                <label for="code" class="form-label">
                                    <i class="fas fa-code me-1"></i>
                                    Code <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="code" name="code" required 
                                       placeholder="Enter application code (e.g., ADM002)">
                                <div class="form-text">Code must be unique</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="account_type" class="form-label">
                                    <i class="fas fa-user-tag me-1"></i>
                                    Account Type <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="account_type" name="account_type" required>
                                    <option value="">Select Account Type</option>
                                    <option value="admin">Admin</option>
                                    <option value="hr">HR</option>
                                    <option value="design">Design</option>
                                    <option value="support">Support</option>
                                    <option value="IT">IT</option>
                                    <option value="photograph">Photograph</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-magic me-2"></i>
                                Generate Code
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Statistics Card -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar me-2"></i>
                            Code Statistics
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="statisticsContent">
                            <div class="text-center">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="mt-2">Loading statistics...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Codes and Users Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-table me-2"></i>
                            Application Codes & Users
                        </h5>
                        <button class="btn btn-sm btn-outline-primary" onclick="refreshTable()">
                            <i class="fas fa-refresh me-1"></i>
                            Refresh
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="codesTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Account Type</th>
                                        <th>Status</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Phone Number</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let dataTable;

        $(document).ready(function() {
            // Initialize DataTable
            initializeDataTable();
            
            // Load statistics
            loadStatistics();
            
            // Generate code form submission
            $('#generateCodeForm').on('submit', function(e) {
                e.preventDefault();
                generateCode();
            });
        });

        function initializeDataTable() {
            dataTable = $('#codesTable').DataTable({
                ajax: {
                    url: 'generatecodeapi.php?action=getCodesAndUsers',
                    dataSrc: 'data'
                },
                columns: [
                    { 
                        data: 'code',
                        render: function(data, type, row) {
                            return '<strong class="text-primary">' + data + '</strong>';
                        }
                    },
                    { 
                        data: 'account_type',
                        render: function(data, type, row) {
                            const badges = {
                                'admin': 'danger',
                                'hr': 'success',
                                'design': 'info',
                                'support': 'warning',
                                'IT': 'primary',
                                'photograph': 'secondary'
                            };
                            return '<span class="badge bg-' + (badges[data] || 'secondary') + '">' + 
                                   data.toUpperCase() + '</span>';
                        }
                    },
                    { 
                        data: 'used',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return '<span class="badge bg-success"><i class="fas fa-check me-1"></i>Used</span>';
                            } else {
                                return '<span class="badge bg-secondary"><i class="fas fa-clock me-1"></i>Available</span>';
                            }
                        }
                    },
                    { 
                        data: 'username',
                        render: function(data, type, row) {
                            return data ? '<i class="fas fa-user me-1"></i>' + data : '<span class="text-muted">-</span>';
                        }
                    },
                    { 
                        data: 'email',
                        render: function(data, type, row) {
                            return data ? '<i class="fas fa-envelope me-1"></i>' + data : '<span class="text-muted">-</span>';
                        }
                    },
                    { 
                        data: 'gender',
                        render: function(data, type, row) {
                            if (data) {
                                const icons = {
                                    'male': '<i class="fas fa-mars text-primary"></i>',
                                    'female': '<i class="fas fa-venus text-danger"></i>',
                                    'other': '<i class="fas fa-genderless text-secondary"></i>'
                                };
                                return icons[data] + ' ' + data.charAt(0).toUpperCase() + data.slice(1);
                            }
                            return '<span class="text-muted">-</span>';
                        }
                    },
                    { 
                        data: 'phone_number',
                        render: function(data, type, row) {
                            return data ? '<i class="fas fa-phone me-1"></i>' + data : '<span class="text-muted">-</span>';
                        }
                    },
                    { 
                        data: 'created_at',
                        render: function(data, type, row) {
                            if (data) {
                                const date = new Date(data);
                                return '<small>' + date.toLocaleDateString() + '<br>' + date.toLocaleTimeString() + '</small>';
                            }
                            return '<span class="text-muted">-</span>';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        render: function(data, type, row) {
                            let actions = '';
                            if (row.used == 0) {
                                actions += '<button class="btn btn-sm btn-outline-danger me-1" onclick="deleteCode(\'' + row.code + '\')">' +
                                          '<i class="fas fa-trash"></i></button>';
                            }
                            actions += '<button class="btn btn-sm btn-outline-info" onclick="viewDetails(\'' + row.code + '\')">' +
                                      '<i class="fas fa-eye"></i></button>';
                            return actions;
                        }
                    }
                ],
                order: [[7, 'desc']],
                pageLength: 10,
                responsive: true,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });
        }

        function generateCode() {
            const formData = new FormData($('#generateCodeForm')[0]);
            
            showLoading();
            
            $.ajax({
                url: 'generatecodeapi.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    hideLoading();
                    
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Code generated successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        
                        // Reset form
                        $('#generateCodeForm')[0].reset();
                        
                        // Refresh table and statistics
                        dataTable.ajax.reload();
                        loadStatistics();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    hideLoading();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred. Please try again.'
                    });
                }
            });
        }

        function loadStatistics() {
            $.ajax({
                url: 'generatecodeapi.php?action=getStatistics',
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        const stats = response.data;
                        const html = `
                            <div class="row text-center">
                                <div class="col-6 col-md-3 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="h4 text-primary mb-1">${stats.total_codes}</div>
                                        <div class="small text-muted">Total Codes</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="h4 text-success mb-1">${stats.used_codes}</div>
                                        <div class="small text-muted">Used</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="h4 text-warning mb-1">${stats.available_codes}</div>
                                        <div class="small text-muted">Available</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="h4 text-info mb-1">${stats.total_users}</div>
                                        <div class="small text-muted">Total Users</div>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#statisticsContent').html(html);
                    }
                },
                error: function() {
                    $('#statisticsContent').html('<div class="text-danger">Error loading statistics</div>');
                }
            });
        }

        function refreshTable() {
            dataTable.ajax.reload();
            loadStatistics();
        }

        function deleteCode(code) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will permanently delete the code: ' + code,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'generatecodeapi.php',
                        type: 'POST',
                        data: {
                            action: 'deleteCode',
                            code: code
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Deleted!', 'Code has been deleted.', 'success');
                                dataTable.ajax.reload();
                                loadStatistics();
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Failed to delete code.', 'error');
                        }
                    });
                }
            });
        }

        function viewDetails(code) {
            // 此功能可以实现显示更多关于代码/用户的详细信息
            Swal.fire({
                title: '代码详情',
                text: '代码: ' + code,
                icon: 'info'
            });
        }

        function showLoading() {
            $('#loadingOverlay').css('display', 'flex');
        }

        function hideLoading() {
            $('#loadingOverlay').hide();
        }
    </script>
</body>
</html>