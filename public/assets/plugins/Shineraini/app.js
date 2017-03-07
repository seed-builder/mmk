/**
 *	根据当前url选中菜单
 *	设置导航栏
 **/
$(".treeview-menu").each(function(i,obj){
    $(obj).find("a").each(function(j,a){
        var node_url = $(a).attr("href");//菜单url
        var cur_url = $("#cur_url").val();//当前页url

        if(node_url==cur_url){
            $(this).parent().addClass("active")
            var node = $(obj).prev();
            var node_i = $(node).find("i").prop("outerHTML");
            var node_span = $(node).find("span").prop("outerHTML");
            var node_text = $(node).find("span").text();
            var title = "<h1>"+node_text+" <small>"+$(this).text()+"</small></h1><ol class=\"breadcrumb\"><li>"+node_i+"  "+node_span+"</li><li>"+$(this).text()+"</li></ol>"

            $(".content-header").html(title);
        }
    })
})

/*
 *  modal
 */
$('body').on('hidden.bs.modal', '.modal:not(.modal-cached)', function () {
    $(this).removeData('bs.modal');
});
$('body').on("show.bs.modal", ".modal", function(){
    $(this).find(".modal-dialog").draggable();
    $(this).css("overflow", "hidden");
});


/*
 * 根据审核状态判断是否可编辑
 */
function checkEditEnabble(table,enableButtonClass,disableButtonClass) {
    var count = table.rows( { selected: true } ).count();
    var row = table.rows('.selected').data()[0];
    if (count>0){
        if (row.fdocument_status=="A"){
            table.buttons( enableButtonClass ).enable(true);
            table.buttons( disableButtonClass ).enable(false);
        }else {
            table.buttons( enableButtonClass ).enable(false);
            table.buttons( disableButtonClass ).enable(true);
        }
    }

}

/*
 * 获取审核状态
 */
function document_status(status) {
    if (status=="A"){
        return '未审核';
    }else if(status=="B"){
        return '审核中';
    }else if(status=="C"){
        return '已审核';
    }else if(status=="D"){
        return '重新审核';
    }else {
        return '状态异常';
    }
}

/*
 * 数据审核 反审核
 */
function dataCheck(table,baseurl,extraFun) {
    var row = table.rows('.selected').data();

    var ids = new Array();
    for (var i=0;i<row.length;i++){
        ids.push(row[i].id);
    }

    var url = baseurl+"?ids="+ids;

    ajaxLink(url,function () {
        table.ajax.reload();
        if(extraFun !== undefined ){
            extraFun();
        }
    });
}

/*
 * ajaxLink
 */
function ajaxLink(url,callback){
    // load the form via ajax
    $.ajax({
        type: 'GET',
        data: {},
        //async: true,
        cache: false,
        url: url,
        dataType: "json",
        timeout: 10000,
        success: function(res)
        {
            layer.msg(res.result);
            if (res.redirect_url){
                window.location.href = res.redirect_url;
            }

            if(callback !== undefined ){
                callback();
            }
        },

        error: function(jqXHR, textStatus, errorThrown)
        {
            layer.msg(jqXHR.responseText);
        },

    });

}

/*
 *  ajax submit form
 */
function ajaxForm(form_id,callback){
    // load the form via ajax
    $.ajax({
        type: 'POST',
        data: $(form_id).serialize(),
        //async: true,
        cache: false,
        url: $(form_id).attr('action'),
        dataType: "json",
        timeout: 10000,
        success: function(res)
        {
            layer.msg(res.result);
            if (res.redirect_url){
                window.location.href = res.redirect_url;
            }

            if(callback !== undefined ){
                callback();
            }
        },

        error: function(jqXHR, textStatus, errorThrown)
        {
            layer.msg(jqXHR.responseText);
        },

    });

}

/*
 *  ajaxGet
 */
function ajaxGetData(url,callback) {
    $.ajax({
        type: 'GET',
        data: {},
        //async: true,
        cache: false,
        url: url,
        dataType: "json",
        timeout: 10000,
        success: function(res)
        {
            if(callback !== undefined ){
                callback(res.data);
            }
            if(res.code==200&&res.data!=null){
                return res.data
            }
        },

        error: function(jqXHR, textStatus, errorThrown)
        {
            layer.msg(jqXHR.responseText);
        },

    });
}

/*
 * treeview
 */
$('#btnOpen').click(function () {
    var tree = $(this).parents('.box').find(".treeview");
    tree.treeview('expandAll');
});

$('#btnCollapse').click(function () {
    var tree = $(this).parents('.box').find(".treeview");
    tree.treeview('collapseAll');
});
