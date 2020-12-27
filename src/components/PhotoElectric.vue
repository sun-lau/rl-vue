<template>
  <div class="photo_electric">
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
            <v-row no-gutters>
              <v-col cols="5">
                <!-- control -->
                <v-radio-group v-model="control_status" dense mandatory>
                <template v-slot:label>
                    <strong>Control</strong>
                </template>
                <v-radio label="Phototube" value="PTUBE" @click="switchLight" ></v-radio>
                <v-radio label="Sensor" value="SENSOR" @click="switchLight" ></v-radio>
                </v-radio-group>
                <!-- Color -->
                <v-radio-group v-model="light_status" dense mandatory>
                <template v-slot:label>
                    <strong>Light</strong>
                </template>
                <v-radio label="Violet" value="0" @click="switchLight"></v-radio>
                <v-radio label="Blue" value="1" @click="switchLight"></v-radio>
                <v-radio label="Blue-Green" value="2" @click="switchLight"></v-radio>
                <v-radio label="Green" value="3" @click="switchLight"></v-radio>
                </v-radio-group>
                <!-- power -->
                <v-subheader> 
                  <strong>Light Power</strong> </v-subheader>
                <v-slider
                  class="mt-4"
                  v-model="power"
                  thumb-label="always"
                  @change="setCommand('device_0', 'POWER|' + power)"
                ></v-slider>
               
              </v-col>
              <v-col cols="7">
                <v-btn class="ma-6" @click="requestChart('device_1')"
                  >Measure</v-btn
                >
                <v-subheader> 
                  <strong>Intensity</strong> </v-subheader>
                  <p class="ml-4">{{ api.value.intensity }}</p>
                <div class="d-flex justify-end">
                </div>
                <apexchart
                  type="line"
                  :options="options"
                  :series="series"
                  class="ma-4"
                ></apexchart>
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
      </v-col>
    </v-row>
    <CameraDialog v-model="camera_dialog" :camera="camera_dialog_camera" />
  </div>
</template>

<script>
import CameraDialog from "@/components/CameraDialog.vue";
import ExperimentBasic from "@/services/ExperimentBasic";
export default {
  name: "photo_electric",
  components: {
    CameraDialog,
  },
  mixins: [ExperimentBasic],
  data: function () {
    return {
      inte: null,
      control_status:'',
      light_status:'',
      power: 0,
      loading: false,
      api: {
        value: "",
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
            text: "Current",
          },
        },
        xaxis: {
          title: {
            text: "Voltage",
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
    self.experiment_name = "PHOTO_ELECTRIC";
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
    switchLight(){
      this.setCommand('device_0', this.control_status+'|'+ this.light_status);
    }
  },
};
</script>
