<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class Laporan_Kewangan implements FromCollection, WithMapping, WithHeadings, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */ 
	private $row = 1;
	
	public function __construct($send_data)
	{
    	$this->send_data = $send_data;
	}
	
    public function collection()
    {
		//$krt = KRT_Profile::where('krt_status', '=',  true)->orderBy('krt_nama','asc')->get();
		$send_data = $this->send_data; 
        return collect($send_data);
    }
	
	public function map($send_data): array
    {
        return [
			$this->row++,
            $send_data->tarikh_t_b,
            $send_data->kewangan_butiran,
            $send_data->notarikh_cek,
            $send_data->notarikh_resit,
            $send_data->notarikh_baucer,
			$send_data->terima_tunai,
			$send_data->terima_bank,
			$send_data->bayar_tunai,
			$send_data->bayar_bank,
			$send_data->kewangan_baki_tunai,
			$send_data->kewangan_baki_bank,
			$send_data->kewangan_jumlah_baki,
        ];
    }
	
	public function headings():array{
		$tit = $this->send_data[0];
        return[
			[$tit],
			['Bil',
			'Tarikh Penerimaan/Pembayaran',
            'Butiran',
            'No.Cek/Tarikh Cek',
            'No.Resit/Tarikh Resit',
            'No.Baucer/Tarikh Baucer',
            'Terima Tunai',
			'Terima Bank',
			'Bayar Tunai',
			'Bayar Bank',
			'Baki Tunai',
			'Baki Bank',
			'Jumlah Baki',
			],
        ];
    } 
}
