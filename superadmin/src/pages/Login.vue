<template>
  <!-- begin login -->
  <div class="login login-v1">
    <!-- begin login-container -->
    <div class="login-container">
      <!-- begin login-header -->
      <div class="login-header">
        <div class="brand">
          <span class="logo"></span>
          <b>Color</b> Admin
          <small>responsive bootstrap 4 admin template</small>
        </div>
        <div class="icon">
          <i class="fa fa-lock"></i>
        </div>
      </div>
      <!-- end login-header -->
      <!-- begin login-body -->
      <div class="login-body">
        <!-- begin login-content -->
        <div class="login-content">
          <div class="form-group m-b-20">
            <input
              type="text"
              class="form-control form-control-lg inverse-mode"
              placeholder="Email Address"
              required
              v-model="user.email"
            />
          </div>
          <div class="form-group m-b-20">
            <input
              type="password"
              class="form-control form-control-lg inverse-mode"
              placeholder="Password"
              required
              v-model="user.password"
            />
          </div>
          <div class="checkbox checkbox-css m-b-20">
            <input type="checkbox" id="remember_checkbox" />
            <label for="remember_checkbox">Remember Me</label>
          </div>
          <div class="login-buttons">
            <button
              type="button"
              @click="login"
              class="btn btn-success btn-block btn-lg"
            >
              Sign me in
            </button>
          </div>
        </div>
        <!-- end login-content -->
      </div>
      <!-- end login-body -->
    </div>
    <!-- end login-container -->
  </div>
  <!-- end login -->
</template>

<script>
import PageOptions from "@/config/PageOptions.vue";
import { API } from "@/services/Api";

export default {
  created() {
    PageOptions.pageEmpty = true;
  },
  beforeRouteLeave(to, from, next) {
    PageOptions.pageEmpty = false;
    next();
  },
  data() {
    return {
      user: {
        email: null,
        password: null,
      },
    };
  },
  methods: {
    login: function() {
      this.loader = this.$loading.show();
      this.$http({
        url: "/oauth/token",
        method: "POST",
        data: {
          grant_type: API.GRANT_TYPE.PASSWORD,
          client_id: API.CLIENT_ID,
          client_secret: API.CLIENT_SECRET,
          username: this.user.email,
          password: this.user.password,
        },
      })
        .then((response) => {
          this.$store.dispatch("login", response.data).then(() => {
          //  this.auth_user();
          });
        })
        .catch(() => {
          this.loader.hide();
          this.$swal({
            title: "Error",
            icon: "error",
          });
        });
    },
  },
};
</script>
