(function(w,d,s,i) {
    var f,j,c; f=d.getElementsByTagName(s)[0]; j=d.createElement(s); j.async=true; c=d.currentScript;
    j.src='https://www.clarity.ms/tag/uet/'+i;
    j.onload = function () {
        if (!c) return;
        var co = function(u) { return u && typeof u === 'object' && !(u instanceof Array) && u.beaconParams && u.beaconParams.mid && w.clarity; };
        var r = 40;
        var cl = function() {
            if (r-- < 1) return;
            var uo = c.getAttribute('data-ueto');
            if (!uo) return;
            var u = w[uo];
            if (!co(u)) { setTimeout(function () { cl(); }, 250); return; }
            var m = u.beaconParams.mid;
            w.clarity('set', '_uetmid', m);
            w.clarity('metadata', (function () { w.clarity('set', '_uetmid', m); }), false);
            d.addEventListener('UetEvent', function(e) {
                var nm = u.beaconParams.mid;
                if (m !== nm) { m = nm; w.clarity('set', '_uetmid', m); }
            });
        };
        cl();
    };
    f.parentNode.insertBefore(j,f);
})(window, document, 'script', '5612917');
