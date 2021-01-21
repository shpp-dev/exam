import {ApiConfig} from "@/directives/types";

const examBackUrl: string = process.env.VUE_APP_EXAM_API_URL || "http://localhost:8080/api";

const config: ApiConfig = {
  baseURL: `${examBackUrl}/admin`,
  endpoints: {
    unchecked: "/list/unchecked",
    passed: "/list/passed",
    failed: "/list/failed",
    all: "/list/all",
    check: "/check",
    saveEverCookie: "evercookie/save",
    removeEverCookie: "evercookie/remove",
    disableCheckingLocation: "location/disable"
  }
};

const urls = {
  signin: process.env.VUE_APP_SIGN_IN_URL,
  userProfile: process.env.VUE_APP_USER_PROFILE_ADMIN_URL
};

export default config;
export {urls};
