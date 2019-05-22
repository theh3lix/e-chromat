<?php
include('subsites/server.php');
if(isset($_SESSION['username'])){?>
    <html>
    <head>
        <?php include('view/header.php');?>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/settings.css">

    </head>

    <body onload="onLd();">
    <div class="container-fluid naglowek" style="margin-top: 30px;">
        <div id="navbar2" class="d-lg-none">
                <br><br><br>
                <a class="tekstylia">TEKSTYLIA</a><br>
                <a class="poduszki">PODUSZKI</a><br>
                <a class="kubki">KUBKI</a><br>
                <a class="wydruki">PŁÓTNA</a><br>
                <a class="odbitki">ODBITKI</a><br>
                <a class="ustawienia">USTAWIENIA</a><br>
                <a href="http://chromat.pl">CHROMAT.PL</a><br>
        </div>
        <a id="barsy" class="d-block d-lg-none" onclick="document.getElementById('navbar2').classList.toggle('is-active');"><i class="fa fa-bars" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i></a>
        <a id="logo2"><img src="/images/logosmall.png"></a>
        <div id="navbar" class="d-none d-lg-block">
                <a class="tekstylia">TEKSTYLIA</a>
                <a class="poduszki">PODUSZKI</a>
                <a class="kubki">KUBKI</a>
                <a class="wydruki">PŁÓTNA</a>
                <a class="odbitki">ODBITKI</a>
                <a class="ustawienia">USTAWIENIA</a>
                <a href="http://chromat.pl">chromat.pl</a>
        </div>
    </div><br>
    <div class="container-fluid" id="full" style=" margin-top: 4%;">
      <div id="err" style="position: absolute; width: 80%; top: 30%; left: 50%; transform: translate(-50%, -50%); z-index: 9999;">
          <?php if (isset($_SESSION['error'])) : ?>
                  <div class="error fadeable" >
                      <h4 style="font-size: 1.1rem;">
                          <?php
                              echo $_SESSION['error'];
                              unset($_SESSION['error']);
                          ?>
                      </h4>
                  </div>
          <?php endif ?>
          <?php if (isset($_SESSION['success'])) : ?>
                    <?php if (strlen($_SESSION['success'])<15) : ?>
                      <div class="error success fadeable">
                    <?php else :?>
                      <div class="error success">
                      <?php endif ?>
                      <h4>
                          <?php
                              echo $_SESSION['success'];
                          ?>
                      </h4>
                      <?php if (strlen($_SESSION['success'])>15) : ?>
                          <button class='ok' onclick="document.getElementById('err').style.display='none';">OK</button>
                      <?php endif ?>
                      <?php unset($_SESSION['success']); ?>
                  </div>
          <?php endif ?>
      </div>
      <div class="container-fluid" id="main" style="margin-top: 7%;">
      </div>
  </div>
    </body>
    <?php include('view/footer.php'); ?>
    </html>
<?php } else {?>
    <!DOCTYPE html>
    <html>
    <head>
        <?php include('view/header.php'); ?>
        <link rel="stylesheet" href="css/defaultpage.css">
    </head>
    <body>
    <div id="all">

    <div class="container-fluid" id="main">
        <div class="product" style="margin-top: 15%">
        <div class="col-xs-12 col-md-6 half" style="float: left; margin-top: 4%; margin-left: -5%;"><a id="logo2" href="index.php"><img src="/images/logosmall.png"></a></div>
        <div id= "login" class="login-block half col-xs-12 col-md-6">
            <form method="post" action="subsites/server.php">
                <input id ="user" type="text" class="input" placeholder="login/e-mail"   name="username"/>
                <input id ="pass" type= "password" class="input"  placeholder="hasło" name="password"/><br>
                <button id="submit2" class="btn" style="clear: both; margin-bottom: 3px;" onclick="$('#main').load('view/register.php'); return false;">Rejestruj</button>
                <button id="submit" class="btn" type="submit" name="login_user" style="margin-bottom: 3px;">Zaloguj</button>
            </form>
            <a href="#" onclick="return remmail();" style="clear: both; float: right; margin-right: 10px; color: black; font-size: 11px;"><u>Zapomniałeś hasła?</u></a>
            <?php if (isset($_SESSION['success'])) : ?>
                <div class="error success">
                  <h4>
                    <?php
                      echo $_SESSION['success'];
                      unset($_SESSION['success']);
                    ?>
                  </h4>
                </div>
            <?php endif ?>
            <?php if (isset($_SESSION['error'])) : ?>
                  <div class="error" >
                    <h4>
                      <?php
                          echo $_SESSION['error'];
                          unset($_SESSION['error']);
                      ?>
                    </h4>
                  </div>
                <?php endif ?>
        </div>
      </div>
    </div>

    </div>
    </div>
    </body>
    </html>

    <?php
    // 5. Close connection
    mysql_close($connection);
};
?>
