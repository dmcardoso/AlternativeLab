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