<template>
  <div>
    <Panel ref="panelList" title="Tabla de torres">
      <b-container>
        <b-form-group
          class="col-md-6"
          label="Conjunto"
          label-cols-md="3"
          label-for="complexes-list"
        >
          <v-select
            label="name"
            :options="complexes"
            :placeholder="'Digite nombre de conjunto'"
            id="complexes-list"
            :clear-search-on-select="true"
            :filterable="false"
            @input="selectComplex"
            @search="searchComplex"
          ></v-select>
        </b-form-group>
        <div class="table-responsive">
          <vue-good-table
            mode="remote"
            v-if="selectedComplex"
            :rows="towers"
            :columns="columns"
            :sort-options="sort"
            :pagination-options="pagination_options"
            :total-rows="totalRecords"
            style-class="table table-bordered m-b-0"
            @on-page-change="onPageChange"
            @on-per-page-change="onPerPageChange"
          >
            <template slot="table-row" slot-scope="props">
              <span v-if="props.column.field == 'actions'">
                <span>
                  <div class="text-center">
                    <a class="btn btn-grey" @click="selectTower(props.row)">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a
                      class="btn btn-danger"
                      @click="confirmDelete(props.row.id)"
                    >
                      <i class="fas fa-trash-alt"></i>
                    </a>
                  </div>
                </span>
              </span>
              <span v-else>
                {{ props.formattedRow[props.column.field] }}
              </span>
            </template>
          </vue-good-table>
        </div>
      </b-container>
    </Panel>
  </div>
</template>

<script>
let searchTimer = null;
export default {
  data() {
    return {
      page: 1,
      perPage: 10,
      totalRecords: 0,
      complexes: [],
      towers: [],
      columns: [
        {
          label: "Nombre",
          field: "name",
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
      selectedComplex: null,
    };
  },
  methods: {
    confirmDelete(tower_id) {
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
            url: "/api/towers/" + tower_id,
          })
            .then(() => {
              loader.hide();
              this.$swal({
                title: "Eliminado!",
                icon: "success",
              }).then(() => {
                this.towers = this.towers.filter((tower) => {
                  return tower.id !== tower_id;
                });
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
    loadComplexes() {
      this.$http({
        method: "GET",
        url: "/api/complexes",
      }).then((response) => {
        this.complexes = response.data.data;
      });
    },
    loadTowers() {
      if (this.selectedComplex) {
        this.$http({
          method: "GET",
          url: "/api/complexes/" + this.selectedComplex + "/towers",
        }).then((response) => {
          this.towers = response.data.data;
        });
      }
    },
    selectTower(tower) {
      this.$emit("selectTower", tower);
    },
    onPageChange(params) {
      this.page = params.currentPage;
      this.loadTowers();
    },
    onPerPageChange(params) {
      this.perPage = params.currentPerPage;
      this.loadTowers();
    },
    selectComplex(complex) {
      this.selectedComplex = complex.id;
      this.loadTowers();
    },
    searchComplex(value, loading) {
      loading(true);
      clearTimeout(searchTimer);
      searchTimer = setTimeout(() => {
        this.$http({
          url: "/api/complexes",
          method: "GET",
          params: {
            ...(value
              ? {
                  query: "name|like|" + value,
                }
              : null),
          },
        })
          .then((response) => {
            this.complexes = response.data.data;
            loading(false);
          })
          .catch(() => {
            this.$swal({
              icon: "error",
              title: "Error!",
            });
          });
      }, 300);
    },
  },
};
</script>

<style></style>
