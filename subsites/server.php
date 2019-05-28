<?php

    session_start();
    $hostname='*********';
    $username='*********';
    $password='*********';
    $dbname='*********';
    $connection = mysql_connect($hostname, $username, $password);
    if(!$connection) {
        die("Database connection failed: " . mysql_error());
    }
    $dbselect=mysql_select_db($dbname);
    if(!$dbselect) {
    	die("Database selection failed: " . mysql_error());
    }
    mysql_query("SET NAMES utf8");




if(isset($_POST['remember_mail'])) {
    $mail = mysql_real_escape_string($_POST['mailtoremember']);
    $query = "SELECT * FROM User where email='$mail'";
    $result = mysql_query($query);
    if(mysql_num_rows($result)==0) {
      $_SESSION['error'] = $_SESSION['error'] . "Użytkownik o podanym adresie e-mail nie istnieje :(<br>";
      header('Location: ../index.php');
    } else {
      $expDate = date("Y-m-d H:i:s",$expFormat);
      $key = md5(2418*2+$email);
      $addKey = substr(md5(uniqid(rand(),1)),3,10);
      $key = $key . $addKey;
      $query = "INSERT INTO Pass_Reset VALUES ('$mail', '$key', NOW() + INTERVAL 1 HOUR, true)";
      $res = mysql_query($query);
      if(!$res) {
        $_SESSION['error'] .= "Błąd przy tworzeniu klucza :/ <br>";
        header('Location: ../index.php');
      }

      $output .= "Drogi użytkowniku\n";
      $output .= "Kliknij w poniższy link, żeby zresetować swoje hasło: \n";
      $output .= "-------------------------------------------------------------------------------------------\n";
      $output .= "fotoexpress.chromat.pl/e-chromat/password-reset.php?key=".$key."&email=".$mail."&action=reset\n";
      $output .= "-------------------------------------------------------------------------------------------\n";
      $output .= "Link wygaśnie za godzinę ze względów bezpieczeństwa\n";
      $output .= "Jeśli nie spodziewałeś się tego maila, pewnie dobrym pomysłem byłoby zalogowanie się do aplikacji i zmiana hasła, bo ktoś mógł je odgadnąć.\n";
      $output .= "Dziękujemy,\n";
      $output .= "Chromat\n";
      $output .= "-------------------------------------------------------------------------------------------\n";
      $output .= "Wiadomość ta została wygenerowana automatycznie i nie należy na nią odpowiadać!\n";

      $body = $output;
      $subject = "Odzyskiwanie hasła - e-chromat";
      $from = "noreply@chromat.pl";
      $to = $mail;
      $headers[] = "From:" . $from;
      $headers[] = "MIME-Version: 1.0";
      $headers[] = "Content-Type: text/html; charset=utf-8";
      if(!mail($to,$subject,$body, $headers)){
        $_SESSION['error'] = $_SESSION['error'] . "Błąd przy wysyłaniu maila!<br>";
        header('Location: ../index.php');
      } else {
        $_SESSION['success'] = "Wysłaliśmy na Twojego maila wiadomość z instrukcjami jak zresetować hasło :)";
        header('Location: ../index.php');
      }
    }

}

if(isset($_POST['updatePass'])) {
    $pass1 = mysql_real_escape_string($_POST['pass1']);
    $pass2 = mysql_real_escape_string($_POST['pass2']);
    $email = mysql_real_escape_string($_POST['email']);
    $key = mysql_real_escape_string($_POST['key']);

    if($pass1 != $pass2) {
      $_SESSION['error'] .= "Hasła się nie zgadzają!<br>";
      header("Location: ../password-reset.php?key=".$key."&email=".$email."&action=reset");
    } else {
      $pass = md5($pass1);
      $query = "UPDATE User SET password='$pass' where email='$email'";
      $res = mysql_query($query);
      if(!$res) {
          $_SESSION['error'] = $_SESSION['error'] . 'Błąd przy zmienianiu hasła!<br>';
          header('Location: ../index.php');
      } else {
          $query = "UPDATE Pass_Reset SET flag = false where email='".$email."' and klucz='".$key."'";
          $result = mysql_query($query);
          if(!$result) {
              $_SESSION['error'] = $_SESSION['error'] . 'Błąd przy anulowaniu tymczasowego klucza!<br>';
              header('Location: ../index.php');
          }
          $_SESSION['success'] .= 'Zmieniono hasło!';
          header('Location: ../index.php');
      }
    }
}

if(isset($_SESSION['username'])) {
    $login=mysql_real_escape_string($_SESSION['username']);
    $query="SELECT id_us from User where login='$login'";
    $tmp=mysql_query($query);
    $id_us=mysql_result($tmp,0);

    $query = "select id_role from User where login='$username'";
    $tmp = mysql_query($query);
    $id_role = mysql_result($tmp, 0);

    //dane do wysyłki

    $queryimie = "SELECT name from User_Details where id_us=$id_us";
    $tmpimie = mysql_query($queryimie);
    $imie = mysql_result($tmpimie, 0);

    $querynazwisko = "SELECT lastname from User_Details where id_us=$id_us";
    $tmpnazwisko = mysql_query($querynazwisko);
    $nazwisko = mysql_result($tmpnazwisko, 0);

    $queryulica = "SELECT street from User_Details where id_us=$id_us";
    $tmpulica = mysql_query($queryulica);
    $ulica = mysql_result($tmpulica, 0);

    $querynrdomu = "SELECT housenumber from User_Details where id_us=$id_us";
    $tmpnrdomu = mysql_query($querynrdomu);
    $nrdomu = mysql_result($tmpnrdomu, 0);

    $querymiasto = "SELECT city from User_Details where id_us=$id_us";
    $tmpmiasto = mysql_query($querymiasto);
    $miasto = mysql_result($tmpmiasto, 0);

    $querykodpoczt = "SELECT citycode from User_Details where id_us=$id_us";
    $tmpkodpoczt = mysql_query($querykodpoczt);
    $kodpoczt = mysql_result($tmpkodpoczt, 0);

    $querynrtel = "SELECT cellnumber from User_Details where id_us=$id_us";
    $tmpnrtel = mysql_query($querynrtel);
    $nrtel = mysql_result($tmpnrtel, 0);


    $querymail = "SELECT email from User where id_us=$id_us";
    $tmpmail = mysql_query($querymail);
    $mail = mysql_result($tmpmail, 0);

    $login = date(m)."-".date(d)."_".date(H)."-".date(i)."-".date(s)."_".$nazwisko."_".$imie;
    $login = str_replace(" ", "_", $login);
    $wysylka = $imie . " " . $nazwisko . "\nul. " . $ulica . " " . $nrdomu . "\n" . $kodpoczt . " " . $miasto;

    $teikste = "Login:\n" . $login . "\n\n" . "Dane do wysyłki:\n" . $wysylka . "\n\n\nDane Uzupełniające:\n" . $mail . "\n" . $nrtel . "\n\n\n\n";
    $txt = $imie . " " . $nazwisko . "<br>" .  $ulica . " " . $nrdomu . "<br>" . $kodpoczt . " " . $miasto . "<br>" . $nrtel;

    $data = date(Y)."-".date(m)."-".date(d);



    //odbitki
    if(isset($_POST['odbitki']))
    {
            $rozmiar = mysql_real_escape_string($_POST['rozmiar']);
            $wypelnienie = mysql_real_escape_string($_POST['wypelnienie']);
            $powierzchnia = mysql_real_escape_string($_POST['powierzchnia']);
            $sepia = mysql_real_escape_string($_POST['sepia']);
            $query="INSERT INTO Contract (id_us, rodzaj_zlecenia, wymiary_odbitki, data) VALUES ($id_us, 'odbitki', '$rozmiar', curdate())";
            mysql_query($query);
            $idzlecenia=mysql_insert_id();
            $foldertmp = "uploads/e-chromat_".$idzlecenia."/";
            $newfolder=mkdir($foldertmp, 0777);
            if(!$newfolder) {
                $_SESSION['error'] = $_SESSION['error'] . 'Błąd przy tworzeniu folderu<br>';
            }
            $folder1 = $foldertmp . $login . "/";
            $newfolder=mkdir($folder1, 0777);
            if(!$newfolder) {
                $_SESSION['error'] = $_SESSION['error'] . 'Błąd przy tworzeniu folderu<br>';
            }

            $cnt =0;
            $cena = 0;
            $b=0;
            $cnt9 = 0;
            $cnt13 = 0;
            $cnt15 = 0;
            $cnt20 = 0;
            for($i=0;$i<count($_FILES["upload_file"]["name"]);$i++)
            {
                $a=0;
                $file = $_FILES['upload_file'];
                $fileName = $file['name'][$i];
                $fileTmpName = $file['tmp_name'][$i];
                $fileError = $file['error'];
                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));

                $wyp = mysql_real_escape_string($_POST[($i+1).'-wypelnienie']);
                if($wyp=='Domyślne')
		              $wyp=$wypelnienie;
                $pow = mysql_real_escape_string($_POST[($i+1).'-powierzchnia']);
                if($pow=='Domyślne')
		              $pow=$powierzchnia;
                $roz = mysql_real_escape_string($_POST[($i+1).'-rozmiar']);
                if($roz=='Domyślne')
		              $roz = $rozmiar;
                $sep = mysql_real_escape_string($_POST[($i+1).'-sepia']);
                if($sep=='Domyślne')
  		            $sep=$sepia;

		            $ilosc = mysql_real_escape_string($_POST[($i+1).'-ilosc']);
                $ilosc = intval($ilosc);
                if($ilosc==0)
                    $ilosc=1;
		            $folder=$folder1 . $roz."_".$pow."_".$wyp."_".$sep."_".$ilosc."szt";
                if(!is_dir($folder)) {
                    $b=0;
                    $newfolder = mkdir($folder, 0777);
                    if(!newfolder)
                      $_SESSION['error'] = $_SESSION['error'] . 'Błąd przy tworzeniu folderu<br>';
                }
                $b++;
                $allowed = array('jpg', 'jpeg', 'png');
                if(in_array($fileActualExt, $allowed)) {
                    $uploadfile=$_FILES["upload_file"]["tmp_name"][$i];
                    $uploadfile=str_replace(" ", "_", $uploadfile);
                    $copied = $folder.'/'. $ilosc ."szt" . '_' . $roz . '_' . $pow .'_'.$wyp.'_'.$b.'.' . $fileActualExt;
                        $cp = copy($uploadfile, $copied);
                        if(!$cp) {
                            $_SESSION['error'] = $_SESSION['error'] . 'Błąd przy przesyłaniu pliku<br>';
                        }
                    for($j=0;$j<$ilosc;$j++) {
                        $cnt++;
                        $a++;
                    }
                    if($roz === "9x13")
                        $cnt9 += $a;
                    else if($roz === "10x15")
                        $cnt9 += $a;
                    else if($roz === "13x18")
                        $cnt13 += $a;
                    else if($roz === "15x21")
                        $cnt15 += $a;
                    else if($roz === "20x30")
                        $cnt20 += $a;
                    else
                        $_SESSION['error'] = $_SESSION['error'] . 'Błąd matrixa!<br>';
                } else {
                    echo "Niedozwolony format pliku";
                    $_SESSION['error'] = $_SESSION['error'] . 'Niedozwolony format pliku<br>';
                }
            }
                if(!isset($_SESSION['error'])){

                    if($cnt9 < 11) {
                        $cena += $cnt9 * 0.74;
                    } else if($cnt9 > 10 && $cnt9 < 101){
                        $cena += $cnt9 * 0.59;
                    } else if($cnt9 > 100 && $cnt9 < 201) {
                        $cena += $cnt9 * 0.50;
                    } else if($cnt9 > 200 && $cnt9 < 301) {
                        $cena += $cnt9 * 0.47;
                    } else if($cnt9 > 300 && $cnt9 < 501) {
                        $cena += $cnt9 * 0.44;
                    } else if($cnt9 > 500 && $cnt9 < 1001) {
                        $cena += $cnt9 * 0.41;
                    } else if($cnt9 > 1000 && $cnt9 < 2001) {
                        $cena += $cnt9 * 0.39;
                    } else {
                        $cena += $cnt9 * 0.33;
                    }

                    if($cnt13 < 11) {
                        $cena += $cnt13 * 1.12;
                    } else if($cnt13 > 10 && $cnt13 < 101) {
                        $cena += $cnt13 * 0.89;
                    } else if($cnt13 > 100 && $cnt13 < 201) {
                        $cena += $cnt13 * 0.76;
                    } else if($cnt13 > 200 && $cnt13 < 301) {
                        $cena += $cnt13 * 0.71;
                    } else if($cnt13 > 300 && $cnt13 < 501) {
                        $cena += $cnt13 * 0.67;
                    } else if($cnt13 > 500 && $cnt13 < 1001) {
                        $cena += $cnt13 * 0.62;
                    } else if($cnt13 > 1000 && $cnt13 < 2001) {
                        $cena += $cnt13 * 0.58;
                    } else {
                        $cena += $cnt13 * 0.49;
                    }

                    if($cnt15 < 11) {
                        $cena += $cnt15 * 1.49;
                    } else if($cnt15 > 10 && $cnt15 < 101) {
                        $cena += $cnt15 * 1.19;
                    } else if($cnt15 > 100 && $cnt15 < 201) {
                        $cena += $cnt15 * 1.01;
                    } else if($cnt15 > 200 && $cnt15 < 301) {
                        $cena += $cnt15 * 0.95;
                    } else if($cnt15 > 300 && $cnt15 < 501) {
                        $cena += $cnt15 * 0.89;
                    } else if($cnt15 > 500 && $cnt15 < 1001) {
                        $cena += $cnt15 * 0.83;
                    } else if($cnt15 > 1000 && $cnt15 < 2001) {
                        $cena += $cnt15 * 0.78;
                    } else {
                        $cena += $cnt15 * 0.66;
                    }

                    if($cnt20 < 11) {
                        $cena += $cnt20 * 3.70;
                    } else if($cnt20 > 10 && $cnt20 < 101) {
                        $cena += $cnt20 * 2.96;
                    } else if($cnt20 > 100 && $cnt20 < 201) {
                        $cena += $cnt20 * 2.52;
                    } else if($cnt20 > 200 && $cnt20 < 301) {
                        $cena += $cnt20 * 2.37;
                    } else if($cnt20 > 300 && $cnt20 < 501) {
                        $cena += $cnt20 * 2.22;
                    } else if($cnt20 > 500 && $cnt20 < 1001) {
                        $cena += $cnt20 * 2.07;
                    } else if($cnt20 > 1000 && $cnt20 < 2001) {
                        $cena += $cnt20 * 1.93;
                    } else {
                        $cena += $cnt20 * 1.63;
                    }
                $txt=$folder1 . $login . ".txt";
                $filetxt=fopen($txt, "w") or die("Unable to open file!");
                fwrite($filetxt, $teikste);
                $teikstedwa = "Zamówienie:\n". "ilość odbitek: " . $cnt . "\ncena: " . $cena;
                if(isset($_POST['komentarz'])) {
                  $comm = mysql_real_escape_string($_POST['komentarz']);
                  $teikstedwa .= "\n\nKomentarz do zamówienia: \n" . $comm;
                }
                fwrite($filetxt, $teikstedwa);
                $a=mysql_real_escape_string($a);
                $cena=mysql_real_escape_string($cena);
                $query="UPDATE Contract SET ilosc_odbitek='$cnt' where id=$idzlecenia";
                $query2="UPDATE Contract SET cena='$cena' where id=$idzlecenia";
                mysql_query($query);
                mysql_query($query2);
                $output = $teikste . "\n" . $teikstedwa;
                $body = $output;
                $body = str_replace("\n", "<br>", $body);
                $subject = "e-chromat - zamowienie nr " . $idzlecenia;
                $from = "noreply@chromat.pl";
                $to = $mail;
                $headers[] = "From:" . $from;
                $headers[] = "MIME-Version: 1.0";
                $headers[] = "Content-Type: text/html; charset=utf-8";
                mail($to,$subject,$body, implode("\r\n",$headers));
                $_SESSION['success']='Złożono zamówienie!' . "<br>Ilość odbitek: " . $cnt ."<br>Cena: ".$cena."<br><br>Wyślemy Ci maila, kiedy zamówienie będzie gotowe :)";
                header('Location: ../index.php');
            } else {
                $query="DELETE FROM Contract where id=$idzlecenia";
                mysql_query($query);
                rmdir($folder);
                header('Location: ../index.php');
            }
    }

    if(isset($_POST['plotna']))
    {

        $rozmiar = mysql_real_escape_string($_POST['rozmiar']);
        $query="INSERT INTO Contract (id_us, rodzaj_zlecenia, wymiary_odbitki, data) VALUES ($id_us, 'wydruk na plotnie', '$rozmiar', curdate())";
        mysql_query($query);
        $idzlecenia=mysql_insert_id();
        $foldertmp = "uploads/e-chromat_".$idzlecenia."/";
        $newfolder=mkdir($foldertmp, 0777);
        if(!$newfolder) {
            $_SESSION['error'] = $_SESSION['error'] . 'Błąd przy tworzeniu folderu<br>';
            header('Location: ../index.php');
        }
        $folder = $foldertmp . $login . "/";
        $newfolder=mkdir($folder, 0777);
        if(!$newfolder) {
            $_SESSION['error'] = $_SESSION['error'] . 'Błąd przy tworzeniu folderu<br>';
            header('Location: ../index.php');
        }

        $a=0;
        for($i=0;$i<count($_FILES["upload_file"]["name"]);$i++)
        {
            $a++;
            $file = $_FILES['upload_file'];
            $fileName = $file['name'][$i];
            $fileTmpName = $file['tmp_name'][$i];
            $fileError = $file['error'];
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            print $fileName;
            $allowed = array('jpg', 'jpeg', 'png');
            if(in_array($fileActualExt, $allowed)) {
                $uploadfile=$_FILES["upload_file"]["tmp_name"][$i];
                $upload = move_uploaded_file($uploadfile, $folder.$_FILES["upload_file"]["name"][$i]);
                if(!$upload) {
                    echo "Bład wysyłania pliku";
                    $_SESSION['error'] = $_SESSION['error'] . 'Błąd przy wysyłaniu pliku<br>';
                }
            } else {
                echo "Niedozwolony format pliku";
                $_SESSION['error'] = $_SESSION['error'] . 'Niedozwolony format pliku<br>';
            }
        }
            if(!isset($_SESSION['error'])){
                if($rozmiar === "20x30")
                    $cena = $a * 39;

                if($rozmiar === "30x42")
                    $cena = $a * 49;

                if($rozmiar === "40x50")
                    $cena = $a * 95;

                if($rozmiar === "40x60")
                    $cena = $a * 65;

                if($rozmiar === "50x70")
                    $cena = $a * 79;

                if($rozmiar === "60x90")
                    $cena = $a * 99;

                if($rozmiar === "70x100")
                    $cena = $a * 135;

                if($rozmiar === "100x100")
                    $cena = $a * 198;

                if($rozmiar === "100x150")
                    $cena = $a * 260;

                if($rozmiar === "100x200")
                    $cena = $a * 280;
                else {
                    $_SESSION['success'] = 'Operacja wysypała się poprawnie!';
                    header('Location: ../index.php');
                }

                $txt=$folder . $login . ".txt";
                $filetxt=fopen($txt, "w") or die("Unable to open file!");
                fwrite($filetxt, $teikste);
                $teikstedwa = "\nRozmiar wydruków na płótnie: " . $rozmiar . "\nilość: " . $a . "\ncena: " . $cena;
                if(isset($_POST['komentarz'])) {
                  $comm = mysql_real_escape_string($_POST['komentarz']);
                  $teikstedwa .= "\n\nKomentarz do zamówienia: \n" . $comm;
                }
                fwrite($filetxt, $teikstedwa);

                $a=mysql_real_escape_string($a);
                $cena=mysql_real_escape_string($cena);
                $query="UPDATE Contract SET ilosc_odbitek='$a' where id=$idzlecenia";
                $query2="UPDATE Contract SET cena='$cena' where id=$idzlecenia";
                mysql_query($query);
                mysql_query($query2);
                $output = $teikste . "\n" . $teikstedwa;
                $body = $output;
                $body = str_replace("\n", "<br>", $body);
                $subject = "e-chromat - zamowienie nr " . $idzlecenia;
                $from = "noreply@chromat.pl";
                $to = $mail;
                $headers[] = "From:" . $from;
                $headers[] = "MIME-Version: 1.0";
                $headers[] = "Content-Type: text/html; charset=utf-8";
                mail($to,$subject,$body, implode("\r\n",$headers));
                $_SESSION['success']='Złożono zamówienie!' . "<br>Wydruk na płótnie o wymiarach: " . $rozmiar . "<br>Ilość: " . $a . "<br>Id zlecenia: " . $idzlecenia . "<br><br>Wyślemy Ci maila, kiedy zamówienie będzie gotowe :)";
                header('Location: ../index.php');
        } else {
            $query="DELETE FROM Contract where id=$idzlecenia";
            mysql_query($query);
            rmdir($folder);
            header('Location: ../index.php');
        }
    }

    if(isset($_POST['kubek'])) {
        $nazwa = mysql_real_escape_string($_POST['prodname']);
        $material = mysql_real_escape_string($_POST['material']);
        $kolor = mysql_real_escape_string($_POST['kolory']);
        $cena = mysql_real_escape_string($_POST['cena']);
        $grafikaurl = mysql_real_escape_string($_POST['foto']);

        if($grafikaurl=="") {
          $_SESSION['error'] = $_SESSION['error']. "Musisz wybrać grafikę<br>";
          header('Location: ../index.php');
        } else {
            $query="INSERT INTO Contract (id_us, rodzaj_zlecenia, cena, data) VALUES ($id_us, '$nazwa', $cena, curdate())";
            mysql_query($query);
            $idzlecenia=mysql_insert_id();
            $foldertmp = "uploads/e-chromat_".$idzlecenia."/";
            $newfolder=mkdir($foldertmp, 0777);
            if(!$newfolder) {
                $_SESSION['error'] = $_SESSION['error'] . 'Błąd przy tworzeniu folderu<br>';
            }
            $folder = $foldertmp . $login . "/";
            $newfolder=mkdir($folder, 0777);
            if(!$newfolder) {
                $_SESSION['error'] = $_SESSION['error'] . 'Błąd przy tworzeniu folderu<br>';
            }
            $txt=$folder . $login . ".txt";
            $grafikaurl = $_SERVER['DOCUMENT_ROOT'] . $grafikaurl;
            if(!is_file($grafikaurl)) {
                $_SESSION['error'] = $_SESSION['error'] . 'Zła ścieżka do pliku!<br>';
                $_SESSION['error'] = $_SESSION['error'] . 'Zły URL: ' . $grafikaurl . '<br>';
                header('Location: ../index.php');
            } else {
                $destname = str_replace(" ", "_", $nazwa) . ".jpg";
                $dest = $folder . $destname;
                $cp = copy($grafikaurl, $dest);
                if(!$cp) {
                    $_SESSION['error'] = $_SESSION['error'] . 'Błąd przy kopiowaniu pliku<br>';
                }
                $filetxt=fopen($txt, "w") or die("Unable to open file!");
                $teikstedwa = "\n" . $nazwa ."\nKolor: " . $kolor . "\nCena: " . $cena;
                if(isset($_POST['komentarz'])) {
                  $comm = mysql_real_escape_string($_POST['komentarz']);
                  $teikstedwa .= "\n\nKomentarz do zamówienia: \n" . $comm;
                }
                fwrite($filetxt, $teikste);
                fwrite($filetxt, $teikstedwa);
                $output = $teikste . "\n" . $teikstedwa;
                $body = $output;
                $body = str_replace("\n", "<br>", $body);
                $subject = "e-chromat - zamowienie nr " . $idzlecenia;
                $from = "noreply@chromat.pl";
                $to = $mail;
                $headers[] = "From:" . $from;
                $headers[] = "MIME-Version: 1.0";
                $headers[] = "Content-Type: text/html; charset=utf-8";
                mail($to,$subject,$body, implode("\r\n",$headers));
                $_SESSION['success']='Złożono zamówienie!' . "<br>" . $nazwa . "<br>Id zlecenia: " . $idzlecenia . "<br><br>Wyślemy Ci maila, kiedy zamówienie będzie gotowe :)";
                    header('Location: ../index.php');
                fclose($filetxt);
            }
          }

    }

    if(isset($_POST['tekstylia'])) {
        $nazwa = mysql_real_escape_string($_POST['prodname']);
        $material = mysql_real_escape_string($_POST['material']);
        $cena = mysql_real_escape_string($_POST['cena']);
        $grafikaurl = mysql_real_escape_string($_POST['foto']);

        if($grafikaurl=="") {
          $_SESSION['error'] = $_SESSION['error']. "Musisz wybrać grafikę<br>";
          header('Location: ../index.php');
        } else {
        $query="INSERT INTO Contract (id_us, rodzaj_zlecenia, cena, data) VALUES ($id_us, '$nazwa', $cena, curdate())";
        mysql_query($query);
        $idzlecenia=mysql_insert_id();
        $foldertmp = "uploads/e-chromat_".$idzlecenia."/";
        $newfolder=mkdir($foldertmp, 0777);
        if(!$newfolder) {
            $_SESSION['error'] = $_SESSION['error'] . 'Błąd przy tworzeniu folderu<br>';
        }
        $folder = $foldertmp . $login . "/";
        $newfolder=mkdir($folder, 0777);
        if(!$newfolder) {
            $_SESSION['error'] = $_SESSION['error'] . 'Błąd przy tworzeniu folderu<br>';
        }
        $txt=$folder . $login . ".txt";

        $grafikaurl = $_SERVER['DOCUMENT_ROOT'] . $grafikaurl;
        if(!is_file($grafikaurl)) {
            $_SESSION['error'] = $_SESSION['error'] . 'Zła ścieżka do pliku!<br>';
            $_SESSION['error'] = $_SESSION['error'] . 'Zły URL: ' . $grafikaurl . '<br>';
            header('Location: ../index.php');
        } else {
            $destname = str_replace(" ", "_", $nazwa) . ".jpg";
            $dest = $folder . $destname;
            $cp = copy($grafikaurl, $dest);
            if(!$cp) {
                $_SESSION['error'] = $_SESSION['error'] . 'Błąd przy kopiowaniu pliku<br>';
            }
            $filetxt=fopen($txt, "w") or die("Unable to open file!");
            if(isset($_POST['kolory'])) {
              $kolor = mysql_real_escape_string($_POST['kolory']);
              $teikstedwa = "\n" . $nazwa . "\nKolor: " . $kolor . "\nCena: " . $cena;
            } else {
              $teikstedwa = "\n" . $nazwa . "\nCena: " . $cena;
            }
            if(isset($_POST['komentarz'])) {
              $comm = mysql_real_escape_string($_POST['komentarz']);
              $teikstedwa .= "\n\nKomentarz do zamówienia: \n" . $comm;
            }
            fwrite($filetxt, $teikste);
            fwrite($filetxt, $teikstedwa);
            $output = $teikste . "\n" . $teikstedwa;
            $body = $output;
            $body = str_replace("\n", "<br>", $body);
            $subject = "e-chromat - zamowienie nr " . $idzlecenia;
            $from = "noreply@chromat.pl";
            $to = $mail;
            $headers[] = "From:" . $from;
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-Type: text/html; charset=utf-8";
            mail($to,$subject,$body, implode("\r\n",$headers));
            $_SESSION['success']='Złożono zamówienie!' . "<br>" . $nazwa . "<br>Id zlecenia: " . $idzlecenia . "<br><br>Wyślemy Ci maila, kiedy zamówienie będzie gotowe :)";
                    header('Location: ../index.php');
            fclose($filetxt);
        }
      }
    }

        // Zmiana hasła
    if (isset($_POST['passcommit'])) {
        $password = mysql_real_escape_string($_POST['pass']);
        $newpass = mysql_real_escape_string($_POST['newpass']);
        $renewpass = mysql_real_escape_string($_POST['renewpass']);
        // Warunki
        if (empty($password)) { $_SESSION['error'] = $_SESSION['error'] . 'Musisz podać stare hasło!<br>'; }
        if (empty($newpass)) { $_SESSION['error'] = $_SESSION['error'] . 'Musisz podać nowe hasło!<br>'; }
        if (empty($renewpass)) { $_SESSION['error'] = $_SESSION['error'] . 'Musisz powtórzyć nowe hasło!<br>'; }

        if (!isset($_SESSION['error'])) {
            $password = md5($password);
            $query="SELECT * FROM User WHERE login='$username' and password='$password'";
            $result=mysql_query($query);
            if (mysql_num_rows($result) == 0) {
                $_SESSION['error'] = $_SESSION['error'] . 'Podałeś złe hasło!<br>'; }
            if($newpass != $renewpass) { $_SESSION['error'] = $_SESSION['error'] . 'Hasła się nie zgadzają!<br>'; }

            $newpass=md5($newpass);
            $query = "UPDATE User SET password='$newpass' where login='$username'";
            $res = mysql_query($query);
            if(!$res) {
                $_SESSION['error'] = $_SESSION['error'] . 'Błąd!<br>';
            }else {
            $_SESSION['success']='Zmieniono hasło!';
                header('Location: ../index.php');
            }
        }
        header('Location: ../index.php');

    }

    // Zmiana danych osobowych
    if (isset($_POST['detcommit'])) {
        $name = mysql_real_escape_string($_POST['name']);
        $surname = mysql_real_escape_string($_POST['surname']);
        $street = mysql_real_escape_string($_POST['street']);
        $houseno = mysql_real_escape_string($_POST['houseno']);
        $city = mysql_real_escape_string($_POST['city']);
        $cicode = mysql_real_escape_string($_POST['cicode']);
        $phoneno = mysql_real_escape_string($_POST['phoneno']);

        $sql = "SELECT id_us from User where login='$username'";
        $tmp = mysql_query($sql);
        $res=mysql_result($tmp,0);

        if (!empty($name)) {
            $query="UPDATE User_Details SET name='$name' where id_us=$res";
            $result=mysql_query($query);
            if($result === FALSE) {
                $_SESSION['error'] = $_SESSION['error'] . 'Błąd wprowadzania! (imię)<br>';
            }
        }

        if (!empty($surname)) {
            $query="UPDATE User_Details SET lastname='$surname' where id_us=$res";
            $result=mysql_query($query);
            if($result === FALSE) {
                $_SESSION['error'] = $_SESSION['error'] . 'Błąd wprowadzania! (nazwisko)<br>';
            }
        }

        if (!empty($street)) {
            $query="UPDATE User_Details SET street='$street' where id_us=$res";
            $result=mysql_query($query);
            if($result === FALSE) {
                $_SESSION['error'] = $_SESSION['error'] . 'Błąd wprowadzania! (ulica)<br>';
            }
        }

        if (!empty($houseno)) {
            $query="UPDATE User_Details SET housenumber='$houseno' where id_us=$res";
            $result=mysql_query($query);
            if($result === FALSE) {
                $_SESSION['error'] = $_SESSION['error'] . 'Błąd wprowadzania! (nr domu)<br>';
            }
        }

        if (!empty($city)) {
            $query="UPDATE User_Details SET city='$city' where id_us=$res";
            $result=mysql_query($query);
            if($result === FALSE) {
                $_SESSION['error'] = $_SESSION['error'] . 'Błąd wprowadzania! (miasto)<br>';
            }
        }

        if (!empty($cicode)) {
            $query="UPDATE User_Details SET citycode='$cicode' where id_us=$res";
            $result=mysql_query($query);
            if($result === FALSE) {
                $_SESSION['error'] = $_SESSION['error'] . 'Błąd wprowadzania! (kod pocztowy)<br>';
            }
        }

        if (!empty($phoneno)) {
            $query="UPDATE User_Details SET cellnumber='$phoneno' where id_us=$res";
            $result=mysql_query($query);
            if($result === FALSE) {
                $_SESSION['error'] = $_SESSION['error'] . 'Błąd wprowadzania! (nr telefonu)<br>';
            }
        }

        if(!isset($_SESSION['error'])) {
            $_SESSION['success']='Zmieniono dane osobowe!';
            header('Location: ../index.php');
        } else
            header('Location: ../index.php');
    }

    if(isset($_POST['delete'])) {
        $login = mysql_real_escape_string($_SESSION['username']);
        $query="select id_us from User where login='$login'";
        $tmp=mysql_query($query);
        $id=mysql_result($tmp, 0);
        $query="DELETE FROM User where id_us=$id";
        $query2="DELETE FROM User_Details where id_us=$id";
        $res=mysql_query($query);
        $res2=mysql_query($query2);

        session_destroy();
        header('Location: ../index.php');
    }

} else {
    if (isset($_POST['reg_user'])) {
        $username = mysql_real_escape_string($_POST['username']);
        $email = mysql_real_escape_string($_POST['email']);
        $password = mysql_real_escape_string($_POST['password']);
        $repassword = mysql_real_escape_string($_POST['repassword']);
        $cellnumber = mysql_real_escape_string($_POST['cellnumber']);
        $name = mysql_real_escape_string($_POST['name']);
        $lastname = mysql_real_escape_string($_POST['lastname']);

        if (empty($username)) { $_SESSION['error'] = $_SESSION['error'] . 'Pole \'Login\' musi być wypełnione!<br>'; }
        if (empty($email)) { $_SESSION['error'] = $_SESSION['error'] . 'Pole \'E-Mail\' musi być wypełnione!<br>'; }
        if (empty($password)) { $_SESSION['error'] = $_SESSION['error'] . 'Pole \'Hasło\' musi być wypełnione!<br>'; }
        if (empty($name)) { $_SESSION['error'] = $_SESSION['error'] . 'Pole \'Imię\' musi być wypełnione!<br>'; }
        if (empty($lastname)) { $_SESSION['error'] = $_SESSION['error'] . 'Pole \'Nazwisko\' musi być wypełnione!<br>'; }

        if (empty($repassword)) { $_SESSION['error'] = $_SESSION['error'] . 'Przepisz hasło!<br>'; }
        $query="SELECT * FROM User WHERE login='$username'";
        $result=mysql_query($query);
        if (mysql_num_rows($result) !== 0) {
            $_SESSION['error'] = $_SESSION['error'] . 'Użytkownik o takim loginie już istnieje!<br>'; }
        $query="SELECT * FROM User WHERE email='$email'";
        $result=mysql_query($query);
        if (mysql_num_rows($result) !== 0) {
            $_SESSION['error'] = $_SESSION['error'] . 'Użytkownik o takim adresie e-mail już istnieje!<br>'; }
        if ($password != $repassword) { $_SESSION['error'] = $_SESSION['error'] . 'Hasła się nie zgadzają!<br>'; }

        if (!isset($_SESSION['error'])) {
            $password = md5($password);
            $query = "INSERT INTO User (login, email, password, id_role)
                      VALUES('$username', '$email', '$password', 2);";
            mysql_query($query);

            $id_us = mysql_insert_id();
            $query2 = "INSERT INTO User_Details (id_us, name, lastname)
              VALUES('$id_us', '$name', '$lastname');";
            mysql_query($query2);

            $_SESSION['success'] = "Możesz się teraz zalogować!";
            header('location: ../index.php');
        } else
            header('location: ../index.php');

    }

    if (isset($_POST['login_user'])) {
        $username = mysql_real_escape_string($_POST['username']);
        $password = mysql_real_escape_string($_POST['password']);

        if (empty($username)) {
            $_SESSION['error'] = $_SESSION['error'] . 'Wymagany Login<br>';
        }
        if (empty($password)) {
            $_SESSION['error'] = $_SESSION['error'] . 'Wymagane hasło<br>';
        }

        if (!isset($_SESSION['error'])) {
            $password = md5($password);
            $query = "SELECT * FROM User WHERE login='$username' AND password='$password'";
             $result = mysql_query($query);
            $query2 = "SELECT * FROM User WHERE email='$username' AND password='$password'";
            $result2 = mysql_query($query2);

            if (mysql_num_rows($result) == 1 or mysql_num_rows($result2)==1) {
		if(mysql_num_rows($result) ==1) {
		  $_SESSION['username'] = $username;
		}
		else {
		  $query = "SELECT login from User where email='$username'";
		  $res = mysql_query($query);
		  $login = mysql_result($res,0);
		  $_SESSION['username'] = $login;
		}
                $_SESSION['success'] = "Zalogowano";
                header('location: ../index.php');
            } else {
                $_SESSION['error'] = $_SESSION['error'] . 'Zły login lub hasło!<br>';
                header('location: ../index.php');
            }
        } else
            header('location: ../index.php');
    }
}

?>
