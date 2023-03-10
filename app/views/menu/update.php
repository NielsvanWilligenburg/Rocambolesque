<h1><?= $data['title'] ?></h1>

<form action="<?= URLROOT ?>menu/update" method="post">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?= $data['name'] ?>">

    <label for="Ingredients">Ingredients:</label>
    <input type="text" name="ingredients" id="ingredients" value="<?= $data['ingredients'] ?>">

    <label for="Category">Category:</label>
    <input type="text" name="category" id="category" value="<?= $data['category'] ?>">

    <label for="Course">Course:</label>
    <input type="text" name="course" id="course" value="<?= $data['course'] ?>">

    <label for="DishId">Dish Id:</label>
    <input type="text" name="dishId" id="dishId" value="<?= $data['dishId'] ?>">

    <button type="submit">Update the Menu</button>

</form>