<?php

file_get_contents('https://example.com/wp-cron.php?doing_wp_cron', false, stream_context_create([
    "ssl"=> [
        "verify_peer" => false,
        "verify_peer_name" => false,
    ],
]));

/*file_put_contents(__DIR__.'/log.log', time().'-'.date('Y-m-d H:i:s')." OK\n", FILE_APPEND);*/
