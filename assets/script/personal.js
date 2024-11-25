function toggleEditMode(sectionId) {
    let section = document.getElementById(sectionId);
    let isEditMode = section.classList.contains('edit-mode');
    section.classList.toggle('edit-mode', !isEditMode);
    section.classList.toggle('view-mode', isEditMode);

    let flexToggles = section.querySelectorAll('.flex-toggle');
    if (flexToggles.length > 0) {
        flexToggles.forEach(flexToggle => {
            if (section.classList.contains('view-mode')) {
                flexToggle.classList.add('active');
            } else {
                flexToggle.classList.remove('active');
            }
        });
    }

    let editButton = section.querySelector(`#edit-${sectionId}`);
    let saveButton = section.querySelector(`#save-${sectionId}`);

    if (editButton) {
        editButton.style.display = isEditMode ? 'inline-block' : 'none';
    }
    if (saveButton) {
        saveButton.style.display = isEditMode ? 'none' : 'inline-block';
    }

    if (!isEditMode) {
        let inputs = section.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', () => checkInputs(sectionId));
        });
        checkInputs(sectionId);
    }

    if (sectionId === 'personal-data') {
        let emailBlock = document.getElementById('contact-email');
        if (section.classList.contains('view-mode')) {
            let accountCenter = document.querySelector('.account-center');
            accountCenter.appendChild(emailBlock);
        } else {
            let accountRight = document.querySelector('.account-right');
            accountRight.appendChild(emailBlock);
        }
    }
}

function checkInputs(sectionId) {
    let section = document.getElementById(sectionId);
    let inputs = section.querySelectorAll('input');
    let allFilled = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            allFilled = false;
        }
    });

    let saveButton = section.querySelector(`#save-${sectionId}`);
    if (saveButton) {
        saveButton.disabled = !allFilled;
    }
}

function saveChanges(sectionId) {
    let data = {};
    let inputs = document.querySelectorAll(`#${sectionId} input`);
    inputs.forEach(input => {
        data[input.id] = input.value;
    });

    $.ajax({
        url: './public/update_profile.php',
        type: 'POST',
        data: data,
        success: function (response) {
            let result = JSON.parse(response);
            if (result.status === 'success') {
                inputs.forEach(input => {
                    let display = document.getElementById(`display-${input.id}`);
                    display.innerText = input.value;
                });
                toggleEditMode(sectionId);
                alert('Данные успешно обновлены');
            } else {
                alert(result.message || 'Ошибка при сохранении данных');
            }
        },
        error: function () {
            alert('Ошибка запроса');
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    let sections = document.querySelectorAll('.profile-field');
    sections.forEach(section => {
        let sectionId = section.id;
        let isEditMode = section.classList.contains('edit-mode');
        let editButton = section.querySelector(`#edit-${sectionId}`);
        let saveButton = section.querySelector(`#save-${sectionId}`);

        if (editButton) {
            editButton.style.display = isEditMode ? 'none' : 'inline-block';
        }
        if (saveButton) {
            saveButton.style.display = isEditMode ? 'inline-block' : 'none';
        }

        let flexToggles = section.querySelectorAll('.flex-toggle');
        if (flexToggles.length > 0) {
            flexToggles.forEach(flexToggle => {
                if (section.classList.contains('view-mode')) {
                    flexToggle.classList.add('active');
                } else {
                    flexToggle.classList.remove('active');
                }
            });
        }

        if (isEditMode) {
            let inputs = section.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', () => checkInputs(sectionId));
            });
            checkInputs(sectionId);
        }
    });

    let personalDataSection = document.getElementById('personal-data');
    let emailBlock = document.getElementById('contact-email');
    if (personalDataSection.classList.contains('view-mode')) {
        let accountCenter = document.querySelector('.account-center');
        accountCenter.appendChild(emailBlock);
    } else {
        let accountRight = document.querySelector('.account-right');
        accountRight.appendChild(emailBlock);
    }
});