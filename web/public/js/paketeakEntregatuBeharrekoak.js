function updatePackageStatus(packageId) {
    var checkbox = event.target;
    if (checkbox.checked) {
        showConfirmation(packageId);
    }
}

function showConfirmation(packageId) {
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('confirmation-box').style.display = 'block';
    document.getElementById('delivery-package-id').value = packageId;
    document.getElementById('package-id').innerText = 'Paketea ' + packageId;
}

function cancelDelivery() {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('confirmation-box').style.display = 'none';
}

function confirmDelivery() {
    document.getElementById('confirmation-form').submit();
}

function toggleIncidentForm(packageId) {
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('incident-form').style.display = 'block';
    document.getElementById('package_id').value = packageId;
}