<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvFileRequest;
use App\Jobs\ProcessingParseCsvJob;
use App\Services\ParseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function uploadFile(CsvFileRequest $request)
    {
        $file = $request->file('csv_file');
        $fileName = time().'.'.$file->getClientOriginalExtension();
        $file->storeAs('files', $fileName);
        Storage::disk('local')->put($file, 'File content goes here..');
        $file = Storage::disk('local')->path('files/' . $fileName);


//        ProcessingParseCsvJob::dispatch($file);
        Cache::put('processing', true);

        return response()->json([
            'success' => true,
            'message' => 'File uploaded successfully.',
            'processing_parse' => Cache::get('processing')
        ], 200);
    }

    public function createTestCsv(ParseService $parseService)
    {
        $source = Storage::disk('local')->path('files/1596101852.csv');
        $destination = Storage::disk('local')->path('files/test2.csv');
        $parseService->sliceAndStore($source, $destination, 2000, 0);
    }

    public function parse(ParseService $parseService)
    {
        $file = Storage::disk('local')->path('files/test.csv');
//        $file = Storage::disk('local')->path('files/test.csv');
        $parseService->parseCSV($file);
    }
}
