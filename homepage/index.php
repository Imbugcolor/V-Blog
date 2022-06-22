<?php
    ob_start();
    include("conn.php");
    $res=mysqli_query($connect,"select * from tag"); 
    $arr=[];
    while($row=mysqli_fetch_assoc($res)){
        $arr[$row['tag_id']]['tag_name']=$row['tag_name'];
        $arr[$row['tag_id']]['parent_id']=$row['parent_id'];
    }
    $html='';
    function buildTreeView($arr,$parent,$level=0,$prelevel= -1){
        global $html;
        foreach($arr as $id=>$data){
            if($parent==$data['parent_id']){
                if($level>$prelevel){
                    if($html==''){
                        $html.='<ul class="nav navbar-nav"><li><a href="index.php">Home</a>';                      
                    }else{
                        $html.='<ul class="dropdown-menu">';
                    }
                    
                }
                if($level==$prelevel){
                    $html.='</li>';
                }
                $html.='<li><a href="./pages/page1.php?tag_id='.$id.'&parent_id='.$parent.'">'.$data['tag_name'].' <span class="caret"></span></a>';
                if($level>$prelevel){
                    $prelevel=$level;
                }
                $level++;
                buildTreeView($arr,$id,$level,$prelevel);
                $level--;
            }
        }
        if($level==$prelevel){
            $html.='</li></ul>';
        }
        return $html;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!--bootstrap jquery file link-->
    <link href="./assets/bootstrap.css" rel="stylesheet">
    <link href="./assets/jquery.smartmenus.bootstrap.css" rel="stylesheet">
    <link id="switcher" href="./assets/theme-color/default-theme.css" rel="stylesheet">
    <!--css,grid file link-->
    <link rel="stylesheet" href="./assets/style.css">
    <link rel="stylesheet" href="./assets/grid.css">
    <!--slick slider css jquery cdn-->
    <link rel="stylesheet" href="./assets/slick/slick.css">
    <link rel="stylesheet" href="./assets/slick/slick-theme.css">
    <title>Blog IT</title>
</head>
<body>
    <div id="banner" class="pd-l-50 pd-r-50">
        <a href="#">V-BLOG</a>
    </div>
    <section id="menu">
         <div class="container">
            <div class="menu-area">
               <!-- Navbar -->
               <div class="navbar navbar-default" role="navigation">
                  <div class="navbar-header">
                     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                     <span class="sr-only">Toggle navigation</span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     </button>          
                  </div>
                  <div class="navbar-collapse collapse">                                
                     <?php 
					 echo buildTreeView($arr,0);
					 ?>            
                  </div>
                  <!--/.nav-collapse -->
                </div>
                <div class="search-icon" onclick="toggleText()">             
                    <span><i class="fas fa-search"></i></span>
                </div>
                <div id="search" style="display: none;">
                    <form class="wrapper" method="GET" action="">
                    <?php 
                        $param = "";
                    //Tim kiem
                        $search = isset($_GET['post_name']) ? $_GET['post_name'] : "";
                        if ($search) {               
                            $where = "AND `title` LIKE '%" . $search . "%'";
                            $param .= "post_name=" . $search . "&";
                            header("location: ./pages/page1.php?".$param);
                            // $sortParam = "post-name=" . $search . "&";
                        }
                    ?>
                    <input type="text" class="search-input" placeholder="Tìm kiếm bài viết" name="post_name" value="<?= isset($_GET['post_name']) ? $_GET['post_name'] : ""; ?>">
                    <!-- <input type="submit" class="search-btn" value="Tìm kiếm"><i class="fas fa-search"></i> -->
                    <input type="submit" class="search-btn" value="Tìm kiếm">
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.js"></script>  
    <script type="text/javascript" src="./assets/js/jquery.smartmenus.js"></script>
    <script type="text/javascript" src="./assets/js/jquery.smartmenus.bootstrap.js"></script>  
    <div id="new-post-section" class="pd-l-50 pd-r-50">
        <div class="new-post-wrapper">
            <div class="row">
                <div class="new-post col-8 col-md-12 col-sm-12">
                    <?php 
                        //newest post query
                        $newest_sl = "SELECT * FROM `posts`,`tag` WHERE `posts`.parent_id = `tag`.parent_id ORDER BY post_createdTime DESC LIMIT 1";
                        $newest_rsl = mysqli_query($connect,$newest_sl);
                        while($rec = mysqli_fetch_array($newest_rsl)){
                    ?>
                    <div class="main-new-post col-12">
                        <a href="./pages/post.php?post_id=<?=$rec['post_id']?>">
                            <div class="thumb-post">  
                                <img src="./assets/image/<?=$rec['post_thumbnail']?>" alt="">
                            </div>
                            <div class="highlight_layer">
                                    
                            </div> 
                            <div class="highlight_content">
                                <div class="d-post">
                                    <div class="d-cat">
                                        <span></span>
                                    </div>
                                    <p class="title-post"><?=$rec['post_title']?></p>
                                    <p class="tag-post"><?=$rec['tag_name']?></p>
                                    <span class="author"><?=$rec['post_author']?></span>
                                    <span class="time-post"> <?=$rec['post_createdTime']?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                    <div class="other-new-post slick-slider row">
                        <?php 
                            //newest post query
                            $newest_sl = "SELECT * FROM `posts` ORDER BY post_createdTime DESC LIMIT 1,4";
                            $newest_rsl = mysqli_query($connect,$newest_sl);
                            while($rec = mysqli_fetch_array($newest_rsl)){
                        ?>
                        <div class="item-post col-4 col-md-6 col-sm-12">
                            <div class="thumb-post">
                                <a href="./pages/post.php?post_id=<?=$rec['post_id']?>">
                                    <img src="./assets/image/<?=$rec['post_thumbnail']?>" alt="">
                                </a>
                            </div>
                            <div class="d-post">
                                <a href="./pages/post.php?post_id=<?=$rec['post_id']?>" class="title-post line-clamp-2">
                                    <?=$rec['post_title']?>
                                </a>
                                <p class="cont-post"><?=$rec['post_description']?></p>
                            </div>
                            <div class="createby">
                                <div class="author">
                                    <span>
                                        <?=$rec['post_author']?>
                                    </span>
                                </div>
  
                                <span class="time-post">
                                    <?=$rec['post_createdTime']?>
                                </span>
                            </div>
                        </div>
                        <?php } ?>                      
                    </div>                 
                </div>
                <div class="other-post col-4 col-md-6 col-sm-12">
                    <h3 class="name-side-list">Bài viết khác</h3>
                    <?php 
                        //newest post query
                        $newest_sl = "SELECT * FROM `posts` ORDER BY post_createdTime DESC LIMIT 5,4";
                        $newest_rsl = mysqli_query($connect,$newest_sl);
                        while($rec = mysqli_fetch_array($newest_rsl)){
                    ?>
                    <div class="list-post-other-wrapper row">
                        <div class="other-thumb-post col-4">
                            <a href="./pages/post.php?post_id=<?=$rec['post_id']?>">
                                <img src="./assets/image/<?=$rec['post_thumbnail']?>" alt="">
                            </a>
                        </div>
                        <div class="other-d-post col-8">
                            <a href="./pages/post.php?post_id=<?=$rec['post_id']?>" class="other-title-post">
                                <?=$rec['post_title']?>
                            </a>
                            <div class="time-create-other-post">                   
                                <span class="time-post">
                                    <?=$rec['post_createdTime']?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div id="section-post-2" class="pd-l-50 pd-r-50">
        <div id="list-post-wrapper" class="pd-l-15 pd-r-15">
            <h3 class="tag-title">
                Blog-Website
            </h3>
            <div class="list-post">
                <div class="row">
                    <div class="post-item col-3 col-md-6 col-sm-12">
                        <div class="thumb-post-item">
                            <a href="">
                                <img src="./assets/image/khuyen-mai-momo.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-post-item">
                            <a href="">Mua theme Newspaper: Theme hàng đầu cho các Bloger giá siêu rẻ – chỉ 250.000VND </a>
                        </div>
                        <div class="author-post-item">
                            <span>Nguyễn Văn A</span>
                        </div>
                        <div class="time-post-item">                      
                            <span>14/06/2022</span>
                        </div>
                    </div>
                    <div class="post-item col-3 col-md-6 col-sm-12">
                        <div class="thumb-post-item">
                            <a href="">
                                <img src="./assets/image/khuyen-mai-momo.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-post-item">
                            <a href="">Mua theme Newspaper: Theme hàng đầu cho các Bloger giá siêu rẻ – chỉ 250.000VND </a>
                        </div>
                        <div class="author-post-item">
                            <span>Nguyễn Văn A</span>
                        </div>
                        <div class="time-post-item">                      
                            <span>14/06/2022</span>
                        </div>
                    </div>
                    <div class="post-item col-3 col-md-6 col-sm-12">
                        <div class="thumb-post-item">
                            <a href="">
                                <img src="./assets/image/khuyen-mai-momo.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-post-item">
                            <a href="">Mua theme Newspaper: Theme hàng đầu cho các Bloger giá siêu rẻ – chỉ 250.000VND </a>
                        </div>
                        <div class="author-post-item">
                            <span>Nguyễn Văn A</span>
                        </div>
                        <div class="time-post-item">                      
                            <span>14/06/2022</span>
                        </div>
                    </div>
                    <div class="post-item col-3 col-md-6 col-sm-12">
                        <div class="thumb-post-item">
                            <a href="">
                                <img src="./assets/image/khuyen-mai-momo.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-post-item">
                            <a href="">Mua theme Newspaper: Theme hàng đầu cho các Bloger giá siêu rẻ – chỉ 250.000VND </a>
                        </div>
                        <div class="author-post-item">
                            <span>Nguyễn Văn A</span>
                        </div>
                        <div class="time-post-item">                      
                            <span>14/06/2022</span>
                        </div>
                    </div>
                    <div class="post-item col-3 col-md-6 col-sm-12">
                        <div class="thumb-post-item">
                            <a href="">
                                <img src="./assets/image/khuyen-mai-momo.jpg" alt="">
                            </a>
                        </div>
                        <div class="title-post-item">
                            <a href="">Mua theme Newspaper: Theme hàng đầu cho các Bloger giá siêu rẻ – chỉ 250.000VND </a>
                        </div>
                        <div class="author-post-item">
                            <span>Nguyễn Văn A</span>
                        </div>
                        <div class="time-post-item">                      
                            <span>14/06/2022</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="./assets/slick/slick.min.js"></script>
<script>
    // When the user scrolls the page, execute myFunction
    window.onscroll = function() {myFunction()};

    // Get the navbar
    var navbar = document.getElementById("menu");

    // Get the offset position of the navbar
    var sticky = navbar.offsetTop;

    // Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
    function myFunction() {
    if (window.pageYOffset >= sticky) {
        navbar.classList.add("sticky")
    } else {
        navbar.classList.remove("sticky");
    }
    }
    function toggleText() {
        var x = document.getElementById("search");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    } 
</script>
<script>
    $('.slick-slider').slick({
    dots: true,
    infinite: false,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 1,
    responsive: [
        {
        breakpoint: 1024,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            autoplay: true,
            infinite: true,
            dots: true
        }
        },
        {
        breakpoint: 480,
        settings: {
            slidesToShow: 1,
            autoplay: true,
            slidesToScroll: 1
        }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
    ]
    }); 
</script>
</html>