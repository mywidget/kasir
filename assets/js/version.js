var version = document.getElementById('version-ruangadmin');

function readTextFile(file, callback) {
    var rawFile = new XMLHttpRequest();
    rawFile.overrideMimeType("application/json");
    rawFile.open("GET", file, true);
    rawFile.onreadystatechange = function() {
        if (rawFile.readyState === 4 && rawFile.status == "200") {
            callback(rawFile.responseText);
		}
	}
    rawFile.send(null);
}

// console.log('Initially ' + (window.navigator.onLine ? 'on' : 'off') + 'line');

// window.addEventListener('online', () => console.log('Became online'));
// window.addEventListener('offline', () => console.log('Became offline'));
if(vupdate!=0){
loadnotif();
window.addEventListener('online', () => loadnotif());
window.addEventListener('offline', () => loadnotif());
if(navigator.onLine){
	readTextFile("https://mywidget.github.io/version.json", function(text){
		var data = JSON.parse(text);
		var name = data['aplikasi'][0]['product'];
		var versi = data['aplikasi'][0]['version'];
		version.innerHTML = name + " Version " +versi;
		// localStorage.setItem("versi", versi); 
	});
	} else {
	readTextFile(base_url+"version.json", function(text){
		var data = JSON.parse(text);
		var name = data['aplikasi'][0]['product'];
		var versi = data['aplikasi'][0]['version'];
		version.innerHTML = name + " Version " +versi;
	});
}
}else{
	readTextFile(base_url+"version.json", function(text){
		var data = JSON.parse(text);
		var name = data['aplikasi'][0]['product'];
		var versi = data['aplikasi'][0]['version'];
		version.innerHTML = name + " Version " +versi;
	});
}

function loadnotif(){
	console.log(navigator.onLine);
	if(navigator.onLine==true){
	var urlcek = base_url+"update/cek_notif";
	$('.cek, .download, .update').removeAttr('disabled')
	}else{
	var urlcek = base_url+"update/cek_offline";
	$('.cek, .download, .update').attr('disabled','disabled')
	}
	$.ajax({
		type: 'POST',
		url:  urlcek,
		data:{tipe:'cek_notif'},
		cache: false,
		success: function (data) {
            $('.load-notif').html(data);
		}
	});
	
}