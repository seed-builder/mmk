(function ($, DataTable) {

    if ( ! DataTable.ext.editorFields ) {
        DataTable.ext.editorFields = {};
    }

    var Editor = DataTable.Editor;

    DataTable.ext.editorFields.laySelect = {
        create: function ( conf ) {
            var that = this;
            var id = Editor.safeId( conf.id );
            conf._enabled = true;
            conf._input = $(
                '<div class="btn-group bootstrap-select">'+
                '<select id="'+id+'" class="selectpicker" data-live-search="true"></select>'+
                '</div>'
            );
            addOptions($('#'+id, conf._input).get(0), conf.options);
            return conf._input;
        },
        get: function ( conf ) {
            var id = Editor.safeId( conf.id );
            return $('#'+id, conf._input).val();
        },
        set: function ( conf, val ) {
            var id = Editor.safeId( conf.id );
            //if(id && val)
            //   addOptions(document.getElementById(id), val);
        },
        enable: function ( conf ) {
            conf._enabled = true;
            $(conf._input).removeClass( 'disabled' );
        },
        disable: function ( conf ) {
            conf._enabled = false;
            $(conf._input).addClass( 'disabled' );
        }
    };

    function addOptions(select, options) {
        select.options.length=0;
        var html = [];
        for(var i=0; i < options.length; i++) {
            html[html.length] = '<option value="'+options[i].value+'" data-tokens="'+options[i].label+'">'+options[i].label+'</option>'
        }
        $(select).html(html.join(''));
    }

})(jQuery, jQuery.fn.dataTable);