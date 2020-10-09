import Vue from "vue";
import Vuex from "vuex";
import Cookies from "js-cookie";
import createPersistedState from "vuex-persistedstate";
import ApiAuth from "./auth";
import { API } from "@/services/Api";

Vue.use(Vuex);
const debug = process.env.NODE_ENV !== "production";

const store = new Vuex.Store({
  modules: {
    ApiAuth,
  },
  plugins: [
    createPersistedState({
      key: API.COOKIE,
      storage: {
        getItem: (key) => Cookies.getJSON(key),
        setItem: (key, value) =>
          Cookies.set(key, value, {
            expires: 3,
            secure: true,
            sameSite: "lax",
          }),
        removeItem: (key) => Cookies.remove(key),
      },
      getState: (key) => Cookies.getJSON(key),
      setState: (key, state) =>
        Cookies.set(key, state, {
          expires: 3,
          secure: true,
          sameSite: "lax",
        }),
    }),
  ],
  strict: debug,
});

export default store;
