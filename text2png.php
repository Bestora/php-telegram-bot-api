<?php
/*
* $t2p = new text2png($_SERVER['DOCUMENT_ROOT'].'/consola.otf');
* $t2p->createImage($text_mit_zeilenumbruch, 12 , '#00ff00','bil.png');
*/
 class text2png {

    private $font_file;


    function __construct($font = null) {
        if($font != null) {
            $this->font_file = $font;
        }
    }

    public function createImage($text,$size, $color,$file) {
        $font_rgb = $this->hex_to_rgb($color);
        $box = imageTTFBBox($size,0,$this->font_file,$text);
        $text_width = abs($box[2]-$box[0]);
        $text_height = abs($box[5]-$box[3]);
        $image_width = $box[2];
        $image =  imagecreatetruecolor($box[2]+40,$box[1]+40);
        $font_color = ImageColorAllocate($image,$font_rgb['red'],$font_rgb['green'],$font_rgb['blue']) ;
        $put_text_x = 20;
        $put_text_y = 20;
        imagettftext($image, $size, 0, $put_text_x,  $put_text_y, $font_color, $this->font_file, $text);
        ImagePNG($image,$file);
        return $file;
    }

    private function hex_to_rgb($hex) {
        // remove '#'
        if(substr($hex,0,1) == '#')
            $hex = substr($hex,1) ;

        // expand short form ('fff') color to long form ('ffffff')
        if(strlen($hex) == 3) {
            $hex = substr($hex,0,1) . substr($hex,0,1) .
                   substr($hex,1,1) . substr($hex,1,1) .
                   substr($hex,2,1) . substr($hex,2,1) ;
        }



        // convert from hexidecimal number systems
        $rgb['red'] = hexdec(substr($hex,0,2)) ;
        $rgb['green'] = hexdec(substr($hex,2,2)) ;
        $rgb['blue'] = hexdec(substr($hex,4,2)) ;

        return $rgb ;
    }

}
