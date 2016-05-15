<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
<script >
    var store = (function () {
        var api               = {},
            win               = window,
            doc               = win.document,
            localStorageName  = 'localStorage',
            globalStorageName = 'globalStorage',
            storage;

        api.set    = function (key, value) {};
        api.get    = function (key)        {};
        api.remove = function (key)        {};
        api.clear  = function ()           {};

        if (localStorageName in win && win[localStorageName]) {
            storage    = win[localStorageName];
            api.set    = function (key, val) { storage.setItem(key, val) };
            api.get    = function (key)      { return storage.getItem(key) };
            api.remove = function (key)      { storage.removeItem(key) };
            api.clear  = function ()         { storage.clear() };

        } else if (globalStorageName in win && win[globalStorageName]) {
            storage    = win[globalStorageName][win.location.hostname];
            api.set    = function (key, val) { storage[key] = val };
            api.get    = function (key)      { return storage[key] && storage[key].value };
            api.remove = function (key)      { delete storage[key] };
            api.clear  = function ()         { for (var key in storage ) { delete storage[key] } };

        } else if (doc.documentElement.addBehavior) {
            function getStorage() {
                if (storage) { return storage }
                storage = doc.body.appendChild(doc.createElement('div'));
                storage.style.display = 'none';
                // See http://msdn.microsoft.com/en-us/library/ms531081(v=VS.85).aspx
                // and http://msdn.microsoft.com/en-us/library/ms531424(v=VS.85).aspx
                storage.addBehavior('#default#userData');
                storage.load(localStorageName);
                return storage;
            }
            api.set = function (key, val) {
                var storage = getStorage();
                storage.setAttribute(key, val);
                storage.save(localStorageName);
            };
            api.get = function (key) {
                var storage = getStorage();
                return storage.getAttribute(key);
            };
            api.remove = function (key) {
                var storage = getStorage();
                storage.removeAttribute(key);
                storage.save(localStorageName);
            }
            api.clear = function () {
                var storage = getStorage();
                var attributes = storage.XMLDocument.documentElement.attributes;;
                storage.load(localStorageName);
                for (var i=0, attr; attr = attributes[i]; i++) {
                    storage.removeAttribute(attr.name);
                }
                storage.save(localStorageName);
            }
        }
        return api;
    })();
</script>
<form action="">
    <input type="text" name="name" value="" />
    <input type="text" name="age" value="" />
    <input type="text" name="sex" value="" />
    <input type="submit" name="" value="ok"  id="do"/>
</form>
<script>
    $(function(){
            $('#do').click(function(){
                store.set('username', $("input[name='name']").val())
                store.set('age', $("input[name='age']").val())
                store.set('sex', $("input[name='sex']").val())
            })

            if(store.get('username')!=''){
                $("input[name='name']").val(store.get('username'))
            }
            if(store.get('age')!=''){
                $("input[name='age']").val(store.get('age'))
            }
            if(store.get('sex')!=''){
                $("input[name='sex']").val(store.get('sex'))
            }

    })


</script>