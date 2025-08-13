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
?>