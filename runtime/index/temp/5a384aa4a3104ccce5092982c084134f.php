<?php /*a:1:{s:44:"E:\php\major\app\index\view\index\index.html";i:1687857502;}*/ ?>
<!--
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime : 2022-07-01 20:43:01
 * @FilePath     : \yiyanyun\app\index\view\index\index.html
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>易验云网络验证 - 专业版</title>
    <style>
        .welcome {
            width: 50%;
            margin: 10% auto 0;
            background-color: rgba(181, 255, 187, 0.479);
            padding: 5%;
            border-radius: 20px;
        }
        .welcome_ip {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="welcome">
        <h1 >欢迎使用易验云网络验证</h1>
        <p>https://yiyanyun.tk</p>
        <p>我想更改此页面内容？请到/app/index/view/index/index.html 文件中进行更改内容</p>    
    </div>
    <p class="welcome_ip">欢迎来自：<?php echo htmlentities($ip); ?> 的朋友</p>
</body>
</html>