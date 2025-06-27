<?php
// 数据库配置
$dbHost = "1Panel-mysql-0gVo";
$dbUsername = "lcytuAPI";
$dbPassword = "CcBhb7tYS8TnPbrm";
$dbName = "lcytuAPI";

// 创建数据库连接
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// 检查连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 判断访问设备
$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
$isMobile = preg_match('/mobile|android|touch|samsung/', $userAgent);

// 选择表
$table = $isMobile ? 'mp' : 'pc';

// 检查是否请求JSON格式
if (isset($_GET['json'])) {
    // 检查json参数
    if (isset($_GET['json']) && is_numeric($_GET['json'])) {
        $jsonParam = intval($_GET['json']);
        
        // 获取指定行的记录
        $query = "SELECT link FROM $table LIMIT 1 OFFSET " . ($jsonParam - 1);
        $result = $conn->query($query);

        if ($row = $result->fetch_assoc()) {
            // 输出链接
            header('Content-Type: text/plain');
            echo $row['link'];
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "No link found for ID: $jsonParam";
        }
    } else {
        // 检查数量参数
        $quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;
        
        // 从表中随机获取指定数量的记录
        $query = "SELECT link FROM $table ORDER BY RAND() LIMIT $quantity";
        $result = $conn->query($query);

        // 准备返回的链接数组
        $links = [];
        while ($row = $result->fetch_assoc()) {
            $links[] = $row['link'];
        }

        // 输出纯链接格式，每行一个链接
        header('Content-Type: text/plain'); // 设置内容类型为纯文本
        echo implode("\n", $links); // 每个链接单独一行
    }
} else {
    // 从表中随机获取一条记录
    $query = "SELECT link FROM $table ORDER BY RAND() LIMIT 1";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $link = $row['link'];

    // 直接输出图片
    header("Location: $link");
    exit();
}

// 关闭数据库连接
$conn->close();
?>