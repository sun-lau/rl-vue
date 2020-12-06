/*crontab -e */
/* create new set of experiment */

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'PHOTO_ELECTRIC', 'set_0', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'PHOTO_ELECTRIC', 'set_0', 'camera_0', '', 'ip', 0, 0, 0, 0);
INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'PHOTO_ELECTRIC', 'set_0', 'camera_1', '', 'ip', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'PHOTO_ELECTRIC', 'set_0', 'device_0', '', '', 0, 0, 0, 0);
INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'PHOTO_ELECTRIC', 'set_0', 'device_1', '', '', 0, 0, 0, 0);



UPDATE `rl_experiment` SET `value`='{"temperature_0":12.9,"temperature_1":22,"co2_value":1,"light":0,"air":0}' WHERE id=66; 


UPDATE `rl_experiment` SET `value`='{"url":"https://stem-video-ap.polyu.edu.hk/stream/INTERFERENCE_00/CAM0002"}' WHERE id=15;   /* 15 | INTERFERENCE     | set_0        | camera_0 */

UPDATE `rl_experiment` SET `value`='{"url":"https://stem-video-ap.polyu.edu.hk/stream/INTERFERENCE_00/CAM0003"}' WHERE id=16;   /* 16 | INTERFERENCE     | set_0        | camera_1 */
UPDATE `rl_experiment` SET `value`='{"url":"https://stem-video-ap.polyu.edu.hk/stream/APPARENT_DEPTH_01/CAM0000"}' WHERE id=5;   /* 5 | APPARENT_DEPTH   | set_0        | camera_0 */
UPDATE `rl_experiment` SET `value`='{"url":"https://stem-video-ap.polyu.edu.hk/stream/APPARENT_DEPTH_01/CAM0001"}' WHERE id=6;   /* 6 | APPARENT_DEPTH   | set_0        | camera_1 */
UPDATE `rl_experiment` SET `value`='{"url":"https://stem-video-ap.polyu.edu.hk/stream/VISIBLE_SPECTRUM_00/CAM0006"}' WHERE id=13;   /* 13 | VISIBLE_SPECTRUM | set_0        | camera_0 */
/* UPDATE `rl_experiment` SET `value`='{"url":"https://stem-video-ap.polyu.edu.hk/stream/VISIBLE_SPECTRUM_00/CAM0007"}' WHERE id=;    */
UPDATE `rl_experiment` SET `value`='{"url":"https://stem-video-ap.polyu.edu.hk/stream/BACTERIA_GROWTH_00/CAM0008"}' WHERE id=9;   /*  9 | BACTERIA_GROWTH  | set_0        | camera_0 */
UPDATE `rl_experiment` SET `value`='{"url":"https://stem-video-ap.polyu.edu.hk/stream/BACTERIA_GROWTH_00/CAM0009"}' WHERE id=10;   /* 10 | BACTERIA_GROWTH  | set_0        | camera_1 */
UPDATE `rl_experiment` SET `value`='{"url":"https://stem-video-ap.polyu.edu.hk/stream/ELECTROMAGNETIC_INDUCTION_00/CAM0004"}' WHERE id=18;   /* 18 | EM_INDUCTION     | set_0        | camera_0 */
/* UPDATE `rl_experiment` SET `value`='{"url":"https://stem-video-ap.polyu.edu.hk/stream/ELECTROMAGNETIC_INDUCTION_00/CAM0005"}' WHERE id=;  */


UPDATE `rl_experiment` SET `value`='{"url":"https://stem-video-ap.polyu.edu.hk/stream/ELECTROMAGNETIC_INDUCTION_02/CAM0030"}' WHERE id=18; 
UPDATE `rl_experiment` SET `value`='{"url":"https://stem-video-ap.polyu.edu.hk/stream/ELECTROMAGNETIC_INDUCTION_02/CAM0031"}' WHERE id=45; 
UPDATE `rl_experiment` SET `value`='{"url":"https://stem-video-ap.polyu.edu.hk/stream/ELECTROMAGNETIC_INDUCTION_01/CAM0024"}' WHERE id=48; 
UPDATE `rl_experiment` SET `value`='{"url":"https://stem-video-ap.polyu.edu.hk/stream/ELECTROMAGNETIC_INDUCTION_01/CAM0025"}' WHERE id=51; 

CREATE TABLE `rl`.`rl_config` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(250) NOT NULL , `value` VARCHAR(250) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;



INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'VISIBLE_SPECTRUM', 'set_1', 'device_0', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'VISIBLE_SPECTRUM', 'set_1', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'VISIBLE_SPECTRUM', 'set_1', 'camera_0', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/VISIBLE_SPECTRUM_00/CAM0007"}', 0, 0, 0, 0);


INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'VISIBLE_SPECTRUM', 'set_2', 'device_0', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'VISIBLE_SPECTRUM', 'set_2', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'VISIBLE_SPECTRUM', 'set_2', 'camera_0', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/VISIBLE_SPECTRUM_01/CAM0016"}', 0, 0, 0, 0);


INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'VISIBLE_SPECTRUM', 'set_3', 'device_0', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'VISIBLE_SPECTRUM', 'set_3', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'VISIBLE_SPECTRUM', 'set_3', 'camera_0', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/VISIBLE_SPECTRUM_01/CAM0017"}', 0, 0, 0, 0);

/**/


INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'BACTERIA_GROWTH', 'set_1', 'device_0', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'BACTERIA_GROWTH', 'set_1', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'BACTERIA_GROWTH', 'set_1', 'camera_0', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/BACTERIA_GROWTH_01/CAM0010"}', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'BACTERIA_GROWTH', 'set_1', 'camera_1', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/BACTERIA_GROWTH_01/CAM0011"}', 0, 0, 0, 0);


INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'BACTERIA_GROWTH', 'set_2', 'device_0', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'BACTERIA_GROWTH', 'set_2', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'BACTERIA_GROWTH', 'set_2', 'camera_0', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/BACTERIA_GROWTH_02/CAM0012"}', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'BACTERIA_GROWTH', 'set_2', 'camera_1', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/BACTERIA_GROWTH_02/CAM0013"}', 0, 0, 0, 0);


INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'BACTERIA_GROWTH', 'set_3', 'device_0', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'BACTERIA_GROWTH', 'set_3', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'BACTERIA_GROWTH', 'set_3', 'camera_0', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/BACTERIA_GROWTH_03/CAM0014"}', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'BACTERIA_GROWTH', 'set_3', 'camera_1', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/BACTERIA_GROWTH_03/CAM0015"}', 0, 0, 0, 0);


/**/
INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'EM_INDUCTION', 'set_1', 'device_0', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'EM_INDUCTION', 'set_1', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'EM_INDUCTION', 'set_1', 'camera_0', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/ELECTROMAGNETIC_INDUCTION_00/CAM0005"}', 0, 0, 0, 0);


INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'EM_INDUCTION', 'set_2', 'device_0', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'EM_INDUCTION', 'set_2', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'EM_INDUCTION', 'set_2', 'camera_0', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/ELECTROMAGNETIC_INDUCTION_01/CAM0024"}', 0, 0, 0, 0);


INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'EM_INDUCTION', 'set_3', 'device_0', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'EM_INDUCTION', 'set_3', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'EM_INDUCTION', 'set_3', 'camera_0', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/ELECTROMAGNETIC_INDUCTION_01/CAM0025"}', 0, 0, 0, 0);

/**/



INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'APPARENT_DEPTH', 'set_1', 'device_0', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'APPARENT_DEPTH', 'set_1', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'APPARENT_DEPTH', 'set_1', 'camera_0', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/APPARENT_DEPTH_02/CAM0018"}', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'APPARENT_DEPTH', 'set_1', 'camera_1', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/APPARENT_DEPTH_02/CAM0019"}', 0, 0, 0, 0);


INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'APPARENT_DEPTH', 'set_2', 'device_0', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'APPARENT_DEPTH', 'set_2', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'APPARENT_DEPTH', 'set_2', 'camera_0', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/APPARENT_DEPTH_03/CAM0020"}', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'APPARENT_DEPTH', 'set_2', 'camera_1', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/APPARENT_DEPTH_03/CAM0021"}', 0, 0, 0, 0);


INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'APPARENT_DEPTH', 'set_3', 'device_0', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'APPARENT_DEPTH', 'set_3', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'APPARENT_DEPTH', 'set_3', 'camera_0', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/APPARENT_DEPTH_04/CAM0022"}', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'APPARENT_DEPTH', 'set_3', 'camera_1', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/APPARENT_DEPTH_04/CAM0023"}', 0, 0, 0, 0);


/**/


INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'GREEN_HOUSE', 'set_0', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'GREEN_HOUSE', 'set_0', 'camera_0', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/GREEN_HOUSE_00/CAM0028"}', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'GREEN_HOUSE', 'set_0', 'device_0', '', '', 0, 0, 0, 0);


INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'GREEN_HOUSE', 'set_1', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'GREEN_HOUSE', 'set_1', 'camera_0', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/GREEN_HOUSE_00/CAM0029"}', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'GREEN_HOUSE', 'set_1', 'device_0', '', '', 0, 0, 0, 0);


/**/

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'INTERFERENCE', 'set_1', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'INTERFERENCE', 'set_1', 'camera_0', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/INTERFERENCE_00/CAM0002"}', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'INTERFERENCE', 'set_1', 'camera_1', '', '{"url":"https://stem-video-ap.polyu.edu.hk/stream/INTERFERENCE_00/CAM0003"}', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'INTERFERENCE', 'set_1', 'device_0', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'INTERFERENCE', 'set_1', 'device_1', '', '', 0, 0, 0, 0);



UPDATE `rl_experiment` SET `value`='{"url":"https://stem-video-ap.polyu.edu.hk/stream/GREEN_HOUSE_01/CAM0032"}' WHERE id=65; 
UPDATE `rl_experiment` SET `value`='{"url":"https://stem-video-ap.polyu.edu.hk/stream/GREEN_HOUSE_01/CAM0033"}' WHERE id=68; 