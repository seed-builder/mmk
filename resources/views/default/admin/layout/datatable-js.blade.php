<script src="/assets/plugins/datatables/js/jquery.dataTables.js"></script>
<script src="/assets/plugins/datatables/js/dataTables.bootstrap.js"></script>
<script src="/assets/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Buttons/js/buttons.colVis.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Buttons/js/buttons.html5.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Buttons/js/buttons.print.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Buttons/js/buttons.flash.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Buttons/js/jszip.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Buttons/js/pdfmake.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Buttons/js/vfs_fonts.js"></script>
<script src="/assets/plugins/datatables/extensions/Select/js/dataTables.select.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Editor/js/dataTables.editor.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Editor/js/editor.bootstrap.min.js"></script>
{{--<script src="/assets/plugins/datatables/extensions/AutoFill/js/autoFill.bootstrap.min.js"></script>--}}
<script src="/assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatables/extensions/Responsive/js/responsive.bootstrap.js"></script>
<script src="/assets/plugins/jquery-datatables-checkboxes-1.1.3/js/dataTables.checkboxes.min.js"></script>
<script>
    $.fn.dataTable.ext.errMode = 'throw';
    $.extend( $.fn.dataTable.defaults, {
        responsive: true,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    } );
</script>