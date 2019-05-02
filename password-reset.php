
<?php
session_start();
$hostname='***********';
$username='***********';
$password='***********';
$dbname='*************';
$connection = mysql_connect($hostname, $username, $password);
if(!$connection) {
    die("Database connection failed: " . mysql_error());
}
$dbselect=mysql_select_db($dbname);
if(!$dbselect) {
	die("Database selection failed: " . mysql_error());
}
mysql_query("SET NAMES utf8");


if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"])
  && ($_GET["action"]=="reset") && !isset($_POST["action"])){
  $key = $_GET["key"];
  $email = $_GET["email"];
  $query = "SELECT NOW()";
  $res = mysql_query($query);
  $curDate = mysql_result($res, 0);
  $query = "SELECT * FROM Pass_Reset WHERE email='".$email."' and klucz='".$key."' and flag=true";
  $res = mysql_query($query);
  $row = mysql_num_rows($res);
  if ($row=="0"){
    $_SESSION['error'] .= 'Niepoprawny link!<p>Ten link jest niepoprawny albo przedawniony. Albo nie przekopiowałeś całego linku albo już go użyłeś, więc został dezaktywowany.</p>';
    header('Location: index.php');
	} else{
    $row = mysql_fetch_assoc($res);
    $expDate = $row['expDate'];
      if ($expDate >= $curDate){
      ?>
      <html>
        <?php include('view/header.php'); ?>
        <link rel="stylesheet" href="css/defaultpage.css">
        <body>
        <div id="all">
        <div class="container-fluid" id="main">
            <div class="product" style="margin-top: 15%">
            <a id="logo2" href="index.php"><img src="/images/logosmall.png"></a>
            <div id= "login" class="login-block">
                <h4>Podaj nowe hasło</h4>
                <form method="post" action="subsites/server.php">
                    <input id ="pass" type="password" class="input"        placeholder="Hasło"   name="pass1"/>
                    <input id ="repass" type= "password" class="input"  placeholder="Powtórz Hasło"   name="pass2"/><br>
                    <input type="hidden" value="<?php echo $email; ?>"  name="email"/>
                    <input type="hidden" value="<?php echo $key; ?>"  name="key"/>
                    <button class="btn" type="submit" style="clear: both;" name="updatePass">Dalej</button>
                </form>
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
      </body>
      </html>
    <?php
    } else {
      $_SESSION['error'] = "Link wygasł. Wygenerowany link po 24 godzinach staje się nieaktywny :(";
      header('Location: index.php');
    }
  }
}
