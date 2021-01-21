import RequestInstance from "@/api/request";
import prodConfig from "@/config";
import {ApiConfig} from "@/directives/types";

const conf: ApiConfig = prodConfig; // (process.env.NODE_ENV === "production" ? prodConfig : devConfig);
const http = RequestInstance(conf);

const api = {
  async get(what: string, params = {}) {
    const url: string = conf.endpoints[what];
    return await http.get(url, params);
  },
  async post(what: string, data: any) {
    const url: string = conf.endpoints[what];
    return await http.post(url, data);
  }
};

export default api;
export {conf};
