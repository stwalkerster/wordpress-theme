<?php
$sessionId = get_post_meta(get_the_ID(), 'ed_session_id', true);;

$basicInfoSql = "
SELECT
  s.jumpsmade,
  s.madness,
  sys.name  AS current_system,
  sys.x as curr_x,
  sys.y as curr_y,
  sys.z as curr_z,
  wsys.name AS next_waypoint,
  wsys.x as next_x,
  wsys.y as next_y,
  wsys.z as next_z,
  coalesce(inc.incidents, 0) as incidents,
  t.jumprange
FROM stwalkerster_ed_explore.session s
  INNER JOIN stwalkerster_ed_explore.system sys ON sys.id = s.currentsystem
  LEFT JOIN stwalkerster_ed_explore.waypoint w ON w.id = s.nextwaypoint
  LEFT JOIN stwalkerster_ed_explore.system wsys ON w.system = wsys.id
  LEFT JOIN (
    select i.session, sum(i.delta) incidents
from stwalkerster_ed_explore.incident i
inner join stwalkerster_ed_explore.incidenttype it on it.id = i.type
where it.technical = 0
group by i.session
    ) inc on inc.session = s.id
  INNER JOIN stwalkerster_ed_explore.trip t on t.id = s.trip
WHERE s.id = %d";

$waypointsSql = "
select sys.name, sys.x, sys.y, sys.z
from stwalkerster_ed_explore.waypoint w
  inner join stwalkerster_ed_explore.trip t on t.id = w.trip
  inner join stwalkerster_ed_explore.session s on s.trip = t.id
  inner join stwalkerster_ed_explore.waypoint nwp on s.nextwaypoint = nwp.id
  inner join stwalkerster_ed_explore.system sys on w.system = sys.id
where w.sequence >= nwp.sequence
  and w.special in ('v','a')
  and s.id = %d
";

$incidentsSql = "
select it.description, i.delta
from stwalkerster_ed_explore.incident i
inner join stwalkerster_ed_explore.incidenttype it on it.id = i.type
where i.session = %d and it.technical = %d
";

$basicInfo = $wpdb->get_row($wpdb->prepare($basicInfoSql, $sessionId));
$waypoints = $wpdb->get_results($wpdb->prepare($waypointsSql, $sessionId));

$nontechIncidents = $wpdb->get_results($wpdb->prepare($incidentsSql, $sessionId, 0));
$techIncidents = $wpdb->get_results($wpdb->prepare($incidentsSql, $sessionId, 1));

?>
<h2>Statistics</h2>
<table>
	<tbody>
		<tr>
			<td>Current location</td>
			<td><?= $basicInfo->current_system ?></td>
		</tr>
		<tr>
			<td>Next waypoint</td>
			<td><?= $basicInfo->next_waypoint ?></td>
		</tr>
		<?php 
			$lastWp = new stdClass;
			$lastWp->x = $basicInfo->curr_x;			
			$lastWp->y = $basicInfo->curr_y;			
			$lastWp->z = $basicInfo->curr_z;			
			$bestCaseJumps = 0; 
			$partialData = false;
			
			foreach($waypoints as $v) : ?>
		<tr>
			<td>Distance from <?= $v->name ?></td>
			<td><?php
				if($v->x === null || $lastWp->x === null || $partialData) {	
					$partialData = true;
					echo '<em>Unknown</em>';
				} else {
					$dX = $v->x - $lastWp->x;
					$dY = $v->y - $lastWp->y;
					$dZ = $v->z - $lastWp->z;
					$dist = sqrt(pow($dX,2)+pow($dY,2)+pow($dZ,2));
					$bestCaseJumps += ceil($dist / $basicInfo->jumprange);
					
					echo round($dist, 2) . " ly";	
				}
			?></td>
		</tr>
		<?php $lastWp = $v; ?>
		<?php endforeach; ?>
		<tr>
			<td>Incident count</td>
			<td><?= $basicInfo->incidents ?></td>
		</tr>
		<tr>
			<td>Jumps made</td>
			<td><?= $basicInfo->jumpsmade ?></td>
		</tr>
		<tr>
			<td>Jumps remaining (best case)</td>
			<td><?= $partialData ? '<em>Unknown</em>' : $bestCaseJumps ?></td>
		</tr>
		<tr>
			<td>Space madness</td>
			<td><?= $basicInfo->madness ?> %</td>
		</tr>
	</tbody>
</table>

<?php if(count($nontechIncidents) > 0) : ?>
<h3>Incidents</h3>
<table>
<?php foreach($nontechIncidents as $inc) : ?>
<tr><td><?= $inc->description ?></td><td><?= $inc->delta ?></td></tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
<?php if(count($techIncidents) > 0) : ?>
<h3>Technical issues</h3>
<table>
<?php foreach($techIncidents as $inc) : ?>
<tr><td><?= $inc->description ?></td><td><?= $inc->delta ?></td></tr>
<?php endforeach; ?>
</table>
<?php endif; ?>