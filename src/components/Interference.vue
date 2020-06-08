<template>
    <div class="">
        <v-container fluid>
            <v-row>
                <v-col xs="12" sm="6">
                    <v-card>
                        <v-card-title>Live</v-card-title>
                        <v-row class="ml-2 mr-2 mt-4">
                            <v-col  xs="12" sm="6">
                            <b-img 
                                src="http://158.132.254.152:8081/?action=stream"
                                fluid
                            />
                            </v-col>
                            <v-col xs="12" sm="6">
                            <b-img 
                                src="http://158.132.254.152:8082/?action=stream"
                                fluid
                            />
                            </v-col>
                        </v-row>
                    </v-card>
                    <v-card>
                        <v-card-title>Measure Result</v-card-title>
                        <apexchart type="line" :options="options" :series="series"></apexchart>
                    </v-card>
                </v-col>
                <v-col xs="12" sm="6">
                    <v-card>
                        <v-card-title>Laser State</v-card-title>
                        <v-card-actions class="ml-4">
                            <v-chip-group
                                v-model="laser_status"
                                active-class="deep-purple accent-4 white--text"
                                column
                            >
                                <v-chip @click="setCommand('device_0','LASER|RED')">Red</v-chip>
                                <v-chip @click="setCommand('device_0','LASER|GREEN')">Green</v-chip>
                            </v-chip-group>
                            <v-spacer></v-spacer>
                            <v-btn
                                icon
                                @click="laser_show = !laser_show"
                            >
                                <v-icon>{{ laser_show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                            </v-btn>
                        </v-card-actions>

                        <v-expand-transition>
                        <div v-show="laser_show">
                            <v-divider></v-divider>

                            <v-card-text>
                            I'm a thing. But, like most politicians, he promised more than he could deliver. You won't have time for sleeping, soldier, not with all the bed making you'll be doing. Then we'll go with that data file! Hey, you add a one and two zeros to that or we walk! You're going to do his laundry? I've got to find a way to escape.
                            </v-card-text>
                        </div>
                        </v-expand-transition>
                    </v-card>
                    <v-card>
                        <v-card-title>Power</v-card-title>
                        <v-card-actions class="ml-4">
                            <v-slider
                                v-model="power"
                                thumb-label="always"
                                @end="setCommand('device_0','POWER|'+power)"
                            ></v-slider>
                            <v-spacer></v-spacer>
                            <v-btn
                                icon
                                @click="gain_show = !gain_show"
                            >
                                <v-icon>{{ gain_show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                            </v-btn>
                        </v-card-actions>

                        <v-expand-transition>
                        <div v-show="gain_show">
                            <v-divider></v-divider>

                            <v-card-text>
                            I'm a thing. But, like most politicians, he promised more than he could deliver. You won't have time for sleeping, soldier, not with all the bed making you'll be doing. Then we'll go with that data file! Hey, you add a one and two zeros to that or we walk! You're going to do his laundry? I've got to find a way to escape.
                            </v-card-text>
                        </div>
                        </v-expand-transition>
                    </v-card>
                    <v-card>

                        <v-card-title>Slit Position</v-card-title>
                        <v-btn-toggle
                            rounded
                            class="ml-4">
                            <v-btn @click="setCommand('device_0', 'SLIT|LEFT')" >
                                <font-awesome-icon icon="angle-left" /> 
                                Left
                            </v-btn>
                            <v-btn variant="info" @click="setCommand('device_0', 'SLIT|RIGHT')">
                                <font-awesome-icon icon="angle-right" /> 
                                Right
                            </v-btn>
                        </v-btn-toggle>

                    <v-card>

                        <v-card-title>Step</v-card-title>
                        <v-card-actions class="ml-4">
                            <v-chip-group
                                v-model="step_status"
                                active-class="deep-purple accent-4 white--text"
                                column
                            >
                                <v-chip @click="setCommand('device_0','STEP|SMALL')">Small</v-chip>
                                <v-chip @click="setCommand('device_0','STEP|LARGE')">Large</v-chip>
                            </v-chip-group>
                            <v-spacer></v-spacer>
                            <v-btn
                                icon
                                @click="step_show = !step_show"
                            >
                                <v-icon>{{ step_show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                            </v-btn>
                        </v-card-actions>

                        <v-expand-transition>
                        <div v-show="step_show">
                            <v-divider></v-divider>

                            <v-card-text>
                            I'm a thing. But, like most politicians, he promised more than he could deliver. You won't have time for sleeping, soldier, not with all the bed making you'll be doing. Then we'll go with that data file! Hey, you add a one and two zeros to that or we walk! You're going to do his laundry? I've got to find a way to escape.
                            </v-card-text>
                        </div>
                        </v-expand-transition>
                    </v-card>

                        <v-card-title>
                            Distance D 
                        </v-card-title>
                        <v-btn-toggle
                            rounded
                            class="ml-4">
                            <v-btn @click="setCommand('device_0', 'DISTANCE|INCREASE')" >
                                <font-awesome-icon icon="angle-up" />
                                Increase
                            </v-btn>
                            <v-btn variant="info" @click="setCommand('device_0', 'DISTANCE|DECREASE')">
                                <font-awesome-icon icon="angle-down" />
                                Decrease
                            </v-btn>
                        </v-btn-toggle>
                        <small class="ma-4">D = {{api.value.distance}}mm</small>
                        <br>
                        <br>
                        <div class="ma-4">
                            <v-btn block @click="requestChart()">Measure</v-btn>
                            <br>
                            <!-- <v-btn block @click="getValue()">Export</v-btn> -->
                        </div>
                        <br>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
                <v-col xs="6">
                    <v-card>
                        <v-card-title>Device 0 Simulation
                            <v-switch
                            v-model="simluate_0_mode"
                            ></v-switch>
                        </v-card-title>
                        <v-card-text>
                            <v-container fluid>
                                <v-row>
                                    <v-col cols="12" md="12">
                                        <v-list two-line subheader>
                                            <v-card v-for="(log, i) of simulation.device_0.logs" :key="i" class="ma-4">
                                                <v-card-text>
                                                <h6 v-text="log.api"></h6>
                                                <small class="float-right" v-text="log.time"></small>
                                                <p v-text="log.request"></p>
                                                <p v-text="log.response"></p>
                                                </v-card-text>
                                            </v-card>
                                        </v-list>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col xs="6">
                    <v-card>
                        <v-card-title>Device 1 Simulation
                            <v-switch
                            v-model="simluate_1_mode"
                            ></v-switch></v-card-title>
                        <v-card-text>
                            <v-container fluid>
                                <v-row>
                                    <v-col cols="12" md="12">
                                        <v-list two-line subheader>
                                            <v-card v-for="(log, i) of simulation.device_1.logs" :key="i" class="ma-4">
                                                <v-card-text>
                                                <h6 v-text="log.api"></h6>
                                                <small class="float-right" v-text="log.time"></small>
                                                <p v-text="log.request"></p>
                                                <p v-text="log.response"></p>
                                                </v-card-text>
                                            </v-card>
                                        </v-list>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
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
  name: 'Interference',
  components: {
      LineChart
  },
  data:function(){
      return{
            inte:null,
            laser_show:false,
            gain_show:false,
            laser_show:false,
            step_show: false,
            laser_status:"",
            step_status:"",
            power:0,
            loading: false,
            api:{
                value:"",
                value_got_at:null,
                value_set_at:null
            },
            options: {
                width:'100%'
            },
            series: [{
                data: []
            }],
            simulation:{
                device_0:{
                    logs:[],
                    status:"WAIT_FOR_COMMAND"
                },
                device_1:{
                    logs:[],
                    status:"WAIT_FOR_COMMAND"
                }
            },
            simluate_0_mode: false,
            simluate_1_mode: false,

      }
  },
  mounted: function(){
        var self = this;
        console.log("mounted");
        setInterval(function(){
            if(self.simluate_0_mode){
                self.simulate_device_0();
            }
        },5000);
        setInterval(function(){
            if(self.simluate_1_mode){
                self.simulate_device_1();
            }
        },3000);
        setInterval(function(){ //loop distance value
            self.getValue("device_0");
        },1000);
        setInterval(function(){ //hard protect
            location.reload();
        },1000*60*60);
  },
  methods:{
        simulate_device_0(){
            var self = this;
            if(self.simulation.device_0.status == "WAIT_FOR_COMMAND"){
                apiService.getCommand("INTERFERENCE", "asdfgh", "device_0")
                .then((response) => {
                    if(response.command_got_at <= response.command_set_at){
                        self.simulation.device_0.logs.unshift({
                            time: moment().format('HH:mm:ss'),
                            api:"getCommand",
                            request:{
                                equipment_id:"asdfgh"
                            },
                            response:response,
                        });
                    }else{
                        self.simulation.device_0.logs.unshift({
                            time: moment().format('HH:mm:ss'),
                            api:"getCommand [IGNORE]",
                            response:response,
                        });

                    }
                });
            }

        },
        simulate_device_1(){
            var self = this;
            if(self.simulation.device_1.status == "WAIT_FOR_COMMAND"){
                apiService.getCommand("INTERFERENCE", "asdfgh", "device_1")
                .then((response) => {
                    if(response.command_got_at <= response.command_set_at){ //New Command
                        if(response.command == "MEASURE|START"){
                            self.simulation.device_1.status = "MEASURING";
                            setTimeout(function(){
                                self.simulation.device_1.status = "SET_CHART";
                            },10000);
                        }else{
                            self.simulation.device_1.logs.unshift({
                                time: moment().format('HH:mm:ss'),
                                api:"getCommand",
                                request:{
                                    equipment_id:"asdfgh"
                                },
                                response:response,
                            });
                            if(response.command == "DISTANCE|INCREASE" || response.command == "DISTANCE|DECREASE"){
                                var value = JSON.stringify({ 
                                        distance: Math.floor(Math.random() * 100)+100
                                    });
                                apiService.setValue("INTERFERENCE", "asdfgh", "device_0", value)
                                .then((response) => {
                                    self.simulation.device_1.logs.unshift({
                                        time: moment().format('HH:mm:ss'),
                                        api:"setValue",
                                        request:{
                                            equipment_id:"asdfgh",
                                            value:value
                                        },
                                        response:response,
                                    });
                                    self.simulation.device_1.status = "WAIT_FOR_COMMAND";
                                });

                            }

                        }

                    }else{
                        self.simulation.device_1.logs.unshift({
                            time: moment().format('HH:mm:ss'),
                            api:"getCommand [IGNORE]",
                            response:response,
                        });

                    }
                });
            }else if(self.simulation.device_1.status == "SET_CHART"){ 
                var rand_0 = Math.floor(Math.random() * 100);
                var rand_1 = Math.floor(Math.random() * 100);
                var rand_2 = Math.floor(Math.random() * 100);
                var rand_3 = Math.floor(Math.random() * 100);
                apiService.setChart("INTERFERENCE", "asdfgh", "device_1", "0,"+rand_0+"|0.1,"+rand_1+"|0.2,"+rand_2+"|0.3,"+rand_3)
                .then((response) => {
                    self.simulation.device_1.logs.unshift({
                        time: moment().format('HH:mm:ss'),
                        api:"setChart",
                        request:{
                            equipment_id:"asdfgh"
                        },
                        response:response,
                    });

                    self.simulation.device_1.status = "WAIT_FOR_COMMAND";

                });
            }else if(self.simulation.device_1.status == "MEASURING"){
                self.simulation.device_1.logs.unshift({
                    time: moment().format('HH:mm:ss'),
                    api:"measuring"
                });
            }

        },
        getValue(device_id, callback){
            console.log("getValue");
            var self = this;
            apiService.getValue("INTERFERENCE", "asdfgh", device_id)
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
            apiService.setCommand("INTERFERENCE", "asdfgh", device_id, command)
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
            self.setCommand('device_1', 'MEASURE|START', function(){
                self.inte = setInterval(function(){
                    self.getValue("device_1",function(){
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
            apiService.getChart("INTERFERENCE", "asdfgh")
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
