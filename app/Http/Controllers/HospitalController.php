<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function hospital(Request $request){
        $data = Hospital::get();

        $response['message'] = "Pegambilan data berhasil!";
        $response['data'] = $data;

        return response()->json($response);
    }

    public function store(Request $request){
        
        $request->validate([
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|numeric'
        ]);

        $data = new Hospital();
        $data->name = $request->name;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->save();

        $response['message'] = "Data berhasil dibuat!";
        $response['data'] = $data;

        return response()->json($response);
    }

    public function update(Request $request, Hospital $hospital){
        
        $request->validate([
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|numeric'
        ]);
        
        $hospital->name = $request->name;
        $hospital->address = $request->address;
        $hospital->phone = $request->phone;
        $hospital->save();

        $response['message'] = "Data berhasil diupdate!";
        $response['data'] = $hospital;

        return response()->json($response);
    }

    public function delete(Request $request, Hospital $hospital){

        $hospital->delete();

        $response['message'] = "Data berhasil dihapus!";
        $response['data'] = true;

        return response()->json($response);
    }
}
