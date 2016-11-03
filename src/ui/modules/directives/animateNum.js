function animateChange(startValue, toValue, duration, fps, setter) {

    startValue = +startValue;
    toValue = +toValue;

    var start = Date.now();

    if (startValue == toValue) {
        return setter(+toValue);
    }

    (function loop() {
        var now = Date.now();
        if (now - start >= duration) {
            return setter(toValue);
        }

        const v = startValue + (now - start) / duration * (toValue - startValue);

        if (toValue > startValue && v > startValue && v <= toValue ||
            toValue < startValue && v < startValue && v >= toValue) {
            setter(v);
        }

        setTimeout(loop, 1000 / fps);
    })();


}

module.exports = {
    params: ['fixed'],
    update(nv, ov) {
        const fixed = this.params.fixed == null ? 3 : +this.params.fixed;
        //console.log('nv='+nv+'  ov='+ov)
        let first=true;
        if (ov == undefined && nv!=undefined) {
            this.el.textContent = parseFloat(nv).toFixed(fixed).slice(0, 20);
            return;
        }
        if (ov == 0 && nv>0 && first) {
            first=false;
            this.el.textContent = parseFloat(nv).toFixed(fixed).slice(0, 20);
            return;
        }
        //if(ov==0 && first){
        //    first=false;
        //    this.el.textContent = nv.toFixed(fixed).slice(0, 20);
        //    return
        //}


        animateChange(ov == undefined ? 0 : ov, nv == undefined ? 0 : nv, 1000, 25, v => {
            this.el.textContent = v.toFixed(fixed).slice(0, 20);
        });
    }
};