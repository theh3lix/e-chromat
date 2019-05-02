<div class="product" style="margin-top: 15%">
  <a id="logo2" href="index.php"><img src="/images/logosmall.png"></a>
  <div id= "login" class="login-block">
    <form method="post" action="subsites/server.php">
        <input id ="user" type="text" class="input"       placeholder="login/e-mail"   name="username"/>
        <input id ="pass" type= "password" class="input"  placeholder="hasło"   name="password"/><br>
        <button id="submit2" class="btn" style="clear: both; margin-bottom: 3px;" onclick="$('#main').load('view/register.php'); return false;">Rejestruj</button>
        <button id="submit" class="btn" type="submit" name="login_user" style="margin-bottom: 3px;">Zaloguj</button>
    </form>
    <a href="#" onclick="return remmail();" style="clear: both; float: right; margin-right: 10px; color: black; font-size: 11px;"><u>Zapomniałeś hasła?</u></a>
  </div>
</div>
