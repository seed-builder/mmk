<?php echo "@extends('admin.layout.collapsed-sidebar')"; ?>

<?php echo  "@section('styles')" ; ?>

    <?php echo  "@include('admin.layout.datatable-css')" ; ?>

<?php echo  "@endsection" ; ?>


<?php echo  "@section('content')" ; ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{$topModule or 'top module'}}
            <small>{{$table}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">{{$topModule or 'top module'}}</a></li>
            <li class="active">{{$table}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{$table}}列表</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                @forelse($columns as $col)
                <th>{{$col->name}}</th>
                @empty
                @endforelse
            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

<?php echo "@endsection"  ; ?>

<?php echo "@section('js')"  ; ?>

    <?php echo "@include('admin.layout.datatable-js')"  ; ?>

    <script type="text/javascript">
        $(function () {
            seajs.use('admin/{{snake_case($model)}}.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

<?php echo "@endsection"  ; ?>