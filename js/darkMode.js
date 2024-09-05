const toggleSwitch = document.getElementById('modeSwitch');

toggleSwitch.addEventListener('change', () => {
    document.body.classList.toggle('dark-mode');
});