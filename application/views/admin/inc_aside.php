<?php 

$arrMenu_1 = [
    ["name"=>"CMS", "menu_num"=>"100"],
    ["name"=>"Message Template", "menu_num"=>"200"],
    ["name"=>"Notice Board", "menu_num"=>"300"],
    ["name"=>"Member", "menu_num"=>"500"],
    ["name"=>"Users", "menu_num"=>"600"],
    ["name"=>"REPORT", "menu_num"=>"800"],
];

$arrMenu_2 = [
    ["name"=>"Contents Create", "menu_num"=>"101", "pr_menu_num"=>"100"], 
    ["name"=>"Contents List", "menu_num"=>"102", "pr_menu_num"=>"100"],       
    ["name"=>"Template Create", "menu_num"=>"201", "pr_menu_num"=>"200"],
    ["name"=>"Template List", "menu_num"=>"202", "pr_menu_num"=>"200"],
    ["name"=>"Message List", "menu_num"=>"210", "pr_menu_num"=>"200"],
    ["name"=>"Notice Create", "menu_num"=>"301", "pr_menu_num"=>"300"],
    ["name"=>"Notice List", "menu_num"=>"302", "pr_menu_num"=>"300"],    
    ["name"=>"Member Create", "menu_num"=>"501", "pr_menu_num"=>"500"],
    ["name"=>"Member List", "menu_num"=>"502", "pr_menu_num"=>"500"],    
    ["name"=>"Internal User New", "menu_num"=>"601", "pr_menu_num"=>"600"],
    ["name"=>"Internal User List", "menu_num"=>"602", "pr_menu_num"=>"600"],    
    ["name"=>"Report_1", "menu_num"=>"901", "pr_menu_num"=>"800"],
];

$view_menu = $menu_num;
$view_menu_array_num = array_search($view_menu, array_column($arrMenu_2, "menu_num"));
$view_pr_menu = $arrMenu_2[$view_menu_array_num]["pr_menu_num"];

?>
<aside class="sidebar">
    <ul>
        <li class="logo">
            <a href="/admin/main/"><img src="/public/images/main/logo01.png" alt=""></a>
        </li>
        <?php 
        foreach($arrMenu_1 as $row){?>
        	<li class="nav-item">
            	<span class="sub-list-toggle" <?php echo $row["menu_num"]==$view_pr_menu ? 'style="color: #fff;"' : '';?>><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp; <?php echo $row["name"].'('.$row["menu_num"].')';?> <i class="fas fa-chevron-down"></i></span><?php
            	if(array_search($row["menu_num"], array_column($arrMenu_2, "pr_menu_num"))>=0){
            	    echo $row["menu_num"]==$view_pr_menu ? '<ul class="sub-list" style="display: block">' : '<ul class="sub-list">';
            	    foreach($arrMenu_2 as $row2){
            	        if($row["menu_num"]==$row2["pr_menu_num"]){
            	            echo '<li onclick="javascript: openMenu('.$row2["menu_num"].');" ';
            	            echo $row2["menu_num"]==$menu_num ? 'style="color: #fff">' : '>';
                            echo $row2["name"].'('.$row2["menu_num"].')'.'</li>';
            	        }
            	    }
            	    echo '</ul>';
            	}?>
        	</li><?php 
        }?>
        
        <!-- 
        <li class="nav-item">
            <span class="sub-list-toggle"><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp; CMS <i class="fas fa-chevron-down"></i></span>
            <!**i class="fas fa-chevron-up"></i**>
            <ul class="sub-list">
                <li onclick="javascript: openMenu(100);">Contents List</li>
                <li onclick="javascript: openMenu(110);">Contents New</li>
            </ul>
        </li>
         -->
        
    </ul>
    <!-- <button class="sidebar-toggle"><i class="fas fa-chevron-left"></i></button> -->
<!--     <button class="sidebar-toggle"><i class="fas fa-bars"></i></button> -->

<!-- Mobile -->
    <div class="menu-toggle">
        <!-- <input type="checkbox" /> -->
        <span></span>
        <span></span>
        <span></span>
    </div>
    
    <div class="hamburger-menu">
        <ul>
        
        <?php 
        foreach($arrMenu_1 as $row){?>
        	<li class="nav-item">
            	<span class="sub-list-toggle" <?php echo $row["menu_num"]==$view_pr_menu ? 'style="color: #fff;"' : '';?>><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp; <?php echo $row["name"].'('.$row["menu_num"].')';?> <i class="fas fa-chevron-down"></i></span><?php
            	if(array_search($row["menu_num"], array_column($arrMenu_2, "pr_menu_num"))>=0){
            	    echo $row["menu_num"]==$view_pr_menu ? '<ul class="sub-list" style="display: block">' : '<ul class="sub-list">';
            	    foreach($arrMenu_2 as $row2){
            	        if($row["menu_num"]==$row2["pr_menu_num"]){
            	            echo '<li onclick="javascript: openMenu('.$row2["menu_num"].');" ';
            	            echo $row2["menu_num"]==$menu_num ? 'style="color: #fff">' : '>';
                            echo $row2["name"].'('.$row2["menu_num"].')'.'</li>';
            	        }
            	    }
            	    echo '</ul>';
            	}?>
        	</li><?php 
        }?>
        
			<!--                 
            <li class="nav-item">
                <span class="sub-list-toggle"><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp; CMS <i class="fas fa-chevron-down"></i></span>
                <!** <i class="fas fa-chevron-up"></i> **>
                <ul class="sub-list" <?php echo in_array($menuNum, [100, 110]) ? 'style="display: block;"' : '';?>>
                    <li onclick="javascript: openMenu(100);">Contents List</li>
                    <li onclick="javascript: openMenu(110);">Contents New</li>
                </ul>
            </li>
             -->
        </ul>
    </div>

</aside>
