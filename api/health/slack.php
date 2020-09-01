<?php
    define('SLACK_WEBHOOK', 'https://hooks.slack.com/services/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');
    $text = $_GET['text'];
    $message = array('payload' => json_encode(array('text' => $text)));
    $c = curl_init(SLACK_WEBHOOK);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_POST, true);
    curl_setopt($c, CURLOPT_POSTFIELDS, $message);
    curl_exec($c);
    curl_close($c);
?>