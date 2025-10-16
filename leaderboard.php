<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

// ===== 修改这里的数据库配置 =====
$servername = "localhost";  // 通常是 localhost
$username = "u857194726_kunzzgroup";  // 从Hostinger控制面板获取
$password = "Kholdings1688@";  // 从Hostinger控制面板获取
$dbname = "u857194726_kunzzgroup";      // 从Hostinger控制面板获取
// ================================

// 创建数据库连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => '数据库连接失败']));
}

// 设置字符集
$conn->set_charset("utf8mb4");

// 获取请求方法
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // 保存成绩
    $data = json_decode(file_get_contents('php://input'), true);
    
    $player_name = $conn->real_escape_string($data['name']);
    $score = intval($data['score']);
    $combo = intval($data['combo']);
    
    // 验证数据
    if (empty($player_name) || $score < 0 || $combo < 0) {
        echo json_encode(['success' => false, 'message' => '数据无效']);
        exit;
    }
    
    // 限制名字长度
    $player_name = mb_substr($player_name, 0, 50);
    
    $sql = "INSERT INTO sushi_leaderboard (player_name, score, combo) VALUES ('$player_name', $score, $combo)";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => '成绩已保存']);
    } else {
        echo json_encode(['success' => false, 'message' => '保存失败']);
    }
    
} elseif ($method === 'GET') {
    // 获取排行榜 (前20名)
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
    $limit = min($limit, 100); // 最多100条
    
    $sql = "SELECT player_name, score, combo, DATE_FORMAT(play_date, '%Y-%m-%d %H:%i') as play_date 
            FROM sushi_leaderboard 
            ORDER BY score DESC, combo DESC 
            LIMIT $limit";
    
    $result = $conn->query($sql);
    
    $leaderboard = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $leaderboard[] = $row;
        }
    }
    
    echo json_encode(['success' => true, 'data' => $leaderboard]);
}

$conn->close();
?>