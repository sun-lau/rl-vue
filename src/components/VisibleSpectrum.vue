<template>
    <div>
        <v-row>
            <v-col xs="12" sm="6">
                <v-card>
                    <v-card-title>Live</v-card-title>
                    <v-row class="ml-2 mr-2 mt-4">
                        <v-col  xs="12">
                        <b-img 
                            src="http://158.132.254.152:8081/?action=stream"
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
                            <v-chip @click="setCommand('device_0','SOURCE|WHITE')">White</v-chip>
                            <v-chip @click="setCommand('device_0','SOURCE|BLUE')">Blue</v-chip>
                            <v-chip @click="setCommand('device_0','SOURCE|GREEN')">Green</v-chip>
                            <v-chip @click="setCommand('device_0','SOURCE|RED')">Red</v-chip>
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
                ]
            },
            options: {
                width:'100%',

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
            simulation:{
            },
            simluate_0_mode: false,

      }
  },
  mounted: function(){
        var self = this;
        console.log("mounted");
        setInterval(function(){ //hard protect
            location.reload();
        },1000*60*60);
  },
  methods:{
        getValue(device_id, callback){
            console.log("getValue");
            var self = this;
            apiService.getValue("VISIBLE_SPECTRUM", "xcvbnm", device_id)
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
        setCommand(device_id, command, callback){
            console.log("set command");
            console.log(device_id);
            console.log(command);
            apiService.setCommand("VISIBLE_SPECTRUM", "xcvbnm", device_id, command)
            .then((response) => {
                console.log("command is set");
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
                            // self.setCommand('device_1', 'MEASURE|END');
                            self.getChart();
                        }
                    });

                },4000);
            });
        },
        getChart(){
            console.log("getChart");
            var self = this;
            apiService.getChart("VISIBLE_SPECTRUM", "xcvbnm")
            .then((response) => {
                self.api.chart = response;
                self.series = [{data:response}];
                console.log("self.series");
                console.log(self.series);
                self.loading = false;
            });

        }
  }
}
</script>