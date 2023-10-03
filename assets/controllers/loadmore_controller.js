document.getElementById('load-more-btn').addEventListener('click', function () {
    const btn = this;
    const offset = parseInt(btn.getAttribute('data-offset'));
    const limit = 8; // Nombre d'éléments à charger à chaque fois

    fetch(`/loadmore/${offset * limit}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);

            // Sélectionnez l'élément parent auquel vous souhaitez ajouter le nouveau contenu
            let parentElement = document.getElementById('tricks');
            if (!parentElement) {
                console.error('Parent container not found');
                return;
            }

            data.data.forEach(trick => {
                let mainDiv = document.createElement('div');
                mainDiv.classList.add('trick', 'col');
                mainDiv.id = trick.id;

                let card = document.createElement('div');
                card.classList.add('card', 'p-2', 'mb-3');

                let link = document.createElement('a');
                link.href = '/trick/' + trick.slug;
                link.classList.add('nav-link');

                let img = document.createElement('img');
                img.src = '/uploads/' + trick.thumbnail;
                img.alt = 'Image of ' + trick.name;
                img.classList.add('card-img-top');

                link.appendChild(img);

                let cardBody = document.createElement('div');

                cardBody.classList.add('card-body');

                let innerDiv = document.createElement('div');
                innerDiv.classList.add('d-flex', 'justify-content-between', 'align-items-center');

                let titleLink = document.createElement('a');
                titleLink.href = '/trick/' + trick.slug;
                titleLink.classList.add('nav-link');

                let title = document.createElement('h4');
                title.classList.add('card-title', 'text-center', 'm-0');
                title.textContent = trick.name;

                titleLink.appendChild(title);
                innerDiv.appendChild(titleLink);
                cardBody.appendChild(innerDiv);

                let actionsList = document.createElement('ul');
                actionsList.classList.add('list-item', 'd-flex', 'justify-content-between', 'align-items-center');

                let editListItem = document.createElement('li');
                editListItem.classList.add('list-unstyled');

                let editLink = document.createElement('a');
                editLink.href = '/trick/' + trick.slug + '/edit';
                editLink.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-pencil" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"></path></svg>';
                editListItem.appendChild(editLink);

                let deleteListItem = document.createElement('li');
                deleteListItem.classList.add('list-unstyled');

                let deleteLink = document.createElement('a');
                deleteLink.href = '/trick/' + trick.slug;
                deleteLink.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"></path><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"></path></svg>';  // ... représente le reste du contenu SVG
                deleteListItem.appendChild(deleteLink);

                actionsList.appendChild(editListItem);
                actionsList.appendChild(deleteListItem);
                innerDiv.appendChild(actionsList);
                card.appendChild(link);
                card.appendChild(cardBody);
                mainDiv.appendChild(card);
                parentElement.appendChild(mainDiv);
            });

            // Mise à jour de l'offset pour la prochaine fois
            btn.setAttribute('data-offset', offset + 1);
        })
        .catch(error => console.error('Erreur lors du chargement des données :', error));
});
