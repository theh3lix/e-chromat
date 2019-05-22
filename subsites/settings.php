<?php include('server.php'); ?>
<div class="product settings hdr">
    <h2 class="product-name" style="text-align: center; font-size: 2rem;">USTAWIENIA</h2>
    <form method="post" action="subsites/server.php" id="formsettings" style="margin-top: 20px;">
        <div id="detailsupdate" class="sett col-xs-12 col-sm-6 col-md-4">
            <input id="imie" type="text" class="polaupdate" placeholder="Imię" name="name" /><br>
            <input id="nazwisko" type="text" class="polaupdate" placeholder="Nazwisko" name="surname" /><br>
            <input id="ulica" type="text" class="polaupdate" placeholder="Ulica" name="street" /><br>
            <input id="nrdomu" type="text" class="polaupdate" placeholder="Nr domu" name="houseno" /><br>
            <input id="miasto" type="text" class="polaupdate" placeholder="Miasto" name="city" /><br>
            <input id="kod" type="text" class="polaupdate" placeholder="Kod pocztowy" name="cicode" /><br>
            <input id="nrtel" type="text" class="polaupdate" placeholder="Nr telefonu" name="phoneno" /><br>
            <button id="detcommit" class="commit input" style="margin-bottom: 20px;" type="submit" name="detcommit" onclick="return confirm('Jesteś pewien?')" value="Zaktualizuj">Zaktualizuj</button>
        </div>

        <div id="passupdate" class="sett col-xs-12 col-sm-6 col-md-4">
            <input id="pass" type="password" class="polaupdate" placeholder="Stare hasło" name="pass" /><br>
            <input id="newpass" type="password" class="polaupdate" placeholder="Nowe hasło" name="newpass" /><br>
            <input id="renewpass" type="password" class="polaupdate" placeholder="Re-nowe hasło" name="renewpass" /><br>
            <button id="passcommit" type="submit" class="commit input" style="margin-bottom: 20px;" name="passcommit" onclick="return confirm('Jesteś pewien?')" value="Zaktualizuj">Zaktualizuj</button>
        </div>
    </form>
    <div class="sett col-xs-12 col-sm-6 col-md-4">
        <form method="post" action="subsites/server.php"><input id="delete" class="commit input" type="submit" name="delete" onclick="return confirm('Jesteś pewien?')" value="Usuń konto"/></form>
        <button class="commit input" onclick="
        if(document.getElementById('dane').style.display=='none') {
            this.style.backgroundColor='white';
            this.style.boxShadow='0 0 5px 3px rgba(0,255,0,0.6)';
            document.getElementById('dane').style.display='block';
        } else {
            document.getElementById('dane').style.display='none';
            this.style.backgroundColor='#ddd';
            this.style.boxShadow='0 0 5px 2px rgba(0,0,0,0.6)';
        }">Pokaż dane</button>
        <button id="history" class="commit input" value="Pokaż historię" onclick="
        if(document.getElementById('historia').style.display=='none') {
            this.style.backgroundColor='white';
            this.style.boxShadow='0 0 5px 3px rgba(0,255,0,0.6)';
            document.getElementById('historia').style.display='block';
        } else {
            document.getElementById('historia').style.display='none';
            this.style.backgroundColor='#ddd';
            this.style.boxShadow='0 0 5px 2px rgba(0,0,0,0.6)';
        }">Pokaż historię</button>
    </div>
</div>
<div class="product col-xs-12 col-sm-6 col-md-3" id='dane' style="display: none; margin-top: 10px;">
    <p style="margin-bottom: 20px;"><?php echo $txt; ?></p>
</div>
<div class="product" id="historia" style="clear: both; display: none; max-height: none;">
    <?php
        $connection = mysql_connect("*******","********","********");
        if(!$connection) {
            die("Database connection failed: " . mysql_error());
        }

        $db_select = mysql_select_db("*******",$connection);
        if(!$db_select) {
            die("Database selection failed: " . mysql_error());
        }
        $username = mysql_real_escape_string($_SESSION['username']);
        mysql_query('SET NAMES utf8');
        $queryid = "SELECT id_us from User where login='$username'";
        $tmp = mysql_query($queryid);
        $id = mysql_result($tmp,0);
        $query = "SELECT data, rodzaj_zlecenia, wymiary_odbitki, ilosc_odbitek, cena FROM Contract where id_us=$id order by id desc";
        $res = mysql_query($query);
        $array = array("Data zlecenia:","Rodzaj zlecenia:","Wymiary odbitki:","Ilość odbitek", "Cena:");
        foreach($array as $i)
            echo '<span style="display: inline-block; width: 18%; text-align:center;">'.$i.'</span>';
        echo '<br>';
        echo '____________________________________________________________________________________________________________________________<br>';
        while($rows = mysql_fetch_row($res)) {
            foreach($rows as $row)
                echo '<span style="display: inline-block; width: 18%; text-align:center;">'.$row.'</span>';
            echo '<br>';

        }
    ?>
</div>
