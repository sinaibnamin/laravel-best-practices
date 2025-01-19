document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.members-wrapper').addEventListener('click', function (event) {
        const memberElement = event.target.closest('.member');

        if (memberElement) {
            memberElement.classList.add('loading')
            const memberId = memberElement.getAttribute('data-member-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const attendanceDate = document.querySelector('.attendance-date').getAttribute('data-value');

            let action = 'present';
            if (memberElement.classList.contains('present')) {
                action = 'absent';
            }

            fetch('/admin_panel/member_attendance/input', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    member_id: memberId,
                    attendance_date: attendanceDate,
                    action: action,
                }),
            })
                .then(response => response.json())
                .then(data => {
                    // Check the action and update member attendance status
                    change_attendance_status(memberElement, data.action)
                    memberElement.classList.remove('loading')
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    });
});

function change_attendance_status(memberElement, action) {
    if (action == 'present') {
        memberElement.classList.add('present');
        memberElement.querySelector('.status').textContent = 'Present'
    } else if (action == 'absent') {
        memberElement.classList.remove('present');
        memberElement.querySelector('.status').textContent = 'Absent'
    }
}