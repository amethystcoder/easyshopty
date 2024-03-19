let currentUser = false

function grade_user(user) {
    if (user && typeof user == "string") {
        fetch(`../serve/admin_get_user.php?user_id=${user}`)
        .then(Response => Response.json())
        .then(result =>{
            let body = document.querySelector("body")
            let modal = `
                <div class="layui-layer layui-layer-page" id="layui-layer4" type="page" times="4" showtime="0" contype="string"
                style="z-index: 19891018; width: 800px; top: 61px; left: 20vw;">
            <div class="layui-layer-title" style="cursor: move;">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">Edit level</font>
                </font>
            </div>
            <div id="" class="layui-layer-content">
            <div class="layui-form layui-card" novalidate="novalidate">
            <div class="layui-card-body">
                <div class="layui-form-item"><label class="layui-form-label label-required">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">membership level</font>
                        </font>
                    </label>
                    <div class="layui-input-block">
                        <div class="layui-unselect layui-form-select">
                        <div class="layui-select-title">
                            <input type="text" id="user-stat-edit" readonly=""
                            placeholder="please choose" value="${result.data.user_status}" class="layui-input layui-unselect">
                            </div>
                            <div style="display:flex">
                                <p>Please choose one</p>
                                <button style="background-color: green;color:white;
                                border:hidden;border-radius:10px;padding:10px;margin:10px" 
                                onclick="change_stat('VIP 1')">VIP1</button> 
                                <button style="background-color: green;color:white;
                                border:hidden;border-radius:10px;padding:10px;margin:10px" 
                                onclick="change_stat('VIP 2')">VIP2</button>
                                <button style="background-color: green;color:white;
                                border:hidden;border-radius:10px;padding:10px;margin:10px" 
                                onclick="change_stat('VIP 3')">VIP3</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item"><label class="layui-form-label label-required">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">Overlay group</font>
                        </font>
                    </label>
                    <div class="layui-input-block">
                        <div class="layui-unselect layui-form-select">
                        <div class="layui-select-title">
                        <input type="text" placeholder="please choose" id="overlay-input"
                            value="${result.data.group}" readonly="" class="layui-input layui-unselect">
                            </div>
                            <div style="display:flex">
                                <p>Please choose one</p>
                                <button style="background-color: green;color:white;
                                border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                onclick="change_overlay('Day 1 Client Accounts')">Day 1 Client Accounts</button>
                                <button style="background-color: green;color:white;
                                border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                onclick="change_overlay('Day 2 own account (self)')">Day 2 own account (self)</button> 
                                <button style="background-color: green;color:white;
                                border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                onclick="change_overlay('Standby (later customers)')">Standby (later customers)</button> 
                                <button style="background-color: green;color:white;
                                border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                onclick="change_overlay('Day 2 Client Accounts')">Day 2 Client Accounts</button> 
                                <button style="background-color: green;color:white;
                                border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                onclick="change_overlay('Day 2 own account (self)')">Day 2 own account (self)</button> 
                                <button style="background-color: green;color:white;
                                border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                onclick="change_overlay('Day 6 own account (self)')">Day 6 own account (self)</button>
                                <button style="background-color: green;color:white;
                                border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                onclick="change_overlay('Day 4 Client Accounts')">Day 4 Client Accounts</button>
                                <button style="background-color: green;color:white;
                                border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                onclick="change_overlay('Day 4 own account (self)')">Day 4 own account (self)</button>
                                <button style="background-color: green;color:white;
                                border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                onclick="change_overlay('Spare 1')">Spare 1</button>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item"><label class="layui-form-label">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">Number of level tasks</font>
                        </font>
                    </label>
                    <div class="layui-input-block"><input name="converNumber" value="66" readonly=""
                            class="layui-input">
                        <p class="help-block">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Which round is the current task?</font>
                            </font>
                        </p>
                    </div>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
        </div>
        <div class="layui-form-item text-center"><button class="layui-btn" type="button" onclick="submit_grade_data('${user}')">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">submit</font>
            </font>
        </button><button class="layui-btn layui-btn-danger" type="button" onclick="remove_grader()">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">Cancel</font>
            </font>
        </button></div>
    </div><span class="layui-layer-setwin"><a class="layui-layer-ico layui-layer-close layui-layer-close1"
            href="javascript:;"></a></span><span class="layui-layer-resize"></span>
    </div>`
            currentUser = user
            body.insertAdjacentHTML("beforeend", modal)
        })
    }
}

function edit_user(user) {
    if (user && typeof user == "string") {
        fetch(`../serve/admin_get_user.php?user_id=${user}`)
        .then(Response => Response.json())
        .then(result => {
            let body = document.querySelector("body")
            let modal = `
            <div class="layui-layer layui-layer-page" id="layui-layer6" type="page" times="6" showtime="0" contype="string"
        style="z-index: 19891020; width: 800px; top: 27px; left: 23.5px;">
        <div class="layui-layer-title" style="cursor: move;">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">Edit user information</font>
            </font>
        </div>
        <div id="" class="layui-layer-content" style="height: 451px;">
            <div class="layui-form layui-card" novalidate="novalidate">
                <div class="layui-card-body">
                    <div class="layui-form-item"><label class="layui-form-label label-required label-required-next">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">user name</font>
                            </font>
                        </label>
                        <div class="layui-input-block"><input name="user_name" id="user-name" required=""
                                placeholder="Please enter user name" value="${result.data.user_name}" class="layui-input"></div>
                    </div>
                    <div class="layui-form-item"><label class="layui-form-label label-required label-required-next">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">phone number</font>
                            </font>
                        </label>
                        <div class="layui-input-block"><input name="tel" id="tel" required=""
                                placeholder="Please enter the phone number" value="${result.data.tel}" class="layui-input"></div>
                    </div>
                    <div class="layui-form-item"><label class="layui-form-label label-required label-required-next">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Account balance</font>
                            </font>
                        </label>
                        <div class="layui-input-block"><input type="number" id="balance" min="0" required=""
                                placeholder="Please enter account balance" name="balance" value="${result.data.balance}"
                                class="layui-input"><span
                                style="padding-right: 12px; color: rgb(169, 68, 66); position: absolute; right: 0px; font-size: 12px; z-index: 2; display: block; width: 30px; text-align: center; pointer-events: none; top: 0px; padding-bottom: 0px; line-height: 38px;"></span>
                        </div>
                    </div>
                    <div class="layui-form-item"><label class="layui-form-label label-required label-required-next">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">frozen amount</font>
                            </font>
                        </label>
                        <div class="layui-input-block">
                        <input type="number" min="0" required="" id="frozen" placeholder="frozen amount"
                                name="freeze_balance" value="0.00" class="layui-input"><span
                                style="padding-right: 12px; color: rgb(169, 68, 66); position: absolute; right: 0px; font-size: 12px; z-index: 2; display: block; width: 30px; text-align: center; pointer-events: none; top: 0px; padding-bottom: 0px; line-height: 38px;"></span>
                        </div>
                    </div>
                    <div class="layui-form-item"><label class="layui-form-label label-required">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">membership level</font>
                            </font>
                        </label>
                        <div class="layui-input-block">
                            <div class="layui-unselect layui-form-select">
                                <div class="layui-select-title">
                                <input type="text" id="user-stat-edit" readonly=""
                                placeholder="please choose" value="${result.data.user_status}" class="layui-input layui-unselect">
                                </div>
                                <div style="display:flex">
                                    <p>Please choose one</p>
                                    <button style="background-color: green;color:white;
                                    border:hidden;border-radius:10px;padding:10px;margin:10px" 
                                    onclick="change_stat('VIP 1')">VIP1</button> 
                                    <button style="background-color: green;color:white;
                                    border:hidden;border-radius:10px;padding:10px;margin:10px" 
                                    onclick="change_stat('VIP 2')">VIP2</button>
                                    <button style="background-color: green;color:white;
                                    border:hidden;border-radius:10px;padding:10px;margin:10px" 
                                    onclick="change_stat('VIP 3')">VIP3</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item"><label class="layui-form-label label-required">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Overlay group</font>
                            </font>
                        </label>
                        <div class="layui-input-block">
                            <div class="layui-unselect layui-form-select">
                                <div class="layui-select-title">
                                    <input type="text" placeholder="please choose" id="overlay-input"
                                        value="${result.data.group}" readonly="" class="layui-input layui-unselect">
                                        </div>
                                        <div style="display:flex">
                                            <p>Please choose one</p>
                                            <button style="background-color: green;color:white;
                                            border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                            onclick="change_overlay('Day 1 Client Accounts')">Day 1 Client Accounts</button>
                                            <button style="background-color: green;color:white;
                                            border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                            onclick="change_overlay('Day 2 own account (self)')">Day 2 own account (self)</button> 
                                            <button style="background-color: green;color:white;
                                            border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                            onclick="change_overlay('Standby (later customers)')">Standby (later customers)</button> 
                                            <button style="background-color: green;color:white;
                                            border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                            onclick="change_overlay('Day 2 Client Accounts')">Day 2 Client Accounts</button> 
                                            <button style="background-color: green;color:white;
                                            border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                            onclick="change_overlay('Day 2 own account (self)')">Day 2 own account (self)</button> 
                                            <button style="background-color: green;color:white;
                                            border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                            onclick="change_overlay('Day 6 own account (self)')">Day 6 own account (self)</button>
                                            <button style="background-color: green;color:white;
                                            border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                            onclick="change_overlay('Day 4 Client Accounts')">Day 4 Client Accounts</button>
                                            <button style="background-color: green;color:white;
                                            border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                            onclick="change_overlay('Day 4 own account (self)')">Day 4 own account (self)</button>
                                            <button style="background-color: green;color:white;
                                            border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                            onclick="change_overlay('Spare 1')">Spare 1</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item"><label class="layui-form-label label-required">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">trading status</font>
                            </font>
                        </label>
                        <div class="layui-input-block">
                            <div class="layui-unselect layui-form-select">
                                <div class="layui-select-title"><input type="text" placeholder="please choose" value="normal"
                                        readonly="" id="freezer-input" class="layui-input layui-unselect"></div>
                                <div style="display:flex">
                                <p>please choose one</p>
                                    <button style="background-color: green;color:white;
                                    border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                    onclick="change_freezer('normal')">normal</button>
                                    <button style="background-color: green;color:white;
                                    border:hidden;border-radius:10px;padding:5px;margin:5px;" 
                                    onclick="change_freezer('freeze')">freeze</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item"><label class="layui-form-label">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">login password</font>
                            </font>
                        </label>
                        <div class="layui-input-block"><input name="pwd" id="pwd"
                                placeholder="Leave blank and do not change the password" class="layui-input"><span
                                style="padding-right: 12px; color: rgb(169, 68, 66); position: absolute; right: 0px; font-size: 12px; z-index: 2; display: block; width: 30px; text-align: center; pointer-events: none; top: 0px; padding-bottom: 0px; line-height: 38px;"></span>
                        </div>
                    </div>
                    <div class="layui-form-item"><label class="layui-form-label">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">transaction password</font>
                            </font>
                        </label>
                        <div class="layui-input-block"><input name="pwd2" id="trans-pwd"
                                placeholder="Leave blank and do not change the transaction password" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item"><label class="layui-form-label">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Number of level tasks</font>
                            </font>
                        </label>
                        <div class="layui-input-block"><input name="converNumber" value="66" readonly=""
                                class="layui-input">
                            <p class="help-block">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">Which round is the current task?</font>
                                </font>
                            </p>
                        </div>
                    </div>
                    <div class="layui-form-item" style="display: none"><label class="layui-form-label">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Superior ID</font>
                            </font>
                        </label>
                        <div class="layui-input-block"><input name="parent_id" placeholder="Please enter superior ID"
                                value="4768" class="layui-input"></div>
                    </div>
                </div><input name="id" type="hidden" value="4769">
                <div class="hr-line-dashed"></div>
            </div>
            <div class="layui-form-item text-center"><button class="layui-btn" type="button" onclick="submit_data('${user}')">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">submit</font>
                        </font>
                    </button><button class="layui-btn layui-btn-danger" type="button" onclick="remove_editer()">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">Cancel</font>
                        </font>
                    </button></div>
        </div><span class="layui-layer-setwin"><a class="layui-layer-ico layui-layer-close layui-layer-close1"
                href="javascript:;"></a></span><span class="layui-layer-resize"></span>
    </div>
            `
            currentUser = user
            body.insertAdjacentHTML("beforeend", modal)
        })
    }
}

function remove_grader() {
    let grader = document.getElementById("layui-layer4")
    grader.replaceWith("")
}

function remove_editer() {
    let editer = document.getElementById("layui-layer6")
    editer.replaceWith("")
}

function change_stat(param) {
    let userStat = document.getElementById("user-stat-edit")
    userStat.innerHTML = param
    userStat.value = param
}

function change_overlay(param) {
    let userOverlay = document.getElementById("overlay-input")
    userOverlay.innerHTML = param
    userOverlay.value = param
}

function change_freezer(param) {
    let freezer = document.getElementById("freezer-input")
    freezer.innerHTML = param
    freezer.value = param
}

function submit_data(user_id) {
    let userStat = document.getElementById("user-stat-edit")
    let userOverlay = document.getElementById("overlay-input")
    let freezer = document.getElementById("freezer-input")
    let userName = document.getElementById("user-name")
    let tel = document.getElementById("tel")
    let balance = document.getElementById("balance")
    let frozen = document.getElementById("frozen")
    let pwd = document.getElementById("pwd")
    let transPwd = document.getElementById("trans-pwd")
    let formdata = new FormData()
    formdata.append("user_id",user_id)
    formdata.append("user_status",userStat.value)
    formdata.append("trading_status",freezer.value)
    formdata.append("overlay",userOverlay.value)
    formdata.append("user_name",userName.value)
    formdata.append("tel",tel.value)
    formdata.append("balance",balance.value)
    formdata.append("pwd",pwd.value)
    formdata.append("frozen",frozen.value)
    formdata.append("transfer_password",transPwd.value)
    fetch("../serve/edit_user.php",{
        method:"POST",
        body:formdata
    })
    .then(Response => Response.json())
    .then(data => {
        if (data.code == 0) {
            window.location.reload()
        }
        else{
            alert("some issue occured")
        }
    })
    .catch(err => alert("an error occured" + err))
}

function submit_grade_data(user_id) {
    let userStat = document.getElementById("user-stat-edit")
    let userOverlay = document.getElementById("overlay-input")
    let formdata = new FormData()
    formdata.append("user_id",user_id)
    formdata.append("user_status",userStat.value)
    formdata.append("overlay",userOverlay.value)
    fetch("../serve/edit_user.php",{
        method:"POST",
        body:formdata
    })
    .then(Response => Response.text())
    .then(data => {
        if (data.code == 0) {
            window.location.reload()
        }
        else{
            alert("some issue occured")
        }
    })
    .catch(err => alert("an error occured" + err))
}