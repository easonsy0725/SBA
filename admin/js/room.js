const genderBoxes = document.querySelectorAll('.student-box, .teacher-box');

genderBoxes.forEach(box => {
    const gender = box.getAttribute('data-gender');
    box.classList.add(`gender-${gender}`);
});

function loadSchedule(page) {
  window.location.href = page;
}