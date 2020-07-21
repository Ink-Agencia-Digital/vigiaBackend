<template>
  <panel ref="panelRegister" title="Creacion de categorias">
    <b-container>
      <b-row class="m-t-10 m-b-10">
        <b-col md="10" offset-md="1">
          <b-form-group class="row" label="Nombre" label-cols-md="3" label-for="category-name">
            <b-form-input id="category-name" v-model="newUser.name" required></b-form-input>
          </b-form-group>
          <b-form-group
            class="row"
            label="Descripcion"
            label-cols-md="3"
            label-for="category-description"
          >
            <b-form-textarea id="category-description" type="text" v-model="newUser.description"></b-form-textarea>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col md="4" offset-md="6">
          <b-row>
            <b-col col sm="6" md="4" offset-md="0">
              <b-button variant="outline-primary" @click="resetRegister">Limpiar</b-button>
            </b-col>
            <b-col col sm="6" md="4" offset-md="1">
              <b-button variant="warning" @click="createCategory">Registrar</b-button>
            </b-col>
          </b-row>
        </b-col>
      </b-row>
    </b-container>
  </panel>
</template>

<script>
export default {
  data() {
    return {
      newUser: {}
    };
  },
  methods: {
    createCategory() {
      this.$http({
        method: "POST",
        url: "/api/users",
        data: this.newUser
      })
        .then(() => {
          this.registrationSuccessful();
          this.$swal.fire("Exito!", "Registro exitoso", "success");
        })
        .catch(error => {
          console.log(error);
          this.$swal.fire("Error!", "Registro fallido", "error").then(() => {
            this.resetRegister();
          });
        });
    },
    registrationSuccessful() {
      this.$emit("registrationSuccessful");
      this.resetRegister();
    }
  }
};
</script>

<style scoped>
.dropzone-custom-content {
  position: inherit;
  top: 50%;
  left: 50%;
  text-align: center;
}

.dropzone-custom-title {
  margin-top: 0;
  color: #00b782;
}

.subtitle {
  color: #314b5f;
  font-size: medium;
}
</style>