<template>
  <div class="experiment ma-0">
          <div v-if="name == 'apparent_depth'">
            <ApparentDepth />
          </div>
          <div v-if="name == 'visible_spectrum'">
            <VisibleSpectrum />
          </div>
          <div v-if="name == 'interference'">
            <Interference />
          </div>
          <div v-if="name == 'bacteria_growth'">
            <BacteriaGrowth />
          </div>
          <div v-if="name == 'em_induction'">
            <EmInduction />
          </div>
          <div v-if="name == 'green_house'">
            <GreenHouse />
          </div>
          <div v-if="name == 'photo_electric'">
            <PhotoElectric />
          </div>
          <div v-if="name == 'radiation'">
            <Radiation />
          </div>
          <div v-if="name == 'titration'">
            <Titration />
          </div>
  </div>
</template>
<script>
import ApparentDepth from "@/components/ApparentDepth.vue";
import VisibleSpectrum from "@/components/VisibleSpectrum.vue";
import Interference from "@/components/Interference.vue";
import BacteriaGrowth from "@/components/BacteriaGrowth.vue";
import EmInduction from "@/components/EmInduction.vue";
import GreenHouse from "@/components/GreenHouse.vue";
import PhotoElectric from "@/components/PhotoElectric.vue";
import Radiation from "@/components/Radiation.vue";
import Titration from "@/components/Titration.vue";
import ExperimentBasic from "@/services/ExperimentBasic";

export default {
  name: "experiment",
  components: {
    ApparentDepth,
    VisibleSpectrum,
    Interference,
    BacteriaGrowth,
    EmInduction,
    GreenHouse,
    PhotoElectric,
    Radiation,
    Titration,
  },
  mixins: [ExperimentBasic],
  data: function () {
    return {
      name: "",
      role: null,
      drawer: true,
      mini: true,
    };
  },
  mounted: function () {
    this.$ga.page("/experiment/" + this.$route.params.experiment_name);
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