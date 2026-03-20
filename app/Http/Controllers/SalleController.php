<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\Request;

class SalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validateData= $request->validate([
                'num_salle'=>'required|min:5|string|unique:salles,num_salle',
                'contenance'=>'required|min:20|integer',
                'status'=>'required|string|',

            ]);
            $res=Salle::create($validateData);
            return response()->json(["message"=> "Salle crée avec succès",'data'=>$res],201);
        }
        catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
        $salle = Salle::find($id);

        if (!$salle) {
            return response()->json(['message' => 'Salle introuvable'], 404);
        }

        return response()->json(['data' => $salle], 200);

        }catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
        $salle = Salle::find($id);

        if (!$salle) {
            return response()->json(['message' => 'Salle introuvable'], 404);
        }

        $validateData = $request->validate([
            'num_salle' => 'sometimes|string|min:5|unique:salles,num_salle,' . $id . ',id',
            'contenance' => 'sometimes|integer|min:20',
            'status' => 'sometimes|string|in:Disponible,Indisponible',
        ]);

        $salle->update($validateData);

        return response()->json([
            "message" => "Salle mise à jour avec succès",
            "data" => $salle
        ], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salle $salle)
{
    try {
        $salle->delete();
        return response()->json(['message' => 'Salle supprimée avec succès'], 200);
    } catch (\Throwable $th) {
        return response()->json(['message' => $th->getMessage()], 500);
    }
}
}
