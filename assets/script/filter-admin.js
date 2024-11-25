function filterUsers() {
    let input = document.getElementById('search-input').value.toLowerCase();
    let userItems = document.getElementsByClassName('user-item');

    for (let i = 0; i < userItems.length; i++) {
        let email = userItems[i].getElementsByTagName('p')[0].innerText.toLowerCase();
        if (email.includes(input)) {
            userItems[i].style.display = "";
        } else {
            userItems[i].style.display = "none";
        }
    }
}