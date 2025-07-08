const mysql = require('mysql2/promise');

jest.mock('mysql2/promise');

const mockQuery = jest.fn();
let getTableData;

beforeAll(() => {
  mysql.createPool.mockReturnValue({ query: mockQuery });
  ({ getTableData } = require('../services/tableService'));
});

test('getTableData returns rows from the database', async () => {
  mockQuery.mockResolvedValueOnce([[{ id: 1 }]]);
  const rows = await getTableData('events');
  expect(mockQuery).toHaveBeenCalled();
  expect(rows).toEqual([{ id: 1 }]);
});
