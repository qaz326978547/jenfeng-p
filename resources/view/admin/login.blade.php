<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="_token" content="{{ csrf_token() }}" />
    <title>Choice 喬義司 - 設計後台</title>

    <meta name="robots" content="noindex">
    
    {{-- CSS --}}
	@adminStyle
    
    {{-- JaveScript --}}
	@adminScript

</head>

<body>
    <form name="form1" method="post" action="" id="login_form">
        @csrf
       
        <img src="{{ resources_path('images/admin/logo.png') }}">
        <div class="t">     
            <ul>
                <li class="left user">管理者帳號</li>
                <li><input type="text" name="account" size="30" placeholder="請輸入帳號" value=""></li>
            </ul>
            <ul> 
                <li class="left pw">管理者密碼</li>
                <li><input type="password" name="password" size="30" placeholder="請輸入密碼"></li>
            </ul>
        </div>
        <div class="button">
            <input type="reset" class="button" value="重新輸入" /> 
            <input class="button" value="登入後台" onclick="validate('#login_form', 'validate.admin_login.rule', 'validate.admin_login.rule_message')" />
        </div>   

        <div class="copyright">
            Design By <a href="http://www.choice-design.com.tw" target="_blank">Choice-Design</a>
        </div>   
    </form>         
</body>
</html>
