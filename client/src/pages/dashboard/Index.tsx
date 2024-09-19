import { Dispatch, SetStateAction, useEffect } from "react";
import { SERVER_URL } from "../../config/server";
import useFetch from "../../hooks/useFetch";
import Card from "../loading/Card";
import Error from "../../components/Error";

const Dashboard = () => {
  const {
    data,
    loading,
    fetchData,
  }: {
    data: { status: boolean; tasks: [] } | null;
    loading: boolean;
    fetchData: () => {};
  } = useFetch(`${SERVER_URL}/tasks`, "GET");

  useEffect(() => {
    fetchData();
  }, []);

  return (
    <section className="container mx-auto p-4">
      <h1 className="text-2xl font-bold mb-4">Dashboard</h1>
      <div className="grid grid-cols-2 gap-4">
        {loading ? (
          <Card />
        ) : data ? (
          <div className="p-6 bg-white shadow-md rounded-lg text-center">
            <h2 className="text-lg font-semibold">Total Tasks</h2>
            <p className="text-4xl font-bold">{data.tasks.length}</p>
          </div>
        ) : (
          <Error />
        )}
        <div className="p-6 bg-white shadow-md rounded-lg text-center">
          <h2 className="text-lg font-semibold">Total Projects</h2>
          <p className="text-4xl font-bold">{4}</p>
        </div>
      </div>
    </section>
  );
};

export default Dashboard;
