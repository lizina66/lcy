<?php
// 数据库连接配置
$servername = "1Panel-mysql-0gVo";  // 请确保此主机名/IP 地址正确
$username = "lcytuAPI";              // 数据库用户名
$password = "Cc**b*****Pbrm";      // 数据库密码
$dbname = "lcytuAPI";                // 数据库名称

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);


// 检测是否传入了 json 参数
if (isset($_GET['json'])) {
    // 检查是否传入特定行号的请求
    if (is_numeric($_GET['json'])) {
        $id = intval($_GET['json']);
        if ($id > 0) {
            // 获取数据库中指定行的链接
            $sql = "SELECT link FROM aimp LIMIT 1 OFFSET " . ($id - 1);
        } else {
            echo json_encode(['code' => 400, 'message' => '无效的参数']);
            exit;
        }
    } 
    // 处理 ?json&quantity=x 的情况，返回 x 行随机数据
    elseif (isset($_GET['quantity']) && is_numeric($_GET['quantity'])) {
        $quantity = intval($_GET['quantity']);
        if ($quantity > 0) {
            $sql = "SELECT link FROM aimp ORDER BY RAND() LIMIT " . $quantity;
        } else {
            echo json_encode(['code' => 400, 'message' => '无效的数量']);
            exit;
        }
    } 
    // 处理 ?json 没有 quantity 的情况，返回一行随机数据
    else {
        $sql = "SELECT link FROM aimp ORDER BY RAND() LIMIT 1";
    }
} else {
    // 没有 json 参数的情况，返回一行随机数据
    $sql = "SELECT link FROM aimp ORDER BY RAND() LIMIT 1";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $links = [];
    while ($row = $result->fetch_assoc()) {
        $links[] = $row["link"];
    }
} else {
    echo "0 结果";
    $conn->close();
    exit;
}

$conn->close();

// 检测是否为 json 输出
if (isset($_GET['json'])) {
    // 返回只包含链接的文本，每行一个链接
    header('Content-Type: text/plain');
    foreach ($links as $randomLink) {
        echo $randomLink . "\n";
    }
} else {
    // 没有 json 参数时，进行重定向
    header("Location: " . $links[0]);
    exit;
}
?>
