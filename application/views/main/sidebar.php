<!-- Sidebar begins -->
<div id="sidebar">

    
	<!-- Main nav -->
    <div class="mainNav">
        
        
        <!-- Responsive nav -->
        <div class="altNav">
            <div class="userSearch">
                <form action="">
                    <input type="text" placeholder="search..." name="userSearch" />
                    <input type="submit" value="" />
                </form>
            </div>
            
            <!-- User nav -->
            <ul class="userNav">
                <li><a href="#" title="" class="profile"></a></li>
                <li><a href="#" title="" class="messages"></a></li>
                <li><a href="#" title="" class="settings"></a></li>
                <li><a href="#" title="" class="logout"></a></li>
            </ul>
        </div>
        
        <!-- Main nav -->
        <ul class="nav">
            <?php
            foreach ($this->menu as $k => $v)
            {
                $url = $v['M_MenuUrl'] == '#' ? 'javascript:;' : base_url() . $v['M_MenuUrl'];
                echo '<li class=level0menu><a href="' . $url . '" title="" class="level0menu" rel="' . $v['M_MenuRel'] . '"><img src="' . base_url() . 'includes/images/icons/mainnav/' . $v['M_MenuIcon'] . '" alt="" /><span>' . $v['M_MenuName'] . '</span></a>';
                               
                echo '</li>';
            }
            ?>
        </ul>
    </div>
        
    <?= isset($secnav) ? $secnav : '' ?>
</div>
<!-- Sidebar ends -->