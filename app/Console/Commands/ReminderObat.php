<?php

namespace App\Console\Commands;

use App\Models\Alarm;
use Illuminate\Console\Command;

class ReminderObat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:obat';

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
        $alarm = Alarm::select("id_alarm", 'nama', 'dosis', 'pengulangan' ,'no_whatsapp', 'nama_obat', 'aturan', 'aturan_tambahan')->join('users', 'alarm.id_user', '=','users.id_user')->join('obat', 'alarm.id_obat', '=','obat.id_obat')->where('waktu', date('H:i'))->get();
        if ($alarm != null) {
            $route = route('alarm');
            foreach ($alarm as  $value) {
                if ($value->pengulangan == 3) {
                    Alarm::where('id_alarm',$value->id_alarm)->update([
                        'pengulangan' => 0,
                        'waktu' => date('H:i', strtotime($value->waktu . " - 6 minutes"))
                    ]);
                }else if ($value->pengulangan < 3) {
                    $tes = $value->pengulangan+1;
                $message =
"
Halo {$value->nama}, waktunya minum obat !

Nama Obat  : {$value->nama_obat}
Dosis : {$value->dosis} x sehari
Aturan : {$value->aturan}
Aturan Tambahan : {$value->aturan_tambahan}

Detailnya bisa cek disini yaa, {$route}";
                Alarm::where('id_alarm',$value->id_alarm)->update([
                    'pengulangan' => $value->pengulangan+1,
                    'waktu' => date('H:i', strtotime($value->waktu . " + 2 minutes"))
                ]);
                \Whatsapp::send($value->no_whatsapp, $message);
                }
            }
        }
        return Command::SUCCESS;
    }
}
