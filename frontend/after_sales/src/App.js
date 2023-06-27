import logo from "./logo.svg";
import "./App.css";
import ReactDOM from "react-dom/client";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Demo from "./pages/Demo";

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="demo" element={<Demo />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
