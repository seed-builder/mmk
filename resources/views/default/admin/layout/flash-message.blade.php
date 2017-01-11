<script type="text/javascript">
    $(function () {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        @if (Session::has('message'))
          toastr.warning("{{ Session::get('message') }}", {timeOut: 2000});
        @endif

        @if (Session::has('success'))
          toastr.success("{{ Session::get('success') }}", {timeOut: 2000});
        @endif

        @if (Session::has('error'))
          toastr.error("{{ Session::get('error') }}", {timeOut: 2000});
        @endif
    });
</script>