<?php if (isset($_GET['tag_id']) && isset($_GET['parent_id']) ) { ?>

<?php
$id = $_GET['tag_id'];
$parent_id = $_GET['parent_id'];
if ($current_page > 3) {
    $first_page = 1;
?>
    <a style="border: 1px solid #000; padding: 10px; text-decoration: none;" href="?<?= $param ?>tag_id=<?= $id ?>&parent_id=<?=$parent_id?>&per_page=<?= $item_per_page ?>&page=<?= $first_page ?>">First</a>
<?php }
if ($current_page > 1) {
    $prev_page = $current_page - 1;
?>
    <a style="border: 1px solid #000; padding: 10px; text-decoration: none;" href="?<?= $param ?>tag_id=<?= $id ?>&parent_id=<?=$parent_id?>&per_page=<?= $item_per_page ?>&page=<?= $prev_page ?>">Prev</a>
<?php }
?>

<?php for ($num = 1; $num <= $totalPages; $num++) { ?>
    <?php if ($num != $current_page) { ?>
        <?php if ($num > $current_page - 3 && $num < $current_page + 3) { ?>
            <a style="border: 1px solid #000; padding: 10px; text-decoration: none;" href="?<?= $param ?>tag_id=<?= $id ?>&parent_id=<?=$parent_id?>&per_page=<?= $item_per_page ?>&page=<?= $num ?>"><?= $num ?></a>
        <?php  } ?>
    <?php  } else { ?>
        <strong style="background-color:#000; border: 1px solid #000; padding: 10px; text-decoration: none; color:#fff;"><?= $num ?></strong>
    <?php  } ?>
<?php }
?>
<?php
if ($current_page < $totalPages - 1) {
    $next_page = $current_page + 1;
?>
    <a style="border: 1px solid #000; padding: 10px; text-decoration: none;" href="?<?= $param ?>tag_id=<?= $id ?>&parent_id=<?=$parent_id?>&per_page=<?= $item_per_page ?>&page=<?= $next_page ?>">Next</a>
<?php }
?>
<?php
if ($current_page < $totalPages - 3) {
    $end_page = $totalPages;
?>
    <a style="border: 1px solid #000; padding: 10px; text-decoration: none;" href="?<?= $param ?>tag_id=<?= $id ?>&parent_id=<?=$parent_id?>&per_page=<?= $item_per_page ?>&page=<?= $end_page ?>">Last</a>
<?php } }
?>

 