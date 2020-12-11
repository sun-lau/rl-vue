<template>
  <div class="em_induction">
    <v-row>
      <v-col xs="12" sm="5">
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
      </v-col>
      <v-col xs="12" sm="7">
        <v-card>
          <v-card-title>Controls</v-card-title>
          <v-card-text>
            <v-row no-gutters>
              <v-col cols="6">
                <!-- magnet -->
                <v-radio-group v-model="magnet" row dense>
                  <template v-slot:label>
                    <strong>Magnet Thickness</strong>
                  </template>
                  <v-radio
                    label="2mm"
                    value="1"
                    @click="setCommand('device_0', 'MAGNET|1')"
                  ></v-radio>
                  <v-radio
                    label="3mm"
                    value="2"
                    @click="setCommand('device_0', 'MAGNET|2')"
                  ></v-radio>
                  <v-radio
                    label="5mm"
                    value="3"
                    @click="setCommand('device_0', 'MAGNET|3')"
                  ></v-radio>
                </v-radio-group>
              </v-col>
              <v-col cols="6">
                <!-- rotation speed -->
                <v-radio-group v-model="speed" row dense>
                  <template v-slot:label>
                    <strong>Rotation Speed</strong>
                  </template>
                  <v-radio
                    label="1 Hz"
                    value="1"
                    @click="setCommand('device_0', 'SPEED|1')"
                  ></v-radio>
                  <v-radio
                    label="2 Hz"
                    value="2"
                    @click="setCommand('device_0', 'SPEED|2')"
                  ></v-radio>
                  <v-radio
                    label="5 Hz"
                    value="3"
                    @click="setCommand('device_0', 'SPEED|3')"
                  ></v-radio>
                </v-radio-group>
              </v-col>
            </v-row>
            <v-row no-gutters>
              <v-col>
                <!-- magnet -->
                <v-radio-group v-model="coil" row dense>
                  <template v-slot:label>
                    <strong>Coil Turns</strong>
                  </template>
                  <v-radio
                    label="50 turns"
                    value="1"
                    @click="setCommand('device_0', 'COIL|1')"
                  ></v-radio>
                  <v-radio
                    label="150 turns"
                    value="2"
                    @click="setCommand('device_0', 'COIL|2')"
                  ></v-radio>
                  <v-radio
                    label="200 turns"
                    value="3"
                    @click="setCommand('device_0', 'COIL|3')"
                  ></v-radio>
                </v-radio-group>
                <v-btn class="mt-2" block @click="requestChart('device_0')">
                  Measure
                  </v-btn>
              </v-col>
            </v-row>
          </v-card-text>
          <v-overlay absolute :value="loading">
            <v-btn color="info">
              Measuring

              <v-progress-circular
                indeterminate
                size="12"
                class="ma-4"
              ></v-progress-circular>
            </v-btn>
          </v-overlay>
        </v-card>
        <v-card class="mt-1">
          <v-card-title>Measure Result</v-card-title>
          <v-row>
            <v-col offset="2" cols="8">
              <apexchart
                type="line"
                :options="options"
                :series="series"
              ></apexchart>
            </v-col>
          </v-row>
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
  name: "EmInduction",
  components: {
    CameraDialog,
  },
  mixins: [ExperimentBasic],
  data: function () {
    return {
      inte: null,
      magnet: "1",
      coil: "1",
      speed: "1",
      loading: false,
      api: {
        value: "",
        value_got_at: null,
        value_set_at: null,
        camera_0: "",
      },
      options: {
        width: "100%",
        stroke: {
          width: 1,
        },
        yaxis: {
          title: {
            text: "Voltage (mV)",
          },
        },
        xaxis: {
          title: {
            text: "Time (ms)",
          },
        },
      },
      series: [
        {
          data: [],
        },
      ],
      loop_flag: false,
    };
  },
  mounted: function () {
    var self = this;
    self.experiment_name = "EM_INDUCTION";
    // self.setCommand("device_0","RESTART|1");
    // self.setCommand("device_0","RESTART|1");
    self.getValue("camera_0", function () {
      self.api.camera_0 = self.api.value.url;
    });
    // self.loading = true;
    // setTimeout(function(){
    //     self.loading = false;
    // },5000);
    self.getValue("device_0");
    setInterval(function () {
      //loop distance value
      if (self.loop_flag) {
        self.getValue("device_0", function () {
          if (self.api.value_set_at >= self.api.value_got_at) {
            self.loop_flag = false;
          }
        });
      }
    }, 1000);
  },
  methods: {
  },
};
</script>
