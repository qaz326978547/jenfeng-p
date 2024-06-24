<?php

//js工具 跳轉用-------------------------------------------------------------------------------------------------------------------

class My_Tool
{

    //跳訊息視窗 並且轉址
    public function show($msg, $redirect = null)
    {

        echo "<script>";
        echo "alert('" . $msg . "');";
        if ($redirect != null) {
            echo "location.href='" . $redirect . "'";
        }

        echo "</script>";

    }

    //轉址
    public function go_url($url)
    {

        echo "<script>";
        echo "location.href='" . $url . "'";
        echo "</script>";

    }

    //彈跳視窗，並中斷
    public function error($msg, $redirect = null)
    {

        if ($redirect === null) {
            $redirect = 'history.go(-1);';
        } else {
            $redirect = 'location.href="' . $redirect . '"';
        }

        echo "<script>";
        echo "alert('" . $msg . "');";
        echo $redirect;
        echo "</script>";

        exit; //因錯誤終止
    }

    //子視窗專用，關閉本身，需配合openwindow()
    public function close()
    {
        echo "<script>";
        echo "window.close();";
        echo "</script>";
    }

    //子視窗專用，更新母視窗
    public function refresh_parents()
    {
        echo "<script>";
        echo "window.opener.location.reload();";
        echo "</script>";
    }

}; //--------------------------------------------------------------------------------------------------------------------------