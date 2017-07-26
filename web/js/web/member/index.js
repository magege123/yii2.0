;
var member_index_ops = {
    init:function () {
        this.eventBind();
    },

    eventBind:function () {
        var that = this;
        $('.wrap_search .search').click(function () {
            $('.wrap_search').submit();
        });

        $('.row .remove').click(function () {
            var id = $(this).attr('data');
            that.ops('remove',id);
        });

        $('.row .recover').click(function () {
            var id = $(this).attr('data');
            that.ops('recover',id);
        });
    },

    ops:function (act,id) {
        var callback = {
            ok:function () {
            $.ajax({
                url:common_ops.buildWebUrl('/member/ops'),
                type:'POST',
                data:{
                    id:id,
                    act:act
                },
                dataType:'json',
                success:function (res) {
                    var cb = null;
                    if(res.code==200){
                        cb = function () {
                            window.location.href =  window.location.href;
                        }
                    }
                    common_ops.alert(res.msg,cb);
                }
            });
        },
            cancel:function () {

            }
        };
        common_ops.confirm((act=='remove')?'确定删除吗?':'确定取消吗?',callback);
    }
};

$(function () {
    member_index_ops.init();
})
