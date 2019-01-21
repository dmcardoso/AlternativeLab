const thisName = "Daniel";
const thisArray = ["Teste"];
const thisObject = {tes: "te"};

String.prototype.coe = function (that) {
    console.log(arguments.callee.caller.name);
    // console.log(this);
    // console.log(that);
};

Array.prototype.coe = function (that) {
    // console.log(this);
    // console.log(that);
};


Object.prototype.coe = function (that) {
    // console.log(this);
    // console.log(that);
};


function nome(){
    console.log(arguments.callee.caller.name);
}

function essa(){
    nome();
}

// essa();
// console.log(__filename);
// console.log(__dirname);
// console.log(__index__);
// console.log(__dir__);
// thisName.coe();
// thisArray.coe();
// thisObject.coe();

const path = require('path');
console.log(path.resolve(__dirname, '../../'));