var _continent = ['亞洲','美洲','歐洲','非洲','大洋洲'];
var _countrys  = {
  
 '亞洲': ['巴林',  '伊朗',  '伊拉克共和國',  '以色列',  '約旦',  '亞美尼亞',  '塞浦路斯',  '哈薩克',  '北朝鮮',  '科威特',  '吉爾吉斯坦',  '黎巴嫩',  '澳門',  '馬來西亞',  '馬爾地夫',  '蒙古',  '緬甸',  '尼泊爾',  '阿曼',  '巴基斯坦',  '巴勒斯坦',  '菲律賓',  '卡塔爾',  '沙烏地阿拉伯',  '新加坡',  '南韓',  '斯里蘭卡',  '蘇丹',  '敘利亞',  '臺灣',  '泰國',  '土耳其',  '土庫曼斯坦',  '阿拉伯聯合共和國',  '越南',  '葉門',  '中國',  '日本',  '汶萊',  '柬埔寨',  '印尼' ] ,
 '美洲': ['百慕達群島','加拿大','美國','薩巴','安圭拉島','安提瓜島和巴布達','阿根廷','阿魯巴島','巴哈馬','巴貝多','伯立茲','玻利維亞','博內爾','巴西','開曼群島','智利','哥倫比亞','哥斯達黎加','古巴','庫腊索','多米尼加','多米尼加共和國','厄瓜多爾','薩爾瓦多','圭亞那(法屬)','格林納達','瓜德羅普','危地馬拉','圭亞那','海地','洪都拉斯','馬提尼克','墨西哥','蒙特塞拉特島','荷屬安的列斯','尼加拉瓜','巴拿馬','巴拉圭','秘魯','波多黎各','聖巴特勒米島','聖克魯斯','聖尤斯特歇斯','聖約翰島','凱特尼維斯','聖露西亞國','聖馬丁島','聖托馬斯島','聖文森特島','蘇裡南','千里達 - 托貝哥','特克斯島',   '烏拉圭','委內瑞拉','英屬維爾京群島','美屬維爾京群島' ] ,
 '歐洲': ['阿爾巴尼亞','安道爾','奧地利','亞塞拜然','白俄羅斯','比利時','波士尼亞赫賽哥維那','保加利亞','布基納法索','克羅地亞','捷克共和國','丹麥','愛沙尼亞','芬蘭','法國','格魯吉亞','德國','直布羅陀','希臘','匈牙利','冰島','愛爾蘭','意大利','拉脫維亞','列支敦士登','立陶宛','盧森堡','馬其頓','馬耳他','摩爾多瓦','摩納哥','荷蘭','挪威','波蘭','葡萄牙','羅馬尼亞','俄羅斯','斯洛伐克共和國','斯洛維尼亞共和國','西班牙','瑞典','瑞士','塔吉克斯坦','烏克蘭','英國','烏茲別克',' 梵蒂岡' ] ,
 '非洲': ['阿爾及利亞','安哥拉','貝寧','博茨瓦納','布隆迪','喀麥隆','維德角','中非共和國','札德','剛果','吉布提','埃及','赤道幾內亞','厄立特里亞','埃塞俄比亞','加蓬','干比亞',  '加納','幾內亞','幾內亞比紹','象牙海岸','牙賣加','肯尼亞','萊索托','利比里亞','利比亞','馬達加斯加','馬拉維','馬里','毛里塔尼亞','毛里求斯','摩洛哥','莫三比克','納米比亞','尼日爾','尼日利亞','留尼汪島','盧安達','塞內加爾','塞席爾群島','塞拉利昂-獅子山','索馬利亞','南非','斯威士蘭','坦桑尼亞','多哥','突尼斯','烏干達','扎伊爾','贊比亞', '津巴布韋' ] ,
 '大洋洲': ['美國薩摩亞','澳大利亞','庫克群島','斐濟','法屬玻利維亞','關島','馬紹爾群島','密克羅尼西亞','加勒多尼亞','紐西蘭','帛琉群島','巴布亞新幾內亞','塞班島','瓦那圖','瓦利斯與富圖納島' ]

};

var _continent_en  = ['Asia','America','Europe','Africa','Oceania'];
var _countrys_en   = {
  
 'Asia': ['Bahrain',  'Iran',  'Iraq Rep',  'Israel',  'Jordan',  'Armenia',  'Cyprus',  'Kazakhstan',  'Korea,D.P.R.Of',  'Kuwait',  'Kyrgyzstan',  'Lebanon',  'Macau',  'Malaysia',  'Maldives',  'Mongolia',  'Myanmar',  'Nepal',  'Oman',  'Pakistan',  'Palestine Authority',  'Philippines',  'Qatar',  'Saudi Arabia',  'Singapore',  'South Korea',  'Sri Lanka',  'Sudan',  'Syria',  'Taiwan',  'Thailand',  'Turkey',  'Turkmenistan',  'U.A.E',  'Vietnam',  'Yemen',  'China',  'Japan',  'Brunei',  'Cambodia',  'Indonesia' ] ,
 'America': ['Bermuda','Canada','U.S.A','Saba','Anguilla','Antigua and Barbuda','Argentina','Aruba','Bahamas','Barbados','Belize','Bolivia','Bonaire','Brazil','Cayman Is.','Chile','Colombia','Costa Rica','Cuba','Curacao','Dominica','Dominican Rep.','Ecuador','EL Salvador','French Guiana','Grenada','Guadeloupe','Guatemala','Guyana','Haiti','Honduras','Martinique','Mexico','Montserrat','Netherlands Antilles','Nicaragua','Panama','Paraguay','Peru','Puerto Rico','St.Barthelemy','St.Croix','St.Eustatius','St.John','St.Kitts&Nevis','St.Lucia','St.Maarten/St.Martin','St.Thomas','St.Vincent','Suriname','Trinidad&Tobag','Turks&Caicos Is.','Uruguay','Venezuela','Virgin Island(British)','Virgin Island(US)' ] ,
 'Europe': ['Albania','Andorra','Austria','Azerbaijan','Belarus','Belgium','Bosnia and Herzegovine','Bulgaria','Burkina Faso','Croatia','Czech Rep.','Denmark','Estonia','Finland','France','Georgia','Germany','Gibraltar','Greece','Hungary','Iceland','Ireland','Italy','Latvia','Liechtenstein','Lithuania','Luxemburg','Macedonia','Malta','Moldova','Monaco','Netherlands','Norway','Poland','Portugal','Romania','Russia','Slovak Rep.','Slovenia','Spain','Sweden','Switzerland','Tajikistan','Ukraine','United Kingdom','Uzbekistan','Vatican City' ] ,
 'Africa': ['Algeria','Angola','Benin','Botswana','Burundi','Cameroon','Cape Verde','Center Africa Rep.','Chad','Congo','Djibouti','Egypt','Equatorial Guinea','Eritrea','Ethiopia','Gabon','Gambia','Ghana','Guinea','Guinea Bissau','Ivory Coast','Jamaica','Kenya','Lesotho','Liberia','Libya','Madagascar','Malawi','Mali','Mauritania','Mauritius','Morocco','Mozambique','Namibia','Niger','Nigeria','Reunion Is.','Rwanda','Senegal','Seychelles','Sierra Leone','Somalia','South Africa','Swaziland','Tanzania','Togo','Tunisia','Uganda','Zaire','Zambia','Zimbabwe' ] ,
 'Oceania': [ 'American Samoa', 'Australia','Cook Is.','Fiji','French Polynesia','Guam','Marshall Is.','Mocronesia','New Caledonia','New Zealand','Palau','Papua New Guine','Saipan','Vanuatu','Wallis & Futuna' ]

};

//alert( _countrys.亞洲[0] )

function continent_select($continent,$country,$lan){
   
    if($lan=='ch'){      
      var continent_array = _continent;
      var countrys_array  = _countrys;
    }
    else{      
      var continent_array = _continent_en;
      var countrys_array  = _countrys_en;
    }

    //縣市
	var continent = $('select[name="continent"]');
	var country   = $('select[name="country"]');
	 
	//初始化
	continent.unbind('change');
	country.unbind('change');
    
    var str     = ''; //暫存區
	var $match  = 0 ; //檢驗用
    

    //製作下拉式選單
    for(i=0;i < continent_array.length ; i++){
		 
		 if(continent_array[i]!=$continent){
		 str += '<option value="'+continent_array[i]+'">'+continent_array[i]+'</option>';
		 }
		 else{
		 str += '<option value="'+continent_array[i]+'" selected>'+continent_array[i]+'</option>';
 		 $match = 1; 
		 }		 
	}

	//沒有符合結果，初始出現提示選項
	if($match==0){
	  
	  if($lan=='ch')	 
      str = str + '<option value="" selected>洲別/地區</option>';
      else
 	  str = str + '<option value="" selected>Region</option>';

 	} 

	continent.html(str);

    //在洲別select上建立bind監聽--建立國家選項
	continent.bind('change', function() {			 
			
			country.unbind('change'); //去除鄉鎮select的監聽，稍後重新建立
			
			var index = $(this).find('option:selected').val();
			
			if(index=='') return false;

			if($lan=='ch')
			str    = '<option value="" selected>國家</option>';
            else
            str    = '<option value="" selected>Country</option>';

			$match = 0 ;
			
			//建立options				
            var array = eval("countrys_array."+index);

			for(i=0;i < array.length ; i++){
              str += '<option value="'+array[i]+'">'+array[i]+'</option>';			  
            }; 			
          
			country.html(str);
			//建立完畢 
			
			 
    });
	//在洲別select上建立bind監聽--建立國家選項   end	   
	
	//若建立時，洲別已有值的狀態，不等待洲，需直接建立部份
	 if($continent!=''){
		 
		    var index = $continent;
	
			str    = '';
			$match =0	
			
			//建立options				
            var array = eval("countrys_array."+index);

			for(i=0;i < array.length ; i++){
              
              if($country!=array[$i])
              str += '<option value="'+array[i]+'">'+array[i]+'</option>';
              else{
              $match = 1;
              str += '<option value="'+array[i]+'" selected>'+array[i]+'</option>';
              }

            }; 			
          
			
			//建立完畢 
			
			//若未符合
			if($match!=1){

			 if($lan=='ch')
			  str = str + '<option value="" selected>國家</option>';
		     else
              str = str + '<option value="" selected>Country</option>';

            }

			
			country.html(str);
			//建立完畢 
		 
	}		
}