<div id="log">
            
            <p>Zalogowano jako <strong><?php 
                switch ($id_role) {
                case 1:
                echo $_SESSION['username'] . ' (admin)' . '  '; 
                break;
                
                case 2:
                echo $_SESSION['username'] . '  ';
                break;
                
                default:
                echo $_SESSION['username'] . ' czyli nikt iksde' . '  ';
                }
            ?></strong> <a href="logout.php" style="text-decoration: none;"><i style="color: black;">(Wyloguj)</i></a></p>
</div>
