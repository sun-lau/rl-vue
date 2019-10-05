import axios from 'axios';
// export class APIService{
//     constructor(API_BASE_URL){
//         this.API_BASE_URL = API_BASE_URL;
//     }

// }


export class APIService {
    constructor(api_base_url) {
        this.api_base_url = api_base_url;
        console.log("construct api service");
        axios.interceptors.request.use(function (config) {
          // if(window.$cookies.get('auth')){
          //   config.headers = { Authorization: "Token "+window.$cookies.get('auth').api_token};
          // }
        
            return config;
          }, function (error) {
            return Promise.reject(error);
          });
    }


}