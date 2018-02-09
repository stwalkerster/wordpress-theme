<?php
/**
 * Template Name: ED Triplist page tempalte
 * Description: A Page Template that adds the alternate sidebar to pages
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

<?php
        $tripData = $wpdb->get_results("
select
    date_format(
        date_add(t.departure, INTERVAL 1286 YEAR),
        '%D %b %Y'
    ) as departure
  , concat(coalesce(concat(t.departurestation, ',<br />'),''), sysfrom.name) as departure_location
  , concat('<ul><li style=\"font-size:smaller\">', group_concat(sysv.name order by v.sequence asc separator '</li><li style=\"font-size:smaller\">'), '</li></ul>') as via
  , concat(coalesce(concat(t.arrivalstation, ',<br />'),''), systo.name) as arrival_location
  , date_format(
        date_add(t.arrival, INTERVAL 1286 YEAR),
        '%D %b %Y'
    ) as arrival
  , t.linkpage
  , t.linktag
from stwalkerster_ed_explore.trip t
  inner join stwalkerster_ed_explore.waypoint wto on wto.id = t.to and wto.special = 'a'
  inner join stwalkerster_ed_explore.system systo on wto.system = systo.id
  inner join stwalkerster_ed_explore.system sysfrom on sysfrom.id = t.from
  left join stwalkerster_ed_explore.waypoint v on v.trip = t.id and v.special = 'v'
  left join stwalkerster_ed_explore.system sysv on v.system = sysv.id
group by t.departure, sysfrom.name, systo.name, t.arrival, t.linkpage, t.linktag
order by coalesce(t.departure, '9999-12-31');
", ARRAY_A);
?>
                    <table class="entry-content" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Departure date</th>
                                <th>Departure location</th>
                                <th>Via</th>
                                <th>Arrival location</th>
                                <th>Arrival date</th>
                                <th>Posts</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($tripData as $trip): ?>
                            <tr>
                                <td colspan="6">
                                    <h2 class="triptitle"><?php echo $trip['linkpage'] ?></h2>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $trip['departure'] ?></td>
                                <td><?php echo $trip['departure_location'] ?></td>
                                <td><?php echo $trip['via'] ?></td>
                                <td><?php echo $trip['arrival_location'] ?></td>
                                <td><?php echo $trip['arrival'] ?></td>
                                <td><?php echo $trip['linktag'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>
