/**
 *    根据当前url选中菜单
 *    设置导航栏
 **/
$(".treeview-menu").each(function (i, obj) {
    var cur_url = $("#cur_url").val();//当前页url

    $(obj).find("a").each(function (j, a) {
        var node_url = $(a).attr("href");//菜单url

        if (node_url == cur_url) {
            //$(this).parent().addClass("active")
            setActive($(this));
            var node = $(obj).prev();
            var node_i = $(node).find("i").prop("outerHTML");
            var node_span = $(node).find("span").prop("outerHTML");
            var node_text = $(node).find("span").text();
            var title = "<h1>" + node_text + " <small>" + $(this).text() + "</small></h1><ol class=\"breadcrumb\"><li>" + node_i + "  " + node_span + "</li><li>" + $(this).text() + "</li></ol>"

            $(".content-header").html(title);
        }
    })
});

function setActive(el) {
    var p = el.parent();
    var tag = p.get(0).tagName;
    // console.log(tag);
    if (tag.toLowerCase() == 'section')
        return;

    el.parent().addClass("active");
    setActive(el.parent());
}

/*
 *  modal
 */
$('body').on('hidden.bs.modal', '.modal:not(.modal-cached)', function () {
    $(this).removeData('bs.modal');
});
$('body').on("show.bs.modal", ".modal", function () {
    $(this).find(".modal-dialog").draggable({
        handle: ".modal-header"
    });
    //$(this).css("overflow", "hidden");
});


/*
 * 根据审核状态判断是否可编辑
 */
function checkEditEnabble(table, enableButtonClass, disableButtonClass) {
    var count = table.rows({selected: true}).count();
    var row = table.rows('.selected').data()[0];
    if (count > 0) {
        if (row.fdocument_status == "A") {
            table.buttons(enableButtonClass).enable(true);
            table.buttons(disableButtonClass).enable(false);
        } else {
            table.buttons(enableButtonClass).enable(false);
            table.buttons(disableButtonClass).enable(true);
        }
    }
}

/*
 * 获取审核状态
 */
function document_status(status) {
    if (status == "A") {
        return '未审核';
    } else if (status == "B") {
        return '审核中';
    } else if (status == "C") {
        return '已审核';
    } else if (status == "D") {
        return '重新审核';
    } else {
        return '状态异常';
    }
}

/*
 * 获取禁用状态
 */
function forbid_status(status) {
    if (status == "A") {
        return '启用';
    } else if (status == "B") {
        return '禁用';
    } else {
        return '状态异常';
    }
}

//A-待接单，B-已接单，C-已配送, D-部分配送
function send_status(status) {
    var txt = '';
    switch (status) {
        case 'A':
            txt = '待接单';
            break;
        case 'B':
            txt = '已接单';
            break;
        case 'C':
            txt = '已配送';
            break;
        case 'D':
            txt = '部分配送';
            break;
        default:
            txt = '状态异常';
            break;
    }
    return txt;
}

/*
 * 数据审核 反审核
 */
function dataCheck(table, baseurl, extraFun) {
    var row = table.rows('.selected').data();

    var ids = new Array();
    for (var i = 0; i < row.length; i++) {
        ids.push(row[i].id);
    }

    var url = baseurl + "?ids=" + ids;

    ajaxLink(url, function () {
        table.ajax.reload();
        if (extraFun !== undefined) {
            extraFun();
        }
    });
}

/*
 * ajaxLink
 */
function ajaxLink(url, callback) {
    // load the form via ajax
    $.ajax({
        type: 'GET',
        data: {},
        //async: true,
        cache: false,
        url: url,
        dataType: "json",
        timeout: 10000,
        success: function (res) {
            layer.msg(res.result);
            if (res.redirect_url) {
                window.location.href = res.redirect_url;
            }

            if (callback !== undefined) {
                callback();
            }
        },

        error: function (jqXHR, textStatus, errorThrown) {
            layer.msg(jqXHR.responseText);
        },

    });

}

/*
 *  ajax submit form
 */
function ajaxForm(form_id, callback) {
    // load the form via ajax
    $.ajax({
        type: 'POST',
        data: $(form_id).serialize(),
        //async: true,
        cache: false,
        url: $(form_id).attr('action'),
        dataType: "json",
        timeout: 10000,
        success: function (res) {
            layer.msg(res.result);
            if (res.redirect_url) {
                window.location.href = res.redirect_url;
            }

            if (callback !== undefined) {
                callback();
            }
        },

        error: function (jqXHR, textStatus, errorThrown) {
            layer.msg(jqXHR.responseText);
        },

    });

}

function ajaxFormWithFile(form_id, callback) {
    var fd = new FormData($(form_id)[0]);
    var data = $(form_id).serializeArray();
    $.each(data, function (key, input) {
        fd.append(input.name, input.value);
    });

    $.ajax({
        type: 'POST',
        data: fd,
        //async: true,
        cache: false,
        url: $(form_id).attr('action'),
        dataType: "json",
        timeout: 10000,
        processData: false,  // tell jQuery not to process the data
        contentType: false,   // tell jQuery not to set contentType
        success: function (res) {
            layer.msg(res.result);
            if (res.redirect_url) {
                window.location.href = res.redirect_url;
            }

            if (callback !== undefined) {
                callback();
            }
        },

        error: function (jqXHR, textStatus, errorThrown) {
            layer.msg(jqXHR.responseText);
        },

    });
}

/*
 *  ajaxGet
 */
function ajaxGetData(url, callback) {
    $.ajax({
        type: 'GET',
        data: {},
        //async: true,
        cache: false,
        url: url,
        dataType: "json",
        timeout: 10000,
        success: function (res) {
            if (callback !== undefined) {
                callback(res.data);
            }
            if (res.code == 200 && res.data != null) {
                return res.data
            }
        },

        error: function (jqXHR, textStatus, errorThrown) {
            layer.msg(jqXHR.responseText);
        },

    });
}

/*
 * ajaxPost
 */
function ajaxPost(url, params, callback) {
    params._token = $("meta[name='_token']").attr('content')
    $.ajax({
        type: 'POST',
        data: params,
        //async: true,
        cache: false,
        url: url,
        dataType: "json",
        success: function (res) {
            if (res.code == 200) {
                layer.msg('调换门店成功');
            }
            if (callback !== undefined) {
                callback();
            }
        },

        error: function (jqXHR, textStatus, errorThrown) {
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

var filter_params = {
    'tree': {},
    'filter': {}
}

var treeNodeSelect = function (treeId, table) {

    var treeNode = $('#' + treeId).treeview('getSelected');
    if (treeNode.length > 0) {
        filter_params['tree']['nodeid'] = treeNode[0].dataid;
        filter_params['tree']['type'] = $('#' + treeId).attr('tree-type');
    }
    // var form = table.parents('filter')

    table.settings()[0].ajax.data = filter_params;
    table.ajax.reload();


};
var treeNodeUnSelect = function (treeId, table) {
    filter_params['tree'] = {};
    table.settings()[0].ajax.data = filter_params;
    table.ajax.reload();

    $(".tree_conditions").remove();
}
/*
 * map
 */
var mapInit = function (map, params) {
    var location = params.location != null ? params.location : new BMap.Point()
    map.centerAndZoom(location, params['zoom']);


    var navigationControl = new BMap.NavigationControl({
        // 靠左上角位置
        anchor: BMAP_ANCHOR_TOP_LEFT,
        // LARGE类型
        type: BMAP_NAVIGATION_CONTROL_LARGE,
        // 启用显示定位
        enableGeolocation: true
    });

    map.addControl(navigationControl);
    var geolocationControl = new BMap.GeolocationControl();
    geolocationControl.addEventListener("locationSuccess", function (e) {
        // 定位成功事件
        var address = '';
        address += e.addressComponent.province;
        address += e.addressComponent.city;
        address += e.addressComponent.district;
        address += e.addressComponent.street;
        address += e.addressComponent.streetNumber;
    });
    geolocationControl.addEventListener("locationError", function (e) {
        // 定位失败事件
        alert(e.message);
    });
    map.addControl(geolocationControl);

    //缩略图
    var overView = new BMap.OverviewMapControl({isOpen: true, anchor: BMAP_ANCHOR_BOTTOM_RIGHT});
    map.addControl(overView);

    //地图 卫星图
    var mapType1 = new BMap.MapTypeControl({mapTypes: [BMAP_NORMAL_MAP, BMAP_HYBRID_MAP]});
    map.addControl(mapType1);

    //全景图
    map.addTileLayer(new BMap.PanoramaCoverageLayer());
    var stCtrl = new BMap.PanoramaControl(); //构造全景控件
    stCtrl.setOffset(new BMap.Size(20, 40));
    map.addControl(stCtrl);//添加全景控件

    var geolocation = new BMap.Geolocation();
    geolocation.getCurrentPosition(function (r) {
        if (this.getStatus() == BMAP_STATUS_SUCCESS) {
            map.panTo(r.point);
        }
        else {
            alert('获取地图失败' + this.getStatus());
        }
    }, {enableHighAccuracy: true})
}

function mapWindow(element, data, callback) {
    var content = "<h3>" + data.title + "</h3>";
    for (var i = 0; i < data.attrs.length; i++) {
        content += '<p>' + data.attrs[i].name + "：" + data.attrs[i].value + '</p>'
    }

    var infoWindow = new BMap.InfoWindow(content)  // 创建信息窗口对象

    element.addEventListener("click", function () {
        this.openInfoWindow(infoWindow);

        if (callback !== undefined) {
            callback();
        }
    });
}

/*
 * 区域联动
 */
var regionFun = function (parent_id, element, callback) {
    ajaxGetData("/admin/city/list?parent_id=" + parent_id, function (data) {
        var html = "";
        for (index in data) {
            html += '<option text="' + data[index].Name + '" value="' + data[index].id + '">' + data[index].Name + '</option>';
        }

        $(element).html(html)
        if (callback !== undefined) {
            callback();
        }
    })
}

/*
 * 数据
 */
var fempId = function (treeId, table) {
    var treeNode = $('#' + treeId).treeview('getSelected');
    var row = table.rows('.selected').data();

    var femp_id;

    if (treeNode[0] !== undefined || row.length > 0) {
        if (row.length > 0) {
            femp_id = row[0].femp_id
        } else if (treeNode[0].nodetype == "emp") {
            femp_id = treeNode[0].dataid
        } else {
            return "";
        }
    } else {
        return null;
    }

    return femp_id;
}

/*
 * 查询过滤器
 */
var filter = function (ele) {
    var filter = ele.parents(".filter");
    var tableId = $(filter).attr('filter-table')
    var table = $(tableId).dataTable({
        "retrieve": true
    });

    filter_params['filter'] = {};
    $(filter).find(".filter-condition").each(function (index, obj) {

        if ($(obj).attr('filter-name')) {
            filter_params['filter'][index] = {
                'name': $(obj).attr('filter-name'),
                'operator': $(obj).attr('filter-operator'),
                'value': $(obj).val(),
            }
        }
    })
    filter_params['distinct'] = $(filter).find(".distinct-condition").val();


    table.api().settings()[0].ajax.data = filter_params
    table.api().ajax.reload();
}

var filter_reset = function (ele) {
    var filter = ele.parents(".filter");
    var tableId = $(filter).attr('filter-table')
    var table = $(tableId).dataTable({
        "retrieve": true
    });

    filter_params['filter'] = {}

    // filter.reset()
    $(filter).find(".filter-condition").each(function (index, obj) {

        $(obj).val("")
    })
    $('.filter-select').selectpicker('refresh');

    table.api().settings()[0].ajax.data = filter_params
    table.api().ajax.reload();
}

$(".filter-submit").on('click', function () {
    filter($(this));
})

$(".filter-reset").on('click', function () {
    filter_reset($(this));

})

$(".filter-condition").keydown(function (event) {
    if (event.keyCode == 13) {
        //执行操作
        filter($(this));
    }
})

$(".filter-select").selectpicker();


$('.filter-date').datepicker({
    language: 'zh-CN',
    format: 'yyyy-mm-dd',
    clearBtn: true,
    autoclose: true,
});

function addOptions(select, options) {
    select.options.length = 0;
    for (var i = 0; i < options.length; i++) {
        var op = document.createElement("option");      // 新建OPTION (op)
        op.setAttribute("value", options[i].value);          // 设置OPTION的 VALUE
        op.appendChild(document.createTextNode(options[i].text)); // 设置OPTION的 TEXT
        select.appendChild(op);           // 为SELECT 新建一 OPTION(op)
    }
}


/*
 * layui
 */
layui.use(['form', 'layedit', 'laydate'], function () {

});

$(document).ready(function () {
    setInterval("message()", 5000);
});

/*
 * 导出excel
 */
function exportExcel(form_id, url) {
    var form = $(form_id)
    $.each(form.find('.form-control'), function (index, input) {
        var name = $(input).attr('filter-name')
        var operator = $(input).attr('filter-operator')

        if (name) {
            var input1 = '<input type="hidden" class="export_conditions" name="filter[' + index + '][name]" value="' + $(input).attr('filter-name') + '"/>'

            var input3 = '<input type="hidden" class="export_conditions" name="filter[' + index + '][value]" value="' + $(input).val() + '" />'
            form.append(input1)
            form.append(input3)
        }
        if (operator) {
            var input2 = '<input type="hidden" class="export_conditions" name="filter[' + index + '][operator]" value="' + $(input).attr('filter-operator') + '" />'
            form.append(input2)
        }

    })

    if ($('#tree').length > 1) {
        var treeNode = $('.treeview').treeview('getSelected');
        if (treeNode.length > 0) {
            var tree_condition = '<input type="hidden" class="export_conditions" name="tree[nodeid]" value="' + treeNode[0].dataid + '" />'
            form.append(tree_condition);
        }
    }


    form.attr('action', url)
    form.submit();
    form.attr('action', '')

    $(".export_conditions").remove();
}

var audioPlayed = false;
/*
 * 消息弹窗
 */
function message() {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-center",
        "preventDuplicates": false,
        "onclick": function () {
            // window.location.href=$("#notifications-url").val()
            $("#message_content").attr("href", "/admin/message-content/info/" + $("#last_unread_id").val())
            $("#message_content").trigger('click')
        },
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "100000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    // while (unread_count>0){

    // }

    $.get('/admin/message/unread', {}, function (data, status, xhr) {
        var last_unread_id = $("#last_unread_id").val();
        if (data.count > 0) {
            $("#message_count").velocity("fadeOut", {duration: 500})
                .velocity("fadeIn", {duration: 500});
            if (!audioPlayed) {
                document.getElementById('audioObj').play();
                audioPlayed = true;
            }
        } else {
            $("#message_count").text(0);
            $("#message_count").hide();
        }
        if (data.last_id > last_unread_id) {
            $("#last_unread_id").val(data.last_id);
            toastr.info('您收到一条新消息！')
            $("#message_count").text(data.count);


            // $("#message_count").velocity("fadeIn", { duration: 1500 })
            //     .velocity("fadeOut", { delay: 500, duration: 1500 });
        }
    }, 'json')
}


/*
 * 打印
 */
function printView(form_id, url, tree_id) {
    var form = $(form_id)
    $.each(form.find('.form-control'), function (index, input) {
        var name = $(input).attr('filter-name')
        var operator = $(input).attr('filter-operator')

        if (name) {
            var input1 = '<input type="hidden" class="print_conditions" name="filter[' + index + '][name]" value="' + $(input).attr('filter-name') + '"/>'

            var input3 = '<input type="hidden" class="print_conditions" name="filter[' + index + '][value]" value="' + $(input).val() + '" />'
            form.append(input1)
            form.append(input3)
        }
        if (operator) {
            var input2 = '<input type="hidden" class="print_conditions" name="filter[' + index + '][operator]" value="' + $(input).attr('filter-operator') + '" />'
            form.append(input2)
        }

    })
    if (tree_id != null) {
        var treeNode = $('.treeview').treeview('getSelected');
        if (treeNode.length > 0) {
            var tree_condition = '<input type="hidden" class="print_conditions" name="tree[nodeid]" value="' + treeNode[0].dataid + '" />'
            form.append(tree_condition);
        }
    }


    form.attr('action', url)
    form.submit();
    form.attr('action', '')

    $(".print_conditions").remove();
}