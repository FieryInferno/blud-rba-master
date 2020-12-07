<?php

namespace App\Console\Commands;

use App\Models\Rba;
use App\Models\StatusAnggaran;
use App\Models\User;
use Illuminate\Console\Command;

class UpdateStatusAnggaranRba extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:rba';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update data rba';

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
        $users = User::get();
        foreach ($users as $user) {
            $user->status_anggaran_id = 1;
            $user->save();
            $this->info('Update status anggaran aktif ' . $user->name . ' ke murni ');
        }
        $rba = Rba::get();
        foreach ($rba as $item) {
            $tipe = 'MURNI';
            if ($item->tipe == 'PAK'){
                $tipe = 'PERUBAHAN 1';
            }
            $statusAnggaran = StatusAnggaran::where('status_anggaran', $tipe)->first();
            $item->status_anggaran_id = $statusAnggaran->id;
            $item->save();
            $this->info('Update rba '. $item->tipe . ' menjadi '. $statusAnggaran->status_anggaran);
        }
    }
}
