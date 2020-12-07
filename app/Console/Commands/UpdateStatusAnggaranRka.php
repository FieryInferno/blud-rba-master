<?php

namespace App\Console\Commands;

use App\Models\Rka;
use App\Models\StatusAnggaran;
use Illuminate\Console\Command;

class UpdateStatusAnggaranRka extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:rka';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $rka = Rka::get();
        foreach ($rka as $item) {
            $tipe = 'MURNI';
            if ($item->tipe == 'PAK') {
                $tipe = 'PERUBAHAN 1';
            }
            $statusAnggaran = StatusAnggaran::where('status_anggaran', $tipe)->first();
            $item->status_anggaran_id = $statusAnggaran->id;
            $item->save();
            $this->info('Update rka ' . $item->tipe . ' menjadi ' . $statusAnggaran->status_anggaran);
        }
    }
}
