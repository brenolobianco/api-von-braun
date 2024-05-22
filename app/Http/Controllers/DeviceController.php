<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        return response()->json($devices, 200);
    }

    public function show($id)
    {
        $device = Device::find($id);
        if (!$device) {
            return response()->json(['message' => 'Device not found'], 404);
        }
        return response()->json($device, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string|unique:devices',
            'description' => 'required|string',
            'manufacturer' => 'required|string',
            'url' => 'required|string',
        ]);

        $device = Device::create([
            'identifier' => $request->identifier,
            'description' => $request->description,
            'manufacturer' => $request->manufacturer,
            'url' => $request->url,
        ]);

        return response()->json($device, 201);
    }

    public function update(Request $request, $id)
    {
        $device = Device::find($id);
        if (!$device) {
            return response()->json(['message' => 'Device not found'], 404);
        }

        $device->update($request->all());

        return response()->json($device, 200);
    }

    public function destroy($id)
    {
        $device = Device::find($id);
        if (!$device) {
            return response()->json(['message' => 'Device not found'], 404);
        }

        $device->delete();

        return response()->json(['message' => 'Device deleted successfully'], 200);
    }

    public function selectDevice(Request $request)
    {
        $user = Auth::user();
        $device = Device::find($request->device_id);

        if (!$device) {
            return response()->json(['message' => 'Device not found'], 404);
        }

        $user->devices()->attach($device);

        return response()->json(['message' => 'Device selected successfully'], 200);
    }

   
    public function getUserDevices($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $devices = $user->devices;  

        return response()->json($devices);
    }
}
