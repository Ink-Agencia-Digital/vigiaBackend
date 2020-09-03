<template>
  <div>
    <Panel title="Registrar torre">
      <b-container>
        <legend>Información de la torre</legend>
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
              class="row"
              label="Nombre"
              label-cols-md="3"
              label-for="register-name"
            >
              <b-form-input
                id="register-name"
                v-model="newTower.name"
                placeholder="Torre 13"
              ></b-form-input>
            </b-form-group>
            <div class="pull-right">
              <b-button variant="outline-primary" @click="resetRegister"
                >Limpiar</b-button
              >
              <b-button variant="warning" class="m-l-10" @click="createTower"
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
      newTower: {},
      complexes: [],
    };
  },
  methods: {
    selectComplex(complex) {
      this.newTower.complex_id = complex.id;
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
    resetRegister() {
      this.$emit("resetRegister");
    },
    registrationSuccessful() {
      this.$emit("registrationSuccessful");
    },
    createTower() {
      let loader = this.$loading.show();
      this.$http({
        method: "POST",
        url: "/api/towers",
        data: this.newTower,
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
    },
  },
};
</script>

<style></style>
