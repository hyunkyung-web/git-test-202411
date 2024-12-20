
<aside class="sidebar">
    <ul>
        <li class="logo">
            <img src="/public/images/main/logo01.png" alt="">
        </li>
        <li class="nav-item">
            <span class="sub-list-toggle"><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp; CMS <i class="fas fa-chevron-down"></i></span>
            <!-- <i class="fas fa-chevron-up"></i> -->
            <ul class="sub-list" <?php echo in_array($menuNum, [100, 110]) ? 'style="display: block;"' : '';?>>
                <li onclick="javascript: openMenu(100);">Contents List</li>
                <li onclick="javascript: openMenu(110);">Contents New</li>
            </ul>
        </li>

        <li class="nav-item">
            <span class="sub-list-toggle"><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp; Message Template <i class="fas fa-chevron-down"></i></span>
            <ul class="sub-list" <?php echo in_array($menuNum, [200, 210]) ? 'style="display: block;"' : '';?>>
                <li onclick="javascript: openMenu(200);">Template List</li>
                <li onclick="javascript: openMenu(210);">Template New</li>
            </ul>
        </li>

        <li class="nav-item">
            <span class="sub-list-toggle"><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp; Notice Board </span>

        </li>

        <li class="nav-item">
            <span class="sub-list-toggle"><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp; HCP <i class="fas fa-chevron-down"></i></span>
            <ul class="sub-list" <?php echo in_array($menuNum, [800, 810]) ? 'style="display: block;"' : '';?>>
                <li onclick="javascript: openMenu(800);">HCP List</li>
                <li onclick="javascript: openMenu(810);">HCP New</li>
            </ul>
        </li>

        <li class="nav-item">
            <span class="sub-list-toggle"><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp; Users <i class="fas fa-chevron-down"></i></span>
            <ul class="sub-list" <?php echo in_array($menuNum, [900, 910]) ? 'style="display: block;"' : '';?>>
                <li onclick="javascript: openMenu(900);">Internal User List</li>
                <li onclick="javascript: openMenu(910);">Internal User New</li>
            </ul>
        </li>


        <li>
            <span class="sub-list-toggle"><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp; Report </span>
        </li>

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
            <li class="nav-item">
                <span class="sub-list-toggle"><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp; CMS <i class="fas fa-chevron-down"></i></span>
                <!-- <i class="fas fa-chevron-up"></i> -->
                <ul class="sub-list" <?php echo in_array($menuNum, [100, 110]) ? 'style="display: block;"' : '';?>>
                    <li onclick="javascript: openMenu(100);">Contents List</li>
                    <li onclick="javascript: openMenu(110);">Contents New</li>
                </ul>
            </li>

            <li class="nav-item">
                <span class="sub-list-toggle"><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp; Message Template <i class="fas fa-chevron-down"></i></span>
                <ul class="sub-list" <?php echo in_array($menuNum, [200, 210]) ? 'style="display: block;"' : '';?>>
                    <li onclick="javascript: openMenu(200);">Template List</li>
                    <li onclick="javascript: openMenu(210);">Template New</li>
                </ul>
            </li>

            <li class="nav-item">
                <span class="sub-list-toggle"><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp; Notice Board </span>

            </li>

            <li class="nav-item">
                <span class="sub-list-toggle"><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp; HCP <i class="fas fa-chevron-down"></i></span>
                <ul class="sub-list" <?php echo in_array($menuNum, [800, 810]) ? 'style="display: block;"' : '';?>>
                    <li onclick="javascript: openMenu(800);">HCP List</li>
                    <li onclick="javascript: openMenu(810);">HCP New</li>
                </ul>
            </li>

            <li class="nav-item">
                <span class="sub-list-toggle"><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp; Users <i class="fas fa-chevron-down"></i></span>
                <ul class="sub-list" <?php echo in_array($menuNum, [900, 910]) ? 'style="display: block;"' : '';?>>
                    <li onclick="javascript: openMenu(900);">Internal User List</li>
                    <li onclick="javascript: openMenu(910);">Internal User New</li>
                </ul>
            </li>


            <li>
                <span class="sub-list-toggle"><i class="fa-solid fa-file-excel"></i>&nbsp;&nbsp; Report </span>
            </li>
        </ul>
    </div>

</aside>
