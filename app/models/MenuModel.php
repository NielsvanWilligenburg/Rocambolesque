<?php

class MenuModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getMenuAppetizers()
    {
        $menuSql = "SELECT  Dishes.Name,
                            Dishes.Ingredients,
                            Dishes.Category,
                            Dishes.Course
                            
                            
                            FROM        Menudishes
                            INNER JOIN  Dishes
                            ON          Menudishes.DishId = Dishes.Id
                            WHERE Dishes.Course = 'Appetizer' and Menudishes.MenuId = '1'
                            ORDER BY Dishes.Id DESC;";
        $this->db->query($menuSql);
        $result = $this->db->resultSet();
        return $result;
    }

    public function getMenuMain()
    {
        $menuSql = "SELECT  Dishes.Name,
                            Dishes.Ingredients,
                            Dishes.Category,
                            Dishes.Course
                            
                            
                            FROM        Menudishes
                            INNER JOIN  Dishes
                            ON          Menudishes.DishId = Dishes.Id
                            WHERE Dishes.Course = 'Main' and Menudishes.MenuId = '1'
                            ORDER BY Dishes.Id DESC;";
        $this->db->query($menuSql);
        $result = $this->db->resultSet();
        return $result;
    }

    public function getMenuDessert()
    {
        $menuSql = "SELECT  Dishes.Name,
                            Dishes.Ingredients,
                            Dishes.Category,
                            Dishes.Course
                            
                            
                            FROM        Menudishes
                            INNER JOIN  Dishes
                            ON          Menudishes.DishId = Dishes.Id
                            WHERE Dishes.Course = 'Dessert' and Menudishes.MenuId = '1'
                            ORDER BY Dishes.Id DESC;";
        $this->db->query($menuSql);
        $result = $this->db->resultSet();
        return $result;
    }



    public function findMenuById($id)
    {
        $this->db->query("Select dis.Name, dis.Ingredients, dis.Category, dis.Course, from dishes as dis
						  where dis.Id = :id");
        $this->db->bind(":id", $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    public function updateMenu($post)
    {

        var_dump($post);
        try {
            $this->db->query("update menudishes as men, dishes as dis
									    set dis.Name = :name,
									    dis.Ingredients = :ingredients,
									    dis.Category = :category,
									    dis.Course = :course,
									    men.DishId = :dishId
								        where men.DishId = dis.Id
									    and men.Id = :id");
            $this->db->bind(':name', $post['name'], PDO::PARAM_STR);
            $this->db->bind(':ingredients', $post['ingredients'], PDO::PARAM_STR);
            $this->db->bind(':category', $post['category'], PDO::PARAM_STR);
            $this->db->bind(':course', $post['course'], PDO::PARAM_STR);
            $this->db->bind(':dishId', $post['dishId'], PDO::PARAM_INT);
            $this->db->bind(':id', 2, PDO::PARAM_INT);
            return $this->db->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
