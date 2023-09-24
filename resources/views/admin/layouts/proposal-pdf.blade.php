@if($layout)
    <!doctype html>
<html lang="en">
<head>
    <title>{{ $title or 'Gus Product online - SSS' }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
<div class="container-fluid">
    @endif
    @yield('content')
    @if($layout)
</div>

@yield('script')
</body>
</html>
@endif
