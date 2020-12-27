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
        "interference":{
            "labManual": "https://stem-ap.polyu.edu.hk/remotelab/assets/files/interference.pdf",
            "setupPhoto": "https://stem-ap.polyu.edu.hk/remotelab/assets/images/interference.png"
        },
        "apparent_depth":{
            "labManual": "https://stem-ap.polyu.edu.hk/remotelab/assets/files/apparent_depth.pdf",
            "setupPhoto": "https://stem-ap.polyu.edu.hk/remotelab/assets/images/apparent-depth.png"
        },
        "em_induction":{
            "labManual": "https://stem-ap.polyu.edu.hk/remotelab/assets/files/em_induction.pdf",
            "setupPhoto": "https://stem-ap.polyu.edu.hk/remotelab/assets/images/em-induction.png"
        },
        "visible_spectrum":{
            "labManual": "https://stem-ap.polyu.edu.hk/remotelab/assets/files/visible_spectrum.pdf",
            "setupPhoto": "https://stem-ap.polyu.edu.hk/remotelab/assets/images/visible-spectrum.png"
        },
        "green_house":{
            "labManual": "https://stem-ap.polyu.edu.hk/remotelab/assets/files/green_house.pdf",
            "setupPhoto": "https://stem-ap.polyu.edu.hk/remotelab/assets/images/green-house.png"
        },
        "bacteria_growth":{
            "labManual": "https://stem-ap.polyu.edu.hk/remotelab/assets/files/interference.pdf",
            "setupPhoto": "https://stem-ap.polyu.edu.hk/remotelab/assets/images/diagram-16.png"
        },
        "photo_electric":{
            "labManual": "https://stem-ap.polyu.edu.hk/remotelab/assets/files/interference.pdf",
            "setupPhoto": "https://stem-ap.polyu.edu.hk/remotelab/assets/images/photo-electric.png"
        },
        "radiation":{
            "labManual": "https://stem-ap.polyu.edu.hk/remotelab/assets/files/interference.pdf",
            "setupPhoto": "https://stem-ap.polyu.edu.hk/remotelab/assets/images/radiation.png"
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