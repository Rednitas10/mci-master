const express = require('express');
const { getTableData } = require('../services/tableService');

const router = express.Router();

router.get('/:name', async (req, res) => {
  try {
    const rows = await getTableData(req.params.name);
    res.json({ data: rows });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: 'Failed to fetch table data' });
  }
});

module.exports = router;