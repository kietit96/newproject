<?php
include_once('config.php');

$time_now = time();
$time_out = 60;
$ip_address = $_SERVER['REMOTE_ADDR'];
if (!count(
    $db->loadallrows_sql("SELECT `ip_address` FROM `vt_counter` WHERE UNIX_TIMESTAMP(`last_visit`) + $time_out > $time_now AND `ip_address` = '$ip_address'")
))
    $db->execute_sql("INSERT INTO `vt_counter` VALUES ('$ip_address', NOW())");
$online = $db->loadrow_sql("SELECT count(*) as count FROM `vt_counter` WHERE UNIX_TIMESTAMP(`last_visit`) + $time_out > $time_now");
$day = $db->loadrow_sql("SELECT count(*) as count FROM `vt_counter` WHERE DAYOFYEAR(`last_visit`) = " . (date('z') + 1) . " AND YEAR(`last_visit`) = " . date('Y'));
$yesterday = $db->loadrow_sql("SELECT count(*) as count FROM `vt_counter` WHERE DAYOFYEAR(`last_visit`) = " . (date('z') + 0) . " AND YEAR(`last_visit`) = " . date('Y'));
$week = $db->loadrow_sql("SELECT count(*) as count FROM `vt_counter` WHERE WEEKOFYEAR(`last_visit`) = " . date('W') . " AND YEAR(`last_visit`) = " . date('Y'));
$lastweek = $db->loadrow_sql("SELECT count(*) as count FROM `vt_counter` WHERE WEEKOFYEAR(`last_visit`) = " . (date('W') - 1) . " AND YEAR(`last_visit`) = " . date('Y'));
$month = $db->loadrow_sql("SELECT count(*) as count FROM `vt_counter` WHERE MONTH(`last_visit`) = " . date('n') . " AND YEAR(`last_visit`) = " . date('Y'));
$year = $db->loadrow_sql("SELECT count(*) as count FROM `vt_counter` WHERE YEAR(`last_visit`) = " . date('Y'));
// đếm tổng số người đã ghé thăm
$visit = $db->loadrow_sql("SELECT count(*) as count FROM `vt_counter`");

?>
<p><i class="fa fa-user"></i> Đang online: <?= $online->count ?></p>
<p><i class="fa fa-user"></i> Hôm nay: <?= $day->count ?></p>
<p><i class="fa fa-user"></i> Hôm qua: <?= $yesterday->count ?></p>
<p><i class="fa fa-user"></i> Tuần này: <?= $week->count ?></p>
<p><i class="fa fa-user"></i> Tuần trước: <?= $lastweek->count ?></p>
<p><i class="fa fa-user"></i> Tháng này: <?= $month->count ?></p>
<p><i class="fa fa-user"></i> Năm nay: <?= $year->count ?></p>
<p><i class="fa fa-line-chart"></i> Tổng truy cập: <?= $visit->count ?></p>