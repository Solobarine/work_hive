import { createBrowserRouter } from "react-router-dom";
import Login from "../pages/auth/login/Index";
import Register from "../pages/auth/register/Index";

const routes = createBrowserRouter([
  {
    path: "/login",
    Component: Login,
  },
  {
    path: "/register",
    Component: Register,
  },
]);

export default routes;
