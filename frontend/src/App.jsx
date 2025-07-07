import { BrowserRouter as Router, Route, Routes } from 'react-router-dom'
import BaseLayout from './components/BaseLayout'
import Home from './pages/Home'
import EventIndex from './pages/EventIndex'

function App() {
  const auth = { admin: true, uploader: true, reviewer: true, username: 'demo' }

  return (
    <Router>
      <BaseLayout auth={auth}>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/events" element={<EventIndex />} />
        </Routes>
      </BaseLayout>
    </Router>
  )
}

export default App
