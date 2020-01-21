import axios from 'axios';
import {APIService} from '@/services/APIService';

export class Root_APIService extends APIService {
    constructor(api_base_url) {
        super(api_base_url);
    }
    postLogin(username, password) {
        console.log("postLogin");
        console.log(username);
        console.log(password);
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
                location.reload();
            })
            .then(response => response.data);
    }
    

}
