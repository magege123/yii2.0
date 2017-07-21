<?php use \app\common\services\UrlService;?>

<div class="row">
    <div class="col-lg-12">
        <span class="pagination_count" style="line-height: 40px;">共<?=$page['count']; ?>条记录 | 每页<?=$page['page_size']; ?>条</span>
        <ul class="pagination pagination-lg pull-right" style="margin: 0 0 ;">
            <?php for($i=1;$i<=$page['pages'];$i++):?>
                <?php if($i==$page['p']):?>
                    <li class="active">
                        <a href="<?=UrlService::buildNullUrl()?>"><?=$i; ?></a>
                    </li>
                <?php else:?>
                    <li>
                        <a href="<?=UrlService::buildWebUrl($url,['p'=>$i])?>"><?=$i; ?></a>
                    </li>
                <?php endif;?>
            <?php endfor;?>
        </ul>
    </div>
</div>
