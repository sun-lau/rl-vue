<template>
    <div>
        <v-row>
            <v-col xs="12" sm="6">
                <v-card>
                    <v-card-title>Live</v-card-title>
                    <v-row class="ml-2 mr-2 mt-4">
                        <v-col cols="12">
                        <b-img 
                            :src="api.camera_0"
                            fluid
                        />
                        </v-col>
                    </v-row>
                </v-card>
                <v-card>
                    <v-card-title>Source</v-card-title>
                    <v-card-actions class="ml-4">
                        <v-chip-group
                            v-model="source_status"
                            active-class="deep-purple accent-4 white--text"
                            column
                        >
                            <v-chip @click="setCommand('device_0','SOURCE|OFF')">Off</v-chip>
                            <v-chip @click="setCommand('device_0','SOURCE|WHITE')">White LED</v-chip>
                            <v-chip @click="setCommand('device_0','SOURCE|BLUE')">Blue LED</v-chip>
                            <v-chip @click="setCommand('device_0','SOURCE|GREEN')">Green LED</v-chip>
                            <v-chip @click="setCommand('device_0','SOURCE|RED')">Red LED</v-chip>
                            <v-chip @click="setCommand('device_0','SOURCE|SODIUM')">Sodium Lamp</v-chip>
                            <v-chip @click="setCommand('device_0','SOURCE|MERCURY')">Mercury Lamp</v-chip>
                        </v-chip-group>
                        <v-spacer></v-spacer>
                        <v-btn
                            icon
                            @click="source_show = !source_show"
                        >
                            <v-icon>{{ source_show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                        </v-btn>
                    </v-card-actions>

                    <v-expand-transition>
                    <div v-show="source_show">
                        <v-divider></v-divider>

                        <v-card-text>
                        Details
                        </v-card-text>
                    </div>
                    </v-expand-transition>
                </v-card>
            </v-col>
            <v-col xs="12" sm="6">
                <v-card>
                    <v-card-title>Spectrum</v-card-title>
                    <apexchart type="line" :options="options" :series="series"></apexchart>
                    <v-btn block @click="requestChart()">Measure</v-btn>
                    <download-csv
                        :data   = "api.chart">
                        <v-btn class="mt-4" block>Download</v-btn>
                    </download-csv>
                </v-card>
            </v-col>
        </v-row>
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
  name: 'VisibleSpectrum',
  components: {
      LineChart
  },
  data:function(){
      return{
            inte:null,
            source_show:false,
            source_status:"",
            loading: false,
            api:{
                value:"",
                value_got_at:null,
                value_set_at:null,
                chart:[
                    {
                        'x': 0,
                        'y': 0
                    }
                ],
                camera_0:""
            },
            options: {
                width:'100%',
                stroke: {
                width:1
                },
                yaxis: {
                    title: {
                        text: "Intensity (count)",
                    },
                },
                xaxis: {
                    title: {
                        text: "Wavelength (nm)",
                    },
                }
            },
            series: [{
                data: []
            }],

      }
  },
  mounted: function(){
        var self = this;
        self.experiment_name = "VISIBLE_SPECTRUM";
        // self.setCommand("device_0","RESTART|1");
        self.getValue("camera_0", function(){
            self.api.camera_0 = self.api.value.url;
        });
        // self.loading = true;
        // setTimeout(function(){
        //     self.loading = false;
        // },5000);
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
                self.api.value = JSON.parse(response.value)
                console.log("self.api.value");
                console.log(self.api.value);
                if(callback){
                    callback();
                }
            });
        },
        getChart(device_id){
            console.log("getChart");
            var self = this;
            apiService.getChart(self.$cookies.get('session_token'), self.$cookies.get('role'), self.experiment_name, self.$cookies.get('equipment_id'), device_id)
            .then((response) => {
                self.api.chart = response;
                self.series = [{data:response}];
                console.log("self.series");
                console.log(self.series);
                self.loading = false;
            });
        },
        setCommand(device_id, command, callback){
            console.log("set command");
            var self = this;
            apiService.setCommand(self.$cookies.get('session_token'), self.$cookies.get('role'), self.experiment_name, self.$cookies.get('equipment_id'), device_id, command)
            .then((response) => {
                console.log("command is set");
                console.log(self.experiment_name);

                console.log("response");
                console.log(response);
                if(callback){
                    callback();
                }
            });
        },
        requestChart(){
            var self = this;
            self.loading = true;
            self.setCommand('device_0', 'MEASURE|START', function(){
                self.inte = setInterval(function(){
                    self.getValue("device_0",function(){
                        console.log("self.api.value");
                        console.log(self.api.value);
                        if(self.api.value.chart_at > self.api.command_set_at){
                            clearInterval(self.inte);
                            self.getChart('device_0');
                        }
                    });

                },4000);
            });
        }
  }
}
</script>
