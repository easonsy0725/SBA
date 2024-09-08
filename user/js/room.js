//                     _____
//                    |     |
//                    |     |
//                    |     |
//    ________________|     |________________
//   |                                       |
//   |________________       ________________|
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |______|

//                耶穌保佑† 唔好有BUG!!!


const genderBoxes = document.querySelectorAll('.student-box, .teacher-box');

genderBoxes.forEach(box => {
    const gender = box.getAttribute('data-gender');
    box.classList.add(`gender-${gender}`);
});