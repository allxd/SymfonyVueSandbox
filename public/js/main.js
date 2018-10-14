
const books = document.getElementById('books');

if (books) {
  books.addEventListener('click', e => {
    if (e.target.className === 'btn btn-danger delete-book') {
      const id = e.target.getAttribute('data-id');
      fetch(`/book/delete/${id}`, {
        method: 'DELETE'
      }).then(res => window.location.reload());
    }
  });
}