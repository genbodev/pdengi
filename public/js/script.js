/**
 * Created by User on 006 06.11.16.
 */

/* clear js */
(function () {
    var data = {};

    var inputs = document.getElementsByClassName('input-wrapper');
    var i;
    for (i = inputs.length; i--;) {
        if (inputs[i]) {
            inputs[i].oninput = function () {
                this.value = this.value.replace(/[^0-9.]/gi, '')
            };
        }
    }

    var senderID;
    var buttons = document.getElementsByTagName('BUTTON');
    for (i = buttons.length; i--;) {
        if (buttons[i]) {
            senderID = buttons[i].getAttribute('data-sender');
            setEvent(buttons[i], senderID);
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

            var sum = parseFloat(document.getElementById('input-' + senderID).value);

            if (isNaN(sum)) {
                sum = '0';
            }

            if (!data['sum']) {
                data['sum'] = {};
            }

            data['sum'][senderID] = sum;

            if (el1) el1.style.display = 'none';
            if (el2) el2.style.display = 'block';

            var i;
            for (i = el2.children.length; i--;) {
                if (el2.children[i]) {
                    if (el2.children[i].tagName === 'DIV') {
                        el2.children[i].setAttribute('data-add-sum', data.sum[senderID]);
                    }
                }
            }

        };
    }

    function setEventCancel(btn, senderID) {

        btn.onclick = function () {

            var el1 = document.getElementById('sum-div-' + senderID);
            var el2 = document.getElementById('users-div-' + senderID);

            if (el1) el1.style.display = '';
            if (el2) el2.style.display = 'none';

        };
    }

})();

/* jQuery */
$(document).ready(function () {

    // Установка значения для всех ajax (не рекомендуется)
    /*$.ajaxSetup({
     headers: {
     'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
     }
     });*/
    // Вариант для чистого JS
    /*xmlHttp.setRequestHeader("X-CSRF-Token", $('meta[name="csrf-token"]').attr('content'));
     xmlHttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");*/
    var senderID, recipientID, senderSum, recipientSum, addSum;
    $('.user-name').click(function () {
        senderID = $(this).attr('data-sender');
        recipientID = $(this).attr('data-recipient');
        senderSum = $(this).attr('data-sender-sum');
        recipientSum = $(this).attr('data-recipient-sum');
        addSum = $(this).attr('data-add-sum');
        if (parseFloat(senderSum) === 0) {
            var el1 = $('#sum-div-' + senderID);
            var el2 = $('#users-div-' + senderID);
            if (el1) el1.css('display', '');
            if (el2) el2.css('display', 'none');
            $('#input-' + senderID).val('Нет баланса!');
        } else {
            if (parseFloat(addSum) > parseFloat(senderSum)) addSum = senderSum;
            $.ajax({
                url: '/',
                type: 'POST',
                async: false,
                // token можно предать в data, а можно и через headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    senderID: senderID,
                    recipientID: recipientID,
                    senderSum: senderSum,
                    recipientSum: recipientSum,
                    addSum: addSum

                },
                success: function (data) {
                    updateDom(data, senderID, recipientID);
                }
            });
        }
    });

    function updateDom(data, senderID, recipientID) {

        var new_sender_sum = addZeroes(data['new_sender_sum'] + '');
        var new_recipient_sum = addZeroes(data['new_recipient_sum'] + '');

        /**
         * Добавит нули к исходной цифре (99 -> 99.00, 99.9 -> 99.90)
         * @param val
         * @returns {*}
         */
        function addZeroes(val) {
            if (!/\d+.\d{2}/g.test(val)) {
                var arr = val.split('.');
                if (arr.length === 1) {
                    val = val + '.00';
                } else {
                    val = val + '0';
                }
            }
            return val;
        }

        var senderDivSum = $('#balance-' + senderID);
        senderDivSum.html(new_sender_sum);
        var recipientDivSum = $('#balance-' + recipientID);
        recipientDivSum.html(new_recipient_sum);
        var el1 = $('#sum-div-' + senderID);
        var el2 = $('#users-div-' + senderID);
        if (el1) el1.css('display', '');
        if (el2) el2.css('display', 'none');
        $('#input-' + senderID).val('Успешно!');
        var elements = $('.users-wrapper');
        var i, j, sender, recipient, senderSum, recipientSum;
        for (i = elements.length; i--;) {
            if (elements[i]) {
                for (j = elements[i].children.length; j--;) {
                    if (elements[i].children[j]) {
                        if (elements[i].children[j].tagName === 'DIV') {
                            sender = $(elements[i].children[j]).data('sender');
                            recipient = $(elements[i].children[j]).data('recipient');
                            senderSum = $(elements[i].children[j]).data('senderSum');
                            recipientSum = $(elements[i].children[j]).data('recipientSum');
                            if (sender == senderID) senderSum = new_sender_sum;
                            if (recipient == recipientID) recipientSum = new_recipient_sum;
                            if (recipient == senderID) recipientSum = new_sender_sum;
                            if (sender == recipientID) senderSum = new_recipient_sum;
                            $(elements[i].children[j]).data('senderSum', senderSum).attr('data-sender-sum', senderSum);
                            $(elements[i].children[j]).data('recipientSum', recipientSum).attr('data-recipient-sum', recipientSum);
                        }
                    }
                }
            }
        }
        var commentDiv = $('#comment-' + senderID);
        commentDiv.append(data['comment']);
        commentDiv.append('<p>' + data.date + '</p>');
    }
});

