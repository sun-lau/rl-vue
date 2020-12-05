import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios';

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
      current:{
        experiment:'',
        equipement_id: '',
        view:''
      },
      experiments:{
        interference:{
          labManual: 'https://stem-ap.polyu.edu.hk/remotelab/assets/files/Interference_student_-20201008.pdf',
          setupPhoto: 'https://stem-ap.polyu.edu.hk/remotelab/assets/images/diagram-16.png'
        },
        apparent_depth:{
          labManual: 'https://stem-ap.polyu.edu.hk/remotelab/assets/files/Interference_student_-20201008.pdf',
          setupPhoto: 'https://stem-ap.polyu.edu.hk/remotelab/assets/images/diagram-16.png'
        },
        em_induction:{
          labManual: 'https://stem-ap.polyu.edu.hk/remotelab/assets/files/Interference_student_-20201008.pdf',
          setupPhoto: 'https://stem-ap.polyu.edu.hk/remotelab/assets/images/diagram-16.png'
        },
        visible_spectrum:{
          labManual: 'https://stem-ap.polyu.edu.hk/remotelab/assets/files/Interference_student_-20201008.pdf',
          setupPhoto: 'https://stem-ap.polyu.edu.hk/remotelab/assets/images/diagram-16.png'
        },
        green_house:{
          labManual: 'https://stem-ap.polyu.edu.hk/remotelab/assets/files/Interference_student_-20201008.pdf',
          setupPhoto: 'https://stem-ap.polyu.edu.hk/remotelab/assets/images/diagram-16.png'
        },
        bacteria_growth:{
          labManual: 'https://stem-ap.polyu.edu.hk/remotelab/assets/files/Interference_student_-20201008.pdf',
          setupPhoto: 'https://stem-ap.polyu.edu.hk/remotelab/assets/images/diagram-16.png'
        }
      },
      snackbar:{
          modal: false,
          message:""
      }
    },
    actions: {
    },
    mutations: {
      updateCurrentExperiment(state, experiment){
        state.current.experiment = experiment;
      },
      showSnackBar(state, message) {
        state.snackbar.message = message;
        state.snackbar.modal = true;
      }
      
    },
    getters: {
      current: state => {
        return state.current;
      }
    }
  })