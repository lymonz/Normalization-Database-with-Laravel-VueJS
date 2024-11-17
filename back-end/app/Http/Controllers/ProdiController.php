<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Prodi::all();
        if(!empty($data)){
            return response()->json([
                "status" => true,
                "message" => "Data Found!",
                "data" => $data
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Data Not Found!",
            ], 404);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            
            'prodi' => 'required|unique:prodis,prodi',
            'jurusan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors(),
            ], 400);
        }

        $data = Prodi::updateOrCreate([
            'prodi' => $request->prodi,
            'jurusan' => $request->jurusan
        ]);

        return response()->json([
            "status" => true,
            "message" => "Data Created",
            $data
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $prodi)
    {
        $data = Prodi::find($prodi);
        if($data){
            return response()->json([
                "status" => true,
                "message" => "Data Found!",
                "data" => $data
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Data Not Found!",
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Prodi::find($id);

        if(!$data) {
            return response()->json([
                "status" => false,
                "message" => "Prodi not found"
            ], 404);
        } else {
            return response()->json([
                "status" => true,
                "message" => "Data Found!",
                "data" => $data
            ],200);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Prodi::findOrFail($id);
        if (!$data) {
            return response()->json([
                "status" => false,
                "message" => "Prodi not found"
            ], 404);
        }
    

        $validator = Validator($request->all(), [
            'prodi' => 'required',
            'jurusan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors(),
            ], 400);
        }
        $datas =[
            'prodi' => $request->prodi,
            'jurusan' => $request->jurusan
        ];
        $data->update($datas);

        return response()->json([
            "status" => true,
            "message" => "Data Updated",
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Prodi::find($id);
        if (!$data) {
            return response()->json([
                "status" => false,
                "message" => "Prodi not found"
            ], 404);
        }
        $data->delete();
        return response()->json([
            "status" => true,
            "message" => "Data Deleted"
        ],200);
    }
}
