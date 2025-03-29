document.querySelector('[name="anonima"]').addEventListener('change', function() {
    document.getElementById('datos-personales').style.display =
        this.checked ? 'none' : 'block';
});