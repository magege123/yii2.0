;
var member_index_ops = {
    init:function () {
        this.eventBind();
    },

    eventBind:function () {
        $('.wrap_search .search').click(function () {
            $('.wrap_search').submit();
        });
    }
};

$(function () {
    member_index_ops.init();
})
