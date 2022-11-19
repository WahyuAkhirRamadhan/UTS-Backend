<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
class PatientsController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        
        if($patients)
        {
            $data = [
                'message' => 'Get all resources patients',
                'data' => $patients
            ];
            return response()->json($data, 200);}else
            { $data = [
                'message' => 'Data is Empty'
            ];
            return response()->json($data, 404);
            
        }

    }
    public function store(Request $request)
    {

        $inputValid = $request->validate([
            'name' => 'required',
            'phone' => 'numeric|required',
            'address' => 'required',
            'status' => 'required',
            'in_date_at' => 'date|required',
            'out_date_at' => 'date|required'
        ]);

        $patients = Patient::create($inputValid);

        $data = [
            'message' => 'Resource is added successfully',
            'data' => $patients
    ];
    return response()->json($data, 201);
}

public function update(Request $request, $id)
    {
        $patients = Patient::find($id);

        if ($patients) {
            $input = [
                'name' => $request->name ?? $patients->name,
                'phone' => $request->phone ?? $patients->phone,
                'address' => $request->address ?? $patients->address,
                'status' => $request->status ?? $patients->status,
                'in_date_at' => $request->in_date_at ?? $patients->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patients->out_date_at
            ];

            $patients->update($input);

            $data = [
                'message' => 'Resource is update successfully',
                'data' => $patients
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found',
            ];

            # mengembalikan data json status code 404
            return response()->json($data, 404);
        }
    }

    public function destroy($id)
    {
        $patients = Patient::find($id);

        if ($patients) {
            $patients->delete();

            $data = [
                'message' => "Resource delete Patient is succsesfuly",
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not Found',
            ];

            return response()->json($data, 404);

        }
    }
    public function show($id)
    {
        $patients = Patient::find($id);

        if ($patients) {
            $data = [
                'message' => 'Get Detail Resource',
                'data' => $patients
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found',
            ];

            return response()->json($data, 200);
        }
    }

    public function search($name)
    {
        $patients = Patient::where('name', 'LIKE', "%$name%")->get();

        if (count($patients) > 0) {
            $data = [
                'message' => 'Get Detail Searched Resource',
                'data' => $patients
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found ',
            ];

            return response()->json($data, 200);
        }
    }

    public function searchByStatus($status)
    {

        # mencari patient berdasarkan status
        $patients = Patient::where('status', 'LIKE', "%$status%")->get();

        if ($patients) {
            $data = [
                'message' => "Resource detail status $status",
                'total' => count($patients),
                'data' => $patients
            ];

            #mengembalikan data json status code 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Resource not found",
            ];

            #mengemablikan data json status code 200
            return response()->json($data, 200);
        }
    }
}