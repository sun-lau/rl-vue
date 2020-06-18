import axios from 'axios';
import qs from 'qs';
import _ from 'lodash';
import {APIService} from '@/services/APIService';

export class Booking_APIService extends APIService {
    constructor(api_base_url, is_dummy = false) {
        super(api_base_url);
        // this.is_dummy = true;
    }
    getSlotsByDate(experiment, date){
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
                    start_date: date,
                    end_date: date,
                    experiment: experiment
                }
            }).then(response => response.data);
        }
    }
    bookSlot(slot_id, auth_token){
        var self = this;
        const url = `${this.api_base_url}/api/booking/bookSlot.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('slot_id', slot_id);
        bodyFormData.set('auth_token', auth_token);
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
    releaseSlot(slot_id, auth_token){
        var self = this;
        const url = `${this.api_base_url}/api/booking/releaseSlot.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('slot_id', slot_id);
        bodyFormData.set('auth_token', auth_token);
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
    enterLab(slot_id, auth_token, role){
        var self = this;
        const url = `${this.api_base_url}/api/booking/enterLab.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('slot_id', slot_id);
        bodyFormData.set('auth_token', auth_token);
        bodyFormData.set('role', role);
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


}
