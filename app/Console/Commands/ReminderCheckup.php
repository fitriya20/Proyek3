<?php

namespace App\Console\Commands;

use App\Models\Jadwal;
use Illuminate\Console\Command;

class ReminderCheckup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:checkup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $jadwal = Jadwal::join('users', 'jadwal.id_user', '=', 'users.id_user')->where('waktu_check', '>', date('Y-m-d'))->get();
        $route = route('jadwal');
        foreach ($jadwal as $value) {
            if (date('Y-m-d', strtotime($value->waktu_check . " - 1 days")) == date('Y-m-d')) {
                if ($value->pengulangan == 3) {
                    Jadwal::where('id_jadwal',$value->id_jadwal)->update([
                        'waktu_pengingat' => date('H:i', strtotime($value->waktu_pengingat . " - 6 minutes"))
                    ]);
                }
                if ($value->pengulangan < 3 ) {
                    if (date('H:i', strtotime($value->waktu_pengingat)) == date('H:i')) {
                $tgl = date('d M Y', strtotime($value->waktu_check));
                $wkt = date('H:i', strtotime($value->waktu));
                $tes = $value->pengulangan+1;
            $message =
"
Halo {$value->nama}, besok waktu check up anda !


Nama Dokter : {$value->nama_dokter}
Tanggal : {$tgl}
Pukul : {$wkt}

Detailnya bisa cek disini yaa, {$route}";
            Jadwal::where('id_jadwal',$value->id_jadwal)->update([
                'pengulangan' => $value->pengulangan+1,
                'waktu_pengingat' => date('H:i', strtotime($value->waktu_pengingat . " + 2 minutes"))
            ]);
            \Whatsapp::send($value->no_whatsapp, $message);
                    }

                }
            }
        }
        return Command::SUCCESS;
    }
}
