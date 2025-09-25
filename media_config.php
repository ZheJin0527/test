<?php
/**
 * 读取媒体配置文件
 * @param string $mediaType 媒体类型
 * @return array 媒体信息
 */
function getMediaConfig($mediaType) {
    $configFile = 'media_config.json';
    $defaultConfig = [
        'home_background' => [
            'file' => '/video/video/home_background.webm',
            'type' => 'video'
        ],
        'about_background' => [
            'file' => 'images/images/关于我们bg8.jpg',
            'type' => 'image'
        ],
        // 添加这个配置
        'joinus_background' => [
            'file' => 'images/images/加入我们bg2.jpg',
            'type' => 'image'
        ]
    ];
    
    if (file_exists($configFile)) {
        $config = json_decode(file_get_contents($configFile), true);
        if ($config && isset($config[$mediaType]) && file_exists($config[$mediaType]['file'])) {
            return $config[$mediaType];
        }
    }
    
    return isset($defaultConfig[$mediaType]) ? $defaultConfig[$mediaType] : $defaultConfig['home_background'];
}

/**
 * 获取媒体文件的HTML标签
 * @param string $mediaType 媒体类型
 * @param array $attributes 额外的HTML属性
 * @return string HTML标签
 */
function getMediaHtml($mediaType, $attributes = []) {
    $media = getMediaConfig($mediaType);
    
    // 添加时间戳防止缓存
    $timestamp = file_exists($media['file']) ? '?v=' . filemtime($media['file']) : '?v=' . time();
    $fileUrl = $media['file'] . $timestamp;
    
    if ($media['type'] === 'video') {
        $defaultAttrs = [
            'class' => 'background-video',
            'autoplay' => '',
            'muted' => '',
            'loop' => '',
            'playsinline' => ''
        ];
        $attrs = array_merge($defaultAttrs, $attributes);
        
        $attrString = '';
        foreach ($attrs as $key => $value) {
            $attrString .= $value === '' ? " {$key}" : " {$key}=\"{$value}\"";
        }
        
        // 根据文件扩展名确定MIME类型
        $extension = strtolower(pathinfo($media['file'], PATHINFO_EXTENSION));
        $mimeType = 'video/mp4'; // 默认
        switch ($extension) {
            case 'webm':
                $mimeType = 'video/webm';
                break;
            case 'mov':
                $mimeType = 'video/quicktime';
                break;
            case 'avi':
                $mimeType = 'video/x-msvideo';
                break;
            case 'mp4':
            default:
                $mimeType = 'video/mp4';
                break;
        }
        
        return "<video{$attrString}><source src=\"{$fileUrl}\" type=\"{$mimeType}\" /></video>";
    } else {
        $defaultAttrs = [
            'class' => 'background-image',
            'style' => 'width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;'
        ];
        $attrs = array_merge($defaultAttrs, $attributes);
        
        $attrString = '';
        foreach ($attrs as $key => $value) {
            $attrString .= " {$key}=\"{$value}\"";
        }
        
        return "<img src=\"{$fileUrl}\" alt=\"Background\"{$attrString}>";
    }
}


/**
 * 获取公司照片数组
 * @return array 照片路径数组
 */
function getCompanyPhotos() {
    $configFile = 'media_config.json';
    $photos = [];
    
    if (file_exists($configFile)) {
        $config = json_decode(file_get_contents($configFile), true);
        if ($config) {
            for ($i = 1; $i <= 30; $i++) {
                $key = 'comphoto_' . $i;
                if (isset($config[$key]) && file_exists($config[$key]['file'])) {
                    $photos[] = $config[$key]['file'] . '?v=' . filemtime($config[$key]['file']);
                } else {
                    // 如果照片不存在，可以使用默认占位图
                    $photos[] = 'https://picsum.photos/400/300?random=' . $i;
                }
            }
        }
    }
    
    // 如果没有配置文件，返回默认照片
    if (empty($photos)) {
        for ($i = 1; $i <= 30; $i++) {
            $photos[] = 'https://picsum.photos/400/300?random=' . $i;
        }
    }
    
    return $photos;
}

/**
 * 获取时间线配置
 * @param string $year 年份
 * @return array 时间线数据
 */
function getTimelineConfig($year = null) {
    $configFile = 'timeline_config.json';
    $defaultTimeline = [
        '2022' => [
            'title' => '一味入魂，情暖人间 ✨',
            'description1' => '在人生的餐桌上，总有一些味道能够唤醒记忆，一些瞬间能够触动心弦。Tokyo Japanese Cuisine，这个名字不仅仅代表着精致的日式料理，更承载着一份对美食与服务的深情承诺。',
            'description2' => '我们的故事，始于 2022 年，那一年，我们怀揣着一个简单而又宏大的梦想：以热情的服务，让每一位走进Tokyo Japanese Cuisine的顾客，都能享受一场愉悦而难忘的用餐体验。',
            'image' => 'images/images/2022发展.jpg'
        ],
        '2023' => [
            'title' => '用心铸就，梦想生长 🌱',
            'description1' => 'Kunzz Holdings Sdn Bhd，一个承载着梦想与温度的名字，犹如一棵在希望沃土上扎根的幼苗，于 2023 年破土而出。我们不仅仅是一家肩负使命的控股公司，更是旗下每一家子公司最坚实的后盾与最真挚的引路人。',
            'description2' => '我们深信，唯有用心管理，倾力推广，才能让每一个独特的创意与梦想，在时代的舞台上绽放出最璀璨的光芒，成为改变世界的力量。',
            'image' => 'images/images/2023的发展.jpg'
        ],
        '2025' => [
            'title' => '规范管理，稳健前行 🚀',
            'description1' => '2025年，我们迎来了规范化管理的新纪元。通过建立完善的管理体系和标准化流程，我们不断提升运营效率，确保每一个项目都能在规范的轨道上稳健发展。',
            'description2' => '我们始终坚持以客户为中心，以质量为生命，用专业的态度和创新的思维，为客户创造更大价值，为行业树立新的标杆。',
            'image' => 'images/images/2025的发展.jpg'
        ]
    ];
    
    // 读取自定义配置
    $config = $defaultTimeline;
    if (file_exists($configFile)) {
        $customConfig = json_decode(file_get_contents($configFile), true);
        if ($customConfig) {
            // 合并配置，保留自定义年份
            $config = array_merge($defaultTimeline, $customConfig);
        }
    }
    
    // 按年份排序
    uksort($config, function($a, $b) {
        return (int)$a - (int)$b;
    });
    
    $config = $defaultTimeline;
    
    if (file_exists($configFile)) {
        $customConfig = json_decode(file_get_contents($configFile), true);
        if ($customConfig) {
            // 合并自定义配置和默认配置
            foreach ($customConfig as $configYear => $data) {
                if (isset($defaultTimeline[$configYear])) {
                    $config[$configYear] = array_merge($defaultTimeline[$configYear], $data);
                } else {
                    $config[$configYear] = $data;
                }
            }
        }
    }
    
    // 为图片添加时间戳防止缓存
    foreach ($config as $configYear => &$data) {
        if (isset($data['image']) && file_exists($data['image'])) {
            $data['image_url'] = $data['image'] . '?v=' . filemtime($data['image']);
        } else {
            $data['image_url'] = $data['image'] ?? '';
        }
    }
    
    return $year ? (isset($config[$year]) ? $config[$year] : null) : $config;
}

/**
 * 获取时间线HTML内容
 * @return string HTML内容
 */
function getTimelineHtml() {
    $timeline = getTimelineConfig();
    $html = '';
    $index = 0;
    
    foreach ($timeline as $year => $data) {
        $activeClass = $index === 0 ? 'active' : ($index === 1 ? 'next' : 'hidden');
        
        $html .= "<div class=\"timeline-content-item {$activeClass}\" data-year=\"{$year}\" data-index=\"{$index}\">";
        $html .= "<div class=\"timeline-content\" onclick=\"selectCard({$year})\">";
        $html .= "<div class=\"timeline-image\">";
        $html .= "<img src=\"{$data['image_url']}\" alt=\"{$year}年发展\">";
        $html .= "</div>";
        $html .= "<div class=\"timeline-text\">";
        $html .= "<div class=\"year-badge\">{$year}年</div>";
        $html .= "<h3>{$data['title']}</h3>";
        $html .= "<p>{$data['description1']}</p>";
        $html .= "<p>{$data['description2']}</p>";
        $html .= "</div>";
        $html .= "</div>";
        $html .= "</div>";
        
        $index++;
    }
    
    return $html;
}

/**
 * 获取排序后的年份数组
 * @return array 排序后的年份数组
 */
function getTimelineYears() {
    $config = getTimelineConfig();
    $years = array_keys($config);
    sort($years, SORT_NUMERIC);
    return $years;
}

/**
 * 添加新年份
 * @param string $year 年份
 * @param array $data 年份数据
 * @return bool 成功返回true
 */
function addTimelineYear($year, $data) {
    $configFile = 'timeline_config.json';
    $config = [];
    
    if (file_exists($configFile)) {
        $config = json_decode(file_get_contents($configFile), true) ?: [];
    }
    
    $config[$year] = array_merge([
        'title' => '新的里程碑',
        'description1' => '这是第一段描述...',
        'description2' => '这是第二段描述...',
        'image' => 'images/images/default.jpg',
        'created' => date('Y-m-d H:i:s')
    ], $data);
    
    return file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}

/**
 * 删除年份
 * @param string $year 年份
 * @return bool 成功返回true
 */
function deleteTimelineYear($year) {
    $configFile = 'timeline_config.json';
    
    if (!file_exists($configFile)) {
        return false;
    }
    
    $config = json_decode(file_get_contents($configFile), true);
    if (!$config || !isset($config[$year])) {
        return false;
    }
    
    // 删除对应的图片文件
    if (isset($config[$year]['image']) && file_exists($config[$year]['image'])) {
        unlink($config[$year]['image']);
    }
    
    unset($config[$year]);
    
    return file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}

/**
 * 获取Tokyo位置配置 - 增强版，支持动态添加
 * @return array Tokyo位置信息
 */
function getTokyoLocationConfig() {
    $configFile = 'tokyo_location_config.json';
    $defaultConfig = [
        'section_title' => '我们在这', // 添加这行
        'main_store' => [
            'label' => '总店：',
            'address' => 'T-042 Level 3, Mid Valley, The Mall, Southkey, 81100 Johor Bahru, Johor Darul Ta\'zim',
            'phone' => '+60 19-710 8090',
            'map_url' => 'https://maps.app.goo.gl/VcQp7YGAeQadDNRx9',
            'order' => 1
        ],
        'branch_store' => [
            'label' => '分店：',
            'address' => 'Lot UG-25, Upper Ground Floor, Paradigm Mall, Lbh Skudai, Taman Bukit Mewah, 81200 Johor Bahru, Johor Darul Ta\'zim',
            'phone' => '+60 18-773 8090',
            'map_url' => 'https://maps.app.goo.gl/7vDymMQJ3h9Srp4M6',
            'order' => 2
        ]
    ];
    
    if (file_exists($configFile)) {
        $config = json_decode(file_get_contents($configFile), true);
        if ($config && is_array($config)) {
            // 合并默认配置和自定义配置
            $mergedConfig = array_merge($defaultConfig, $config);
            
            // 按order字段排序，如果没有order字段则使用键名排序
            uasort($mergedConfig, function($a, $b) {
                $orderA = isset($a['order']) ? $a['order'] : 999;
                $orderB = isset($b['order']) ? $b['order'] : 999;
                return $orderA - $orderB;
            });
            
            return $mergedConfig;
        }
    }
    
    return $defaultConfig;
}

/**
 * 保存Tokyo位置配置 - 增强版
 * @param array $config 位置配置数据
 * @return bool 成功返回true
 */
function saveTokyoLocationConfig($config) {
    $configFile = 'tokyo_location_config.json';
    
    // 检查目录权限
    $dir = dirname($configFile);
    if (!is_writable($dir)) {
        error_log("目录不可写: $dir");
        return false;
    }
    
    // 验证数据结构
    if (!is_array($config)) {
        error_log("配置数据不是数组格式");
        return false;
    }
    
    // 添加时间戳和排序信息
    $order = 1;
    foreach ($config as $key => &$store) {
        if ($key === 'section_title') continue;
        
        if (is_array($store)) {
            $store['updated'] = date('Y-m-d H:i:s');
            if (!isset($store['order'])) {
                $store['order'] = $order++;
            }
        }
    }
    
    // 创建备份
    if (file_exists($configFile)) {
        copy($configFile, $configFile . '.backup.' . date('Y-m-d-H-i-s'));
    }
    
    // 保存文件
    $jsonData = json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if ($jsonData === false) {
        error_log("JSON编码失败: " . json_last_error_msg());
        return false;
    }
    
    $result = file_put_contents($configFile, $jsonData);
    if ($result === false) {
        error_log("写入文件失败: $configFile");
        return false;
    }
    
    return true;
}

/**
 * 添加新的Tokyo店铺
 * @param string $storeKey 店铺键名
 * @param array $storeData 店铺数据
 * @return bool 成功返回true
 */
function addTokyoStore($storeKey, $storeData) {
    $config = getTokyoLocationConfig();
    
    // 设置默认值
    $defaultData = [
        'label' => '新店铺：',
        'address' => '',
        'phone' => '',
        'map_url' => '',
        'order' => count($config) + 1,
        'created' => date('Y-m-d H:i:s')
    ];
    
    $config[$storeKey] = array_merge($defaultData, $storeData);
    
    return saveTokyoLocationConfig($config);
}

/**
 * 删除Tokyo店铺
 * @param string $storeKey 店铺键名
 * @return bool 成功返回true
 */
function deleteTokyoStore($storeKey) {
    $config = getTokyoLocationConfig();
    
    if (!isset($config[$storeKey])) {
        return false;
    }
    
    // 不允许删除默认的主要店铺
    if (in_array($storeKey, ['main_store', 'branch_store'])) {
        return false;
    }
    
    unset($config[$storeKey]);
    
    return saveTokyoLocationConfig($config);
}

/**
 * 生成Tokyo位置信息HTML - 增强版
 * @return string HTML内容
 */
function getTokyoLocationHtml() {
    $config = getTokyoLocationConfig();
    $html = '';
    
    // 修改这行，使用配置中的标题
    $sectionTitle = isset($config['section_title']) ? $config['section_title'] : '我们在这';
    $html .= '<h2>' . htmlspecialchars($sectionTitle) . '</h2>';
    
    foreach ($config as $storeKey => $store) {
        // 跳过标题配置项
        if ($storeKey === 'section_title') continue;
        
        if (!empty($store['address'])) {
            $html .= '<p>' . htmlspecialchars($store['label']) . 
                    '<a href="' . htmlspecialchars($store['map_url']) . '" target="_blank" class="no-style-link">' . 
                    htmlspecialchars($store['address']) . 
                    '</a></p>';
            $html .= '<p>电话：' . htmlspecialchars($store['phone']) . '</p>';
        }
    }
    
    return $html;
}

/**
 * 获取店铺统计信息
 * @return array 统计数据
 */
function getTokyoStoreStats() {
    $config = getTokyoLocationConfig();
    
    return [
        'total_stores' => count($config),
        'active_stores' => count(array_filter($config, function($store) {
            return !empty($store['address']) && !empty($store['phone']);
        })),
        'last_updated' => max(array_column($config, 'updated'))
    ];
}

/**
 * 验证店铺数据
 * @param array $storeData 店铺数据
 * @return array 验证结果 ['valid' => bool, 'errors' => array]
 */
function validateTokyoStoreData($storeData) {
    $errors = [];
    
    if (empty($storeData['label'])) {
        $errors[] = '标签文字不能为空';
    }
    
    if (empty($storeData['address'])) {
        $errors[] = '地址不能为空';
    }
    
    if (empty($storeData['phone'])) {
        $errors[] = '电话号码不能为空';
    }
    
    if (empty($storeData['map_url'])) {
        $errors[] = '地图链接不能为空';
    } elseif (!filter_var($storeData['map_url'], FILTER_VALIDATE_URL)) {
        $errors[] = '地图链接格式不正确';
    }
    
    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}

/**
 * 搜索店铺
 * @param string $keyword 搜索关键词
 * @return array 匹配的店铺
 */
function searchTokyoStores($keyword) {
    $config = getTokyoLocationConfig();
    $results = [];
    
    foreach ($config as $storeKey => $store) {
        $searchText = $store['label'] . ' ' . $store['address'] . ' ' . $store['phone'];
        if (stripos($searchText, $keyword) !== false) {
            $results[$storeKey] = $store;
        }
    }
    
    return $results;
}

/**
 * 导出店铺配置为JSON
 * @return string JSON字符串
 */
function exportTokyoStoresJson() {
    $config = getTokyoLocationConfig();
    return json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

/**
 * 从JSON导入店铺配置
 * @param string $jsonData JSON数据
 * @return bool 成功返回true
 */
function importTokyoStoresJson($jsonData) {
    $config = json_decode($jsonData, true);
    
    if (!$config || !is_array($config)) {
        return false;
    }
    
    // 验证每个店铺数据
    foreach ($config as $storeKey => $storeData) {
        $validation = validateTokyoStoreData($storeData);
        if (!$validation['valid']) {
            return false;
        }
    }
    
    return saveTokyoLocationConfig($config);
}

/**
 * 生成备份文件名
 * @return string 备份文件名
 */
function generateTokyoBackupFilename() {
    return 'tokyo_stores_backup_' . date('Y-m-d_H-i-s') . '.json';
}

/**
 * 创建店铺配置备份
 * @return string|false 备份文件路径或失败时返回false
 */
function backupTokyoStores() {
    $backupDir = 'backups';
    if (!file_exists($backupDir)) {
        mkdir($backupDir, 0755, true);
    }
    
    $backupFile = $backupDir . '/' . generateTokyoBackupFilename();
    $config = getTokyoLocationConfig();
    
    if (file_put_contents($backupFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        return $backupFile;
    }
    
    return false;
}

/**
 * 获取所有备份文件
 * @return array 备份文件列表
 */
function getTokyoBackups() {
    $backupDir = 'backups';
    $backups = [];
    
    if (file_exists($backupDir) && is_dir($backupDir)) {
        $files = scandir($backupDir);
        foreach ($files as $file) {
            if (strpos($file, 'tokyo_stores_backup_') === 0) {
                $backups[] = [
                    'filename' => $file,
                    'path' => $backupDir . '/' . $file,
                    'created' => filemtime($backupDir . '/' . $file),
                    'size' => filesize($backupDir . '/' . $file)
                ];
            }
        }
        
        // 按创建时间倒序排列
        usort($backups, function($a, $b) {
            return $b['created'] - $a['created'];
        });
    }
    
    return $backups;
}

/**
 * 获取招聘职位配置
 * @return array 职位信息数组
 */
function getJobsConfig() {
    $configFile = 'jobs_config.json';
    $jobs = [];
    
    if (file_exists($configFile)) {
        $jobs = json_decode(file_get_contents($configFile), true) ?: [];
    }
    
    // 按发布日期排序（最新的在前）
    uasort($jobs, function($a, $b) {
        return strtotime($b['publish_date']) - strtotime($a['publish_date']);
    });
    
    return $jobs;
}

/**
 * 生成招聘职位HTML
 * @return string 职位卡片HTML
 */
function getJobsHtml() {
    // 数据库配置
    $host = 'localhost';
    $dbname = 'u857194726_kunzzgroup';
    $dbuser = 'u857194726_kunzzgroup';
    $dbpass = 'Kholdings1688@';
    
    $html = '';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // 获取所有职位
        $stmt = $pdo->prepare("SELECT * FROM job_positions ORDER BY publish_date DESC, id DESC");
        $stmt->execute();
        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // 按公司分类分组
        $groupedJobs = [];
        foreach ($jobs as $job) {
            $category = $job['company_category'] ?? 'KUNZZ HOLDINGS';
            $groupedJobs[$category][] = $job;
        }
        
        // 为每个公司创建独立的卡片容器，确保KUNZZHOLDINGS在左边
        $companyOrder = ['KUNZZ HOLDINGS', 'TOKYO JAPANESE CUISINE', 'TOKYO IZAKAYA'];
        foreach ($companyOrder as $company) {
            $html .= '<div class="company-job-container">';
            $html .= '<h3 class="company-title">' . htmlspecialchars($company) . '</h3>';
            $html .= '<div class="company-jobs-list">';
            
            if (isset($groupedJobs[$company]) && !empty($groupedJobs[$company])) {
                if ($company === 'TOKYO JAPANESE CUISINE' || $company === 'TOKYO IZAKAYA') {
                    // 为TOKYO公司按部门分组显示
                    $departmentJobs = [];
                    foreach ($groupedJobs[$company] as $job) {
                        $dept = $job['company_department'] ?? '其他';
                        $departmentJobs[$dept][] = $job;
                    }
                    
                    // 定义部门顺序
                    $departmentOrder = ['前台', '厨房', 'sushi bar'];
                    
                    foreach ($departmentOrder as $dept) {
                        if (isset($departmentJobs[$dept]) && !empty($departmentJobs[$dept])) {
                            $jobCount = count($departmentJobs[$dept]);
                            $singleJobClass = ($jobCount == 1) ? ' single-job' : '';
                            
                            $html .= '<div class="department-section">';
                            $html .= '<div class="department-title">' . htmlspecialchars($dept) . '</div>';
                            $html .= '<div class="department-jobs' . $singleJobClass . '">';
                            
                            $jobIndex = 0;
                            foreach ($departmentJobs[$dept] as $job) {
                                $jobIndex++;
                                $isLastOddJob = ($jobCount > 2 && $jobCount % 2 == 1 && $jobIndex == $jobCount) ? ' last-odd-job' : '';
                                
                                $html .= '<div class="job-item' . $isLastOddJob . '" data-job-id="' . $job['id'] . '">';
                                $html .= '<div class="job-item-title">' . htmlspecialchars($job['job_title']) . '</div>';
                                $html .= '</div>';
                            }
                            
                            $html .= '</div>'; // department-jobs
                            $html .= '</div>'; // department-section
                        }
                    }
                } else {
                    // 其他公司（KUNZZ HOLDINGS）正常显示
                    foreach ($groupedJobs[$company] as $job) {
                        $html .= '<div class="job-item" data-job-id="' . $job['id'] . '">';
                        $html .= '<div class="job-item-title">' . htmlspecialchars($job['job_title']) . '</div>';
                        $html .= '</div>';
                    }
                }
            } else {
                $html .= '<div class="no-jobs-company">暂无职位</div>';
            }
            
            $html .= '</div>'; // company-jobs-list
            $html .= '</div>'; // company-job-container
        }
    } catch (Exception $e) {
        $html = '<div class="no-jobs">职位数据加载失败</div>';
    }
    
    return $html;
}

/**
 * 获取背景音乐配置
 * @return array 音乐信息
 */
function getBgMusicConfig() {
    $configFile = 'music_config.json';
    $defaultConfig = [
        'file' => 'audio/audio/music.mp3',
        'type' => 'audio',
        'format' => 'mp3'
    ];
    
    if (file_exists($configFile)) {
        $config = json_decode(file_get_contents($configFile), true);
        if ($config && isset($config['background_music']) && file_exists($config['background_music']['file'])) {
            return $config['background_music'];
        }
    }
    
    return $defaultConfig;
}

/**
 * 获取音乐HTML标签
 * @param array $attributes 额外的HTML属性
 * @return string HTML标签
 */
function getBgMusicHtml($attributes = []) {
    $music = getBgMusicConfig();
    
    // 添加时间戳防止缓存
    $timestamp = file_exists($music['file']) ? '?v=' . filemtime($music['file']) : '?v=' . time();
    $fileUrl = $music['file'] . $timestamp;
    
    $defaultAttrs = [
        'id' => 'bgMusic',
        'loop' => '',
        'preload' => 'auto'
    ];
    $attrs = array_merge($defaultAttrs, $attributes);
    
    $attrString = '';
    foreach ($attrs as $key => $value) {
        $attrString .= $value === '' ? " {$key}" : " {$key}=\"{$value}\"";
    }
    
    $mimeType = 'audio/' . ($music['format'] === 'mp3' ? 'mpeg' : $music['format']);
    
    return "<audio{$attrString}><source src=\"{$fileUrl}\" type=\"{$mimeType}\" /></audio>";
}
?>