<template>
  <div class="ultrasound">
    <v-row>
      <v-col xs="12" sm="4">
        <v-card>
          <v-card-text>
            <v-img
              class="clickable"
              :src="api.camera_0.url"
              @click="popCamera(api.camera_0)"
            >
              <template v-slot:default> Camera 1 </template>
            </v-img>
          </v-card-text>
        </v-card>
        <v-card>
          <v-card-text>
            <v-img
              class="clickable"
              :src="api.camera_1.url"
              @click="popCamera(api.camera_1)"
            >
              <template v-slot:default> Camera 2 </template>
            </v-img>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col xs="12" sm="8">
        <v-card>
          <v-card-title>Controls</v-card-title>
          <v-card-text>
            <v-radio-group v-model="currentMaterial" row dense>
                <template v-slot:label>
                </template>
                  <v-radio label="A Scan" value="set_0"></v-radio>
                  <!--v-radio label="B Scan" value="set_1" ></v-radio-->
              </v-radio-group>
            <v-row no-gutters>              
              <v-col cols="10">
                <!-- power -->
                <div v-if="group== 0 ">
                  <v-subheader> 
                    <strong>Transducer Position ({{ this.api.value.position }} mm)</strong> </v-subheader>
                  <div style='display:flex; align-items: center;'>
                    <strong>left</strong>
                    <v-slider
                      class="mt-4"
                      v-model="position"
                      thumb-label="always"
                      max=30
                      slider=position
                      @change="setASCANCommand('device_0', 'POSITION|'+position)"
                    ></v-slider>
                    <!--@change="setASCANCommand('device_0', 'POSITION|'+position)"-->
                    <strong>right</strong>
                  </div>
                  <div class="d-flex justify-end">
                  <v-btn class="ma-6" @click="requestASCAN('device_0')" 
                    >Measure</v-btn
                  >
                  </div>
                  <apexchart
                    type="line"
                    :options="options"
                    :series="series"
                    class="ma-4"
                  ></apexchart>
                </div>
                <div v-else>

                </div>
              </v-col>
            </v-row>
          </v-card-text>
          <v-overlay absolute :value="moving">
            <v-btn color="info">
              Moving

              <v-progress-circular
                indeterminate
                size="12"
                class="ma-4"
              ></v-progress-circular>
            </v-btn>
          </v-overlay>
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
      </v-col>
    </v-row>
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
    <CameraDialog v-model="camera_dialog" :camera="camera_dialog_camera" />
  </div>
</template>

<script>
import CameraDialog from "@/components/CameraDialog.vue";
import ExperimentBasic from "@/services/ExperimentBasic";
export default {
  name: "ultrasound",
  components: {
    CameraDialog,
  },
  mixins: [ExperimentBasic],
  data: function () {
    return {
      group: 0,
      currentMaterial: "",
      inte: null,
      laser_status: "red",
      step_status: "small",
      position: 0,
      moving: false,
      loading: false,
      confirmDialog: false,
      api: {
        value: {
          position: 0,
        },
        value_got_at: null,
        value_set_at: null,
        camera_0: "",
        camera_1: "",
      },
      options: {
        width: "100%",
        stroke: {
          width: 1,
        },

        yaxis: {
          title: {
            text: "Voltage (V)",
          },
        },
        xaxis: {
          title: {
            text: "Time (μs)",
          },
          tickAmount: 5
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
  mounted: function () {
    var self = this;
    self.experiment_name = "ULTRASOUND";
    this.currentMaterial = this.$cookies.get("equipment_id");
    //if(this.currentMaterial == 'set_0' || this.currentMaterial == 'set_1' || this.currentMaterial == 'set_2'){
    if(this.currentMaterial == 'set_0'){
      this.group = 0;
    }else{
      this.group = 1;
    }
    self.getValue("camera_0", function () {
      self.api.camera_0 = self.api.value;
      self.getValue("camera_1", function () {
        self.api.camera_1 = self.api.value;
        self.getValue("device_0");
      });
    });
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
    trySwitchMaterial() {
      this.confirmDialog = true;
    },
    switchRoom() {
      this.$cookies.set("equipment_id", this.currentMaterial);
      alert(this.currentMaterial);
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
