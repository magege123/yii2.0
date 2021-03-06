<?php
use app\common\services\UrlService;
use app\common\services\StaticService;
use app\common\services\ConstantService;
StaticService::loadAppJsFile('/js/web/account/index.js',['depends'=>app\assets\WebAsset::className()]);
?>
<?= Yii::$app->view->renderFile("@app/modules/web/views/common/tab_account.php",['current'=>'index'])?>
<div class="row">
    <div class="col-lg-12">
        <form class="form-inline wrap_search">
            <div class="row m-t p-w-m">
                <div class="form-group">
                    <select name="status" class="form-control inline">
                        <option value="<?=ConstantService::$status_default; ?>">请选择状态</option>
                        <?php foreach (ConstantService::$status_map as $key=>$value):?>
                        <option <?php if($key==$status):?> selected <?php endif;?> value="<?=$key?>"  ><?=$value?></option>
                        <?php endforeach;?>
                    </select>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="mix_kw" placeholder="请输入姓名或者手机号码" class="form-control" value="<?=$mix_kw; ?>">
                        <input type="hidden" name="p" value="1">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary search">
                                <i class="fa fa-search"></i>搜索
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="/web/account/set">
                        <i class="fa fa-plus"></i>账号
                    </a>
                </div>
            </div>
        </form>
<table class="table table-bordered m-t">
    <thead>
    <tr>
        <th>序号</th>
        <th>姓名</th>
        <th>手机</th>
        <th>邮箱</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($list as $value):?>
         <tr>
            <td><?=$value['uid']?></td>
            <td><?=$value['nickname']?></td>
            <td><?=$value['mobile']?></td>
            <td><?=$value['email']?></td>
            <td>
                <a href="<?=UrlService::buildWebUrl('/account/info',['id'=>$value['uid']])?>">
                    <i class="fa fa-eye fa-lg"></i>
                </a>
                <a class="m-l" href="<?=UrlService::buildWebUrl('/account/set',['id'=>$value['uid']])?>">
                    <i class="fa fa-edit fa-lg"></i>
                </a>
                <?php if($value['status']==0):?>
                <a class="m-l recover" href="javascript:void(0);" data="<?=$value['uid']?>">
                    <i class="fa fa-rotate-left fa-lg"></i>
                </a>
            <?php else:?>
                    <a class="m-l remove" href="javascript:void(0);" data="<?=$value['uid']?>">
                        <i class="fa fa-trash fa-lg"></i>
                    </a>
            <?php endif;?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
    <?=\Yii::$app->view->renderFile('@app/modules/web/views/common/pagnation.php',[
        'page'=>$page,
        'url'=>'/account/index'
    ])?>
</div>
</div>


