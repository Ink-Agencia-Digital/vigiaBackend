<template>
  <Panel ref="panelList" title="Tabla de conjuntos">
    <b-container>
      <div class="table-responsive">
        <vue-good-table
          mode="remote"
          :rows="complexes"
          :columns="columns"
          :sort-options="sort"
          :pagination-options="pagination_options"
          :totalRows="totalRecords"
          @on-page-change="onPageChange"
          @on-per-page-change="onPerPageChange"
          styleClass="table table-bordered m-b-0"
        >
          <div slot="emptystate">No hay informacion disponible</div>
          <template slot="table-row" slot-scope="props">
            <span v-if="props.column.field == 'created_at'">
              <span>{{ props.row.created_at | formatDate }}</span>
            </span>
            <span v-else-if="props.column.field == 'actions'">
              <span>
                <div class="text-center">
                  <a class="btn btn-grey" @click="selectComplex(props.row)">
                    <i class="fas fa-edit fa-fw"></i>
                  </a>
                  <a
                    class="btn btn-danger"
                    @click="confirmDelete(props.row.id)"
                  >
                    <i class="fas fa-trash-alt fa-fw"></i>
                  </a>
                </div>
              </span>
            </span>

            <span v-else>{{ props.formattedRow[props.column.field] }}</span>
          </template>
        </vue-good-table>
      </div>
    </b-container>
  </Panel>
</template>

<script>
export default {
  data() {
    return {
      page: 1,
      perPage: 10,
      totalRecords: 0,
      complexes: [],
      columns: [
        {
          label: "ID",
          field: "id",
        },
        {
          label: "Nombre",
          field: "name",
        },
        {
          label: "Direccion",
          field: "address",
        },
        {
          label: "Creacion",
          field: "created_at",
        },
        {
          label: "Acciones",
          field: "actions",
        },
      ],
      sort: {
        enabled: false,
      },
      pagination_options: {
        enabled: true,
        mode: "records",
        nextLabel: "Sig",
        prevLabel: "Ant",
        rowsPerPageLabel: "Registros por pagina",
        ofLabel: "de",
        pageLabel: "Pagina", // for 'pages' mode
        allLabel: "Todos",
        perPageDropdown: [10, 30, 50],
        dropdownAllowAll: false,
      },
      selectedPhoto: null,
      isOpen: "none",
    };
  },
  methods: {
    confirmDelete(id) {
      this.$swal({
        title: "Está seguro?",
        text: "Estos cambios no podran ser revertidos",
        icon: "warning",
        showCancelButton: true,
      }).then((response) => {
        if (response.value) {
          let loader = this.$loading.show();
          this.$http({
            method: "DELETE",
            url: "/api/complexes/" + id,
          })
            .then(() => {
              this.$swal({
                title: "Hecho!",
                icon: "success",
              }).then(() => {
                this.loadComplexes();
                loader.hide();
              });
            })
            .catch((error) => {
              this.$swal({
                title: "Error!",
                icon: "error",
                text: error.data.error,
              }).then(() => {
                loader.hide();
              });
            });
        }
      });
    },
    selectComplex(complex) {
      this.$emit("selectComplex", complex);
    },
    loadComplexes() {
      let loader = this.$loading.show();
      this.$http({
        method: "GET",
        url: "/api/complexes",
        params: {
          per_page: this.perPage,
          page: +this.page,
        },
      })
        .then((response) => {
          this.complexes = response.data.data;
          this.totalRecords = response.data.meta.total;
          loader.hide();
        })
        .catch(() => {
          loader.hide();
          this.$swal({
            title: "Error",
            text: "Error cargando los datos",
            icon: "error",
          });
        });
    },
    onPageChange(params) {
      this.page = params.currentPage;
      this.loadComplexes();
    },
    onPerPageChange(params) {
      this.perPage = params.currentPerPage;
      this.loadComplexes();
    },
  },
  created() {
    this.loadComplexes();
  },
  filters: {
    formatDate(value) {
      /*global moment*/
      /*eslint no-undef: "error"*/
      return moment(value).format("LL");
    },
  },
};
</script>
<style scoped></style>
