<?php

namespace App\Http\Controllers;

use App\Models\Ue;
use Illuminate\Http\Request;

class UeController extends Controller
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
            $validateData = $request->validate([
                'code_ue' => 'required|min:5|string|unique:ues,code_ue',
                'label_ue' => 'required|min:5|string',
                'desc_ue' => 'nullable|string',
                'code_niveau'=>'required|exists:niveaux,code_niveau'
            ]);

            $res = Ue::create($validateData);

            return response()->json(["message" => "Ue crée avec succès", 'data' => $res], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
public function show(Ue $ue)
{
    return response()->json(['data' => [
        'code_ue'    => $ue->code_ue,
        'label_ue'   => $ue->label_ue,
        'desc_ue'    => $ue->desc_ue,
        'code_niveau'=> $ue->code_niveau,
        'created_at' => $ue->created_at,
        'updated_at' => $ue->updated_at,
    ]], 200);
}

public function update(Request $request, Ue $ue)
{
    try {
        // DEBUG TEMPORAIRE
        \Log::info('UE reçu:', ['ue' => $ue->toArray(), 'key' => $ue->getKey()]);

        $found = Ue::find($ue->getKey());
        \Log::info('UE trouvé en DB:', ['found' => $found ? $found->toArray() : null]);

        
        $validateData = $request->validate([
            'label_ue'    => 'sometimes|string',
            'desc_ue'     => 'sometimes|nullable|string',
            'code_niveau' => 'sometimes|exists:niveaux,code_niveau',
        ]);

        $ue->update($validateData);
        $ue->refresh(); // ← ajoute cette ligne

        return response()->json(['message' => 'UE mis à jour', 'data' => [
            'code_ue'     => $ue->code_ue,
            'label_ue'    => $ue->label_ue,
            'desc_ue'     => $ue->desc_ue,
            'code_niveau' => $ue->code_niveau,
            'created_at'  => $ue->created_at,
            'updated_at'  => $ue->updated_at,
        ]], 200);
    } catch (\Throwable $th) {
        return response()->json([
            'message' => $th->getMessage(),
            'file'    => $th->getFile(),
            'line'    => $th->getLine(),
        ], 500);
    }
}

public function destroy(Ue $ue)
{
    try {
        $ue->delete();
        return response()->json(['message' => 'UE supprimé avec succès'], 200);
    } catch (\Throwable $th) {
        return response()->json(['message' => $th->getMessage()], 500);
    }
}
}
