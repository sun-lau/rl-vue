
import { Experiment_APIService } from "@/services/Experiment_APIService";
const apiService = new Experiment_APIService(process.env.VUE_APP_BASE_URL);
export default {
    data: () => ({
        camera_dialog: false,
        camera_dialog_camera: {},
        setup_dialog: false,
    }),
    methods: {
        popCamera(camera){
          this.camera_dialog = true;
          this.camera_dialog_camera = camera;
        },
        popSetup() {
            this.setup_dialog = true;
        },
      
        getValue(device_id, callback) {
            var self = this;
            apiService
            .getValue(
                self.$cookies.get("session_token"),
                self.$cookies.get("role"),
                self.experiment_name,
                self.$cookies.get("equipment_id"),
                device_id
            )
            .then((response) => {
                self.api.value_got_at = response.value_got_at;
                self.api.value_set_at = response.value_set_at;
                self.api.command_got_at = response.command_got_at;
                self.api.command_set_at = response.command_set_at;
                if(response.value!=''){
                    self.api.value = JSON.parse(response.value);
                }
                if (callback) {
                callback();
                }
            });
        },
        getChart(device_id) {
            var self = this;
            apiService
            .getChart(
                self.$cookies.get("session_token"),
                self.$cookies.get("role"),
                self.experiment_name,
                self.$cookies.get("equipment_id"),
                device_id
            )
            .then((response) => {
                self.api.chart = response;
                self.series = [{ data: response }];
                console.log("self.series");
                console.log(self.series);
                self.loading = false;
            });
        },
        setCommand(device_id, command, callback) {
            var self = this;
            apiService
            .setCommand(
                self.$cookies.get("session_token"),
                self.$cookies.get("role"),
                self.experiment_name,
                self.$cookies.get("equipment_id"),
                device_id,
                command
            )
            .then(() => {
                if (callback) {
                callback();
                }
            });
        },
        requestChart(device) {
            var self = this;
            self.loading = true;
            self.setCommand(device, "MEASURE|START", function () {
            self.inte = setInterval(function () {
                self.getValue(device, function () {
                if (self.api.value.chart_at >= self.api.command_set_at) {
                    clearInterval(self.inte);
                    self.getChart(device);
                }
                });
            }, 4000);
            });
        },
    },
    created(){
    }
  }