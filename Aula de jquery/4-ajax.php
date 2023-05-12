<?php

if (isset($_POST["ajax_exclui_item"])) {


	exit(json_encode([
		"success" => true
	]));

}

?>

<script>

$(".excluir_item").click(function(){

	let that = $(this);

	let item = $(this).data("item-id");

	$.ajax({
	    async: false,
	    url: window.location,
	    type: "post",
	    data: {
	    	ajax_exclui_item: true,
	    	item: item
	    },
	    dataType: "json",
	    beforeSend: function() {

	    	$(that).text("Aguarde...");

	    },
	    success: function(jsonResposta) {

	    	if (jsonResposta.success) {

	    		$(that).closest("tr").remove();

	    	} else {

	    		alert("errror");

	    	}

	    }
	});

	//

});


</script>