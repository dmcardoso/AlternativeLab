function start(){
    const textarea = document.querySelector('.texto');
    const result = document.querySelector('.result');

    textarea.onchange = (e) => {
        const {value} = e.target;

        result.innerText = value.toLowerCase();
    };
}

start();
