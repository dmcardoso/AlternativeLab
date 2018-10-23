const obj_soma = {
    a: 1,
    b: 2,
    c: 3,
    soma() {
        return a + b + c
    }
};

console.log(JSON.stringify(obj_soma));
// console.log(JSON.parse("{a: 4, b: 5, c: 6}"));
// console.log(JSON.parse("{'a': 4, 'b': 5, 'c': 6}"));
console.log(JSON.parse('{"a": 4, "b": 5, "c": 6}'));
console.log(JSON.parse('{"a": "string com espaco", "b": true, "c": {"e": 4}, "d": [45,56]}'));