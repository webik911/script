        <div  id="menu">
            <ul>
                <li class="link"><a href="index.php"><?=$ini_array['menu']['index']?></a></li>
                <!--<li class="link"><a href="view.php"><?php /*print $ini_array['menu']['data'];*/?></a></li>-->
                <li class="link"><a href="about.php"><?=$ini_array['menu']['about']?></a></li>
                <li class="link"><a href="contact.php"><?=$ini_array['menu']['contact']?></a></li>
                <?php if(isset($_SESSION['login'])) echo "<li class='link'><a href='profile.php'>Profile</a></li>"?>
            </ul>
            <?php include("language.php")?>
        </div>        