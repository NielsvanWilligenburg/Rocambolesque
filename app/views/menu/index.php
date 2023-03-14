<img src="../../../public/images//Menu_Test_Photos/Test_Photo_1.jpg" alt="Restaurant" class="Menu_Photo_Test">


<body>
    <div id="MenuBoxDiv">
        <h3>Our Story</h3>
        <div class="Box1">
            <div class="Box2"></div>
        </div>
    </div>

    <h3>Appetizers</h3>
    <tr>
        <?= $data['appetizer'] ?>
    </tr>
    <br>
    <h3>Main</h3>
    <tr>
        <?= $data['main'] ?>
    </tr>
    <br>
    <h3>Dessert</h3>
    <tr>
        <?= $data['dessert'] ?>
    </tr>

    <div id="Menu_Items">
        <div class="Appetizers">
            <h2 class="Menu_Items_h2"><?= $data["title"]; ?></h2>
            <div>
                <img src="../../../public/images/Menu_Test_Photos/Appetizer_Photo_1.jpg" alt="Franse Uiensoep" class="AppetizerImg">


            </div>
        </div>

        <div class="Main">

        </div>

        <div class="Dessert">

        </div>
    </div>
</body>