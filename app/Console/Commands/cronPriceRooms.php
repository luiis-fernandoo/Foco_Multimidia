<?php

namespace App\Console\Commands;

use App\Models\Rooms;
use Carbon\Carbon;
use Illuminate\Console\Command;

class cronPriceRooms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronPriceRooms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command PriceRooms';

    /**
     * Execute the console command.
     */
    //metodo command para uso cron que atualiza o preço dos quartos de acordo com a data do mes.
    // o nome do comando para rodar é php artisan cronPriceRooms.
    public function handle()
    {   //recebo os dados de quartos do banco de dados
        $rooms = Rooms::all();
        //função para data atual 
        $dateCurrent = Carbon::now();
        foreach($rooms as $room){
            //se o dia for maior que 20, o preço dos quartos irá aumentar em 15%
            if($dateCurrent->day > 20){
                $room->price  *= 1 + 0.07;
            //se for entre os dias 1 e 10, preço cai para 20%
            }else if($dateCurrent->day >= 1 and $dateCurrent->day <= 10){
                $room->price *= 1 - 0.05;
            }else{
                $room->price;
            }
            //atualizo o preço dos quartos no banco de dados.
            $room->update();
        
        }
        
    }
}
