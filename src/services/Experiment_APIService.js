import axios from 'axios';
import qs from 'qs';
import _ from 'lodash';
import {APIService} from '@/services/APIService';

export class Experiment_APIService extends APIService {
    constructor(api_base_url, is_dummy = false) {
        super(api_base_url);
        this.is_dummy = is_dummy;
    }
    setChart(device_id, chart){
        var self = this;
        const url = `${this.api_base_url}/api/experiment/setChart.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('equipment_id', "asdfgh");
        bodyFormData.set('device_id', device_id);
        bodyFormData.set('chart', chart);
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
    getChart(){
        var self = this;
        const url = `${this.api_base_url}/api/experiment/getChart.php`;
        var dummy_response = {
            value:[
                {
                    x: 10,
                    y: 500
                }, 
                {
                    x: 15,
                    y: 114
                }
            ]
        };
        if(self.is_dummy){
            return new Promise(function(resolve){setTimeout(function(){resolve(dummy_response)},1000);});
        }else{
            return axios.get(url).then(response => response.data);
        }
    }
    getValue(device_id){
        var self = this;
        const url = `${this.api_base_url}/api/experiment/getValue.php?equipment_id=`+"asdfgh&device_id="+device_id;
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
    setValue(device_id, value){
        var self = this;
        const url = `${this.api_base_url}/api/experiment/setValue.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('equipment_id', "asdfgh");
        bodyFormData.set('device_id', device_id);
        bodyFormData.set('value', value);
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
    getCommand(device_id){
        var self = this;
        const url = `${this.api_base_url}/api/experiment/getCommand.php?equipment_id=`+"asdfgh&device_id="+device_id;
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
    setCommand(device_id, command){
        var self = this;
        const url = `${this.api_base_url}/api/experiment/setCommand.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('equipment_id', "asdfgh");
        bodyFormData.set('device_id', device_id);
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
