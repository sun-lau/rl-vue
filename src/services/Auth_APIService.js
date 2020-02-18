import axios from 'axios';
import qs from 'qs';
import _ from 'lodash';
import {APIService} from '@/services/APIService';

export class Auth_APIService extends APIService {
    constructor(api_base_url, is_dummy = false) {
        super(api_base_url);
        // this.is_dummy = true;
    }
    login(username, password){
        const url = `${this.api_base_url}/login.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('username', username);
        bodyFormData.set('password', password);
        return axios({
            method: 'post',
            url: url,
            data: bodyFormData,
            config: { headers: {'Content-Type': 'multipart/form-data' }}
            })
            .catch(function (error) {
                alert("Login Error: Invalid Username or Password");
            })
            .then(response => response.data);
    }
    register(username, email, password, confirm_password){
        const url = `${this.api_base_url}/register.php`;
        var bodyFormData = new FormData();
        bodyFormData.set('username', username);
        bodyFormData.set('email', email);
        bodyFormData.set('confirm_password', confirm_password);
        bodyFormData.set('password', password);
        return axios({
            method: 'post',
            url: url,
            data: bodyFormData,
            config: { headers: {'Content-Type': 'multipart/form-data' }}
            })
            .catch(function (error) {
                alert("Register Error: Invalid Username");
            })
            .then(response => response.data);
    }

}
