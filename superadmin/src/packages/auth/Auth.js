import Cookies from "js-cookie";
import store from "@/store";
import { API } from "@/services/Api";

export default function (Vue) {
    Vue.auth = {
        hasToken: () => store.getters.getToken,
        tokenExpires: function () {
            if (Date.now() > parseInt(store.getters.getExpiresIn)) {
                store.dispatch("logout").then(() => this.destroyCookie());
                return false;
            }
            return true;
        },
        destroyCookie: () => Cookies.remove(API.COOKIE),
        isAuthenticated() {
            return this.hasToken();
        },
        hasRole: function (role) {
            return store.getters.userRoles.indexOf(role) !== -1;
        },
        can: function (permission) {
            let perm = store.getters.userPermissions.map(perm => {
                return perm.indexOf(permission) !== -1;
            });
            return perm.indexOf(true) !== -1;
        },
        ability: function (permissions) {
            let perm = permissions.map(permission => {
                return store.getters.userPermissions.map(perm => {
                    return perm.indexOf(permission) !== -1;
                });
            });
            return perm.some(r => r.includes(true));
        }
    };
    Object.defineProperties(Vue.prototype, {
        $auth: {
            get() {
                return Vue.auth;
            }
        }
    });
}
