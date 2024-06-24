<?php

namespace App\Controller\Web;

class ContactController
{
    /**
     * $config.
     *
     * @var array
     */
    protected $config;

    public function __construct()
    {
        $this->config = config('contact');
    }
   
    /**
     * 新增
     */
    public function add()
    {
    	// 驗證碼
        // $rule = $this->config['captcha_rule'];
        // $rule_message = $this->config['captcha_rule_message' . KEY_SUFFIX_LANG];
        // validate($rule, $rule_message);

    	// google機器人驗證
        // $rule = $this->config['g-recaptcha-response_rule'];
        // $rule_message = $this->config['g-recaptcha-response_rule_message' . KEY_SUFFIX_LANG];
        // validate($rule, $rule_message);

        // if (\Session::get('validate.path.contact') != 'pass') {
        //     return back()->withErrors('請重新操作 (Please re-operate)')->send();
        // }

        //主要資訊
        $values = \Request::except('class' , 'quest' , 'name' , 'cel' , 'email' , 'job' , '_method' , '_token');
        $values['class'] = implode(',' , \Request::post('class'));
        $values['quest'] = implode(',' , \Request::post('quest'));
        
        $id = \DB::table($this->config['table'])->insertGetId($values);

        //報名資訊
		$name  = \Request::post('name');
		$cel   = \Request::post('cel');
		$job   = \Request::post('job');
		$email = \Request::post('email');

        foreach ($name as $key => $value) {
        	$values = [
        		'cid' => $id,
        		'name' => $name[$key],
        		'cel' => $cel[$key],
        		'job' => $job[$key],
        		'email' => $email[$key],
        	];
        	\DB::table(config('contact.list_table'))->insertGetId($values);
        }

       
        // -----------------------
        
        //return back()->with('message', '感謝你的報名')->send();
        return redirect('thanks')->send();
    }
}