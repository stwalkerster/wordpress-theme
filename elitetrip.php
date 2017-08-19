<?php
$tripId = get_post_meta(get_the_ID(), 'ed_trip_id', true);
$jumpRange = $wpdb->get_var($wpdb->prepare('select jumprange from stwalkerster_ed_explore.trip where id = %d', $tripId));

$waypointData = $wpdb->get_results(
	$wpdb->prepare("
select
    1 as ordergroup
  , 0 as ordergroup2
  , 'Departure' as stage
  , s.name as system
  , null as source
  , 0 as reached
  , t.departurestation as waypointnotes
from stwalkerster_ed_explore.trip t
  inner join stwalkerster_ed_explore.system s on s.id = t.`from`
where t.id = %d
union all
select
    3 as ordergroup
  , 0 as ordergroup2
  , 'Arrival' as stage
  , s.name as system
  , concat('CMDR ', c.name) as source
  , w.reached as reached
  , t.arrivalstation as waypointnotes
from stwalkerster_ed_explore.trip t
  inner join stwalkerster_ed_explore.waypoint w on w.id = t.to and w.special = 'a'
  inner join stwalkerster_ed_explore.system s on s.id = w.system
  left join stwalkerster_ed_explore.commander c on c.id = w.commander
where t.id = %d
union all
select
    2 as ordergroup
  , w.sequence as ordergroup2
  , case w.special
		when 'v' then concat('Via ', w.number)
        when 'n' then concat('Neutron Waypoint ', w.number)
		else concat('Waypoint ', w.number)
	end as stage
  , coalesce(s.name, '<i>Unplotted</i>') as system
  , concat('CMDR ', c.name) as source
  , w.reached as reached
  , w.notes as waypointnotes
from stwalkerster_ed_explore.waypoint w
  left join stwalkerster_ed_explore.system s on s.id = w.system
  left join stwalkerster_ed_explore.commander c on c.id = w.commander
where w.trip = %d
  and coalesce(w.special, 'v') in ('v', 'n')
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
      SELECT max(ms.id)
      FROM stwalkerster_ed_explore.session ms
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
  SELECT max(ms.id)
  FROM stwalkerster_ed_explore.session ms
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

$currentLocationSql = "SELECT s.name, s.cx x, s.cy y, s.cz z FROM stwalkerster_ed_explore.vw_currentposition s WHERE s.trip = %d";
$currentLocation = $wpdb->get_row($wpdb->prepare($currentLocationSql, $tripId));

$viasSql = "
select next.name,
  round(case
    when 1=2 then null
    when next.reached = 1 then 0
    when curr.reached = 1 then sqrt(power(next.x - currpos.cx, 2) + power(next.y - currpos.cy, 2) + power(next.z - currpos.cz, 2))
    else sqrt(power(next.x - curr.x, 2) + power(next.y - curr.y, 2) + power(next.z - curr.z, 2))
  end, 2) as dist,
  round(sqrt(power(next.x - curr.x, 2) + power(next.y - curr.y, 2) + power(next.z - curr.z, 2)), 2) as origdist
from stwalkerster_ed_explore.vw_vias curr
inner join stwalkerster_ed_explore.vw_vias next on next.number = (curr.number + 100) and next.trip = curr.trip
left join stwalkerster_ed_explore.vw_currentposition currpos on currpos.trip = curr.trip
where curr.trip = %d
order by next.number
";

$vias = $wpdb->get_results($wpdb->prepare($viasSql, $tripId), OBJECT);

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
			<td<?php if($waypoint['waypointnotes'] !== null) echo ' rowspan="2"'; ?>><?php if($waypoint['reached']) echo '<del>' . $waypoint['stage'] . '</del>'; else echo $waypoint['stage']; ?></td>
			<td><?php if($waypoint['reached']) echo '<del>' . $waypoint['system'] . '</del>'; else echo $waypoint['system']; ?></td>
			<td style="color: #bbbbbb; font-size:smaller;"><?php if($waypoint['reached']) echo '<del>' . $waypoint['source'] . '</del>'; else echo $waypoint['source']; ?></td>
		</tr>
        <?php if($waypoint['waypointnotes'] !== null) : ?>
            <tr><td colspan="2" style="border-top:none;padding-top: 0;font-weight: bold;"><?= $waypoint['waypointnotes'] ?></td></tr>
        <?php endif; ?>
<?php endforeach; ?>
	</tbody>
</table>

<h2>Current position</h2>
<table>
	<thead>
		<tr>
			<th></th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Current Location</td>
			<td colspan="2"><?= $currentLocation->name ?></td>
		</tr>
		<?php $bestCaseJumps = 0; ?>
		<?php foreach($vias as $v) : ?>
		<tr>
			<td>Distance from <?= $v->name ?></td>
			<td><?php
                $bestCaseJumps += ceil($v->dist / $jumpRange);
				echo round($v->dist, 2) . " ly";
				if($v->origdist != $v->dist) {
                    echo ' remaining <span style="color: #bbbbbb; font-size:x-small">(' . $v->origdist . ' ly)</span>';
                }
			?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td>Jumps made</td>
			<td><?= $jumpsMade ?></td>
		</tr>
		<tr>
			<td>Jump range</td>
			<td><?= round($jumpRange, 2) ?> ly</td>
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
			<th><abbr title="Total this trip">Σ</abbr></th>
			<th><abbr title="Last session">Δ</abbr></th>
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
			<th><abbr title="Total this trip">Σ</abbr></th>
			<th><abbr title="Last session">Δ</abbr></th>
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
