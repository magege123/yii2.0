;
var account_set_ops = {
    init:function () {
        this.eventBind();
    },

    eventBind:function () {
        $(".wrap_account_set .save").click(function () {
            var _this = $(this);
            if(_this.hasClass("disabled")){
                common_ops.alert("正在处理，请不要重复提交~~");
            }

            var nickname_target = $(".wrap_account_set input[name=nickname]");
            var nickname = nickname_target.val();

            var mobile_target = $(".wrap_account_set input[name=mobile]");
            var mobile = mobile_target.val();

            var email_target = $(".wrap_account_set input[name=email]");
            var email = email_target.val();

            var login_name_target = $(".wrap_account_set input[name=login_name]");
            var login_name = login_name_target.val();

            var login_pwd_target = $(".wrap_account_set input[name=login_pwd]");
            var login_pwd = login_pwd_target.val();

            var id = $(".wrap_account_set input[name=id]").val();

            var data = {
                id:id,
                nickname:nickname,
                mobile:mobile,
                email:email,
                login_name:login_name,
                login_pwd:login_pwd,
            };

            if(nickname.length<1){
                common_ops.tip("请输入正确的用户名~~",nickname_target);
                return;
            }

            if(mobile.length<1){
                common_ops.tip("请输入正确的手机号~~",mobile_target);
                return;
            }

            if(email.length<1){
                common_ops.tip("请输入正确的邮箱~~",email_target);
                return;
            }

            if(login_name.length<1){
                common_ops.tip("请输入正确的登录名~~",login_name_target);
                return;
            }

            if(login_pwd.length<1){
                common_ops.tip("请输入正确的密码~~",login_pwd_target);
                return;
            }

            _this.addClass("disabled");

            $.ajax({
                url:common_ops.buildWebUrl("/account/set"),
                type:'POST',
                data:data,
                dataType:'json',
                success:function (res) {
                    _this.removeClass("disabled");
                    var cb = null;
                    if(res.code == 200){
                        cb = function () {
                            window.location.href = common_ops.buildWebUrl("/account/index");
                        }
                    }
                    common_ops.alert(res.msg,cb);
                }
            });
        });
    }
};

$(function () {
    account_set_ops.init();
})