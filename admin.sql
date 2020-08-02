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
