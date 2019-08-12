// html2canvas(document.body).then(function (canvas) {
//     document.body.appendChild(canvas);
// });

const getImgSize = (imgSrc, container, img) => {
    const newImg = new Image();

    newImg.onload = function () {
        const height = newImg.height;
        const width = newImg.width;

        changeImgContainerSize(container, img, { width, height });
    };

    newImg.src = imgSrc; // this must be done AFTER setting onload
};

const changeImgContainerSize = (container, img, { width = 0, height = 0 }) => {
    container.style.width = `${width + 10}px`;
    container.style.height = `${height + 10}px`;
    img.style.width = `${width}px`;
    img.style.height = `${height}px`;

    changeImgInfo(container, { width, height }, img);
};

const changeImgInfo = (container, { width, height }, src) => {
    const info = document.createElement('div');
    info.classList.add('info');

    const widthfield = document.createElement('div');
    widthfield.classList.add('field');
    widthfield.innerHTML = `Width: ${width}`;

    const heightfield = document.createElement('div');
    heightfield.classList.add('field');
    heightfield.innerHTML = `Height: ${height}`;

    src = src.getAttribute('src');
    const img_name = src.split('/').pop();
    const img_name_field = document.createElement('div');
    img_name_field.classList.add('field');
    img_name_field.innerHTML = `Name: ${img_name}`;

    const download_button = document.createElement('a');
    download_button.classList.add('download');
    download_button.innerHTML = 'Baixar';
    download_button.onclick = (e) => {
        if (e.isTrusted) {
            generateCanvas(container, download_button, img_name);
        }
    };

    info.appendChild(img_name_field);
    info.appendChild(widthfield);
    info.appendChild(heightfield);
    info.appendChild(download_button);
    container.parentNode.prepend(info);
};

const generateCanvas = (container, button, img_name) => {
    html2canvas(container, { backgroundColor: null }).then(canvas => {
        button.setAttribute('download', img_name);
        const img = canvas.toDataURL('image/png').replace('image/png', 'image/octet-stream');
        button.setAttribute('href', img);
        button.click();
        button.removeAttribute('href');
        button.removeAttribute('download');
    });
};

const getBorderColor = () => {
    const input = document.querySelector('#border-color');
    input.onkeyup = (e) => {
        const color = e.target.value;
        document.querySelectorAll('.container').forEach((v, i) => {
            v.style.backgroundColor = `#${color}`;
            v.style.borderColor = `#${color}`;
        });
    };
};

const getBorderSize = () => {
    const input = document.querySelector('#border-size');
    input.onkeyup = (e) => {
        const size = e.target.value;
        document.querySelectorAll('.container').forEach((v, i) => {
            console.log(v);
            v.style.borderWidth = `${size}px`;
        });
    };
};

const start = async () => {
    const imgs = await fetch('./imgs.json').then(res => res.json());

    console.log(imgs);
    const ul = document.querySelector('#img-list');
    imgs.forEach((v, i) => {
       const li = document.createElement('li');
       const container = document.createElement('div');
       container.classList.add('container');

       const img = document.createElement('img');
       img.classList.add('imagem');
       img.setAttribute('src', v);

       container.appendChild(img);
       li.appendChild(container);
       ul.appendChild(li);
    });

    document.querySelectorAll('.container').forEach((v, i) => {
        const img = v.querySelector('img');
        getImgSize(img.src, v, img);
    });

    getBorderColor();
    getBorderSize();
};

start();
