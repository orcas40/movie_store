document.addEventListener('DOMContentLoaded', function() {
    const searchButton = document.getElementById('searchButton');
    const searchTitle = document.getElementById('searchTitle');
    const searchYear = document.getElementById('searchYear');
    const searchAuthor = document.getElementById('searchAuthor');
    const categorySelect = document.getElementById('categorySelect');
    const movieList = document.getElementById('movieList');

    let isProcessing = false;


    function fetchMovies() {
        const title = searchTitle.value;
        const year = searchYear.value;
        const author = searchAuthor.value;
        const category = categorySelect.value;
        fetch(`searchMovies.php?title=${title}&year=${year}&author=${author}&category=${category}`)
            .then(response => response.json())
            .then(data => {
                movieList.innerHTML = '';
                data.forEach(movie => {
                    const movieItem = document.createElement('div');
                    movieItem.classList.add('movie-item');
                    movieItem.innerHTML = `
                        <h3>${movie.title}</h3>
                        <p>Año: ${movie.year}</p>
                        <p>Autor: ${movie.author}</p>
                        <p>Categoría: ${movie.category}</p>
                        <p>
                            <button data-id="${movie.id}" class="buyButton" style="display:${movie.purchase==="sin_comprar" ? "show" : 'none'};" >Comprar</button>
                            <h3 class="text-green" style="display:${movie.purchase==="sin_comprar" ? "none" : 'show'};">${movie.purchase}</h3>
                        </p>
                    `;
                    movieList.appendChild(movieItem);
                });

                document.querySelectorAll('.buyButton').forEach(button => {
                    button.addEventListener('click', function() {
                        const movieId = this.getAttribute('data-id');
                        openPaymentPopup(movieId);
                    });
                });
            });
    }

    function openPaymentPopup(movieId) {
        paymentPopup.style.display = 'block';
        paymentForm.setAttribute('data-movie-id', movieId);
    }

    closePopup.addEventListener('click', function() {
        paymentPopup.style.display = 'none';
    });

    paymentForm.addEventListener('submit', function(event) {
        event.preventDefault();
        if (isProcessing) return;
        isProcessing = true;

        const movieId = this.getAttribute('data-movie-id');
        const cardNumber = document.getElementById('cardNumber').value;
        const cardHolder = document.getElementById('cardHolder').value;
        const cvv = document.getElementById('cvv').value;
        const expiryDate = document.getElementById('expiryDate').value;

        paymentPopup.style.display = 'none';

        fetch(`buyMovies.php?movieId=${movieId}`)
            .then(data => {
                location.reload();
            });


    });


    searchButton.addEventListener('click', fetchMovies);
    categorySelect.addEventListener('change', fetchMovies);

    fetchMovies();
});
