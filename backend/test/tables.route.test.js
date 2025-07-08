const express = require('express');
const request = require('supertest');

const tablesRouter = require('../routes/tables');
const tableService = require('../services/tableService');

jest.mock('../services/tableService');

test('GET /api/tables/:name returns json data', async () => {
  tableService.getTableData.mockResolvedValueOnce([{ id: 1 }]);

  const app = express();
  app.use('/api/tables', tablesRouter);

  const res = await request(app).get('/api/tables/events');
  expect(res.status).toBe(200);
  expect(res.body).toEqual({ data: [{ id: 1 }] });
});
