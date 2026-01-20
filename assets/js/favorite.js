document.addEventListener('click', async function (e) {
    const btn = e.target.closest('.btn-favorite');
    if (!btn) return;

    const movieId = btn.dataset.movieId;
    const isFavorite = btn.dataset.isFavorite === '1';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const url =  '/movies/movies/'+ movieId + (isFavorite ? '/unfavorite' : '/favorite');

    try {
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `csrf_token=${csrfToken}`
        });

        if (!res.ok) throw new Error('Request failed');

        //Rander html
        const data = await res.json();

        if (data.status === 'added') {
            btn.dataset.isFavorite = '1';
            btn.querySelector('.favorite-icon').textContent = '❤️';
        } else {
            btn.dataset.isFavorite = '0';
            btn.querySelector('.favorite-icon').textContent = '🤍';
        }

    } catch (err) {
        alert('Error, please try again');
    }
});
