<div class="head">
    <h1><?= $data['title'] ?></h1>
</div>
<?php
var_dump($data);
?>
<form action="<?= URLROOT ?>register/update" method="post">
    <div class="form register">

        <div class="name">
            <div class="required firstname">
                <input type="text" name="firstname" placeholder="Firstname" maxlength="50" value="<?= $data['firstname'] ?>">
            </div>
            <div class="infix">
                <input type="text" name="infix" placeholder="Infix" maxlength="20" value="<?= $data['infix'] ?> ">
            </div>
            <div class="required">
                <input type="text" name="lastname" placeholder="Lastname" maxlength="50" value="<?= $data['lastname'] ?>">
            </div>
        </div>

        <div class="col required">
            <input type="text" name="username" placeholder="Username" maxlength="50" value="<?= $data['username'] ?>">
        </div>
        <div class="required">
            <input type="text" name="email" placeholder="Email" maxlength="50" value="<?= $data['email'] ?>">
        </div>
        <div class="required">
            <input type="text" name="mobile" placeholder="Phone number" maxlength="15" value="<?= $data['mobile'] ?>">
        </div>


        <div class="buttons">

            <div class="button to-update">
                <button type="submit">Update Your data</button>

                <!-- <a class="link-empty submit" href="<?= URLROOT; ?>register/update">Login</a> -->
            </div>
        </div>
    </div>
</form>

<a href="<?= URLROOT ?>register/delete">delete</a>