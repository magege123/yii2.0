var user_index_ops = {
    init:function() {
        this.eventBind();
    },

    eventBind:function(){
        var _this = this;
        $(".search").click(function () {
            $("form").submit();
        })

        $(".remove").click(function () {
            var uid  = $(this).attr('data');
            _this.ops('remove',uid);
        });

        $(".recover").click(function () {
            var uid  = $(this).attr('data');
            _this.ops('recover',uid);
        });
    },

    ops:function (act,uid) {
        callback = {
            'ok':function () {
                $.ajax({
                 url:common_ops.buildWebUrl('/account/ops'),
                 type:'POST',
                 data:{
                 act:act,
                 uid:uid
                 },
                 dataType:'json',
                 success:function (res) {
                     cb = null;
                     if(res.code == 200){
                         cb = function () {
                            window.location.href =  window.location.href;
                         }
                     }
                     common_ops.alert(res.msg,cb);
                     }
                 });
            },
            'cancel':function () {

            }
        };
        common_ops.confirm((act == "remove")?"您确定删除吗?":"您确定恢复吗?",callback);
    }
};

$(function () {
    user_index_ops.init();
})
