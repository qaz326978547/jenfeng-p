<?php

//檢查 安全用類別------------------------------------------------------------------------------------------------------------
class guard
{

    private $web_site; //網址鎖檢查用

    //當物件建立時
    public function __construct()
    {

        //$this->web_site = "9tsweb.com/";
        $this->web_site = "webhome5000.com/"; //網址過濾用，localhost自動允許

        //將此行啟用時，呼叫guard即自動檢查網址
        //$this->path_check();

        $this->anti_injection();
    }

    //傳遞變數檢查器，防範sql injection攻擊
    public function var_check($var)
    {

        $var = str_replace("'", "+" . chr(39) . "+", $var);
        $var = str_replace('"', "+" . chr(34) . "+", $var);

        return $var;
    }

    //上傳檔案類別檢查器，防範css,js,php等上傳檔案攻擊
    public function file_check($type)
    {

        if ($type == "application/x-php" or $type == "application/x-js" or $type == "application/x-asp" or $type == "text/css") {
            return false;
        } else {
            return true;
        }

    }

    //圖檔類別檢查器，可依照傳入值檢查是否為jpg、gif或png檔案
    public function image_check($type, $jpg, $gif, $png = 0)
    {

        $temp = 0;

        if ($jpg == 1 and ($type == 'image/pjpeg' or $type == 'image/jpeg')) {
            $temp++;
        }

        if ($gif == 1 and $type == 'image/gif') {
            $temp++;
        }

        if ($png == 1 and ($type == 'image/x-png' or $type == 'image/png')) {
            $temp++;
        }

        if ($temp != 0) //不為0 : 上傳正確
        {
            return true;
        } else {
            return false;
        }

    }

    //mail字串格式檢查
    public function mail_check($mail)
    {

        $check1 = stristr($mail, "@"); //檢查帳號用
        $check2 = stristr(stristr($mail, "@"), ".");
        $check3 = strlen($acc_check2);

        if (empty($check1) and empty($check2) and $check3 < 3) {
            return false;
        } else {
            return true;
        }

    }

    //來源檢查器，防範網址傳遞變數攻擊
    public function path_check()
    {

        $path = $_SERVER['PHP_SELF']; //目前文件路徑

        if (empty($_SERVER['HTTP_REFERER'])) //不是從外部檔案傳送而來，直接輸入網址者
        {
            print "請勿直接執行此檔案";
            exit;
        }

        $a = $_SERVER['HTTP_REFERER']; //外部傳送路徑
        $b = $this->web_site; //內建設定
        $c = "localhost/";

        if (strrpos($a, $b) == false and strrpos($a, $c) == false) {
//比較字串
            print "請勿自外部表單進入";
            exit;
        }
    }

    //反留言板robot
    public function anti_robot()
    {

        $checkment = 0; //標籤
        $count = 0;
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            $count++;
        }

        if (empty($_SERVER['HTTP_ACCEPT'])) {
            $count++;
        }

        if (empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $count++;
        }

        if (empty($_SERVER['HTTP_ACCEPT_ENCODING'])) {
            $count++;
        }

        if (empty($_SERVER['HTTP_ACCEPT_CHARSET'])) {
            $count++;
        }

        if ($count >= 3) {
            $checkment = 1;
        }
        //超過2項空白則視為ROBOT，誅殺

        if ($checkment == 0) {
            return true;
        }

        $tool = new My_tool;
        $tool->error("留言錯誤！，請檢查您的網頁瀏覽器是否合乎規格！");
        exit;
    }

    //過濾字元
    public function ro_str($str)
    {

        $fuck = array("幹你娘", "幹您娘", "FUCK", "王八蛋", "畜牲", "wyler", "王八", "中出", "內射");

        if (!in_array($str, $fuck) === null) {
            $tool = new My_tool;
            $tool->error("留言失敗！留言內含過濾字元。");
            exit;
        }

    }

    //防止sqlinjection
    public function anti_injection()
    {
        //保留key
        // $escape = array('utube', 's_info', 'info', 'info1', 'info2', 'info3', 'info4', 'info5', 'image_data', 'reply', 'mid_info', 'text', 'google', 'description', 'link');
        $escape = array('');

        if(!\Session::has('admuser')) {
            if (is_array(\Request::input())) {
                foreach (\Request::input() as $key => $value) {
                    if (!is_array(\Request::input($key)) and !in_array($key, $escape)) {
                    	\Request::merge([$key => str_replace('"', "&quot;", \Request::input($key))]);
                    	\Request::merge([$key => str_replace("'", "&apos;", \Request::input($key))]);
                    	\Request::merge([$key => $this->RemoveXSS(\Request::input($key))]);
                    }
                }
            }
        }
    }

    /**
     * Wrapper for the RemoveXSS function.
     * Removes potential XSS code from an input string.
     *
     * Using an external class by Travis Puderbaugh <kallahar@quickwired.com>
     *
     * @param    string        Input string
     * @return    string        Input string with potential XSS code removed
     */
    public function RemoveXSS($val)
    {
        // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
        // this prevents some character re-spacing such as <java\0script>
        // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
        $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);

        // straight replacements, the user should never need these since they're normal characters
        // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
        $search = 'abcdefghijklmnopqrstuvwxyz';
        $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $search .= '1234567890!@#$%^&*()';
        $search .= '~`";:?+/={}[]-_|\'\\';

        for ($i = 0; $i < strlen($search); $i++) {
            // ;? matches the ;, which is optional
            // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

            // &#x0040 @ search for the hex values
            $val = preg_replace('/(&#[x|X]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val); // with a ;
            // &#00064 @ 0{0,7} matches '0' zero to seven times
            $val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); // with a ;
        }

        // now the only remaining whitespace attacks are \t, \n, and \r
        $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
        $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
        $ra = array_merge($ra1, $ra2);

        $found = true; // keep replacing as long as the previous round replaced something
        while ($found == true) {
            $val_before = $val;
            for ($i = 0; $i < sizeof($ra); $i++) {
                $pattern = '/';
                for ($j = 0; $j < strlen($ra[$i]); $j++) {
                    if ($j > 0) {
                        $pattern .= '(';
                        $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
                        $pattern .= '|(&#0{0,8}([9][10][13]);?)?';
                        $pattern .= ')?';
                    }
                    $pattern .= $ra[$i][$j];
                }
                $pattern .= '/i';
                $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2); // add in <> to nerf the tag
                $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
                if ($val_before == $val) {
                    // no replacements were made, so exit the loop
                    $found = false;
                }
            }
        }

        return $val;
    }

}