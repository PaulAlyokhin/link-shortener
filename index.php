<?php
require_once('mysql.php');

function GenerateKey($length = 5) {
    $symbols = "abcdefghijklmnopqrstuvwxyz0123456789";

    if($length <= 0) $length = 5;
    else if($length > strlen($symbols)) $length = strlen($symbols);

    $key = str_split($symbols);
    $result = "";

    do {
        $el = rand(0, count($key));
        $result .= $key[$el];
    }
    while(strlen($result) !== $length);

    return $result;
}

$link = htmlspecialchars($_GET['url']);
if(!empty($_GET['url'])) {
    $select = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `short` WHERE `url` = '{$link}'")); // Наличие ссылки в таблице

    if($select) { // Есть в таблице
        $result = [
            'url'  => $select['url'],
            'key'  => $select['key'],
            'link' => 'http://' . $_SERVER['HTTP_HOST'] . '/' . $select['key'],
        ];
    }
    else { // Отсутствует в таблице
        $key = GenerateKey();

        mysqli_query($db, "INSERT INTO `short` (`url`, `key`) VALUES ('{$link}', '{$key}') ");
        $select = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM `short` WHERE `url` = '{$link}'"));
        $result = [
            'url'  => $select['url'],
            'key'  => $select['key'],
            'link' => 'http://' . $_SERVER['HTTP_HOST'] . '/' . $select['key'],
        ];
    }
    echo json_encode($result);
    exit();
}
?>

<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Link Shortener</title>
    </head>
    <body>
        <form method="POST" id="form" onsubmit="return FormSubmit();">
            <input type="text" id="url" required>
            <input type="submit" value="Перейти">
        </form>
        <p id="link"></p>
        <script src="script.js"></script>
    </body>
</html>