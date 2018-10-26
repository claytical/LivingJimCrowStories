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
	$.getJSON( "http://livingjimcrow.app//get/item/" + item_id, function( data ) {
		jd = data;
		});

//	var new_item = $("#vault_content").prepend(html);

}

function unlock_random(category_id) {

}

function scene(scene_id) {

}

function scene_by_category(category_id) {

}
