<?php
/*
 *  © BitcoinDice 


 
*/

if (!isset($included)) exit();

if (isset($_POST['addons_form']))
    echo '<div class="zpravagreen"><b>Success!</b> Data was successfuly saved.</div>';  

?>
<h1>Dodatki</h1>
<form method="post" action="./?p=addons">
  <input type="hidden" name="addons_form" value="1">
  <fieldset>
    <legend>Czat</legend>
    <input type="checkbox" value="1"<?php if ($settings['chat_enable']==1) echo ' checked="checked"'; ?> id="chat_chckbx" name="chat_enable">
    <label for="chat_chckbx" class="chckbxLabel">Enable</label>
  </fieldset>
  <fieldset style="margin-top: 10px;">
    <legend>Zakłady automatyczne</legend>
    <input type="checkbox" value="1"<?php if ($settings['bot_enable']==1) echo ' checked="checked"'; ?> id="bot_chckbx" name="bot_enable">
    <label for="bot_chckbx" class="chckbxLabel">Enable</label>
  </fieldset>
  <fieldset style="margin-top: 10px;">
    <legend>Darmowe Monety (gratisy)</legend>
    <table style="border: 0; border-collapse: collapse;">
      <tr>
        <td style="padding: 0;">
          <input type="checkbox" value="1"<?php if ($settings['giveaway']==1) echo ' checked="checked"'; ?> id="giveaway" name="giveaway">
          <label for="giveaway" class="chckbxLabel">Enable</label>
        </td>
        <td style="padding-left: 40px;">
          <table style="border: 0; border-collapse: collapse;">
            <tr>
              <td>Ilość:</td>
              <td>
                <input type="text" name="giveaway_amount" value="<?php echo $settings['giveaway_amount']; ?>"> <?php echo $settings['currency_sign']; ?><br>
              </td>
            </tr>
            <tr>
              <td>Częstotliwość:</td>
              <td>
                <input type="text" name="giveaway_freq" value="<?php echo $settings['giveaway_freq']; ?>"> s &nbsp;&nbsp;<small><i>Minimal time between requests</i></small>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <small>
      <i>
        <b>Note:</b> Aby aktywować dodatek gratisów wymagane jest zainstalowanie biblioteki <b>GD lib</b> (php5-gd).  W przeciwnym razie, ten dodatek nie będzie działał poprawnie.
      </i>
    </small>
  </fieldset>
  <input type="submit" value="Save" style="margin-top: 10px;">
</form>
