<?php

$arr = '[{"id":1,"value":10,"sensor_id":7,"created_at":"2019-08-07 00:00:00","updated_at":null},{"id":2,"value":15,"sensor_id":7,"created_at":"2019-08-08 00:00:00","updated_at":null},{"id":3,"value":20,"sensor_id":7,"created_at":"2019-08-09 00:00:00","updated_at":null}]';

echo $arr;
//echo json_encode(array_column((array)$arr, 'created_at'), JSON_UNESCAPED_SLASHES);
