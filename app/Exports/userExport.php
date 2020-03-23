<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class userExport implements WithHeadings, FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $usersData = User::select('name', 'email', 'city', 'address', 'created_at')->where(['status' => 1])->orderBy('id', 'desc')->get();
        return $usersData;
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'City', 'Address', 'Created At'];
    }
}
