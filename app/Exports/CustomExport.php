<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomExport implements FromCollection, WithHeadings
{
    protected $title;
    protected $data;

    public function __construct($title, $data)
    {
        $this->title = $title;
        $this->data = $data;
    }

    public function collection()
    {
        // Return the data excluding the first row (title)
        return collect($this->data)->slice(1);
    }
	
    public function headings(): array
    {
        // Return the second row as headings
        return $this->data[0];
    }
}