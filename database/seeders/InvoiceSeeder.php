<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        for ($i = 0; $i < 10; $i++) {
            Invoice::create([
                'invoice_number' => "100100",
                'invoice_Date' => "2022-10-10",
                'Due_date' => "2022-11-15",
                'product_id' => rand(1, 10),
                'section_id' => rand(1, 4),
                'Amount_collection' => rand(100000, 200000),
                'Amount_Commission' => rand(10000, 20000),
                'Discount' => rand(1000, 2000),
                'Value_VAT' => rand(1000, 2000),
                'Rate_VAT' => rand(10, 20) . "%",
                'Total' => rand(100000, 200000),
                'value_status' =>rand(1, 2),
                'status' => 'غير مدفوعة',
                'note' => "تمت اضافة الفاتورة الاولى ",
            ]);
        }
    }
}
