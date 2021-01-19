import Vue from "vue";
import {DateTime, Duration, Info, Interval, Settings} from "@/plugins/luxon";

// luxon setup
// use it like: this.$dt.local().toFormat("MMMM dd, yyyy");

Settings.defaultLocale = "uk";
Settings.defaultZoneName = "Europe/Kiev";

declare module "vue/types/vue" {
  interface Vue {
    $dt: typeof DateTime;
    $duration: typeof Duration;
    $interval: typeof Interval;
  }
}

Vue.prototype.$dt = DateTime;
Vue.prototype.$duration = Duration;
Vue.prototype.$interval = Interval;
