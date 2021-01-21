import axios from "axios";
import {ApiConfig} from "@/directives/types";

const Instance = (config: ApiConfig) => {
  const instance = axios.create({
    baseURL: config.baseURL,
    withCredentials: true
  });

  instance.interceptors.response.use((response) => {
    // Do something with response data
    return response.data;
  }, (error) => {
    // Do something with response error
    return Promise.reject(error.response.data.error);
  });
  return instance;
};

export default Instance;
