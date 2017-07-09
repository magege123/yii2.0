var user_reset_pwd_ops = {
  init:function () {
      this.eventBind();
  },

  eventBind:function () {
      $('#save').on('click',function () {
          var _this = $(this);
          var old_password = $('#old_password').val();
          var new_password = $('#new_password').val();

          if(_this.hasClass('disabled')){
              common_ops.alert('正在处理,请不要重复提交~~');
              return false;
          }

          if(old_password.length <　1){
              common_ops.tip('请输入正确的密码~~',$('#old_password'));
              return false;
          }

          if(new_password.length <　6){
              common_ops.tip('新密码不能少于6位~~',$('#new_password'));
              return false;
          }

          if(old_password == new_password){
              common_ops.tip('新密码与老密码重复了,请重新输入~~',$('#new_password'));
              return false;
          }

          _this.addClass('disabled');

          $.ajax({
              url:common_ops.buildWebUrl("/user/reset-pwd"),
              type:'POST',
              data:{
                  old_password:old_password,
                  new_password:new_password
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
    user_reset_pwd_ops.init();
})