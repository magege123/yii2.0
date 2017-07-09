var user_edit_ops = {
    init:function () {
        this.eventBind();
    },
    eventBind:function () {
        $('.save').on('click',function () {
            var nickname = $("input[name=nickname]").val();
            var email = $("input[name=email]").val();
            var _this = $(this);
            if(_this.hasClass('disabled')){
                common_ops.alert('正在处理,请不要重复提交~~');
                return false;
            }

            if(nickname.length<1){
                common_ops.tip('请输入正确的用户名~~',$("input[name=nickname]"));
                return false;
            }

            if(email.length<1){
                common_ops.tip('请输入正确的邮箱~~',$("input[name=email]"));
                return false;
            }

            _this.addClass('disabled');

            $.ajax({
                url:common_ops.buildWebUrl("/user/edit"),
                type:'POST',
                data:{nickname:nickname,
                    email:email
                },
                success:function (res) {
                    _this.removeClass('disabled');
                    cb = null;
                    if(res.code == 200){
                        cb = function () {
                            window.location.href = window.location.href;
                        }
                    }
                    common_ops.alert(res.msg,cb);
                },
                dataType:'json'
            });
        })
    }
};

$(function () {
    user_edit_ops.init();
})