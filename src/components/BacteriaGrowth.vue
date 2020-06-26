<template>
    <div>
        <v-container fluid>
            <v-row>
                <v-col xs="12" sm="12">
                    <v-card>
                        <v-card-title>Bacteria Growth</v-card-title>
                        <v-row class="ml-2 mr-2 mt-4">
                            <v-col  xs="12" sm="6">
                                {{api.camera_0}}
                                <b-img 
                                    :src="api.camera_0"
                                    fluid
                                />
                            </v-col>
                            <v-col xs="12" sm="6">
                                    {{api.camera_1}}
                                <b-img 
                                    :src="api.camera_1"
                                    fluid
                                />
                            </v-col>
                        </v-row>
                    </v-card>
                    <br>
                    <v-card>
                        <v-card-title>Move to Sample</v-card-title>
                        <v-btn-toggle
                            rounded
                            dense
                            class="ml-4">
                            <v-btn @click="setSample('1')" >
                                1
                            </v-btn>
                            <v-btn @click="setSample('2')" >
                                2
                            </v-btn>
                            <v-btn @click="setSample('3')" >
                                3
                            </v-btn>
                            <v-btn @click="setSample('4')" >
                                4
                            </v-btn>
                            <v-btn @click="setSample('5')" >
                                5
                            </v-btn>
                            <v-btn @click="setSample('6')" >
                                6
                            </v-btn>
                            <v-btn @click="setSample('7')" >
                                7
                            </v-btn>
                            <v-btn @click="setSample('8')" >
                                8
                            </v-btn>
                        </v-btn-toggle>
                        <br>
                    </v-card>
                    <v-card>
                        <v-card-title>Records</v-card-title>
                        <v-btn class="ma-4" @click="capture">
                            Capture
                        </v-btn>
                        <v-btn class="ma-4" @click="downloadPhotos">
                            Download All Photos
                        </v-btn>
                        <br>

                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <v-dialog v-model="loading" fullscreen>
            <v-container fluid fill-height style="background-color: rgba(255, 255, 255, 0.5);">
                <v-layout justify-center align-center>
                <v-progress-circular
                    indeterminate
                    color="primary">
                </v-progress-circular>
                </v-layout>
            </v-container>
        </v-dialog>
    </div>
</template>

<script>
// @ is an alias to /src

import moment from 'moment';
import LineChart from '@/components/LineChart.vue'
import {Experiment_APIService} from '@/services/Experiment_APIService';
const apiService = new Experiment_APIService(process.env.VUE_APP_BASE_URL);
export default {
  name: 'BacteriaGrowth',
  components: {
      LineChart
  },
  props: {
      role:String
  },
  data:function(){
      return{
            inte:null,
            loading: false,
            api:{
                camera_0:"",
                camera_1:"",
                value:"",
                value_got_at:null,
                value_set_at:null
            },
            experiment_name:"",
            current_sample:1
      }
  },
  mounted: function(){
        var self = this;
        self.experiment_name = "BACTERIA_GROWTH";
        self.getValue("camera_0", function(){
            self.api.camera_0 = self.api.value.url;
        });
        self.getValue("camera_1", function(){
            self.api.camera_1 = self.api.value.url;
        });
  },
  methods:{
        getValue(device_id, callback){
            console.log("getValue");
            var self = this;
            apiService.getValue(self.$cookies.get('session_token'), self.$cookies.get('role'), self.experiment_name, self.$cookies.get('equipment_id'), device_id)
            .then((response) => {
                self.api.value_got_at = response.value_got_at;
                self.api.value_set_at = response.value_set_at;
                self.api.command_got_at = response.command_got_at;
                self.api.command_set_at = response.command_set_at;
                self.api.value = JSON.parse(response.value);
                if(callback){
                    callback();
                }
            });
        },
        setCommand(device_id, command, callback){
            console.log("set command");
            var self = this;
            apiService.setCommand(self.$cookies.get('session_token'), self.$cookies.get('role'), self.experiment_name, self.$cookies.get('equipment_id'), device_id, command)
            .then((response) => {
                if(callback){
                    callback();
                }
            });
        },
        setSample(target_sample){
            var self = this;
            self.current_sample = target_sample;
            self.setCommand("device_0","SAMPLE|"+target_sample);
        },
        capture(){
            var self = this;
            apiService.setPhoto(self.experiment_name, self.$cookies.get('equipment_id'), "sample_"+self.current_sample, function(){
                self.$store.commit('showSnackBar', "Photo Captured");
            });
        },
        downloadPhotos(){
            var self = this;
            apiService.zipPhotos(self.$cookies.get('session_token'), self.$cookies.get('role'), self.experiment_name, self.$cookies.get('equipment_id'), "device_0",  function(){
                window.open(process.env.VUE_APP_BASE_URL+"/api/experiment/storage/"+self.experiment_name+"-"+self.$cookies.get('equipment_id')+".zip");
            });

        }
  }
}
</script>
