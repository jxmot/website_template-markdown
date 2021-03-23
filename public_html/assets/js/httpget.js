/*
    Send a GET request and invoke a 
    callback function when completed.
*/
function httpGet(url, callback, tickle = false) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            var resp = this.responseText;
//            console.log('httpGet - ' + resp);
            callback(resp);
        }
    };
    // bypass caching, useful when retrieving resources
    // that change frequently
    if((tickle === true) && (url.includes('?') === false)) {
        url = url + '?_=' + new Date().getTime();
    }
    xmlhttp.open('GET', url, true);
    xmlhttp.send();
};
