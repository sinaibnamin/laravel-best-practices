<script>
    const validityInput = document.querySelector('input[name="validity"]');
    const memberInputField = document.querySelector('select[name="member_id"]');

    function handleMemberChange() {
        const memberId = memberInputField.value;
        const memberHistoryDiv = document.querySelector('.member-history-wrapper');

        memberHistoryDiv.innerHTML = `<div class="member-history"><p class="text-bold">Please wait....</p></div>`

        if (memberId) {
            const url = `{{ url('/admin_panel/payment/ajax_member_history/${memberId}') }}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(data => {
                    memberHistoryDiv.innerHTML = data;
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    memberHistoryDiv.innerHTML = `<div class="member-history"><p class="text-bold text-danger">something went wrong!</p><p class="text-bold text-danger">${error}</p></div>
                    
                    `;
                });
        } else {
            memberHistoryDiv.innerHTML = '';
        }
    }


    // document.addEventListener("DOMContentLoaded", function() {
    //     const editMode = '{{ $edit_mode ?? '' }}';
    //     if ( editMode == true) {
    //         handleMemberChange()
    //     }
    // });



    function handlePackageChange(selectElement) {


        const selectedOption = selectElement.options[selectElement.selectedIndex];

        // Retrieve package price and discount from data attributes as integers
        const packagePrice = parseInt(selectedOption.getAttribute('data-price'), 10) || 0;
        const discount = parseInt(selectedOption.getAttribute('data-discount'), 10) || 0;

        // Set the values for Package Price and Discount inputs
        document.querySelector('input[name="package_price"]').value = packagePrice;
        document.querySelector('input[name="discount"]').value = discount;

        // Calculate and set the Paid amount based on discount
        const paidAmount = discount > 0 ? (packagePrice - discount) : packagePrice;
        document.querySelector('input[name="paid"]').value = paidAmount;

        // reset due input 
        const dueInput = document.querySelector('input[name="due"]');
        const dueLabel = document.querySelector('.due-label');
        dueInput.value = 0;
        dueInput.classList.remove('text-danger');
        dueLabel.classList.remove('text-danger');

        // Trigger recalculation for due amount
        calculateDueAmount();

        // validity disable  handler 
        validityDisableCheck()
    }

    // Calculate due amount when package details change
    function calculateDueAmount() {
        const packagePrice = parseInt(document.querySelector('input[name="package_price"]').value, 10) || 0;

        if (packagePrice == 0) {
            return
        }

        const paidAmount = parseInt(document.querySelector('input[name="paid"]').value, 10) || 0;
        const discount = parseInt(document.querySelector('input[name="discount"]').value, 10) || 0;

        // Calculate due as integers only
        const dueAmount = packagePrice - (paidAmount + discount);

        // Select the Due input field and its label
        const dueInput = document.querySelector('input[name="due"]');
        const dueLabel = document.querySelector('.due-label');

        // Update the Due input field value
        dueInput.value = dueAmount;

        // Add or remove "text-danger" class based on due amount
        if (dueAmount != 0) {
            dueInput.classList.add('text-danger');
            dueLabel.classList.add('text-danger');
        } else {
            dueInput.classList.remove('text-danger');
            dueLabel.classList.remove('text-danger');
        }
    }

    function validityDisableCheck() {

        const package_selection_input = document.querySelector('select[name="package_id"]');
        const package_selection_input_option = package_selection_input.options[package_selection_input.selectedIndex];
        const duration = parseInt(package_selection_input_option.getAttribute('data-duration'), 10) || 0;


        if (duration < 1) {
            validityInput.setAttribute("readonly", true);
            validityInput.value = '';
            validityInput.required = false;
        } else {
            validityInput.removeAttribute("readonly");
            validityInput.required = true;

            validityInput.value = getMemberValidity();
            if (getMemberValidity()) {
                const mvd = new Date(getMemberValidity());
                mvd.setDate(mvd.getDate() + duration);
                validityInput.value = mvd.toLocaleDateString('en-CA'); 
            } else {
                const today = new Date();
                today.setDate(today.getDate() + duration);
                validityInput.value = today.toLocaleDateString('en-CA'); 
            }


        }
    }

    function getMemberValidity() {

        const memberInputFieldOption = memberInputField.options[memberInputField.selectedIndex];
        const memberValidity = memberInputFieldOption.getAttribute('data-validity');

        if (!memberValidity) {
            return ''
        }



        const today = new Date();
        const memberValidityDate = new Date(memberValidity);

        // Reset both dates to midnight to ignore time comparison
        today.setHours(0, 0, 0, 0);
        memberValidityDate.setHours(0, 0, 0, 0);

        if (today > memberValidityDate) {
            // expired
            return ''
        }

        return memberValidityDate.toLocaleDateString('en-CA');
    }



    // Add event listeners for Paid and Discount fields to update due on input change
    document.querySelector('input[name="paid"]').addEventListener('input', calculateDueAmount);
    document.querySelector('input[name="discount"]').addEventListener('input', calculateDueAmount);
</script>
