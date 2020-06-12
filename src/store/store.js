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
      checkToken ({ commit }) {
        return new Promise((resolve, reject) => {
        axios.get(`https://stem-ap.polyu.edu.hk/remotelab/api/experiment/getValue.php`, {
            params: {
                experiment: "APPARENT_DEPTH",
                equipment_id: "set_0",
                device_id: "camera_0",
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