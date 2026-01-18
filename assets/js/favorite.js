document.addEventListener('click', async function (e) {
    const btn = e.target.closest('.btn-favorite');
    if (!btn) return;

    const movieId = btn.dataset.movieId;
    const isFavorite = btn.dataset.isFavorite === '1';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const url = isFavorite ? '/movies/unfavorite.php' : '/movies/favorite.php';

    try {
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                movie_id: movieId,
                csrf_token: csrfToken
            })
        });

        if (!res.ok) throw new Error('Request failed');

        //Rander html
        btn.dataset.isFavorite = isFavorite ? '0' : '1';

        btn.querySelector('.favorite-icon').textContent =
            isFavorite ? '🤍' : '❤️';

    } catch (err) {
        alert('Error, please try again');
    }
});
