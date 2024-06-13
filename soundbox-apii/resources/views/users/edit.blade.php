<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="{{route('users.update', $user->id)}}" method="post" enctype="multipart/form-data">
        @method('PUT')
        <label for="old_password">Old password</label>
        <input type="text" name="old_password">
        <label for="file">New password</label>
        <input type="new_password" name="new_password">
        <input type="submit">


    </form>
</body>

</html>