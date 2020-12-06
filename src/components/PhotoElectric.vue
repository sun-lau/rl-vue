<template>
  <div class="photoelectric">
    <v-row>
      <v-col xs="12" sm="4">
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
            <v-img
              class="clickable"
              :src="api.camera_1"
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
            <v-row>
              <v-col cols="6">
                <!-- phototube -->
                <v-radio-group v-model="currentMaterial" row dense>
                <template v-slot:label>
                    <strong>Phototube</strong>
                </template>
                <v-radio label="Violet" value="0" @click="setCommand('device_0', 'PTUBE|0')"></v-radio>
                <v-radio label="Blue" value="1" @click="setCommand('device_0', 'PTUBE|1')"></v-radio>
                <v-radio label="Blue-Green" value="2" @click="setCommand('device_0', 'PTUBE|2')"></v-radio>
                <v-radio label="Green" value="3" @click="setCommand('device_0', 'PTUBE|3')"></v-radio>
                </v-radio-group>

                <!-- slit position -->
                <v-row>
                  <v-col cols="4">
                    <v-subheader> Slit Position </v-subheader>
                  </v-col>
                  <v-col>
                    <v-btn-toggle>
                      <v-btn @click="setCommand('device_0', 'SLIT|LEFT')">
                        Left
                      </v-btn>
                      <v-btn @click="setCommand('device_0', 'SLIT|RIGHT')">
                        Right
                      </v-btn>
                    </v-btn-toggle>
                  </v-col>
                </v-row>
                <!-- step size -->
                <v-row>
                  <v-col cols="4">
                    <v-subheader> Step Size </v-subheader>
                  </v-col>
                  <v-col>
                    <v-btn-toggle v-model="step_status" mandatory>
                      <v-btn
                        @click="setCommand('device_0', 'STEP|SMALL')"
                        value="red"
                      >
                        Small
                      </v-btn>
                      <v-btn
                        @click="setCommand('device_0', 'STEP|LARGE')"
                        value="green"
                      >
                        Large
                      </v-btn>
                    </v-btn-toggle>
                  </v-col>
                </v-row>
                
                <!-- distance D -->
                <v-row>
                  <v-col cols="4">
                    <v-subheader> Distance D </v-subheader>
                  </v-col>
                  <v-col cols="8">
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
                    <br />
                    <strong class="ma-4">D = {{ api.value.distance }}mm</strong>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col>
                    <v-btn class="ma-6" block @click="requestChart('device_1')">Measure</v-btn>
                  </v-col>
                </v-row>
              </v-col>
              <v-col cols="6">

                <!-- power -->
                <v-row>
                  <v-col cols="4">
                    <v-subheader> Laser Power </v-subheader>
                  </v-col>
                  <v-col>
                    <v-slider
                      class="mt-4"
                      v-model="power"
                      thumb-label="always"
                      @change="setCommand('device_0', 'POWER|' + power)"
                    ></v-slider>
                  </v-col>
                </v-row>
                <v-row>
                  <v-card outlined>
                    <v-card-title>Measure Result</v-card-title>
                    <v-card-text
                      ><apexchart
                        type="line"
                        :options="options"
                        :series="series"
                        class="ma-4"
                      ></apexchart
                    ></v-card-text>
                  </v-card>
                </v-row>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="6"> </v-col>
              <v-col cols="6"> </v-col>
            </v-row>
            <v-row>
              <v-col cols="6"> </v-col>
              <v-col cols="6"> </v-col>
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
    <CameraDialog v-model="camera_dialog" :src="camera_dialog_src" />
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
      phototube: "red",
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
      self.api.camera_0 = self.api.value.url;
      self.getValue("camera_1", function () {
        self.api.camera_1 = self.api.value.url;
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
