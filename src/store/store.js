import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios';

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        token: '',
        role: "anonymous",
        snackbar:{
            modal: false,
            message:""
        }
    },
    actions: {
      getToken ({ commit, state }, args) {
        return new Promise((resolve, reject) => {
            console.log(args.username);
            console.log(args.slot_id);
        axios.get(`${this.api_base_url}/api/booking/getToken.php`, {
            params: {
                username: args.username,
                slot_id: args.slot_id
            }
          }).then(function(response){
            commit('updateRole', response.data);
            resolve();
          });
        })
      },
    },
    mutations: {
        updateRole(state, role) {
            console.log(role);
            console.log("update role");
            //temp
            role = "player";
          state.role = role;
        },
        showSnackBar(state, message) {
          state.snackbar.message = message;
          state.snackbar.modal = true;
        }
    },
    getters: {
        role: state => state.role,
        snackbar: state => state.snackbar
    }
  })