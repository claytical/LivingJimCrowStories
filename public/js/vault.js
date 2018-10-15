var vaultOpen = false;

function openVault() {
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

function unlock(item) {
	console.log("Unlocking " + item);
	$('.item .new-item').removeClass('.new-item');
	var html = "<div class='item'><h3>";
	switch(item) {
		case "nih1":
			html +="Racial/Ethnic Differences in Physician Distrust in the United States"
			html += "<span class='new-label'>Unlocked!</span></h3><p>";
			html +="Publication from a study funded by the National Institutes of Health</p>";
			html +="<a class='pure-button' href='https://www.ncbi.nlm.nih.gov/pmc/articles/PMC1913079/' data-featherlight='iframe' data-featherlight-iframe-allowfullscreen>View</a>";
			break;
		case "nejm1":
/*			html +="Racial Differences in the Use of Cardiac Catheterization after Acute Myocardial Infarction"
			html += "<span class='new-label'>Unlocked!</span></h3><p>";
			html +="Several studies have reported that black patients are less likely than white patients to undergo cardiac catheterization after acute myocardial Infarction</p>";
			html +="<a href='http://www.nejm.org/doi/full/10.1056/NEJM200105103441906' data-featherlight='iframe' data-featherlight-iframe-allowfullscreen>View</a>";
*/
			html +="Coquetting with Beckly"
			html += "<span class='new-label'>Unlocked!</span></h3><p>";
			html +="Nimick Again Tempting the First Baseman to Abandon Players</p>";
			html +="<a class='pure-button' href='vault/articles/union.pdf'>View</a>";

			break;
		case "newyorker1":
			html +="What Does It Mean To Die?"
			html += "<span class='new-label'>Unlocked!</span></h3><p>";
			html +="Jahi McMath, a Black 13 year old who went to the doctors for a tonsilectomy ended up braindead after doctors ignored her health histories and pushed her out of the hospital early</p>";
			html +="<a class='pure-button' href='https://www.newyorker.com/magazine/2018/02/05/what-does-it-mean-to-die' data-featherlight='iframe' data-featherlight-iframe-allowfullscreen>View</a>";
			break;
		case "michigantoday":
/*			html +="The Protest Psychosis"
			html += "<span class='new-label'>Unlocked!</span></h3><p>";
			html +="How Schizophrenia Became a Black Disease</p>";
			html +="<a href='http://michigantoday.umich.edu/a7776/'>View</a>";
*/
			html +="Assaultive and belligerent?"
			html += "<span class='new-label'>Unlocked!</span></h3><p>";
			html +="How Schizophrenia Became a Black Disease</p>";
			html +="<a class='pure-button' href='https://thesocietypages.org/socimages/files/2011/05/1.png'>View</a>";
			break;
		case "finished_injury":
			html +="Injury Story Complete"
			html += "<span class='new-label'>New!</span></h3><p>";
			html +="You played through the story <em>An Injury</em>";
			break;
		default:
			console.log(item + " not found");

	}
	html += "</p></div>";
	var new_item = $(".vault-content").prepend(html);
	if(!vaultOpen) {
		openVault();
	}
	$(".vault-content a").featherlight();
	$(".item .new-label").fadeIn(500).delay(3000).fadeOut(3000);
}