import RequestInstance from "@/api/request";
import config from "@/config";
import {ApiConfig} from "@/types";

const conf: ApiConfig = config;
const http = RequestInstance(conf);

const api = {
  async get(what: string, params = {}) {
    const url: string = conf.endpoints[what];
    return await http.get(url, params);
  },
  async post(what: string, data?: any) {
    const url: string = conf.endpoints[what];
    return await http.post(url, data);
  }
};

export default api;
export {conf};
