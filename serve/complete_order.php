<?php

    session_start();
    $user_id = $_SESSION["user_id"];
    $order_id = $_POST["oid"];
    $user_status = $_POST["status"];
#how it looks in frontend
/* url: "../serve/complete_order",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                oid: oid,
                                status: 2,
                                add_id: add_id, //optional
                                to_name: to_name,//optional
                                aid: aid//optional
                            },
                            success: function (res) {
                                layer.closeAll();
                                if (res.code == 0) {
                                    $(document).dialog({
                                        infoText: "Ordem Cancela o sucesso!",
                                        autoClose: 2000
                                    });
                                    $('#orderDetail').modal('hide');
                                } else {
                                    $(document).dialog({
                                        type: 'alert',
                                        titleText: res.info,
                                        buttonTextConfirm: "OK",
                                        autoClose: 0,
                                        onClosed: function (e) {
                                            if (res.url) window.location.href = res.url;
                                        }
                                    });
                                }
                                sumbit = true;
                            },
                            error: function (err) {
                                console.log(err);
                                sumbit = true;
                            }
                        });
                    },
                    onClickCancelBtn: function () {

                    }
                }); */

?>