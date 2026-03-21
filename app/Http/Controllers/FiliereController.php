<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class FiliereController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/filieres",
     *     summary="Get list of filieres",
     *     tags={"Filieres"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(
     *                 type="object",
     *
     *                 @OA\Property(property="code_filiere", type="string", example="FIL001"),
     *                 @OA\Property(property="label_filiere", type="string", example="Informatique"),
     *                 @OA\Property(property="desc_filiere", type="string", example="Description"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 5); // valeur par défaut = 20
        $filieres = Filiere::paginate($perPage);

        return response()->json([
            'filieres' => $filieres->items(),
            'pagination' => [
                'current_page' => $filieres->currentPage(),
                'last_page' => $filieres->lastPage(),
                'per_page' => $filieres->perPage(),
                'total' => $filieres->total(),
            ],
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/filieres",
     *     summary="Create a new filiere",
     *     tags={"Filieres"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *             required={"code_filiere", "label_filiere"},
     *
     *             @OA\Property(property="code_filiere", type="string", example="FIL001"),
     *             @OA\Property(property="label_filiere", type="string", example="Informatique"),
     *             @OA\Property(property="desc_filiere", type="string", nullable=true, example="Description")
     *         )
     *     ),
     *
     *     @OA\Response(response=201, description="Filiere created successfully"),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'code_filiere' => 'required|min:5|string|unique:filieres,code_filiere',
                'label_filiere' => 'required|min:5|string',
                'desc_filiere' => 'nullable|string',
            ]);

            $res = Filiere::create($validateData);

            return response()->json(['message' => 'Filiere crée avec succès', 'data' => $res], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/filieres/{code_filiere}",
     *     summary="Get a filiere by code",
     *     tags={"Filieres"},
     *
     *     @OA\Parameter(
     *         name="code_filiere",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Filiere found",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="code_filiere", type="string"),
     *             @OA\Property(property="label_filiere", type="string"),
     *             @OA\Property(property="desc_filiere", type="string"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function show(Filiere $filiere)
    {
        return response()->json($filiere, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/filieres/{code_filiere}",
     *     summary="Update a filiere",
     *     tags={"Filieres"},
     *
     *     @OA\Parameter(
     *         name="code_filiere",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(property="label_filiere", type="string"),
     *             @OA\Property(property="desc_filiere", type="string", nullable=true)
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Updated successfully"),
     *     @OA\Response(response=404, description="Not found"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, Filiere $filiere)
    {
        $data = $request->validate([
            'label_filiere' => 'sometimes|required|min:5|string',
            'desc_filiere' => 'sometimes|nullable|string',
        ]);

        $filiere->update($data);

        return response()->json(['message' => 'Filiere mise à jour', 'data' => $filiere], 200);
    }
    // public function update(Request $request, Filiere $filiere)
    // {
    //     $data = $request->validate([
    //         'label_filiere' => 'sometimes|required|min:5|string',
    //         'desc_filiere' => 'sometimes|nullable|string'
    //     ]);

    //     $filiere->update($data);

    //     return response()->json(['message' => 'Filiere mise à jour', 'data' => $filiere], 200);
    // }

    /**
     * @OA\Delete(
     *     path="/api/filieres/{code_filiere}",
     *     summary="Delete a filiere",
     *     tags={"Filieres"},
     *
     *     @OA\Parameter(
     *         name="code_filiere",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(response=200, description="Deleted successfully"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function destroy(string $code_filiere)
    {
        try {
            $filiere = Filiere::findOrFail($code_filiere);
            $filiere->delete();

            return response()->json(['message' => 'Suppression réussie'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Filiere non trouvée'], 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/filieres/search",
     *     summary="Search filieres by label or description",
     *     tags={"Filieres"},
     *
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Search term",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Search results",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(
     *                 type="object",
     *
     *                 @OA\Property(property="code_filiere", type="string"),
     *                 @OA\Property(property="label_filiere", type="string"),
     *                 @OA\Property(property="desc_filiere", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(response=404, description="No results found"),
     *     @OA\Response(response=422, description="No search term provided")
     * )
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (! $query) {
            return response()->json(['message' => 'Aucun terme de recherche fourni'], 422);
        }

        $filieres = Filiere::where('label_filiere', 'like', "%$query%")
            ->orWhere('desc_filiere', 'like', "%$query%")
            ->get();

        if ($filieres->isEmpty()) {
            return response()->json(['message' => 'Aucune filiere trouvée'], 404);
        }

        return response()->json($filieres, 200);
    }
}
