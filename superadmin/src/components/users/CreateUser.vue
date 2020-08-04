<template>
  <panel ref="panelRegister" title="Creacion de categorias">
    <b-container>
      <b-row class="m-t-10 m-b-10">
        <b-col md="10" offset-md="1">
          <b-form-group class="row" label="Nombre" label-cols-md="3" label-for="user-name">
            <b-form-input id="user-name" v-model="newUser.name"></b-form-input>
          </b-form-group>
          <b-form-group class="row" label="Apellido" label-cols-md="3" label-for="user-lastname">
            <b-form-input id="user-lastname" v-model="newUser.lastname"></b-form-input>
          </b-form-group>
          <b-form-group class="row" label="Direccion" label-cols-md="3" label-for="user-address">
            <b-form-input id="user-address" v-model="newUser.address"></b-form-input>
          </b-form-group>
          <b-form-group class="row" label="Número" label-cols-md="3" label-for="user-phone">
            <b-form-input id="user-phone" v-model="newUser.phone"></b-form-input>
          </b-form-group>
          <b-form-group class="row" label="Correo" label-cols-md="3" label-for="user-email">
            <b-form-input id="user-email" type="email" v-model="newUser.email"></b-form-input>
          </b-form-group>
          <b-form-group class="row" label="Contraseña" label-cols-md="3" label-for="user-password">
            <b-form-input id="user-password" type="password" v-model="newUser.password"></b-form-input>
          </b-form-group>
          <b-form-group
            class="row"
            label="Confirmacion"
            label-cols-md="3"
            label-for="user-password_confirmation"
            type="password"
          >
            <b-form-input id="user-password_confirmation" v-model="newUser.password_confirmation"></b-form-input>
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
              <b-button variant="warning" @click="createUser">Registrar</b-button>
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
    createUser() {
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
    },
    resetRegister() {
      this.$emit("resetRegister");
    }
  }
};
</script>