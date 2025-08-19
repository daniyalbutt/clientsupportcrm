<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>{{ $data['Form_Name'] }}</title>
</head>
<body>
    @foreach ($data as $key => $value)
        @if($value != null)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ str_replace('_', ' ', $key)}}</h5>
                <p class="card-text">{{ $value }}</p>
            </div>
        </div>
        @endif
    @endforeach 
</body>
</html>