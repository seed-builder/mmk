<?php echo "@extends('admin.layout.collapsed-sidebar')"; ?>

<?php echo  "@section('styles')" ; ?>

    <?php echo  "@include('admin.layout.datatable-css')" ; ?>

<?php echo  "@endsection" ; ?>


<?php echo  "@section('content')" ; ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo e(isset($topModule) ? $topModule : 'top module'); ?>

            <small><?php echo e($table); ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"><?php echo e(isset($topModule) ? $topModule : 'top module'); ?></a></li>
            <li class="active"><?php echo e($table); ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo e($table); ?>列表</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table id="moduleTable" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                <?php $__empty_1 = true; $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); $__empty_1 = false; ?>
                <th><?php echo e($col->name); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); if ($__empty_1): ?>
                <?php endif; ?>
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
            seajs.use('admin/<?php echo e(snake_case($model)); ?>.js', function (app) {
                app.index($, 'moduleTable');
            });
        });
    </script>

<?php echo "@endsection"  ; ?>