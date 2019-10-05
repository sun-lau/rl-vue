import axios from 'axios';
import qs from 'qs';
import _ from 'lodash';
import {APIService} from '@/services/APIService';

export class Experiment_APIService extends APIService {
    constructor(api_base_url, is_dummy = false) {
        super(api_base_url);
        this.is_dummy = is_dummy;
    }
    getChart(){
        var self = this;
        const url = `${this.api_base_url}/get.php`;
        var dummy_response = {
            chart: [500,114,106,106,107,111,133,221,783,2478]
        };
        if(self.is_dummy){
            return new Promise(function(resolve){setTimeout(function(){resolve(dummy_response)},1000);});
        }else{
            // return axios.get(url)
            // .then(response => { 
            //     console.log(response);
            // })
            return axios.get(url).then(response => response.data);
        }
    }

}
