<p>
    <p>
        Информация о платеже:
    </p>
    <table class="table">
        <tr>
            <td> Пользователь: </td>
            <td> <?php echo $userName ?> </td>
        </tr>
        <tr>
            <td> Товар: </td>
            <td> Бот для мобитвы </td>
        </tr>
        <tr>
            <td> Срок лицензии: </td>
            <td> <?php echo $month ?> мес.</td>
        </tr>
        <tr>
            <td> Стоимость: </td>
            <td> <?php echo $price?> рублей <b>*</b></td>
        </tr>
    </table>
</p>



<?php
//Секретный ключ интернет-магазина
$key = "SXw0bndoVXhITEZGUklBdDR0QjFIckR6e2BL";

$fields = array();

// Добавление полей формы в ассоциативный массив
$fields["WMI_MERCHANT_ID"] = "159351550214";
$fields["WMI_PAYMENT_AMOUNT"] = $price;
$fields["WMI_CURRENCY_ID"] = "643";
$fields["WMI_PAYMENT_NO"] = "12345-001";
$fields["WMI_DESCRIPTION"] = "BASE64:" . base64_encode("Оплата бота для мобитвы");
$fields["WMI_EXPIRED_DATE"] = date('Y-m-d').'T'.date("H:i:s");
$fields["WMI_SUCCESS_URL"] = "mobitva-bot.ru" . url_for('@success');
$fields["WMI_FAIL_URL"] = "mobitva-bot.ru" . url_for('@fail');
$fields["user_id"] = $userId;                   // Дополнительные параметр: id пользователя
$fields["month_count"] = $month;                // Дополнительные параметр: количество месяцев
$fields["username"] = $userName;                // Дополнительные параметр: имя пользователя
$fields["transactionKey"] = $transactionKey;    // Дополнительные параметр: уникальный ключ транзакции

//Если требуется задать только определенные способы оплаты, раскоментируйте данную строку и перечислите требуемые способы оплаты.
$fields["WMI_PTENABLED"] = array(
    "WebMoneyRUB",
    "CashTerminal",
    "VISA",
    "MegafonRUB",
    "MtsRUB"
);

//Сортировка значений внутри полей
foreach ($fields as $name => $val) {
    if (is_array($val)) {
        usort($val, "strcasecmp");
        $fields[$name] = $val;
    }
}


// Формирование сообщения, путем объединения значений формы, 
// отсортированных по именам ключей в порядке возрастания.
uksort($fields, "strcasecmp");
$fieldValues = "";

foreach ($fields as $value) {
    if (is_array($value))
        foreach ($value as $v) {
            //Конвертация из текущей кодировки (UTF-8)
            //необходима только если кодировка магазина отлична от Windows-1251
            $v = iconv("utf-8", "windows-1251", $v);
            $fieldValues .= $v;
        } else {
        //Конвертация из текущей кодировки (UTF-8)
        //необходима только если кодировка магазина отлична от Windows-1251
        $value = iconv("utf-8", "windows-1251", $value);
        $fieldValues .= $value;
    }
}

// Формирование значения параметра WMI_SIGNATURE, путем 
// вычисления отпечатка, сформированного выше сообщения, 
// по алгоритму MD5 и представление его в Base64

$signature = base64_encode(pack("H*", md5($fieldValues . $key)));

//Добавление параметра WMI_SIGNATURE в словарь параметров формы

$fields["WMI_SIGNATURE"] = $signature;

// Формирование HTML-кода платежной формы

print "<form action=\"https://merchant.w1.ru/checkout/default.aspx\" method=\"POST\">";

foreach ($fields as $key => $val) {
    if (is_array($val))
        foreach ($val as $value) {
            print "<input type=\"hidden\" name=\"$key\" value=\"$value\"/>";
        }
    else
        print "<input type=\"hidden\" name=\"$key\" value=\"$val\"/>";
}

print "<input type=\"submit\"/ value=\"Продолжить\" class=\"btn\"></form>";
?>
<div class="alert alert-danger">
    * Фактическая стоимость будет зависеть от способа оплаты<br />
</div>
