<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/branches",
    *     summary="Get the list of all branches",
    *     tags={"Branches"},
    *     @OA\Response(response="200", description="List of branches"),
    * )
    */
    public function index()
    {
        $branches = Branch::all();
        return response()->json($branches);
    }

    /**
     * @OA\Post(
     *     path="/api/branches",
     *     summary="Add a new branch",
     *     tags={"Branches"},
     *     @OA\Response(response="201", description="Branch created"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"branch_name", "company_id"},
     *             @OA\Property(property="branch_name", type="string", example="Branch Name"),
     *             @OA\Property(property="company_id", type="integer", example="1"),
     *         ),
     *     ),
     * )
     */

    public function store(Request $request)
    {
        $data = $request->validate([
            'branch_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
        ]);

        $branch = Branch::create($data);
        return response()->json($branch, 201);
    }
    
    /**
     * @OA\Get(
     *     path="/api/branches/{branch}",
     *     summary="Get branch details with employees",
     *     tags={"Branches"},
     *     @OA\Parameter(
     *         name="branch",
     *         in="path",
     *         required=true,
     *         description="Branch ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Branch details with employees"),
     * )
     */
    public function show(Branch $branch)
    {
        $branch->load(['employees' => function ($query) {
            $query->orderBy('employee_name');
        }]);

        return response()->json($branch);
    }
}
