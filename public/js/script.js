/**
 * Created by User on 006 06.11.16.
 */

(function () {
    var data = {};

    var inputs = document.getElementsByClassName('input-wrapper');
    var i;
    for (i = inputs.length; i--;) {
        if (inputs[i]) {
            inputs[i].oninput = function () {
                inputs[i].value.replace(/[^0-9,]/, '')
            };
        }
    }

    var senderID;
    var btns = document.getElementsByTagName('BUTTON');
    for (i = btns.length; i--;) {
        if (btns[i]) {
            senderID = btns[i].getAttribute('data-sender');
            setEvent(btns[i], senderID);
        }
    }

    var a = document.getElementsByTagName('A');

    for (i = a.length; i--;) {
        if (a[i] && a[i]['dataset']['idSender']) {
            senderID = a[i].getAttribute('data-id-sender');
            setEventCancel(a[i], senderID);
        }
    }

    function setEvent(btn, senderID) {

        btn.onclick = function () {

            var el1 = document.getElementById('sum-div-' + senderID);
            var el2 = document.getElementById('users-div-' + senderID);

            data.sum = parseFloat(document.getElementById('input-' + senderID).value);

            if (isNaN(data.sum)) {
                data.sum = '0';
            }

            if (el1) el1.style.display = 'none';
            if (el2) el2.style.display = 'block';

        };
    }

    function setEventCancel(btn, senderID) {

        btn.onclick = function () {

            var el1 = document.getElementById('sum-div-' + senderID);
            var el2 = document.getElementById('users-div-' + senderID);

            data.sum = null;

            if (el1) el1.style.display = '';
            if (el2) el2.style.display = 'none';

        };
    }


    



})();
