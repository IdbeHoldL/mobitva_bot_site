<div class="h-container">
  <h2>Увеличить макс. количество копий для запуска одновременно</h2>
</div>
<br />

<div style="margin-left: 50px;">
  <div class="alert" style="">Сколько добавить?</div>
  <table class="bye-table">
    <tr>
      <td>
        стоимость:
      </td>
      <td>
        <?php $charPrice = sfConfig::get('app_bot_add_char_price'); ?>
        <?php $mounthPrice = sfConfig::get('app_bot_add_char_mounts_price'); ?>
        <input class="input-xlarge disabled" id="price" type="text" disabled="" value="<?php echo ($charPrice + $mounthPrice) * 0.98; ?>"style="width: 40px;"/> рублей
      </td>
      <td>
      </td>
    </tr>
    <tr>
      <td>
        Количество копий:
      </td>
      <td>
        <select id="selectChars" name="chars" style="width: 80px;">
          <?php for ($i = 0; $i < 9; $i++): ?>
            <option value="<?php echo $i + 1; ?>"><?php echo $i + 1; ?></option>
          <?php endfor; ?>
          <?php for ($i = 0; $i < 5; $i++): ?>
            <option value="<?php echo ($i + 1) * 10; ?>"><?php echo ($i + 1) * 10; ?></option>
          <?php endfor; ?>
        </select>
      </td>
      <td>
      </td>
    </tr>

    <tr>
      <td>
        Срок:
      </td>
      <td>
        <select id="selectMonth" name="mounth" style="width: 80px;">
          <?php for ($i = 0; $i < 24; $i++): ?>
            <option value="<?php echo $i + 1; ?>"><?php echo $i + 1; ?></option>
          <?php endfor; ?>
        </select>
        мес.
      </td>
      <td>
        <form method="post" action="<?php echo url_for('@add_chars') ?>">
          <input type="hidden" id="chars_count" name="chars_count" value="1"/>
          <input type="hidden" id="month_count" name="month_count" value="1"/>
          <input type="submit" id="submit_button" value="Купить" class="btn btn-primary"/>
          <div id="no_money_message" class="alert alert-danger">
            <?php echo sfConfig::get('app_bot_message_need_more_money'); ?>
          </div>
        </form>
      </td>
    </tr>

  </table>
</div>

<div class="alert alert-info">
  Данный параметр непосредственно влияет на ограничение количества копий скрипта, 
  запущенных одновременно.<br />
  Это, своего рода, расширение основной лицензии. Покупается на заданный срок,
  по истечению которого, ограничение вернется в значение по уполчанию.<br />
</div>

<?php $ballance = $sf_user->getGuardUser()->getProfile()->getBalance(); ?>

<script type="text/javascript">
    
  var user_balance = <?php echo empty($ballance) ? '0' : $ballance; ?>;
  
  (function(){
    
    var bot_add_char_price = <?php echo sfConfig::get('app_bot_add_char_price'); ?>;
    var bot_add_char_mounth_price = <?php echo sfConfig::get('app_bot_add_char_mounts_price'); ?>;
    
    $('#no_money_message').hide();
    
    if (user_balance - parseFloat($('#price').val()) < 0){
      console.log(user_balance);
      console.log(parseFloat($('#price').val()));
      $('#submit_button').hide();
      $('#no_money_message').show();
    }
    
    $('#selectChars, #selectMonth').on('change',function(){
      
      var chars_count = $('#selectChars').val();
      var month_count = $('#selectMonth').val();
      
      var price = 0;
     
      price += getPrice(bot_add_char_price, chars_count);
      price += chars_count * getPrice(bot_add_char_mounth_price, month_count);
      
      var bonus_for_count = chars_count * 0.01;
      var bonus_for_month = month_count * 0.01; 
      
      bonus_for_count = (bonus_for_count < 0.17) ? bonus_for_count : 0.17;
      bonus_for_month = (bonus_for_month < 0.17) ? bonus_for_month : 0.17;
      
      price = price * (1-(bonus_for_month+bonus_for_count));
      

      $('#price').val(price);
      $('#chars_count').val(chars_count);
      $('#month_count').val(month_count);
      
      if (user_balance - $('#price').val() < 0){
        $('#submit_button').hide();
        $('#no_money_message').show();
      }else{
        $('#submit_button').show();
        $('#no_money_message').hide();
      }
    });
        
  })();
  
  function getPrice(price, count){
    var result_price = 0;
    var persents = 1;
    var koef_persents = 0;
    
    for (var i=0; i<count; i++){
      var k = (1 - 0.05*i);
      if (k < 0.3){
        k = 0.3;
      }
      result_price += price * k;
    }
    
    return result_price;
  }

</script>