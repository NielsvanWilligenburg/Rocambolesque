<h1><?= $data['title']?></h1>

<form action="<?=URLROOT?>user/update" method="post">
    <label for="firstname">Firstname:</label>
    <input type="text" name="firstname" id="firstname" value="<?=$data['firstname']?>">

    <label for="infix">Infix:</label>
    <input type="text" name="infix" id="infix" value="<?=$data['infix']?>">

    <label for="lastname">Lastname:</label>
    <input type="text" name="lastname" id="lastname" value="<?=$data['lastname']?>">

    <label for="username">Username:</label>
    <input type="text" name="username" id="username" value="<?=$data['username']?>">

    <label for="email">Email:</label>
    <input type="text" name="email" id="email" value="<?=$data['email']?>">

    <label for="phoneNumber">Phone number:</label>
    <input type="text" name="phoneNumber" id="phoneNumber" value="<?=$data['mobile']?>">

    <button type="submit">Update Your data</button>

</form>

<a href="<?=URLROOT?>user/delete">delete</a>