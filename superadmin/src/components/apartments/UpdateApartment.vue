<template>
    <div>
        <Panel title="Actualizar casa">
            <b-container>
                <legend>Información de la casa</legend>
                <b-row class="m-t-10 m-b-10">
                    <b-col md="10" offset-md="1">
                        <b-form-group
                            v-if="selectedComplex"
                            class="row"
                            label="Torre"
                            label-cols-md="3"
                            label-for="buildings-register"
                        >
                            <v-select
                                label="name"
                                :options="buildings"
                                :placeholder="'Digite nombre de la torre'"
                                id="buildings-register"
                                :clear-search-on-select="true"
                                :filterable="false"
                                @input="selectBuilding"
                                @search="searchBuilding"
                            ></v-select>
                        </b-form-group>
                        <b-form-group
                            class="row"
                            label="Nombre"
                            label-cols-md="3"
                            label-for="update-name"
                        >
                            <b-form-input
                                id="update-name"
                                v-model="estate.name"
                                placeholder="Apt 101 o Casa 12"
                            ></b-form-input>
                        </b-form-group>
                        <b-form-group
                            class="row"
                            label="Administracion"
                            label-cols-md="3"
                            label-for="update-administration"
                        >
                            <b-form-input
                                id="update-administration"
                                v-model="estate.administration"
                                placeholder="650000"
                            ></b-form-input>
                        </b-form-group>
                        <div class="pull-right">
                            <b-button
                                variant="outline-primary"
                                @click="resetUpdate"
                                >Cancelar</b-button
                            >
                            <b-button
                                variant="warning"
                                class="m-l-10"
                                @click="updateEstate"
                                >Modificar</b-button
                            >
                        </div>
                    </b-col>
                </b-row>
                <ResidentsEstate :estate_id="initialEstate.id" />
            </b-container>
        </Panel>
    </div>
</template>

<script>
let searchTimer = null;
export default {
    components: {
        ResidentsEstate: () => ({
            component: import("@/components/estates/ResidentsEstate.vue")
        })
    },
    props: {
        initialEstate: Object
    },
    watch: {
        initialEstate() {
            this.estate = { ...this.initialEstate };
        }
    },
    data() {
        return {
            estate: { ...this.initialEstate },
            complexes: [],
            buildings: [],
            selectedComplex: null,
            company: {}
        };
    },
    methods: {
        updateEstate() {
            this.$http({
                method: "PUT",
                url: "/api/estates/" + this.estate.id,
                data: this.estate
            })
                .then(() => {
                    this.$swal({
                        type: "success",
                        title: "Hecho!"
                    }).then(() => {
                        this.changeSuccesful();
                    });
                })
                .catch(() => {
                    this.$swal({
                        type: "error",
                        title: "Error!"
                    });
                });
        },
        resetUpdate() {
            this.$emit("resetUpdate");
        },
        changeSuccesful() {
            this.$emit("changeSuccesful");
        },
        selectComplex(complex) {
            this.selectedComplex = complex.id;
            this.estate.residential_complex_id = complex.id;
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
        selectBuilding(building) {
            this.estate.building_id = building.id;
        },
        searchBuilding(value, loading) {
            loading(true);
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                this.$http({
                    url:
                        "/api/residentialcomplexes/" +
                        this.selectedComplex +
                        "/buildings?query=name|LIKE|" +
                        value,
                    method: "GET"
                })
                    .then(response => {
                        this.buildings = response.data.data;
                        loading(false);
                    })
                    .catch(() => {
                        this.$swal({
                            type: "error",
                            title: "Error!"
                        });
                    });
            }, 300);
        }
    },
    created() {
        this.company = this.$store.getters.authUser.company;
    }
};
</script>

<style></style>
