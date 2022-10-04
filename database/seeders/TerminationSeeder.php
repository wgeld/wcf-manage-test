<?php

namespace Database\Seeders;

use App\Models\Termination;
use Illuminate\Database\Seeder;

class TerminationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $collections = [
            [
                //'account_id' => '713308-318491',
                'service_order_number' => 'SORD48568464546',
                'location_id' => '713308',
                'customer_id' => '318491',
                'customer_name' => 'WFLD GAS & ELECTRIC OPS CTR',
                'service_address' => '',
                'request_id' => '2-Current',
                'requested_date' => '2021-09-10',
                //'due_date' => '2021-08-09',
                'status' => 'COMPLETED',
                //'delivery_status' => 'CLICK',
                'is_suspended' => false,
                'has_phone_service' => true,
                'ont_object_name' => 'OPS-7360-1:1-1-1-7-1'
            ],
            [
                //'account_id' => '713308-318491',
                'service_order_number' => 'SORD48568464546',
                'location_id' => '713308',
                'customer_id' => '318491',
                'customer_name' => 'WFLD GAS & ELECTRIC OPS CTR',
                'service_address' => '',
                'request_id' => '2-Current',
                'requested_date' => '2021-09-10',
                //'due_date' => '2021-08-09',
                'status' => 'COMPLETED',
                //'delivery_status' => 'CLICK',
                'is_suspended' => false,
                'has_phone_service' => true,
                'ont_object_name' => 'OPS-7360-1:1-1-1-7-2'
            ]
        ];
        /*
        $collections = [
            [
                'account_id' => '713308-318491',
                'location_id' => '713308',
                'customer_id' => '318491',
                'customer_name' => 'WFLD GAS & ELECTRIC OPS CTR',
                'email' => '',
                'notice_step' => '2-Current',
                'notice_date' => '2021-09-10',
                'due_date' => '2021-08-09',
                'status' => 'COMPLETED',
                'delivery_status' => 'CLICK',
                'is_suspended' => false,
                'has_phone_service' => true,
            'ont_object_name' => 'OPS-7360-1:1-1-1-7-1'
            ],
            [
                'account_id' => '713308-318491',
                'location_id' => '713308',
                'customer_id' => '318491',
                'customer_name' => 'WFLD GAS & ELECTRIC OPS CTR',
                'email' => '',
                'notice_step' => '2-Current',
                'notice_date' => '2021-09-10',
                'due_date' => '2021-08-09',
                'status' => 'COMPLETED',
                'delivery_status' => 'CLICK',
                'is_suspended' => false,
                'has_phone_service' => true,
                'ont_object_name' => 'OPS-7360-1:1-1-1-7-2'
            ],
            [
                'account_id' => '713308-318491',
                'location_id' => '713308',
                'customer_id' => '318491',
                'customer_name' => 'WFLD GAS & ELECTRIC OPS CTR',
                'email' => '',
                'notice_step' => '2-Current',
                'notice_date' => '2021-09-10',
                'due_date' => '2021-08-09',
                'status' => 'COMPLETED',
                'delivery_status' => 'CLICK',
                'is_suspended' => false,
                'has_phone_service' => false,
                'ont_object_name' => 'OPS-7360-1:1-1-1-7-3'
            ],
            [
                'account_id' => '713308-318491',
                'location_id' => '713308',
                'customer_id' => '318491',
                'customer_name' => 'WFLD GAS & ELECTRIC OPS CTR',
                'email' => '',
                'notice_step' => '2-Current',
                'notice_date' => '2021-09-10',
                'due_date' => '2021-08-09',
                'status' => 'COMPLETED',
                'delivery_status' => 'CLICK',
                'is_suspended' => false,
                'has_phone_service' => true,
                'ont_object_name' => 'OPS-7360-1:1-1-1-7-5'
            ],
            [
                'account_id' => '713308-318491',
                'location_id' => '713308',
                'customer_id' => '318491',
                'customer_name' => 'WFLD GAS & ELECTRIC OPS CTR',
                'email' => '',
                'notice_step' => '2-Current',
                'notice_date' => '2021-09-10',
                'due_date' => '2021-08-09',
                'status' => 'COMPLETED',
                'delivery_status' => 'CLICK',
                'is_suspended' => false,
                'has_phone_service' => true,
                'ont_object_name' => 'OPS-7360-1:1-1-1-7-6'
            ],
            [
                'account_id' => '713308-318491',
                'location_id' => '713308',
                'customer_id' => '318491',
                'customer_name' => 'WFLD GAS & ELECTRIC OPS CTR',
                'email' => '',
                'notice_step' => '2-Current',
                'notice_date' => '2021-09-10',
                'due_date' => '2021-08-09',
                'status' => 'COMPLETED',
                'delivery_status' => 'CLICK',
                'is_suspended' => false,
                'has_phone_service' => false,
                'ont_object_name' => 'OPS-7360-1:1-1-1-7-7'
            ],
            [
                'account_id' => '713308-318491',
                'location_id' => '713308',
                'customer_id' => '318491',
                'customer_name' => 'WFLD GAS & ELECTRIC OPS CTR',
                'email' => '',
                'notice_step' => '2-Current',
                'notice_date' => '2021-09-10',
                'due_date' => '2021-08-09',
                'status' => 'COMPLETED',
                'delivery_status' => 'CLICK',
                'is_suspended' => false,
                'has_phone_service' => false,
                'ont_object_name' => 'OPS-7360-1:1-1-1-7-8'
            ],
            [
                'account_id' => '713308-318491',
                'location_id' => '713308',
                'customer_id' => '318491',
                'customer_name' => 'WFLD GAS & ELECTRIC OPS CTR',
                'email' => '',
                'notice_step' => '2-Current',
                'notice_date' => '2021-09-10',
                'due_date' => '2021-08-09',
                'status' => 'COMPLETED',
                'delivery_status' => 'CLICK',
                'is_suspended' => false,
                'has_phone_service' => false,
                'ont_object_name' => 'OPS-7360-1:1-1-1-7-9'
            ],
            [
                'account_id' => '713308-318491',
                'location_id' => '713308',
                'customer_id' => '318491',
                'customer_name' => 'WFLD GAS & ELECTRIC OPS CTR',
                'email' => '',
                'notice_step' => '2-Current',
                'notice_date' => '2021-09-10',
                'due_date' => '2021-08-09',
                'status' => 'COMPLETED',
                'delivery_status' => 'CLICK',
                'is_suspended' => false,
                'has_phone_service' => true,
                'ont_object_name' => 'OPS-7360-1:1-1-1-7-10'
            ],
            [
                'account_id' => '713308-318491',
                'location_id' => '713308',
                'customer_id' => '318491',
                'customer_name' => 'WFLD GAS & ELECTRIC OPS CTR',
                'email' => '',
                'notice_step' => '2-Current',
                'notice_date' => '2021-09-10',
                'due_date' => '2021-08-09',
                'status' => 'COMPLETED',
                'delivery_status' => 'CLICK',
                'is_suspended' => false,
                'has_phone_service' => true,
                'ont_object_name' => 'OPS-7360-1:1-1-1-7-11'
            ],
            [
                'account_id' => '713308-318491',
                'location_id' => '713308',
                'customer_id' => '318491',
                'customer_name' => 'WFLD GAS & ELECTRIC OPS CTR',
                'email' => '',
                'notice_step' => '2-Current',
                'notice_date' => '2021-09-10',
                'due_date' => '2021-08-09',
                'status' => 'COMPLETED',
                'delivery_status' => 'CLICK',
                'is_suspended' => false,
                'has_phone_service' => false,
                'ont_object_name' => 'OPS-7360-1:1-1-1-7-12'
            ],
            [
                'account_id' => '713308-318491',
                'location_id' => '713308',
                'customer_id' => '318491',
                'customer_name' => 'WFLD GAS & ELECTRIC OPS CTR',
                'email' => '',
                'notice_step' => '2-Current',
                'notice_date' => '2021-09-10',
                'due_date' => '2021-08-09',
                'status' => 'COMPLETED',
                'delivery_status' => 'CLICK',
                'is_suspended' => false,
                'has_phone_service' => false,
                'ont_object_name' => 'OPS-7360-1:1-1-1-7-95'
            ],
            [
                'account_id' => '713308-318491',
                'location_id' => '713308',
                'customer_id' => '318491',
                'customer_name' => 'WFLD GAS & ELECTRIC OPS CTR',
                'email' => '',
                'notice_step' => '2-Current',
                'notice_date' => '2021-09-10',
                'due_date' => '2021-08-09',
                'status' => 'COMPLETED',
                'delivery_status' => 'CLICK',
                'is_suspended' => false,
                'has_phone_service' => false,
                'ont_object_name' => 'OPS-7360-1:1-1-1-7-97'
            ],
            [
                'account_id' => '713308-318491',
                'location_id' => '713308',
                'customer_id' => '318491',
                'customer_name' => 'WFLD GAS & ELECTRIC OPS CTR',
                'email' => '',
                'notice_step' => '2-Current',
                'notice_date' => '2021-09-10',
                'due_date' => '2021-08-09',
                'status' => 'COMPLETED',
                'delivery_status' => 'CLICK',
                'is_suspended' => false,
                'has_phone_service' => true,
                'ont_object_name' => 'OPS-7360-1:1-1-1-7-99'
            ],
        ];
        */
        foreach($collections as $collection){
            Termination::create($collection);
        }

    }
}
