/*crontab -e */
/* create new set of experiment */

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'EM_INDUCTION', 'set_0', 'session', '', '', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'EM_INDUCTION', 'set_0', 'camera_0', '', 'ip', 0, 0, 0, 0);

INSERT INTO `rl_experiment` 
(`id`, `experiment`, `equipment_id`, `device_id`, `command`, `value`, `command_set_at`, `command_got_at`, `value_set_at`, `value_got_at`) VALUES 
(NULL, 'EM_INDUCTION', 'set_0', 'device_0', '', '', 0, 0, 0, 0);





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



CREATE TABLE `rl`.`rl_config` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(250) NOT NULL , `value` VARCHAR(250) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
