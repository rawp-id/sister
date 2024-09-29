<?php

namespace App\Http\Controllers;

use CURLFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function store(Request $request)
    {
        // Get the uploaded file
        $file = $request->file('file');
        $fileName = time();

        // Read the file content and encode it in base64
        $fileContent = file_get_contents($file);
        $base64Data = base64_encode($fileContent);

        // Prepare data for Google Apps Script
        $postData = [
            'filename' => $fileName,
            'file' => $base64Data,
            'folderid' => $request->folderid
        ];

        // dd($postData);

        try {
            // Send POST request to Google Apps Script
            $response = Http::asForm()->post('https://script.google.com/macros/s/AKfycbzPkHY9ygQJTZYIh3TFB-vplIh1U1ZpIUW723v07wK3iVfByJT1kRy9XxEzGREW3_C_cw/exec', $postData);

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['result' => 'Error: ' . $e->getMessage()], 500);
        }
    }



}
