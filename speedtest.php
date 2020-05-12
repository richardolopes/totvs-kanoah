<?php

$time = getdate();

$newdate = $time[0] - ($time["wday"] - 1) * 24 * 60 * 60;

$time2 = getdate($newdate);
echo json_encode([$time, $time2]);
