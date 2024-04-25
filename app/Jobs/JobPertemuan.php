<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\Api\ApipertemuanController;
use App\Models\Pertemuan;
use App\Models\PertemuanSisfo;

class JobPertemuan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $result;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $result)
    {
        $this->result =$result;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $chunk=collect($this->result)->chunk(1000000);
        foreach($chunk as $arr){
            Pertemuan::insert($arr->toArray());
        }
    }
}
