<?php
$tripId = get_post_meta(get_the_ID(), 'ed_trip_id', true);
$jumpRange = $wpdb->get_var($wpdb->prepare('select jumprange from stwalkerster_ed_explore.trip where id = %d', $tripId));

$waypointData = $wpdb->get_results(
	$wpdb->prepare("
select
    1 as ordergroup
  , 0 as ordergroup2
  , 'Departure' as stage
  , concat(coalesce(concat(t.departurestation, ', '),''), s.name) as system
  , null as source
  , 0 as reached
from stwalkerster_ed_explore.trip t
  inner join stwalkerster_ed_explore.system s on s.id = t.`from`
where t.id = %d
union all
select
    3 as ordergroup
  , 0 as ordergroup2
  , 'Arrival' as stage
  , concat(coalesce(concat(t.arrivalstation, ', '),''), s.name) as system
  , null as source
  , w.reached as reached
from stwalkerster_ed_explore.trip t
  inner join stwalkerster_ed_explore.waypoint w on w.id = t.to and w.special = 'a'
  inner join stwalkerster_ed_explore.system s on s.id = w.system
where t.id = %d
union all
select
    2 as ordergroup
  , w.sequence as ordergroup2
  , case w.special
		when 'v' then concat('Via ', w.number)
		else concat('Waypoint ', w.number)
	end as stage
  , coalesce(s.name, '<i>Unplotted</i>') as system
  , concat('CMDR ', c.name) as source
  , w.reached as reached
from stwalkerster_ed_explore.waypoint w
  left join stwalkerster_ed_explore.system s on s.id = w.system
  left join stwalkerster_ed_explore.commander c on c.id = w.commander
where w.trip = %d
  and coalesce(w.special, 'v') = 'v' 
order by ordergroup, ordergroup2;
", $tripId, $tripId, $tripId), ARRAY_A);

$incidentDataQuery = "
select
    it.description
  , coalesce(total.sum, 0) as sum
  , coalesce(delta.delta, 0) as delta
from stwalkerster_ed_explore.incidenttype it
left join (
    SELECT
      i.type,
      sum(delta) as sum
    FROM stwalkerster_ed_explore.incident i
      INNER JOIN stwalkerster_ed_explore.session s ON s.id = i.session
    WHERE s.trip = %d
    GROUP BY i.type
    ) total on total.type = it.id
left join (
    SELECT si.type, si.delta
    FROM stwalkerster_ed_explore.incident si
    WHERE si.session = (
      SELECT max(mi.session)
      FROM stwalkerster_ed_explore.incident mi
        INNER JOIN stwalkerster_ed_explore.session ms ON mi.session = ms.id
      WHERE ms.trip = %d)
    ) delta on delta.type = it.id
where it.technical = %d
and (hidden = 0 or sum > 0)
";

$incidentSumQuery = "
SELECT
  coalesce(sum(delta), 0) as sum
FROM stwalkerster_ed_explore.incident i
  INNER JOIN stwalkerster_ed_explore.session s ON s.id = i.session
  INNER JOIN stwalkerster_ed_explore.incidenttype it on i.type = it.id
WHERE s.trip = %d and it.technical = %d;
";

$incidentDeltaQuery = "
SELECT coalesce(sum(si.delta), 0)
FROM stwalkerster_ed_explore.incident si
  INNER JOIN stwalkerster_ed_explore.incidenttype it on si.type = it.id
WHERE si.session = (
  SELECT max(mi.session)
  FROM stwalkerster_ed_explore.incident mi
    INNER JOIN stwalkerster_ed_explore.session ms ON mi.session = ms.id
  WHERE ms.trip = %d)
AND it.technical = %d
";

$nontechData = $wpdb->get_results($wpdb->prepare($incidentDataQuery, $tripId, $tripId, 0), ARRAY_A);
$techData = $wpdb->get_results($wpdb->prepare($incidentDataQuery, $tripId, $tripId, 1), ARRAY_A);

$nontechSum = $wpdb->get_var($wpdb->prepare($incidentSumQuery, $tripId, 0));
$techSum = $wpdb->get_var($wpdb->prepare($incidentSumQuery, $tripId, 1));

$nontechDelta = $wpdb->get_var($wpdb->prepare($incidentDeltaQuery, $tripId, 0));
$techDelta = $wpdb->get_var($wpdb->prepare($incidentDeltaQuery, $tripId, 1));

$jumpsMadeSql = "select coalesce(sum(jumpsmade),0) jumps from stwalkerster_ed_explore.session where trip = %d";
$jumpsMade = $wpdb->get_var($wpdb->prepare($jumpsMadeSql, $tripId));

$currentLocationSql = "
SELECT
  sys.name,
  sys.x,
  sys.y,
  sys.z
FROM stwalkerster_ed_explore.session s
  LEFT JOIN stwalkerster_ed_explore.system sys ON sys.id = s.currentsystem
WHERE s.trip = %d
      AND s.id = (
  SELECT max(sm.id)
  FROM stwalkerster_ed_explore.session sm
  WHERE sm.trip = s.trip
)
UNION ALL
SELECT
  sys.name,
  sys.x,
  sys.y,
  sys.z
FROM stwalkerster_ed_explore.trip t 
  INNER JOIN stwalkerster_ed_explore.system sys ON sys.id = t.from
WHERE t.id = %d
";

$lastLocationSql = "
SELECT subq.name, subq.x, subq.y, subq.z
FROM (
SELECT
  sys.name,
  sys.x,
  sys.y,
  sys.z
FROM stwalkerster_ed_explore.session s
  LEFT JOIN stwalkerster_ed_explore.system sys ON sys.id = s.currentsystem
WHERE s.trip = %d
      AND s.id < (
  SELECT max(sm.id)
  FROM stwalkerster_ed_explore.session sm
  WHERE sm.trip = s.trip
)
order by s.id DESC
limit 1 ) subq
UNION ALL
SELECT
  sys.name,
  sys.x,
  sys.y,
  sys.z
FROM stwalkerster_ed_explore.session s
  LEFT JOIN stwalkerster_ed_explore.system sys ON sys.id = s.currentsystem
WHERE s.trip = %d
      AND s.id = (
  SELECT max(sm.id)
  FROM stwalkerster_ed_explore.session sm
  WHERE sm.trip = s.trip
)
UNION ALL
SELECT
  sys.name,
  sys.x,
  sys.y,
  sys.z
FROM stwalkerster_ed_explore.trip t 
  INNER JOIN stwalkerster_ed_explore.system sys ON sys.id = t.from
WHERE t.id = %d
";

$currentLocation = $wpdb->get_row($wpdb->prepare($currentLocationSql, $tripId, $tripId));
$lastLocation = $wpdb->get_row($wpdb->prepare($lastLocationSql, $tripId, $tripId, $tripId));

$viasSql = "
SELECT
  sys.name,
  sys.x,
  sys.y,
  sys.z
FROM (
       SELECT
         1 AS rgroup,
         system,
         number,
         trip
       FROM stwalkerster_ed_explore.waypoint
       WHERE trip = %d and special = 'v'
       UNION ALL
       SELECT
         2,
         w.system,
         0,
         t.id
       FROM stwalkerster_ed_explore.trip t
	   INNER JOIN stwalkerster_ed_explore.waypoint w on t.to = w.id
       WHERE t.id = %d
     ) wp
  INNER JOIN stwalkerster_ed_explore.system sys ON sys.id = wp.system
ORDER BY wp.rgroup, wp.number
";

$vias = $wpdb->get_results($wpdb->prepare($viasSql, $tripId, $tripId), OBJECT);

?>
<h2>Route Plan</h2>
<table>
	<thead>
		<tr>
			<th>Stage</th>
			<th>System</th>
			<th>Waypoint Source</th>
		</tr>
	</thead>
	<tbody>
<?php foreach($waypointData as $waypoint) : ?>
		<tr>
			<td><?php if($waypoint['reached']) echo '<del>' . $waypoint['stage'] . '</del>'; else echo $waypoint['stage']; ?></td>
			<td><?php if($waypoint['reached']) echo '<del>' . $waypoint['system'] . '</del>'; else echo $waypoint['system']; ?></td>
			<td><?php if($waypoint['reached']) echo '<del>' . $waypoint['source'] . '</del>'; else echo $waypoint['source']; ?></td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>

<h2>Current position</h2>
<table>
	<thead>
		<tr>
			<th/>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Current Location</td>
			<td colspan="2"><?= $currentLocation->name ?></td>
		</tr>
		<?php $lastWp = $currentLocation; $bestCaseJumps = 0; ?>
		<?php foreach($vias as $v) : ?>
		<tr>
			<td>Distance from <?= $v->name ?></td>
			<td><?php
				$dX = $v->x - $lastWp->x;
				$dY = $v->y - $lastWp->y;
				$dZ = $v->z - $lastWp->z;
				$dist = sqrt(pow($dX,2)+pow($dY,2)+pow($dZ,2));
				$bestCaseJumps += ceil($dist / $jumpRange);
				
				echo round($dist, 2) . " ly";
			?></td>
		</tr>
		<?php $lastWp = $v; ?>
		<?php endforeach; ?>
		<tr>
			<td>Jumps made</td>
			<td><?= $jumpsMade ?></td>
		</tr>
		<tr>
			<td>Jump range</td>
			<td><?= $jumpRange ?> ly</td>
		</tr>
		<tr>
			<td>Best case jumps remaining</td>
			<td><?= $bestCaseJumps ?></td>
		</tr>
	</tbody>
</table>

<h2>Incidents</h2>
<table>
	<thead>
		<tr>
			<th rowspan="2">Type</th>
			<th>Σ</th>
			<th>Δ</th>
		</tr>
		<tr>
			<td><?= $nontechSum ?></td>
			<td><?= $nontechDelta ?></td>
		</tr>
	</thead>
	<tbody>
		<?php foreach($nontechData as $inc) : ?>
		<tr>
			<td><?= $inc['description'] ?></td>
			<td><?= $inc['sum'] ?></td>
			<td><?= $inc['delta'] ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<h2>Technical issues</h2>
<table>
	<thead>
		<tr>
			<th rowspan="2">Type</th>
			<th>Σ</th>
			<th>Δ</th>
		</tr>
		<tr>
			<td><?= $techSum ?></td>
			<td><?= $techDelta ?></td>
		</tr>
	</thead>
	<tbody>
		<?php foreach($techData as $inc) : ?>
		<tr>
			<td><?= $inc['description'] ?></td>
			<td><?= $inc['sum'] ?></td>
			<td><?= $inc['delta'] ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>