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


function openMap(location) {
  window.open('https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(location), '_blank');
}
function loadSchedule(page) {
  window.location.href = page;
}