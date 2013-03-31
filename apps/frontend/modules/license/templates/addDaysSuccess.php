<div class="h-container">
  <h2><?php echo ($license) ? "Продлить" : "Купить"; ?> лицензию</h2>
</div>
<br />

<div style="margin-left: 50px;">
  <div class="alert" style="">На какой промежуток времени желаете <?php echo ($license) ? "продлить" : "купить"; ?> лицензию?</div>
  <table class="bye-table">
    <tr>
      <td>
        стоимость:
      </td>
      <td>
        <?php $botPrice = (!$preEnd) ? sfConfig::get('app_bot_price') : sfConfig::get('app_bot_price') * (100 - (int) sfConfig::get('app_bot_pre_end_discount')) / 100; ?>
        <input class="input-xlarge disabled" id="price" type="text" disabled="" value="<?php echo $botPrice; ?>"style="width: 40px;"/> рублей
      </td>
      <td>
        <?php if ($preEnd): ?>
          (с учетом скидки <?php echo sfConfig::get('app_bot_pre_end_discount'); ?>% за своевременное продление лицензии)
        <?php endif; ?>
      </td>
    </tr>
    <tr>
      <td>
        срок:
      </td>
      <td>
        <select id="selectMonth" name="mounth" style="width: 80px;">

          <?php for ($i = 1; $i <= 24; $i++): ?>
            <option value="<?php echo $i ?>"><?php echo $i ?></option>
          <?php endfor; ?>
        </select> мес.
      </td>
      <td>
        <form method="post" action="<?php echo url_for('@add_days') ?>">
          <input type="hidden" id="month" name="month" value="1"/>

          <input type="submit" id="submit_button" value="<?php echo ($license) ? "Продлить" : "Купить"; ?>" class="btn btn-primary"/>
          <div id="no_money_message" class="alert alert-danger">
            <?php echo sfConfig::get('app_bot_message_need_more_money'); ?>
          </div>
        </form>
      </td>
    </tr>

  </table>
</div>

<div class="alert alert-info">
  Покупка/продление лицензии.<br />
  Для того чтобы начать пользоваться ботом вам нужно купить лицензию.<br />
  Бот будет работать, пока не истек срок, на который покупается лицензия<br />
  Вы можете продлить лицензию в любое время.<br />
  Если продлить лицензию до итечения срока, по вы получите скидку в 10%, 
  дата окончания будет пересчитана с учетом неизрасходованных дней.
</div>

<?php $ballance = $sf_user->getGuardUser()->getProfile()->getBalance(); ?>

<script type="text/javascript">
    
  var discount = <?php echo ($preEnd) ? (int) sfConfig::get('app_bot_pre_end_discount') : 0; ?>;
  var user_balance = <?php echo empty($ballance) ? '0' : $ballance; ?>;
  
  (function(){
    
    $('#no_money_message').hide();
    
    if (user_balance - $('#price').val() < 0){
      $('#submit_button').hide();
      $('#no_money_message').show();
    }
    
    $('#selectMonth').on('change',function(){
      var mounth = $(this).val();
      var price = 0;
      var persents = 1;
      var koef_persents = 0;
    
      for (var i=0;i<mounth;i++){
        var k = (1 - 0.05*i);
        if (k < 0.3){
          k = 0.3;
        }
        price += <?php echo sfConfig::get('app_bot_price'); ?> * k;

      }
      
      price = price * (100 - discount)/100;
    
      $('#price').val(price);
      $('#month').val(mounth);
      
      if (user_balance - $('#price').val() < 0){
        $('#submit_button').hide();
        $('#no_money_message').show();
      }else{
        $('#submit_button').show();
        $('#no_money_message').hide();
      }
    });
        
  })();

</script>