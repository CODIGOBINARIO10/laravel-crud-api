<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller
{
    //
    public function index()
    {
       $students = Student::all();

      $data = [
        'students' => $students,
        'status' => 200
      ];

        return response()->json($data, 200);
    }

    //Funcion parta crear estudiantes
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(),[ //valida con validator la base de datos con request->all
        'name' => 'required|max:255',   //arreglo de datos
        'email' => 'required|email|unique:student',
        'phone' => 'required|digits:10',
        'languaje' => 'required|in:English,Spanish,French'
      ]);
       
      if ($validator->fails()) {// Si hay un valor en la validacion con $validator->fails
        $data = [      //Entonces nos muestra este mensaje
          'message' => 'Error en la validacion de los datos',
          'errors' =>  $validator->errors(),
          'status' => 400
        ];
        return response()->json($data, 400); // Luego le muestra esto al cliente 
      }

      //y si los datos son correctios entonces creo una variable student
      $student = Student::create([
        'name' => $request->name, //bienen de $request ya que es lo que envia el cliente
        'email' => $request->email,
        'phone' => $request->phone,
        'languaje' =>$request->languaje
      ]);
      //y finalmente le digo con un if si no pudiste crea un estudiante quer Erro al crear estudiante
      if (!$student) {
        $data = [
          'message' => 'Error al crear el estudiante',
          'status' => 500
        ];
        return response()->json($data, 500);
      }
        //Pero si si pudo crearlo entonces boy a retornar otro arreglo data
        $data = [
           'student' => $student,
           'status' => 201
        ];
         return response()->json($data, 201);//respuesta al cliente en formato json que la variable data a creado un nuevo estudiante mostgrando el 201
      }

    public function show($id)
    {
      $student =Student::find($id);

      if (!$student) {
        $data = [
          'message' => 'Estudiante no encontrado',
          'status' => 404
        ];
        return response()->json($data, 404);
      }

      $data = [
        'student' => $student,
        'status' => 200
      ];
      return response()->json($data, 200);
    }

     //Usamos destroy para elimnar a un estudiante mediante su {id}
    public function destroy($id)
    {
      
      $student = Student::find($id);

      if (!$student) {
        $data = [
            'message' => 'Estudiante no enciontrado',
            'status' => 404 
        ];
        return response()->json($data, 404);
      }

      $student->delete();

      $data = [

        'message' => 'Estudiante eliminado',
        'status' => 200
      ];
    }

    public function update(Request $request, $id)
    {
      $student = Student::find($id);

      if (!$student) {
        $data = [
          'message' => 'Estudiante no encontrado',
          'status' => 404
        ];
        return response()->json($data, 404);
      }
      //Creamos el validator
       $Validator = Validator::make($request->all(), [
          'name' => 'required|max:255',
          'email' => 'required|email|unique:student',
          'phone' => 'required|digits:10',
          'languaje' => 'required|in:English,Spanish,French'
      ]);

      if ($Validator->fails()) {
        $data = [
          'message' => 'Error en la validacion de los datos',
          'errors' => $Validator->errors(),
          'status' => 400
        ];
        return response()->json($data, 404);
      }

      $student->name = $request->name;
      $student->email = $request->email;
      $student->phone = $request->phone;
      $student->languaje = $request->languaje;

      //guardo estos  datos
      $data = [
        'message' => 'Estudiante actaualizado',
        'student' => $student,
        'status' => 200
      ];
      return response()->json($data, 202);
    }

    public function updatePartial(Request $request, $id)
    {
      $student = Student::find($id);

      if (!$student) {
        $data = [
          'message' => 'Estudiante no encontrado',
          'status' => 404
        ];
        return response()->json($data, 404);
      }
      $validator = Validator::make($request->all(), [
         'name' => 'max:255',
         'email' => 'email|unique:student',
         'phone' => 'digits:10',
         'languaje' => 'in:English,Spanish,French'
      ]);

      if ($validator->fails()) {
        $data = [
           'message' => 'Error en la validacion de los datos',
           'errors' => $validator->errors(),
           'status' => 400
        ];
        return response()->json($data, 404);
      }

      if ($request->has('name')) {
        $student->name = $request->name;
      }

      if ($request->has('email')) {
        $student->email = $request->email;
      }

      if ($request->has('phone')) {
        $student->phone = $request->phone;
      }

      if ($request->has('languaje')) {
        $student->languaje = $request->languaje;
      }

      $student->save();

      $data = [
        'message' => 'Estudiante actualizado',
        'student' => $student,
        'status' => 200
      ];
      return response()->json($data, 200);


    }
    }
