<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sample</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container">
        <div class="row mb-2">
            <div class="col">
                <form method="POST" action="/sample/submit" id="sample-form">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputName" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name-input">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="check" class="form-check-input" id="check-input">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" id="file-input">
                    </div>
                    <input type="hidden" name="file-path" id="file-path">
                    <button type="submit" class="btn btn-primary" id="submit-button">Submit</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div id="form-progress" class="progress d-none" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                    <div id="form-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%;"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>