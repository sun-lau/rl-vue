<template>
  <div class="interference">
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
                <!-- laser -->
                <v-radio-group v-model="laser_status" row dense>
                  <template v-slot:label>
                    <strong class="ml-4">Laser Status</strong>
                  </template>
                  <v-radio
                    label="Red"
                    value="red"
                    @click="setCommand('device_0', 'LASER|RED')"
                  ></v-radio>
                  <v-radio
                    label="Green"
                    value="green"
                    @click="setCommand('device_0', 'LASER|GREEN')"
                  ></v-radio>
                </v-radio-group>
                <!-- slit position -->
                <v-subheader> 
                  <strong>Slit Position</strong>
                  </v-subheader>
                <v-btn-toggle>
                  <v-btn @click="setCommand('device_0', 'SLIT|LEFT')">
                    Left
                  </v-btn>
                  <v-btn @click="setCommand('device_0', 'SLIT|RIGHT')">
                    Right
                  </v-btn>
                </v-btn-toggle>
                <!-- step size -->
                <v-radio-group v-model="step_status" row dense>
                  <template v-slot:label>
                    <strong class="ml-4">Step Size</strong>
                  </template>
                  <v-radio
                    label="Small"
                    value="small"
                    @click="setCommand('device_0', 'STEP|SMALL')"
                  ></v-radio>
                  <v-radio
                    label="Large"
                    value="large"
                    @click="setCommand('device_0', 'STEP|LARGE')"
                  ></v-radio>
                </v-radio-group>
                <!-- distance D -->
                <v-subheader> 
                  <strong>Distance D = {{ api.value.distance }}mm</strong> </v-subheader>
                <v-btn-toggle>
                  <v-btn
                    @click="
                      setCommand('device_0', 'DISTANCE|INCREASE');
                      loop_flag = true;
                    "
                  >
                    Increase
                  </v-btn>
                  <v-btn
                    @click="
                      setCommand('device_0', 'DISTANCE|DECREASE');
                      loop_flag = true;
                    "
                  >
                    Decrease
                  </v-btn>
                </v-btn-toggle>
               
              </v-col>
              <v-col cols="7">
                <!-- power -->
                <v-subheader> 
                  <strong>Laser Power</strong> </v-subheader>
                <v-slider
                  class="mt-4"
                  v-model="power"
                  thumb-label="always"
                  @change="setCommand('device_0', 'POWER|' + power)"
                ></v-slider>
                <div class="d-flex justify-end">
                <v-btn class="ma-6" @click="requestChart('device_1')"
                  >Measure</v-btn
                >
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
    <v-row>
      <v-col cols="12">
        <v-card>
          <v-simple-table>
            <template v-slot:default>
              <tbody>
                <tr>
                  <td>Slit Number (From Right to Left)</td>
                  <td>1</td>
                  <td>2</td>
                  <td>3</td>
                  <td>4</td>
                  <td>5</td>
                  <td>6</td>
                  <td>7</td>
                  <td>8</td>
                  <td>9</td>
                </tr>
                <tr>
                  <td>Type</td>
                  <td>Single</td>
                  <td>Double</td>
                  <td>Double</td>
                  <td>Double</td>
                  <td>Double</td>
                  <td>Double</td>
                  <td>Triple</td>
                  <td>Quadruple</td>
                  <td>Quadruple</td>
                </tr>
                <tr>
                  <td>Width a/mm</td>
                  <td>0.04</td>
                  <td>0.04</td>
                  <td>0.04</td>
                  <td>0.04</td>
                  <td>0.08</td>
                  <td>0.08</td>
                  <td>0.04</td>
                  <td>0.04</td>
                  <td>0.04</td>
                </tr>
                <tr>
                  <td>Separation d/mm</td>
                  <td>0</td>
                  <td>0.5</td>
                  <td>0.25</td>
                  <td>0.125</td>
                  <td>0.5</td>
                  <td>0.25</td>
                  <td>0.5</td>
                  <td>0.125</td>
                  <td>0.125</td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
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
  name: "interference",
  components: {
    CameraDialog,
  },
  mixins: [ExperimentBasic],
  data: function () {
    return {
      inte: null,
      laser_status: "red",
      step_status: "small",
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
            text: "Intensity (arbitrary unit)",
          },
        },
        xaxis: {
          title: {
            text: "Distance (mm)",
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
    self.experiment_name = "INTERFERENCE";
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
  methods: {},
};
</script>
