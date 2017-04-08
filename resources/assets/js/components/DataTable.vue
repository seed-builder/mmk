<template>
  <table :id="table.table_id"  class="table table-bordered table-hover">
    <thead>
    <tr>
      <th v-for="column_name in table.column_names">{{ column_name }}</th>
    </tr>
    </thead>
  </table>

</template>

<script>

  export default {

      props: ['table'],
      mounted() {
          $("#" + this.table.table_id).DataTable({
              dom: "lBfrtip",
              language: this.table.language,
              processing: true,
              serverSide: true,
              select: true,
              paging: true,
              rowId: "id",
              ajax: this.table.ajax,
              columns: this.table.columns,
              buttons: this.table.buttons,
              columnDefs: this.table.columnDefs!==undefined?this.table.columnDefs:[]
          });
      },
      data() {
          return {

          }
      },

  }
</script>
