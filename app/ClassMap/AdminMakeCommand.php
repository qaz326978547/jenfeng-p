<?php

namespace App\ClassMap;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '產生器';


    protected $input_name;

    protected $input_title;

	protected $folder;

	/**
	 * [$template_folder 模板資料夾]
	 * @var [string]
	 */
	protected $template_folder;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$this->setInputName();
    	// $this->setInputTitle();
    	$this->setTemplateFolder();

        $this->comment('產生 Controller...');
        $this->make_controlle_process();
        $this->line('');

        $this->comment('產生 Config...');
        $this->make_config_process();
        $this->line('');

        $this->comment('產生 View...');
        $this->make_view_process();
        $this->line('');  

        $this->comment('產生 Ajax...');
        $this->make_ajax_process();
        $this->line(''); 

        $this->comment('寫入 Route...');
        $this->write_route_process();
        $this->line('');  

        $this->comment('寫入 View->layout...');
        $this->write_view_layout_process();
        $this->line('');   

        $this->comment('創建 資料表...');
        $this->create_dbtable_process();
        $this->line('');                                           
    }

    private function make_controlle_process()
    {
    	$name = strtolower($this->getInputName());
    	$studly_name = \Str::studly($name);
    	$snake_name = \Str::snake($name);

    	$template_folder = $this->getTemplateFolder();
    	$path = 'app/Controller/Admin/';

        if (is_file($path . $studly_name . 'Controller.php')) {
        	$this->error('Admin/' . $studly_name . 'Controller 已存在');
        } else {
	    	// 模板處理
	    	$stub = \File::get('resources/stub/controller/admin/'.$this->getTemplateFolder().'.stub');
	    	$stub = str_replace(['{{studly_name}}', '{{snake_name}}'], [$studly_name, $snake_name], $stub);

			$file = \File::put($path . $studly_name . 'Controller.php', $stub);

	        if ($file) {
	        	$this->info("成功產生 Admin/{$studly_name}Controller");
	        }
	        else {
	        	$this->error("產生 Admin/{$studly_name}Controller 失敗");
	        }
        }

		// 產生產品架Class
		if (\Str::contains($template_folder, ['product', 'news'])) {
	        if (is_file($path . $studly_name . 'ClassController.php')) {
	        	$this->error('Admin/' . $studly_name . 'ClassController 已存在');
	        } else {
		    	// 模板處理
		    	$stub = \File::get('resources/stub/controller/admin/'.$this->getTemplateFolder().'_class.stub');
		    	$stub = str_replace(['{{studly_name}}', '{{snake_name}}'], [$studly_name, $snake_name], $stub);

				$file = \File::put($path . $studly_name . 'ClassController.php', $stub);

		        if ($file) {
		        	$this->info("成功產生 Admin/{$studly_name}ClassController");
		        }
		        else {
		        	$this->error("產生 Admin/{$studly_name}ClassController 失敗");
		        }
	        }
		}  	
    }

    private function make_config_process()
    {
    	$name = strtolower($this->getInputName());
    	$studly_name = \Str::studly($name);
    	$snake_name = \Str::snake($name);

    	$title = '###' . $studly_name . '###'; //

    	$template_folder = $this->getTemplateFolder();
    	$path = 'config/system/';

        if (is_file($path . $snake_name . '.php')) {
        	$this->error('Config->' . $snake_name . ' 已存在');
        } else {
	    	// 模板處理
	    	$stub = \File::get('resources/stub/config/'.$this->getTemplateFolder().'.stub');
	    	$stub = str_replace(['{{snake_name}}', '{{title}}'], [$snake_name, $title], $stub);

			$file = \File::put($path . $snake_name . '.php', $stub);

	        if ($file) {
	        	$this->info("成功產生 Config->{$snake_name}");
	        }
	        else {
	        	$this->error("產生 Config->{$snake_name} 失敗");
	        }
        }

		// 產生產品架Class
		if (\Str::contains($template_folder, ['product', 'news'])) {
	        if (is_file($path . $snake_name . '_class.php')) {
	        	$this->error('Config->' . $snake_name . '_class 已存在');
	        } else {
		    	// 模板處理
		    	$stub = \File::get('resources/stub/config/'.$this->getTemplateFolder().'_class.stub');
		    	$stub = str_replace(['{{snake_name}}', '{{title}}'], [$snake_name, $title], $stub);

				$file = \File::put($path . $snake_name . '_class.php', $stub);

		        if ($file) {
		        	$this->info("成功產生 Config->{$snake_name}_class");
		        }
		        else {
		        	$this->error("產生 Config->{$snake_name}_class 失敗");
		        }
	        }
		}  	
    }

    private function make_view_process()
    {
    	$name = strtolower($this->getInputName());
    	$studly_name = \Str::studly($name);
    	$snake_name = \Str::snake($name);

    	$title = '###' . $studly_name . '###'; //

    	$template_folder = $this->getTemplateFolder();
    	$path = 'resources/view/admin/' . $snake_name . '/';
    	// 創建 目錄
    	if (! \File::isDirectory($path)) {
			\File::makeDirectory($path, 0755, true);
    	}

        if (count(\File::files($path)) > 0) {
        	$this->error('resource/view/admin/' . $snake_name . '/ 已有 View 存在');
        } else {
        	// 模板處理
	    	$files = \File::files('resources/stub/view/admin/' .$this->getTemplateFolder() . '/');
			$stubs = [];

			foreach ($files as $key => $value) {
				$stubs[$key]['name'] = $value->getBasename('.stub');
				$stubs[$key]['info'] = \File::get($value->getRealPath());
			}

	    	foreach ($stubs as $key => $value) {
	    		$file = \File::put($path . $value['name'].'.php', $value['info']);

		        if ($file) {
		        	$this->info('成功產生 view/admin/' . $snake_name . '/' . $value['name']);
		        }
		        else {
		        	$this->error('產生 view/admin/' . $snake_name . '/' . $value['name'] . ' 失敗');
		        }
	    	}			
        }

		// 產生產品架Class
		if (\Str::contains($template_folder, ['product', 'news'])) {
			$path = 'resources/view/admin/' . $snake_name . '_class/';
        	// 創建 目錄
	    	if (! \File::isDirectory($path)) {
    			\File::makeDirectory($path, 0755, true);
	    	}	

	        if (count(\File::files($path)) > 0) {
	        	$this->error('resource/view/admin/' . $snake_name . '_class/ 已有 View 存在');
	        } else {        	
	        	// 模板處理
		    	$files = \File::files('resources/stub/view/admin/' .$this->getTemplateFolder() . '_class/');
				$stubs = [];

				foreach ($files as $key => $value) {
					$stubs[$key]['name'] = $value->getBasename('.stub');
					$stubs[$key]['info'] = \File::get($value->getRealPath());
				}

		    	foreach ($stubs as $key => $value) {
		    		$file = \File::put($path . $value['name'].'.php', $value['info']);

			        if ($file) {
			        	$this->info('成功產生 view/admin/' . $snake_name . '_class/' . $value['name']);
			        }
			        else {
			        	$this->error('產生 view/admin/' . $snake_name . '_class/' . $value['name'] . ' 失敗');
			        }
		    	}			
	        }
		}  	
    }

    private function make_ajax_process()
    {
    	$name = strtolower($this->getInputName());
    	$studly_name = \Str::studly($name);
    	$snake_name = \Str::snake($name);

    	$title = '###' . $studly_name . '###'; //

    	$template_folder = $this->getTemplateFolder();
    	$path = 'resources/ajax/admin/' . $snake_name . '/';
    	// 創建 目錄
    	if (! \File::isDirectory($path)) {
			\File::makeDirectory($path, 0755, true);
    	}

        if (count(\File::files($path)) > 0) {
        	$this->error('resource/ajax/admin/' . $snake_name . '/ 已有 js 存在');
        } else {
        	// 模板處理
	    	$files = \File::files('resources/stub/ajax/admin/' .$this->getTemplateFolder() . '/');
			$stubs = [];

			foreach ($files as $key => $value) {
				$stubs[$key]['name'] = $value->getBasename('.stub');
				$stubs[$key]['info'] = \File::get($value->getRealPath());
			}

	    	foreach ($stubs as $key => $value) {
	    		$file = \File::put($path . $value['name'].'.js', $value['info']);

		        if ($file) {
		        	$this->info('成功產生 ajax/admin/' . $snake_name . '/' . $value['name'] . '.js');
		        }
		        else {
		        	$this->error('產生 ajax/admin/' . $snake_name . '/' . $value['name'] . '.js 失敗');
		        }
	    	}			
        }

		// 產生產品架Class
		if (\Str::contains($template_folder, ['product', 'news'])) {
			$path = 'resources/ajax/admin/' . $snake_name . '_class/';
        	// 創建 目錄
	    	if (! \File::isDirectory($path)) {
    			\File::makeDirectory($path, 0755, true);
	    	}	

	        if (count(\File::files($path)) > 0) {
	        	$this->error('resource/ajax/admin/' . $snake_name . '_class/ 已有 js 存在');
	        } else {        	
	        	// 模板處理
		    	$files = \File::files('resources/stub/ajax/admin/' .$this->getTemplateFolder() . '_class/');
				$stubs = [];

				foreach ($files as $key => $value) {
					$stubs[$key]['name'] = $value->getBasename('.stub');
					$stubs[$key]['info'] = \File::get($value->getRealPath());
				}

		    	foreach ($stubs as $key => $value) {
		    		$file = \File::put($path . $value['name'].'.js', $value['info']);

			        if ($file) {
			        	$this->info('成功產生 ajax/admin/' . $snake_name . '_class/' . $value['name']. '.js');
			        }
			        else {
			        	$this->error('產生 ajax/admin/' . $snake_name . '_class/' . $value['name'] . '.js 失敗');
			        }
		    	}			
	        }
		}  	
    }

    private function write_route_process()
    {
    	$name = strtolower($this->getInputName());
    	$studly_name = \Str::studly($name);
    	$snake_name = \Str::snake($name);

    	$title = '###' . $studly_name . '###'; //

    	$template_folder = $this->getTemplateFolder();
    	$path = 'routes/admin.php';
    	$now_route = \File::get($path);

    	if (\Str::contains($now_route, 'admin/' . $snake_name)) {
    		$this->error("Admin->{$snake_name} 路由 已存在");
    	} else {
	    	// 模板處理
	    	$stub = \File::get('resources/stub/route/admin/'.$this->getTemplateFolder().'.stub');
	    	$stub = str_replace(['{{studly_name}}', '{{snake_name}}', '{{title}}'], [$studly_name, $snake_name, $title], $stub);

	    	$new_route = str_replace('];', $stub ,$now_route);  
			$file = \File::put($path, $new_route);

	        if ($file) {
	        	$this->info("成功寫入 Admin->{$snake_name} 路由");
	        }
	        else {
	        	$this->error("寫入 Admin->{$snake_name} 路由 失敗");
	        }      		
    	}
    }

    private function write_view_layout_process()
    {
    	$name = strtolower($this->getInputName());
    	$studly_name = \Str::studly($name);
    	$snake_name = \Str::snake($name);

    	$title = '###' . $studly_name . '###'; //

    	$template_folder = $this->getTemplateFolder();
    	$path = 'resources/view/admin/layout/layout.blade.php';
    	$now_layout = \File::get($path);

    	if (\Str::contains($now_layout, 'admin/' . $snake_name)) {
    		$this->error("view/admin/layout->{$snake_name} 區塊 已存在");
    	} else {
	    	// 模板處理
	    	$stub = \File::get('resources/stub/view/admin/layout/'.$this->getTemplateFolder().'.stub');
	    	$stub = str_replace(['{{studly_name}}', '{{snake_name}}', '{{title}}'], [$studly_name, $snake_name, $title], $stub);

	    	$new_layout = \Str::replaceLast('@endadminLeft', $stub ,$now_layout);  
			$file = \File::put($path, $new_layout);

	        if ($file) {
	        	$this->info("成功寫入產生 view/admin/layout->{$snake_name} 區塊");
	        }
	        else {
	        	$this->error("寫入產生 view/admin/layout->{$snake_name} 區塊 失敗");
	        }      		
    	}	
    }

    private function create_dbtable_process()
    {
    	$name = strtolower($this->getInputName());
    	$studly_name = \Str::studly($name);
    	$snake_name = \Str::snake($name);

    	$template_folder = $this->getTemplateFolder();

    	switch ($template_folder) {
    		case 'banner':
    			if (Schema::hasTable($snake_name)) {
    				$this->error("$snake_name} 資料表 已存在");
    			} else {
			        Schema::create($snake_name, function (Blueprint $table) {
			            $table->increments('id');
			            $table->string('name', 250)->default('');
			            $table->string('pic', 250)->default('');
			            $table->string('pic_alt', 250)->default('');
			            $table->text('link')->nullable();
			            $table->boolean('act')->default(0);
			            $table->integer('no')->default(0);		         
			            $table->boolean('del')->default(0);            
			            $table->timestamps();
			        });

			        if (Schema::hasTable($snake_name)) {
			        	$this->info("成功產生 {$snake_name} 資料表");
			        }
		        }

    			break;

    		case 'contact':
    			if (Schema::hasTable($snake_name)) {
    				$this->error("{$snake_name} 資料表 已存在");
    			} else {
			        Schema::create($snake_name, function (Blueprint $table) {
			            $table->increments('id');
			            $table->string('name', 250)->default('');
			            $table->text('info')->nullable();
			            $table->integer('no')->default(0);		         
			            $table->boolean('del')->default(0);            
			            $table->timestamps();
			            $table->text('column_store')->nullable();
			        });

			        if (Schema::hasTable($snake_name)) {
			        	$this->info("成功產生 {$snake_name} 資料表");
			        }
		        }

    			break;

    		case 'news':
    			if (Schema::hasTable($snake_name)) {
    				$this->error("{$snake_name} 資料表 已存在");
    			} else {
			        Schema::create($snake_name, function (Blueprint $table) {
			            $table->increments('id');
			            $table->integer('class_id')->index();	
			            $table->string('name', 250)->default('');
			            $table->timestamp('date')->nullable();
			            $table->string('pic', 250)->default('');
			            $table->string('pic_alt', 250)->default('');
			            $table->string('file', 250)->default('');
			            $table->text('utube')->nullable();
			            $table->text('s_info')->nullable();
			            $table->text('info')->nullable();
			            $table->text('info2')->nullable();
			            $table->text('info3')->nullable();
			            $table->text('info4')->nullable();
			            $table->text('info5')->nullable();
			            $table->integer('be_click')->default(0);	
			            $table->boolean('act')->default(0);  
			            $table->boolean('p_home')->default(0);  
			            $table->boolean('p_new')->default(0);  
			            $table->boolean('p_hot')->default(0);  
			            $table->boolean('p_run')->default(0);  
			            $table->integer('no')->default(0);		         
			            $table->boolean('del')->default(0);            
			            $table->timestamps();
			        });

			        if (Schema::hasTable($snake_name)) {
			        	$this->info("成功產生 {$snake_name} 資料表");
			        }
		        }

    			if (Schema::hasTable($snake_name . '_class')) {
    				$this->error("{$snake_name}_class 資料表 已存在");
    			} else {
			        Schema::create($snake_name . '_class', function (Blueprint $table) {
			            $table->increments('id');
			            $table->integer('class_id')->index();	
			            $table->string('history', 250)->default('');
			            $table->string('name', 250)->default('');
						$table->string('e_name', 250)->default('');
			            $table->string('pic', 250)->default('');
			            $table->string('pic_alt', 250)->default('');
			            $table->text('s_info')->nullable();
			            $table->text('info')->nullable();
			            $table->boolean('act')->default(0);  
			            $table->boolean('p_home')->default(0);   
			            $table->integer('no')->default(0);		         
			            $table->boolean('del')->default(0);            
			            $table->timestamps();
			        });

			        if (Schema::hasTable($snake_name . '_class')) {
			        	$this->info("成功產生 {$snake_name}_class 資料表");
			        }
		        }

    			break;    			

    		case 'product':
    			if (Schema::hasTable($snake_name)) {
    				$this->error("{$snake_name} 資料表 已存在");
    			} else {
			        Schema::create($snake_name, function (Blueprint $table) {
			            $table->increments('id');
			            $table->integer('class_id')->index();	
			            $table->string('name', 250)->default('');
			            $table->string('numbers', 250)->default('');
			            $table->timestamp('date')->nullable();
			            $table->string('pic', 250)->default('');
			            $table->string('pic_alt', 250)->default('');
			            $table->string('file', 250)->default('');
			            $table->text('utube')->nullable();
			            $table->integer('price')->default(0);	
			            $table->integer('s_price')->default(0);
			            $table->integer('be_click')->default(0);
			            $table->text('s_info')->nullable();
			            $table->text('info')->nullable();
			            $table->text('info2')->nullable();
			            $table->text('info3')->nullable();
			            $table->text('info4')->nullable();
			            $table->text('info5')->nullable();	
			            $table->boolean('act')->default(0);  
			            $table->boolean('p_home')->default(0);  
			            $table->boolean('p_new')->default(0);  
			            $table->boolean('p_hot')->default(0);  
			            $table->boolean('p_run')->default(0);  
			            $table->integer('no')->default(0);		         
			            $table->boolean('del')->default(0);            
			            $table->timestamps();
			        });

			        if (Schema::hasTable($snake_name)) {
			        	$this->info("成功產生 {$snake_name} 資料表");
			        }
		        }

    			if (Schema::hasTable($snake_name . '_class')) {
    				$this->error("{$snake_name}_class 資料表 已存在");
    			} else {
			        Schema::create($snake_name . '_class', function (Blueprint $table) {
			            $table->increments('id');
			            $table->integer('class_id')->index();	
			            $table->string('history', 250)->default('');
			            $table->string('name', 250)->default('');
						$table->string('e_name', 250)->default('');
			            $table->string('pic', 250)->default('');
			            $table->string('pic_alt', 250)->default('');
			            $table->text('s_info')->nullable();
			            $table->text('info')->nullable();
			            $table->boolean('act')->default(0);  
			            $table->boolean('p_home')->default(0);   
			            $table->integer('no')->default(0);		         
			            $table->boolean('del')->default(0);            
			            $table->timestamps();
			        });

			        if (Schema::hasTable($snake_name . '_class')) {
			        	$this->info("成功產生 {$snake_name}_class 資料表");
			        }
		        }

    			break; 
 		
    		default:
    			# code...
    			break;
    	}
    }

    /**
    * 設置 input_name
    * 
    */     
    private function setInputName()
    {
    	$input_name = '';

    	while (empty($input_name)) {
    		$input_name = $this->ask('輸入檔案名稱 (例: test / test_abc)');

    		if (empty($input_name)) {
    			$this->error("檔案名稱不能為空");
    		}
    	}


    	$this->input_name = $input_name;
    }

    /**
     * 取得 input_name
     * 
     * @return string
     */ 
    private function getInputName()
    {
    	return $this->input_name;
    } 

    /**
    * 設置 input_title
    * 
    */     
    private function setInputTitle()
    {
    	$input_title = '';

    	while (empty($input_title)) {
    		$input_title = $this->ask('輸入標題 (page_title)');

    		if (empty($input_title)) {
    			$this->error("標題不能為空");
    		}
    	}
    
    	$this->input_title = $input_title;
    }

    /**
     * 取得 input_title
     * 
     * @return string
     */ 
    private function getInputTitle()
    {
    	return $this->input_title;
    } 

    /**
    * 設置 template_folder
    * 
    */     
    private function setTemplateFolder()
    {
		$template_folder = $this->choice('選擇模板?', ['Banner', 'News', 'Product', 'Contact']);
    	$this->template_folder = lcfirst($template_folder);
    }

    /**
     * 取得 template_folder
     * 
     * @return string
     */ 
    private function getTemplateFolder()
    {
    	return $this->template_folder;
    }       
}