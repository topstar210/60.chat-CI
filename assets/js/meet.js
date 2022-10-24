let ssUrl = "https://60.chat";
// let ssUrl = "http://localhost";

let connection, myId, partnerId, currChannelId;
let onlineUsers = [];
let usersData = {};
let partnerData = {};
let ignoreList = [];
let _researchInterval = null;
let _countdownInterval = null;
let latedConTime = 0;
let acceptFlag = false;

$(document).ready(function(){
    // initial connection
    myId = hash;
    connection = new RTCMultiConnection();
    connection.socketURL = ssUrl + ':' + server_port + '/';

    loadingStart();
    initialConnect();
    connection.openOrJoin(myId);
    socketActions();
    // initial connection

    calculateVideoSize();
    $(document).resize(function () {
        calculateVideoSize();
    })

});

/* getting a channel name from user ids */
function getChannelId(uid1, uid2){
    var tmpAry = [uid1, uid2].sort();
    var channelId = tmpAry[0]+ tmpAry[1];
    return channelId;
}

/* select random partner */
function selectPartner(myId, pblUsers) {
    console.log('possible users', pblUsers);
    if(pblUsers.length == 0) return;
    connection.socket.emit('select_partner', { myId, pblUsers });
}

/* open or join in room */
function openOrJoinRoom(roomId, myId, pId, flag){
    connection.openOrJoin(roomId, function(isRoomCreated, roomid, error) {
        // if(isRoomCreated && connection.isInitiator === true)
        console.log(flag, isRoomCreated, connection.isInitiator, error);
        if ((isRoomCreated && connection.isInitiator) || (flag == 'doOpen' && error == 'Room not available')) { // you opened the room
        // if (flag == 'doOpen') { // you opened the room
            console.log("you opened a room", myId);
            connection.socket.emit('let_us_chat', {
                fromId: myId,
                toId: pId,
                channelId: roomId
            });
        } else {
            console.log('you joined it');
        }
    });
}

/* display data of selected partner */
function displayPartnerData(pId){
    partnerData = usersData[pId];
    if(partnerData){
        $("#partner_name").html(partnerData.username);
        $("#partner_gender").html(partnerData.usergender);
        // const imgname = (partnerData.usergender).toLowerCase() + "_" + (Math.floor(Math.random() * 5 +1))
        const imgname = "unknown_1";
        $('#partner_avatar').html('<img src="https://60.chat/assets/imgs/'+imgname+'.png" width="100%" height="100%" />');
    }
}

/* research other partner */
function researchPartner(){
    _researchInterval = setInterval(function(){
        if(onlineUsers.length > 2){
            let pblUsers = possibleUsers(myId, onlineUsers, ignoreList);
            if(pblUsers.length > 0) {
                selectPartner(myId, pblUsers);
            }
        } else if(onlineUsers.length == 2) {
            const elapsed = Math.floor((Date.now() - latedConTime) / 1000);
            // console.log('onlineusers is two', elapsed);
            if(latedConTime > 0 && elapsed >= 58) {
                ignoreList = [];
                let pblUsers = possibleUsers(myId, onlineUsers, ignoreList);
                selectPartner(myId, pblUsers);
            }
        }
    },2000);
}

// clear all of interval
function clearAllInterval(){
    const interval_id = window.setInterval(function(){}, Number.MAX_SAFE_INTEGER);
    for (let i = 1; i < interval_id; i++) {
        window.clearInterval(i);
    }
}

/* just start count down */
function startCountdown() {
    loadingEnd();
    clearAllInterval();
    _countdownInterval = setInterval(function () {
        console.log(counter);
        $('.span_counter_label').html(counter);
        if (counter <= 5) {
            $('.videoCounterWrap').addClass('videoCounterWrapActive');
        }
        if (counter <= 0) {
            clearAllInterval();
            counter = 0;
            connection.close();
        }
        counter--
    }, 1000);
}

/* the action after stream ended */
function afterStreamEnded() {
    acceptFlag = false;
    latedConTime = Date.now();

    // if (ignoreList.indexOf(partnerId) == -1) ignoreList.push(partnerId);
    
    loadingStart();
    researchPartner();

    connection.socket.emit('add_me_waitingusers', { userId: myId });
    // connection.socket.emit('add_me_waitingusers', { userId: partnerId });
    console.log('onstreamended');
}

/* possible users with me */
function possibleUsers(myId, onlineUsers, ignoreList){
    let pblUsers = onlineUsers.filter(function(value){ 
        if(ignoreList.indexOf(value) == -1) return true;
    });
    const mId = pblUsers.indexOf(myId);
    pblUsers.splice(mId, 1);
    return pblUsers;
}

/* initial connect */
function initialConnect(){
    connection.enableFileSharing = false; // by default, it is "false".

    connection.autoCloseEntireSession = true;

    connection.userid = myId;
    connection.session = {
        audio: true,
        video: true,
        data: true
    };
    connection.extra = {
        username: minfo.name,
        usergender: minfo.gender
    }
    connection.sdpConstraints.mandatory = {
        OfferToReceiveAudio: true,
        OfferToReceiveVideo: true
    };
    connection.onstream = function (event) {
        // console.log("event", event);
        console.log("type", event.type);
        
        if (event.type == 'local') {
            document.getElementById('videos-container').innerHTML = '';
            event.mediaElement.removeAttribute('controls');
            document.getElementById('videos-container').appendChild(event.mediaElement);
        }

        if (event.type == 'remote') {
            startCountdown();
            document.getElementById('videos-second-container').innerHTML = "";
            event.mediaElement.removeAttribute('controls');
            document.getElementById('videos-second-container').appendChild(event.mediaElement);
        }
    };
    connection.onstreamended = function (event) {
        afterStreamEnded();
    }
    connection.onerror = function(event) {
        connection.close();
        // alert('unable to open data connection between you and ' + event.userid);
    };
}

/* getting socket events */
function socketActions() {
    connection.socket.on('users_state',function(data){
        if(data.currUsers.length < 2) return;

        usersData = data.udata;
        onlineUsers = data.currUsers;
        $('.videoPeople').text(onlineUsers.length + " users online");

        if(data.state == 'connect' && data.userid == myId){
            loadingStart();
            setTimeout(() => {
                let pblUsers = possibleUsers(myId, onlineUsers, ignoreList);
                selectPartner(myId, pblUsers);
            }, 500);
        }
    });

    connection.socket.on('users_disconnect', function(data){
        const oInd = onlineUsers.indexOf(data.userid);
        onlineUsers.splice(oInd, 1); // delete in users list
        $('.videoPeople').text(onlineUsers.length + " users online");
        delete usersData[data.userid]; // delete data in users data
    })

    // my side
    connection.socket.on('selected_partner', function(data){
        if(data.myId == myId) {
            console.log('selected_partner', usersData[data.partnerId]);

            clearAllInterval();
            partnerId = data.partnerId;
            displayPartnerData(partnerId);
            currChannelId = getChannelId(myId, partnerId);
            openOrJoinRoom(currChannelId, myId, partnerId, 'doOpen');
        }
    });
    connection.socket.on('find_other', function(data){
        if(data.myId == myId) {
            partnerId = null;
            currChannelId = null;

            console.log("already chatting. find other", data.partnerId);
            connection.socket.emit('add_me_waitingusers', { userId: data.myId });
            researchPartner();
        }
    })

    // partner side
    connection.socket.on('chat_accept', function(data){
        if(data.myId == myId && !acceptFlag){
            acceptFlag = true;
            console.log('chat_accept', data);

            partnerId = data.partnerId;
            displayPartnerData(partnerId);
            currChannelId = data.channelId;
            openOrJoinRoom(data.channelId, data.myId, data.partnerId, 'doJoin');
        } else if (data.myId == myId && acceptFlag) {
            connection.socket.emit('now_chatting', data);
        }
    });

    researchPartner();
}

function loadingStart() {
    clearInterval(_countdownInterval);
    $('.span_counter_label').html('0');
    $("#videos-second-container").html($('#partnerLoading').html());
    $('.videoCounterWrap').removeClass('videoCounterWrapActive');
    $('#titlePage').text('Waiting for the next meeting.');
    $('#partnerWrap').hide();
}
function loadingEnd() {
    $('#titlePage').html('Greetings!');
    $('#partnerWrap').show();
}

function calculateVideoSize() {
    let w = parseFloat($('#big-container').width());
    let h = 480 * w / 600;
    $('#big-container').css({'height': h + 'px'});
}