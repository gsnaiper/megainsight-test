<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/branches/{branch}/employees",
     *     summary="Add a new employee to a branch",
     *     tags={"Employees"},
     *     @OA\Parameter(
     *         name="branch",
     *         in="path",
     *         required=true,
     *         description="Branch ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"employee_name", "employee_type"},
     *             @OA\Property(property="employee_name", type="string", example="John Doe"),
     *             @OA\Property(property="employee_type", type="string", example="Engineer"),
     *         ),
     *     ),
     *     @OA\Response(response="201", description="Employee created"),
     *     @OA\Response(response="404", description="Branch not found"),
     * )
     */
    public function store(Request $request, Branch $branch)
    {
        $data = $request->validate([
            'employee_name' => 'required|string|max:255',
            'employee_type' => 'required|string|max:255',
        ]);

        $employee = $branch->employees()->create($data);
        return response()->json($employee, 201);
    }
}
