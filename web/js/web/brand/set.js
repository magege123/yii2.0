;
var brand_set_ops = {
    init:function () {
        this.eventBind();
    },

    eventBind:function () {
        $(".wrap_brand_set .save").click(function () {
            var btn_target = $(this);
            if(btn_target.hasClass("disabled")){
                common_ops.alert("正在处理,请不要重复提交~~");
            }

            var name_target = $(".wrap_brand_set input[name=name]");
            var name = name_target.val();

            var mobile_target = $(".wrap_brand_set input[name=mobile]");
            var mobile = mobile_target.val();

            var address_target = $(".wrap_brand_set input[name=address]");
            var address = address_target.val();

            var description_target = $(".wrap_brand_set textarea[name=description]");
            var description = description_target.val();

            if(name.length < 1){
                common_ops.tip("请输入合法的品牌名称~~",name_target);
                return;
            }

            if(mobile.length < 1){
                common_ops.tip("请输入合法的电话号码~~",mobile_target);
                return;
            }

            if(address.length < 1){
                common_ops.tip("请输入合法的地址~~",address_target);
                return;
            }

            if(description.length < 1){
                common_ops.tip("请输入合法的品牌介绍~~",description_target);
                return;
            }

            btn_target.addClass('disabled');

            var data = {
                name:name,
                mobile:mobile,
                address:address,
                description:description
            };

            $.ajax({
                url:common_ops.buildWebUrl('/brand/set'),
                type:'POST',
                data:data,
                dataType:'json',
                success:function (res) {
                    btn_target.removeClass('disabled');
                    var cb = null;
                    if(res.code == 200){
                        cb = function () {
                            window.location.href = common_ops.buildWebUrl('/brand/info');
                        }
                    }
                    common_ops.alert(res.msg,cb);
                }
            });
        });
    }
};

$(function () {
    brand_set_ops.init();
})
