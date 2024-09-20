import { useState } from "react";
import { NavLink } from "react-router-dom";

const Menu = () => {
  const [isCollapsed, setIsCollapsed] = useState(true);

  return (
    <div
      className={`basis-${
        isCollapsed ? "12" : "96"
      } h-screen bg-gray-600 text-white flex flex-col shrink-0 grow`}
    >
      {/* Menu Toggle Button */}
      <button
        onClick={() => setIsCollapsed(!isCollapsed)}
        className="p-4 focus:outline-none"
      >
        {isCollapsed ? "☰" : "✕"}
      </button>

      {/* Menu Links */}
      <nav className="flex flex-col mt-8 space-y-4">
        <NavLink
          to="/dashboard"
          className="p-4 hover:bg-gray-700 flex items-center"
        >
          <span className="mr-2">📊</span>
          {!isCollapsed && <span>Dashboard</span>}
        </NavLink>
        <NavLink
          to="/tasks"
          className="p-4 hover:bg-gray-700 flex items-center"
        >
          <span className="mr-2">✏️</span>
          {!isCollapsed && <span>Tasks</span>}
        </NavLink>

        <NavLink
          to="/tasks/new"
          className="p-4 hover:bg-gray-700 flex items-center"
        >
          <span className="mr-2">✏️</span>
          {!isCollapsed && <span>Create Task</span>}
        </NavLink>
      </nav>
    </div>
  );
};

export default Menu;
