<?php
echo PHP_EOL;
echo <<< EOT
    <style type="text/css">
        html,body,div,ul,li,p,hr,td,form,input,button{margin:0;padding:0;}
        html,body,img,iframe{border:0;}
        li{list-style:none;}
        q:before,q:after{content:none;}
        label{cursor:default;}
        a,button{cursor:pointer;}
        a,a:hover{text-decoration:none;}
        body,input,button{font:12px/1.14 arial;color:#333;outline:0;}
        a,a:hover{color:#333;}
        .install {
            width:700px;
            margin:8% auto 30px auto;
            color:#666;
        }
        .header {
            background-color: #ddd;
            font-size: 16px;
            padding: 10px;
            color: #000;
            font-weight: bold;
        }
        .main {
            min-height: 150px;
            line-height: 29px;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .formitm { padding-left:100px; }
		.step-1 {
            font-size: 14px;
            padding: 10px;
        }
        .installed {
            font-size: 14px;
            text-align: center;
        }
        .main .formitm { padding: 10px 0px;height: 30px; line-height: 30px; border-bottom: 1px solid #eee; }
        .main .formitm-1 { padding-left: 120px;height: 30px; }
        .main .formitm-2 { border-bottom:none;}
        .main .lab { float: left; width: 110px; margin-right: -90px; text-align: right; font-weight: bold; }
        .main .ipt { margin-left: 120px; }
        .main .ipt * { vertical-align: middle; }
        .main .ipt a, .main .ipt a:hover { text-decoration: none; color: #3891eb; }
        .main .ipt .suffix { margin: 0 0 0 5px; color: #777; }
        .main .ipt .suffix a { padding: 0px; }
        .main .ipt .u-btn { margin-top: -2px; *margin-top:0px;}
        .main .ipt p { line-height: 22px; color: #999; }
        .main .tip { padding-top: 10px; }
        .main .tip input { margin: 0 5px 3px 0; }
        .main .status { padding-left: 10px; color: #093 }
        .main .status-err { color: #F00 }
        .u-btn-sm { padding: 0 10px; height: 22px; line-height: 22px; }

        .u-ipt { width: 180px; padding: 5px; height: 17px; border: 1px solid #D9D9D9; border-top-color: #c0c0c0; line-height: 17px; font-size: 14px; color: #777; background: #fff; margin-right: 5px; vertical-align: middle; }
        .u-ipt-1 { width: 50px; }
        .u-ipt-2 { width: 100px; }
        .u-ipt-3 { width: 150px; }
        .u-ipt-4 { width: 200px; }
        .u-ipt-5 { width: 250px; }
        .u-ipt-6 { width: 300px; }
        .u-ipt-7 { width: 400px; }
        .u-tta { width: 180px; padding: 5px; height: 50px; border: 1px solid #D9D9D9; border-top-color: #c0c0c0; line-height: 17px; font-size: 14px; color: #777; background: #fff; vertical-align: middle; margin-right: 5px; }
        .u-tta-4 { width: 200px; height: 60px; }
        .u-tta-5 { width: 250px; height: 70px; }
        .u-tta-6 { width: 300px; height: 80px; }
        .u-ipt-7 { width: 400px; height: 100px; }
        .u-tta-err { border-color: #c00 #e00 #e00; }

        .install-button {
            margin: 10px auto;
            text-align:center;
        }
        .install-button .btn {
            background-color: #ddd;
            border: 0px;
            font-size: 14px;
            text-align: center;
            color: #00f;
            padding: 8px;
        }
        .install-button .btn:hover {
            background-color: #b59f9f;
        }
        .install-button .btn:active {
            background-color: #4c95e1;
        }
        .install .install-status { margin-left:auto; margin-right:auto; line-height:35px; font-size:12px; text-align:center; color:#F00}

        .footer {
            background-color: #ddd;
            padding: 10px;
            color: #333;
            overflow: hidden;
        }
        .footer .copy {
            float: right;
        }
        .footer .site {
            float: left;
        }
    </style>
EOT;
echo PHP_EOL;
