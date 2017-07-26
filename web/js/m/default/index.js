;
//轮播效果展示
$(function () {
    TouchSlide({
        slideCell:"#slideBox",
        titCell:'.hd ul',
        mainCell:'.bd ul',
        effect:"leftLoop",
        autoPage:true,
        autoPlay:true
    });
})
