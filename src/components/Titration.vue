<template>
  <div class="titration">
    <v-row>
      <v-col xs="12" sm="5">
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
      <v-col xs="12" sm="7">
        <v-card>
            <v-card-actions>
                <h4>Controls</h4>
            </v-card-actions>
          <v-card-text>
            <v-row no-gutters>
              <v-col xs="4">
                <h6>Glass Tube</h6>
                <small>Washed: {{api.value.washed_times}} times</small>
                <br>
                <small>Max: {{max_wash}} times</small>
                <br>
                <v-btn class="my-2" @click="promptWash"
                    :disabled="loop_flag">
                  Wash
                </v-btn>
                <br>
                <v-btn class="my-2" @click="setCommand('device_0', 'GTUBE|1')"
                    :disabled="loop_flag"
                    >
                  Vibrate
                </v-btn>
                <v-btn class="my-2" @click="setCommand('device_0', 'RESTART|1')"
                    :disabled="loop_flag"
                    >
                  Restart
                </v-btn>

              </v-col>
              <v-col xs="4">
                <h6>Adding Base</h6>
                <small>Added: {{api.value.base_added}} mL</small>
                <br>
                <small>Max: {{ max_base }}mL</small>
                <br>
                <v-btn 
                    class="my-2" 
                    @click="
                        setCommand('device_0', 'BASE|0');
                        loop_flag = true;"
                    :disabled="api.value.base_added + 3 >max_base || loop_flag"
                >
                  Base (3mL)
                </v-btn>
              </v-col>
              <v-col xs="4">
                <h6>Adding Acid</h6>
                <small>Added:  {{api.value.acid_added}} mL</small>
                <br>
                <small>Max: {{ max_acid }}mL</small>
                <br>
                <v-btn class="my-2" @click="
                    setCommand('device_0', 'ACID|1');
                    loop_flag = true;"
                    :disabled="api.value.acid_added + 0.02 >max_acid || loop_flag"
                    >
                  Acid (0.02mL)
                </v-btn>
                <v-btn class="my-2" @click="
                    setCommand('device_0', 'ACID|0');
                    loop_flag = true;"
                    :disabled="api.value.acid_added + 0.2 >max_acid || loop_flag"
                    >
                  Acid (0.2mL)
                </v-btn>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <CameraDialog v-model="camera_dialog" :camera="camera_dialog_camera" />
    <!-- Confirm Dialog -->
    <v-dialog v-model="confirmDialog" width="600" persistent>
      <v-card>
        <v-card-title class="headline grey lighten-2">
          Wash Glass Tube
        </v-card-title>
        <v-card-text>
          <v-alert class="mt-4" type="error">
              Wash Glass Tube will clear all experiment data
          </v-alert>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="confirmWash"> Confirm</v-btn>
          <v-btn color="primary" text @click="cancelWash"> Cancel</v-btn>
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
  name: "Titration",
  components: {
    CameraDialog,
  },
  mixins: [ExperimentBasic],
  data: function () {
    return {
        confirmDialog: false,
        washed_times: 0,
        base_added: 0,
        acid_added: 0,
        max_wash: 4,
        max_base: 6,
        max_acid: 3,
        api: {
            value: {
                washed_times: 0,
                acid_added: 0,
                base_added: 0,
            },
            value_got_at: null,
            value_set_at: null,
            camera_0: "",
            camera_1: "",
        },
        loop_flag: false,
    };
  },
  mounted: function () {
    var self = this;
    self.experiment_name = "TITRATION";
    self.getValue("camera_0", function () {
      self.api.camera_0 = self.api.value;
      self.getValue("camera_1", function () {
        self.api.camera_1 = self.api.value;
        self.getValue("device_0", function () {
            console.log(self.api.value);
        });
      });
    });
    setInterval(function () {
      //loop check whether wash complete
      if (self.loop_flag) {
        self.getValue("device_0", function () {
          if (self.api.value_set_at >= self.api.command_set_at) {
            self.loop_flag = false;
          }
        });
      }
    }, 1000);
  },
  methods: {
      promptWash(){
            this.confirmDialog = true;
      },
      confirmWash(){
            this.setCommand('device_0', 'GTUBE|0');
            this.loop_flag = true;
            this.confirmDialog = false;
      },
      cancelWash(){
            this.confirmDialog = false;
      }
  },
};
</script>
