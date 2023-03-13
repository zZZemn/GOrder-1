const totalInput = document.getElementById('total');
const paymentInput = document.getElementById('payment');
const changeInput = document.getElementById('change');

function calculateChange() {
    const payment = parseFloat(paymentInput.value) || 0;
    const total = parseFloat(totalInput.value) || 0;
    if (payment >= total)
    {
        const change = payment - total;
        changeInput.value = change.toFixed(2);
    }
    else
    {
        const change = 0.00;
        changeInput.value = change.toFixed(2);
    }
}

paymentInput.addEventListener('input', calculateChange);