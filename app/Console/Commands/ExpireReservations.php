<?php

namespace App\Console\Commands;

use App\Models\Reservasi;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ExpireReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservasi:kadaluarsa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Konsole ini berguna untuk mengupdate data reservasi yang sudah kadaluarsa';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Reservasi::where('status', 'Siap Diambil')
            ->whereDate('tanggal_expired', '>', Carbon::today())
            ->update([
                'status' => 'Kadaluarsa'
            ]);

        $this->info('Reservasi kadaluarsa berhasil diperbarui.');
    }
}
