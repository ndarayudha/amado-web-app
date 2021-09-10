<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
</head>

<body>

    <h1>Home</h1>

    <script src="{{ asset('/js/app.js') }}"></script>
    <script>
        window.Echo.channel('patient-registered-channel')
            .listen('.PatientRegisteredEvent', e => {
                console.log(e)
            })
    </script>

</body>

</html>
