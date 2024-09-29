<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parcel;
use Illuminate\Http\Request;

class ParcelController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/parcels",
     *     tags={"Parcels"},
     *     summary="Get List of Parcels",
     *     description="Retrieve a list of all parcels.",
     *     operationId="getParcels",
     *     @OA\Response(
     *         response="200",
     *         description="List of parcels retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="statuscode",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Parcels retrieved successfully"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Parcel")
     *             )
     *         )
     *     )
     * )
     */

    public function index()
    {
        $parcels = Parcel::all();
        return response()->json([
            'statuscode' => 200,
            'status' => 'success',
            'message' => 'Parcels retrieved successfully',
            'data' => $parcels
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/parcels",
     *     tags={"Parcels"},
     *     summary="Create a Parcel",
     *     description="Store a new parcel.",
     *     operationId="createParcel",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name_product", "name_recipient", "address_shipper", "name_shipper", "address_recipient", "status"},
     *             @OA\Property(property="name_product", type="string", example="Laptop"),
     *             @OA\Property(property="name_recipient", type="string", example="John Doe"),
     *             @OA\Property(property="address_shipper", type="string", example="123 Ship Lane"),
     *             @OA\Property(property="name_shipper", type="string", example="Jane Smith"),
     *             @OA\Property(property="address_recipient", type="string", example="456 Recieve Rd"),
     *             @OA\Property(property="status", type="string", enum={"pending", "delivered", "cancelled"}, example="pending")
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Parcel created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="statuscode",
     *                 type="integer",
     *                 example=201
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Parcel created successfully"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Parcel"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid input provided"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_product' => 'required|string',
            'name_recipient' => 'required|string',
            'address_shipper' => 'required|string',
            'name_shipper' => 'required|string',
            'address_recipient' => 'required|string',
            'status' => 'required|in:pending,delivered,cancelled',
        ]);

        $parcel = Parcel::create($validatedData);

        return response()->json([
            'statuscode' => 201,
            'status' => 'success',
            'message' => 'Parcel created successfully',
            'data' => $parcel->id
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/parcels/{id}",
     *     tags={"Parcels"},
     *     summary="Get a Specific Parcel",
     *     description="Retrieve details of a specific parcel.",
     *     operationId="getParcel",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the parcel to retrieve",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Parcel retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="statuscode",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Parcel retrieved successfully"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Parcel"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Parcel not found"
     *     )
     * )
     */
    public function show(Parcel $parcel)
    {
        return response()->json([
            'statuscode' => 200,
            'status' => 'success',
            'message' => 'Parcel retrieved successfully',
            'data' => $parcel
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/parcels/{id}",
     *     tags={"Parcels"},
     *     summary="Update a Parcel",
     *     description="Update details of an existing parcel.",
     *     operationId="updateParcel",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the parcel to update",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name_product", type="string", example="Updated Laptop"),
     *             @OA\Property(property="name_recipient", type="string", example="John Doe"),
     *             @OA\Property(property="address_shipper", type="string", example="123 Ship Lane"),
     *             @OA\Property(property="name_shipper", type="string", example="Jane Smith"),
     *             @OA\Property(property="address_recipient", type="string", example="456 Recieve Rd"),
     *             @OA\Property(property="status", type="string", enum={"pending", "delivered", "cancelled"}, example="delivered")
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Parcel updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="statuscode",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Parcel updated successfully"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Parcel"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Parcel not found"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid input provided"
     *     )
     * )
     */
    public function update(Request $request, Parcel $parcel)
    {
        $validatedData = $request->validate([
            'name_product' => 'sometimes|required|string',
            'name_recipient' => 'sometimes|required|string',
            'address_shipper' => 'sometimes|required|string',
            'name_shipper' => 'sometimes|required|string',
            'address_recipient' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:pending,delivered,cancelled',
        ]);

        $parcel->update($validatedData);

        return response()->json([
            'statuscode' => 200,
            'status' => 'success',
            'message' => 'Parcel updated successfully',
            'data' => $parcel->id
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/parcels/{id}",
     *     tags={"Parcels"},
     *     summary="Delete a Parcel",
     *     description="Remove a specific parcel from storage.",
     *     operationId="deleteParcel",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the parcel to delete",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Parcel deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="statuscode",
     *                 type="integer",
     *                 example=204
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Parcel deleted successfully"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="null"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Parcel not found"
     *     )
     * )
     */

    public function destroy(Parcel $parcel)
    {
        $parcel->delete();

        return response()->json([
            'statuscode' => 204,
            'status' => 'success',
            'message' => 'Parcel deleted successfully',
            'data' => null
        ], 204);
    }
}
