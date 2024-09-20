import { useContext, useEffect } from "react";
import { TaskContext } from "../../../context/Task";
import { TaskInterface } from "../../../interfaces/task";
import useFetch from "../../../hooks/useFetch";
import { SERVER_URL } from "../../../config/server";
import Loading from "../../loading/Index";
import Error from "../../../components/Error";

const TaskList: React.FC = () => {
  const { tasks, getAllTasks, deleteTask } = useContext(TaskContext);

  const {
    data: taskList,
    loading,
    fetchData,
  }: {
    data: { status: boolean; tasks: TaskInterface[] } | null;
    error: string | null;
    loading: boolean;
    fetchData: () => {};
  } = useFetch(`${SERVER_URL}/tasks`, "GET");

  useEffect(() => {
    fetchData();
  }, []);

  useEffect(() => {
    if (taskList) {
      getAllTasks(taskList?.tasks as TaskInterface[]);
    }
  }, []);

  console.log(tasks);

  return (
    <div className="container mx-auto">
      <h1 className="text-2xl font-bold mb-4">TaskInterface List</h1>
      {loading ? (
        <Loading />
      ) : taskList ? (
        <div className="grid gap-4">
          {taskList?.tasks.map((task: TaskInterface) => (
            <div key={task.id} className="p-4 bg-white shadow rounded">
              <h2 className="text-xl font-semibold">{task.title}</h2>
              <p>{task.description}</p>
              <p>Status: {task.status}</p>
              <p>Priority: {task.priority}</p>
              <button
                onClick={() => deleteTask(task.id)}
                className="mt-2 bg-red-500 text-white py-1 px-3 rounded"
              >
                Delete
              </button>
            </div>
          ))}
        </div>
      ) : (
        <Error />
      )}
    </div>
  );
};

export default TaskList;
