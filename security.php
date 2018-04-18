<?php
class Security{

    public static $info = '';

    public static function IP()
    {
       $ip = "";
       if(isset($_SERVER))
       {
           if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
           {
               $ip=$_SERVER['HTTP_CLIENT_IP'];
            }
            elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            {
                $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else
            {
                $ip=$_SERVER['REMOTE_ADDR'];
            }
       }
       else
       {
            if ( getenv( 'HTTP_CLIENT_IP' ) )
            {
                $ip = getenv( 'HTTP_CLIENT_IP' );
            }
            elseif( getenv( 'HTTP_X_FORWARDED_FOR' ) )
            {
                $ip = getenv( 'HTTP_X_FORWARDED_FOR' );
            }
            else
            {
                $ip = getenv( 'REMOTE_ADDR' );
            }
       }
        // En algunos casos muy raros la ip es devuelta repetida dos veces separada por coma
        return (strstr($ip,',')) ? array_shift(explode(',', $ip)) : $ip;
    }

    private static function register_code_injection($string){
        $ip = self::IP();
        $conexionDB = new DataBase();
        $string = $conexionDB->escape_string($string);

        if(isset($_SESSION[SESSION_VARIABLE])){
            $id_user = $_SESSION[SESSION_VARIABLE];
            $conexionDB -> connect("INSERT INTO filters(ip, id_account, input) VALUES ('$ip', '$id_user', '/* $string */')");
        }else{
            $conexionDB -> connect("INSERT INTO filters(ip, input) VALUES ('$ip', '/* $string */')");
        }
        self::$info = Message::SECURITY_WARNING;
        $conexionDB->close_DB();

    }

    public static function filter($text, $form = false){
        if($text == ''){
            self::$info = ($form === 'form_config') ? Message::SELECT_CHAR : Message::INPUT_TEXT_NULL;
            return false;
        }        
        $text = trim($text);
        
        $text_special = htmlspecialchars($text);            

        if(strlen($text_special) > MAX_INPUT_CHARS){
            self::register_code_injection($text);
            return false;
        }

        $HTML_entities = array('&amp;', '&quot;', '&#039;', '&apos;', '&lt;', '&gt;', "'");

        foreach ($HTML_entities as $enti) {
            if(strpos($text_special, $enti) !== false){
                self::register_code_injection($text);
                return false;
            }
        }

        $_text = trim($text, "\x00..\x1F");

        return strip_tags($text);//http://php.net/manual/en/function.strip-tags.php
        
    }

}