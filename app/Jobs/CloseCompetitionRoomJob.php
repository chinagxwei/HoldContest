<?php

namespace App\Jobs;

use App\Models\Competition\CompetitionRoom;
use App\Service\Competition\CompetitionEventService;
use App\Service\Wallet\RefundService;
use App\Service\Wallet\WalletHandle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CloseCompetitionRoomJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $room_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($room_id)
    {
        //
        $this->room_id = $room_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Log::info("========= 房间状态定时检查 =========");
        DB::beginTransaction();
        try {
            CompetitionEventService::closeRoomByID($this->room_id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }
}
