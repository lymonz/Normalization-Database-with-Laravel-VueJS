<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = Nilai::with(['mahasiswas.prodis', 'matkuls'])->get();
        $mahasiswa = Mahasiswa::all();
        $matkul = MataKuliah::all();
        if ($data->isNotEmpty()) {
            return response()->json([
                "status" => true,
                "message" => "Data Found!",
                "data" => $data,
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
            "mhs_id" => "required",
            "matkul_id" => "required",
            "nilai" => "required",          
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors(),
            ], 400);
        }

        $data = Nilai::create([
            "mhs_id" => $request->mhs_id,
            "matkul_id" => $request->matkul_id,
            "nilai" => $request->nilai,
        ]);

        return response()->json([
            "status" => true,
            "message" => "Data Created!",
            "data" => $data
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Nilai::with(['mahasiswas.prodis', 'matkuls'])->find($id);

        if ($data) {
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
        $data = Nilai::with('mahasiswas', 'matkuls')->find($id);

        if ($data) {
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Nilai::find($id);
        if (!$data) {
            return response()->json([
                "status" => false,
                "message" => "Nilai not found"
            ], 404);
        }

        $validator = Validator($request->all(), [
            "mhs_id" => "required",
            "matkul_id" => "required",
            "nilai" => "required",          
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors(),
            ], 400);
        }

        $data->update([
            "mhs_id" => $request->mhs_id,
            "matkul_id" => $request->matkul_id,
            "nilai" => $request->nilai  
        ]);

        return response()->json([
            "status" => true,
            "message" => "Data Updated!",
            "data" => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Nilai::find($id);
        if (!$data) {
            return response()->json([
                "status" => false,
                "message" => "Nilai not found"
            ], 404);
        }
        $data->delete();
        return response()->json([
            "status" => true,
            "message" => "Data Deleted"
        ],200);

    }
}
