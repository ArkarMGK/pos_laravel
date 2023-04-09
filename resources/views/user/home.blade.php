<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>User Home Page</h2>
    Role - {{Auth::user()->role}}

    <form action="{{ route('logout')}}" method="post">
        @csrf
        <button>Logout</button>
    </form>
</body>
</html>
