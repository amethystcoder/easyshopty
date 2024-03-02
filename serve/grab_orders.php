<?php
#how it looks in front end
/* url: "./grab_orders.php" + '?cid=' + cid + '&reCAPTCHA=' + token + '&v=' + v + '&m=' + Math.random() + "&real=" + real,
                    type: 'POST',
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        loading.close();
                        $('#autoStart').text("start grabbing orders");
                        $(document).dialog({
                            infoText: "failed to grab the order, please try again later!",
                            autoClose: 2000
                        });
                    },
                    success: function (data) {
                        loading.close();
                        $('#autoStart').text("start grabbing orders");
                        if (data.code == 1) {
                            loading.close();
                            if (data.image) {
                                $(document).dialog({
                                    type: 'alert',
                                    titleShow: false,
                                    dialogClass: "no-padding-alert",
                                    content: "<img style='max-width: 100%' src='" + data.image + "'>",
                                    buttonTextConfirm: "OK",
                                    autoClose: 0,
                                    onClosed: function () {
                                        start(token, 1, 1);
                                    }
                                });
                            } else {
                                $(document).dialog({
                                    type: 'alert',
                                    titleText: data.info,
                                    buttonTextConfirm: "OK",
                                    autoClose: 0,
                                    onClosed: function () {
                                        if (data.url) window.location.href = data.url;
                                    }
                                });
                            }
                        } else if (data.code == 0 && data.oid) {
                            loading.close();
                            palySong(1);
                            sessionStorage.setItem('oid', data.oid);
                            $(document).dialog({
                                infoText: data.info
                            });
                            qdSuccess(data.oid);
                            oid = data.oid;
                            add_id = data.add_id;
                        } else {
                            loading.close();
                            if (data.info) {
                                $(document).dialog({
                                    infoText: data.info,
                                });
                            } else {
                                $(document).dialog({
                                    infoText: "A rede não é estável, por favor, tente novamente em um bom sinal!"
                                });
                            }
                        }
                    }
                });
            } else {
                countdown--;
                setTimeout(function () {
                    start(token, v)
                }, 1000);
            }
        } */
?>