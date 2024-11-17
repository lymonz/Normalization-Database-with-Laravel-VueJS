<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     
    public function index()
    {
        $data = Mahasiswa::with('prodis')->get();
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
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $prodi = Prodi::all();
        return response()->json([
            "status" => true,
            "message" => "Data Found!",
            "prodi" => $prodi
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'nim' => 'required|unique:mahasiswas,nim',
            'nama' => 'required',
            'prodi_id' => 'required',
            'no_hp' => 'nullable',
            'alamat' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors(),
            ], 400);
        }

        $data = Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,            
            'prodi_id' => $request->prodi_id,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
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
    public function show(int $id)
    {
        $data = Mahasiswa::with('prodis')->find($id);

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
    public function edit(int $id)
    {
        $data = Mahasiswa::with('prodis')->find($id);

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
    public function update(Request $request, int $id)
    {
        $data = Mahasiswa::find($id)->first();
        if (!$data) {
            return response()->json([
                "status" => false,
                "message" => "Prodi not found"
            ], 404);
        }
    

        $validator = Validator($request->all(), [
            'nim' => 'required',
            'nama' => 'required',
            'prodi_id' => 'required',
            'no_hp' => 'nullable',
            'alamat' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors(),
            ], 400);
        }
        $datas =[
            'nim' => $request->nim,
            'nama' => $request->nama,
            'prodi_id' => $request->prodi_id,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat
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
        $data = Mahasiswa::find($id);
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
