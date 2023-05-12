

//retorna valor do input
const valor = $("input, select").val();

//retorna o texto dentro do elemento
const texto = $("h1").text();

//retorna todo conteudo html do elemento
const html = $("div").html();

//esconde o elemento
$("div").hide("fast");

//mostra o elemento
$("div").show();

//alterna entre hidden e visible
$("div").toggle();

//remove o elemento da tela
$("select > option").remove();

//inserir um novo elemento no final do elemento pai

let option = $("<option></option>", {
	value: "1234",
	text: "FURADEIRA",
	selected: false
})

$("select").append(option); 
//ou
$("select").append(`<option value="1234" selected>FURADEIRA<option>`);

//inserir um novo elemento no começo do elemento pai
$("select").prepend(option);

//inserir um novo elemento após outro elemento
$("select").insertAfter(`<div></div>`);

//inserir um novo elemento antes de outro elemento
$("input").insertBefore(`<span class="obrigatorio">*</div>`);

//retorna o elemento irmao anterior
$("input").prev(".asterisco");

//retorna o proximo elemento irmao
$("input").next(".lupa");

//retorna todos os irmaos anteriores
$("input").prevAll();

//retorna todos os proximos irmaos
$("input").nextAll();

//retorna a div pai (no caso a TR)
$("td").parent();

//retorna todas as divs pais
$("td").parents();

//retorna a div mais proxima (MÉTODO IMPORTANTISSIMO)
$("td").closest("tr");

//procura um elemento filho dentro de outro elemento
$("div").find("#referencia_produto");

//altera uma pseudo propriedade (selected, checked etc)
$("option[fora_garantia=t]").prop("selected", true);

//executa uma ação para cada elemento
$("select#tipo_atendimento > option").each(function(){

	//verifica o estado do option
	$(this).is(":selected");

});

//pode ser usado também para percorrer um objeto ou array
$.each(objeto_cidades, function(key, val) {

});

//adiciona um filtro personalizado
$("option").filter(function() {

	return $(this).text() != "";

})