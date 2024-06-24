@extends('web.includes.layout',[
    'page_title' => $seo_data['main'][1]['title'],
    'main_id' => 'index',
    'seo' => true,
    'seo_title' => $seo_data['main'][1]['title'],
    'seo_description' => $seo_data['main'][1]['description'],
    'seo_keyword' => $seo_data['main'][1]['keyword'],
    'seo_image'=> host_path(storage_path($seo_data['main'][1]['pic'])),
    'seo_type' => 'website',
])

@push('head')

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            @foreach ($faq as $element)
            {
            "@type": "Question",
            "name": "{{ $element['name'] }}",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "{{ mb_substr( strip_tags( preg_replace( "/\r|\n/", "", $element['info']) ) , 0 , -1 , "utf8" ) }}"
            }}@if (!$loop->last), @endif
            @endforeach
        ]
    }
</script>
@endpush

@push('script')

<script>
    $('.qa-item').click(function() {
        $(this).toggleClass("active");
        $(this).children(".a-content").slideToggle();
    });

    var join = '<div class="join-group"><div class="join-title mb-3">參加人員[num]</div><div class="form-group row required"><label class="col-sm-3 col-form-label" for="">姓名<span>*</span></label><input type="text" class="form-control col" id="" placeholder="" name="name[]" required></div><div class="form-group row required"><label class="col-sm-3 col-form-label" for="">手機號碼<span>*</span></label><input type="text" class="form-control col" id="" placeholder="" name="cel[]" required></div><div class="form-group row"><label class="col-sm-3 col-form-label" for="">職稱</label><input type="text" class="form-control col" id="" placeholder="" name="job[]" required></div><div class="form-group row required"><label class="col-sm-3 col-form-label" for="">E-MAIL<span>*</span></label><input type="text" class="form-control col" id="" placeholder="" name="email[]" required></div></div>';    

    $(function(){

    	$('select[name=num]').change(function(){

    		num = $(this).val();
    		var counter = $('#join-list .join-group').length;

    		if(counter < num){
    			for($i=1;$i<=num-counter;$i++){
    				var unit = join.replace("[num]",counter+$i);
    				$('#join-list').append(unit);
    			}
    		}
    		else{
    			$('#join-list .join-group').slice( num-counter ).remove();
    		}

    	}).change();

    });
</script>
@endpush

@section('main')

<article class="position-relative">
    <section class="position-relative" id="activities">
        <div class="container">
            <div class=""><img class="" src="{{ resources_path() }}_img/index/01.jpg" alt="勞動件供法/職業災害保險及保護法/勞資爭議問題"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/02.jpg" alt="避免陷入勞資糾紛/勞保及職災保險/協商勞資議題/職業災害風險"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/03.jpg" alt="符合上列其中一樣情況，建議您立即報名本講座，因爲企業的危機已潛藏在你身邊，可能讓您的企業有莫大的損失，違反勞基法罰款爲2萬到100萬不等！"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/04.jpg" alt="勞動事件法/加班費的算法/資遣費的算法"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/05.jpg" alt="工資、工時爭議"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/06.jpg" alt="勞動事件法 需注意？"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/07.jpg" alt="勞工職業災書保險及保護法 2022/05/01新法上路/投保薪資金額以多報少"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/08.jpg" alt="職業災害保險及保護法,需留意投保薪資上限"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/09.jpg" alt="面對求職蟑螂，企業應如何處理避免吃啞巴虧"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/10.jpg" alt="勞動教育促進法通過在即,別等勞工培訓完再發生勞資糾紛"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/11.jpg" alt="基本工資連續7年調漲，逐年不斷調漲的工資，勞保、健保、勞退，的支出也隨之提高，有效且合法的節省，二次費用成本，成為企業必修的課程"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/12.jpg" alt="資訊透明化/檢舉方式簡易化"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/13.jpg" alt="109年勞動事件法實施"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/14.jpg" alt="參加本講座課稈內容，【勞動事件法】2個推定及1個舉證的問題？/【勞基法】3張法定報表的合法性的問題？/【勞工職業災害保險及保護法】的執行問題？/即將立法的【勞動教育促進法】的問題？/企業留才=企業留財"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/15.jpg" alt="面對常見【勞資爭議】企業要如何因應及防護對策解析，「勞動契約」爭議：發生爭議時，勞工說的算/「勞動條件」 爭議：工時、加班、補休程序的合法性及注意事項/契約終止」 爭議：企業資遺、開除員工時，須避免爭議發生/「工資認定」爭議：您對法定的「工資V.S非工資」的定義是否清楚？將影響企業二次費用以及職災補償金計算/「職業災害補償金」 爭議：為何買了團體保險，企業還被告，買錯保險 更加危險！/「安定責任準備金」爭議：如何透過安全「提存安定準備金」一次解決企業所有資金風險的問題/「證據保全」 爭議：面對勞資爭議時，企業要如何建立及保存「強而有力的證據」"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/16.jpg" alt="講座後您將省下超過百萬損失。"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/17.jpg" alt="此講座課程適合對象:即將創業的準老闆/企業老闆、負責人/人資及主管/"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/18.jpg" alt="本講座為勞動法務高階速修班"></div>
            <div class=""><img class="" src="{{ resources_path() }}_img/index/19.jpg" alt="專業勞基法專家諮詢服務"></div>
        </div>
    </section>

    <section class="position-relative" id="faq">
        <div class="container">
            <div class="mb-md-8 mb-6"><img class="" src="{{ resources_path() }}_img/index/qa.jpg" alt="勞資常見大哉問"></div>
            @forelse ($faq as $key => $element)
            <div class="qa-item">
                <div class="q-content">
                    <div class="number-cube">
                        <div class="number">{{ ($key+1) }}</div>
                    </div>
                    <div class="title">{{ $element['name'] }}</div>
                    <div class="icon"><i class="fas fa-caret-down"></i></div>
                </div>
                <div class="a-content">
                	{!! htmlspecialchars_decode($element['info']) !!}
                </div>
            </div>
            @empty
            @endforelse
            <div class=""><img class="" src="{{ resources_path() }}_img/index/qa-2.jpg" alt="有以上勞資疑惑，參加本講座後將得到解答"></div>

        </div>
    </section>

    <section class="position-relative pb-8" id="register">
        <div class="container">
            <div class="icon"><i class="fas fa-megaphone"></i></div>
            <div class="text-center title mb-md-5 mb-3">立即報名</div>
            <div class="col-lg-10 mx-auto">
                <form method="post" action="{{ base_path() }}contact" id="contact-form"> 
                	@csrf

                    <div class="form-group required mb-5">
                        <label class="col-form-label big-title" for="">遠離勞資糾紛-法律速成班(報名場次)<span>*</span></label>

                        @forelse($class as $element)
                        <div class="form-check ">
                            <input class="form-check-input" type="checkbox" name="class[]" id="inlineRadio{{ $element['id'] }}" value="{{ $element['name'] }}">
                            <label class="form-check-label" for="inlineRadio{{ $element['id'] }}">{{ $element['name'] }}</label>
                        </div>
                        @empty
                        @endforelse
                    </div>
                    <div class="big-title mb-3">填寫報名資料</div>
                    <div class="form-group row required">
                        <label class="col-sm-3 col-form-label" for="">公司名稱/服務單位<span>*</span></label>
                        <input type="text" class="form-control col" id="" placeholder="" name="company" required>
                    </div>
                    <div class="form-group row required mb-5">
                        <label class="col-sm-3 col-form-label" for="">公司電話<span>*</span></label>
                        <input type="text" class="form-control col" id="" placeholder="" name="tel" required>
                    </div>
                    <div class="form-group required mb-5">
                        <label class="col-form-label big-title" for="">目前想解決或想瞭解的問題</label>

                        @forelse($quest as $element)
                        <div class="form-check ">
                            <input class="form-check-input" type="checkbox" name="quest[]" id="quest{{ $element['id'] }}" value="{{ $element['name'] }}">
                            <label class="form-check-label" for="quest{{ $element['id'] }}">{{ $element['name'] }}</label>
                        </div>
                        @empty
                        @endforelse 
                       
                    </div>

                    <hr>
                    <div class="form-group row required mb-5">
                    	<label class="col-sm-3 col-form-label" for="">報名人數<span>*</span></label>
                        <select name="num" class="form-control col">
                        	@for($i=1;$i<=50;$i++)
                        	<option value="{{ $i }}">{{ $i }}人</option>
                        	@endfor
                        </select>	
                    </div>	
                    <div id="join-list">
	                    
                	</div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="">匯款後五碼</label>
                        <input type="text" class="form-control col" id="" placeholder="" name="last5" maxlength="5">
                        <div class="row mb-2">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9 text-primary2 fs-16">(優惠1,000元/人 費用含講義及飯店下午茶 再贈企業個別諮詢1小時保證物超所值，價值$5,000元，報名後請三日內完成繳費)。可以先填寫報名資料 匯款完成後再於line官方帳號或mail填寫匯款資訊（匯款末五碼及匯款日期）</div>
                        </div>
                    </div>
                    
                    
                    <div class="form-group required mb-5">
                        <label class="col-form-label mr-3" for="">發票是否開立公司抬頭(三聯式發票) </label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ticket" id="yes" value="3">
                            <label class="form-check-label mt-2" for="yes">是</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ticket" id="no" value="2">
                            <label class="form-check-label mt-2" for="no">否</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="">發票抬頭</label>
                        <input type="text" class="form-control col" id="" placeholder="" name="ticket_name">
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="">統一編號</label>
                        <input type="text" class="form-control col" id="" placeholder="" name="ticket_no">
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="">發票寄送地址</label>
                        <input type="text" class="form-control col" id="" placeholder="" name="ticket_address">
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="">得知講座管道</label>
                        <input type="text" class="form-control col" id="" placeholder="" name="from">
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="">推薦人姓名</label>
                        <input type="text" class="form-control col" id="" placeholder="" name="suggest_name">
                    </div>
                    <div class="w-100 ">
                    	<div class="send-btn mx-auto" onclick="validate('#contact-form', 'contact.rule', 'contact.rule_message', 'contact');">送出表單</div>
                    </div>
                </form>
            </div>
        </div>
    </section>

</article>


@endsection



