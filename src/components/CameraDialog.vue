<template>
  <div class="cameraDialog">
    <v-dialog v-model="parentDialog" width="680" persistent>
      <v-card>
        <v-card-title class="headline grey lighten-2"> Camera </v-card-title>

        <v-card-text>
          <v-img :src="src" fluid />
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-btn color="primary" text @click="rebootCamera">Reboot Camera</v-btn>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="closeDialog"> Hide</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { Experiment_APIService } from "@/services/Experiment_APIService";
const apiService = new Experiment_APIService(process.env.VUE_APP_BASE_URL);
export default {
  name: "CameraDialog",
  model: {
    prop: "parentDialog",
    event: "update-parent-dialog",
  },
  props: {
    parentDialog: false,
    camera: {}
  },
  data: function () {
    return {
      dialog: false,
    };
  },
  methods: {
    rebootCamera(){
      var r = confirm("Reboot camera? (It takes about 3 minutes)");
      if (r == true) {
            apiService
            .rebootCamera(
              this.camera.reboot
            );
      }
    },
    closeDialog() {
      this.$emit("update-parent-dialog", false);
    },
  },
  watch: {},
};
</script>

<style scoped lang="scss">
</style>