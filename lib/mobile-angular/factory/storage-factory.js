function StorageFactory() {
    this.set = function(name,id,val,time){
        time = (time || 10*60)*1000;
        var key = name + '-' + id;
        var data = {
            value: val,
            expried: new Date().getTime() + time
        }
        sessionStorage[key] = angular.toJson(data);
    }
    this.get = function(name,id){
        var key = name + '-' + id;
        var data = angular.fromJson(sessionStorage[key]);
        if(data && new Date().getTime()<data.expried) return data.value;
        return undefined;
    }
    return this;
}