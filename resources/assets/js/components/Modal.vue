<template>
    <div class="modal fade" tabindex="-1" role="dialog" :id="modal.modal_id">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" >{{modal.title}}</h4>
                </div>

                <div class="modal-body">
                    <div class="box-body">
                        <form class="form-horizontal" :id="modal.form_id" :action="modal.url" method="post" enctype="multipart/form-data">
                            <div class="form-group" v-for="field in modal.fields">
                                <label class="col-sm-3 control-label">{{field.label}}</label>
                                <div class="col-sm-9">
                                    <input :type="field.type" :name="field.name" class="form-control" :value="field.value"/>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" v-on:click="modal.submit">保存</button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    export default {
        props: ['modal'],
//        mounted() {
//            console.log('Component mounted.')
//        }
    }
</script>
