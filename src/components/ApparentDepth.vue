<template>
  <div class="apparent_depth">
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
      <v-col xs="12" sm="7">
        <v-card>
          <v-card-title>Controls</v-card-title>
          <v-card-text>
            <!-- material -->
            <v-radio-group v-model="currentMaterial" row dense>
              <template v-slot:label>
                <strong>Material</strong>
              </template>
              <v-radio label="1" value="set_0"></v-radio>
              <v-radio label="2" value="set_1"></v-radio>
            </v-radio-group>
            <!-- horizontal -->
            <v-radio-group v-model="current.horizontal_position" row dense>
              <template v-slot:label>
                <strong>Horizontal Position</strong>
              </template>
              <v-radio
                label="A"
                @click="setHorizontal(0)"
                :disabled="false"
              ></v-radio>
              <v-radio
                label="B"
                @click="setHorizontal(1)"
                :disabled="map[current.vertical_position][1] == 0"
              ></v-radio>
              <v-radio
                label="C"
                @click="setHorizontal(2)"
                :disabled="map[current.vertical_position][2] == 0"
              ></v-radio>
            </v-radio-group>
            <!-- vertical -->
            <strong>
              Vertical Position {{ current.vertical_position }}mm
            </strong>
            <br>
            <v-btn-toggle class="mt-1">
              <v-btn
                @click="setVertical('down')"
                :disabled="current.vertical_position == 0"
              >
                Down
              </v-btn>
              <v-btn
                @click="setVertical('up')"
                :disabled="current.vertical_position == map.length - 1"
              >
                Up
              </v-btn>
            </v-btn-toggle>
          </v-card-text>
        </v-card>

        <v-card class="mt-4">
          <v-card-title>Measure Result</v-card-title>
          <v-card-text>
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
                    <td>{{ measurment[0].vertical_position }}mm</td>
                  </tr>
                  <tr>
                    <td>Position B</td>
                    <td>{{ measurment[1].vertical_position }}mm</td>
                  </tr>
                  <tr>
                    <td>Position C</td>
                    <td>{{ measurment[2].vertical_position }}mm</td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
            <hr />
            <div class="d-flex justify-end">
              <v-spacer></v-spacer>
              <v-btn-toggle>
                <v-btn class="mx-2" @click="measure"> Measure </v-btn>
                <v-btn class="mx-2">
                  <download-csv
                    class="btn btn-default"
                    :data="measurment"
                    name="apparent_depth.csv"
                  >
                    Download
                  </download-csv>
                </v-btn>
              </v-btn-toggle>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <CameraDialog v-model="camera_dialog" :camera="camera_dialog_camera" />

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
  name: "ApparentDepth",
  components: {
    CameraDialog,
  },
  props: {
    role: String,
  },
  mixins: [ExperimentBasic],
  data: function () {
    return {
      inte: null,
      loading: false,
      confirmDialog: false,
      targetRoom: 0,
      map: [
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 0, 0],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
        [1, 1, 1],
      ],
      current: {
        horizontal_position: 0,
        vertical_position: 0,
      },
      currentMaterial: "",
      measurment: [
        {
          horizontal_position: "A",
          vertical_position: 0,
        },

        {
          horizontal_position: "B",
          vertical_position: 0,
        },

        {
          horizontal_position: "C",
          vertical_position: 0,
        },
      ],
      api: {
        camera_0: "",
        camera_1: "",
        value: "",
        value_got_at: null,
        value_set_at: null,
      },
      options: {
        width: "100%",
      },
      series: [
        {
          data: [],
        },
      ],
      simulation: {
        device_0: {
          logs: [],
          status: "WAIT_FOR_COMMAND",
        },
      },
      simluate_0_mode: false,
      experiment_name: "",
    };
  },
  mounted: function () {
    var self = this;
    self.experiment_name = "APPARENT_DEPTH";
    this.currentMaterial = this.$cookies.get("equipment_id");
    // self.setCommand("device_0","RESTART|1");
    self.getValue("camera_0", function () {
      self.api.camera_0 = self.api.value.url;
    });
    self.getValue("camera_1", function () {
      self.api.camera_1 = self.api.value.url;
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
    setHorizontal(h) {
      var self = this;
      if (self.isAllowedToMoveHorizontal(h)) {
        self.current.horizontal_position = h;
        self.setCommand(
          "device_0",
          "POSITION_MAP|" +
            self.current.horizontal_position +
            "," +
            self.current.vertical_position
        );
      } else {
        self.$store.commit("showSnackBar", "Limited");
      }
    },
    setVertical(direction) {
      var self = this;
      if (direction == "down") {
        if (self.isAllowedToMoveUp()) {
          self.current.vertical_position -= 1;
          self.setCommand(
            "device_0",
            "POSITION_MAP|" +
              self.current.horizontal_position +
              "," +
              self.current.vertical_position
          );
        } else {
          self.$store.commit("showSnackBar", "Limited");
        }
      } else {
        if (self.isAllowedToMoveDown()) {
          self.current.vertical_position += 1;
          self.setCommand(
            "device_0",
            "POSITION_MAP|" +
              self.current.horizontal_position +
              "," +
              self.current.vertical_position
          );
        } else {
          self.$store.commit("showSnackBar", "Limited");
        }
      }
    },
    isAllowedToMoveUp() {
      var self = this;
      if (self.current.vertical_position - 1 < 0) {
        return false;
      }
      if (
        self.map[self.current.vertical_position - 1][
          self.current.horizontal_position
        ] == 0
      ) {
        return false;
      }
      return true;
    },
    isAllowedToMoveDown() {
      var self = this;
      if (self.current.vertical_position + 1 > self.map.length - 1) {
        return false;
      }
      if (
        self.map[self.current.vertical_position + 1][
          self.current.horizontal_position
        ] == 0
      ) {
        return false;
      }
      return true;
    },
    isAllowedToMoveHorizontal(h) {
      var self = this;
      if (self.map[self.current.vertical_position][h] == 1) {
        return true;
      } else {
        return false;
      }
    },
    measure() {
      var self = this;
      self.measurment[self.current.horizontal_position].vertical_position =
        self.current.vertical_position;
    },
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
