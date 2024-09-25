import "./App.scss"
import Head from "./components/Header"
import {Route, Routes} from "react-router-dom"
import Home from "./components/Home"

function App() {
  return (
    <>
      <Head />
      <Routes>
        <Route path='/' element={<Home />}></Route>
      </Routes>
    </>
  )
}

export default App
