$.routes.add('/', function() {
    console.log('/')
});
$.routes.add('/login/', function() {
    App.ShowLogin();
});
$.routes.add('/{phase:string}/', function() {
    console.log(this.phase)
});
