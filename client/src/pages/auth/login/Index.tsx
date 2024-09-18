import React, { useContext, useState } from "react";
import { useNavigate } from "react-router-dom";
import { SERVER_URL } from "../../../config/server";
import { UserContext } from "../../../context/User";
import Header from "../../../components/Header";

const Login: React.FC = () => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [loading, setLoading] = useState<boolean>(false);
  const [error, setError] = useState("");

  const navigate = useNavigate();

  const { setAuth } = useContext(UserContext);

  const handleLogin = async (e: React.FormEvent) => {
    console.log(email, password);
    e.preventDefault();
    setError("");
    setLoading(true);
    const response = await fetch(`${SERVER_URL}/login`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        email,
        password,
      }),
    }).finally(() => setLoading(false));

    const data = await response.json();
    console.log(data);
    if (data.token) {
      setAuth((values) => ({ ...values, isLoggedIn: true }));
      localStorage.setItem("auth_token", data.token);
    } else {
      setError(data.error);
    }
  };

  return (
    <section>
      <Header />
      <div className="flex items-center justify-center h-screen bg-gray-100">
        <div className="w-full max-w-md p-8 bg-white shadow-lg rounded-lg">
          <h2 className="text-2xl font-bold mb-4">Login</h2>
          {typeof error === "string" && error && (
            <p className="text-red-600 text-sm text-center py-1">{error}</p>
          )}
          <form onSubmit={handleLogin}>
            <div className="mb-4">
              <label
                htmlFor="email"
                className="block text-sm font-medium text-gray-700"
              >
                Email
              </label>
              <input
                type="email"
                id="email"
                className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                required
              />
            </div>
            <div className="mb-4">
              <label
                htmlFor="password"
                className="block text-sm font-medium text-gray-700"
              >
                Password
              </label>
              <input
                type="password"
                id="password"
                className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
              />
            </div>
            <button
              type="submit"
              disabled={loading}
              className="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700"
            >
              {loading ? "Logging In..." : "Login"}
            </button>
          </form>
        </div>
      </div>
    </section>
  );
};

export default Login;
