/* const fttitle = document.querySelectorAll('.ft_tx_title');
const fttext = document.querySelectorAll('.ft_text');
const btnPrev = document.getElementById('prev-button');
const btnNext = document.getElementById('next-button');

let currentext = 1;
let time = 15;

console.log(fttitle);
console.log(fttext);
console.log(btnPrev);
console.log(btnNext);
console.log("fixe");

function hidestext(){
    fttext.forEach(item => item.classList.remove('on'))
    fttext.forEach(item => item.classList.remove('espe'))
    fttitle.forEach(item => item.classList.remove('on'))
}
function showtext(){
    fttext[currentext].classList.add('on')
    fttext[currentext].classList.add('espe')
    console.log(fttext.length)
    if(currentext === 0){
        fttext[fttext.length-1].classList.add('on')
        fttext[fttext.length-1].classList.add('espe') 
    }else{
        fttext[currentext-1].classList.add('on')
        fttext[currentext-1].classList.add('espe')
    }
    fttitle[currentext].classList.add('on')
    if(currentext === 0){
        fttitle[fttitle.length-1].classList.add('on')
    }else{
        fttitle[currentext-1].classList.add('on')
    }
}

function nexttext(){
    hidestext()
    if(currentext === fttitle.length -1 && currentext === fttitle.length - 1){
        currentext = 0;
    }else{
        currentext++;
    }
    showtext();
    time = 0;
    console.log()
}

function prevtext(){
    hidestext()
    if(currentext === 0){
        currentext = fttitle.length -1;
    }else{
        currentext--;
    }
    showtext();
    time = 0;
}

setInterval(countdown,1000)

function countdown(){
  time++
  if(time === 15){
    nexttext();
    time = 0;
  }
}
btnNext.addEventListener('click', nexttext)
btnPrev.addEventListener('click', prevtext) */
const btnPrev = document.getElementById("prev-button");
const btnNext = document.getElementById("next-button");
title_feat = [
  "Level of The water",
  "Modern and Portable Design",
  "Temperature Monitoring",
];
text_feat = [
  "With the help of this tecnology you can always see the level od the water insite your bottle",
  "Stylish, easy-to-carry design that fits perfectly into any lifestyle.",
  "Display water temperature to ensure ou know the best places to store it.",
];
preset_text = document.getElementsByClassName("ft_text");
preset_title = document.getElementsByClassName("ft_tx_title");

time = 0;
let currentext = 1;

function nexttext() {
  if (currentext == title_feat.length - 1) {
    currentext = 0;
    preset_text[0].innerText = text_feat[text_feat.length - 1];
    preset_text[1].innerText = text_feat[currentext];
    preset_title[0].innerText = title_feat[text_feat.length - 1];
    preset_title[1].innerText = title_feat[currentext];
  } else {
    preset_text[0].innerText = text_feat[currentext];
    preset_text[1].innerText = text_feat[currentext + 1];
    preset_title[0].innerText = title_feat[currentext];
    preset_title[1].innerText = title_feat[currentext + 1];
    currentext++;
  }
  time = 0;
}
function prevtext() {
  if (currentext == title_feat.length - 1) {
    currentext = 0;
    preset_text[0].innerText = text_feat[title_feat.length - 1];
    preset_text[1].innerText = text_feat[currentext];
    preset_title[0].innerText = title_feat[title_feat.length - 1];
    preset_title[1].innerText = title_feat[currentext];
  } else if (currentext == 1 || currentext == 0) {
    currentext = title_feat.length - 1;
    preset_text[0].innerText = text_feat[currentext - 1];
    preset_text[1].innerText = text_feat[currentext];
    preset_title[0].innerText = title_feat[currentext - 1];
    preset_title[1].innerText = title_feat[currentext];
  }
  time = 0;
}
setInterval(countdown, 1000);

function countdown() {
  time++;
  if (time === 15) {
    nexttext();
    time = 0;
  }
}

btnNext.addEventListener("click", nexttext);
btnPrev.addEventListener("click", prevtext);
