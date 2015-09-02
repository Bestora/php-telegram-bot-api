<?php
/*
  //Beispiel
  $bot = new TelegramBot($deinTelegramBotToken);

  try
  {
    print_r($bot->getUpdates());
  }
  catch(Exception $e)
  {
    echo ($e->getMessage());
    echo ($e->getCode());
  }
*/
class TelegramBot {
  private $token;

  const ReplyKeyboardMarkup = "ReplyKeyboardMarkup";
  const ReplyKeyboardHide = "ReplyKeyboardHide";
  const ForceReply = "ForceReply";

  function __construct($token){
    $this->token = $token;
  }

  function __call($method, $param){
    $url = 'https://api.telegram.org/bot'.$this->token.'/'.$method;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, count($param));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param_);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result_raw = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $result = json_decode($result_raw, true);
    $error = curl_error($ch);
    curl_close($ch);

    if($result['ok'] !== true)
    {
      throw new Exception($result['description'], $result['error_code']);
    }

    return $result;
  }

  /*
  getUpdates
    Use this method to receive incoming updates using long polling (wiki). An Array of Update objects is returned.

    Parameters   Type     Required  Description
    offset       Integer  Optional  Identifier of the first update to be returned. Must be greater by one than the highest among the identifiers of previously received updates. By default, updates starting with the earliest unconfirmed update are returned. An update is considered confirmed as soon as getUpdates is called with an offset higher than its update_id.
    limit        Integer  Optional  Limits the number of updates to be retrieved. Values between 1—100 are accepted. Defaults to 100
    timeout      Integer  Optional  Timeout in seconds for long polling. Defaults to 0, i.e. usual short polling
  */
  function getUpdates($offset = false, $limit = false, $timeout = false){
    $param = array();

    if($offset !== false){
      $param['offset'] = $offset;
    }
    if($limit !== false){
      $param['limit'] = $limit;
    }
    if($timeout !== false){
      $param['timeout'] = $timeout;
    }

    $result = $this->__call(__FUNCTION__, $param);
    return $result;
  }

  /*
  sendMessage
    Use this method to send text messages. On success, the sent Message is returned.

    Parameters                Type                                                    Required  Description
    chat_id                   Integer                                                 Yes       Unique identifier for the message recipient — User or GroupChat id
    text                      String                                                  Yes       Text of the message to be sent
    disable_web_page_preview  Boolean                                                 Optional  Disables link previews for links in this message
    reply_to_message_id       Integer                                                 Optional  If the message is a reply, ID of the original message
    reply_markup              ReplyKeyboardMarkup or ReplyKeyboardHide or ForceReply  Optional  Additional interface options. A JSON-serialized object for a custom reply keyboard, instructions to hide keyboard or to force a reply from the user.
  */
  function sendMessage($chat_id, $text, $disable_web_page_preview = false, $reply_to_message_id = false, $reply_markup = false)
  {
    $param = array(
      "chat_id" => $chat_id,
      "text" => $text,
    );

    if($disable_web_page_preview !== false){
      $param['disable_web_page_preview'] = $disable_web_page_preview;
    }
    if($reply_to_message_id !== 0){
      $param['reply_to_message_id'] = $reply_to_message_id;
    }
    if($reply_markup !== false){
      $param['reply_markup'] = $reply_markup;
    }

    $result = $this->__call(__FUNCTION__, $param);
    return $result;
  }

  /*
  sendPhoto
    Use this method to send photos. On success, the sent Message is returned.

    Parameters           Type                                                     Required   Description
    chat_id              Integer                                                  Yes        Unique identifier for the message recipient — User or GroupChat id
    photo                InputFile or String                                      Yes        Photo to send. You can either pass a file_id as String to resend a photo that is already on the Telegram servers, or upload a new photo using multipart/form-data.
    caption              String                                                   Optional   Photo caption (may also be used when resending photos by file_id).
    reply_to_message_id  Integer                                                  Optional   If the message is a reply, ID of the original message
    reply_markup         replyKeyboardMarkup or ReplyKeyboardHide or ForceReply   Optional   Additional interface options. A JSON-serialized object for a custom reply keyboard, instructions to hide keyboard or to force a reply from the user.
  */
  function sendPhoto($chat_id, $photo, $caption = false, $reply_to_message_id = false, $reply_markup = false)
  {
    $param = array(
      "chat_id" => $chat_id,
      "photo" => $photo,
    );

    if($caption !== 0){
      $param['caption'] = $caption;
    }
    if($reply_to_message_id !== false){
      $param['reply_to_message_id'] = $reply_to_message_id;
    }
    if($reply_markup !== false){
      $param['reply_markup'] = $reply_markup;
    }

    $result = $this->__call(__FUNCTION__, $param);
    return $result;
  }

  /*
  sendChatAction
    Use this method when you need to tell the user that something is happening on the bot's side. The status is set for 5 seconds or less (when a message arrives from your bot, Telegram clients clear its typing status).

    Example: The ImageBot needs some time to process a request and upload the image. Instead of sending a text message along the lines of “Retrieving image, please wait…”, the bot may use sendChatAction with action = upload_photo. The user will see a “sending photo” status for the bot.
    We only recommend using this method when a response from the bot will take a noticeable amount of time to arrive.

    Parameters  Type     Required   Description
    chat_id     Integer  Yes        Unique identifier for the message recipient — User or GroupChat id
    action      String   Yes        Type of action to broadcast. Choose one, depending on what the user is about to receive: typing for text messages, upload_photo for photos, record_video or upload_video for videos, record_audio or upload_audio for audio files, upload_document for general files, find_location for location data.
  */
  /*
  action:
    "typing"                         for text messages,
    "upload_photo"                   for photos,
    "record_video" or "upload_video" for videos,
    "record_audio" or "upload_audio" for audio files,
    "upload_document"                for general files,
    "find_location"                  for location data.
  */
  function sendChatAction($chat_id, $action)
  {
    $param = array(
      "chat_id" => $chat_id,
      "action" => $action,
    );

    $result = $this->__call(__FUNCTION__, $param);
    return $result;
  }


}
