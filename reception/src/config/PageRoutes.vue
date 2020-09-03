<script>
const routes = [
    {
        path: "/",
        component: resolve =>
            import(/* webpackChunkName: "Login" */ "@/pages/Login.vue").then(
                Login => {
                    resolve(Login.default);
                }
            )
    },
    {
        path: "/home",
        component: resolve =>
            import(/* webpackChunkName: "Home" */ "@/pages/Home.vue").then(
                Home => {
                    resolve(Home.default);
                }
            )
    },
    {
        path: "/404",
        component: resolve =>
            import(/* webpackChunkName: "Error" */ "@/pages/Error404.vue").then(
                Error404 => {
                    resolve(Error404.default);
                }
            )
    }
];

export default routes;
</script>
