<template>
  <v-app id="inspire">
    <v-navigation-drawer app :mini-variant.sync="mini" mini-variant-width="90">
      <v-list-item>
        <v-list-item-content>
          <h5 class="mb-2" v-if="!mini">Borderless Lab 365</h5>
          <v-list-item-title class="title">
            <p>
              {{ $route.params.experiment_name }}
              <v-btn icon @click.stop="mini = !mini">
                <v-icon>mdi-chevron-left</v-icon>
              </v-btn>
            </p>
          </v-list-item-title>
          <v-list-item-subtitle v-if="$route.name == 'experiment'">
            Room {{ parseInt($cookies.get("equipment_id").slice(-1)) + 1 }}
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
      <v-list dense nav>
        <v-list-item
          link
          @click="openManual"
          v-if="$route.name == 'experiment' || $route.name == 'board'"
        >
          <v-list-item-content>
            <v-list-item-title>Lab Manual</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item
          link
          @click="setupDialog = true"
          v-if="$route.name == 'experiment' || $route.name == 'board'"
        >
          <v-list-item-content>
            <v-list-item-title>Equipment Setup</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item v-if="$route.name == 'experiment'">
          <v-list-item-content>
            <v-list-item-title>
              <v-btn dark :block="!mini" color="info" class="mt-4">
                <v-icon small class="mr-2">mdi-clock</v-icon>
                {{ parseInt(kick_time / 60) }}
                <span v-if="!mini">mins left</span>
              </v-btn>
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <v-btn
        x-small
        class="ml-4 my-4"
        dark
        color="info"
        @click="feedbackDialog = true"
        >Feedback</v-btn
      >
      <v-btn
        v-if="$cookies.isKey('username')"
        x-small
        class="ml-4 my-4"
        dark
        color="error"
        @click="goTo('/logout')"
      >
        Logout
      </v-btn>
      <v-btn v-else x-small class="ml-4 my-4" @click="goTo('/login')"
        >Login</v-btn
      >
      <br />
      <small class="ma-4">1221.1</small>
    </v-navigation-drawer>

    <v-content>
      <router-view class="mx-4" />
    </v-content>

    <!-- Setup Dialog -->
    <v-dialog
      v-model="setupDialog"
      width="600"
      persistent
      v-if="$route.name == 'experiment'"
    >
      <v-card>
        <v-card-title class="headline grey lighten-2"> Setup </v-card-title>
        <v-card-text>
          <v-img
            :src="
              $store.state.experiments[$route.params.experiment_name].setupPhoto
            "
            fluid
          />
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="setupDialog = false"> Hide</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- Feedback Dialog -->
    <v-dialog v-model="feedbackDialog" width="600" persistent>
      <v-card>
        <v-card-title class="headline grey lighten-2"> Feedback </v-card-title>
        <v-card-text>
          <p class="mt-4">What kind of Problem faced?</p>
          <v-radio-group v-model="feedbackCategory" column>
            <v-radio
              label="Cannot book experiment"
              value="cannot_book_experiment"
            ></v-radio>
            <v-radio
              label="Cannot enter experiment"
              value="cannot_enter_experiment"
            ></v-radio>
            <v-radio
              label="Cannot finish experiment"
              value="cannot_finish_experiment"
            ></v-radio>
            <v-radio
              label="Camera no response"
              value="camera_no_response"
            ></v-radio>
            <v-radio label="Others" value="others"></v-radio>
          </v-radio-group>
          <hr />
          <v-textarea
            label="Details"
            v-model="feedbackDetails"
            hint="Bug Report or Comments"
          ></v-textarea>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="feedbackDialog = false">
            Quit</v-btn
          >
          <v-btn color="success" text @click="submitFeedback">Submit</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- snackbar -->
    <v-snackbar v-model="$store.state.snackbar.modal">
      {{ $store.state.snackbar.message }}
      <template v-slot:action="{ attrs }">
        <v-btn color="pink" text v-bind="attrs" @click="snackbar = false">
          Close
        </v-btn>
      </template>
    </v-snackbar>
    <div></div>
  </v-app>
</template>

<script>
export default {
  props: {
    source: String,
  },
  data: () => ({
    auth_token: "",
    setupDialog: false,
    feedbackDialog: false,
    mini: false,
    kick_time: null,
    feedbackCategory: "",
    feedbackDetails: "",
  }),

  mounted: function () {
    var self = this;
    if (self.$cookies.isKey("kick_time")) {
      self.kick_time = self.$cookies.get("kick_time");
      setInterval(function () {
        //countdown protect
        self.kick_time = self.kick_time - 1;
        if (self.kick_time < 0) {
          self.$ga.event(
            "Experiment",
            "kick_out",
            self.$cookies.get("experiment")
          );
          self.$cookies.remove("session_token");
          window.location.href = process.env.VUE_APP_BASE_URL;
        }
      }, 1000);
    }
  },
  methods: {
    goTo: function (name) {
      var self = this;
      self.$router.push(name);
    },
    changeLang: function (lang) {
      var self = this;
      self.$i18n.locale = lang;
    },
    openManual() {
      window.open(
        this.$store.state.experiments[this.$route.params.experiment_name]
          .labManual
      );
    },
    submitFeedback() {
      const url =
        "https://hooks.slack.com/services/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";
      const data = {
        text:
          "User Feedback" +
          "\n" +
          "User: " +
          this.$cookies.get("username") +
          "\n" +
          "Experiment: " +
          this.$route.params.experiment_name +
          "\n" +
          "Set: " +
          this.$cookies.get("equipment_id") +
          "\n" +
          "feedbackCategory: " +
          this.feedbackCategory +
          "\n" +
          "feedbackDetails: " +
          this.feedbackDetails +
          "\n" +
          "\n",
      };
      this.axios.post(url, JSON.stringify(data), {
        withCredentials: false,
        transformRequest: [
          (data, headers) => {
            delete headers.post["Content-Type"];
            return data;
          },
        ],
      });
      alert("Thank you for your feedback!");
    },
  },
};
</script>