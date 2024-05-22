<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Device;
use App\Services\TelnetService;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    protected $telnetService;

    public function __construct(TelnetService $telnetService)
    {
        $this->telnetService = $telnetService;
    }

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

    public function executeCommand(Request $request, $deviceId, $commandId)
    {
        $command = Command::where('device_id', $deviceId)->where('id', $commandId)->first();
        if (!$command) {
            return response()->json(['message' => 'Command not found'], 404);
        }

        $device = Device::find($deviceId);
        if (!$device) {
            return response()->json(['message' => 'Device not found'], 404);
        }

        $hostname = $device->hostname;
        $port = $device->port ?? 23; // Porta padrão Telnet é 23
        $username = $device->username;
        $password = $device->password;

        $telnetService = new TelnetService($hostname, $port, $username, $password);
        $response = $telnetService->sendCommand($command->command);

        return response()->json([
            'command' => $command->command,
            'response' => $response,
        ]);
    }
}
