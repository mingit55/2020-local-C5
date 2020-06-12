<?php

require __DIR__."/App/DB.php";

use App\DB;

for($i = 1;  $i <= 4;  $i++){
    $params = ["specialist$i", hash('sha256', '1234'), "전문가$i", "specialist$i.jpg", "1"];
    DB::query("INSERT INTO users(user_id, password, user_name, photo, type) VALUES (?, ?, ?, ?, ?)", $params);
}