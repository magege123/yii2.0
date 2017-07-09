<!--引入统一布局文件-->
<?php
use app\assets\AppAsset;
use app\common\services\UrlService;
AppAsset::register($this);
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>编程浪子微信图书商城</title>
    <?php $this->head()?>
</head>
<body>
<?php $this->beginBody()?>
<div class="navbar navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-collapse collapse pull-left">
            <ul class="nav navbar-nav ">
                <li><a href="<?=UrlService::buildWwwUrl("/")?>">首页</a></li>
                <li><a target="_blank" href="http://www.54php.cn/">博客</a></li>
                <li><a href="<?=UrlService::buildWebUrl("/user/login")?>">管理后台</a></li>
            </ul>
        </div>
    </div>
</div>

<!--布局开始-->
<?=$content; ?>
<!--布局结束-->
<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>