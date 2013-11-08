jQuery(document).ready(function ($) {

   
    var defaultPanel = parseInt(getParam('panel'));
    jQuery(".accordion-container").accordion({
        autoHeight:false,
        collapsible:true,
        active:defaultPanel
        });

    var defaultTab = parseInt(getParam('tab'));
    jQuery(".tab-container").tabs({
        selected:defaultTab
        });

    function getParam(name) {
        var query = location.search.substring(1);
        if (query.length) {
            var parts = query.split('&');
            for (var i = 0; i < parts.length; i++) {
                var pos = parts[i].indexOf('=');
                if (parts[i].substring(0,pos) == name) {
                    return parts[i].substring(pos+1);
                }
            }
        }
        return -1;
    }
});