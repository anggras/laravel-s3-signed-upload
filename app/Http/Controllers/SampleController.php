<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\S3\S3Client;  
use Aws\Exception\AwsException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SampleController extends Controller
{
    public function view(Request $request) {
        return view('sample');
    }

    public function submit(Request $request) {
        $input = $request->all();

        // Check if file exists
        if (!Storage::exists($input['file-path'])) {
            return 'File not uploaded';
        }

        // Do whatever else needed with the input data

        return $input;
    }

    public function signedurlforpost(Request $request) {
        
        $originalFileName = $request->filename;
        $extension = explode(".", $originalFileName);
        $extension = count($extension) > 1 ? "." . end($extension) : "";

        // The 'folder' to upload the file to in S3
        $prefixPath = "upload/folder/";

        // Determine the file path to upload to
        // Use UUID for stored filename in S3 to ensure minimum chance of 
        // overwrite
        $filename = (string) Str::uuid();
        $fullFilePath = $prefixPath . $filename . $extension;
        
        // A check to determine if a file already exist can be done here

        // Generate S3 Client
        $client = new S3Client([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
        ]);

        $bucket = env('AWS_BUCKET');

        $formInputs = [
        ];

        // Construct an array of conditions for policy
        $options = [
            ['bucket' => $bucket],
            ['starts-with', '$key', $fullFilePath],
        ];

        $expires = '+5 minutes';

        $postObject = new \Aws\S3\PostObjectV4(
            $client,
            $bucket,
            $formInputs,
            $options,
            $expires
        );

        $formAttributes = $postObject->getFormAttributes();

        $formInputs = $postObject->getFormInputs();

        return [
            'path' => $fullFilePath,
            'attributes' => $formAttributes,
            'inputs' => $formInputs
        ];
    }
}