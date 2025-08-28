<?php
// vendor/autoload.php
spl_autoload_register(function ($class) {
    // 将命名空间转换为文件路径
    $prefix = 'PhpOffice\\PhpSpreadsheet\\';
    $base_dir = __DIR__ . '/phpoffice/phpspreadsheet/src/PhpSpreadsheet/';
    
    // 检查类是否使用了这个命名空间前缀
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    // 获取相对类名
    $relative_class = substr($class, $len);
    
    // 将命名空间前缀替换为基础目录，将命名空间分隔符替换为目录分隔符
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    // 如果文件存在，则引入
    if (file_exists($file)) {
        require $file;
    }
});
?>