import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios';

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
      token: '',
      role: "anonymous"
    },
    actions: {
      checkToken ({ commit, state }, token) {
        return new Promise((resolve, reject) => {
          console.log("token");
          console.log(token);
        axios.get(`https://stem-ap.polyu.edu.hk/remotelab/api/experiment/checkToken.php`, {
            params: {
                token: token
            }
          }).then(function(response){
            commit('updateRole', response.data);
            resolve();
          });
        })
      }
    },
    mutations: {
      updateRole(state, role) {
          console.log(role);
          console.log("update role");
          //temp
          role = "player";
        state.role = role;
      }
    },
    getters: {
      role: state => state.role
    }
  })