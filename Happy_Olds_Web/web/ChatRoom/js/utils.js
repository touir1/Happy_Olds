var Utils = function(){
    // TODO
    var utility = {};

    utility.helloWold = function(){
        console.log('hello world');
    };

    utility.getUrlParameter = function(url, parameter) {
        parameter = parameter.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?|&]' + parameter.toLowerCase() + '=([^&#]*)');
        var results = regex.exec('?' + url.toLowerCase().split('?')[1]);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    };

    utility.getNextSibling = function (elem, selector) {

        // Get the next sibling element
        var sibling = elem.nextElementSibling;

        // If the sibling matches our selector, use it
        // If not, jump to the next sibling and continue the loop
        while (sibling) {
            if (sibling.matches(selector)) return sibling;
            sibling = sibling.nextElementSibling
        }

    };

    utility.setUrlParameter = function(url, key, value) {
        var key = encodeURIComponent(key),
            value = encodeURIComponent(value);

        var baseUrl = url.split('?')[0],
            newParam = key + '=' + value,
            params = '?' + newParam;

        if (url.split('?')[1] == undefined){ // if there are no query strings, make urlQueryString empty
            urlQueryString = '';
        } else {
            urlQueryString = '?' + url.split('?')[1];
        }

        // If the "search" string exists, then build params from it
        if (urlQueryString) {
            var updateRegex = new RegExp('([\?&])' + key + '[^&]*');
            var removeRegex = new RegExp('([\?&])' + key + '=[^&;]+[&;]?');

            if (typeof value === 'undefined' || value === null || value === '') { // Remove param if value is empty
                params = urlQueryString.replace(removeRegex, "$1");
                params = params.replace(/[&;]$/, "");

            } else if (urlQueryString.match(updateRegex) !== null) { // If param exists already, update it
                params = urlQueryString.replace(updateRegex, "$1" + newParam);

            } else if (urlQueryString=='') { // If there are no query strings
                params = '?' + newParam;
            } else { // Otherwise, add it to end of query string
                params = urlQueryString + '&' + newParam;
            }
        };

        // no parameter was set so we don't need the question mark
        params = params === '?' ? '' : params;

        return baseUrl + params;
    };

    function collectionHas(a, b) { //helper function (see below)
        for(var i = 0, len = a.length; i < len; i ++) {
            if(a[i] == b) return true;
        }
        return false;
    }
    utility.findParentBySelector = function(elm, selector) {
        var all = document.querySelectorAll(selector);
        var cur = elm.parentNode;
        while(cur && !collectionHas(all, cur)) { //keep going up until you find a match
            cur = cur.parentNode; //go up
        }
        return cur; //will return null if not found
    }

    return utility;
}();