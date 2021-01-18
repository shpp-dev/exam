import {ApiConfig} from "@/types";

const API_BASE_URL: string = (process.env.VUE_APP_API_URL || "") + "/exam";
const SIGN_IN_URL: string = process.env.VUE_APP_SIGN_IN_URL || "";
const LOGOUT_URL: string = process.env.VUE_APP_LOGOUT_URL || "";
const SUPPORT_EMAIL: string = process.env.VUE_APP_SUPPORT_EMAIL || "";

const urls = {
  supportEmail: SUPPORT_EMAIL,
  SIGN_IN: SIGN_IN_URL,
  LOGOUT: LOGOUT_URL
};

const config: ApiConfig = {
  baseURL: API_BASE_URL,
  endpoints: {
    invite: "/invite",
    approve: "/approve",
    email: "/email",
    examsList: "/list",
    startExam: "/start",
    examStatus: "/status",
    programmingTask: "/programming/task",
    programmingAnswer: "/programming/answer",
    programmingFinish: "/programming/finish",
    programmingRemainingTime: "/programming/remaining-time",
    randomText: "/type/text",
    typingResult: "/type/speed",
    typingStart: "/type/start",
    englishQuestion: "/english/question",
    englishAnswer: "/english/answer",
    englishFinish: "/english/finish",
    englishRemainingTime: "/english/remaining-time",
    saveZeroStatus: "/zero-status/save",
    logout: LOGOUT_URL
  }
};

export default config;
export {urls};
