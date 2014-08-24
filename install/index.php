<?php
/*
 *  © BitcoinDice 


 
*/


if (isset($_GET['checkCons'])) {
  if (@!mysql_connect($_POST['db_host'],$_POST['db_user'],$_POST['db_pass']) || @!mysql_select_db($_POST['db_name'])) {
    header('Location: ./?step=3&db');
    exit();
  }

  $included_=true;
  include 'db_data.php';
  
  $db_file=fopen('../inc/db-conf.php','wb');
  fwrite($db_file,"<?php \n");          
  fwrite($db_file,'$conf_c=true;'."\n");          
  fwrite($db_file,'mysql_connect(\''.$_POST['db_host'].'\',\''.$_POST['db_user'].'\',\''.$_POST['db_pass'].'\');'."\n");
  fwrite($db_file,'mysql_select_db(\''.$_POST['db_name'].'\');'."\n");
  fwrite($db_file,'mysql_query("SET NAMES utf8");'."\n");
  fwrite($db_file,"?>");      ?><?php
  fclose($db_file);

  $w_file=fopen('../inc/driver-conf.php','wb');
  fwrite($w_file,"<?php \n");          
  fwrite($w_file,'$driver_login=\'http://'.$_POST['w_user'].':'.$_POST['w_pass'].'@'.$_POST['w_host'].':'.$_POST['w_port'].'/\';'."\n");
  fwrite($w_file,"?>");      ?><?php
  fclose($w_file);

  header('Location: ./?step=4');
  exit();
}

if (isset($_GET['saveB'])) {
  include '../inc/db-conf.php';
  mysql_query("UPDATE `system` SET `title`='$_POST[s_title]',`url`='$_POST[s_url]',`currency`='$_POST[s_cur]',`currency_sign`='$_POST[s_cur_sign]',`description`='$_POST[s_desc]' WHERE `id`=1");
  header('Location: ./?step=5');
  exit();
}

if (empty($_GET['step']) || ($_GET['step']!=1 && $_GET['step']!=2 && $_GET['step']!=3 && $_GET['step']!=4 && $_GET['step']!=5 && $_GET['step']!=6)) {
  header('Location: ./?step=1');
  exit();
}
else $step=$_GET['step'];

if ($step==3 && (!is_writable('../inc/db-conf.php') || !is_writable('../inc/driver-conf.php'))) {
  header('Location: ./?step=2');
  exit();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>BitcoinDice 1.0 - Instalator</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./install_page.css">
    <link rel="shortcut icon" href="./favicon.ico">
    <script type="text/javascript" src="jquery.js"></script>
  </head>
  <body>
    <div class="allbody">
      <div class="alls" style="text-align: center;">
        <h1>BitcoinDice 1.0 Instalacja</h1>
      </div>
    </div>
    <?php
    switch ($step) {
      case 1:
      ?>
        <script type="text/javascript">
          function next() {
            window.location.href='./?step=2';
          }
        </script>
        <div class="allbody">
          <div class="alls">
            <h3>Witamy!</h3>
            To jest automatyczny skrypt instalacyjny. Proszę, postępuj według instrukcji wyświetlanych w kolejnych krokach.
          </div>
        </div>
      <?php
      break;
      case 2:
      ?>
        <script type="text/javascript">
          function next() {
            window.location.href='./?step=3';
          }
        </script>
        <div class="allbody">
          <div class="alls">
            <h3>Uprawnienia plików</h3>
            Upewnij się, że pliki mają prawa zapisu (chmod 777):
            <br>
            <table>
              <tr>
                <td><i>inc/db-conf.php</i></td>
                <td>&nbsp;&nbsp;</td>
                <td><?php if (is_writable('../inc/db-conf.php')) { echo '<span style="color: green;"><b>Yes</b></span>'; } else { echo '<span style="color: red;"><b>No</b></span>'; } ?></td>
              </tr>
              <tr>
                <td><i>inc/driver-conf.php</i></td>
                <td>&nbsp;&nbsp;</td>
                <td><?php if (is_writable('../inc/driver-conf.php')) { echo '<span style="color: green;"><b>Yes</b></span>'; } else { echo '<span style="color: red;"><b>No</b></span>'; } ?></td>
              </tr>
            </table>
            <br>
            Powyższe pliki powinny być zapisywalne, w przeciwnym razie instalacja nie będzie kontynuowana!
          </div>
        </div>
      <?php
      break;
      case 3:
      ?>
        <script type="text/javascript">
          function next() {
            $.ajax({
              'url': './db_test_call.php?db_user='+$("input#db_user").val()+'&db_pass='+$("input#db_pass").val()+'&db_host='+$("input#db_host").val()+'&db_db='+$("input#db_db").val(),
              'dataType': "json",
              'success': function(data) {
                if (data['error']=='no') checkWallet();
                else alert('Database error! Can\'t connect to database! Please check if provided informations are correct and try again.');
              }
            });
          }
          function checkWallet() {
            $.ajax({
              'url': './driver_test_call.php?w_user='+$("input#w_user").val()+'&w_pass='+$("input#w_pass").val()+'&w_host='+$("input#w_host").val()+'&w_port='+$("input#w_port").val(),
              'dataType': "json",
              'success': function(data) {
                document.getElementById('mform').submit();
              },
              'error': function() {
                alert('Wallet error! Can\'t connect to wallet! Please check if provided informations are correct and try again.');
              }
            });
          }
        </script>
        <div class="allbody">
          <div class="alls">
            <form id="mform" method="post" action="./?checkCons">
              <h3>Baza Danych</h3>
              <i>Proszę o wpisanie poprawnych informacji o bazie danych:</i>
              <br>
              <table>
                <tr>
                  <td>Host:</td>
                  <td><input type="text" name="db_host" id="db_host" value="localhost"></td>
                </tr>
                <tr>
                  <td>użytkownik:</td>
                  <td><input type="text" name="db_user" id="db_user" placeholder="DB user"></td>
                </tr>
                <tr>
                  <td>Hasło:</td>
                  <td><input type="text" name="db_pass" id="db_pass" placeholder="DB pass"></td>
                </tr>
                <tr>
                  <td>Database:</td>
                  <td><input type="text" name="db_name" id="db_db" placeholder="DB name"></td>
                </tr>
              </table>
              
              <h3>Informacje o Portfelu</h3>
              <i>Proszę o podanie poprawnych danych o portfelu:</i>
              <br>
              <table>
                <tr>
                  <td>Host:</td>
                  <td><input type="text" name="w_host" id="w_host" value="localhost"></td>
                </tr>
                <tr>
                  <td>Login:</td>
                  <td><input type="text" name="w_user" id="w_user" placeholder="Wallet user"></td>
                </tr>
                <tr>
                  <td>Hasło:</td>
                  <td><input type="text" name="w_pass" id="w_pass" placeholder="Wallet password"></td>
                </tr>
                <tr>
                  <td>Port:</td>
                  <td><input type="text" name="w_port" id="w_port" placeholder="Wallet port"></td>
                </tr>
              </table>
            </form>
          </div>
        </div>
      <?php
      break;
      case 4:
      ?>
        <script type="text/javascript">
          function next() {
            document.getElementById('mform').submit();
          }
        </script>
        <div class="allbody">
          <div class="alls">
            <h3>Ustawienia podstawowe</h3>
            <br>
            <form id="mform" action="./?saveB" method="post">
              <table>
                <tr>
                  <td>Tytuł Strony:</td>
                  <td><input type="text" name="s_title"></td>
                </tr>
                <tr>
                  <td>Opis Strony:</td>
                  <td><input type="text" name="s_desc"></td>
                </tr>
                <tr>
                  <td>URL:</td>
                  <td><input type="text" name="s_url"></td>
                  <td>(<b>without <i>http://</i></b>)</td>
                </tr>
                <tr>
                  <td>Waluta:</td>
                  <td><input type="text" name="s_cur" value="Bitcoin" disabled></td>
                </tr>
                <tr>
                  <td>Symbol Waluty:</td>
                  <td><input type="text" name="s_cur_sign" value="BTC" disabled></td>
                </tr>
              </table>
            </form>
          </div>
        </div>
      <?php
      break;
      case 5:
      ?>
        <script type="text/javascript">
          function next() {
            window.location.href='./?step=6';
          }
        </script>
        <div class="allbody">
          <div class="alls">
            <h3>konfiguracja CRON</h3>
            Aby BitCoinDice mógł działać poprawnie, musisz mieć CRON ustawionego w ten sposób:
            <br><br>
            <b>Co 1 minute</b>: <i>content/cron/check_deposits.php</i>
            <br><br><hr>
            <b>Przykład (Linux):</b>
            <br><br>
            1) <i>Otwórz CRON table:</i>
            <br>
            $ crontab -e
            <br><br>
            2) <i>Dodaj poniższą linie:</i>
            <br>
            * * * * * cd /var/www/content/cron; php check_deposits.php;
            <br><br>
            3) Zapisz zadanie CRONA przyciskając <b>CTRL</b>+<b>X</b>, następnie potwierdź (<b>Y</b>) i wciśnij <b>enter</b>.
            <br><br>
            4) Restart zadań CRON-a:
            <br>
            $ service cron restart
            <br><br>
            To wszystko.            
             
          </div>
        </div>
      <?php
      break;
      case 6:
      ?>
        <div class="allbody">
          <div class="alls">
            <h3>Thank You!</h3>
            <br>
            Instalacja jest zakończona! Możesz zalogować się do panelu administracji lub spróbować szczęścia w swojej własnej stronie hazardowej:-) 
            <br>
            <br>
            Informacje o Administratorze:<br>
            &nbsp;Użytkownik: <b>admin</b><br>
            &nbsp;Hasło: <b>admin</b>
            <br>
            <br>
            <i>Nie zapomnij, aby zmienić te informacje przy pierwszym logowaniu!</i>
            <br>
            <br>
            <b>Ostrzeżenie!</b> Proszę usunąć katalog <i>/install</i> teraz, w przeciwnym razie istnieje zagrożenie dla bezpieczeństwa strony.
          </div>
        </div>
      <?php        
      break;
    }
    ?>    
    <div class="allbody">
      <div class="alls" style="padding: 5px; height: 30px;">
        <div style="float: left; font-style: italic;">
          <h2>Step: <?php echo $step; ?></h2>
        </div>
        <div style="float: right;">
          <?php
          if ($step==6) echo '<input id="next" type="button" onclick="javascript:window.location.href=\'../admin/\';" value="Go to Admin!" style="padding: 5px;">';
          else echo '<input id="next" type="button" onclick="javascript:next();" value="Next ->" style="padding: 5px;">';
          ?>
        </div>
      </div>
    </div>
    <?php
    if ($step==3 && isset($_GET['db'])) echo '<script type="text/javascript">alert("Can\'t connect to database! Please check if provided informations are correct and try again.");</script>';
    ?>
  </body>
</html>
