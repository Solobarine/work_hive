import React, { useContext, useState } from "react";
import { TaskContext } from "../../../context/Task";
import { TaskInterface } from "../../../interfaces/task";
import useFetch from "../../../hooks/useFetch";
import { SERVER_URL } from "../../../config/server";

const Create = () => {
  const { tasks, addTask } = useContext(TaskContext);
  const [title, setTitle] = useState("");
  const [description, setDescription] = useState("");
  const [status, setStatus] = useState<"pending" | "ongoing" | "completed">(
    "pending"
  );
  const [priority, setPriority] = useState<"low" | "medium" | "high">("low");

  const {
    data,
    loading,
    fetchData,
  }: {
    data: { status: boolean; task: TaskInterface } | null;
    loading: boolean;
    fetchData: (options: any) => {};
  } = useFetch(`${SERVER_URL}/tasks`, "POST");

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    const newTask: TaskInterface = {
      id: 0,
      title,
      description,
      status,
      priority,
    };

    fetchData({ body: newTask });

    if (data) {
      addTask(data.task);

      setTitle("");
      setDescription("");
      setStatus("pending");
      setPriority("low");
    }
  };
  console.log(data, tasks);
  return (
    <form
      onSubmit={handleSubmit}
      className="container mx-auto p-4 bg-gray-100 shadow-md rounded-md"
    >
      <div className="mb-4">
        <label className="block text-gray-700">Title</label>
        <input
          type="text"
          value={title}
          onChange={(e) => setTitle(e.target.value)}
          className="w-full p-2 border border-gray-300 rounded"
        />
      </div>

      <div className="mb-4">
        <label className="block text-gray-700">Description</label>
        <textarea
          value={description}
          onChange={(e) => setDescription(e.target.value)}
          className="w-full p-2 border border-gray-300 rounded"
        />
      </div>

      <div className="mb-4">
        <label className="block text-gray-700">Status</label>
        <select
          value={status}
          onChange={(e) =>
            setStatus(e.target.value as "pending" | "ongoing" | "completed")
          }
          className="w-full p-2 border border-gray-300 rounded"
        >
          <option value="pending">Pending</option>
          <option value="ongoing">Ongoing</option>
          <option value="completed">Completed</option>
        </select>
      </div>

      <div className="mb-4">
        <label className="block text-gray-700">Priority</label>
        <select
          value={priority}
          onChange={(e) =>
            setPriority(e.target.value as "low" | "medium" | "high")
          }
          className="w-full p-2 border border-gray-300 rounded"
        >
          <option value="low">Low</option>
          <option value="medium">Medium</option>
          <option value="high">High</option>
        </select>
      </div>

      <button
        type="submit"
        disabled={loading}
        className="bg-blue-500 text-white py-2 px-4 rounded"
      >
        {loading ? "Please Wait..." : "Add Task"}
      </button>
    </form>
  );
};

export default Create;
