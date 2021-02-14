<template>
  <div class="admin">
    <v-tabs
      v-model="tab"
      class="elevation-2"
      dark
    >
      <v-tab :href="`#tab-users`">
        Users
      </v-tab>
      <v-tab :href="`#tab-bookings`">
        Booking - Slots
      </v-tab>
      <v-tab :href="`#tab-history`">
        Booking - History
      </v-tab>
      <v-tab :href="`#tab-equipments`">
        Equipments
      </v-tab>
      <v-tab :href="`#tab-health`">
        Health Notification
      </v-tab>
      <v-tab :href="`#tab-bacteria`">
        Bacteria Growth
      </v-tab>

      <v-tab-item :value="'tab-users'">
        <AdminUser />
      </v-tab-item>
      <v-tab-item :value="'tab-bookings'">
        <AdminBooking />
      </v-tab-item>
      <v-tab-item :value="'tab-history'">
        <AdminHistory />
      </v-tab-item>
      <v-tab-item :value="'tab-equipments'">
        <AdminEquipment />
      </v-tab-item>
      <v-tab-item :value="'tab-health'">
        <AdminHealth />
      </v-tab-item>
      <v-tab-item :value="'tab-bacteria'">
        <AdminBacteria />
      </v-tab-item>
    </v-tabs>
  </div>
</template>
<script>
import AdminUser from "@/components/AdminUser.vue";
import AdminBooking from "@/components/AdminBooking.vue";
import AdminHistory from "@/components/AdminHistory.vue";
import AdminEquipment from "@/components/AdminEquipment.vue";
import AdminHealth from "@/components/AdminHealth.vue";
import AdminBacteria from "@/components/AdminBacteria.vue";
export default {
  name: "admin",
  components: {
    AdminUser,
    AdminBooking,
    AdminHistory,
    AdminEquipment,
    AdminHealth,
    AdminBacteria
  },
  data: () => ({
    tab: null
  }),
  mounted() {
    var self = this;
    if($cookies.get('username') != "admin"){
        self.$store.commit('showSnackBar', "Access Denied");
        self.$router.push("/");
    }
  },
  methods: {}
};
</script>