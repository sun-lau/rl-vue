<template>
  <div class="green_house">
    <v-row>
      <v-col xs="12" sm="6">
        <v-card>
          <v-card-text>
            <v-img
              class="clickable"
              :src="api.camera_0"
              @click="popCamera(api.camera_0)"
            >
              <template v-slot:default> Camera 1 </template>
            </v-img>
          </v-card-text>
        </v-card>
        <v-card>
            <v-card-title>Real-time Values</v-card-title>
            <v-card-text>
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
            </v-card-text>
        </v-card>
      </v-col>
      <v-col xs="12" sm="6">
        <v-card>
          <v-card-text>
            <v-row no-gutters>
              <v-col cols="6">
                <!-- flush -->
                <v-radio-group v-model="air_status" dense row>
                  <template v-slot:label>
                    <strong>Flush</strong>
                  </template>
                  <v-radio label="Off" :value="0" @click="setCommand('device_0', 'AIR|OFF')"></v-radio>
                  <v-radio label="On" :value="1" @click="setCommand('device_0', 'AIR|ON')"></v-radio>
                </v-radio-group>
                <!-- sun -->
                <v-radio-group v-model="light_status" dense row>
                  <template v-slot:label>
                    <strong>Sun</strong>
                  </template>
                  <v-radio label="Off" :value="0" @click="setCommand('device_0', 'LIGHT|OFF')"></v-radio>
                  <v-radio label="On" :value="1" @click="setCommand('device_0', 'LIGHT|ON')"></v-radio>
                </v-radio-group>
              </v-col>
              <v-col cols="6">
                <div class="mt-4">
                  <strong>CO2 Pulse</strong>
                  <br>
                <v-btn class="my-2" @click="setCommand('device_0', 'CO2|ON')">
                  Add CO2
                </v-btn>
                </div>
              </v-col>  
            </v-row>
            <v-btn
              v-if="!is_capturing"
              class="mx-4"
              @click="startCapture"
            >
              Start Capture
            </v-btn>
            <v-btn v-if="is_capturing" class="mx-4" @click="stopCapture">
              Stop Capture
            </v-btn>

            <v-btn class="mx-4">
              <download-csv :data="stored_data" name="green_house.csv">
                Export
              </download-csv>
            </v-btn>
            <v-btn class="mx-4" @click="clearCapture" color="error">
              Clear Capture
            </v-btn>
          </v-card-text>
        </v-card>
        <v-card>
          <v-card-title>Measure Result</v-card-title>
          <apexchart
            type="line"
            :options="options"
            :series="series"
            ref="realtimeChart"
          ></apexchart>
        </v-card>
      </v-col>
    </v-row>
    <CameraDialog v-model="camera_dialog" :camera="camera_dialog_camera" />
  </div>
</template>

<script>
// @ is an alias to /src
import CameraDialog from "@/components/CameraDialog.vue";
import ExperimentBasic from "@/services/ExperimentBasic";
import { Experiment_APIService } from "@/services/Experiment_APIService";
const apiService = new Experiment_APIService(process.env.VUE_APP_BASE_URL);
export default {
  name: "GreenHouse",
  components: {
    CameraDialog,
  },
  mixins: [ExperimentBasic],
  data: function () {
    return {
      inte: null,
      stored_data: [["Time", "Set 1 Temperature", "Set 2 Temperature"]],
      is_capturing: false,
      timer: 0,
      loop_interval: 5000,
      laser_show: false,
      gain_show: false,
      step_show: false,
      air_status: "off",
      light_status: "off",
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
            },
          },
        },
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
            x: self.timer,
            y: self.api.value.temperature_0,
          });
          self.series[1].data.push({
            x: self.timer,
            y: self.api.value.temperature_1,
          });
          self.stored_data.push([
            self.timer,
            self.api.value.temperature_0,
            self.api.value.temperature_1,
          ]);
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
    stopCapture: function () {
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
        self.stored_data = [["Time", "Set 1 Temperature", "Set 2 Temperature"]];
        self.timer = 0;
        self.$refs.realtimeChart.updateSeries(self.series, false, true);
      }
    },
  },
};
</script>
