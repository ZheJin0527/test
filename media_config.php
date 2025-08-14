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
            'file' => 'video/video/Cover4.mp4',
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
        ],
        'tokyo_background' => [
            'file' => 'images/images/tokyo_bg.jpg',
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
        
        return "<video{$attrString}><source src=\"{$fileUrl}\" type=\"video/mp4\" /></video>";
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
            for ($i = 1; $i <= 34; $i++) {
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
        for ($i = 1; $i <= 34; $i++) {
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
 * 获取地址配置
 * @return array 地址信息
 */
function getLocationConfig() {
    $configFile = 'location_config.json';
    $defaultConfig = [
        'main_store' => [
            'name' => '总店',
            'address' => 'T-042 Level 3, Mid Valley, The Mall, Southkey, 81100 Johor Bahru, Johor Darul Ta\'zim',
            'phone' => '+60 19-710 8090',
            'map_url' => 'https://maps.app.goo.gl/VcQp7YGAeQadDNRx9'
        ],
        'branch_store' => [
            'name' => '分店',
            'address' => 'Lot UG-25, Upper Ground Floor, Paradigm Mall, Lbh Skudai, Taman Bukit Mewah, 81200 Johor Bahru, Johor Darul Ta\'zim',
            'phone' => '+60 18-773 8090',
            'map_url' => 'https://maps.app.goo.gl/7vDymMQJ3h9Srp4M6'
        ]
    ];
    
    if (file_exists($configFile)) {
        $config = json_decode(file_get_contents($configFile), true);
        if ($config) {
            return array_merge($defaultConfig, $config);
        }
    }
    
    return $defaultConfig;
}

/**
 * 保存地址配置
 * @param array $config 地址配置
 * @return bool 成功返回true
 */
function saveLocationConfig($config) {
    $configFile = 'location_config.json';
    return file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}

/**
 * 获取地址信息的HTML
 * @return string HTML内容
 */
function getLocationHtml() {
    $config = getLocationConfig();
    
    $html = '<div class="location-info">';
    $html .= '<h2>我们在这</h2>';
    
    // 总店信息
    if (isset($config['main_store'])) {
        $store = $config['main_store'];
        $html .= '<p>' . $store['name'] . '：';
        $html .= '<a href="' . $store['map_url'] . '" target="_blank" class="no-style-link">';
        $html .= $store['address'];
        $html .= '</a></p>';
        $html .= '<p>电话：' . $store['phone'] . '</p>';
    }
    
    // 分店信息
    if (isset($config['branch_store'])) {
        $store = $config['branch_store'];
        $html .= '<p>' . $store['name'] . '：';
        $html .= '<a href="' . $store['map_url'] . '" target="_blank" class="no-style-link">';
        $html .= $store['address'];
        $html .= '</a></p>';
        $html .= '<p>电话：' . $store['phone'] . '</p>';
    }
    
    $html .= '</div>';
    
    return $html;
}
?>