<?php

`"price": price,
"id": id,
"type": type`;

`
setTimeout(function () {
    if (next_url) {
        var join = '?';
        if (next_url.indexOf('?') > -1) {
            join = '&'
        }
        var url = next_url + join + 'num=' + data.info.num + '&id=' + id + '&payer_name=' + payer_name + '&payer_bank=' + payer_bank + '&payer_cardno=' + payer_cardno + '&payer_name=' + payer_name + '&payer_mobile=' + payer_mobile + '&payer_upi=' + payer_upi + '&payer_email=' + payer_email + "&vip_id=" + vip_id + "&type=" + type2;
        if (next_url.indexOf('paydragon') > -1 || next_url.indexOf('recharge2') > -1) {
            window.location.href = url;
        } else {
            window.location.href = url;
        }
    } else {
        window.location.href = '/index/ctrl/recharge2?num=' + data.info.num + '&type=' + type + "&vip_id=" + vip_id;
    }
},
    1500);
`;


?>