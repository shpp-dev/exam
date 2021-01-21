export interface User {
  email: string;
  firstName: string;
  lastName: string;
  discord: string;
  avatar: string;
  birthday: string; // 2000-02-02
  examAvailable: boolean;
}

export interface ApiConfig {
  baseURL: string;
  endpoints: {
    [index: string]: string
  };
}

export interface ProgrammingTask {
  name: string;
  description: string;
  number: number;
  functionStart: {
    js: string;
    java: string;
    cpp: string;
  };
  deadlineTs: number;
  tasksAmount: number;
}
