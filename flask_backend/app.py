from flask import Flask, jsonify
import os
from dotenv import load_dotenv
from . import table_service

load_dotenv()

app = Flask(__name__)

@app.route('/api/tables/<name>')
def get_table(name):
    try:
        rows = table_service.get_table_data(name)
        return jsonify({'data': rows})
    except Exception as exc:
        print(exc)
        return jsonify({'error': 'Failed to fetch table data'}), 500

if __name__ == '__main__':
    port = int(os.getenv('PORT', '3000'))
    app.run(host='0.0.0.0', port=port)
