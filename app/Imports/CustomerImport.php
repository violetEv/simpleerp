<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class CustomerImport implements 
    ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public $successRows = 0;

    public function rules(): array
    {
        return [
            '*.name' => 'required',
        ];
    }

    public function model(array $row)
    {
        $this->successRows++;

        return new Customer([
            'name'      => $row['name'],
            'address'   => $row['address'] ?? null,
            'phone'     => $row['phone'] ?? null,
            'attention' => $row['attention'] ?? null,
        ]);
    }
}