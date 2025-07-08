import { Link } from 'react-router-dom'

function Home() {
  return (
    <div>
      <h1>CNICS Validation</h1>
      <p>Welcome to the CNICS Validation application.</p>

      <section>
        <h2>Administrative Tools</h2>
        <ul>
          <li>
            <Link to="/events/viewAll">View all events</Link>
          </li>
          <li>
            <Link to="/events/add">Add an event</Link>
          </li>
          <li>
            <Link to="/events/addMany">Add multiple events from a CSV file</Link>
          </li>
        </ul>
      </section>

      <section>
        <h2>Users</h2>
        <ul>
          <li>
            <Link to="/users/add">Add a user</Link>
          </li>
          <li>
            <Link to="/users/viewAll">Edit/Delete users</Link>
          </li>
        </ul>
      </section>

      <section>
        <h2>Upload Packets</h2>
        <ul>
          <li>
            <Link to="/events/upload">Upload New Packets</Link>
          </li>
          <li>
            <Link to="/events/upload">Re-upload Existing Packets</Link>
          </li>
        </ul>
      </section>

      <section>
        <h2>Reviewer Tools</h2>
        <ul>
          <li>
            <Link to="/events/review">Review Events</Link>
          </li>
        </ul>
      </section>
    </div>
  )
}

export default Home
