;
var upload = {
    success:function (img_key) {
        var html = '<img src="'+common_ops.buildPicUrl('brand',img_key)+'"><span class="fa fa-times-circle del del_image" data="'+img_key+'"><i></i>';
        if($('.upload_pic_wrap .pic-each').size()>0){
            $('.upload_pic_wrap .pic-each').html(html);
        }else{
            $('.upload_pic_wrap').append('<span class="pic-each">'+html+'</span>');
        }

        brand_image_ops.del_img();
    },

    error:function (msg) {
        common_ops.alert(msg);
    }
};

var brand_image_ops = {
    init:function () {
        this.eventBind();
        this.del_img();
    },

    eventBind:function () {
        $(".set_pic").click(function () {
            $('#brand_image_wrap').modal('show');
        });

        $("#brand_image_wrap .upload_pic_wrap input[name=pic]").change(function () {
            $("#brand_image_wrap .upload_pic_wrap").submit();
        });
        
        $('#brand_image_wrap .save').click(function () {
            var btn_target = $(this);
            if(btn_target.hasClass('disabled')){
                common_ops.alert('正在处理请不要重复提交~~');
                return;
            }

            if($('.upload_pic_wrap .pic-each').size()<1){
                common_ops.alert('请选择上传图片~~');
                return;
            }

            btn_target.addClass('disabled');

            var img_key = $('#brand_image_wrap .upload_pic_wrap .del_image').attr('data');
            $.ajax({
                url:common_ops.buildWebUrl('/brand/set-image'),
                type:'POST',
                dataType:'json',
                data:{img_key:img_key},
                success:function (res) {
                    btn_target.removeClass('disabled');
                    var cb = null;
                    if(res.code == 200){
                        cb = function () {
                            window.location.href = window.location.href;
                        }
                    }
                    common_ops.alert(res.msg,cb);
                }
            });
        });

        $('.remove').click(function () {
            var id = $(this).attr('data');
            var callback = {
                'ok':function () {
                    $.ajax({
                        url:common_ops.buildWebUrl('/brand/image-ops'),
                        type:'POST',
                        dataType:'json',
                        data:{id:id},
                        success:function (res) {
                            var cb = null;
                            if(res.code == 200){
                                cb = function () {
                                    window.location.href = window.location.href;
                                }
                            }
                            common_ops.alert(res.msg,cb);
                        }
                    });
                },
                'cancel':null
            };
            common_ops.confirm('确定删除吗？~~',callback);
        });
    },
    
    del_img:function () {
        /*$(document).on('click','.del_image',function () {
            $(this).parent().remove();
        })*/
        $('.upload_pic_wrap .del_image').unbind().click(function(){
            $(this).parent().remove();
        });
    }
};

$(function () {
    brand_image_ops.init();
})
