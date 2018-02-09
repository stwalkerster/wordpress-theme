CREATE OR REPLACE VIEW vw_vias AS
SELECT
  ws.name,
  w.trip,
  w.reached,
  ws.x,
  ws.y,
  ws.z,
  w.sequence number
FROM waypoint w
INNER JOIN system ws ON ws.id = w.system
WHERE w.special IN ('v', 'a')
UNION ALL
SELECT
  s.name,
  t.id,
  1,
  s.x,
  s.y,
  s.z,
  0
  FROM trip t INNER JOIN system s ON s.id = t.from
;
