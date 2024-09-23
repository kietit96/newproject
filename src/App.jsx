import './App.scss'
import Head from './components/Header'
import { Route, Routes } from 'react-router-dom'

function App() {
  return (
    <>
      <Head />
      <Routes>
        <Route path='/'></Route>
      </Routes>
    </>
  )
}

export default App
