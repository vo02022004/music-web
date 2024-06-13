<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="/api/users" method="post" enctype="multipart/form-data">
        <label for="email">Email</label>
        <input type="text" name="email">
        <label for="password">Password</label>
        <input type="text" name="password">
        <label for="name">Name</label>
        <input type="text" name="name">

        <label for="gender">Gender</label>
        <input type="text" name="gender">



        <label for="avatar">Avatar</label>
        <input type="file" name="avatar">
        <input type="submit" value="add">
    </form>
</body>

</html>