<?php

namespace App\Http\Controllers;

use App\Models\Enseigne;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EnseigneController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'code_pers' => 'required|exists:personnels,code_pers',
                'code_ec' => 'required|exists:ecs,code_ec',
                'date_ens' => 'required|date',
            ]);

            $validateData['id'] = (string) Str::uuid(); // ✅ UUID obligatoire

            $res = Enseigne::create($validateData);

            return response()->json(['message' => 'Enseigne créée avec succès', 'data' => $res], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function update(Request $request, $code_pers, $code_ec)
    {
        try {
            $enseigne = Enseigne::where('code_pers', $code_pers)
                ->where('code_ec', $code_ec)
                ->first();

            if (! $enseigne) {
                return response()->json(['message' => 'Enseigne introuvable'], 404);
            }

            $validateData = $request->validate([
                'date_ens' => 'sometimes|date',
            ]);

            $enseigne->update($validateData);

            return response()->json(['message' => 'Enseigne mise à jour', 'data' => $enseigne], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function destroy($code_pers, $code_ec)
    {
        try {
            $enseigne = Enseigne::where('code_pers', $code_pers)
                ->where('code_ec', $code_ec)
                ->first();

            if (! $enseigne) {
                return response()->json(['message' => 'Enseigne introuvable'], 404);
            }

            $enseigne->delete();

            return response()->json(['message' => 'Enseigne supprimée avec succès'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
