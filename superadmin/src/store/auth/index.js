import actions from "./actions";
import mutations from "./mutations";
import getters from "./getters";

const state = {
    access_token: null,
    refresh_token: null,
    expires_in: null,
    user_id: null,
    user_name: null,
    user_lastname: null,
    picture: null,
    email: null,
    company: null,
    residential_complex: null,
    permissions: [],
    roles: []
};

export default {
    actions,
    mutations,
    getters,
    state
};
