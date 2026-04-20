<h1>Usuarios registrados</h1>
<ul id="lista"></ul>

<script>
fetch('{{ url("api/usuarios") }}')
    .then(res => res.json())
    .then(data => {
        const ul = document.getElementById('lista');
        data.forEach(u => {
            ul.innerHTML += `<li>${u.nombre} - ${u.email}</li>`;
        });
    })
    .catch(err => console.error(err));
</script>
