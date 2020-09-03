<template>
  <div>
    <Panel title="Actualizar casa">
      <b-container>
        <legend>Información de la casa</legend>
        <b-row class="m-t-10 m-b-10">
          <b-col md="10" offset-md="1">
            <b-form-group
              class="row"
              label="Conjunto"
              label-cols-md="3"
              label-for="complexes-update"
            >
              <v-select
                id="complexes-update"
                label="name"
                :options="complexes"
                :placeholder="apartment.tower.complex.name"
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
              label-for="towers-uodate"
            >
              <v-select
                label="name"
                :options="towers"
                :placeholder="apartment.tower.name"
                id="towers-update"
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
              label-for="update-name"
            >
              <b-form-input
                id="update-name"
                v-model="apartment.name"
                placeholder="Apt 101 o Casa 12"
              ></b-form-input>
            </b-form-group>
            <div class="pull-right">
              <b-button variant="outline-primary" @click="resetUpdate"
                >Cancelar</b-button
              >
              <b-button
                variant="warning"
                class="m-l-10"
                @click="updateApartment"
                >Modificar</b-button
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
  props: {
    initialApartment: Object,
  },
  data() {
    return {
      apartment: { ...this.initialApartment },
      complexes: [],
      towers: [],
      selectedComplex: null,
    };
  },
  methods: {
    updateApartment() {
      this.$http({
        method: "PUT",
        url: "/api/apartments/" + this.apartment.id,
        data: this.apartment,
      })
        .then(() => {
          this.$swal({
            icon: "success",
            title: "Hecho!",
          }).then(() => {
            this.updateSuccess();
          });
        })
        .catch(() => {
          this.$swal({
            icon: "error",
            title: "Error!",
          });
        });
    },
    resetUpdate() {
      this.$emit("resetUpdate");
    },
    updateSuccess() {
      this.$emit("updateSuccess");
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
      this.apartment.tower_id = tower.id;
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
