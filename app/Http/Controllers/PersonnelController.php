<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PersonnelController extends Controller
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
                'code_pers' => 'required|unique:personnels,code_pers|string',
                'nom_pers' => 'required|string',
                'sexe_pers' => 'required|string|in:Masculin,Feminin',
                'phone_pers' => 'required|string|unique:personnels,phone_pers',
                'login_pers' => 'required|string|unique:personnels,login_pers',
                'pwd_pers' => 'required|string',
                'type_pers' => 'required|string',
            ]);

            $validateData['pwd_pers'] = Hash::make($validateData['pwd_pers']);

            $res = Personnel::create($validateData);

            return response()->json([
                'message' => 'Personnel créé avec succès',
                'data' => $res,
            ], 201);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $personnel = Personnel::find($id);

            if (! $personnel) {
                return response()->json(['message' => 'Personnel introuvable'], 404);
            }

            return response()->json(['data' => $personnel], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $personnel = Personnel::find($id);

            if (! $personnel) {
                return response()->json(['message' => 'Personnel introuvable'], 404);
            }

            $validateData = $request->validate([
                'nom_pers' => 'sometimes|string',
                'sexe_pers' => 'sometimes|string|in:Masculin,Feminin',
                'phone_pers' => ['sometimes', 'string', Rule::unique('personnels', 'phone_pers')->ignore($personnel->getKey(), $personnel->getKeyName())],
                'login_pers' => ['sometimes', 'string', Rule::unique('personnels', 'login_pers')->ignore($personnel->getKey(), $personnel->getKeyName())],
                'pwd_pers' => 'sometimes|string',
                'type_pers' => 'sometimes|string',
            ]);

            if (isset($validateData['pwd_pers'])) {
                $validateData['pwd_pers'] = Hash::make($validateData['pwd_pers']);
            }

            $personnel->update($validateData);
            $personnel->refresh();

            return response()->json(['message' => 'Personnel mis à jour avec succès', 'data' => $personnel], 200);

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'file' => $th->getFile(), 'line' => $th->getLine()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $personnel = Personnel::find($id);
            if (! $personnel) {
                return response()->json(['message' => 'Personnel introuvable'], 404);
            }
            $personnel->delete();

            return response()->json(['message' => 'Personnel supprimé avec succès'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
