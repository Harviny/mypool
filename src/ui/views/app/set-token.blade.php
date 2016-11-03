<script type="application/json" id="token">{!! $token !!}</script>

<script src="mod.js"></script>
{!! app('fis')->useFramework() !!}

<script>
    const bridge = require('modules/mobile/bridge');
    const token = JSON.parse(document.querySelector('#token').textContent);
    bridge.call('set_token', token).then(() => {
        console.log(`setToken = ${token}`);
    });
</script>