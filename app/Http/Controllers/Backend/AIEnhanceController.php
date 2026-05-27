<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AIEnhanceController extends Controller
{
    public function enhance(Request $request)
    {
        $request->validate([
            'images' => 'required|array',
            'is_pro' => 'required|boolean'
        ]);

        $images = $request->input('images');
        $isPro = $request->input('is_pro');

        $inputData = json_encode([
            'images' => $images,
            'is_pro' => $isPro
        ]);

        $scriptPath = storage_path('app/scripts/ai_enhancer.py');
        
        // Escape the input for shell safely
        // Since input can be large (base64 images), passing via stdin is necessary
        $descriptorSpec = [
            0 => ["pipe", "r"],  // stdin
            1 => ["pipe", "w"],  // stdout
            2 => ["pipe", "w"]   // stderr
        ];

        // Run python script
        $process = proc_open("python \"{$scriptPath}\"", $descriptorSpec, $pipes);

        if (is_resource($process)) {
            // Write JSON input to stdin
            fwrite($pipes[0], $inputData);
            fclose($pipes[0]);

            // Read JSON output from stdout
            $output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            // Read errors
            $error = stream_get_contents($pipes[2]);
            fclose($pipes[2]);

            $returnValue = proc_close($process);

            if ($returnValue === 0) {
                $result = json_decode($output, true);
                if (isset($result['success']) && $result['success']) {
                    return response()->json([
                        'success' => true,
                        'images' => $result['images']
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'AI Enhancer failed',
                'error' => $error,
                'output' => $output
            ], 500);
        }

        return response()->json([
            'success' => false,
            'message' => 'Could not open process'
        ], 500);
    }
}
