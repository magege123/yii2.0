<?=Yii::$app->view->renderFile("@app/modules/web/views/common/tab_member.php",['current'=>'index']);?>
<?php
use \app\common\services\ConstantService;
use \app\common\services\UrlService;
?>
<div class="row m-t">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-b-md">
                    <a class="btn btn-outline btn-primary pull-right" href="/web/member/set?id=1">编辑</a>
                    <h2>会员信息</h2>
                </div>
            </div>
        </div>
    <div class="row">
            <div class="col-lg-2 text-center">
                <img class="img-circle" src="<?=UrlService::buildPicUrl('avatar',$data['avatar'])?>" width="100px" height="100px"/>
            </div>
            <div class="col-lg-9">
                <dl class="dl-horizontal">
                    <dt>姓名：</dt> <dd><?=$data['nickname']?></dd>
                    <dt>手机：</dt> <dd><?=$data['mobile']?></dd>
                    <dt>性别：</dt> <dd><?=ConstantService::$sex_map[$data['sex']]?></dd>
                </dl>
            </div>
        </div>
        <div class="row m-t">
            <div class="col-lg-12">
                <div class="panel blank-panel">
                    <div class="panel-heading">
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab-1" data-toggle="tab" aria-expanded="false">会员订单</a>
                                </li>
                                <li>
                                    <a href="#tab-2" data-toggle="tab" aria-expanded="true">会员评论</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-1">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>订单编号</th>
                                            <th>支付时间</th>
                                            <th>支付金额</th>
                                            <th>订单状态</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                               20170312194531                                            </td>
                                            <td>
                                                                                                2017-03-12 22:28                                                                                            </td>
                                            <td>
                                                135.00                                            </td>
                                            <td>
                                                已支付                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab-2">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>评论时间</th>
                                            <th>评分</th>
                                            <th>评论内容</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                           <td>2017-03-17 16:48:31</td>
                                           <td>8</td>
                                           <td>哈哈哈哈或哈哈</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

