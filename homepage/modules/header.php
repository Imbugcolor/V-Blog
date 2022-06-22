<?php
    include("../conn.php");
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
                        $html.='<ul class="nav navbar-nav"><li><a href="../index.php">Home</a>';
                    }else{
                        $html.='<ul class="dropdown-menu">';
                    }
                    
                }
                if($level==$prelevel){
                    $html.='</li>';
                }
                $html.='<li><a href="page1.php?tag_id='.$id.'&parent_id='.$parent.'">'.$data['tag_name'].' <span class="caret"></span></a>';
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
    <link href="../assets/bootstrap.css" rel="stylesheet">
    <link href="../assets/jquery.smartmenus.bootstrap.css" rel="stylesheet">
    <link id="switcher" href="../assets/theme-color/default-theme.css" rel="stylesheet">
    <!--css,grid file link-->
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/grid.css">
    <!--slick slider css jquery cdn-->
    <link rel="stylesheet" href="../assets/slick/slick.css">
    <link rel="stylesheet" href="../assets/slick/slick-theme.css">
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
    <script src="../assets/js/bootstrap.js"></script>  
    <script type="text/javascript" src="../assets/js/jquery.smartmenus.js"></script>
    <script type="text/javascript" src="../assets/js/jquery.smartmenus.bootstrap.js"></script>  
    