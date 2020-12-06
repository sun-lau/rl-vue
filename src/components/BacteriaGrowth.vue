<template>
  <div class="bacteria_growth">
    <v-row no-gutters>
      <v-col cols="10">
        <v-row>
          <v-col xs="12" sm="3">
            <v-card>
              <v-card-title>Sample 1</v-card-title>
              <v-card-subtitle>{{ api.snapshots.sample_1 }}</v-card-subtitle>
              <v-card-text>
                <v-img
                  :src="
                    base_url + '/api/experiment/storage/BACTERIA_GROWTH-' + $route.params.equipment_name +'/sample_1.jpg'
                  "
                  fluid
                />
              </v-card-text>
            </v-card>
          </v-col>
          <v-col xs="12" sm="3">
            <v-card>
              <v-card-title>Sample 2</v-card-title>
              <v-card-subtitle>{{ api.snapshots.sample_2 }}</v-card-subtitle>
              <v-card-text>
                <v-img
                  :src="
                    base_url + '/api/experiment/storage/BACTERIA_GROWTH-' + $route.params.equipment_name +'/sample_2.jpg'
                  "
                  fluid
                />
              </v-card-text>
            </v-card>
          </v-col>
          <v-col xs="12" sm="3">
            <v-card>
              <v-card-title>Sample 3</v-card-title>
              <v-card-subtitle>{{ api.snapshots.sample_3 }}</v-card-subtitle>
              <v-card-text>
                <v-img
                  :src="
                    base_url + '/api/experiment/storage/BACTERIA_GROWTH-' + $route.params.equipment_name +'/sample_3.jpg'
                  "
                  fluid
                />
              </v-card-text>
            </v-card>
          </v-col>
          <v-col xs="12" sm="3">
            <v-card>
              <v-card-title>Sample 4</v-card-title>
              <v-card-subtitle>{{ api.snapshots.sample_4 }}</v-card-subtitle>
              <v-card-text>
                <v-img
                  :src="
                    base_url + '/api/experiment/storage/BACTERIA_GROWTH-' + $route.params.equipment_name +'/sample_4.jpg'
                  "
                  fluid
                />
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
        <v-row>
          <v-col xs="12" sm="3">
            <v-card>
              <v-card-title>Sample 5</v-card-title>
              <v-card-subtitle>{{ api.snapshots.sample_5 }}</v-card-subtitle>
              <v-card-text>
                <v-img
                  :src="
                    base_url + '/api/experiment/storage/BACTERIA_GROWTH-' + $route.params.equipment_name +'/sample_5.jpg'
                  "
                  fluid
                />
              </v-card-text>
            </v-card>
          </v-col>
          <v-col xs="12" sm="3">
            <v-card>
              <v-card-title>Sample 6</v-card-title>
              <v-card-subtitle>{{ api.snapshots.sample_6 }}</v-card-subtitle>
              <v-card-text>
                <v-img
                  :src="
                    base_url + '/api/experiment/storage/BACTERIA_GROWTH-' + $route.params.equipment_name +'/sample_6.jpg'
                  "
                  fluid
                />
              </v-card-text>
            </v-card>
          </v-col>
          <v-col xs="12" sm="3">
            <v-card>
              <v-card-title>Sample 7</v-card-title>
              <v-card-subtitle>{{ api.snapshots.sample_7 }}</v-card-subtitle>
              <v-card-text>
                <v-img
                  :src="
                    base_url + '/api/experiment/storage/BACTERIA_GROWTH-' + $route.params.equipment_name +'/sample_7.jpg'
                  "
                  fluid
                />
              </v-card-text>
            </v-card>
          </v-col>
          <v-col xs="12" sm="3">
            <v-card>
              <v-card-title>Sample 8</v-card-title>
              <v-card-subtitle>{{ api.snapshots.sample_8 }}</v-card-subtitle>
              <v-card-text>
                <v-img
                  :src="
                    base_url + '/api/experiment/storage/BACTERIA_GROWTH-' + $route.params.equipment_name +'/sample_8.jpg'
                  "
                  fluid
                />
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="2">
          <v-btn class="ma-4" @click="downloadPhotos">Download All</v-btn>
      </v-col>
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
        snapshots:{},
        value: "",
        value_got_at: null,
        value_set_at: null,
      },
      experiment_name: "",
      current_sample: 1,
      base_url:process.env.VUE_APP_BASE_URL 
    };
  },
  mounted: function () {
    var self = this;
    self.experiment_name = "BACTERIA_GROWTH";
    apiService
    .getPhotoTime('set_0', function(result){
      self.api.snapshots = result;
    })
  },
  methods: {
    // capture() {
    //   var self = this;
    //   apiService.setPhoto(
    //     self.experiment_name,
    //     self.$route.params.equipment_name,
    //     "sample_" + self.current_sample,
    //     function () {
    //       self.$store.commit("showSnackBar", "Photo Captured");
    //     }
    //   );
    // },
    downloadPhotos() {
      var self = this;
      apiService.zipPhotos(
        self.$cookies.get("session_token"),
        self.$cookies.get("role"),
        self.experiment_name,
        self.$route.params.equipment_name,
        "device_0",
        function () {
          window.open(
            process.env.VUE_APP_BASE_URL +
              "/api/experiment/storage/" +
              self.experiment_name +
              "-" +
              self.$route.params.equipment_name +
              ".zip"
          );
        }
      );
    },
  },
};
</script>
