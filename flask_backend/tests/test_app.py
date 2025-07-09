from flask_backend.app import app
from unittest.mock import patch

@patch('flask_backend.table_service.get_table_data')
def test_get_table_route(mock_service):
    mock_service.return_value = [{'id': 1}]
    client = app.test_client()
    res = client.get('/api/tables/events')
    assert res.status_code == 200
    assert res.get_json() == {'data': [{'id': 1}]}
