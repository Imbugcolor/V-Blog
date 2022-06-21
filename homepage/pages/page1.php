<?php
    include('../conn.php');
    include('../modules/header.php');
?>
<body>
    <div id="page-view-container" class="pd-l-50 pd-r-50">        
        <div id="about-menu-list-post">
        <?php
        if(isset($_GET["tag_id"]) && isset($_GET["parent_id"])){
        $tag_id = $_GET["tag_id"];
        $parent = $_GET["parent_id"];    
        $allpost_tag = "SELECT * from `tag` WHERE tag_id =".$tag_id;
        $rslApt = mysqli_query($connect,$allpost_tag);
        while($tag = mysqli_fetch_array($rslApt)){ ?>
            <div class="menu-tag">
                <h4 class="name">
                    <?=$tag['tag_name']?>
                </h4>
            </div>
            <div class="about-tag">
                <p class="about">
                <?=$tag['tag_description']?>
                </p>
            </div>
        <?php } }?>
        </div>
        <div id="all-post-list-menu">
            <div class="row mg-t-25">
                <div class="all-post-wrapper col-9 col-md-7 col-sm-12">
                        <?php 
                            if(isset($_GET["tag_id"]) && isset($_GET["parent_id"])){
                            $tag_id = $_GET["tag_id"];
                            $parent = $_GET["parent_id"];
                            if($parent == 0){      
                                $allpost_tag = "SELECT * from `posts` WHERE parent_id =".$tag_id;
                                $rslApt = mysqli_query($connect,$allpost_tag);
                                $row = mysqli_num_rows($rslApt);
                            } else{
                                $allpost_tag = "SELECT * from `posts`,`tag` WHERE `posts`.tag_id=`tag`.tag_id and `posts`.tag_id =".$tag_id;
                                $rslApt = mysqli_query($connect,$allpost_tag);
                            }
                            while($row = mysqli_fetch_array($rslApt)){ ?>
                                <div class="item-all-post">
                                    <div class="row mg-t-25">
                                        <div class="thumb-item-all-post col-4 col-md-12 col-sm-12">
                                            <a href="post.php?post_id=<?=$row['post_id']?>">
                                            <img src="../assets/image/<?=$row["post_thumbnail"]?>" alt="" class="image-item-all-post">
                                            </a>
                                        </div>
                                        <div class="about-item-all-post col-8 col-md-12 col-sm-12">
                                            <div class="title-item-all-post">
                                                <a href="post.php?post_id=<?=$row['post_id']?>">
                                                <p><?=$row['post_title']?></p>
                                                </a>
                                            </div>
                                            <div class="author-item-all-post">
                                                <span><?=$row['post_author']?></span>
                                            </div>
                                            <div class="time-create-item-all-post">
                                                <span><?=$row['post_createdTime']?></span>
                                            </div>
                                            <div class="about-cont-item-all-post">
                                                <p><?=$row['post_description']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                                <?php }} ?> 
                </div>
                        
                <div class="relate-posts mg-t-25 col-3 col-md-5 col-sm-12">
                    <div class="relate-posts-wrapper">
                        <h3 class="name-side-list">
                            Bài viết liên quan
                        </h3>
                        <div class="list-post-other-wrapper">
                        <?php
                            if(isset($_GET["tag_id"]) && isset($_GET["parent_id"])){
                                $tag_id = $_GET["tag_id"];
                                $parent = $_GET["parent_id"];
                                if($parent==0){    
                                    $allpost_tag = "SELECT * from `posts` WHERE `posts`.parent_id != '$tag_id' ORDER BY RAND() LIMIT 3";
                                    $rsl_rlt = mysqli_query($connect,$allpost_tag);
                                } else{
                                    $allpost_tag = "SELECT * from `posts` WHERE `posts`.parent_id !='$parent'  ORDER BY RAND() LIMIT 3";
                                    $rsl_rlt = mysqli_query($connect,$allpost_tag);
                                }
                            while($row_rlt = mysqli_fetch_array($rsl_rlt)){ ?>
                            <div class="row post-border-item mg-t-25">                    
                                <div class="other-thumb-post col-4 col-sm-12 ">
                                    <a href="post.php?post_id=<?=$row_rlt['post_id']?>">
                                    <img src="../assets/image/<?=$row_rlt['post_thumbnail']?>" alt="">
                                    </a>
                                </div>
                                <div class="other-d-post col-8 col-sm-12">
                                    <a href="post.php?post_id=<?=$row_rlt['post_id']?>" class="other-title-post">
                                    <?=$row_rlt['post_title']?>
                                    </a>
                                    <div class="time-create-other-post">                   
                                        <span class="time-post">
                                        <?=$row_rlt['post_createdTime']?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php }} ?>
                        </div>
                    </div>
                    <div class="feature-posts-wrapper mg-t-25">
                        <h3 class="name-side-list">
                            Bài viết nổi bật
                        </h3>
                        <div class="list-post-other-wrapper">
                            <div class="row post-border-item mg-t-25">                   
                                <div class="thumb-feature-post col-12">
                                    <a href="">
                                    <img src="../assets/image/1655336449236-toptip-top-5-trang-web-hoc-online-co-cap-chung-chi-mien-phi-ma-ban-khong-nen-bo-qua-.png" alt="">
                                    </a>
                                </div>
                                <div class="aubout-feature-post title-post-item col-12">
                                    <a href="" class="tag-post">@Thủ thuật</a>
                                    <a href="">
                                    [TopTip] Top 5 Trang Web Học Online Có Cấp Chứng Chỉ Miễn Phí Mà Bạn Không Nên Bỏ Qua
                                    </a>
                                    <div class="create-by-feature-post">
                                        <span class="author">Đinh Hoàng Việt</span> -
                                        <span class="time-create-post">1 ngày trước</span>
                                    </div> 
                                </div>
                            </div>
                            <div class="row post-border-item mg-t-25">                   
                                <div class="thumb-feature-post col-12">
                                    <a href="">
                                    <img src="../assets/image/1655336449236-toptip-top-5-trang-web-hoc-online-co-cap-chung-chi-mien-phi-ma-ban-khong-nen-bo-qua-.png" alt="">
                                    </a>
                                </div>
                                <div class="aubout-feature-post title-post-item col-12">
                                    <a href="" class="tag-post">@Thủ thuật</a>
                                    <a href="">
                                    [TopTip] Top 5 Trang Web Học Online Có Cấp Chứng Chỉ Miễn Phí Mà Bạn Không Nên Bỏ Qua
                                    </a>
                                    <div class="create-by-feature-post">
                                        <span class="author">Đinh Hoàng Việt</span> -
                                        <span class="time-create-post">1 ngày trước</span>
                                    </div> 
                                </div>
                            </div>
                            <div class="row post-border-item mg-t-25">                   
                                <div class="thumb-feature-post col-12">
                                    <a href="">
                                    <img src="../assets/image/1655336449236-toptip-top-5-trang-web-hoc-online-co-cap-chung-chi-mien-phi-ma-ban-khong-nen-bo-qua-.png" alt="">
                                    </a>
                                </div>
                                <div class="aubout-feature-post title-post-item col-12">
                                    <a href="" class="tag-post">@Thủ thuật</a>
                                    <a href="">
                                    [TopTip] Top 5 Trang Web Học Online Có Cấp Chứng Chỉ Miễn Phí Mà Bạn Không Nên Bỏ Qua
                                    </a>
                                    <div class="create-by-feature-post">
                                        <span class="author">Đinh Hoàng Việt</span> -
                                        <span class="time-create-post">1 ngày trước</span>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    include('../modules/footer.php');
?>