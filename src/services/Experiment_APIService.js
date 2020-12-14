import axios from 'axios';
import qs from 'qs';
import _ from 'lodash';
import {APIService} from '@/services/APIService';

export class Experiment_APIService extends APIService {
    constructor(api_base_url, is_dummy = false) {
        super(api_base_url);
        this.is_dummy = is_dummy;
    }
    setChart(experiment, equipment_id, device_id, chart){
        var self = this;
        const url = `${this.api_base_url}/api/experiment/setChart.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('experiment', experiment);
        bodyFormData.set('equipment_id', equipment_id);
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
    getChart(session_token, role, experiment, equipment_id, device_id){    //user side
        var self = this;
        const url = `${this.api_base_url}/api/experiment/getChart.php?experiment=`+experiment+`&equipment_id=`+equipment_id+`&device_id=`+device_id;
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
            return axios.get(url, {
                params: {
                  session_token: session_token,
                  role: role,
                  experiment: experiment,
                  equipment_id: equipment_id,
                  device_id: device_id
                }
              }).then(response => response.data);
        }
    }
    setValue(experiment, equipment_id, device_id, value){
        var self = this;
        const url = `${this.api_base_url}/api/experiment/setValue.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('experiment', experiment);
        bodyFormData.set('equipment_id', equipment_id);
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
    getCommand(experiment, equipment_id, device_id){
        var self = this;
        const url = `${this.api_base_url}/api/experiment/getCommand.php`;
        var dummy_response = {
            value:[
            ]
        };
        if(self.is_dummy){
            return new Promise(function(resolve){setTimeout(function(){resolve(dummy_response)},1000);});
        }else{
           
            return axios.get(url, {
                params: {
                  experiment: experiment,
                  equipment_id: equipment_id,
                  device_id: device_id,
                }
              }).then(response => response.data);
        }
    }
    getValue(session_token, role, experiment, equipment_id, device_id){    //user side
        var self = this;
        const url = `${this.api_base_url}/api/experiment/getValue.php`;
        var dummy_response = {
            value:[
            ]
        };
        if(self.is_dummy){
            return new Promise(function(resolve){setTimeout(function(){resolve(dummy_response)},1000);});
        }else{
           
            return axios.get(url, {
                params: {
                  session_token: session_token,
                  role: role,
                  experiment: experiment,
                  equipment_id: equipment_id,
                  device_id: device_id,
                }
              }).then(response => response.data);
        }
    }
    setCommand(session_token, role, experiment, equipment_id, device_id, command){    //user side
        var self = this;
        const url = `${this.api_base_url}/api/experiment/setCommand.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('session_token', session_token);
        bodyFormData.set('role', role);
        bodyFormData.set('experiment', experiment);
        bodyFormData.set('equipment_id', equipment_id);
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
            .then(response => response.data);
        }
    }
    setPhoto(experiment, equipment_id, filename_prefix, cb){    //user side
        var self = this;
        const url = `${this.api_base_url}/api/experiment/setPhoto.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('experiment', experiment);
        bodyFormData.set('equipment_id', equipment_id);
        bodyFormData.set('filename_prefix', filename_prefix);
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
                    if(cb){
                        cb();
                    }
                });
        }
    }
    zipPhotos(session_token, role, experiment, equipment_id, device_id, cb){    //user side
        var self = this;
        const url = `${this.api_base_url}/api/experiment/zipPhotos.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('session_token', session_token);
        bodyFormData.set('role', role);
        bodyFormData.set('experiment', experiment);
        bodyFormData.set('equipment_id', equipment_id);
        bodyFormData.set('device_id', device_id);
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
                if(cb){
                    cb();
                }
            });
        }
    }
    getPhotoTime(equipment_id, cb){
        var self = this;
        const url = `${this.api_base_url}/api/experiment/getPhotoTime.php`;
        return axios.get(url, {
            params: {
                equipment_id: equipment_id,
            }
            }).then(function (response) {
                if(cb){
                    cb(response.data);
                }
            });
    }
    rebootCamera(url){
        var self = this;
        return axios.get(url, {
            }).then(function (response) {
            });
    }

}
