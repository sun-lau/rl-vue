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
        const url = `${this.api_base_url}/getChart.php`;
        var dummy_response = {
            value:[
                {
                    x: 10,
                    y: 500
                }, 
                {
                    x: 15,
                    y: 114
                }, 
                {
                    x: 20,
                    y: 106
                }
            ]
        };
        if(self.is_dummy){
            return new Promise(function(resolve){setTimeout(function(){resolve(dummy_response)},1000);});
        }else{
            return axios.get(url).then(response => response.data);
        }
    }
    getValue(){
        var self = this;
        const url = `${this.api_base_url}/getValue.php?equipment_id=`+"asdfgh";
        var dummy_response = {
            value:[
            ]
        };
        if(self.is_dummy){
            return new Promise(function(resolve){setTimeout(function(){resolve(dummy_response)},1000);});
        }else{
           
            return axios.get(url).then(response => response.data);
        }
    }
    setCommand(command){
        var self = this;
        const url = `${this.api_base_url}/setCommand.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('equipment_id', "asdfgh");
        bodyFormData.set('command', command);
        var dummy_response = {
            status:"success"
        };
        
        if(self.is_dummy){
            return new Promise(function(resolve){setTimeout(function(){resolve(dummy_response)},1000);});
        }else{
            return axios({
                method: 'post',
                url: url,
                data: bodyFormData,
                config: { headers: {'Content-Type': 'multipart/form-data' }}
                })
            .then(function (response) {
                //handle success
                console.log(response);
            });
        }
    }

}
