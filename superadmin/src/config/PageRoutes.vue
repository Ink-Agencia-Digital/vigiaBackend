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
    path: "/categories",
    component: resolve =>
      import(/* webpackChunkName: "pages" */ "@/pages/Category.vue").then(
        Category => {
          resolve(Category.default);
        }
      )
  },
  {
    path: "/courses",
    component: resolve =>
      import(/* webpackChunkName: "pages" */ "@/pages/Course.vue").then(
        Course => {
          resolve(Course.default);
        }
      )
  }
];

export default routes;
</script>
