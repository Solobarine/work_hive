import { createContext, useState, ReactNode } from "react";
import { TaskInterface } from "../interfaces/task";
import useFetch from "../hooks/useFetch";
import { SERVER_URL } from "../config/server";

interface TaskContextProps {
  tasks: TaskInterface[];
  getAllTasks: (tasks: TaskInterface[]) => void;
  addTask: (task: TaskInterface) => void;
  updateTask: (id: number, updatedTask: TaskInterface) => void;
  deleteTask: (id: number) => void;
}

export const TaskContext = createContext<TaskContextProps>({
  tasks: [],
  getAllTasks: () => {},
  addTask: () => {},
  updateTask: () => {},
  deleteTask: () => {},
});

export const TaskContextProvider = ({ children }: { children: ReactNode }) => {
  const [tasks, setTasks] = useState<TaskInterface[]>([]);

  const getAllTasks = (tasks: TaskInterface[]) => {
    setTasks(tasks);
  };
  const addTask = (task: TaskInterface) => {
    setTasks([...tasks, { ...task, id: tasks.length + 1 }]);
  };

  const updateTask = (id: number, updatedTask: TaskInterface) => {
    setTasks(tasks.map((task) => (task.id === id ? updatedTask : task)));
  };

  const deleteTask = (id: number) => {
    setTasks(tasks.filter((task) => task.id !== id));
  };

  return (
    <TaskContext.Provider
      value={{ tasks, getAllTasks, addTask, updateTask, deleteTask }}
    >
      {children}
    </TaskContext.Provider>
  );
};
