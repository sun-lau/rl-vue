<template>
    <div class="experiment">
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
                                <v-chip @click="setCommand('LASER|OFF')">Off</v-chip>
                                <v-chip @click="setCommand('LASER|RED')">Red</v-chip>
                                <v-chip @click="setCommand('LASER|GREEN')">Green</v-chip>
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
                        <v-card-title>Gain</v-card-title>
                        <v-card-actions class="ml-4">
                            <v-chip-group
                                v-model="gain_status"
                                active-class="deep-purple accent-4 white--text"
                                column
                            >
                                <v-chip @click="setCommand('GAIN|VERY_LOW')">Very Low</v-chip>
                                <v-chip @click="setCommand('GAIN|LOW')">Low</v-chip>
                                <v-chip @click="setCommand('GAIN|HIGH')">High</v-chip>
                                <v-chip @click="setCommand('GAIN|VERY_HIGH')">Very High</v-chip>
                            </v-chip-group>
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
                            <v-btn @click="setCommand('SLIT|LEFT')" >
                                <font-awesome-icon icon="angle-left" /> 
                                Left
                            </v-btn>
                            <v-btn variant="info" @click="setCommand('SLIT|RIGHT')">
                                <font-awesome-icon icon="angle-right" /> 
                                Right
                            </v-btn>
                        </v-btn-toggle>

                        <v-card-title>
                            Distance D 
                        </v-card-title>
                        <v-btn-toggle
                            rounded
                            class="ml-4">
                            <v-btn @click="setCommand('DISTANCE|INCREASE')" >
                                <font-awesome-icon icon="angle-up" />
                                Increase
                            </v-btn>
                            <v-btn variant="info" @click="setCommand('DISTANCE|DECREASE')">
                                <font-awesome-icon icon="angle-down" />
                                Decrease
                            </v-btn>
                        </v-btn-toggle>
                        <small class="ma-4">D = 990mm</small>
                        <br>
                        <br>
                        <div class="ma-4">
                            <v-btn block @click="requestChart()">Measure</v-btn>
                            <br>
                            <v-btn block @click="getValue()">Export</v-btn>
                        </div>
                        <br>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
                <v-col xs="12">
                    <v-card>
                        <v-card-title>Hardware Simulation</v-card-title>
                        <v-card-text>
                            <v-container fluid>
                                <v-row>
                                    <v-col cols="12" md="12">
                                        <p>Current Color: {{simulation.color}}</p>
                                        <p>Current Gain: {{simulation.gain}}</p>
                                        <p>Current Slit Position: {{simulation.slit_position}}</p>
                                        <p>Current Distance: {{simulation.distance}}</p>
                                    </v-col>
                                    <v-col cols="12" md="12">
                                        <v-list two-line subheader>
                                            <v-card v-for="(log, i) of simulation.logs" :key="i" class="ma-4">
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
  name: 'experiment',
  components: {
      LineChart
  },
  data:function(){
      return{
            mode:"WAIT_FOR_COMMAND",
            inte:null,
            laser_show:false,
            gain_show:false,
            laser_status:"",
            gain_status:"",
            loading: false,
            api:{
                value:""
            },
            options: {
                width:'100%'
            },
            series: [{
                data: []
            }],
            simulation:{
                color:"OFF",
                gain:"HIGH",
                slit_position:20,
                distance:30,
                logs:[],
                log:""
            }

      }
  },
  mounted: function(){
        var self = this;
        console.log("mounted");
        setInterval(function(){
            self.simulate();
        },5000);
  },
  methods:{
        simulate(){
            var self = this;
            if(self.mode == "WAIT_FOR_COMMAND"){
                apiService.getCommand()
                .then((response) => {
                    if(response.command == "MEASURE|START"){
                        self.mode = "MEASURING";
                        setTimeout(function(){
                            self.mode = "WAIT_FOR_COMMAND";
                        },10000);
                    }
                    self.simulation.logs.unshift({
                        time: moment().format('HH:mm:ss'),
                        api:"getCommand",
                        request:{
                            equipment_id:"asdfgh"
                        },
                        response:response,
                    });
                });
            }else{
                self.simulation.logs.unshift({
                    time: moment().format('HH:mm:ss'),
                    api:"measuring"
                });
            }

        },
        getValue(callback){
            console.log("getValue");
            var self = this;
            apiService.getValue()
            .then((response) => {
                self.api.value = response.value;
                if(callback){
                    callback();
                }
            });
        },
        setCommand(command, callback){
            apiService.setCommand(command)
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
            self.setCommand('MEASURE|START', function(){
                self.inte = setInterval(function(){
                    self.getValue(function(){
                        if(self.api.value == "complete"){
                            clearInterval(self.inte);
                            self.getChart();
                            self.loading = false;
                        }
                    });
                },2000);
            });
        },
        getChart(){
            console.log("getChart");
            var self = this;
            apiService.getChart()
            .then((response) => {
                self.api.chart = response;
                self.series = [{data:response}];
                console.log("self.series");
                console.log(self.series);
            });

        }
  }
}
</script>
