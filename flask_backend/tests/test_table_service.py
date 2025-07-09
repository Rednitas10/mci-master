from unittest.mock import MagicMock, patch
import flask_backend.table_service as ts

@patch('mysql.connector.connect')
def test_get_table_data(mock_connect):
    mock_conn = MagicMock()
    mock_cursor = MagicMock()
    mock_cursor.fetchall.return_value = [{'id': 1}]
    mock_conn.cursor.return_value = mock_cursor
    mock_connect.return_value = mock_conn

    rows = ts.get_table_data('events')

    mock_connect.assert_called()
    mock_cursor.execute.assert_called_with('SELECT * FROM `events` LIMIT 100')
    assert rows == [{'id': 1}]
