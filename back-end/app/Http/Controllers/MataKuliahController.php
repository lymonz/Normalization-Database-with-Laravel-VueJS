<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = MataKuliah::all();
        if(!empty($data)){
            return response()->json([
                "status" => true,
                "message" => "Data Found!",
                "data" => $data
            ]);
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
            'kode_matkul' => 'required|string|unique:mata_kuliahs,kode_matkul',
            'mata_kuliah' => 'required',
            'sks' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors(),
            ], 400);
        }

        $data = MataKuliah::create([
            'kode_matkul' => $request->kode_matkul,
            'mata_kuliah' => $request->mata_kuliah,
            'sks' => $request->sks,
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
    public function show(string $id)
    {
        $data = MataKuliah::find($id);

        if(!empty($data)){
            return response()->json([
                "status" => true,
                "message" => "Data Found!",
                $data
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
        $data = MataKuliah::find($id);

        if(!empty($data)){
            return response()->json([
                "status" => true,
                "message" => "Data Found!",
                $data
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Data Not Found!",
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = MataKuliah::find($id);
        if (!$data) {
            return response()->json([
                "status" => false,
                "message" => "Mata Kuliah not found"
            ], 404);
        }

        $validator = Validator($request->all(), [
            "kode_matkul" => 'required',
            'mata_kuliah' => 'required',
            "sks" => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors(),
            ], 400);
        }
        $datas =[
            'kode_matkul' => $request->kode_matkul,
            'mata_kuliah' => $request->mata_kuliah,
            'sks' => $request->sks,
        ];
        $data->update($datas);
        return response()->json([
                "status" => true,
                "message" => "Data Updated",
                $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = MataKuliah::find($id);
        if (!$data) {
            return response()->json([
                "status" => false,
                "message" => "Mata Kuliah not found"
            ], 404);
        }
        $data->delete();
        return response()->json([
            "status" => true,
            "message" => "Data Deleted"
        ],200);
    }
}
