<?php
if(get_post_meta(get_the_ID(), 'ed_post_mode', true) != '') :
    switch(get_post_meta(get_the_ID(), 'ed_post_mode', true)) :
        case 'trip':
            get_template_part('elitetrip');
            break;
        case 'session':
            get_template_part('elitesession');
            break;
    endswitch;
endif;
