;
var member_set_ops = {
    init:function () {
        this.eventBind();
    },

    eventBind:function () {
        $('.wrap_member_set .save').click(function () {
            var btn_target = $(this);
            if(btn_target.hasClass('disabled')){
                common_ops.alert('正在处理，请不要重复提交~~');
            }

            var nickname_target = $(".wrap_member_set input[name=nickname]");
            var nickname = nickname_target.val();

            var mobile_target = $(".wrap_member_set input[name=mobile]");
            var mobile = mobile_target.val();

            var id = $(".wrap_member_set input[name=id]").val();

            if(nickname.length < 1){
                common_ops.tip('请输入正确的会员名~~',nickname_target);
                return;
            }

            if(mobile.length < 1){
                common_ops.tip('请输入正确的手机号码~~',mobile_target);
                return;
            }

            btn_target.addClass('disabled');

            $.ajax({
                url:common_ops.buildWebUrl('/member/set'),
                data:{
                    id:id,
                    nickname:nickname,
                    mobile:mobile
                },
                type:'POST',
                dataType:'json',
                success:function (res) {
                    btn_target.removeClass('disabled');
                    var cb = null;
                    if(res.code == 200){
                        cb = function () {
                            window.location.href = common_ops.buildWebUrl("/member/index");
                        }
                    }
                    common_ops.alert(res.msg,cb);
                }
            });
        });
    }
};

$(function () {
    member_set_ops.init();
});
