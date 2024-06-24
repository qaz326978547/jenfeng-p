<?php

if (!function_exists('get_youtube_code')) {
    function get_youtube_code($url)
    {
        $code = '';

        if (strpos($url, 'watch?v=')) {
            $code = strchr($url, 'watch?v=');
            $code = str_replace('watch?v=', '', $code);
            if (strpos($code, '&t=')) {
                $temp = strchr($code, '&t=');
                $code = str_replace($temp, '', $code);
            }
            if (strpos($code, '&feature')) {
                $temp = strchr($code, '&feature');
                $code = str_replace($temp, '', $code);
            }
            if (strpos($code, '&list')) {
                $temp = strchr($code, '&list');
                $code = str_replace($temp, '', $code);
            }
        }
        if (strpos($url, 'youtu.be/')) {
            $code = strchr($url, 'youtu.be/');
            $code = str_replace('youtu.be/', '', $code);
            if (strpos($code, '?t=')) {
                $temp = strchr($code, '?t=');
                $code = str_replace($temp, '', $code);
            }
            if (strpos($code, '?list=')) {
                $temp = strchr($code, '?list=');
                $code = str_replace($temp, '', $code);
            }
        }

        return 'https://www.youtube.com/embed/' . $code;
    }
}