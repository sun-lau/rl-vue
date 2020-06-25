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
        Bookings
      </v-tab>
      <v-tab :href="`#tab-bookings`">
        Equipments
      </v-tab>

      <v-tab-item :value="'tab-users'">
        <AdminUser />
      </v-tab-item>
      <v-tab-item :value="'tab-bookings'">
        <AdminBooking />
      </v-tab-item>
    </v-tabs>
  </div>
</template>
<script>
import AdminUser from "@/components/AdminUser.vue";
import AdminBooking from "@/components/AdminBooking.vue";
export default {
  name: "admin",
  components: {
    AdminUser,
    AdminBooking
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