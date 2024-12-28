<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class Laporan_Aktiviti implements FromCollection, WithMapping, WithHeadings, WithStrictNullComparison
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
            $send_data->state,
            $send_data->daerah,
            $send_data->krt_name,
            $send_data->penganjur,
            $send_data->tarikh_aktiviti,
			$send_data->tajuk_aktiviti,
			$send_data->perasmi_aktiviti,
			$send_data->agenda_kerja,
			$send_data->program,
			$send_data->bidang_kerja,
			$send_data->kategori_aktiviti,
			$send_data->jenis_aktiviti,
			$send_data->jumlah_lelaki,
			$send_data->jumlah_perempuan,
			$send_data->jumlah_umur1,
			$send_data->jumlah_umur2,
			$send_data->jumlah_umur3,
			$send_data->jumlah_umur4,
			$send_data->jumlah_umur5,
			$send_data->jumlah_umur6,
			$send_data->jumlah_umur7,
        ];
    }
	
	public function headings():array{
        return[
			['Bil',
			'Negeri',
            'Daerah',
            'Nama KRT',
            'Penganjur',
            'Tarikh',
            'Tajuk Aktiviti',
			'Perasmi',
			'Agenda Kerja',
			'Program',
			'Bidang',
			'Kategori Aktiviti',
			'Jenis Kategori',
			'Lelaki',
			'Perempuan',
			'0-6',
			'7-12',
			'13-17',
			'18-35',
			'36-45',
			'45-59',
			'60 KEATAS',
			],
        ];
    } 
}
