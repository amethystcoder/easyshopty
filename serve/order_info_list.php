<?php
session_start();
try {
    //code...
    $order_id = $_POST["id"];
} catch (\Throwable $th) {
    //throw $th;
}
#how it looks in frontend
/* 
success: function (res) {
                    res = JSON.parse(res)
                    var data = res.data;
                    if (res.code == 0) {
                        var html = '';
                        for (var i = 0; i < data.length; i++) {
                            html += '<div class="records_tabs_box">\n' +
                                '<div class="records_tabs_box_top">time to rush an order:&nbsp;\n' +
                                '    <span>' + data[i].addtime + '</span>\n' +
                                '    <br>order number&nbsp;<span>' + data[i].oid + '</span>\n' +
                                '</div>\n' +
                                '<div class="records_tabs_box_des">\n' +
                                '    <div class="tabs_box_des_img">\n' +
                                '        <img src="' + data[i].goods_pic + '"></div>\n' +
                                '    <div class="tabs_box_des_r">\n' +
                                '        <p class="tabs_box_des_r_tit" style="max-height: 95px;">' +
                                data[i].goods_name + '</p>\n' +
                                '        <div class="tabs_box_des_r_pic" style="display: none"><p>' +
                                data[i].goods_price + '</p><p> x ' + data[i].goods_count + '</p></div>\n' +
                                '    </div>\n' +
                                '</div>\n' +
                                '<div class="row mt-3">\n' +
                                '    <div class="col text-left">Total order</div>\n' +
                                '    <div class="col-auto text-right text-mute">' + data[i].num + '</div>\n' +
                                '</div>\n' +
                                '<div class="row mt-3">\n' +
                                '    <div class="col text-left">commission</div>\n' +
                                '    <div class="col-auto text-right txt1"><span id="yongjin">' +
                                data[i].commission + '</span></div>\n' +
                                '</div>\n' +
                                '</div>'
                        }
                        $('#orderListInfo').html(html);

*/

?>