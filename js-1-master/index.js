const API_URL = "https://api.sheety.co/30b6e400-9023-4a15-8e6c-16aa4e3b1e72";

let api_data = [];

let order = "";

const fetchAPI = async (url) => {
	let response = await fetch(url)
	const textResponse = await response.text()
	return JSON.parse(textResponse)
}

// const changeOrder = (new_order) => {
// 	order = new_order;
// 	changePage (1);
// }

// function check_order (apiData)
// {
//     if (typeof order === 'boolean')
        

//     return apiData;
// }

const renderPage = async () => {
	const apiData = api_data;

    console.log(apiData);

	const paginatedData = paginateData(apiData);

	openPage(currentPage, paginatedData);
}

const format_string = (string) => {
	return string.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "");
}

const sorting_api = (reverse) => {
	sort(api_data, (a, b) => a.price - b.price, reverse);
	renderPage();
}

window.addEventListener("load", () => {
	(async () => {
		api_data = await fetchAPI(API_URL);
		renderPage();
	})();
	
    document.getElementById("menorPreco").addEventListener("click", () => {
        sorting_api (false);
    });

    document.getElementById("maiorPreco").addEventListener("click", () => {
        sorting_api (true);
	});
	
	document.getElementById("tipo_estadia").addEventListener("change", async () => {
		api_data = await fetchAPI(API_URL);
		type = document.getElementById("tipo_estadia").value;

		if (type)
			api_data = api_data.filter((current) => format_string(current.property_type) == format_string(type));		

		renderPage();
	});
});