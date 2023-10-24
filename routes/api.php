<?php

use App\Http\Controllers\Api\Admin\AdminController;
use Illuminate\Support\Facades\Route;

/*utilizo somente uma rota pela api Rest que atraves desse apiResource reconhece pelas requisições 
qual o metodo certo a ser utilizado*/ 

Route::apiResource('/hotels', AdminController::class);
