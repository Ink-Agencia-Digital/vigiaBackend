<template>
  <!-- begin error -->
  <div class="error">
    <div class="error-code m-b-10"></div>
    <div class="error-content">
      <div class="error-message">Tu correo ha sido confirmado ya puedes iniciar sesion</div>
      <div>
        <router-link to="/" class="btn btn-success p-l-20 p-r-20">Iniciar Sesion</router-link>
      </div>
    </div>
  </div>
  <!-- end error -->
</template>

<script>
import PageOptions from "../config/PageOptions.vue";

export default {
  created() {
    PageOptions.pageEmpty = true;
  },
  beforeRouteLeave(to, from, next) {
    PageOptions.pageEmpty = false;
    next();
  }
};
</script>

<style scoped>
.btn {
  background: #b62c1b;
  border-color: #b62c1b;
}
</style>