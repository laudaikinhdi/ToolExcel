<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Excel - Json</title>
</head>
<body>
    <div style="display: flex;justify-content: center;">
        <div>
            <h3 style="text-align: center;">Export - Json</h3>
            <form action="/" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="file" name="file_import">
                <hr>
                <div style="text-align: center;">
                    <button style="padding: 7px;border-radius: 10px;">Export Json</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>