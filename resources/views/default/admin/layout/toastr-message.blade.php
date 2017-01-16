<script type="text/javascript">
    $(function () {
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