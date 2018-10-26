var vaultOpen = false;

function openVault() {
	vault.open();
	vaultOpen = true;
	$("#story-container").addClass("pure-g");
	$("#story").removeClass("pure-u-3-3");
	$("#story").addClass("pure-u-2-3");
	$("#vault").show();
}

function closeVault() {
	vaultOpen = false;

	$("#story-container").removeClass("pure-g");
	$("#story").removeClass("pure-u-2-3");
	$("#story").addClass("pure-u-3-3");
	$("#vault").hide();


}

function toggleVault() {
	if(vaultOpen) {
		closeVault();
	}
	else {
		openVault();
	}
}
var jd;
function unlock(item_id) {
	//call to API
	$.getJSON( "https://livingjimcrow.app/get/item/" + item_id, function( data ) {
		format_and_add_item(data);
		});

}

function unlock_random(category_id) {
	$.getJSON( "https://livingjimcrow.app/get/random/item/" + item_id, function( data ) {
		format_and_add_item(data);
		});

}

function format_and_add_item(data) {
		var html =  "<div class='row'>";
		html += "<div class='col-sm-12'>";
		html += "<h3>" + data.item.title + "</h3>";
		html += "</div>";
		html += "<div class='col-sm-6'><p>" + data.item.description + "</p></div>";
		html += "<div class='col-sm-6'><a class='btn btn-info btn-block btn-lg' href='" + data.item.url + "'><i class='fas fa-eye'></i>/a></div>";
		html += "</div>";
		$("#vault_content").prepend(html);
}


function scene(scene_id) {

}

function scene_by_category(category_id) {

}
