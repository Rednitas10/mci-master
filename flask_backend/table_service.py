import os
import mysql.connector
from dotenv import load_dotenv

load_dotenv()

DB_CONFIG = {
    'host': os.getenv('DB_HOST', 'localhost'),
    'user': os.getenv('DB_USER', 'root'),
    'password': os.getenv('DB_PASSWORD', ''),
    'database': os.getenv('DB_NAME', 'mci'),
}

def get_table_data(name: str):
    """Return up to 100 rows from the specified table."""
    conn = mysql.connector.connect(**DB_CONFIG)
    cursor = conn.cursor(dictionary=True)
    cursor.execute(f"SELECT * FROM `{name}` LIMIT 100")
    rows = cursor.fetchall()
    cursor.close()
    conn.close()
    return rows
