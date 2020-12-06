<template>
  <div class="board ma-0">
    <div v-if="name == 'bacteria_growth'">
      <BacteriaGrowth />
    </div>
  </div>
</template>
<script>
import BacteriaGrowth from "@/components/BacteriaGrowth.vue";

export default {
  name: "board",
  components: {
    BacteriaGrowth,
  },
  data: function () {
    return {
      name: "",
      role: null,
    };
  },
  mounted: function () {
    this.$ga.page("/board/" + this.$route.params.experiment_name);
    this.name = this.$route.params.experiment_name;
    var ga_counter = 0;
    setInterval(function () {
      ga_counter += 10;
      this.$ga.event(
        "Experiment",
        "stay_" + ga_counter + "_mins",
        this.$route.params.experiment_name
      );
    }, 10 * 60 * 1000);
  },
  methods: {},
};
</script>

<style lang="scss">
.clickable {
  cursor: pointer;
}
</style>