<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use DateTime;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = User::select('id','name','lastname','birthday','phone','email','address')
            ->selectRaw( 'TIMESTAMPDIFF(YEAR,birthday,CURDATE()) AS edad')
            -> orderBy('name')
            ->paginate(15);

        return response()->json($contacts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'name'=> 'required|string|max:100',
            'lastname'=> 'string|max:100',
            'email'=> 'string|email|max:100|unique:users',
            'phone'=> 'string|max:20',
            'address'=> 'string|max:200',
            'birthday'=> 'date',
            'sexo'=> 'string|max:5',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => '¡huo un error. Por favor revise los datos e intente nuevamente!',
            ], 409);
        }

        //comprobar si es mayor a 18 años
        $birthday =  new DateTime($request->birthday);
        $today = new DateTime();
        $age = $today->diff($birthday);

        if($age->y < 18){
            return response()->json([
                'success' => false,
                'message' => '¡Debes ser mayor de edad!',
            ], 409);
        }


        User::create($request->all());
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = User::find($id,['id','name','lastname','address','birthday','phone','email']);
        return response()->json($contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
        'name'=> 'required|string|max:100',
        'lastname'=> 'string|max:100',
        //'email'=> 'string|email|max:100|unique:users',
        'phone'=> 'string|max:20',
        'address'=> 'string|max:200',
        'birthday'=> 'date',
        'sexo'=> 'string|max:5',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => '¡hubo un error. Por favor revise los datos e intente nuevamente!',
            ], 409);
        }

        //comprobar si es mayor a 18 años
        $birthday =  new DateTime($request->birthday);
        $today = new DateTime();
        $age = $today->diff($birthday);

        if($age->y < 18){
            return response()->json([
                'success' => false,
                'message' => '¡Debes ser mayor de edad!',
            ], 409);
        }

        user::find($id)->update($request->all());


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
    }

    public function search($param)
    {
        if($param !== 'getall'){
            $contacts = User::select('id','name','lastname','birthday','phone','email','address')
                ->selectRaw( 'TIMESTAMPDIFF(YEAR,birthday,CURDATE()) AS edad')
                ->where('name','like','%'.$param.'%')
                ->orWhere('lastname','like','%'.$param.'%')
                ->orWhere('email','like','%'.$param.'%')
                ->orWhere('phone','like','%'.$param.'%')
                ->orderBy('name')
                ->paginate(15);
            // dd($contacts);
            return response()->json($contacts);
        }else{
            return $this->index();
        }
    }
}
