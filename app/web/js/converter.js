const inputs = document.querySelectorAll(".xxx-input-converter__input");
inputs.forEach(input => {
    input.addEventListener("input", validateInput);
    input.addEventListener("input", calculateCurrencies);
})

const inputss = document.querySelectorAll(".xxx-input-converter__close");
inputss.forEach(input => {
    input.addEventListener("click", clearAllInputs);
})

async function calculateCurrencies(event) {
    const formData = new FormData();
    formData.append('value', event.target.value);
    formData.append('currencyCode', event.target.dataset.curName);
    formData.append('_csrf', event.target.dataset.csrf);

    const response = await fetch("/index.php?r=converter%2Fcalculate", {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        },
        method: 'POST',
        body: formData

    });

    const json = await response.json();
    if (json.success) {
        let courses  = json.response;
        courses.forEach(course => {
            let input = document.querySelector(`input[data-cur-name="${course.currencyCode}"]`);
            input.value = course.value
        })
    }
}

function validateInput(event) {
    event.target.value = event.target.value.replace(/[^0-9+]/g, ''); 
}

function clearAllInputs(event) {
    if (event.currentTarget.classList.contains('xxx-input-converter__close')) {
        inputs.forEach(input => {
            input.value = 0;
        })
    }
}
