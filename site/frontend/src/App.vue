<template>
  <v-app dark>
    <div v-if="loading">
      <v-alert
        v-if="notIdentified"
        :value="true"
        type="error"
        transition="scale-transition"
      >
        {{$t('notAllowedForExam')}}
      </v-alert>
    </div>
    <v-container class="start-exam" v-if="!loading && !examStarted">
      <div>
        <h2 class="text-xs-center display-3 ma-10">GET READY</h2>
        <h2 class="text-xs-center display-3 ma-3">PLAYER ONE</h2>
        <br>
        <div class="text-xs-center">
          <v-btn color="green lighten-1" large flat @click="startExam">PRESS START!</v-btn>
        </div>
      </div>
    </v-container>
    <v-dialog light v-model="exception" width="500">
      <v-card>
        <v-card-text class="text-xs-center">
          {{$t('exception')}}
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="success"
            flat
            @click="clearException"
          >
            Ok
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <router-view v-if="hasExams"/>
  </v-app>
</template>

<script lang="ts">
import Vue from "vue";
import {User} from "./types";
import statusCodes from "@/config/status-codes";
import {urls} from "@/config";

export default Vue.extend({
  name: "App",
  data() {
    return {
      loading: false,
      hasExams: false,
      notIdentified: false,
      supportEmail: urls.supportEmail
    };
  },
  computed: {
    user(): User {
      return this.$store.state.user.data;
    },
    examStarted(): boolean {
      return this.$store.state.general.examStarted;
    },
    exception(): boolean {
      return this.$store.state.general.exception;
    }
  },
  async mounted() {
    try {
      this.loading = true;
      await Promise.all([
        this.$store.dispatch("general/getStatus")
      ]);
      await this.tryToGetExamsList();
      this.loading = false;
    } catch (e) {
      switch (e.code) {
        case statusCodes.UNAUTHORIZED:
          window.location.href = urls.SIGN_IN;
          break;
        case statusCodes.NOT_ALLOWED:
          window.location.href = urls.SIGN_IN;
          break;
        case statusCodes.NOT_IDENTIFIED:
          this.notIdentified = true;
          break;
        default:
          Vue.set(this.$store.state.general, "exception", true);
      }
    }
  },
  methods: {
    async tryToGetExamsList() {
      if (this.examStarted) {
        await this.$store.dispatch("general/getExamsList");
        this.hasExams = Object.keys(this.$store.state.general.examsList).length !== 0;
      }
    },
    async startExam() {
      try {
        await this.$store.dispatch("general/startExam");
        await this.tryToGetExamsList();
      } catch (e) {
        Vue.set(this.$store.state.general, "exception", true);
      }
    },
    clearException() {
      Vue.set(this.$store.state.general, "exception", false);
    }
  }
});
</script>

<style lang="scss">
  .application {
    justify-content: center;
  }

  .application--wrap {
    justify-content: center;
    max-width: 1300px !important;
  }

  nav {
    margin-bottom: 0;
    border-bottom: 5px solid #27ae60;
    height: 90px;
    box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.16), 0 1px 1px 0 rgba(0, 0, 0, 0.12);
    z-index: 1;
  }

  .brand-logo {
    text-decoration: none;
    font-family: 'Arial', sans-serif;
    font-size: 50px;
    line-height: 110px;
    height: 90px;
    font-weight: bold;
    margin: -10px;
    letter-spacing: 1.1px;

    .sh {
      color: white;
    }
    .plusplus {
      color: #27ae60;
    }
    .beta {
      font-weight: 100;
      font-style: italic;
      font-size: 15px;
    }
  }
  .start-exam {
    display: flex;
    align-items: center !important;
    justify-content: center !important;
    font-family: 'ZX', serif !important;
    [class*=display] {
      font-family: 'ZX', serif !important;
    }
  }
</style>
