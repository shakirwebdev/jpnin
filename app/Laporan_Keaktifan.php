<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Krt_Keaktifan;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class Laporan_Keaktifan implements FromCollection, WithMapping, WithHeadings, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */ 
	private $row = 1;
	
    public function headings():array{
        return[
			'Bil',
			'Negeri',
            'Daerah',
            'Parlimen',
            'DUN',
            'Nama KRT',
            'No.Rujukan',
			'Bilangan AJK',
			'Bilangan Aktiviti',
			'Bilangan Mesyuarat',
			'Bilangan Kewangan',
			'Markah Profile(%)',
			'Markah AJK(%)',
			'Markah Aktiviti(%)',
			'Markah Mesyuarat(%)',
			'Markah Kewangan(%)',
			'Markah Manual(%)',
			'Jumlah Markah(%)',
			'Status'
        ];
    } 
	
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
            $send_data->negeri,
            $send_data->daerah,
            $send_data->parlimen,
            $send_data->dun,
            $send_data->nama_krt,
			$send_data->no_rujukan_krt,
			$send_data->bil_ajk,
			$send_data->bil_aktiviti,
			$send_data->bil_mesyuarat,
			$send_data->bil_kewangan,
			$send_data->markah_latar+$send_data->markah_penduduk+$send_data->markah_pekerjaan+$send_data->markah_rumah+$send_data->markah_pertubuhan+$send_data->markah_kemudahan+$send_data->markah_sosial+$send_data->markah_tempat_krt+$send_data->markah_profil_peta,
			$send_data->markah_ajk,
			$send_data->markah_aktiviti,
			$send_data->markah_mesyuarat,
			$send_data->markah_kewangan,
			$send_data->keaktifan_markah,
            $send_data->markah_latar+$send_data->markah_penduduk+$send_data->markah_pekerjaan+$send_data->markah_rumah+$send_data->markah_pertubuhan+$send_data->markah_kemudahan+$send_data->markah_sosial+$send_data->markah_tempat_krt+$send_data->markah_profil_peta+$send_data->markah_ajk+$send_data->markah_aktiviti+$send_data->markah_mesyuarat+$send_data->markah_kewangan+$send_data->keaktifan_markah,
			$send_data->status,
        ];
    }
}
