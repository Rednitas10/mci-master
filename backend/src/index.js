const express = require('express');
const session = require('express-session');
const Keycloak = require('keycloak-connect');
const dotenv = require('dotenv');

const tablesRouter = require('../routes/tables');

dotenv.config();

const PORT = process.env.PORT || 3000;

const app = express();

// Setup Keycloak middleware if configuration is provided
let keycloak;
if (process.env.KEYCLOAK_REALM) {
  const memoryStore = new session.MemoryStore();
  keycloak = new Keycloak({ store: memoryStore });
  app.use(session({ secret: 'change-me', resave: false, saveUninitialized: true, store: memoryStore }));
  app.use(keycloak.middleware());
  app.use('/api', keycloak.protect());
}

app.use(express.json());
app.use('/api/tables', tablesRouter);

app.listen(PORT, () => {
  console.log(`Backend API listening on port ${PORT}`);
});

module.exports = app;
