import { FC, useContext, useEffect } from "react";
import { UserContext } from "./context/User";
import useFetch from "./hooks/useFetch";
import { SERVER_URL } from "./config/server";
import { Navigate, Outlet } from "react-router-dom";
import Loading from "./pages/loading/Index";
import Menu from "./components/Menu";

const App = () => {
  const {
    auth: { isLoggedIn },
    setAuth,
  } = useContext(UserContext);

  const { data, error, loading, fetchData } = useFetch(
    `${SERVER_URL}/user`,
    "GET"
  );

  useEffect(() => {
    fetchData();
    console.log(data);
    if (data) {
      setAuth({ isLoggedIn: true, user: data as any });
    }
  }, []);

  console.log(isLoggedIn);

  if (error) {
    return <Navigate to="/login" />;
  }

  if (loading) return <Loading />;

  return (
    <main className="min-h-screen flex items-start">
      <Menu />
      <Outlet />;
    </main>
  );
};

export default App;
