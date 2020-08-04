<script>
const routes = [
  {
    path: "/",
    component: resolve =>
      import(/* webpackChunkName: "pages" */ "@/pages/Login.vue").then(
        Login => {
          resolve(Login.default);
        }
      )
  },
  {
    path: "/home",
    component: resolve =>
      import(/* webpackChunkName: "pages" */ "@/pages/Home.vue").then(Home => {
        resolve(Home.default);
      })
  },
  {
    path: "/users",
    component: resolve =>
      import(/* webpackChunkName: "pages" */ "@/pages/User.vue").then(User => {
        resolve(User.default);
      })
  },
  {
    path: "/complexes",
    component: resolve =>
      import(/* webpackChunkName: "pages" */ "@/pages/Complex.vue").then(
        Complex => {
          resolve(Complex.default);
        }
      )
  },
  {
    path: "/404",
    component: resolve =>
      import(/* webpackChunkName: "pages" */ "@/pages/Error404.vue").then(
        Error404 => {
          resolve(Error404.default);
        }
      )
  },
  {
    path: "/confirmation",
    component: resolve =>
      import(/* webpackChunkName: "pages" */ "@/pages/Confirmation.vue").then(
        Confirmation => {
          resolve(Confirmation.default);
        }
      )
  }
];

export default routes;
</script>
