<template>
  <div class="setupDialog">
    <v-dialog v-model="parentDialog" width="600" persistent>
      <v-card>
        <v-card-title class="headline grey lighten-2"> Setup </v-card-title>
        <v-card-text>
            Setup Image
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="closeDialog"> Hide</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  name: "SetupDialog",
  model: {
    prop: "parentDialog",
    event: "update-parent-dialog",
  },
  props: {
    parentDialog: false,
  },
  data: function () {
    return {
      dialog: false,
    };
  },
  methods: {
    closeDialog() {
      this.$emit("update-parent-dialog", false);
    },
  },
  watch: {},
};
</script>

<style scoped lang="scss">
</style>