const mysql = require('mysql2/promise');
const dotenv = require('dotenv');

dotenv.config();

const pool = mysql.createPool({
  host: process.env.DB_HOST || 'localhost',
  user: process.env.DB_USER || 'root',
  password: process.env.DB_PASSWORD || '',
  database: process.env.DB_NAME || 'mci',
  waitForConnections: true,
  connectionLimit: 10,
});

async function getTableData(tableName) {
  const [rows] = await pool.query(`SELECT * FROM \`${tableName}\` LIMIT 100`);
  return rows;
}

module.exports = { getTableData };
