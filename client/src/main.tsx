import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import "./index.css";
import { UserContextProvider } from "./context/User.tsx";
import { RouterProvider } from "react-router-dom";
import routes from "./router/index.ts";

createRoot(document.getElementById("root")!).render(
  <StrictMode>
    <UserContextProvider>
      <RouterProvider router={routes} />
    </UserContextProvider>
  </StrictMode>
);
