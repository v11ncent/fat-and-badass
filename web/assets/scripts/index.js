const accentColor = getComputedStyle(document.documentElement).getPropertyValue(
  "--clr-accent"
);
const titleWords = document.querySelectorAll("h1 span");

const getRandomTime = (max) => {
  return Math.floor(Math.random() * max);
};
