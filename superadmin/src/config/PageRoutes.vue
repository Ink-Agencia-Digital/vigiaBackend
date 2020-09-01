<script>
const routes = [
  {
    path: "/",
    component: (resolve) =>
      import(/* webpackChunkName: "Login" */ "@/pages/Login.vue").then(
        (Login) => {
          resolve(Login.default);
        }
      ),
  },
  {
    path: "/home",
    component: (resolve) =>
      import(/* webpackChunkName: "Home" */ "@/pages/Home.vue").then((Home) => {
        resolve(Home.default);
      }),
  },
  {
    path: "/users",
    component: (resolve) =>
      import(/* webpackChunkName: "User" */ "@/pages/User.vue").then((User) => {
        resolve(User.default);
      }),
  },
  {
    path: "/complexes",
    component: (resolve) =>
      import(/* webpackChunkName: "Complex" */ "@/pages/Complex.vue").then(
        (Complex) => {
          resolve(Complex.default);
        }
      ),
  },
  {
    path: "/towers",
    component: (resolve) =>
      import(/* webpackChunkName: "Tower" */ "@/pages/Tower.vue").then(
        (Tower) => {
          resolve(Tower.default);
        }
      ),
  },
  {
    path: "/404",
    component: (resolve) =>
      import(/* webpackChunkName: "Error" */ "@/pages/Error404.vue").then(
        (Error404) => {
          resolve(Error404.default);
        }
      ),
  },
  {
    path: "/confirmation",
    component: (resolve) =>
      import(/* webpackChunkName: "pages" */ "@/pages/Confirmation.vue").then(
        (Confirmation) => {
          resolve(Confirmation.default);
        }
      ),
  },
];

export default routes;
</script>
