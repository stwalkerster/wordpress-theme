<?php if(get_post_meta(get_the_ID(), 'ed_skipstats', true) != 'yes'): ?>
	<hr />
	<h3>Statistics</h3>
	<table>
		<tbody>
			<?php
			$permastats = array('ed_current_location', 'ed_distance_from_jaques', 'ed_jumps_remaining', 'ed_jumps_made', 'ed_incident_count');
			
			foreach($permastats as $k){
				stw_ed_stat($k);
			}
			
			$postcustom = get_post_custom(get_the_ID());
			
			foreach($postcustom as $key => $value){
				
			}
			
			//print_r($postcustom);
			
			
			?>
		</tbody>
	</table>
<?php endif; ?>
