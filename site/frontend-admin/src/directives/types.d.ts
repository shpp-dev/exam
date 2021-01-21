export interface User {
  id: number;
  email: string;
  firstName: string;
  lastName: string;
  discord: string;
  avatar: string;
  approved: boolean;
  invitedToExam: boolean;
  examPassed: boolean;
  admin: boolean;
  volunteer: boolean;
  status?: number;
}

export interface ApiConfig {
  baseURL: string;
  endpoints: {
    [index: string]: string
  };
}
export interface State {
  users: User[];
}
