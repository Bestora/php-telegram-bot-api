<?php

class TelegramBot {
  private $chat_id;
  private $token;

  function __construct($token, $chat_id = false)
  {
    $this->token = $token;
    $this->chat_id = $chat_id;
  }

  function call($url, $param)
  {
    $url = 'http://domain.com/get-post.php';
    foreach($param as $key=>$value) { $param_string .= $key.'='.$value.'&'; }
    rtrim($param_string, '&');
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, count($param));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $param_string);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  }

}
