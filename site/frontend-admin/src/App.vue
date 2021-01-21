<template>
  <v-app>
    <div v-if="loading">
      <v-alert
        v-if="notAdminError"
          :value="true"
        type="error"
        transition="scale-transition"
      >
        Это страничка для администрации, а вы, кажется &mdash; не администратор 🧐
      </v-alert>
      <v-alert
        v-else-if="error"
        :value="true"
        type="error"
        transition="scale-transition"
      >
        Ошибка при получении списка экзаменов! Подробности в консоли разработчика.
      </v-alert>
    </div>
    <div v-else-if="!error && !notAdminError">
      <NavBar/>
      <v-content>
        <router-view />
      </v-content>
    </div>
  </v-app>
</template>

<script>
import NavBar from "@/components/NavBar.vue";
import status_codes from "@/config/status-codes";
import {urls} from "@/config";
import settings from "@/config/settings";

export default {
  name: "App",
  components: {
    NavBar
  },
  data() {
    return {
      error: false,
      notAdminError: false,
      loading: false
    };
  },
  async created() {
    try {
      this.loading = true;
      await this.$store.dispatch("exams/getExams", {key: settings.startList});
      this.loading = false;
    } catch (e) {
      switch (e.code) {
        case status_codes.UNAUTHORIZED:
          window.location.href = urls.signin;
          break;
        case status_codes.ACCESS_DENIED:
          this.notAdminError = true;
          break;
        default:
          console.warn({e});
          this.error = true;
      }
    }
  }
};
</script>
