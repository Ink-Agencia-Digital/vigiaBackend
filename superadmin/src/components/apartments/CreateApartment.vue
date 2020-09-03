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
                :clear-search-on-select="false"
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
              label-for="towers-register"
            >
              <v-select
                label="name"
                :options="towers"
                :placeholder="'Digite nombre de la torre'"
                id="towers-register"
                :clear-search-on-select="false"
                :filterable="false"
                @input="selectTower"
                @search="searchTower"
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
                v-model="newApartment.name"
                placeholder="Apt 101"
              ></b-form-input>
            </b-form-group>
            <div class="pull-right">
              <b-button variant="outline-primary" @click="resetRegister"
                >Limpiar</b-button
              >
              <b-button
                variant="warning"
                class="m-l-10"
                @click="createApartment"
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
      newApartment: {},
      complexes: [],
      towers: [],
      selectedComplex: null,
    };
  },
  methods: {
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
      this.newApartment.tower_id = tower.id;
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
    resetRegister() {
      this.$emit("resetRegister");
    },
    registrationSuccessful() {
      this.$emit("registrationSuccessful");
    },
    createApartment() {
      if (this.newApartment.tower_id) {
        let loader = this.$loading.show();
        this.$http({
          method: "POST",
          url: "/api/apartments",
          data: this.newApartment,
        })
          .then(() => {
            loader.hide();
            this.$swal({
              icon: "success",
              title: "Hecho!",
            }).then(() => {
              this.registrationSuccessful();
            });
          })
          .catch(() => {
            loader.hide();
            this.$swal({
              icon: "error",
              title: "Error!",
            });
          });
      } else {
        this.$swal({
          icon: "error",
          title: "Error!",
          text: "No ha sido asociado",
        });
      }
    },
  },
 
};
</script>

<style></style>
