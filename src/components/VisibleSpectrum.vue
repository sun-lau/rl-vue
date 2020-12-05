<template>
  <div class="visible_spectrum">
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
        <v-card>
          <v-card-text>
            <!-- material -->
            <v-radio-group v-model="currentMaterial" row dense>
              <template v-slot:label>
                <strong>Material</strong>
              </template>
              <v-radio label="1" value="set_0"></v-radio>
              <v-radio label="2" value="set_1"></v-radio>
            </v-radio-group>
            <!-- magnet -->
            <v-radio-group v-model="source_status" row dense>
              <template v-slot:label>
                <strong>Light Source</strong>
              </template>
              <v-radio
                label="Off"
                value="off"
                @click="setCommand('device_0', 'SOURCE|OFF')"
              ></v-radio>
              <v-radio
                label="White LED"
                value="white"
                @click="setCommand('device_0', 'SOURCE|WHITE')"
              ></v-radio>
              <v-radio
                label="Blue LED"
                value="blue"
                @click="setCommand('device_0', 'SOURCE|BLUE')"
              ></v-radio>
              <v-radio
                label="Green LED"
                value="green"
                @click="setCommand('device_0', 'SOURCE|GREEN')"
              ></v-radio>
              <v-radio
                label="Red LED"
                value="red"
                @click="setCommand('device_0', 'SOURCE|RED')"
              ></v-radio>
              <v-radio
                label="Sodium Lamp"
                value="sodium"
                @click="setCommand('device_0', 'SOURCE|SODIUM')"
              ></v-radio>
              <v-radio
                label="Mercury Lamp"
                value="mercury"
                @click="setCommand('device_0', 'SOURCE|MERCURY')"
              ></v-radio>
            </v-radio-group>
            <div class="d-flex justify-end">
            <v-btn class="mx-2" @click="requestChart('device_0')">Measure</v-btn>
            <download-csv :data="api.chart">
              <v-btn class="mx-2">Download</v-btn>
            </download-csv>
            </div>
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

          </v-card-text>
        </v-card>
      </v-col>
      <v-col xs="12" sm="7">
        <v-card>
          <v-card-title>Spectrum</v-card-title>
          <v-card-text>
          <apexchart
            type="line"
            :options="options"
            :series="series"
          ></apexchart>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <CameraDialog v-model="camera_dialog" :src="camera_dialog_src" />

    <!-- Confirm Dialog -->
    <v-dialog v-model="confirmDialog" width="600" persistent>
      <v-card>
        <v-card-title class="headline grey lighten-2">
          Switch Material
        </v-card-title>
        <v-card-text>
          <v-alert class="mt-4" type="error"
            >Switching Material will cause measured result lost. Please download
            the result before switching.
          </v-alert>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="switchRoom"> Confirm</v-btn>
          <v-btn color="primary" text @click="cancelSwitchRoom"> Cancel</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
// @ is an alias to /src

import CameraDialog from "@/components/CameraDialog.vue";
import ExperimentBasic from "@/services/ExperimentBasic";
import { Experiment_APIService } from "@/services/Experiment_APIService";
const apiService = new Experiment_APIService(process.env.VUE_APP_BASE_URL);
export default {
  name: "VisibleSpectrum",
  components: {
    CameraDialog,
  },
  mixins: [ExperimentBasic],
  data: function () {
    return {
      inte: null,
      source_status: 'off',
      loading: false,
      confirmDialog: false,
      targetRoom: 0,
      currentMaterial: '',
      api: {
        value: "",
        value_got_at: null,
        value_set_at: null,
        chart: [
          {
            x: 0,
            y: 0,
          },
        ],
        camera_0: "",
      },
      options: {
        width: "100%",
        stroke: {
          width: 1,
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
        },
      },
      series: [
        {
          data: [],
        },
      ],
    };
  },
  mounted: function () {
    var self = this;
    self.experiment_name = "VISIBLE_SPECTRUM";
    this.currentMaterial = this.$cookies.get("equipment_id");
    // self.setCommand("device_0","RESTART|1");
    self.getValue("camera_0", function () {
      self.api.camera_0 = self.api.value.url;
    });
    // self.loading = true;
    // setTimeout(function(){
    //     self.loading = false;
    // },5000);
  },
  watch: {
    currentMaterial: {
      handler(newValue, oldValue) {
        if (oldValue != "") {
          if (newValue != this.$cookies.get("equipment_id")) {
            this.trySwitchMaterial();
          }
        }
      },
    },
  },
  methods: {
    trySwitchMaterial() {
      this.confirmDialog = true;
    },
    switchRoom() {
      this.$cookies.set("equipment_id", this.currentMaterial);
      this.$cookies.set("session_token", "super");
      this.$router.go();
    },
    cancelSwitchRoom() {
      this.confirmDialog = false;
      this.currentMaterial = this.$cookies.get("equipment_id");
    },
  },
};
</script>
