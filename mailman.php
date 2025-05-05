<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "POST 请求成功接收";
} else {
    echo "不是 POST 请求";
}