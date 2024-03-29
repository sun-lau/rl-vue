import axios from 'axios';
import qs from 'qs';
import _ from 'lodash';
import {APIService} from '@/services/APIService';

export class Admin_APIService extends APIService {
    constructor(api_base_url, is_dummy = false) {
        super(api_base_url);
        // this.is_dummy = true;
    }
    getSlotsByDates(experiment, equipment_id, start_date, end_date){
        var self = this;
        const url = `${this.api_base_url}/api/booking/getSlotsByDates.php`;
        var dummy_response = {
            slots: [
                {
                    start_at: '12:00 PM',
                    end_at: '12:55 PM',
                    status: 'IDLE',
                    user_id:""
                },
                {
                    start_at: '1:00 PM',
                    end_at: '1:55 PM',
                    status: 'IDLE',
                    user_id:""
                }
            ]
        };
        if(self.is_dummy){
            return new Promise(function(resolve){setTimeout(function(){resolve(dummy_response)},1000);});
        }else{
            return axios.get(url,{
                params: {
                    start_date: start_date,
                    end_date: end_date,
                    experiment: experiment,
                    equipment_id: equipment_id,
                }
            }).then(response => response.data);
        }
    }
    assignSlotsToDates(start_date, end_date, start_from, duration, rest, experiment, equipment_id){
        var self = this;
        const url = `${this.api_base_url}/api/booking/assignSlotsToDates.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('start_date', start_date);
        bodyFormData.set('end_date', end_date);
        bodyFormData.set('start_from', start_from);
        bodyFormData.set('duration', duration);
        bodyFormData.set('rest', rest);
        bodyFormData.set('experiment', experiment);
        bodyFormData.set('equipment_id', equipment_id);
        return axios({
            method: 'post',
            url: url,
            data: bodyFormData,
            config: { headers: {'Content-Type': 'multipart/form-data' }}
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(response => response.data);
    }
    removeSlotsWithinDates(start_date, end_date, experiment, equipment_id){
        var self = this;
        const url = `${this.api_base_url}/api/booking/removeSlotsWithinDates.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('start_date', start_date);
        bodyFormData.set('end_date', end_date);
        bodyFormData.set('experiment', experiment);
        bodyFormData.set('equipment_id', equipment_id);
        return axios({
            method: 'post',
            url: url,
            data: bodyFormData,
            config: { headers: {'Content-Type': 'multipart/form-data' }}
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(response => response.data);
    }
    listAllUsers(){
        var self = this;
        const url = `${this.api_base_url}/../auth/listAllUsers.php`;
        var dummy_response = {
        };
        if(self.is_dummy){
            return new Promise(function(resolve){setTimeout(function(){resolve(dummy_response)},1000);});
        }else{
            return axios.get(url,{
                params: {
                }
            }).then(response => response.data);
        }
    }
    batchCreateUsers(auth_token, batch_content){
        var self = this;
        const url = `${this.api_base_url}/../auth/batchCreateUsers.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('auth_token', auth_token);
        bodyFormData.set('batch_content', batch_content);
        return axios({
            method: 'post',
            url: url,
            data: bodyFormData,
            config: { headers: {'Content-Type': 'multipart/form-data' }}
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(response => response.data);
    }
    listAllEquipments(){
        var self = this;
        const url = `${this.api_base_url}/api/experiment/listAllEquipments.php`;
        var dummy_response = {
        };
        if(self.is_dummy){
            return new Promise(function(resolve){setTimeout(function(){resolve(dummy_response)},1000);});
        }else{
            return axios.get(url,{
                params: {
                }
            }).then(response => response.data);
        }
    }
    listAllHistorys(){
        var self = this;
        const url = `${this.api_base_url}/api/booking/listAllHistorys.php`;
        var dummy_response = {
        };
        if(self.is_dummy){
            return new Promise(function(resolve){setTimeout(function(){resolve(dummy_response)},1000);});
        }else{
            return axios.get(url,{
                params: {
                }
            }).then(response => response.data);
        }
    }
    downloadAllBacteriaPhotos(experiment, equipment_id, cb){
        var self = this;
        const url = `${this.api_base_url}/api/experiment/zipArchivedPhotos.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('experiment', experiment);
        bodyFormData.set('equipment_id', equipment_id);
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
    removeAllBacteriaPhotos(experiment, equipment_id, cb){
        var self = this;
        const url = `${this.api_base_url}/api/experiment/removeArchivedPhotos.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('experiment', experiment);
        bodyFormData.set('equipment_id', equipment_id);
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
