import { createBrowserRouter } from "react-router-dom";
import Login from "../pages/auth/login/Index";
import Register from "../pages/auth/register/Index";
import Dashboard from "../pages/dashboard/Index";
import TaskList from "../pages/tasks/taskList/Index";
import TaskCreate from "../pages/tasks/create/Index";
import Welcome from "../pages/welcome/Index";
import App from "../App";

const routes = createBrowserRouter([
  {
    path: "/",
    Component: Welcome,
  },
  {
    path: "/login",
    Component: Login,
  },
  {
    path: "/register",
    Component: Register,
  },
  {
    path: "/",
    Component: App,
    children: [
      {
        path: "/dashboard",
        Component: Dashboard,
      },
      {
        path: "/tasks",
        Component: TaskList,
      },
      {
        path: "/tasks/new",
        Component: TaskCreate,
      },
    ],
  },
]);

export default routes;
