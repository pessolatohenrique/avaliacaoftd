/**
 * aplica a máscara nos campos selecionados
 * função chamada no carregando e adições dinâmicas
 */
function maskField()
{
	$(".initial_date").mask("00/00/0000");
	$(".final_date").mask('00/00/0000');
}

$(document).ready(function($) {
	maskField();

	$(document).on("click", ".add-line", function(event){
		event.preventDefault();
		var target = "#" + $(this).data("target");
		var linha = $(this).parent().parent();
		var nova_linha = linha.clone().appendTo(target);
		maskField();
	});

	$(document).on("click", ".remove-line", function(event) {
		event.preventDefault();
		var linha = $(this).parent().parent();
		var total_linhas = $("#tabela-departamento").find("tbody > tr").length;
		if (total_linhas > 1) {
			linha.remove();
		}
	});

	$(document).on("change", ".actual_job", function(event) {
		var is_checked = $(this).is(':checked');
		var linha = $(this).parent().parent();
		var final_date = linha.find(".final_date");
		final_date.attr("readonly", false);
		final_date.val("");
		if (is_checked) {
			final_date.attr("readonly", true);
			final_date.val("01/01/9999");
		}
	});


});