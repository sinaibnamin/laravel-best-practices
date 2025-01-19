function filterMembers() {
    // Get the input value
    const input = document.getElementById('searchBox').value.toLowerCase();
    // Get all member elements
    const members = document.querySelectorAll('.members-wrapper .member');

    // Loop through members and filter
    members.forEach(member => {
        const name = member.querySelector('.name').textContent.toLowerCase();
        const uniqId = member.querySelector('.uniq_id').textContent.toLowerCase();
        const phone = member.querySelector('.phone').textContent.toLowerCase();

        if (name.includes(input) || uniqId.includes(input) || phone.includes(input)) {
            member.style.display = 'flex';
        } else {
            member.style.display = 'none';
        }
    });

    // If input is empty, show all members
    if (input === '') {
        members.forEach(member => {
            member.style.display = 'flex';
        });
    }
}


function clearSearch() {
    const searchBox = document.getElementById('searchBox');
    searchBox.value = '';
    filterMembers();
}