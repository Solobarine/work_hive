import React from "react";
import { NavLink } from "react-router-dom";

const Header = () => {
  return (
    <header className="flex items-center justify-end p-2">
      <nav className="flex items-center gap-4 justify-end text-sm font-semibold">
        <NavLink to="/register">Register</NavLink>
        <NavLink to="/login">Login</NavLink>
      </nav>
    </header>
  );
};

export default Header;
