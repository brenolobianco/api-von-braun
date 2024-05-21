<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Device;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function index($deviceId)
    {
        $device = Device::find($deviceId);
        if (!$device) {
            return response()->json(['message' => 'Device not found'], 404);
        }

        $commands = $device->commands;
        return response()->json($commands, 200);
    }

    public function show($deviceId, $commandId)
    {
        $command = Command::where('device_id', $deviceId)->where('id', $commandId)->first();
        if (!$command) {
            return response()->json(['message' => 'Command not found'], 404);
        }

        return response()->json($command, 200);
    }

    public function store(Request $request, $deviceId)
    {
        $device = Device::find($deviceId);
        if (!$device) {
            return response()->json(['message' => 'Device not found'], 404);
        }

        $request->validate([
            'operation' => 'required|string',
            'description' => 'required|string',
            'command' => 'required|string',
            'result' => 'required|string',
            'format' => 'required|json',
        ]);

        $command = Command::create([
            'device_id' => $device->id,
            'operation' => $request->operation,
            'description' => $request->description,
            'command' => $request->command,
            'result' => $request->result,
            'format' => $request->format,
        ]);

        return response()->json($command, 201);
    }

    public function update(Request $request, $deviceId, $commandId)
    {
        $command = Command::where('device_id', $deviceId)->where('id', $commandId)->first();
        if (!$command) {
            return response()->json(['message' => 'Command not found'], 404);
        }

        $command->update($request->all());

        return response()->json($command, 200);
    }

    public function destroy($deviceId, $commandId)
    {
        $command = Command::where('device_id', $deviceId)->where('id', $commandId)->first();
        if (!$command) {
            return response()->json(['message' => 'Command not found'], 404);
        }

        $command->delete();

        return response()->json(['message' => 'Command deleted successfully'], 200);
    }
}
