<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\S3\S3Client;  
use Aws\Exception\AwsException;
use Illuminate\Support\Facades\Storage;

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
            ['starts-with', '$key', $request->path],
        ];

        $expires = '+2 hours';

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
            'path' => $request->path,
            'attributes' => $formAttributes,
            'inputs' => $formInputs
        ];
    }
}