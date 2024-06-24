// JavaScript Document
function CKupdate(){
    for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
}

function OpenWindow($url,$name,$width,$height)
{
window.status = "";
strFeatures = "top=350,left=350,width="+$width+",height="+$height+",toolbar=0,menubar=0,location=0,directories=0,status=0,scrollbars=1,resizable=yes";
objNewWindow = window.open( $url, $name, strFeatures);
window.status = "管理視窗";
window.event.cancelBubble = true;
window.event.returnValue = false;
}

function checkEmail(email) {
 regularExpression = /^[^\s]+@[^\s]+\.[^\s]{2,3}$/;
 if (regularExpression.test(email)) {
 return true;
 }
 else{
 return false;
 }
}

//檢查密碼
function checkPassword(password){
  re = /^[0-9a-zA-z]{6,10}$/;	
  if (re.test(password)) {
  return true;
  }
  else{
  return false;
  }
}

//檢查區碼 
function checkZip(zip){
  re = /^[0-9]{2,4}$/
  if (re.test(zip)) {
  return true;
  }
  else{
  return false;
  }  	
}
//檢查市話(含區碼)
function checkTel(tel){
  re = /^[0-9]{2}-[0-9]{5,8}$/
  if (re.test(tel)) {
  return true;
  }
  else{
  return false;
  }
}
//檢查手機
function checkCel(cel){
  re = /^09[0-9]{8}$/
  if (re.test(cel)) {
  return true;
  }
  else{
  return false;
  }
}
//身分證字號檢查--------------------------------------------------------------------------------------
function idChecker(id) /*函數宣告*/
{
  

  tab = "ABCDEFGHJKLMNPQRSTUVXYWZIO"                     
  A1 = new Array (1,1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,3,3,3,3,3,3 );
  A2 = new Array (0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5 );
  Mx = new Array (9,8,7,6,5,4,3,2,1,1);

  if ( id.length != 10 ) return false;
  i = tab.indexOf( id.charAt(0) );
  if ( i == -1 ) return false;
  sum = A1[i] + A2[i]*9;

  for ( i=1; i<10; i++ ) {
    v = parseInt( id.charAt(i) );
    if ( isNaN(v) ) return false;
    sum = sum + v * Mx[i];
  }
  if ( sum % 10 != 0 ) return false;
  return true;

  
  
  
  /*
    var pass=0; /*為了通過後面的防呆所以...*/
 /*   var num=new Array(11); /*用來存轉換碼加九個數字 */
 /*   var sum=0; /*計算經過公式後的加總*/
 /*   input=val; /*存文字框的內容*/
 /*   var table=new Array(10,11,12,13,14,15,16,17,18,34,19,20,21,22,35,23,24,25,26,27,28,29,32,30,31,33); /*轉換的對照表*/
    /*以下是防呆*/
 /*   if(input.length!=10)
        alert("身分證長度不符");
    else if(input.charCodeAt(0)<"A".charCodeAt(0)||input.charCodeAt(0)>"Z".charCodeAt(0))
        alert("身分證第一個字母要大寫英文");
    else if(input.charCodeAt(1)!="1".charCodeAt(0)&&input.charCodeAt(1)!="2".charCodeAt(0))
        alert("身分證第一個數字必須是1或2");
    else
    {
        for(p=2;p<10;p++)
        {
            if(input.charCodeAt(p)<"0".charCodeAt(0)||input.charCodeAt(p)>"9".charCodeAt(0))
            {
                alert("身分證後九碼要皆為數字");
                break;
            }
            else
                pass++;
        }
    }
    if(pass!=8)
        return false;
    /*以上是防呆*/
 /*   num[1]=table[input.charCodeAt(0)-65]%10;
    num[0]=(table[input.charCodeAt(0)-65]-num[1])/10;
    for(p=1;p<10;p++)
        num[p+1]=input.charCodeAt(p)-48;
    for(p=1;p<9;p++)
        num[p]=num[p]*(10-p); /*套用公式*/
 /*   for(p=0;p<11;p++)
        sum+=num[p]; 
		
		
		alert(sum);
		
    if(sum%10==0) /*檢查*/
 /*    return true;
    else
       return false;*/
}