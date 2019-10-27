<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/phpecommerce/core/init.php';
    $parentId = (int)$_POST['parentId'];
    $selected = checkInput($_POST['selected']);
    $childQuery =$db->query("SELECT * FROM categories WHERE parent = '$parentId' ORDER BY category ");
    ob_start();?>
    <option value=""></option>
    <?php while($child = mysqli_fetch_assoc($childQuery) ): ?>
    <option value="<?= $child['id']; ?>" <?=(($selected==$child['id'])?' selected':''); ?>>
    <?= $child['category']; ?></option>
    <?php endwhile?>
    <?php echo ob_get_clean() ?>