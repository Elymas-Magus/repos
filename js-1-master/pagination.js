let currentPage = 1;
const ITEMS_PER_PAGE = 6;

const paginateData = (data) => {
    return data.reduce((total, current, index) => {
      const belongArrayIndex = Math.ceil((index + 1) / ITEMS_PER_PAGE) - 1;
      total[belongArrayIndex] ? total[belongArrayIndex].push(current) : total.push([current]);
      return total;
    }, []);
}

// função de mudar de página
const changePage = (pageToBeOpened, paginatedData) => {
	currentPage = pageToBeOpened;
	openPage(pageToBeOpened, paginatedData);
}

const openPage = (pageToBeOpened, paginatedData) => {
	cardContainer = document.getElementById("cards");

	while (cardContainer.firstChild) {
		cardContainer.removeChild(cardContainer.firstChild);
	}

	renderPaginationMenu(paginatedData);

	paginatedData[pageToBeOpened - 1].forEach(property => {
		const { name, photo, price, property_type } = property;

		cardContainer.innerHTML += `
		<div class="media">
			<a href="${photo}"><img src="${photo}" class="align-self-center mr-3" id="photo"></a>
			<div class="media-body conteudo">
				<div class="media-title">
					<a href=""><h5 class="mt-0 conteudo"><b>${name}</b></h5></a>
					<p>${property_type}</p>
				</div>
				<p class="mb-0 price"><b>R$${price},00/noite</b></p>
			</div>
		</div
		>
		`;
	});
}

// função de mudar de página
const renderPaginationMenu = (paginatedData) => {

	paginationContainer = document.querySelector(".pagination");
	//colocamos nossa div container dos cards em uma variável

	while (paginationContainer.firstChild) {
			paginationContainer.removeChild(paginationContainer.firstChild)
	}
	//esvaziamos essa div a cada render para que não seja rendedrizado o menu com os dados da página antiga do usuário
	
	const previousPage = document.createElement('span')
	previousPage.className = 'page-changer'
	previousPage.innerHTML = '<'
	previousPage.addEventListener('click', () => currentPage <= 1 ? () => {} : changePage(currentPage - 1, paginatedData))
	paginationContainer.appendChild(previousPage)
	//geramos um botão que ao ser clicado atualiza chama o método de mudar de página passando a página anterior se a página
	//atual não for 1

	paginatedData.forEach((_, index) => {
			//para cada array (página) dentro do nosso array total criaremos um botão numerado para ir para aquela página
			const pageButton = document.createElement('span')
			pageButton.innerHTML = index + 1 //index + 1 porque os indices começam em 0 e queremos mostrar a primeira página como 1

			pageButton.addEventListener('click', () => changePage(index + 1, paginatedData))

			if (currentPage === index + 1) {
					pageButton.className = 'active'
			}

			paginationContainer.appendChild(pageButton)
	})

	const nextPage = document.createElement('span')
	nextPage.className = 'page-changer'
	nextPage.innerHTML = '>'
	nextPage.addEventListener('click', () => currentPage >= paginatedData.length ? () => { } : changePage(currentPage + 1, paginatedData))

	paginationContainer.appendChild(nextPage)

	//por fim, método de avançãr a página que funciona igual o de voltar a página só que ao contrário :)
}