export interface UserInterface {
  first_name: string;
  last_name: string;
  email: string;
}

export interface AuthInterface {
  isLoggedIn: boolean;
  user: UserInterface;
}
