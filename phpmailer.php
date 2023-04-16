<?php
// 导入PHPMailer库
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 引入PHPMailer库的自动加载器
require 'vendor/autoload.php';

// 创建PHPMailer对象
$mail = new PHPMailer(true);

// 输出PHPMailer版本号，如果输出了版本号，则说明PHPMailer已成功安装
echo 'PHPMailer版本号：' . PHPMailer::VERSION;
?>
