const actions = {
    login: ({ commit }, response) => {
        response.expires_in = parseInt(response.expires_in) + Date.now();
        commit("LOGIN", response);
    },

    logout: ({ commit }) => {
        commit("LOGOUT");
    },

    auth_user: ({ commit }, response) => {
        commit("USER", response.data);
        if (response.data.roles) {
            commit("PERMISSIONS", response);
            commit("ROLES", response);
        }
    }
};

export default actions;
