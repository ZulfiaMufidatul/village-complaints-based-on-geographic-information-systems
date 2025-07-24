<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    Test
    @foreach ($data as $index => $item)
    <div style="display: flex; flex-direction: column">
         {{ $index + 1 }}. id:{{ $item->id }} {{ $item->description }} 

    </div>
    @endforeach
</body>
</html>