<template>
    <div>
        <Panel title="Registrar casa">
            <b-container>
                <legend>Información del casa</legend>
                <b-row class="m-t-10 m-b-10">
                    <b-col md="10" offset-md="1">
                        <b-form-group
                            class="row"
                            label="Conjunto"
                            label-cols-md="3"
                            label-for="complexes"
                        >
                            <v-select
                                label="name"
                                :options="complexes"
                                :placeholder="'Digite nombre de conjunto'"
                                id="complexes"
                                :clear-search-on-select="true"
                                :filterable="false"
                                @input="selectComplex"
                                @search="searchComplex"
                            ></v-select>
                        </b-form-group>
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
                            label-for="register-name"
                        >
                            <b-form-input
                                id="register-name"
                                v-model="newEstate.name"
                                placeholder="Apt 101"
                            ></b-form-input>
                        </b-form-group>
                        <b-form-group
                            class="row"
                            label="Administracion"
                            label-cols-md="3"
                            label-for="register-administration"
                        >
                            <b-form-input
                                id="register-administration"
                                v-model="newEstate.administration"
                                placeholder="650000"
                            ></b-form-input>
                        </b-form-group>
                        <div class="pull-right">
                            <b-button
                                variant="outline-primary"
                                @click="resetRegister"
                                >Limpiar</b-button
                            >
                            <b-button
                                variant="warning"
                                class="m-l-10"
                                @click="createEstate"
                                >Crear</b-button
                            >
                        </div>
                    </b-col>
                </b-row>
            </b-container>
        </Panel>
    </div>
</template>

<script>
let searchTimer = null;

export default {
    data() {
        return {
            newEstate: {},
            complexes: [],
            buildings: [],
            selectedComplex: null,
            company: {}
        };
    },
    methods: {
        selectComplex(complex) {
            this.selectedComplex = complex.id;
            this.newEstate.residential_complex_id = complex.id;
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
            this.newEstate.building_id = building.id;
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
                        value +
                        "",
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
        },
        resetRegister() {
            this.$emit("resetRegister");
        },
        registrationSuccessful() {
            this.$emit("registrationSuccessful");
        },
        createEstate() {
            let registrate = () => {
                let loader = this.$loading.show();
                this.$http({
                    method: "POST",
                    url: "/api/estates",
                    data: this.newEstate
                })
                    .then(() => {
                        loader.hide();
                        this.$swal({
                            type: "success",
                            title: "Hecho!"
                        }).then(() => {
                            this.registrationSuccessful();
                        });
                    })
                    .catch(() => {
                        loader.hide();
                        this.$swal({
                            type: "error",
                            title: "Error!"
                        });
                    });
            };

            if (!this.newEstate.building_id) {
                this.$swal({
                    title: "Está seguro?",
                    text: "Una torre/interior no fue asociada/o",
                    type: "warning",
                    showCancelButton: true
                }).then(status => {
                    if (status.value) {
                        registrate();
                    }
                });
            } else {
                registrate();
            }
        }
    },
    created() {
        this.company = this.$store.getters.authUser.company;
    }
};
</script>

<style></style>
