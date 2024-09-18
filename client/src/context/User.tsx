import React, {
  Dispatch,
  SetStateAction,
  createContext,
  useState,
} from "react";
import { AuthInterface, UserInterface } from "../interfaces/user";

const user: UserInterface = {
  first_name: "",
  last_name: "",
  email: "",
};

const defaultValue: AuthInterface = {
  isLoggedIn: false,
  user,
};
export const UserContext = createContext<{
  auth: AuthInterface;
  setAuth: Dispatch<SetStateAction<AuthInterface>>;
}>({ auth: defaultValue, setAuth: () => {} });
export const UserContextProvider: React.FC<any> = ({ children }) => {
  const [auth, setAuth] = useState<AuthInterface>(defaultValue);

  return (
    <UserContext.Provider value={{ auth, setAuth }}>
      {children}
    </UserContext.Provider>
  );
};
