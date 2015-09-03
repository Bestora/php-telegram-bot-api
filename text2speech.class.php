<?php
class text2speech {
        public $file = '';
        function __construct($text) {
                $words = substr($text, 0, 100);
                $words = urlencode($words);
                $this->file =  "audio.mp3";

                // If the MP3 file exists, do not create a new request

                $url = 'http://translate.google.com/translate_tts?tl=en&q='.$words.'&client=t';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64; rv:39.0) Gecko/20100101 Firefox/39.0');

                $result_raw = curl_exec($ch);
                file_put_contents('curl.log', $url."\r\n",FILE_APPEND);
                file_put_contents('curl.log', $result_raw."\r\n",FILE_APPEND);

                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $error = curl_error($ch);
                curl_close($ch);
                file_put_contents('audio.mp3',$result_raw);

        }
}
