<div class="h-container">
    <h2>Продлить лицензию</h2>
</div>
<br />



<div style="margin-left: 50px;">
    <div class="alert" style="">На какой промежуток времени желаете продлить лицензию?</div>
    <table class="bye-table">
        <tr>
            <td>
                стоимость:
            </td>
            <td>
                <input class="input-xlarge disabled" id="price" type="text" disabled="" value="45"style="width: 40px;"/> рублей
            </td>
            <td>

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
                <form method="post" action="<?php echo url_for('@confirm')?>">
                    <input type="hidden" name="month" value="1"/>
                    <input type="submit" value="Продолжить" class="btn btn-primary" style="margin-top: -30px;">
                </form>
            </td>
        </tr>

    </table>
</div>


<script type="text/javascript">
    
    (function(){
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
                price += 45 * k;

            }
    
            $('#price').val(price);
        });
        
    })();

</script>