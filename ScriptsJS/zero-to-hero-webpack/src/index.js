import johnCena from './assets/daniel.jpg';
import andHisNameIs from "./assets/and-his-name-is-john-cena-1.mp3";
import "./assets/styles.scss";


document.body.innerHTML = '<div id="myMemes"></div>';
document.getElementById('myMemes').innerHTML = `
  <h1>And his name is...</h1>
  <img src="${johnCena}" />
`;

const audio = new Audio(andHisNameIs);
const img = document.querySelector("#myMemes img");

img.addEventListener("click", event => audio.play());

import("./module-1").then(mod => {
    const nothing = mod.default();
    const nothingToo = mod.useless();

    // logs "This function does nothing and neither this one!"
    console.log(`${nothing} and ${nothingToo}`);
});

const outputs = [1, 2].map(modNum =>
    import(/* webpackMode: "lazy-once" */ `./module-${modNum}`).then(mod =>
        mod.default()
    )
);

Promise.all(outputs).then(outs => console.log(outs.join(" and ")));

const lazyButton = document.createElement("button");
lazyButton.innerText = "😴";
lazyButton.style = "margin: 10px auto; display: flex; font-size: 4rem";
lazyButton.onclick = () =>
    import(
        /* webpackChunkName: "myAwesomeLazyModule" */
        /* webpackPreload: true */
        "./lazy-one"
        ).then(mod => (lazyButton.innerText = mod.default));

document.body.appendChild(lazyButton);