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
      getToken ({ commit, state }, args) {
        return new Promise((resolve, reject) => {
            console.log("hey");
            console.log(args.username);
            console.log(args.slot_id);
        axios.get(`https://stem-ap.polyu.edu.hk/remotelab/api/booking/getToken.php`, {
            params: {
                username: args.username,
                slot_id: args.slot_id
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