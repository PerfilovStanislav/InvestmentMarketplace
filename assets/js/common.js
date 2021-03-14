/*Стэк функций
addToStack('MyFunction', [param1, param2, ...])*/
var addToStack = function(func_name, args) {
    stack[func_name] = args;
};

/*вызов функции из стэка*/
var callFromStack = function(func_name) {
    var data = getFromStack(func_name);
    if (data) {
        delete stack[func_name];
        window[func_name].apply(this, data.args);
        return true;
    }

    return null;
/*    else console.error(func_name + ' not found');*/
};

/*получение параметров для функции из стэка, либо удаление функции из стэка*/
var getFromStack = function(func_name) {
    if (!stack[func_name]) return null;
    return {args: stack[func_name]};
};

var removeFromStack = function(func_name) {
    if (!stack[func_name]) return null;
    delete stack[func_name];
    return true;
};

/*добавить параметры в функцию*/
var addParamsToStackFunction = function(func_name, args) {
    var data = getFromStack(func_name);
    if (data) {
        addToStack(func_name, data.args.concat(args));
        return true;
    }
    return null;
};

/* Удаление из объекта ключей*/
var removeFromObject = function(obj, arr) {
    for (var i in arr) delete obj[arr[i]];
    return obj;
};

/* Склеиваем объекты var obj = mergeObjects(obj1, obj2, ..., objN)*/
var mergeObjects = function(array_objects) {
    var obj = {};
    for (var i in array_objects) {
        for (var k in array_objects[i]) {
            obj[k] = array_objects[i][k]
        }
    }
    return obj;
};

var addToObject = function(main_obj, obj) {
    for (var i in obj) {
        main_obj[i] = obj[i];
    }
    return main_obj;
};

Date.prototype.addDays = function(days) {
    this.setDate(this.getDate() + days);
    return this;
}