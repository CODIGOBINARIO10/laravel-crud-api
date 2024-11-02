<?php

use App\Http\Controllers\api\studentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



//Con este codigo estamos respondiendo una peticion get al cliente cuando visite esa pagina: api/students en este caso esta url
Route::get('/students', [studentController::class, 'index']);//llamamos el metodo index directamente desde studentController


Route::get('/students/{id}', [studentController::class, 'show']);
//--------Ahora tenemos el crud completo--------

//Ruta para crear estudiantes con el metodo "POST"
Route::post('/students', [studentController::class, 'store']);//llamo al metodo store de crear estudiante

 //Ruta para Actualizar o editar estudiantes con el metodo "PUT"
 Route::put('/students/{id}', [studentController::class, 'update']);

 Route::patch('/students/{id}', [studentController::class, 'updatePartial']);


  //Ruta para eliminar estudiantes con el metodo "DELETE"
  Route::delete('/students/{id}', [studentController::class, 'destroy']);