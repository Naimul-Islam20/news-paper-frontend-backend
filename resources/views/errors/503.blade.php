<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
</head>
<body style="text-align:center; margin-top:100px;">
    <h1>🚧 Site Under Maintenance</h1>
    @if (! empty($message))
        <p>{{ $message }}</p>
    @else
        <p>We are currently updating the system. Please come back later.</p>
    @endif
</body>
</html>
