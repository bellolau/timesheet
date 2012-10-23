(function() {
    var framework = function(options) {
        var self = {
            init: function() {
                console.log('init framework');
            }
        }
        if (self.init && typeof self.init == 'function') {
            self.init();
        }
        return self;
    }
    addEventListener('load', new framework({}), false);
}());

$(window).load(function() {
	var url = window.location.hash.substr(1);
	console.log(url);
	if (url != '') {
		loadPageWithHash();
	}

    $('#popup').dialog({
        autoOpen: false,
        modal: true,
        minWidth: 300,
        width: 'auto'
    });

    $(window).bind('hashchange', function(event) {
        event.preventDefault();
        console.log('hashchange');
        loadPageWithHash();
    });

    function loadPageWithHash() {
        var url = window.location.hash.substr(1);
        $.ajax(url, {
            success: function(data) {
                $('#container').html(data);
            },
            error: function() {
                console.log('error');
            }
        });
    }

    $('body').delegate('form', 'submit', function(event){
        //        alert('test(');
        event.preventDefault();
        console.log('ajax form');

        var action = $(this).attr('action');
        console.log(action);
        var method = $(this).attr('method');
        method = method === '' ? 'GET' : method.toUpperCase();
        console.log(method);
        var params = $(this).serializeArray();
        console.log(params);

        $.ajax(action, {
            type: method,
            data: params,
            success: function(data) {
                if ($('#popup').dialog('isOpen') === true) {
                    if (typeof data.result !== 'undefined' && data.result === 'ok') {
                        $('#popup').dialog('close');
                        loadPageWithHash();
                    } else {
                        $('#popup').html(data);
                    }
                } else {
                    $('#container').html(data);
                }
            },
            error: function() {
                console.log('error');
            //                    window.localtion = target.href;
            }
        });
    });

    $('body').delegate('a', 'click', function(event){
        var url = event.target.href;

        if (typeof url !== 'undefined') {
            event.preventDefault();
            console.info(url);
            var domain = window.location.protocol + '//' + window.location.host;
            console.info(domain);
            var actualPage = domain + '/' + window.location.path;

            if ($(this).hasClass('popup')) {
                console.log('popup');
                $.ajax(url, {
                    success: function(data) {
                        $('#popup').html(data).dialog("open");
                    },
                    error: function() {
                        console.log('error');
                    //                    window.localtion = target.href;
                    }
                });
            } else if (url !== actualPage + '#') {
                console.log('page');
                window.location.hash = url.replace(domain, '');
            }
        }
    });
});

