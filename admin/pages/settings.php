<?php
/*
 *  © BitcoinDice 


 
*/

if (!isset($included)) exit();

if (isset($_POST['s_title'])) {
  if (!empty($_POST['s_title']) && !empty($_POST['s_url']) && !empty($_POST['s_desc']) && !empty($_POST['cur']) && !empty($_POST['cur_s']) && isset($_POST['bet_fr_players']) && is_numeric((int)$_POST['bet_fr_players']) && isset($_POST['bet_fr_bots']) && is_numeric((int)$_POST['bet_fr_bots']) && isset($_POST['house_edge']) && is_numeric((double)$_POST['house_edge']) && isset($_POST['min_withdrawal']) && is_numeric((double)$_POST['min_withdrawal']) && isset($_POST['txfee']) && is_numeric((double)$_POST['txfee']) && isset($_POST['bankroll_maxbet_ratio']) && is_numeric((double)$_POST['bankroll_maxbet_ratio'])) {
    echo '<div class="zpravagreen"><b>Powodzenie!</b> Dane zostały pomyslnie zapisane.</div>';  
  }
  else {
    echo '<div class="zpravared"><b>Błąd!</b> Jedno z pól jest puste.</div>';
  }
}

?>

<h1>Ustawienia</h1>
<br>
<form action="./?p=settings" method="post">
  <table>
    <tr>
      <td>Aktywna skórka:</td>
      <td>
        <select name="acttheme">
          <?php
            $tdir=opendir('../themes/');
            while (false!==($ctheme=readdir($tdir))) {
              $ifselected='';
              if ($ctheme=='.' || $ctheme=='..') continue;
              if (file_exists('../themes/'.$ctheme.'/main.css') && file_exists('../themes/'.$ctheme.'/frontpage.php'))
                if ($ctheme==$settings['activeTheme']) $ifselected=' selected="selected"';
                echo '<option value="'.$ctheme.'"'.$ifselected.'>'.$ctheme."\r\n";
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td style="width: 180px;">Tytuł strony:</td>
      <td style="width: 200px;"><input type="text" name="s_title" value="<?php echo $settings['title']; ?>"></td>
    </tr>
    <tr>
      <td>Adres URL:</td>
      <td><input type="text" name="s_url" value="<?php echo $settings['url']; ?>"></td>
      <td><small><i>Bez <b>http://</b>.</i></small></td>
    </tr>
    <tr>
      <td>Opis strony:</td>
      <td><input type="text" name="s_desc" value="<?php echo $settings['description']; ?>"></td>
    </tr>
    <tr>
      <td>Waluta:</td>
      <td><input type="text" name="cur" value="<?php echo $settings['currency']; ?>"></td>
    </tr>
    <tr>
      <td>Symbol Waluty:</td>
      <td><input type="text" name="cur_s" value="<?php echo $settings['currency_sign']; ?>"></td>
    </tr>
    <tr>
      <td>Bet freq. (players):</td>
      <td><input title="0 = unlimited" type="text" name="bet_fr_players" value="<?php echo $settings['rolls_mintime']; ?>"> ms</td>
      <td><small><i>Minimalna przerwa między zakładami w <b>milisekundach</b>.</i></small></td>
    </tr>
    <tr>
      <td>Bet freq. (bots):</td>
      <td><input title="0 = unlimited" type="text" name="bet_fr_bots" value="<?php echo $settings['rolls_mintime_bB']; ?>"> ms</td>
      <td><small><i>Minimalna przerwa między zakładami w <b>milisekundach</b>.</i></small></td>
    </tr>
    <tr>
      <td>House edge:</td>
      <td><input type="text" name="house_edge" value="<?php echo $settings['house_edge']; ?>"> %</td>
      <td><small><i>Przybliżona zysk z łącznej kwoty postawionej.</i></small></td>
    </tr>
    <tr>
      <td>Minimal withdrawal:</td>
      <td><input type="text" name="min_withdrawal" value="<?php echo $settings['min_withdrawal']; ?>"> <?php echo $settings['currency_sign']; ?></td>
    </tr>
    <tr>
      <td>Opłata transakcyjna</td>
      <td><input type="text" name="txfee" value="<?php $infofee=$wallet->getinfo(); echo $infofee['paytxfee']; ?>"> <?php echo $settings['currency_sign']; ?></td>
      <td><small><i>Opłata transakcyjna dla <?php echo $settings['currency']; ?> sieci.</i></small></td>
    </tr>
    <tr>
      <td>Bankroll/max bet ratio</td>
      <td><input type="text" name="bankroll_maxbet_ratio" value="<?php echo $settings['bankroll_maxbet_ratio']; ?>"></td>
      <td><small><i>Wskaźnik domyślny pomiędzy kwotą w portfelu i max dostępnej zakładu jest ustawiony na 25. Tak więc na przykład, jeśli chcesz, aby umożliwić graczom obstawiać 1 <?php echo $settings['currency_sign']; ?>, trzeba mieć 25 <?php echo $settings['currency_sign']; ?> w portfelu.</i></small></td>
    </tr> 
    <tr>
      <td></td>
      <td><input type="submit" value="Save"></td>
    </tr>
  </table>
</form>
