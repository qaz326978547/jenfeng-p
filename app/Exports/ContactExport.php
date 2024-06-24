<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
// use Maatwebsite\Excel\Events\BeforeWriting;
// use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Service\OrderService;

/**
 * 導出
 *
 * @example https://docs.laravel-excel.com/3.1/exports/ 文檔
 * @example https://phpspreadsheet.readthedocs.io/en/latest/ PhpSpreadsheet 文檔
 */
class ContactExport implements FromQuery, WithEvents, WithHeadings, WithMapping, Responsable
{
	use Exportable;

    /**
     * $config.
     *
     * @var array
     */
	protected $config;

    /**
     * $titles.
     *
     * @var collection
     */
	protected $titles;

    /**
     * $fileName
     *
     * 導出的檔案名稱
     *
     * @var string
     */
	private $fileName = 'List.xls';

	public function __construct()
	{
		$this->config = config('contact');
		// 導出的檔案名稱
		$this->fileName = 'list-' . \Date::now()->toDateTimeString() . '.xls';

		$this->titles = \Collection::make([
			['name' => '序號', 'width' => 5],
			['name' => '報名課程', 'width' => 30],
			['name' => '公司名稱', 'width' => 20],
			['name' => '公司電話', 'width' => 20],
			['name' => '姓名', 'width' => 15], 
			['name' => '手機', 'width' => 20], 
			['name' => 'e-mail', 'width' => 30], 
		]);
	}

    /**
     * 查詢資料
     */
    public function query()
    {
		$where = [['c.del', 0]]; 

		// 日期區間搜尋
		// !empty(\Request::query('s_date')) AND array_push($where, ['o.created_at', '>=', \Request::query('s_date')]);
		// !empty(\Request::query('e_date')) AND array_push($where, ['o.created_at', '<=', \Date::parse(\Request::query('e_date'))->addDay()]);
        return \DB::table($this->config['list_table'].' as list')
        		  ->join($this->config['table'].' as c' , 'c.id' , 'list.cid')
        		  ->where($where)
        		  ->select(
        		  	'c.id' ,
        		  	'c.class' ,
        		  	'c.company' ,
        		  	'c.tel' ,
        		  	'list.cid',
        		  	'list.name',
        		  	'list.cel',
        		  	'list.email',
        		  )        		  
        		  ->orderBy('id', 'desc');
    }

    /**
     * 格式化 - 列
     */
    public function map($row): array
    {
		 

        
         
        return [
			'No'      => '=ROW()-2',
			'class'   => $row['class'],
			'company' => $row['company'],
			'tel'     => $row['tel'],
			'name'    => $row['name'],
			'cel'     => $row['cel'],
			'email'   => $row['email'],
        ];
    }

    /**
     * 標題 標頭
     */
    public function headings(): array
    {
		$title = config('system.web_title') . ' 報名資料';
    	if(!empty(\Request::query('s_date')) || !empty(\Request::query('e_date'))) {
    		$title = $title . ' (日期區間: '.\Request::query('s_date').' - '.\Request::query('e_date').')';
    	} else {
    		$title = $title . ' (全)';
    	}

        return [
			[$title],
			$this->titles->pluck('name')->toArray(),
        ];
    }

    public function registerEvents(): array
    {
        return [
            // BeforeExport::class => function(BeforeExport $event) {
            // 	$event->writer->getDelegate()->getProperties()
											 // ->setCreator('A')
											 // ->setLastModifiedBy('B')
											 // ->setTitle('C')
											 // ->setSubject('D')
											 // ->setDescription('E')
											 // ->setKeywords('F')
											 // ->setCategory('G');
            // },
            AfterSheet::class => function(AfterSheet $event) {

            	foreach ($this->titles->toArray() as $key => $value) {
            		$event->sheet->getDelegate()->getColumnDimensionByColumn($key + 1)->setWidth($value['width']);
            	}

            	// 整體預設
				$styleArray = [
				    'alignment' => [
				        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				    ],
				];
            	$event->sheet->getDelegate()->getParent()->getDefaultStyle()->applyFromArray($styleArray);

            	// 第一列
            	$event->sheet->getDelegate()->mergeCells('A1:N1');
				$styleArray = [
				    'font' => [
				        'bold' => true,
				        'size' => 20,
				    ],
				    'alignment' => [
				        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				    ],
				];
				$event->sheet->getDelegate()->getStyle('A1')->applyFromArray($styleArray);

				// 第二列
				$event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(25);
				$styleArray = [
				    'alignment' => [
				        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				    ],
				];
				$event->sheet->getDelegate()->getStyle('A2:T2')->applyFromArray($styleArray);

            },
        ];
    }
}