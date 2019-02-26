const fs = require('fs');

const path = "E:\\Daniel\\Cursos Udemy\\Curso React.js Ninja - React Completo";

const initials = ["[M1]", "[MWP]", "[M1C]", "[M2]", "[M3]", "[M4]"];

const directories = {
    "[M1]": [],
    "[MWP]": [],
    "[M1C]": [],
    "[M2]": [],
    "[M3]": [],
    "[M4]": []
};

const readDir = () => {
    const folders = fs.readdirSync(path);

    folders.forEach((value, index) => {
        const files = fs.readdirSync(path + `\\${value}`);

        files.forEach((video, i) => {
            if (video.split('.vt')[1]) {
                // legenda
            } else {
                directories[initials[index]].push(video.split('.mp4')[0]);
            }
        });
    });

};

function start() {
    readDir();

    let stringTemplate = ``;
    Object.keys(directories).forEach((cap, index) => {
        stringTemplate += `- [] ${cap}\n`;

        const numbers = directories[cap].map((value, index) => {
            return Number(value.split('.')[0]);
        });

        const numbersWithIndex = directories[cap].map((value, index) => {
            return [Number(value.split('.')[0]), index];
        });

        const ordered = numbers.sort(compareNumbers);

        ordered.forEach((value, index) => {
            numbersWithIndex.forEach((lecture, idx) => {
                if (value === lecture[0]) stringTemplate += `\t - [] ${directories[cap][lecture[1]]}\n`;
            });
        });

    });


    fs.writeFile(__dirname + '/aulas.txt', stringTemplate, erro => {
        console.log(erro || "Arquivo salvo");
    });
}

function compareNumbers(a, b) {
    return a - b;
}

start();
