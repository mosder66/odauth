<?php
/*
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime : 2022-05-13 08:15:43
 * @FilePath     : \yiyanyun\app\common.php
 */

// 应用公共文件
use PHPMailer\PHPMailer\PHPMailer;

function post($url, $param)
{
    if (!is_array($param)) {
        return '参数必须为array';
        throw new Exception("参数必须为array");
    }
    $httph = curl_init($url);
    curl_setopt($httph, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($httph, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($httph, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($httph, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
    curl_setopt($httph, CURLOPT_POST, 1); //设置为POST方式 
    curl_setopt($httph, CURLOPT_POSTFIELDS, $param);
    curl_setopt($httph, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($httph, CURLOPT_HEADER, 1);
    $rst = curl_exec($httph);
    curl_close($httph);
    return $rst;
}

/**
 * 邮件发送
 * @param string $to_mail 目标邮箱
 * @param string $Content 邮件主体内容 支持Html标签
 * @param string $title 邮件标题 
 * @param string $user
 * @return bool true or false
 */
function mail_send($to_mail = '', $Content = '', $title = '', $user = '')
{
    $mail = new PHPMailer(); //实例化
    $mail->IsSMTP(); // 启用SMTP
    $mail->Host = config('web.smtp_host'); //SMTP服务器 以163邮箱为例子
    $mail->Port = config('smtp_port');  //邮件发送端口
    $mail->SMTPAuth   = true;  //启用SMTP认证
    $mail->CharSet  = "UTF-8"; //字符集
    $mail->Encoding = "base64"; //编码方式
    $mail->Username = config('web.smtp_user');  //你的邮箱
    $mail->Password = config('web.smtp_pass');  //你的密码
    $mail->Subject = "你好"; //邮件标题
    $mail->From = config('web.smtp_user');  //发件人地址
    $mail->FromName = "易验云";  //发件人姓名
    $address = $to_mail; //收件人email
    $mail->AddAddress($address, "Q"); //添加收件人（地址，昵称）
    $mail->IsHTML(true); //支持html格式内容
    $mail->AddEmbeddedImage("logo.jpg", "my-attach", "logo.jpg"); //设置邮件中的图片
    $mail->Body = '<div>
    <includetail>
        <div style="font:Verdana normal 14px;color:#000;">
            <div style="position:relative;">
                <style>
                    .title_bold {
                        font-family: PingFangSC-Medium, "STHeitiSC-Light", BlinkMacSystemFont, "Helvetica", "lucida Grande", "SCHeiti", "Microsoft YaHei";
                        font-weight: bold;
                    }

                    .mail_bg {
                        background-color: #F5F5F5;
                    }

                    .mail_cnt {
                        padding: 60px 0 160px;
                        max-width: 700px;
                        margin: auto;
                        color: #2b2b2b;
                        -webkit-font-smoothing: antialiased;
                    }

                    .mail_container {
                        background-color: #fff;
                        margin: auto;
                        max-width: 702px;
                        border-radius: 2px;
                    }

                    .eml_content {
                        padding: 0 50px 30px 50px;
                        font-family: "Helvetica Neue", "Arial", "PingFang SC", "Hiragino Sans GB", "STHeiti", "Microsoft YaHei", sans-serif;
                    }

                    .mail_header {
                        text-align: right;
                    }

                    .top_line_left {
                        width: 88%;
                        height: 3px;
                        background-color: #FF0000;
                        float: left;
                        margin-right: 1px;
                        border-top-left-radius: 2px;
                        display: inline-block;
                    }

                    .top_line_right {
                        width: 12%;
                        height: 3px;
                        background-color: #8470FF;
                        float: right;
                        border-top-right-radius: 2px;
                        margin-top: -3px;
                    }

                    .main_title {
                        font-size: 16px;
                        line-height: 24px;
                    }

                    .main_subtitle {
                        line-height: 28px;
                        font-size: 16px;
                        margin-bottom: 12px;
                    }

                    .item_level_1 {
                        margin-top: 60px;
                    }

                    .item_level_2 {
                        margin-top: 40px;
                    }

                    .level_1_title {
                        font-size: 16px;
                        line-height: 28px;
                    }

                    .level_2_title {
                        font-size: 14px;
                        line-height: 28px;
                        font-weight: 600;
                    }

                    .item_txt {
                        font-size: 14px;
                        line-height: 28px;
                    }

                    .mail_footer {
                        font-size: 12px;
                        line-height: 17px;
                        color: #bebebe;
                        margin-top: 60px;
                        letter-spacing: 1px;
                    }

                    .mail_logo {
                        /*这里修改LOGO*/
                        background-image: url("https://s1.ax1x.com/2022/04/05/qOY2Gt.png");
                        background-size: 34px 24px;
                        width: 34px;
                        height: 24px;
                        background-repeat: no-repeat;
                        display: inline-block;
                        margin: 27px 0 20px 0;
                        clear: left;
                    }

                    .img_position {
                        max-width: 100%;
                    }

                    .normalTxt {
                        font-size: 14px;
                        line-height: 24px;
                        margin-top: 10px;
                    }

                    @media (max-width: 768px) {
                        .top_line {
                            display: none;
                        }

                        .mail_bg {
                            background: #fff;
                        }

                        .mail_cnt {
                            padding-bottom: 0;
                            padding-top: 0;
                        }

                        .eml_content {
                            padding: 0 12px 50px;
                        }

                        .phoneFontSizeTitle {
                            font-size: 18px !important;
                        }

                        .phoneFontSizeContent {
                            font-size: 16px !important;
                            line-height: 28px !important;
                        }

                        .phoneFontSizeTitleLarge {
                            font-size: 20px !important;
                        }

                        .phoneFontSizeTips {
                            font-size: 14px !important;
                        }
                    }
                </style>

                <div class="qmbox">
                    <div class="mail_bg">
                        <div class="mail_cnt">
                            <div class="mail_container">
                                <div class="top_line">
                                    <div class="top_line_left"></div>
                                    <div class="top_line_right"></div>
                                </div>
                                <div class="eml_content">
                                    <div class="mail_header">
                                        <div class="mail_logo"></div>
                                    </div>
                                    <div class="">
                                        <p style="font-size: 16px;margin-top:20px;" class="phoneFontSizeTitle">
                                            尊敬的：收件者您好
                                        </p>

                                        <div style="margin-bottom: 40px;margin-top: 30px;overflow: hidden;">
                                            <div style="font-size: 16px;line-height: 28px;margin-bottom: 10px;" class="title_bold phoneFontSizeTitle">' . $title . '</div>
                                            <div style="font-size: 14px;line-height: 24px;" class="phoneFontSizeContent">· ' . $Content . '</div>
                                            <div style="display: inline-block;margin-top: 20px;margin-bottom: 20px;">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="mail_footer">
                                        易验云
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </includetail>
</div>
'; //邮件主体内容
    //发送
    return $mail->Send();
}
