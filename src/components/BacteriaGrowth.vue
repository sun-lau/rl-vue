<template>
  <div class="bacteria_growth">
    <v-row>
      <v-col xs="12" sm="3">
        <v-card>
          <v-card-title>Sample 1</v-card-title>
          <v-card-text>          
            <v-img :src="$store.state.experiments[$route.params.experiment_name].setupPhoto" fluid />
          </v-card-text>
        </v-card>
      </v-col>
      <v-col xs="12" sm="3">
        <v-card>
          <v-card-title>Sample 2</v-card-title>
          <v-card-text>          
            <v-img :src="$store.state.experiments[$route.params.experiment_name].setupPhoto" fluid />
          </v-card-text>
        </v-card>
      </v-col>
      <v-col xs="12" sm="3">
        <v-card>
          <v-card-title>Sample 3</v-card-title>
          <v-card-text>          
            <v-img :src="$store.state.experiments[$route.params.experiment_name].setupPhoto" fluid />
          </v-card-text>
        </v-card>
      </v-col>
      <v-col xs="12" sm="3">
        <v-card>
          <v-card-title>Sample 4</v-card-title>
          <v-card-text>          
            <v-img :src="$store.state.experiments[$route.params.experiment_name].setupPhoto" fluid />
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col xs="12" sm="3">
        <v-card>
          <v-card-title>Sample 5</v-card-title>
          <v-card-text>          
            <v-img :src="$store.state.experiments[$route.params.experiment_name].setupPhoto" fluid />
          </v-card-text>
        </v-card>
      </v-col>
      <v-col xs="12" sm="3">
        <v-card>
          <v-card-title>Sample 6</v-card-title>
          <v-card-text>          
            <v-img :src="$store.state.experiments[$route.params.experiment_name].setupPhoto" fluid />
          </v-card-text>
        </v-card>
      </v-col>
      <v-col xs="12" sm="3">
        <v-card>
          <v-card-title>Sample 7</v-card-title>
          <v-card-text>          
            <v-img :src="$store.state.experiments[$route.params.experiment_name].setupPhoto" fluid />
          </v-card-text>
        </v-card>
      </v-col>
      <v-col xs="12" sm="3">
        <v-card>
          <v-card-title>Sample 8</v-card-title>
          <v-card-text>          
            <v-img :src="$store.state.experiments[$route.params.experiment_name].setupPhoto" fluid />
          </v-card-text>
        </v-card>
      </v-col>
        <v-card>
          <v-card-title>Records</v-card-title>
          <v-btn class="ma-4" @click="capture">Capture All Samples</v-btn>
          <br />
        </v-card>
    </v-row>
  </div>
</template>

<script>
// @ is an alias to /src

import { Experiment_APIService } from "@/services/Experiment_APIService";
const apiService = new Experiment_APIService(process.env.VUE_APP_BASE_URL);
export default {
  name: "BacteriaGrowth",
  components: {},
  props: {
    role: String,
  },
  data: function () {
    return {
      inte: null,
      loading: false,
      api: {
        camera_0: "",
        camera_1: "",
        value: "",
        value_got_at: null,
        value_set_at: null,
      },
      experiment_name: "",
      current_sample: 1,
    };
  },
  mounted: function () {
    var self = this;
    self.experiment_name = "BACTERIA_GROWTH";
    self.getValue("camera_0", function () {
      self.api.camera_0 = self.api.value.url;
    });
    self.getValue("camera_1", function () {
      self.api.camera_1 = self.api.value.url;
    });
  },
  methods: {
    setSample(target_sample) {
      var self = this;
      self.current_sample = target_sample;
      self.setCommand("device_0", "SAMPLE|" + target_sample);
    },
    capture() {
      var self = this;
      apiService.setPhoto(
        self.experiment_name,
        self.$cookies.get("equipment_id"),
        "sample_" + self.current_sample,
        function () {
          self.$store.commit("showSnackBar", "Photo Captured");
        }
      );
    },
    downloadPhotos() {
      var self = this;
      apiService.zipPhotos(
        self.$cookies.get("session_token"),
        self.$cookies.get("role"),
        self.experiment_name,
        self.$cookies.get("equipment_id"),
        "device_0",
        function () {
          window.open(
            process.env.VUE_APP_BASE_URL +
              "/api/experiment/storage/" +
              self.experiment_name +
              "-" +
              self.$cookies.get("equipment_id") +
              ".zip"
          );
        }
      );
    },
  },
};
</script>
