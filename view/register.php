<div  id="register">
  <div class="naglowek" style="margin-top: 30px;">
      <a id="logo" href="index.php"><img src="/images/logosmall.png"></a>
  </div>
    <form method="post" action="subsites/server.php">
        <?php include('../view/errors.php'); ?>
        <div class="product">
          <div class="product1" style="clear: both;">
            <h4>Dane Logowania</h4>
            <input type="text"         class="regs" placeholder="Imię"          name="name" /><br>
            <input type="text"         class="regs" placeholder="Nazwisko"          name="lastname" /><br>

            <input type="text"         class="regs" placeholder="Login"          name="username" /><br>
            <input type="text"         class="regs" placeholder="E-mail"         name="email" /><br>
            <input type="password"     class="regs" placeholder="Haslo"          name="password" /><br>
            <input type="password"     class="regs" placeholder="Re Haslo"       name="repassword" /><br>
          </div>
          <div id="summary">
            <button id="submit3" type="submit" class="btn col-md-6" style="clear: both; float: left;" name="reg_user">Zarejestruj</button>
            <button class="btn col-md-6" name="reg_user" style="float: left;" onclick="$('#main').load('view/login.php'); return false;">Powrót</button>
          </form>
          <p style="position: static; width: 100%; clear: both; float: left; font-family: 'Oswald', sans-serif; font-style: italic; font-size: 10px; margin-top: 20px;">
              Klikając 'Zarejestruj' wyrażasz zgodę na przetwarzanie swoich danych osobowych do celów marketingowych
              zgodnie z ustawą z dnia 29 sierpnia 1997 r. o ochronie danych osobowych
              (Dz.U. nr 133, poz. 883) przez Chromat sp. z o.o.</p>
          </div>
        </div>
</div><br>
