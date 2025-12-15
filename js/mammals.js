const animals = [
  {
    name: "Dog",
    img: "img/dog1.png",
    desc: "has four legs, eats meat, vegetables, and fruits. Easy to play with, has a distinctive voice.",
    sound: "sound/dog.mp3"
  },
  {
    name: "Elephant",
    img: "img/elephant.png",
    desc: "has four legs, eats grass, leaves, tree bark, roots, fruit, and twigs. has a large body, wide ears, and a long trunk.",
    sound: "sound/Elephant.mp3"
  }
];

let index = 0;

const imgEl = document.getElementById("animalImage");
const nameEl = document.getElementById("animalName");
const descEl = document.getElementById("animalDesc");

function updateAnimal() {
  imgEl.src = animals[index].img;
  nameEl.innerText = animals[index].name;
  descEl.innerText = animals[index].desc;
}

function nextAnimal() {
  index = (index + 1) % animals.length;
  updateAnimal();
}

function prevAnimal() {
  index = (index - 1 + animals.length) % animals.length;
  updateAnimal();
}

function playSound() {
  const audio = new Audio(animals[index].sound);
  audio.play();
}
