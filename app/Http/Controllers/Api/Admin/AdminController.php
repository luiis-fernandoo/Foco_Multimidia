<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dailies;
use App\Models\Guest;
use App\Models\Guests;
use App\Models\Hotels;
use App\Models\Payments;
use App\Models\Reserves;
use App\Models\Rooms;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //função retorna todos os hoteis cadastrados no sistema.
    public function index()
    {
        //recuperando todos os hoteis do banco
        $hotels = Hotels::all();

        //verificando se está vazio
        if ($hotels->isEmpty()) {
            return response()->json(['message' => 'Não há hoteis']);
        } else {
            return response()->json(['hotels' => $hotels]);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */

    //função de cadastro para persistir no banco de dados.
    public function store(Request $request){

        if ($request->hotelsName) {
            //valido as requisições
            $request->validate([
                'hotelsName' => 'required',
            ]);

            $hotels = new Hotels();
            //insiro os dados do request no objeto hotels.
            $hotels->fill($request->all());
            //salvo no banco
            $hotels->save();

            return response()->json(['message' => 'hotel cadastrado']);
        } //verifico se a requisição foi feita para cadastro de quartos.
        else if ($request->roomName) {

            $request->validate([
                'roomName' => 'required',
                'hotelCode' => 'required',
            ]);

            //esse foreach é para casos em que o usuario adiciona mais de um quarto por vez, 
            //necessitando do uso de indice
            foreach ($request->roomName as $room_names) {
                $rooms = new Rooms();
                $rooms->roomName = $room_names;
                $rooms->hotelCode = $request->input('hotelCode');
                $rooms->save();
            }

            return response()->json(['message' => 'Quarto Cadastrado']);

        } //ou se a requisição foi feita para cadastro de arquivos xml de reservas.
        else if ($request->arquivo) {

            //verifica se tem arquivo na requisição recebida.
            if ($request->has('arquivo')) {
                $arquivoXml = $request->file('arquivo');
                $arquivo = time() . '_' . $arquivoXml->getClientOriginalName();
                $path = public_path('resources/Xml');
                $arquivoXml->move($path, $arquivo);

                //carrega o arquivo que acabou de ser recebido
                $xml = simplexml_load_file('resources/Xml/' . $arquivo);

                //foreach para percorrer os campos de cada reserva que possui no xml.
                foreach ($xml->Reserve as $register) {
                    //salvo essas variaveis por serem necessarias nos outros campos
                    $hotelCode = $register['hotelCode'];
                    $roomCode = $register['roomCode'];

                    //verifica se existe alguma reserva com o id atual.  
                    $existingReserve = DB::table('reserves')
                    ->select('*')
                    ->where('hotelCode', '=', $hotelCode)
                    ->where('roomCode', '=', $roomCode)
                    ->get();

                    if ($existingReserve->isEmpty()) {
                        //salvando nos objetos os dados recebidos pelo xml. Comecando pelos dados reserves.
                        $dataReserve = new Reserves();
                        $dataReserve->hotelCode = $register['hotelCode'];
                        $dataReserve->roomCode = $register['roomCode'];
                        $dataReserve->checkIn = $register->CheckIn;
                        $dataReserve->checkOut = $register->CheckOut;
                        $dataReserve->total = $register->Total;
                        $dataReserve->save();

                        //persistindo nos campos filhos de reserva, a Guest
                        foreach ($register->Guests->Guest as $guest) {
                            $reserveGuest = new Guests();
                            $reserveGuest->name = $guest->Name;
                            $reserveGuest->lastName = $guest->LastName;
                            $reserveGuest->phone = $guest->Phone;
                            $reserveGuest->reserves_id = $dataReserve->id;
                            $reserveGuest->save();
                        }
                        //As diarias de determinada reserva
                        foreach ($register->Dailies->Daily as $daily) {
                            $reserveDaily = new Dailies();
                            $reserveDaily->date = $daily->Date;
                            $reserveDaily->value = $daily->Value;
                            $reserveDaily->reserves_id = $dataReserve->id;
                            $reserveDaily->save();
                        }
                        //e por fim a tabela de pagamentos. Todos sendo salvos no banco de dados com
                        // ids correspondentes a sua reserva.
                        foreach ($register->Payments->Payment as $pay) {
                            $reservePayment = new Payments();
                            $reservePayment->method = $pay->Method;
                            $reservePayment->value = $pay->Value;
                            $reservePayment->reserves_id = $dataReserve->id;
                            $reservePayment->save();
                        }
                    }
                }
                return response()->json(['status' => 'sucess']);
            } else {
                return response()->json(['status' => 'fail']);
            }
        } else {

            return response()->json(['status' => 'fail']);
        }
        return response()->json(['status' => 'sucess']);
    }

    /**
     * Display the specified resource.
     */

    //função que retorna em formato json os objetos especificos de cada consulta.
    public function show(string $id)
    {
        //nesse eloquent é utilizado para recuperar do banco de dados todos os quartos que tenha
        //o mesmo id do hotel, ou seja, quartos separados por qual hotel ele pertence.  
        $rooms = Rooms::join('hotels', 'rooms.hotelCode', '=', 'hotels.id')
        ->select('hotels.*', 'rooms.*')
        ->where('rooms.hotelCode', $id)
        ->get();

        /*esse eloquent é equivalente a uma query que seleciona todas as reservas correspondente a cada hotel, ou seja
        Ele retorna objetos com todos os links de qual hotel, quarto, valor, diaria e pessoa correspondente a cada
        reserva*/

        $reserves = Reserves::join('hotels', 'reserves.hotelCode', '=', 'hotels.id')
        ->join('guests', 'reserves.id', '=', 'guests.reserves_id')
        ->join('dailies', 'reserves.id', '=', 'dailies.reserves_id')
        ->join('payments', 'reserves.id', '=', 'payments.reserves_id')
        ->select('hotels.*', 'reserves.*', 'guests.*', 'dailies.*', 'payments.*')
        ->where('reserves.hotelCode', $id)
        ->get();

        try{
            if ($rooms->isEmpty()) {
                return response()->json(['message' => 'Não há quartos']);
            } else {
                return response()->json(['rooms' => $rooms, 'reserves' => $reserves]);
            }
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);  // Retorna o erro interno do servidor
        }
    }

    /**
     * Update the specified resource in storage.
     */

    //função utilizada para atualizar os dados que foram requeridos.
    public function update(Request $request, string $id)
    {
        $request->validate([
            'roomName' => 'required',
        ]);

        $room = Rooms::find($id);
        $room->fill($request->all());
        $room->update();

        return response()->json(['room' => $room]);

    }

    /**
     * Remove the specified resource from storage.
     */

    //função para deletar os objetos retornados pela request.
    public function destroy(Request $request, string $id){
    
        /*na url da requisição, passo um atributo a mais alem do id do objeto, esse atributo é type, para identificar
        qual tipo do objeto que vai ser deletado, nesse caso 'room' ou 'reserve'.
        */ 
        $type = $request->type;
        if($type === 'room'){

            //recupero o objeto e usando o eloquent do laravel, deleto o objeto do banco.
            $rooms = Rooms::find($id);
            if($rooms){
               $rooms->delete(); 
               return response()->json(['message' => 'Deletado com sucesso']);
    
            }else{
    
                return response()->json(['message' => 'Quarto não encontrado']);
            }

        }else if($type === 'reserves'){
            $reserves = Reserves::find($id);
            if($reserves){
                $reserves->delete();
                return response()->json(['message' => 'Deletado com sucesso']);
            }else{
                return response()->json(['message' => 'Reserva não encontrada']);
            }
        }
        

        
    }
}
