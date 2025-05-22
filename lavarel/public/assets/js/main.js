window.addEventListener('DOMContentLoaded', () => {
    fetch('components/header.html')
      .then(res => res.text())
      .then(data => document.getElementById('header-placeholder').innerHTML = data);
  
    fetch('components/footer.html')
      .then(res => res.text())
      .then(data => document.getElementById('footer-placeholder').innerHTML = data);
  });

  fetch('http://127.0.0.1:8000/api/menus')
    .then(response => response.json())
    .then(data => {
        let container = document.getElementById('menu-container');
        data.forEach(menu => {
            container.innerHTML += `
                <div>
                    <h3>${menu.name}</h3>
                    <p>${menu.description}</p>
                    <strong>${menu.price} zł</strong>
                </div>
            `;
        });
    }); 