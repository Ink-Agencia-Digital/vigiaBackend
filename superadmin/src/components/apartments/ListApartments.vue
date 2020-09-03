<template>
  <div>
    <Panel ref="panelList" title="Tabla de apartamentos/casas">
      <b-container>
        <b-form-group
          class="col-md-6"
          label="Conjunto"
          label-cols-md="3"
          label-for="complexes-list"
        >
          <v-select
            id="complexes-list"
            label="name"
            :options="complexes"
            :placeholder="'Digite nombre de conjunto'"
            :clear-search-on-select="false"
            :filterable="false"
            @input="selectComplex"
            @search="searchComplex"
          ></v-select>
        </b-form-group>
        <b-form-group
          v-if="selectedComplex"
          class="col-md-6"
          label="Torre"
          label-cols-md="3"
          label-for="towers-register"
        >
          <v-select
            label="name"
            :options="towers"
            :placeholder="'Digite nombre de la torre'"
            id="towers-list"
            :clear-search-on-select="false"
            :filterable="false"
            @input="selectTower"
            @search="searchTower"
          ></v-select>
        </b-form-group>
        <div class="table-responsive">
          <vue-good-table
            v-if="selectedTower"
            mode="remote"
            :rows="apartments"
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
                    <a class="btn btn-grey" @click="selectApartment(props.row)">
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
      apartments: [],
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
      selectedTower: null,
    };
  },
  methods: {
    confirmDelete(apartment_id) {
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
            url: "/api/apartments/" + apartment_id,
          })
            .then(() => {
              loader.hide();

              this.$swal({
                title: "Eliminado!",
                icon: "success",
              }).then(() => {
                this.$emit("resetUpdate");
                this.apartments = this.apartments.filter((apartment) => {
                  return apartment.id !== apartment_id;
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
    resetUpdate() {
      this.$emit("resetUpdate");
    },
    loadApartments() {
      if (this.selectedTower) {
        this.$http({
          method: "GET",
          url: "/api/towers/" + this.selectedComplex + "/apartments",
          params: {
            per_page: this.perPage,
            page: this.page,
          },
        }).then((response) => {
          this.apartments = response.data.data;
        });
      }
    },
    selectApartment(apartment) {
      this.$emit("selectApartment", apartment);
    },
    onPageChange(params) {
      this.page = params.currentPage;
      this.loadBuildings();
    },
    onPerPageChange(params) {
      this.perPage = params.currentPerPage;
      this.loadBuildings();
    },
    selectComplex(complex) {
      this.selectedComplex = complex.id;
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
    selectTower(tower) {
      this.selectedTower = tower.id;
      this.loadApartments();
    },
    searchTower(value, loading) {
      loading(true);
      clearTimeout(searchTimer);
      searchTimer = setTimeout(() => {
        this.$http({
          url: "/api/complexes/" + this.selectedComplex + "/towers",
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
            this.towers = response.data.data;
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
