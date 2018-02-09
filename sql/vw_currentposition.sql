CREATE VIEW stwalkerster_ed_explore.vw_currentposition AS
  SELECT
    `t`.`id`                           AS `trip`,
    coalesce(`ss`.`x`, `ts`.`x`)       AS `cx`,
    coalesce(`ss`.`y`, `ts`.`y`)       AS `cy`,
    coalesce(`ss`.`z`, `ts`.`z`)       AS `cz`,
    coalesce(`ss`.`name`, `ts`.`name`) AS `name`,
    coalesce(`ss`.`id`, `ts`.`id`)     AS `system`
  FROM (((`stwalkerster_ed_explore`.`trip` `t` LEFT JOIN `stwalkerster_ed_explore`.`session` `sess`
      ON (((`sess`.`trip` = `t`.`id`) AND (`sess`.`id` = (SELECT max(`sessids`.`id`)
                                                          FROM `stwalkerster_ed_explore`.`session` `sessids`
                                                          WHERE (`sessids`.`trip` = `t`.`id`)))))) LEFT JOIN
    `stwalkerster_ed_explore`.`system` `ss` ON ((`ss`.`id` = `sess`.`currentsystem`))) JOIN
    `stwalkerster_ed_explore`.`system` `ts` ON ((`ts`.`id` = `t`.`from`)))
  ORDER BY `t`.`id`;

