<?php
    include('../conn.php');
    include('../modules/header.php');
?>
<body>
    <div id="post-view-container">
    <?php 
        if(isset($_GET["post_id"])){
            $post_id = $_GET["post_id"];
            $post_sl = "SELECT * From `posts` where post_id=".$post_id;
            $post_rsl = mysqli_query($connect,$post_sl);
        while($row = mysqli_fetch_array($post_rsl)){ ?>     
        <h1><?=$row['post_title']?></h1>
        <h3><?=$row['post_description']?></h3>
        <span><?=$row['post_createdTime']?></span>
        <span><?=$row['post_author']?></span>
        <div class="content-post-view">
            <p><?=$row['post_content']?></p>
        </div>
    <?php }}     
    ?>
    </div>
</body>
<?php
    include('../modules/footer.php');
?>