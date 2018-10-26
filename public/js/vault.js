
function unlock(item_id) {
	//call to API
	$.getJSON( "https://livingjimcrow.app/get/item/" + item_id, function( data ) {
		format_and_add_item(data);
		});
	vault.open();
}

function unlock_random(category_id) {
	$.getJSON( "https://livingjimcrow.app/get/random/item/" + item_id, function( data ) {
		format_and_add_item(data);
		});
	vault.open();
}

function format_and_add_item(data) {
		var html =  "<div class='row'>";
		html += "<div class='col-sm-12'>";
		html += "<h3>" + data.item.title + "</h3>";
		html += "</div>";
		html += "<div class='col-sm-10'><p>" + data.item.description + "</p></div>";
		html += "<div class='col-sm-2'><a class='btn btn-info btn-block btn-lg' href='" + data.item.url + "'><i class='fas fa-eye'></i></a></div>";
		html += "</div>";
		$("#vault_content").prepend(html);
}

function format_scene(data) {
	var html =  "<img class='img-fluid' src='" + data.scene + "''/>";
	$("#scene").html(html);
}

function scene(scene_id) {
	$.getJSON( "https://livingjimcrow.app/get/scene/" + scene_id, function( data ) {
		format_scene(data);
		});
}

function scene_by_category(category_id) {
	$.getJSON( "https://livingjimcrow.app/get/scene/category/" + category_id, function( data ) {
		format_scene(data);
		});
}
