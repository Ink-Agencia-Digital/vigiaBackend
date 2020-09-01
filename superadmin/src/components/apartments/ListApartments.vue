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
                        :clear-search-on-select="true"
                        :filterable="false"
                        @input="selectComplex"
                        @search="searchComplex"
                    ></v-select>
                </b-form-group>
                <div class="table-responsive">
                    <vue-good-table
                        v-if="selectedComplex"
                        mode="remote"
                        :rows="estates"
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
                                        <a
                                            class="btn btn-grey"
                                            @click="selectEstate(props.row)"
                                        >
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
                            <span v-else-if="props.column.field == 'building'">
                                <span v-if="props.row.building">
                                    {{ props.row.building.name }}
                                </span>
                                <span v-else>No registrado</span>
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
            buildings: [],
            estates: [],
            columns: [
                {
                    label: "Nombre",
                    field: "name"
                },
                {
                    label: "Torre/Interior",
                    field: "building"
                },
                {
                    label: "Acciones",
                    field: "actions"
                }
            ],
            sort: {
                enabled: false
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
                dropdownAllowAll: false
            },
            selectedComplex: null,
            company: {}
        };
    },
    methods: {
        confirmDelete(estate_id) {
            this.$swal({
                title: "Está seguro?",
                text: "Estos cambios no podran ser revertidos",
                type: "warning",
                showCancelButton: true
            }).then(response => {
                if (response.value) {
                    let loader = this.$loading.show();
                    this.$http({
                        method: "DELETE",
                        url: "/api/estates/" + estate_id
                    })
                        .then(() => {
                            this.$swal({
                                title: "Eliminado!",
                                type: "success"
                            }).then(() => {
                                this.$emit("resetUpdate");
                                this.loadEstates();
                                loader.hide();
                            });
                        })
                        .catch(error => {
                            this.$swal({
                                title: "Error!",
                                type: "error",
                                text: error.data.error
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
        loadEstates() {
            if (this.selectedComplex) {
                this.$http({
                    method: "GET",
                    url:
                        "/api/residentialcomplexes/" +
                        this.selectedComplex +
                        "/estates"
                }).then(response => {
                    this.estates = response.data.data;
                });
            }
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
            this.loadEstates();
        },
        searchComplex(value, loading) {
            loading(true);
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                this.$http({
                    url:
                        "/api/companies/" +
                        this.company.id +
                        "/residentialcomplexes?query=name|LIKE|" +
                        value,
                    method: "GET"
                })
                    .then(response => {
                        this.complexes = response.data.data;
                        loading(false);
                    })
                    .catch(() => {
                        this.$swal({
                            type: "error",
                            title: "Error!"
                        });
                    });
            }, 300);
        },
        selectEstate(estate) {
            this.$emit("selectEstate", estate);
        }
    },
    created() {
        this.company = this.$store.getters.authUser.company;
    }
};
</script>

<style></style>
