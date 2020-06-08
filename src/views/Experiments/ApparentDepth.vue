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
                                src="http://158.132.254.155:8081/?action=stream"
                                fluid
                            />
                            </v-col>
                            <v-col xs="12" sm="6">
                            <b-img 
                                src="http://158.132.254.164:8081/?action=stream"
                                fluid
                            />
                            </v-col>
                        </v-row>
                    </v-card>
                    <br>
                    <v-card>
                        <v-card-title>Measurment</v-card-title>
                        <v-simple-table>
                            <template v-slot:default>
                            <thead>
                                <tr>
                                <th class="text-left">Horizontal</th>
                                <th class="text-left">Vertical Measure Point</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Position A</td>
                                    <td>{{measurment[0].vertical_position}}mm</td>
                                </tr>
                                <tr>
                                    <td>Position B</td>
                                    <td>{{measurment[1].vertical_position}}mm</td>
                                </tr>
                                <tr>
                                    <td>Position C</td>
                                    <td>{{measurment[2].vertical_position}}mm</td>
                                </tr>
                            </tbody>
                            </template>
                        </v-simple-table>
                        <v-btn class="ma-4" @click="measure">
                            Measure
                        </v-btn>
                        <v-btn class="ma-4">
                        <download-csv
                            class   = "btn btn-default"
                            :data   = "measurment"
                            name    = "apparent_depth.csv">
                            Download
                        </download-csv>
                        </v-btn>
                        <br>

                    </v-card>
                </v-col>
                <v-col xs="12" sm="6">
                    <v-card>
                        <v-card-title>Control</v-card-title>
                        <v-card-title>Horizontal:</v-card-title>
                        <v-card-actions class="ml-4">
                            <v-chip-group
                                v-model="current.horizontal_position"
                                active-class="deep-purple accent-4 white--text"
                                column
                                class="ma-4"
                            >
                                <v-chip 
                                    @click="setHorizontal(0)"
                                    :disabled="false"
                                >Position A</v-chip>
                                <v-chip 
                                    @click="setHorizontal(1)"
                                    :disabled="map[current.vertical_position][1]==0"
                                >Position B</v-chip>
                                <v-chip 
                                    @click="setHorizontal(2)"
                                    :disabled="map[current.vertical_position][2]==0"
                                >Position C</v-chip>
                            </v-chip-group>
                            <v-spacer></v-spacer>
                        </v-card-actions>

                    </v-card>
                    <v-card>

                        <v-card-title>Vertical: {{current.vertical_position}}mm</v-card-title>
                        <v-btn-toggle
                            rounded
                            class="ml-4">
                            <v-btn 
                                @click="setVertical('down')" 
                                :disabled="current.vertical_position==0"
                            >
                                <font-awesome-icon icon="angle-down" /> 
                                Down
                            </v-btn>
                            <v-btn 
                            
                                @click="setVertical('up')" 
                                :disabled="current.vertical_position==map.length-1"

                            >
                                <font-awesome-icon icon="angle-up" /> 
                                Up
                            </v-btn>
                        </v-btn-toggle>
                        <br>
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

		<v-btn
		absolute
		dark
		top
		right
		color="green"
		class="mt-4"
		>
            <v-icon>mdi-clock</v-icon> {{parseInt(kick_time/60)}} mins left
		</v-btn>
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
            inte:null,
            loading: false,
            map:[
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,0,0],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1],
                [1,1,1]
            ],
            current:{
                horizontal_position:0,
                vertical_position:0
            },
            measurment:[
                {
                horizontal_position:'A',
                vertical_position:0
                },
                
                {
                horizontal_position:'B',
                vertical_position:0
                },
                
                {
                horizontal_position:'C',
                vertical_position:0
                }
                
            ],
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
                }
            },
            simluate_0_mode: false,
            kick_time: 3600

      }
  },
  computed: {
      checkDisabled:function(v,h){
          
      }
  },
  mounted: function(){
        var self = this;
        console.log("mounted");
        
        self.setCommand("device_0","RESTART|1");

        setInterval(function(){ //hard protect
            location.reload();
        },1000*60*60);
        self.kick_time = self.$cookies.get('kick_time');
        setInterval(function(){ //countdown protect
            self.kick_time = self.kick_time -1;
            if(self.kick_time < 0){
                window.location.href = process.env.VUE_APP_BASE_URL;
            }
        },1000);
  },
  methods:{
        simulate_device_0(){
            var self = this;
            if(self.simulation.device_0.status == "WAIT_FOR_COMMAND"){
                apiService.getCommand("APPARENT_DEPTH", "zxcvbn", "device_0")
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
        getValue(device_id, callback){
            console.log("getValue");
            var self = this;
            apiService.getValue("APPARENT_DEPTH", "zxcvbn", device_id)
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
            apiService.setCommand("APPARENT_DEPTH", "zxcvbn", device_id, command)
            .then((response) => {
                console.log("command is set");
                console.log("response");
                console.log(response);
                if(callback){
                    callback();
                }
            });
        },
        setHorizontal(h){
            var self = this;
            if(self.isAllowedToMoveHorizontal(h)){
                console.log("here");
                console.log(h);
                self.current.horizontal_position = h;
                self.setCommand("device_0","POSITION_MAP|"+self.current.horizontal_position+","+self.current.vertical_position);
            }else{
                alert("Limit");
            }
        },
        setVertical(direction){
            var self = this;
            if(direction == "down"){
                if(self.isAllowedToMoveUp()){
                    self.current.vertical_position -= 1;
                    self.setCommand("device_0","POSITION_MAP|"+self.current.horizontal_position+","+self.current.vertical_position);
                }else{
                    alert("Limit");
                }
            }else{
                if(self.isAllowedToMoveDown()){
                    self.current.vertical_position += 1;
                    self.setCommand("device_0","POSITION_MAP|"+self.current.horizontal_position+","+self.current.vertical_position);
                }else{
                    alert("Limit");
                }
            }
        },
        isAllowedToMoveUp(){
            var self = this;
            if(self.current.vertical_position-1 < 0){
                return false;
            }
            if(self.map[self.current.vertical_position-1][self.current.horizontal_position]==0){
                return false;
            }
            return true;
        },
        isAllowedToMoveDown(){
            var self = this;
            if(self.current.vertical_position+1 > self.map.length-1){
                return false;
            }
            if(self.map[self.current.vertical_position+1][self.current.horizontal_position]==0){
                return false;
            }
            return true;
        },
        isAllowedToMoveHorizontal(h){
            var self = this;
            console.log("isAllowedToMoveHorizontal");
            console.log(self.current);
            console.log("what");
            console.log(self.current.vertical_position);
            if(self.map[self.current.vertical_position][h]==1){
                return true;
            }else{
                return false;
            }
        },
        measure(){
            var self = this;
            self.measurment[self.current.horizontal_position].vertical_position = self.current.vertical_position;

        }
  }
}
</script>
