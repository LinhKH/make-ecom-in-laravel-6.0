<?php

namespace App\Exports;

use App\NewsletterSubscriber;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class subscribersExport implements WithHeadings,FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $subscribersData = NewsletterSubscriber::select("id","email","created_at")->where('status',1)->orderBy("id","desc")->get();
        return $subscribersData;
    }

    public function headings(): array
    {
        return ['ID', 'Email', 'Created At'];
    }
}
