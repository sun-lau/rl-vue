<template>
  <div class>
    <v-container fluid>
      <v-row>
        <v-col xs="12" sm="6">
          <v-card>
            <v-card-title>Live</v-card-title>
            <v-row class="ma-2">
                <b-img class="ma-2" :src="api.camera_0" fluid-grow />
            </v-row>
          </v-card>
			<v-row>
				<v-col cols="4">
				<v-card>
					<v-card-title>Flush</v-card-title>
					<v-card-actions class="ml-4">
					<v-chip-group
						v-model="air_status"
						active-class="deep-purple accent-4 white--text"
						column
					>
						<v-chip @click="setCommand('device_0', 'AIR|OFF')">Off</v-chip>
						<v-chip @click="setCommand('device_0', 'AIR|ON')">On</v-chip>
					</v-chip-group>
					<v-spacer></v-spacer>
					</v-card-actions>
				</v-card>
				</v-col>
				<v-col cols="4">
				<v-card>
					<v-card-title>Sun</v-card-title>
					<v-card-actions class="ml-4">
					<v-chip-group
						v-model="light_status"
						active-class="deep-purple accent-4 white--text"
						column
					>
						<v-chip @click="setCommand('device_0', 'LIGHT|OFF')"
						>Off</v-chip
						>
						<v-chip @click="setCommand('device_0', 'LIGHT|ON')">On</v-chip>
					</v-chip-group>
					<v-spacer></v-spacer>
					</v-card-actions>
				</v-card>
				</v-col>
				<v-col cols="4">
					<v-card>
						<v-card-title>CO2 Pulse</v-card-title>
						<v-card-actions class="ml-4">
						<v-btn @click="setCommand('device_0', 'CO2|ON')"> Add CO2 </v-btn>
						<v-spacer></v-spacer>
						</v-card-actions>
					</v-card>
				</v-col>
			</v-row>
        </v-col>
		<v-col xs="12" sm="6">
          <v-card>
            <v-card-title>Measure Result</v-card-title>
            <apexchart
              type="line"
              :options="options"
              :series="series"
              ref="realtimeChart"
            ></apexchart>
            <v-card>
              <v-card-actions class="ml-4">
                <v-btn
                  v-if="!is_capturing"
                  class="mb-4"
                  @click="startCapture"
                  color="success"
                >
                  Start Capture
                </v-btn>
                <v-btn
                  v-if="is_capturing"
                  class="mb-4"
                  @click="stopCapture"
                >
                  Stop Capture
                </v-btn>
		
                <v-btn class="mb-4">
				<download-csv
					:data   = "stored_data"
					name    = "green_house.csv">
					Export
				</download-csv>
                </v-btn>
                <v-btn
                  class="mb-4"
                  @click="clearCapture"
                  color="error"
                >
                  Clear Capture
                </v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
			  
				<v-card-title>Real-time Values</v-card-title>
				<v-row class="ml-1 mr-1">
					<v-col xs="4">
						<h6>CO2</h6>
						<h4>{{ api.value.co2_value }} ppm</h4>
					</v-col>
					<v-col xs="4">
						<small>Set 1 (More CO2)</small>
						<h6>Temperature</h6>
						<h4>{{ api.value.temperature_0 }} degC</h4>
					</v-col>
					<v-col xs="4">
						<small>Set 2</small>
						<h6>Temperature</h6>
						<h4>{{ api.value.temperature_1 }} degC</h4>
					</v-col>
				</v-row>
            </v-card>
          </v-card>
		</v-col>
      </v-row>
    </v-container>
    <v-dialog v-model="loading" fullscreen>
      <v-container
        fluid
        fill-height
        style="background-color: rgba(255, 255, 255, 0.5)"
      >
        <v-layout justify-center align-center>
          <v-progress-circular
            indeterminate
            color="primary"
          ></v-progress-circular>
        </v-layout>
      </v-container>
    </v-dialog>
  </div>
</template>

<script>
// @ is an alias to /src

import moment from "moment";
import LineChart from "@/components/LineChart.vue";
import { Experiment_APIService } from "@/services/Experiment_APIService";
const apiService = new Experiment_APIService(process.env.VUE_APP_BASE_URL);
export default {
  name: "GreenHouse",
  components: {
    LineChart,
  },
  data: function () {
    return {
	  inte: null,
	  stored_data:[['Time', 'Set 1 Temperature', 'Set 2 Temperature']],
      is_capturing: false,
      timer: 0,
      loop_interval: 5000,
      laser_show: false,
      gain_show: false,
      laser_show: false,
      step_show: false,
      air_status: "",
      light_status: "",
      step_status: "",
      co2_pulse: 0,
      loading: false,
      api: {
        value: "",
        value_got_at: null,
        value_set_at: null,
        camera_0: "",
      },
      options: {
        
      colors: ["#FF0000", "#0000FF"],
        width: "100%",
        stroke: {
          width: 1,
        },

        yaxis: {
          title: {
            text: "Temperature (°C)",
          },
        },
        xaxis: {
          title: {
            text: "Time (sec)",
          },
		},
		chart: {
      		toolbar: {
				show: false,
        		tools: {
          			zoom: false,
				}
				
			}
		}
      },
      series: [
        {
          name: "Set 1",
          data: [],
        },
        {
          name: "Set 2",
          data: [],
        },
      ],
    };
  },
  mounted: function () {
    var self = this;
    self.experiment_name = "GREEN_HOUSE";
    self.getValue("camera_0", function () {
      self.api.camera_0 = self.api.value.url;
    });
    //get inital setting once only
    self.getValue("device_0", function () {
      console.log("got value");
      console.log(self.api.value);
      self.air_status = self.api.value.air;
      self.light_status = self.api.value.light;
    });

    setInterval(function () {
      self.getValue("device_0", function () {
        if (self.is_capturing) {
          self.series[0].data.push({
            x:self.timer,
            y:self.api.value.temperature_0
          });
          self.series[1].data.push({
            x:self.timer,
            y:self.api.value.temperature_1
          });
          self.stored_data.push([self.timer, self.api.value.temperature_0, self.api.value.temperature_1]);
          self.$refs.realtimeChart.updateSeries(self.series, false, true);
        }
        self.timer = self.timer + self.loop_interval / 1000;
      });
    }, self.loop_interval);
  },
  methods: {
    startCapture: function () {
      var self = this;
      self.is_capturing = true;
      self.timer = 0;
	},
	stopCapture: function(){
      var self = this;
      self.is_capturing = false;

	},
    clearCapture: function () {
      	var self = this;
		var r = confirm("Are you sure to remove all data?");
		if (r == true) {
			self.is_capturing = false;
			self.series[0].data = [];
			self.series[1].data = [];
			self.stored_data = [['Time', 'Set 1 Temperature', 'Set 2 Temperature']];
      self.timer = 0;
      self.$refs.realtimeChart.updateSeries(self.series, false, true);
		}
    },
    exportChart: function () {
      var self = this;
    },
    getValue(device_id, callback) {
      console.log("getValue");
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
          if (response.value) {
            self.api.value = JSON.parse(response.value);
          }
          console.log("self.api.value");
          console.log(self.api.value);
          if (callback) {
            callback();
          }
        });
    },
    setCommand(device_id, command, callback) {
      console.log("set command");
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
        .then((response) => {
          if (callback) {
            callback();
          }
        });
    },
  },
};
</script>
