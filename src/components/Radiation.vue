<template>
  <div class="radiation">
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
      <v-col xs="12" sm="3">
        <v-card>
          <v-card-title>Controls</v-card-title>
          <v-card-text>
            <v-row no-gutters>
              <v-col cols="12">
                <!-- shutter -->
                <v-radio-group v-model="shutter_status" row dense mandatory>
                  <template v-slot:label>
                    <strong class="ml-4">Shutter Status</strong>
                  </template>
                  <v-radio
                    label="Open"
                    value="open"
                    @click="setCommand('device_0', 'SHUTTER|OPEN')"
                  ></v-radio>
                  <v-radio
                    label="Close"
                    value="close"
                    @click="setCommand('device_0', 'SHUTTER|CLOSE')"
                  ></v-radio>
                </v-radio-group>
                <!-- material -->
                <v-radio-group v-model="material" dense column mandatory>
                  <template v-slot:label>
                    <strong class="ml-4">Cover Material</strong>
                  </template>
                  <v-radio
                    label="1) None"
                    value="1"
                    @click="setCommand('device_0', 'COVER|0')"
                  ></v-radio>
                  <v-radio
                    label="2) Plastic 1mm"
                    value="2"
                    @click="setCommand('device_0', 'COVER|1')"
                  ></v-radio>
                  <v-radio
                    label="3) Plastic 2mm"
                    value="3"
                    @click="setCommand('device_0', 'COVER|2')"
                  ></v-radio>
                  <v-radio
                    label="4) Plastic 3mm"
                    value="4"
                    @click="setCommand('device_0', 'COVER|3')"
                  ></v-radio>
                  <v-radio
                    label="5) Aluminium 1mm"
                    value="5"
                    @click="setCommand('device_0', 'COVER|4')"
                  ></v-radio>
                  <v-radio
                    label="6) Aluminium 2mm"
                    value="6"
                    @click="setCommand('device_0', 'COVER|5')"
                  ></v-radio>
                  <v-radio
                    label="7) Aluminium 3mm"
                    value="7"
                    @click="setCommand('device_0', 'COVER|6')"
                  ></v-radio>
                  <v-radio
                    label="8) Lead 0.3mm"
                    value="8"
                    @click="setCommand('device_0', 'COVER|7')"
                  ></v-radio>
                  <v-radio
                    label="9) Lead 0.6mm"
                    value="9"
                    @click="setCommand('device_0', 'COVER|8')"
                  ></v-radio>
                  <v-radio
                    label="10) Lead 2mm"
                    value="10"
                    @click="setCommand('device_0', 'COVER|9')"
                  ></v-radio>
                </v-radio-group>
                <!-- distance D -->
                <v-subheader> 
                  <strong>Distance D = {{ distance }}mm</strong> </v-subheader>
                <v-btn-toggle>
                  <v-btn
                    @click="
                      setCommand('device_0', 'DISTANCE|INCREASE');
                      device_flag='device_0';
                    "
                  >
                    Increase
                  </v-btn>
                  <v-btn
                    @click="
                      setCommand('device_0', 'DISTANCE|DECREASE');
                      device_flag='device_0';
                    "
                  >
                    Decrease
                  </v-btn>
                </v-btn-toggle>
                <!-- points of average -->
                <v-subheader> 
                  <strong>Points of average</strong> </v-subheader>
                <v-slider
                    class="mt-4"
                    step="5"
                    min="5"
                    max="30"
                    v-model="points_of_average"
                    thumb-label="always"
                    @change="setCommand('device_0', 'POINTS|' + points_of_average)"
                ></v-slider>
                <div class="d-flex justify-end">
                <v-btn class="ma-6" @click="startMeasure"
                  >Measure</v-btn
                >
                </div>
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
      <v-col cols="5">
        <v-card>
            <v-card-title>Result</v-card-title>
            <v-card-text>
                <apexchart
                 ref="realtimeChart"
                  type="line"
                  :options="options"
                  :series="series"
                  class="ma-4"
                ></apexchart>
                <v-data-table
                    :headers="headers"
                    :items="api.records"
                    class="elevation-1"
                >
                    <template v-slot:top>

                        <v-dialog v-model="dialogDelete" max-width="500px">
                        <v-card>
                            <v-card-title class="headline">Are you sure you want to delete this data point?</v-card-title>
                            <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                            <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                            <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                        </v-dialog>
                    </template>
                    <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        @click="deleteDataPoint(item)"
                    >
                        mdi-delete
                    </v-icon>
                    </template>
                </v-data-table>
                <div class="d-flex justify-end">
                  <download-csv
                    class="btn"
                    :data="api.records"
                    name="radiation.csv"
                  >
                    Download
                  </download-csv>
                </div>
            </v-card-text>
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
  name: "radiation",
  components: {
    CameraDialog,
  },
  mixins: [ExperimentBasic],
  data: function () {
    return {
      inte: null,
      shutter_status: "open",
      material:'0',
      points_of_average: 0,
      distance:0,
      device_flag:'idle',
      loading: false,
      api: {
        value: "",
        value_got_at: null,
        value_set_at: null,
        camera_0: "",
        camera_1: "",
        chart:[],
        records:[]
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
            type: 'numeric'
        },
      },
      series: [
        {
          data: [
          ],
        },
      ],

      dialog: false,
      dialogDelete: false,
      editedIndex: -1,
      headers: [
        { text: 'Distance', value: 'distance' },
        { text: 'Material', value: 'material' },
        { text: 'Shutter', value: 'shutter' },
        { text: 'Points of Average', value: 'points_of_average' },
        { text: 'Reading', value: 'reading' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
    };
  },
  mounted: function () {
    var self = this;
    self.experiment_name = "RADIATION";
    self.getValue("camera_0", function () {
      self.api.camera_0 = self.api.value;
      self.getValue("camera_1", function () {
        self.api.camera_1 = self.api.value;
        self.getValue("device_0", function () {
              self.updateValues();
              self.device_flag = 'idle';
        });
      });
    });
    setInterval(function () {
      //loop distance value
      if (self.device_flag == 'idle') {
      }else if (self.device_flag == 'device_0') {
        self.getValue("device_0", function () {
          if (self.api.value_set_at >= self.api.value_got_at) {
              self.updateValues();
              self.device_flag = 'idle';
          }
        });
      }else{    //get chart
        self.getValue("device_1", function () {
          if (self.api.value_set_at >= self.api.value_got_at) {
              self.series[0].data.push({
                  x:self.distance,
                  y:self.api.value.reading
              });
              console.log(self.series);
              self.$refs.realtimeChart.updateSeries([{
                    data: self.series[0].data
                }], false, true);
              self.api.records.push({
                    distance: self.distance,
                    material: self.material,
                    shutter: self.shutter_status,
                    points_of_average: self.points_of_average,
                    reading: self.api.value.reading    
              });
              self.device_flag = 'idle';
                self.loading = false;
          }
        });
      }
    }, 2000);
  },
  methods: {
      startMeasure(){
        this.setCommand('device_1', 'MEASURE|0');
        this.device_flag = 'device_1';
        this.loading = true;
      },
      updateValues(){
          var self = this;
        self.shutter_status = self.api.value.shutter;
        self.material = self.api.value.cover;
        self.points_of_average = self.api.value.points_of_average;
        self.distance = self.api.value.distance;

      },
      deleteDataPoint (item) {
        this.editedIndex = this.api.records.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.api.records.splice(this.editedIndex, 1)
        this.series[0].data.splice(this.editedIndex, 1)
        this.$refs.realtimeChart.updateSeries([{
            data: this.series[0].data
        }], false, true);
        this.closeDelete()
      },
      closeDelete () {
        this.dialogDelete = false
      },
      exportData(){

      },

  },
};
</script>
