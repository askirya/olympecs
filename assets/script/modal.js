document.querySelector('.btn__sign-in').addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector('.form-container').classList.add('visible');
});

document.querySelector('.form-container').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.remove('visible');
    }
});