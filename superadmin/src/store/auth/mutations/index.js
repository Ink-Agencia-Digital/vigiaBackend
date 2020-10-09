const mutations = {
  LOGIN(state, response) {
    state.access_token = response.access_token;
    state.refresh_token = response.refresh_token;
    state.expires_in = response.expires_in;
  },

  LOGOUT(state) {
    state.access_token = null;
    state.refresh_token = null;
    state.expires_in = null;
  },

  USER(state, response) {
    state.user_id = response.id;
    state.user_name = response.name;
    state.last_name = response.lastname;
    state.picture = response.picture;
    state.email = response.email;
  },

  PERMISSIONS(state, response) {
    state.permissions = response.data.roles.map((role) => {
      if (role.permissions) {
        return role.permissions.map((permission) => {
          return permission.name;
        });
      } else {
        return [];
      }
    });
  },

  ROLES(state, response) {
    state.roles = response.data.roles.map((role) => {
      return role.name;
    });
  },
};

export default mutations;
