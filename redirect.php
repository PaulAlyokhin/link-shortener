<?php
require_once('mysql.php');

$key = htmlspecialchars($_GET['key']);

if(!empty($_GET['key'])) {
    $select = mysqli_fetch_assoc(mysqli_query($db, "SELECT `url` FROM `short` WHERE `key` = '{$key}'"));

    if($select) {
        $result = [
            'url' => $select['url'],
        ];

        header('location: ' . $result['url']);
    }
}